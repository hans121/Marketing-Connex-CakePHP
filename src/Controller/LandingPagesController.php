<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
/**
 * LandingPages Controller
 *
 * @property App\Model\Table\LandingPagesTable $LandingPages
 */
class LandingPagesController extends AppController {

    public $components = ['Imagecreator'];
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->loadModel('Campaigns');
        $this->loadModel('LandingForms');
        $this->Auth->allow(['view','downloadfile']);
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
            return true;
        }
        // Default deny
        return false;
    }
    public function managepage($cmp_id=0){
        if($cmp_id < 1){
            return $this->redirect(['controller' => 'Campaigns','action' => 'index']);
        }
        $this->request->allowMethod('post', 'delete');
        $lpa    =   $this->LandingPages->find()
                                        ->where(['campaign_id' => $cmp_id])
                                        ->first();
        if(isset($lpa->id) && $lpa->id   > 0){
            return $this->redirect(['action' => 'edit',$lpa->id]);
        }
        return $this->redirect(['action' => 'add',$cmp_id]);
    }
/**
 * Add method
 *
 * @return void
 */
	public function add($cmp_id=0) {
		
            if($cmp_id < 1){
                return $this->redirect(['controller' => 'Campaigns','action' => 'index']);
            }
            /*
            * Section for Banner BG Image upload
            */
            $vid    =   $this->Auth->user('vendor_id');
            $bgfilename = null;
            $msg='';
            $allwed_types = array('image/jpg','image/jpeg','image/png','image/gif');
            //Filemanagement
            if (!empty($this->request->data['banner_bg_image']['tmp_name']) && $this->request->data['banner_bg_image']['error'] == 0 && in_array($this->request->data['banner_bg_image']['type'],$allwed_types)) {
                // Strip path information

                $bgfilename = time().basename($this->request->data['banner_bg_image']['name']); 

                if($this->Imagecreator->uploadImageFile($bgfilename,$this->request->data['banner_bg_image']['name'],$this->request->data['banner_bg_image']['tmp_name'],$this->request->data['banner_bg_image']['type'],WWW_ROOT  .'img' . DS . 'landingpages' . DS .'bgimages'.DS. $bgfilename,$this->request->data['banner_bg_image']['size'],420)){
                    $this->request->data['banner_bg_image'] = $bgfilename;
                }else{
                    unset($this->request->data['banner_bg_image']);
                }

            }else{
                if(isset($this->request->data['banner_bg_image'])){
                    unset($this->request->data['banner_bg_image']);
                } 
            }
            /*
             * End of image upload section
             *
             * Section To upload Downloadable file
             */
            if (!empty($this->request->data['downloadable_item']['tmp_name']) && $this->request->data['downloadable_item']['error'] == 0 && in_array($this->request->data['downloadable_item']['type'],$this->allowed_resource_file_types)) {
                $updfile = $this->Filemanagement->uploadFiletoFolder($this->request->data['downloadable_item'],'landingpages/');
                if($updfile['success'] == 200){
                    $srcfile    =   $updfile['filename'];
                    $this->request->data['downloadable_item'] = $srcfile;
                }else{
                    $msg     .=   $updfile['msg'];
                    unset($this->request->data['downloadable_item']);
                    $upload_error   =   true;
                    
                }
                
            }else{
                unset($this->request->data['downloadable_item']);
            }
             
             /* 
             * Section to serialize external urls..
             */
            if(isset($this->request->data['form_external'])){
                $this->request->data['external_links']  =   json_encode($this->request->data['form_external']);
                unset($this->request->data['form_external']);
            }
            $landingPage = $this->LandingPages->newEntity($this->request->data);
            if ($this->request->is('post')) {
                
                    
                if ($this->LandingPages->save($landingPage)) {
                            $this->Flash->success($msg.'The landing page has been saved.');
                             return $this->redirect(['controller'=>'Campaigns','action' => 'view',$cmp_id]);
                    } else {
                            $this->Flash->error($msg.'The landing page could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                    }
            }
            $campaigns = $this->LandingPages->Campaigns->find('list');
            $vendors = $this->LandingPages->Vendors->find('list');
            $masterTemplates = $this->LandingPages->MasterTemplates->find('list')->where(['template_type' => 'landing_page']);
            $this->set(compact('landingPage', 'campaigns', 'vendors', 'masterTemplates','cmp_id','vid'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$landingPage = $this->LandingPages->get($id, [
			'contain' => []
		]);
                $msg    =   '';
                $externalurls   =   array();
                if(isset($landingPage->external_links)){
                    $externalurls   = json_decode($landingPage->external_links);
                }
		/*
                * Section for Banner BG Image upload
                */
                $vid    =   $this->Auth->user('vendor_id');
                $bgfilename = null;
                $allwed_types = array('image/jpg','image/jpeg','image/png','image/gif');
                //Filemanagement
                if (!empty($this->request->data['banner_bg_image']['tmp_name']) && $this->request->data['banner_bg_image']['error'] == 0 && in_array($this->request->data['banner_bg_image']['type'],$allwed_types)) {
                    // Strip path information

                    $bgfilename = time().basename($this->request->data['banner_bg_image']['name']); 

                    if($this->Imagecreator->uploadImageFile($bgfilename,$this->request->data['banner_bg_image']['name'],$this->request->data['banner_bg_image']['tmp_name'],$this->request->data['banner_bg_image']['type'],WWW_ROOT  .'img' . DS . 'landingpages' . DS .'bgimages'.DS. $bgfilename,$this->request->data['banner_bg_image']['size'],420)){
                        $this->request->data['banner_bg_image'] = $bgfilename;
                    }else{
                        unset($this->request->data['banner_bg_image']);
                    }

                }else{
                    if(isset($this->request->data['banner_bg_image'])){
                        unset($this->request->data['banner_bg_image']);
                    } 
                }
                /*
                 * End of image upload section
                 *
                 * Section To upload Downloadable file
                 */
                if (!empty($this->request->data['downloadable_item']['tmp_name']) && $this->request->data['downloadable_item']['error'] == 0 && in_array($this->request->data['downloadable_item']['type'],$this->allowed_resource_file_types)) {
                    $updfile = $this->Filemanagement->uploadFiletoFolder($this->request->data['downloadable_item'],'landingpages/');
                    //print_r($updfile); exit;
                    if($updfile['success'] == 200){
                        $srcfile    =   $updfile['filename'];
                        $this->request->data['downloadable_item'] = $srcfile;
                        //echo $srcfile; exit;
                    }else{
                        $msg     .=   $updfile['msg'];
                        unset($this->request->data['downloadable_item']);
                        $upload_error   =   true;

                    }
                    
                    //print_r($folder->folderpath);exit;
                }else{
                    unset($this->request->data['downloadable_item']);
                }
                if(isset($this->request->data['ajaxedit_id'])){
                    unset($this->request->data['ajaxedit_id']);
                }
                 /* 
                 * Section to serialize external urls..
                 */
                if(isset($this->request->data['form_external'])){
                    $this->request->data['external_links']  =   json_encode($this->request->data['form_external']);
                    unset($this->request->data['form_external']);
                }
                if ($this->request->is(['patch', 'post', 'put'])) {
			$landingPage = $this->LandingPages->patchEntity($landingPage, $this->request->data);
			if ($this->LandingPages->save($landingPage)) {
				$this->Flash->success($msg.'The landing page has been saved.');
				return $this->redirect(['controller'=>'Campaigns','action' => 'view',$landingPage->campaign_id]);
			} else {
				$this->Flash->error($msg.'The landing page could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$campaigns = $this->LandingPages->Campaigns->find('list');
		$vendors = $this->LandingPages->Vendors->find('list');
		$masterTemplates = $this->LandingPages->MasterTemplates->find('list')->where(['template_type' => 'landing_page']);
		$this->set(compact('landingPage', 'campaigns', 'vendors', 'masterTemplates','externalurls'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$landingPage = $this->LandingPages->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->LandingPages->delete($landingPage)) {
			$this->Flash->success('The landing page has been deleted.');
		} else {
			$this->Flash->error('The landing page could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
        
    /*
     * Function to show landing page
     */
    public function view($id=0){
        $rethome    =   false;
        if($id >0){
            $lpa    =   $this->LandingPages->find()
                                            ->where(['id' => $id])
                                            ->first();
            if(isset($lpa->id) && $lpa->id   > 0){
                $rethome    =   false;
            }else{
                $rethome    =   true;
            }
        }else{
            $rethome    =   true;
        }
        if($rethome == true) {
            $this->Flash->error('Can\'t preview landing page, no landing page on record.');
            return $this->redirect($this->referer());
        } 
        $landingPage = $this->LandingPages->get($id, [
			'contain' => ['Campaigns', 'Vendors', 'MasterTemplates', 'LandingForms','Vendors.VendorManagers.Users']
		]);
		
		$campaign_desc = $landingPage[campaign][id].": ".$landingPage[campaign][name];
        $vendor_email   =   $landingPage['vendor']['vendor_managers'][0]['user']->email;
        $vendor_name   =   $landingPage['vendor']['company_name'];
        $landingForm = $this->LandingForms->newEntity($this->request->data);
        
        
        if ($this->request->is('post')) {
                if ($this->LandingForms->save($landingForm)) {
                        if($landingPage->chk_frm_submission ==   'Y' && is_file(WWW_ROOT  .'files' . DS .'landingpages'.DS.$landingPage->downloadable_item) && isset($landingForm->email_address) && '' !=trim($landingForm->email_address)){
                            /*
                             * Section to send downloadable item in  e-mail
                             */
                            $sent = $this->Prmsemails->sendLandingPageResource($landingForm->email_address,null,WWW_ROOT  .'files' . DS .'landingpages'.DS.$landingPage->downloadable_item,$vendor_email,$vendor_name);
                            $extra_msg = ' Please check your email.';
                        }
                        $this->Flash->success('Thank you for contacting us.'.$extra_msg);                        
                        return $this->redirect(['controller'=>'LandingPages','action' => 'view',$id]);
                } else {
                        $this->Flash->error('The form could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                }
        }
        
        
        $viewhtml   =   $landingPage['master_template']->content;
        $viewhtml   =   str_replace('[*!HEADING!*]',$landingPage->heading, $viewhtml);
        $viewhtml   =   str_replace('[*!BODYTEXT!*]',$landingPage->body_text, $viewhtml);
        $viewhtml   =   str_replace('[*!FRMHEADING!*]',$landingPage->form_heading, $viewhtml);
        $viewhtml   =   str_replace('[*!FOOTERTEXT!*]',$landingPage->footer_text, $viewhtml);
        /*
         * Section for external menu
         */
        $ext_menu   =   json_decode($landingPage->external_links);
        $mnu_str    =   '';
        if(!empty($ext_menu)){
            foreach($ext_menu as $mnu){
                $mnu_str    .=   '<a href="'.$mnu->url.'" target="_blank" id="external_link">'.$mnu->text.'</a>';
            }
        }
        $viewhtml   =   str_replace('[*!EXTERNALMENU!*]',$mnu_str, $viewhtml);
        $this->set('viewhtml', $viewhtml);
		$this->set('landingPage', $landingPage);
        $this->set('landingForm', $landingForm);
        
        $this->set('vendor_name', $vendor_name);
        $this->set('campaign_desc', $campaign_desc);
        $this->layout = 'ajax';
    }
    public function downloadfile($id=null){
        if($id!=null){
            $landingPage = $this->LandingPages->get($id);
            $this->request->allowMethod('post');
            $this->Filemanagement->download('landingpages/'.$landingPage->downloadable_item);
            return $this->redirect($this->referer());
        }
        return false;
    }
    public function ajaxpreviewimage(){
        $this->loadModel('MasterTemplates');
        $this->layout = 'ajax';
        $mteplate       =   $this->MasterTemplates->get($this->request->data['mtemplate_id']);
        if($this->request->data['poston'] == 0 ){
            $preview_image_name =   $mteplate->title.'.png';
        }else{
            $preview_image_name =   $mteplate->title.'-'.$this->request->data['poston'].'.png';
        }
        //echo  $preview_image_name;exit;
        $this->set('preview_image_name', $preview_image_name);
    }
    public function ajaxpreviewbrowser(){
        $this->loadModel('MasterTemplates');
        $this->layout = 'ajax';
        $editflag       =   false;
        $editbannerimg  =   false;
        //print_r($this->request->data['banner_bg_image']); die();

        /*
         * Section to upload temperory banner image
         */
        $bannerbgfilename = null;
        $allwed_types = array('image/jpg','image/jpeg','image/png','image/gif');
        if (!empty($this->request->data['banner_bg_image']['tmp_name']) && $this->request->data['banner_bg_image']['error'] == 0 && in_array($this->request->data['banner_bg_image']['type'],$allwed_types)) {
            // Strip path information

            $bgfilename = time().basename($this->request->data['banner_bg_image']['name']); 

            if($this->Imagecreator->uploadImageFile($bgfilename,$this->request->data['banner_bg_image']['name'],$this->request->data['banner_bg_image']['tmp_name'],$this->request->data['banner_bg_image']['type'],WWW_ROOT  .'img' . DS . 'tmppreview' . DS .'bgimages'.DS. $bgfilename,$this->request->data['banner_bg_image']['size'],600)){
                $bannerbgfilename = $bgfilename;
            }

        }elseif(true == $editflag){
            if(isset($emailTemplate->banner_bg_image) && $emailTemplate->banner_bg_image != ''){
                $bannerbgfilename   = $emailTemplate->banner_bg_image;
                $editbannerimg      =   true;
            }
        }
        if($this->request->data['banner_bg_image_stored']!='')
            $bannerbgfilename = $this->request->data['banner_bg_image_stored'];
        
        unset($this->request->data['banner_bg_image']);
        if(isset($this->request->data['ajaxedit_id']) && $this->request->data['ajaxedit_id']>0){
            $LandingPage  = $this->LandingPages->get($this->request->data['ajaxedit_id'],[
			'contain' => ['Campaigns', 'Vendors', 'MasterTemplates', 'LandingForms','Vendors.VendorManagers.Users']
		]);
            $landingPage = $this->LandingPages->patchEntity($LandingPage, $this->request->data);
            $editflag       =   true;
        }else{
            $landingPage = $this->LandingPages->newEntity($this->request->data);
        }
        $mteplate   =   $this->MasterTemplates->get($this->request->data['master_template_id']);
        $viewhtml   =   $mteplate->content;
        $viewhtml   =   str_replace('[*!HEADING!*]',$this->request->data['heading'], $viewhtml);
        $viewhtml   =   str_replace('[*!BODYTEXT!*]',$this->request->data['body_text'], $viewhtml);
        $viewhtml   =   str_replace('[*!FRMHEADING!*]',$this->request->data['form_heading'], $viewhtml);
        $viewhtml   =   str_replace('[*!FOOTERTEXT!*]',$this->request->data['footer_text'], $viewhtml);
        /*
         * Section for external menu
         */
        $ext_menu   =   json_decode($landingPage->external_links);
        $mnu_str    =   '';
        if(isset($this->request->data['form_external'])){
            foreach($this->request->data['form_external'] as $mnu){
                $mnu_str    .=   '<a href="'.$mnu['url'].'">'.$mnu['text'].'</a>';
            }
            unset($this->request->data['form_external']);
        }
        $viewhtml   =   str_replace('[*!EXTERNALMENU!*]',$mnu_str, $viewhtml);
        $this->set(compact('viewhtml','bannerbgfilename','editflag','editbannerimg','landingPage'));
    }
    public function ajaxview($cmpid=0){
        $rethome    =   false;
        if($cmpid >0){
            $lpa    =   $this->Campaigns->find()
                                            ->contain(['LandingPages'])
                                            ->where(['id' => $cmpid])
                                            ->first();
            if(isset($lpa->id) && $lpa->id   > 0){
                $rethome    =   false;
            }else{
                $rethome    =   true;
            }
        }else{
            $rethome    =   true;
        }
        if($rethome == true) {
            return $this->redirect(['controller'=>'pages','action' => 'display']);
        } 
        $id = $lpa['LandingPages'][0]->id;
        $landingPage = $this->LandingPages->get($id, [
			'contain' => ['Campaigns', 'Vendors', 'MasterTemplates', 'LandingForms','Vendors.VendorManagers.Users']
		]);
        $vendor_email   =   $landingPage['vendor']['vendor_managers'][0]['user']->email;
        $vendor_name   =   $landingPage['vendor']['vendor_managers'][0]['user']->full_name;
        $landingForm = $this->LandingForms->newEntity($this->request->data);
        if ($this->request->is('post')) {
                if ($this->LandingForms->save($landingForm)) {
                        if($landingPage->chk_frm_submission ==   'Y' && is_file(WWW_ROOT  .'files' . DS .'landingpages'.DS.$landingPage->downloadable_item) && isset($landingForm->email_address) && '' !=trim($landingForm->email_address)){
                            /*
                             * Section to send downloadable item in  e-mail
                             */
                            $this->Prmsemails->sendLandingPageResource($landingForm->email_address,null,WWW_ROOT  .'files' . DS .'landingpages'.DS.$landingPage->downloadable_item,$vendor_email,$vendor_name);
                        }
                        $this->Flash->success('The landing page form has been saved.');
                        return $this->redirect(['controller'=>'LandingPages','action' => 'view',$id]);
                } else {
                        $this->Flash->error('The landing page form could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                }
        }
        
        
        $viewhtml   =   $landingPage['master_template']->content;
        $viewhtml   =   str_replace('[*!HEADING!*]',$landingPage->heading, $viewhtml);
        $viewhtml   =   str_replace('[*!BODYTEXT!*]',$landingPage->body_text, $viewhtml);
        $viewhtml   =   str_replace('[*!FRMHEADING!*]',$landingPage->form_heading, $viewhtml);
        $viewhtml   =   str_replace('[*!FOOTERTEXT!*]',$landingPage->footer_text, $viewhtml);
        /*
         * Section for external menu
         */
        $ext_menu   =   json_decode($landingPage->external_links);
        $mnu_str    =   '';
        if(!empty($ext_menu)){
            foreach($ext_menu as $mnu){
                $mnu_str    .=   '<a href="'.$mnu->url.'">'.$mnu->text.'</a>';
            }
        }
        $viewhtml   =   str_replace('[*!EXTERNALMENU!*]',$mnu_str, $viewhtml);
        $this->set('viewhtml', $viewhtml);
	$this->set('landingPage', $landingPage);
        $this->set('landingForm', $landingForm);
        $this->layout = 'ajax';
    }

}
