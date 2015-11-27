<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Resources Controller
 *
 * @property App\Model\Table\ResourcesTable $Resources
 */
class ResourcesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        //$this->Auth->allow(['buypackage','primarycontact','checkout','payment']);
        $this->layout = 'admin';
        $this->set('country_list',$this->country_list);
        $this->loadModel('Folders');
        $this->loadComponent('Opencloud');
    }
    public function isAuthorized($user) {
        // Admin can access every action
        if(isset($user['status']) && $user['status'] === 'S') {
            $this->Flash->error(__('Your account is suspended, please contact Customer Support'));
            return $this->redirect(['controller' => 'Users','action' => 'vendorSuspended']);
        }elseif(isset($user['status']) && $user['status'] === 'B') {
            $this->Flash->error(__('Your account is blocked, please contact Customer Support'));
            return $this->redirect(['controller' => 'Users','action' => 'vendorBlocked']);
         }elseif(isset($user['status']) && $user['status'] === 'D') {
            $this->Flash->error(__('Your account is inactive, please contact Customer Support'));
            return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);
            
         }elseif(isset($user['status']) && $user['status'] === 'P') {
           $this->Flash->error(__('Your account is inactive, please contact Customer Support'));
           return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);
            
        }elseif (isset($user['role']) && $user['role'] === 'admin' || $user['role'] === 'superadmin') {
            return true;
        }

        // Default deny
        return false;
    }
/**
 * Index method
 *
 * @return void
 */
	public function index() {
		$this->navigate();
	}

/**
 * navigate method
 *
 * @return void
 */
    public function navigate($folderid=1) {
        //->contain(['Folders', 'Users', 'Vendors'])
        $resources = $this->paginate($this->Resources->find()->contain(['Vendors'])->where(['folder_id'=>$folderid]));
        $parentfolder = $this->Folders->get($folderid);
        $folders = $this->Folders
                    ->find('all')
                    ->where(['parent_id'=>$folderid,'status'=>'Y'])
                    ->order($this->request->params['paging']['Resources']['sort']?[str_replace('Resources.','',$this->request->params['paging']['Resources']['sort'])=>$this->request->params['paging']['Resources']['direction']]:['name'=>'asc']);

        $this->set(compact('resources','folders','parentfolder'));
    }

/**
 * search method
 *
 * @return void
 */
    public function search() {
        $keyword = $this->request->data['keyword'];
        $keys = explode(' ', $keyword);
        $conds = Array();
        $conds[] = ['name LIKE'=>'%'.$keyword.'%'];
        foreach($keys as $key)
        {
            $conds[] = ['name LIKE'=>'%'.$key.'%'];
        }
        $resources = $this->paginate($this->Resources->find()->contain(['Vendors'])->where( [ 'OR' => $conds ] ));
 
        $this->set(compact('resources','keyword'));
    }

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$resource = $this->Resources->get($id, [
			'contain' => ['Folders', 'Users', 'Vendors']
		]);
		$this->set('resource', $resource);
	}

/**
 * Add method
 *
 * @return void
 */
    public function add($parent_id = 0) {
        
        /*
         * Section to find folder path and to upload the file.....
         */
        
        $upload_error   =   false;
        if ($this->request->is('post')) {
            if (!empty($this->request->data['sourcepath']['tmp_name']) && $this->request->data['sourcepath']['error'] == 0 && in_array($this->request->data['sourcepath']['type'],$this->allowed_resource_file_types)) {

                // Insert data prior to uploading to get ID for filename
                $resource = $this->Resources->newEntity($this->request->data);
                if ($this->Resources->save($resource))
                {
                    $id = $resource->id;
                    $file_ext = substr(strrchr($this->request->data['sourcepath']['name'],'.'),1);
                    $file_name = $id . '.' . $file_ext;
                }
                else
                    $file_name =  $this->request->data['sourcepath']['name'];
                // end insert

                $folder = $this->Folders->get($this->request->data['folder_id']);
                $srcfile =  ($folder->folderpath ? $folder->folderpath . '/' : '') . $file_name;
                if($this->Opencloud->addObject($srcfile,$this->request->data['sourcepath']['tmp_name']))
                {
                    $this->request->data['type'] = $this->request->data['sourcepath']['type']; //$object->getContentType();
                    $this->request->data['size'] = $this->request->data['sourcepath']['size']; //$object->getContentLength();
                    $this->request->data['sourcepath'] = $srcfile; //$object->getName();
                    $this->request->data['publicurl'] = $this->Opencloud->getobjecturl($srcfile);
                }
                else{
                    unset($this->request->data['sourcepath']);
                    $upload_error   =   true;
                }
            }else{
                unset($this->request->data['sourcepath']);
            }
        }

        if ($this->request->is('post')) {
               if(true != $upload_error) {
                    if($id)
                    {
                        $resource = $this->Resources->get($id);
                        $resource = $this->Resources->patchEntity($resource, $this->request->data);
                    }
                    else
                        $resource = $this->Resources->newEntity($this->request->data);

                    if ($this->Resources->save($resource)) {
                        $this->Flash->success('The resource has been saved.');
                        return $this->redirect(['controller'=>'Resources','action' => 'navigate',$parent_id]);
                    } else {
                        $this->Flash->error('Sorry, the resource could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                    }
               }                
        }
        else
            $resource = $this->Resources->newEntity([]);

        $sourceFolders = $this->Folders->find('all')
                                        ->where(['vendor_id'=>'0','user_role'=>'admin','status'=>'Y','parent_id'=>'1'])
                                        ->order(['parentpath' => 'Asc','folderpath' => 'Asc']);

        $parentfolder = $this->Folders->get($parent_id);

        $folders= array();
        foreach($sourceFolders as $sf){
            $folders[$sf->id] =$sf->name;
        }
        
        $users = $this->Resources->Users->find('list');
        $vendors = $this->Resources->Vendors->find('list');
        $this->set(compact('resource', 'folders', 'users', 'vendors','parent_id','parentfolder'));
    }

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($parent_id=0,$id = null) {
		$resource = $this->Resources->get($id);
		if ($this->request->is(['patch', 'post', 'put'])) {
            $ret = true;

            if (!empty($this->request->data['sourcepath']['tmp_name']) && $this->request->data['sourcepath']['error'] == 0 && in_array($this->request->data['sourcepath']['type'],$this->allowed_resource_file_types))
            {
                $folder = $this->Folders->get($resource->folder_id);
                $file_ext = substr(strrchr($this->request->data['sourcepath']['name'],'.'),1);
                $source_ext = substr(strrchr($resource->sourcepath,'.'),1);
                if($file_ext==$source_ext)
                {
                    $this->Opencloud->updateObject($resource->sourcepath,$this->request->data['sourcepath']['tmp_name']);
                    $this->request->data['size'] = $this->request->data['sourcepath']['size'];
                    unset($this->request->data['sourcepath']);
                }
                else
                {
                    $file_name = $id . '.' . $file_ext;
                    $newfilepath =  ($folder->folderpath ? $folder->folderpath . '/' : '') . $file_name;
                    $this->Opencloud->replaceObject($resource->sourcepath,$newfilepath,$this->request->data['sourcepath']['tmp_name']);
                    
                    $this->request->data['type'] = $this->request->data['sourcepath']['type'];
                    $this->request->data['size'] = $this->request->data['sourcepath']['size'];
                    $this->request->data['sourcepath'] = $newfilepath;
                    $this->request->data['publicurl'] = $this->Opencloud->getobjecturl($newfilepath);

                }
            }
            else
                unset($this->request->data['sourcepath']);


            $resource = $this->Resources->patchEntity($resource, $this->request->data);
			if ($this->Resources->save($resource)) {
				$this->Flash->success('The resource has been saved.');
				return $this->redirect(['controller'=>'Resources','action' => 'navigate',$parent_id]);
			} else {
				$this->Flash->error('Sorry, the resource could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$folders = $this->Resources->Folders->find('list');
		$users = $this->Resources->Users->find('list');
		$vendors = $this->Resources->Vendors->find('list');
		$this->set(compact('resource', 'folders', 'users', 'vendors'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($parent_id=0,$id = null) {
		$resource = $this->Resources->get($id);
        if($this->Opencloud->deleteObject($resource->sourcepath))
    		if ($this->Resources->delete($resource)) {
    			$this->Flash->success('The resource has been deleted.');
    		} else {
    			$this->Flash->error('Sorry, the resource could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
    		}
		return $this->redirect(['controller'=>'Resources','action' => 'navigate',$parent_id]);
    }

    public function bulkdelete() {

        $ids = $this->request->data['ids'];
        $ids = explode(',',$ids);
        $error = 0;
        foreach($ids as $id)
        {

            $resource = $this->Resources->get($id);
            if($this->Opencloud->deleteObject($resource->sourcepath))
                if ($this->Resources->delete($resource)) {
                   // do nothing
                } else {
                   $error++;
                }
            else
                $error++;

        }

        if($error==0)
            die('SUCCESS');
        else
            die($error);
    }

    public function download($id=null) {
         if($id!=null){
                $resource = $this->Resources->get($id);
                $filename = ( $resource->name ? str_replace(' ','_',strtolower($resource->name)) : $resource->id ) . '.' . substr(strrchr($resource->sourcepath,'.'),1);
                $this->Opencloud->downloadObject( $resource->sourcepath,$filename );
                die(); //end here
        }
    }
}