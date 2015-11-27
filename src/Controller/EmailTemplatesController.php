<?php
	namespace App\Controller;
	
	use App\Controller\AppController;
	
	use Cake\Event\Event;

/**
 * EmailTemplates Controller
 *
 * @property App\Model\Table\EmailTemplatesTable $EmailTemplates
 */
 
class EmailTemplatesController extends AppController {

    public $components = ['Imagecreator', 'Campaignemails'];
    public function beforeFilter(Event $event) {
      parent::beforeFilter($event);
      $this->layout = 'admin';
      $this->loadModel('Campaigns');
      $this->loadModel('LandingPages');
      $this->loadModel('EmailTemplates');
      $this->Auth->allow('view');
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
    public function managemail($cmp_id=0){
      if($cmp_id < 1){
        return $this->redirect(['controller' => 'Campaigns','action' => 'index']);
      }
      $this->request->allowMethod('post', 'delete');
      $ema    =   $this->EmailTemplates->find()
      ->where(['campaign_id' => $cmp_id])
      ->first();
      if(isset($ema->id) && $ema->id   > 0){
        return $this->redirect(['action' => 'edit',$ema->id]);
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
		$vid    =   $this->Auth->user('vendor_id');

		
		if ($this->request->is(['ajax'])) { // upload zip
		
			$this->loadComponent('Extractzip');
			$upload_error   =   false;
			
			$vendor_id = $this->request->data['vendor_id'];
			$campaign_id = $this->request->data['campaign_id'];
			
			$allowed_resource_file_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
			$this->Filemanagement->allowed_resource_file_types = $allowed_resource_file_types;
			if (!empty($this->request->data['importzip']['tmp_name']) && $this->request->data['importzip']['error'] == '0' && in_array($this->request->data['importzip']['type'],$allowed_resource_file_types)) {
			
				$this->Filemanagement->mkdir_r(WWW_ROOT .'files'.DS.'temp_importemailtemplate');// create temp folder
				if($srcfile = $this->Filemanagement->uploadFiletoFolder($this->request->data['importzip'],'temp_importemailtemplate/')){ 
					if(isset($srcfile['success']) && $srcfile['success'] == 200){
						
						$zip = $this->Extractzip->extract($srcfile['filename'],false,$vendor_id,$campaign_id);
						
						if(isset($zip["message"]) && isset($zip['folder'])) {
							
							if(isset($zip["folderContainer"]) && $zip["folderContainer"] == "yes") {
								$old_name = 'temp_importemailtemplate'.DS.$zip['folder'];
								$new_name = "temp_importemailtemplate".DS."vendor-{$vendor_id}-campaign-{$campaign_id}";
							
								$this->Filemanagement->renameFolder($new_name,$old_name);
								
								$this->Filemanagement->recurse_copy(WWW_ROOT .'files'.DS.'temp_importemailtemplate',WWW_ROOT .'files'.DS.'importemailtemplate');// copy file folder
							}
							
							
							$this->Filemanagement->delete_dir(WWW_ROOT .'files'.DS.'temp_importemailtemplate'.DS);// delete file on temp folder
							echo 'success';
							
						}
						
						
						
					}else{
						unset($this->request->data['importzip']);
						$upload_error   =   true;
						$this->Flash->error($srcfile['msg']);
					}
              }else{
                  unset($this->request->data['importzip']);
                  $upload_error   =   true;
              }
				
				
			}else{
              $this->Flash->error('Sorry, file selected was not a valid zip file. Please try again. If you continue to experience problems, please contact Customer Support.');
              unset($this->request->data['importzip']);
              unset($this->request->data['importzip']);
			  $upload_error   =   true;
          }
			
			exit();
			
		}// end import email
		
		
		
		/*
		 * Section to find the related landing page
		 */
		 
		$cta_page_id   =   0;
		$ema    =   $this->LandingPages->find()
		->where(['campaign_id' => $cmp_id])
		->first();
		if(isset($ema->id) && $ema->id   > 0){
		  $cta_page_id   =   $ema->id;
		}
		$emailTemplate = $this->EmailTemplates->newEntity($this->request->data);
		if ($this->request->is('post')) {
			//echo $this->request->data['template']; exit;
			//print_r($emailTemplate); exit;
				if ($emailTemplate=$this->EmailTemplates->save($emailTemplate)) {
				$emailid = $emailTemplate->id;
				if ( $this->request->data['template']=="Y") {
					return $this->redirect(['controller'=>'EmailTemplates','action' => 'template',$cmp_id, $emailid]);
				} else {
					$this->Flash->success('The email template has been saved.');
					return $this->redirect(['controller'=>'Campaigns','action' => 'view',$cmp_id]);
				}
			} else {
				$this->Flash->error('The email template could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		
		$preview_image_name =   '';
		$this->set('preview_image_name', $preview_image_name);
		$campaigns = $this->EmailTemplates->Campaigns->find('list');
		$masterTemplates = $this->EmailTemplates->MasterTemplates->find('list')->where(['template_type' => 'email']);
		$this->set(compact('emailTemplate', 'campaigns', 'masterTemplates','cmp_id','vid','cta_page_id'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
 
	public function edit($id = null) {
		$emailTemplate = $this->EmailTemplates->get($id, [
			'contain' => []
		]);
		
				if ($this->request->is(['ajax'])) { // upload zip
			
			$this->loadComponent('Extractzip');
			$upload_error   =   false;
			
			$vendor_id = $this->request->data['vendor_id'];
			$campaign_id = $this->request->data['campaign_id'];
			
			$allowed_resource_file_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
			$this->Filemanagement->allowed_resource_file_types = $allowed_resource_file_types;
			if (!empty($this->request->data['importzip']['tmp_name']) && $this->request->data['importzip']['error'] == '0' && in_array($this->request->data['importzip']['type'],$allowed_resource_file_types)) {
			
				$this->Filemanagement->mkdir_r(WWW_ROOT .'files'.DS.'temp_importemailtemplate');// create temp folder
				if($srcfile = $this->Filemanagement->uploadFiletoFolder($this->request->data['importzip'],'temp_importemailtemplate/')){ 
					if(isset($srcfile['success']) && $srcfile['success'] == 200){
						
						$zip = $this->Extractzip->extract($srcfile['filename'],$id,$vendor_id,$campaign_id);
						
						if(isset($zip["message"]) && isset($zip['folder'])) {
							
							$old_name = 'temp_importemailtemplate'.DS.$zip['folder'];
							$new_name = "temp_importemailtemplate".DS."vendor-{$vendor_id}-campaign-{$campaign_id}";
						
							$this->Filemanagement->renameFolder($new_name,$old_name);
							
							$this->Filemanagement->recurse_copy(WWW_ROOT .'files'.DS.'temp_importemailtemplate',WWW_ROOT .'files'.DS.'importemailtemplate');// copy file folder
							
							$this->Filemanagement->delete_dir(WWW_ROOT .'files'.DS.'temp_importemailtemplate'.DS);// delete file on temp folder
							echo 'success';
							
						}
						
						
						
					}else{
						unset($this->request->data['importzip']);
						$upload_error   =   true;
						$this->Flash->error($srcfile['msg']);
					}
              }else{
                  unset($this->request->data['importzip']);
                  $upload_error   =   true;
              }
				
				
			}else{
              $this->Flash->error('Sorry, file selected was not a valid zip file. Please try again. If you continue to experience problems, please contact Customer Support.');
              unset($this->request->data['importzip']);
              unset($this->request->data['importzip']);
			  $upload_error   =   true;
			}
			
			exit();
			
		}// end import email
		
		
		
		
	    /*
	     * Section to find the related landing page
	     */
	    
	    $cta_page_id   =   0;
	    $ema    =   $this->LandingPages->find()
	                                   ->where(['campaign_id' => $emailTemplate->campaign_id])
                                     ->first();
	    if(isset($ema->id) && $ema->id   > 0){
	       $cta_page_id   =   $ema->id;
	    }
	    
	    /*
	     *  Banner background image upload
	     */
		$vid    =   $this->Auth->user('vendor_id');
		
	    $bgfilename = null;
	    $allwed_types = array('image/jpg','image/jpeg','image/png','image/gif');
	    if (!empty($this->request->data['banner_bg_image']['tmp_name']) && $this->request->data['banner_bg_image']['error'] == 0 && in_array($this->request->data['banner_bg_image']['type'],$allwed_types)) {
	      // Strip path information
	
	      $bgfilename = time().basename($this->request->data['banner_bg_image']['name']); 
	
	      if($this->Imagecreator->uploadImageFile($bgfilename,$this->request->data['banner_bg_image']['name'],$this->request->data['banner_bg_image']['tmp_name'],$this->request->data['banner_bg_image']['type'],WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'bgimages'.DS. $bgfilename,$this->request->data['banner_bg_image']['size'],600)){
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
		 *  Call-to-action (CTA) background image upload
		 */
		
		$ctafilename = null;
		if (!empty($this->request->data['cta_bg_image']['tmp_name']) && $this->request->data['cta_bg_image']['error'] == 0 && in_array($this->request->data['cta_bg_image']['type'],$allwed_types)) {
		  // Strip path information
		
		  $ctafilename = time().basename($this->request->data['cta_bg_image']['name']); 
		
		  if($this->Imagecreator->uploadImageFile($ctafilename,$this->request->data['cta_bg_image']['name'],$this->request->data['cta_bg_image']['tmp_name'],$this->request->data['cta_bg_image']['type'],WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'ctaimages'.DS. $ctafilename,$this->request->data['cta_bg_image']['size'],600)){
		      
		      $this->request->data['cta_bg_image'] = $ctafilename;
		  }else{
		      unset($this->request->data['cta_bg_image']);
		  }
		
		}else{
		  if(isset($this->request->data['cta_bg_image'])){
		      unset($this->request->data['cta_bg_image']);
		  } 
		}
		
		if(isset($this->request->data['ajaxedit_id'])){
		  unset($this->request->data['ajaxedit_id']);
		}
		
		
		if($this->request->data['cta_bg_image']!='')
		    $this->request->data['cta_bg_image'] = $this->request->data['cta_bg_image'];
		
		/*
		*  End of background image upload section
		*/
		if ($this->request->is(['patch', 'post', 'put'])) {
			$emailTemplate = $this->EmailTemplates->patchEntity($emailTemplate, $this->request->data);

				if ($emailTemplate=$this->EmailTemplates->save($emailTemplate)) {
					$emailid = $emailTemplate->id;
					if ( $this->request->data['template']=="Y") {
						return $this->redirect(['controller'=>'EmailTemplates','action' => 'edit_template',$emailTemplate->campaign_id, $emailid]);
					} else {
						$this->Flash->success('The email template has been saved.');
						return $this->redirect(['controller'=>'Campaigns','action' => 'view',$emailTemplate->campaign_id]);
					} 
				} else {
					$this->Flash->error('The email template could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
				}

		}

		$this->set('preview_image_name', $preview_image_name);
		$campaigns = $this->EmailTemplates->Campaigns->find('list');
		$masterTemplates = $this->EmailTemplates->MasterTemplates->find('list')->where(['template_type' => 'email']);
		$cmp_id = $emailTemplate->campaign_id;
		$this->set(compact('emailTemplate', 'campaigns', 'masterTemplates','cta_page_id','id','vid','cmp_id'));
	}
	
	
	public function ajaxSaveEmail($id) {
		  $this->layout = 'ajax';
		    if ($this->request->is(['post','ajax']))
		    {
				$data = $this->request;
			    $emailcode = $data['data']['email'];
			    $emailtemplate = $data['data']['template'];
			    
				$email_template = $this->EmailTemplates->get($id);
				$email_template = $this->EmailTemplates->patchEntity($email_template,['use_templates'=>'N', 'custom_template'=>$emailcode, 'template_override'=>$emailtemplate], ['validate' => false]);
				if($email_template = $this->EmailTemplates->save($email_template))
					echo 'success';
				else
					echo 'error';
				
		    }
		    die();
	}


	public function template($id) {
	  $this->layout = 'template';
	  
	}
	
	public function edit_template($id) {
	  $this->layout = 'edittemplate';
	  
	}
	
	public function ajaxLoadEmail($id=NULL) {
	      $this->loadModel('MasterTemplates');
		  $this->layout = 'ajax';
		    if ($this->request->is(['post','ajax']))
		    {
			    if ($id) {
				    //ID SPECIFIED SO TREAT AS AN EDIT
				    $master = $this->MasterTemplates->get(1);
				    $master_template = $this->EmailTemplates->get($id);
				    if ($master_template['template_override']!="") {
					    echo $master_template['template_override'];
				    } else {
					    //Just use first template as fallback
						echo $master['content'];			    
				    };
					//echo file_get_contents('http://marketingconnex.local.com:8888/tests/beefree/templates/test.php');		
				} else {
					//ID NOT SPECIFIED SO TREAT AS AN ADD				    
					$templateSelection = $this->request->data['data'];
				    $master = $this->MasterTemplates->get($templateSelection);
					echo $master['content'];
				}
		    }
		    die();
	}




/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
 
	public function delete($id = null) {
    $emailTemplate = $this->EmailTemplates->get($id);
    $this->request->allowMethod('post', 'delete');
    if ($this->EmailTemplates->delete($emailTemplate)) {
      $this->Flash->success('The email template has been deleted.');
    } else {
      $this->Flash->error('The email template could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
    }
    return $this->redirect(['action' => 'index']);
	}
	
    /*
     *  Preview the email template in the browser
     */
	
  public function ajaxpreviewbrowser(){
    $this->loadModel('MasterTemplates');
    $this->layout = 'ajax';
    $editflag       	=   false;
    $editbannerimg  	=   false;
    $editctaimg     	=   false;   
    if(isset($this->request->data['ajaxedit_id']) && $this->request->data['ajaxedit_id']>0){
      $edm  = $this->EmailTemplates->get($this->request->data['ajaxedit_id']);
      $editflag       =   true;
    }

    $mteplate   			=   $this->MasterTemplates->get($this->request->data['master_template_id']);
    $viewhtml   			=   $mteplate->content;


	/*
	=====================================  
	START UNIQUE MERGE FIELD CONTENT	
	=====================================  
	*/      
	    $viewhtml   =   str_replace('[*!SITE_URL!*]',$this->portal_settings['site_url'], $viewhtml); 
	    $viewhtml   =   str_replace('[*!WEBLINK!*]',$this->portal_settings['site_url'].'/partner_campaigns/view/'.$edm['id'].'/'.$partner['partner_id'], $viewhtml); 
						        
	    $viewhtml   =   str_replace('[*!HEADING!*]',$edm['heading'], $viewhtml);
	    $viewhtml   =   str_replace('[*!SUBJECTTEXT!*]',$edm['subject_text'], $viewhtml);
	    if ($edm['banner_text'] != '') {
	    $viewhtml   =   str_replace('[*!BANNERTEXT!*]',$edm['banner_text'], $viewhtml);
	    } else {
	    $viewhtml   =   str_replace('[*!BANNERTEXT!*]',' ', $viewhtml);
	    }
	    $viewhtml   =   str_replace('[*!BODYTEXT!*]',$edm['body_text'], $viewhtml);
	    $viewhtml   =   str_replace('[*!FEATUREHEADING!*]',$edm['features_heading'], $viewhtml);
	    $viewhtml   =   str_replace('[*!FEATURES!*]',$edm['features'], $viewhtml);
	    $viewhtml   =   str_replace('[*!CTATEXT!*]','<a href="'.$edm['cta_url'].'">'.$edm['cta_text'].'</a>', $viewhtml);
	    $viewhtml   =   str_replace('[*!PARTNERNAME!*]',$partner['company_name'], $viewhtml); 
	    //$viewhtml   =   str_replace('*|UNSUB:http://www.marketingconnex.com/unsub|*', '#', $viewhtml);
	    //$viewhtml   =   preg_replace('|\*\|UNSUB(.*?)\|\*|i','#', $viewhtml);
	
	    if($partner['logo_url']){
	        $plogo      =    '<img src="'.$partner['logo_url'].'" height="60" width="100" class="left"/>';
	        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
	    } else {
	        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]','', $viewhtml);
	    }

	     /*
	     *  Banner BG
	     */
	   
	    $bannerbgfilename = null;
	    $allwed_types = array('image/jpg','image/jpeg','image/png','image/gif');
	    if (!empty($this->request->data['banner_bg_image']['tmp_name']) && $this->request->data['banner_bg_image']['error'] == 0 && in_array($this->request->data['banner_bg_image']['type'],$allwed_types)) {
	        // Strip path information
	
	        $bgfilename = time().basename($this->request->data['banner_bg_image']['name']); 
	
	        if($this->Imagecreator->uploadImageFile($bgfilename,$this->request->data['banner_bg_image']['name'],$this->request->data['banner_bg_image']['tmp_name'],$this->request->data['banner_bg_image']['type'], WWW_ROOT  .'img' . DS . 'tmppreview' . DS .'bgimages'.DS.$bgfilename, $this->request->data['banner_bg_image']['size'],600)){
	            $bannerbgfilename = $bgfilename;
				$bannerbgimage   =   '<img src="/img' . DS . 'tmppreview' . DS .'bgimages'.DS.$bannerbgfilename.'" alt="Banner" width="auto" height="auto"/>';
	        }
	
	    } elseif(true == $editflag){
	        if(isset($edm->banner_bg_image) && $edm->banner_bg_image != ''){
	            $bannerbgfilename   = $edm->banner_bg_image;
	            $editbannerimg      =   true;
				$bannerbgimage   =   '<img src="/img/emailtemplates' . DS .'bgimages'.DS.$edm->banner_bg_image.'" alt="Banner" width="auto" height="auto"/>';
	        }
	    }
	    
	    $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
	 
	    if($this->request->data['banner_bg_image_stored']!='')
	        $bannerbgfilename = $this->request->data['banner_bg_image_stored'];
	
	            
	    /*
	     *  Upload temporary CTA image
	     */
	     
	    $ctatempfilename = null;
	    if (!empty($this->request->data['cta_bg_image']['tmp_name']) && $this->request->data['cta_bg_image']['error'] == 0 && in_array($this->request->data['cta_bg_image']['type'],$allwed_types)) {
        // Strip path information
	
	        $ctafilename = time().basename($this->request->data['cta_bg_image']['name']); 
	        if($this->Imagecreator->uploadImageFile($ctafilename,$this->request->data['cta_bg_image']['name'],$this->request->data['cta_bg_image']['tmp_name'],$this->request->data['cta_bg_image']['type'], WWW_ROOT  .'img' . DS . 'tmppreview' . DS .'ctaimages'.DS.$ctafilename,$this->request->data['cta_bg_image']['size'],100)){
	            $ctatempfilename = $ctafilename;
	        }
		

	    } elseif(true == $editflag){
	        if(isset($edm->cta_bg_image) && $edm->cta_bg_image != ''){
	            $ctatempfilename   =   $edm->cta_bg_image;
	            $editctaimg        =   true;
	        }
	    }

	
	  /*
		=====================================  
		END UNIQUE MERGE FIELD CONTENT	
		=====================================  
	  */      
     
     $this->set(compact('viewhtml','bannerbgfilename','ctatempfilename','editflag','editbannerimg','editctaimg'));
	
  }
  
  public function customajaxpreviewbrowser(){
    $this->layout = 'ajax';
    $this->loadModel('Partners');
   
    if(isset($this->request->data['custom_template']) && $this->request->data['custom_template']!= ''){
        $viewhtml   =   $this->request->data['custom_template'];
        
        $partner = $this->Partners->find()->where(['vendor_id'=>$this->Auth->user('vendor_id')])->first();
        if($partner->logo_url!= ''){
	        $plogo      =    '<img src="'.$partner->logo_url.'" height="60" width="100" class="right"/>';
	        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
	    } else {
	        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]','<img src="http://placehold.it/100x60" width="auto" height="auto"/>', $viewhtml);
	    }

	    if($this->request->data['cta_url'])
	    	if($this->request->data['cta_text'])
	    		$viewhtml   =   str_replace('[*!CTATEXT!*]','<a href="'.$this->request->data['cta_url'].'">'.$this->request->data['cta_text'].'</a>', $viewhtml);
	    	else
	    		$viewhtml   =   str_replace('[*!CTATEXT!*]',$this->request->data['cta_url'], $viewhtml);

    }else{
        $viewhtml   =   '';
    }

    //print_r($this->request->data);die();
    
    $this->set(compact('viewhtml'));
  }
  
  

    /*
     * Function to show Email Online
     */
    public function view($id=0, $partnerid=0){
	    
       $rethome    =   false;
        if($id >0){
            $edm    =   $this->EmailTemplates->get($id, [
				'contain' => ['Campaigns', 'Vendors', 'Vendors.VendorManagers.Users']
			]);
			
			if(isset($edm->id) && $edm->id   > 0){
			    $rethome    =   0;
			} else{
				$rethome    =   1;
			}
		} else {
			$rethome    =   1;
		}
		
		if($rethome != 0) {
		//return $this->redirect(['controller'=>'pages','action' => 'display']);
			return $this->redirect($this->referer());
		} 
		
//		print_r($edm[campaign][name]); exit;
		

	    $this->loadModel('MasterTemplates');
	     $this->loadModel('Partners');
        $this->layout = 'ajax';

	    $viewhtml   			=   $mteplate->content;
	
		$this->set('custom_code', $edm['custom_template']);
		
		if ($partnerid > 0) {
		
			$partner = $this->Partners->find()
			    ->where(['id' => $partnerid])
			    ->first();		
		
		}

	

   		$this->set('code_subject_line', $edm[campaign][subject_line]);   
		//$viewhtml   =   str_replace('*|UNSUB:http://www.marketingconnex.com/pages/unsubscribe|*','#', $viewhtml);
		$viewhtml   =   preg_replace('|\*\|UNSUB(.*?)\|\*|i','#', $viewhtml);
        $this->set('viewhtml', $viewhtml);

        
    }

  
  
}
