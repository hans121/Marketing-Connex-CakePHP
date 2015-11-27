<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Network\Email\Email;
/**
 * Resources Controller
 *
 * @property App\Model\Table\ResourcesTable $Resources
 */
class PartnerResourcesController extends AppController {

    private $user;

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->set('country_list',$this->country_list);
        $this->loadModel('Folders');
        $this->loadModel('Resources');
        $this->loadModel('Partners');
        $this->loadModel('PartnerGroupResources');
        $this->loadModel('PartnerGroupFolders');
        $this->loadModel('Users');
        $this->loadModel('Vendors');
        $this->loadModel('VendorManagers');

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
            
        }elseif (isset($user['role']) && $user['role'] === 'admin') {
            return false;
        }
        elseif(isset($user['role']) && $user['role'] === 'vendor') {
            return false;
        }elseif(isset($user['role']) && $user['role'] === 'partner') {
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
        $folder = $this->Folders->find()->where(['vendor_id'=>$this->user['vendor_id'],'parent_id'=>4])->first(); //parent_id is default for folder for vendors
        if($folder)
            $folderid = $folder->id;
        else
        {
            $vendor = $this->VendorManagers->find()->contain(['Users'])->where(['vendor_id'=>$this->user['vendor_id']])->first();
            $folderid = $this->copyresourcetemplate($vendor->id,$vendor->user->id,$vendor->user->username);
        }
		$this->navigate($folderid);
	}

    private function copyresourcetemplate($vendorid,$vendoruserid,$vendorusername) {
        $this->copyfoldercontents(2,4,$vendorid,$vendoruserid,$vendorusername); // default templates folderid=2, parentid_new=4(Vendors)
        $folder = $this->Folders->find()->where(['vendor_id'=>$vendorid,'user_id'=>$vendoruserid,'parent_id'=>4])->first(); //parent_id is default for folder for vendors
        return $folder->id;
    }

    private function copyfoldercontents($folderid,$parentid_new,$vendorid,$vendoruserid,$vendorusername) {
        // copy folder        
        if($folderid==2) // if default template folder
        {
            // Create Vendor Root Folder
            $folder_new = $this->Folders->newEntity(['parentpath'=>'vendors','user_id'=>$vendoruserid,'user_role'=>'vendor','vendor_id'=>$vendorid,'name'=>$vendorusername,'folderpath'=>'vendors/'.$vendorid,'status'=>'Y','parent_id'=>$parentid_new]);
        }
        else
        {
            // Copy Template Folder
            $folder = $this->Folders->get($folderid);
            $parentfolder_new = $this->Folders->get($parentid_new);

            $folder_new = $this->Folders->newEntity(['parentpath'=>$parentfolder_new->folderpath,'user_id'=>$vendoruserid,'user_role'=>'vendor','vendor_id'=>$vendorid,'name'=>$folder->name,'folderpath'=>substr_replace($folder->folderpath,$parentfolder_new->folderpath,0,strlen($folder->parentpath)),'status'=>$folder->status,'parent_id'=>$parentid_new]);
        }
        $this->Folders->save($folder_new);
        $folderid_new = $folder_new->id;
        // copy folder contents
        $resources = $this->Resources->find()->where(['folder_id'=>$folderid]);
        if($resources->count()>0)
        foreach($resources as $resource)
        {
            $resource_new = $this->Resources->newEntity(['folder_id'=>$folderid_new,'name'=>$resource->name,'description'=>$resource->description,'user_id'=>$vendoruserid,'user_role'=>'vendor','vendor_id'=>$vendorid,'status'=>$resource->status,'sourcepath'=>$resource->sourcepath,'publicurl'=>$resource->publicurl,'type'=>$resource->type,'size'=>$resource->size]);
            $this->Resources->save($resource_new);
        }

        // copy subfolders
        $subfolders = $this->Folders->find()->where(['parent_id'=>$folderid]);
        if($subfolders->count()>0)
        foreach($subfolders as $subfolder)
            $this->copyfoldercontents($subfolder->id,$folderid_new,$vendorid,$vendoruserid,$vendorusername);

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

            $partner = $this->Partners->get($this->user['partner_id']);
            //Get group assigned resources
            $partner_group_resources = $this->PartnerGroupResources->find()->where(['partner_group_id'=>$partner->partner_group_id]);
            foreach($partner_group_resources as $partner_group_resource)
                $group_resources[] = $partner_group_resource->resource_id;
            $resource_in = ($group_resources?implode(',',$group_resources):'');
            //Get group assigned folders
            $partner_group_folders = $this->PartnerGroupFolders->find()->where(['partner_group_id'=>$partner->partner_group_id]);
            foreach($partner_group_folders as $partner_group_folder)
                $group_folders[] = $partner_group_folder->folder_id;
            $folder_in = ($group_folders?implode(',',$group_folders):'');

            $resources = $this->paginate($this->Resources->find()->contain(['Vendors'])->where(['folder_id'=>$folderid,'OR'=>['assigned'=>'N','Resources.id IN'=>$resource_in]]));
            $parentfolder = $this->Folders->get($folderid);
            $folders = $this->Folders
                        ->find('all')
                        ->where(['parent_id'=>$folderid,'status'=>'Y','OR'=>['assigned'=>'N','id IN'=>$folder_in]])
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

    public function report($id = null) {
        $resource = $this->Resources->get($id, [
            'contain' => ['Folders', 'Users', 'Vendors']
        ]);

        if ($this->request->is(['post','put'])) {

            $users = $this->Users->find()->where(['role'=>'admin','status'=>'Y']);
            foreach($users as $user)
                $admins[] = $user->email;

            $msg = "
File ID: {$resource->id}<br />
File: {$resource->sourcepath}<br />
Owner: {$resource->user->username}<br />
Vendor: {$resource->vendor->company_name}<br />
File URL: {$resource->publicurl}<br />
<br />
            ";

            $msg .= $this->request->data['message'];

            $fgemail = new Email('default');
            $fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
            $fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
            ->to($admins)
            ->subject(__('Resource Abuse Report'))
            ->emailFormat('both')
            ->send($msg);

            $this->Flash->success('The resource has been reported for abuse.');
            return $this->redirect(['controller'=>'PartnerResources', 'action' => 'navigate',$resource->folder_id]);
        }

        $this->set('resource', $resource);
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