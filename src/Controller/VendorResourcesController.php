<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Resources Controller
 *
 * @property App\Model\Table\ResourcesTable $Resources
 */
class VendorResourcesController extends AppController {

    private $user;

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->set('country_list',$this->country_list);
        $this->loadModel('Folders');
        $this->loadModel('Resources');
        $this->loadModel('PartnerGroups');
        $this->loadModel('PartnerGroupResources');
        $this->loadComponent('Opencloud');
    }
    public function isAuthorized($user) {
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
            
        }elseif(isset($user['role']) && $user['role'] === 'vendor') {            
            $this->user = $user;
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
        $folder = $this->Folders->find()->where(['user_role'=>$this->user['role'],'vendor_id'=>$this->user['vendor_id'],'user_id'=>$this->user['id'],'parent_id'=>4])->first(); //parent_id is default for folder for vendors
        if($folder)
            $folderid = $folder->id;
        else
        {
            $folderid = $this->copyresourcetemplate();
        }
		$this->navigate($folderid);
	}

    private function copyresourcetemplate() {
        $this->copyfoldercontents(2,4); // default templates folderid=2, parentid_new=4(Vendors)
        $folder = $this->Folders->find()->where(['vendor_id'=>$this->user['vendor_id'],'user_id'=>$this->user['id'],'parent_id'=>4])->first(); //parent_id is default for folder for vendors
        return $folder->id;
    }

    private function copyfoldercontents($folderid,$parentid_new) {
        // copy folder        
        if($folderid==2) // if default template folder
        {
            // Create Vendor Root Folder
            $folder_new = $this->Folders->newEntity(['parentpath'=>'vendors','user_id'=>$this->user['id'],'user_role'=>$this->user['role'],'vendor_id'=>$this->user['vendor_id'],'name'=>$this->user['username'],'folderpath'=>'vendors/'.$this->user['vendor_id'],'status'=>'Y','parent_id'=>$parentid_new]);
        }
        else
        {
            // Copy Template Folder
            $folder = $this->Folders->get($folderid);
            $parentfolder_new = $this->Folders->get($parentid_new);

            $folder_new = $this->Folders->newEntity(['parentpath'=>$parentfolder_new->folderpath,'user_id'=>$this->user['id'],'user_role'=>$this->user['role'],'vendor_id'=>$this->user['vendor_id'],'name'=>$folder->name,'folderpath'=>substr_replace($folder->folderpath,$parentfolder_new->folderpath,0,strlen($folder->parentpath)),'status'=>$folder->status,'parent_id'=>$parentid_new]);
        }
        $this->Folders->save($folder_new);
        $folderid_new = $folder_new->id;
        // copy folder contents
        $resources = $this->Resources->find()->where(['folder_id'=>$folderid]);
        if($resources->count()>0)
        foreach($resources as $resource)
        {
            $resource_new = $this->Resources->newEntity(['folder_id'=>$folderid_new,'name'=>$resource->name,'description'=>$resource->description,'user_id'=>$this->user['id'],'user_role'=>$this->user['role'],'vendor_id'=>$this->user['vendor_id'],'status'=>$resource->status,'sourcepath'=>$resource->sourcepath,'publicurl'=>$resource->publicurl,'type'=>$resource->type,'size'=>$resource->size]);
            $this->Resources->save($resource_new);
        }

        // copy subfolders
        $subfolders = $this->Folders->find()->where(['parent_id'=>$folderid]);
        if($subfolders->count()>0)
        foreach($subfolders as $subfolder)
            $this->copyfoldercontents($subfolder->id,$folderid_new);

        return true;
    }

/**
 * navigate method
 *
 * @return void
 */
    public function navigate($folderid=0) {
        if($folderid<=4)
        {
            $this->Flash->error('Sorry, the resource could not be accessed. Insufficient access privelege.');
            return $this->redirect(['controller'=>'VendorResources','action' => 'index']);
        }

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
        $resources = $this->paginate($this->Resources->find()->contain(['Vendors'])->where( [ 'vendor_id'=>$this->user['vendor_id'],'user_id'=>$this->user['id'],'OR' => $conds ] ));
 
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
        if ($this->request->is(['ajax'])){
			$upload_error   =   false;
			$data = $this->request->data;
			
			 if (!empty($this->request->data['sourcepath']['tmp_name']) && $this->request->data['sourcepath']['error'] == 0 && in_array($this->request->data['sourcepath']['type'],$this->allowed_resource_file_types)) {
				// Insert data prior to uploading to get ID for filename
                $resource = $this->Resources->newEntity($this->request->data);
				if ($this->Resources->save($resource)){
                    $id = $resource->id;
                    $file_ext = substr(strrchr($this->request->data['sourcepath']['name'],'.'),1);
                    $file_name = $id . '.' . $file_ext;
                }else{
					 $file_name =  $this->request->data['sourcepath']['name'];
				}
				
				$folder = $this->Folders->get($this->request->data['folder_id']);
                $srcfile =  ($folder->folderpath ? $folder->folderpath . '/' : '') . $file_name;
				
				if($this->Opencloud->addObject($srcfile,$this->request->data['sourcepath']['tmp_name'])){
					$this->request->data['type'] = $this->request->data['sourcepath']['type']; //$object->getContentType();
                    $this->request->data['size'] = $this->request->data['sourcepath']['size']; //$object->getContentLength();
                    $this->request->data['sourcepath'] = $srcfile; //$object->getName();
                    $this->request->data['publicurl'] = $this->Opencloud->getobjecturl($srcfile);
				}else {
					$upload_error   =   true;
				}
			 }else {
				unset($this->request->data['sourcepath']);
			 }
			
			 if(true != $upload_error) {
				if($id){
					$resource = $this->Resources->get($id);
					$resource = $this->Resources->patchEntity($resource, $this->request->data);

					// insert new selected groups
					if(count($this->request->data['groups'])){
						foreach($this->request->data['groups'] as $group)
							$this->PartnerGroupResources  ->query()
														->insert(['resource_id','partner_group_id'])
														->values(['resource_id'=>$id,'partner_group_id'=>$group])
														->execute();
						$this->request->data['assigned'] = 'Y';
					}                        
				}else{
					$resource = $this->Resources->newEntity($this->request->data);
				}
				if($this->Resources->save($resource)) {
					$this->Flash->success('The resource has been saved.');
					//return $this->redirect(['controller'=>'VendorResources','action' => 'navigate',$parent_id]);
					echo "success";
				}else {
					$this->Flash->error('Sorry, the resource could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
				}
		   }
			
			
			//print_r($data);
			exit();
		}
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

                        // insert new selected groups
                        if(count($this->request->data['groups'])) 
                        {
                            foreach($this->request->data['groups'] as $group)
                                $this->PartnerGroupResources  ->query()
                                                            ->insert(['resource_id','partner_group_id'])
                                                            ->values(['resource_id'=>$id,'partner_group_id'=>$group])
                                                            ->execute();
                            $this->request->data['assigned'] = 'Y';
                        }                        
                    }
                    else
                        $resource = $this->Resources->newEntity($this->request->data);

                    if ($this->Resources->save($resource)) {
                        $this->Flash->success('The resource has been saved.');
                        return $this->redirect(['controller'=>'VendorResources','action' => 'navigate',$parent_id]);
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
        $groups = $this->PartnerGroups->find('list')->where(['vendor_id'=>$this->user['vendor_id']]);
        $this->set(compact('resource', 'folders', 'users', 'vendors','parent_id','parentfolder','groups'));
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
            // delete existing group resources
            $this->PartnerGroupResources  ->query()
                                        ->delete()
                                        ->where(['resource_id'=>$id])
                                        ->execute();
            $this->request->data['assigned'] = 'N';
            // insert new selected groups
            if(count($this->request->data['groups'])) 
            {
                foreach($this->request->data['groups'] as $group)
                    $this->PartnerGroupResources  ->query()
                                                ->insert(['resource_id','partner_group_id'])
                                                ->values(['resource_id'=>$id,'partner_group_id'=>$group])
                                                ->execute();
                $this->request->data['assigned'] = 'Y';
            }

            if (!empty($this->request->data['sourcepath']['tmp_name']) && $this->request->data['sourcepath']['error'] == 0 && in_array($this->request->data['sourcepath']['type'],$this->allowed_resource_file_types))
            {
                $folder = $this->Folders->get($resource->folder_id);
                $file_ext = substr(strrchr($this->request->data['sourcepath']['name'],'.'),1);
                $source_ext = substr(strrchr($resource->sourcepath,'.'),1);

                if(stripos($resource->sourcepath, $folder->folderpath)===0)
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
                else
                {
                    $file_name = $id . '.' . $file_ext;
                    $newfilepath =  ($folder->folderpath ? $folder->folderpath . '/' : '') . $file_name;
                    if($this->Opencloud->addObject($newfilepath,$this->request->data['sourcepath']['tmp_name']))
                    {
                        $this->request->data['type'] = $this->request->data['sourcepath']['type']; 
                        $this->request->data['size'] = $this->request->data['sourcepath']['size'];
                        $this->request->data['sourcepath'] = $newfilepath; 
                        $this->request->data['publicurl'] = $this->Opencloud->getobjecturl($newfilepath);
                    }
                    else
                        unset($this->request->data['sourcepath']);
                }
            }
            else
                unset($this->request->data['sourcepath']);


            $resource = $this->Resources->patchEntity($resource, $this->request->data);
			if ($this->Resources->save($resource)) {
				$this->Flash->success('The resource has been saved.');
				return $this->redirect(['controller'=>'VendorResources','action' => 'navigate',$parent_id]);
			} else {
				$this->Flash->error('Sorry, the resource could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$folders = $this->Resources->Folders->find('list');
		$users = $this->Resources->Users->find('list');
		$vendors = $this->Resources->Vendors->find('list');
        $groups = $this->PartnerGroups->find('list')->where(['vendor_id'=>$this->user['vendor_id']]);
        $partner_groups = $this->PartnerGroupResources->find()->select(['partner_group_id'])->where(['resource_id'=>$id])->toArray();
        foreach($partner_groups as $group)
            $assigned_groups[] = $group->partner_group_id;
		$this->set(compact('resource', 'folders', 'users', 'vendors','groups','assigned_groups'));
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
        $folder = $this->Folders->get($resource->folder_id);
        if(stripos($resource->sourcepath, $folder->folderpath)===0)
        {
            if($this->Opencloud->deleteObject($resource->sourcepath))
        		if ($this->Resources->delete($resource)) {
        			$this->Flash->success('The resource has been deleted.');
        		} else {
        			$this->Flash->error('Sorry, the resource could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
        		}
        }
        else
        {
            if ($this->Resources->delete($resource)) {
                $this->Flash->success('The resource has been deleted.');
            } else {
                $this->Flash->error('Sorry, the resource could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
            }
        }

		return $this->redirect(['controller'=>'VendorResources','action' => 'navigate',$parent_id]);
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