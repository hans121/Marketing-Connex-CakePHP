<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Folders Controller
 *
 * @property App\Model\Table\FoldersTable $Folders
 */
class FoldersController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        //$this->Auth->allow(['buypackage','primarycontact','checkout','payment']);
        $this->layout = 'admin';
        $this->set('country_list',$this->country_list);
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
		$this->paginate = [
			'contain' => ['Users', 'Vendors']
		];
		$this->set('folders', $this->paginate($this->Folders->find('all')->where(['parentpath !='=> '0'])));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$folder = $this->Folders->get($id, [
			'contain' => ['Users', 'Vendors', 'Resources']
		]);
		$this->set('folder', $folder);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add($parent_id=NULL) {
         if ($this->request->is('post')) {
            $parent = $this->Folders->get($this->request->data['parent_id']);
            $this->request->data['user_id'] = $parent->user_id;
            $this->request->data['user_role'] = $parent->user_role;
            $this->request->data['vendor_id'] = $parent->vendor_id;
            $this->request->data['parentpath'] = $parent->folderpath;
            $this->request->data['status'] = 'Y';
            $this->request->data['folderpath'] = ($parent->folderpath?$parent->folderpath.'/':'').str_replace(' ','_',strtolower($this->request->data['name']));
            $dupfolder = $this->Folders->find()->where(['parent_id'=>$this->request->data['parent_id'],'folderpath'=>$this->request->data['folderpath']]);
            
            if($dupfolder->count())
            {
                $this->Flash->error('The folder could not be created. Duplicate folder found.');
            }
            else
            {            
                $folder = $this->Folders->newEntity($this->request->data);
                $this->Folders->save($folder);
                $this->Flash->success('The folder has been created.');
                return $this->redirect(['controller'=>'Resources','action'=>'navigate',$this->request->data['parent_id']]);
            }
           
        }

		$sourceFolders = $this->Folders->find('all')
	    ->where(['status'=>'Y'])
	    ->order(['parentpath' => 'Asc','folderpath' => 'Asc']);
      $parentFolders= array();
      foreach($sourceFolders as $sf){
        $parentFolders[$sf->id] =($sf->parent_id == '0' ? $sf->name : $sf->folderpath);
      }
		$users = $this->Folders->Users->find('list');
		$vendors = $this->Folders->Vendors->find('list');
		$this->set(compact('folder', 'parentFolders', 'users', 'vendors','parent_id'));
	}

/**
 * rename method
 *
 * @return void
 */
    public function rename() {
        if ($this->request->is('post')) {
            $folderid = $this->request->data['id'];
            $folder = $this->Folders->get($folderid, ['contain'=>['Resources']]);
            $subfolders = $this->Folders->find()->where(['parent_id'=>$folderid]);
            if(count($folder->resources)<=0 && $subfolders->count()<=0) {
                $this->request->data['folderpath'] = ($folder->parentpath?$folder->parentpath.'/':'').str_replace(' ','_',strtolower($this->request->data['name']));
                
                $dupfolder = $this->Folders->find()->where(['parent_id'=>$folder->parent_id,'folderpath'=>$this->request->data['folderpath']]);

                if($dupfolder->count())
                    die('DUPLICATE');

                $folder = $this->Folders->patchEntity($folder,$this->request->data);
                if($this->Folders->save( $folder ))
                {
                    die('SUCCESS');
                }
                die('ERROR');
            }
            else
                die('NOTEMPTY');
        }
         die('INVALID');
    }

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
        $folder = $this->Folders->get($id);
        $parent_id = $folder->parent_id;

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $folder = $this->Folders->patchEntity($folder, $this->request->data);
            $this->Folders->save($folder);
            $this->Flash->success('The folder has been updated.');
            return $this->redirect(['controller'=>'VendorResources','action'=>'navigate',$this->request->data['parent_id']]);
            
        }

        $sourceFolders = $this->Folders->find('all')
                                        ->where(['vendor_id'=>'0','user_role'=>'admin','status'=>'Y'])
                                        ->order(['parentpath' => 'Asc','folderpath' => 'Asc']);
        $parentFolders= array();
        foreach($sourceFolders as $sf){
            $parentFolders[$sf->id] =($sf->parentpath == '0' ? $sf->folderpath : $sf->folderpath);
        }

        $users = $this->Folders->Users->find('list');
        $vendors = $this->Folders->Vendors->find('list');
        $this->set(compact('folder','parentFolders', 'users', 'vendors', 'parent_id'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($parent_id = 0,$folder_id) {
        if (isset($folder_id)) {
            $folder = $this->Folders->get($folder_id, ['contain'=>['Resources']]);
            $subfolders = $this->Folders->find()->where(['parent_id'=>$folder_id]);
            if(count($folder->resources)<=0 && $subfolders->count()<=0) {
                $entity = $this->Folders->get($folder_id);
                if($this->Folders->delete($entity))
                {
                    $this->Flash->success('The folder has been deleted.');                     
                }
            }
            else
                $this->Flash->error('The folder could not be deleted. Folder not empty.');
        }
        return $this->redirect(['controller'=>'Resources','action'=>'navigate',$parent_id]);
	}

        /**
        * Find Child Folders List method
        *
        * @param string $id
        * @return array of child folders id
        * @throws \Cake\Network\Exception\NotFoundException
        */
        function __getChildList($id=null,&$childern=array()){
            $fldrs  =   $this->Folders->findAllByParentId($id);
            foreach($fldrs as $fld){
                array_push($childern,$fld->id);
                $this->__getChildList($fld->id, $childern);
            }
          return $childern;
        }
        function __editFoldername($id=null,$name=null,$newparent=null){
            if($id != null && $name != null){
                $folder = $this->Folders->get($id);
                $childfldrs=    $this->__getChildList($id);
                if($newparent == null){
                    $nppath =   $folder->parentpath;
                }else{
                     $nppath =   $newparent;
                }
                if($this->Filemanagement->renameFolder($nppath.$name,$folder->parentpath.$folder->name)){
                    /*
                     * Section to update parent path of child folders......
                     */
                    foreach($childfldrs as $chld){
                        $this->__updateparentpath($chld, $nppath.$name, $folder->parentpath.$folder->name);
                    }
                    return true;
                }
               
            }
            return false;
        }
        function __updateparentpath($id,$newpath,$oldpath){
             
            $folder = $this->Folders->get($id);
            //print_r($folder->parentpath);
            $npath  =   explode( $oldpath , $folder->parentpath );
            $rpth   =   '';
            if(is_array($npath)){
                for($i=1;$i <sizeof($npath);$i++){
                    if($i > 1){
                        $rpth   .=   $oldpath.$npath[$i];
                    }else {
                        $rpth   .=   $npath[$i];
                    }
                }
                
            }
            $new_parentpath =   $newpath.$rpth;
            $Fquery = $this->Folders->query();
            $Fquery->update()
                ->set(['parentpath' => $new_parentpath])
                ->where(['id' =>  $id])
                ->execute();
            return true;
        }
        /*
         * Function to update child folders parent path
         */
        function __editChildParentPath($id=null, $parentpath=null){
            if($id != null && $parentpath != null){
                $folder = $this->Folders->get($id);
                $childfldrs=    $this->__getChildList($id);
                $oldpath =   $folder->parentpath.$folder->folderpath;
                    if($this->Filemanagement->renameFolder($parentpath,$oldpath)){
                         foreach($childfldrs as $chld){
                        $this->__updateparentpath($chld, $parentpath, $oldpath);
                    }
                }
               
                return true;   
            }
            return false;
        }
}
