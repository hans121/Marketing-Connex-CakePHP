<?php
namespace App\Controller;
use App\Controller\AppController;

use Cake\Event\Event;
use JTEmail;
use Mandrill;
use Cake\Routing\Router;
use Abraham\TwitterOAuth\TwitterOAuth;
/**
 * PartnerCampaignEmailSettings Controller
 *
 * @property App\Model\Table\PartnerCampaignEmailSettingsTable $PartnerCampaignEmailSettings
 */
class PartnerCampaignEmailSettingsController extends AppController {
	public $twitterConnect = NULL;
	public $linkedinhttp = NULL;
	public $requestToken = NULL;
	public $twitterUrl = NULL;
	public	$consumerKey='7oE1VeQjURjH9ZksRFbGzc7sT';
	public	$consumerSecret='qHtJtWiYrZwXUyIVMC15MCb8RpcRNmgLhskvFdpDwpkHoPuwUO';
	public	$token = '529419126-tmYSipKzaHlfIfNL3DNCOWszZM8mUiuuWeiEWn31';
	public	$tokenSecret = 'hyp5RbyPc86HsaEWwNs67azjD412sNPeGCloVGChW4oLb';

        public function beforeFilter(Event $event) {
            parent::beforeFilter($event);
            $this->layout = 'admin';
            $this->loadModel('Campaigns');
			$this->loadModel('Partners');
            $this->loadModel('PartnerCampaigns');
            $this->loadModel('CampaignPartnerMailinglists');
            $this->loadModel('EmailTemplates');
            $this->loadModel('LandingPages');
            $this->loadModel('PartnerManagers');
            $this->loadModel('VendorManagers');
            $this->loadModel('PartnerMailinglistGroups');
            $this->loadModel('PartnerMailinglists');
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

            }elseif(isset($user['role']) && $user['role'] === 'partner') {
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
        	'contain' => ['Partners', 'Campaigns', 'EmailTemplates'],
        	'conditions'=>['PartnerCampaignEmailSettings.partner_id'=>$this->Auth->user('partner_id')]
        	];
        
        	$id =   $this->Auth->user('partner_id');
		$partner = $this->Partners->get($id);
		
        $this->set('partner',$partner);
        $this->set('partnerCampaignEmailSettings', $this->paginate($this->PartnerCampaignEmailSettings));
        
        } 
	
	public function allowAutoTweet() {
		//$partnerCampaignEmailSetting =  $this->Auth->user('partner_id');
		$id =   $this->Auth->user('partner_id');
		$partnerCampaignEmailSettings = $this->Partners->get($id);
		
		if ($this->request->is(['post', 'put'])) {
		
			$partner = $partnerCampaignEmailSettings;
			
			if($this->request->data['allow_auto_tweet'] ==1) {
				$this->request->data['allow_auto_tweet'] = 1;
			}else {
				$this->request->data['allow_auto_tweet'] = 0;
			}
			
			$partner = $this->Partners->patchEntity($partner, $this->request->data);
			 if($this->Partners->save($partner)) {
				$this->redirect(['controller' => 'PartnerCampaignEmailSettings','action'=>'index']);
				$this->Flash->success('Settings has been saved!');
			 }
		}
		
		$this->set('partnerCampaignEmailSettings', $partnerCampaignEmailSettings);
		
		
	}
/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$partnerCampaignEmailSetting = $this->PartnerCampaignEmailSettings->get($id, [
			'contain' => ['Partners', 'Campaigns', 'EmailTemplates', 'CampaignPartnerMailinglists']
		]);
		$this->set('partnerCampaignEmailSetting', $partnerCampaignEmailSetting);
	}
	public function twitterInit() {
		$this->loadComponent('Socialmedia');
		$init = $this->Socialmedia->twitter_initialize();
		//return $this->redirect($init);
	}
/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$base_url = Router::url('/',true);
		
		$defaultList = $this->PartnerMailinglistGroups->find()->where(['is_default'=>'1','partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')]);
		if($defaultList->count()==0)
		{
			$this->Flash->error('You may not add emails until you have created a default mailing list, please add a default mailing list here.');
			return $this->redirect(['controller'=>'PartnerMailinglistGroups','action' => 'index']);
		}
		else 
		{
			$defaultList = $defaultList->first();
			$lists = $this->PartnerMailinglists->find()->where(['partner_mailinglist_group_id'=>$defaultList->id]);
			if($lists->count()==0)
			{
				$this->Flash->error('You may not add emails until you have added contacts to your default list, please add contacts here.');
				return $this->redirect(['controller'=>'PartnerMailinglists','action' => 'show', $defaultList->id]);
			}
		}
		
		//Begin Socialmedia code
		if(!$this->request->is('post'))
		{
			$this->loadComponent('Socialmedia');
			
			$facebook_isauth = $this->Socialmedia->facebook_isauth();
			$twitter_isauth = $this->Socialmedia->twitter_isauth();
			$linkedin_isauth = $this->Socialmedia->linkedin_isAuth();
				
			$linkedin_companies = $linkedin_isauth?$this->Socialmedia->linkedin_getCompanies():'';
			
			$facebook_pages = $facebook_isauth?$this->Socialmedia->search_fb_pages():'';
			
			// estimate next email_template id
			$edm_id = 1;
			$email_templates = $this->EmailTemplates->find()->order(['id'=>'desc']);
			if($email_templates->count())
			{
				$email_template = $email_templates->first();
				$edm_id = $email_template->id + 1;
			}
			//end
			
			$email_url = $base_url.'e/'.$edm_id;
		
			$this->set(compact('linkedin_isauth','linkedin_companies','twitter_isauth','email_url','facebook_isauth','facebook_pages'));
		}
		else // is post
		{
			if(($cnt_comp = count($this->request->data['linkedin_companies']))>0)
			{
				$this->request->data['linkedin_companies'] = implode(',',$this->request->data['linkedin_companies']);
			}
			if(($cnt_fb_pages = count($this->request->data['facebook_pages']))>0){
				$this->request->data['facebook_pages'] = implode(',',$this->request->data['facebook_pages']);
			}
		}
		//End Socialmedia code
		
				$pcamparr       =   array();
                $pcampaigns   	= $this->PartnerCampaigns->find('all')
                                            ->contain(['Campaigns'])
                                            ->where(['Campaigns.html'=>'Y','PartnerCampaigns.partner_id'=>$this->Auth->user('partner_id')]);
                if(isset($pcampaigns) && !empty($pcampaigns)){
                    foreach($pcampaigns as $cmps){
                        /*
                         * Section to check whether already created.....
                         */
                        $curcmp     = $this->PartnerCampaignEmailSettings->find()->where(['partner_campaign_id'=>$cmps->id])->first();
                        if(isset($curcmp->id) && $curcmp->id > 0){
                           ; 
                        }else{
                           $pcamparr[] =   $cmps->campaign_id; 
                        }


                    }
                }
                
                if(empty($pcamparr)){
                    $this->Flash->error('There are no campaigns to create email settings for');
                    return $this->redirect(['action' => 'index']);
                }
                
                $campaigns  = $this->Campaigns->find('list')
                                                    ->where(['id IN'=>$pcamparr]);
                if(isset($this->request->data['campaign_id'])){
                    $emtmplt    =   $this->EmailTemplates->find()->where(['campaign_id'=>$this->request->data['campaign_id']])->first();
					
                    if(isset($emtmplt->id)){
                        $this->request->data['email_template_id'] =   $emtmplt->id;
                        if($emtmplt->spam=='Y')
                        {
                          $this->Flash->error('You may not add emails until the campaign email template is verified, please contact Customer Support.');
                          return $this->redirect(['action' => 'index']);
                        }
                    }
                    else
                    {
                      $this->Flash->error('You may not add emails to a cmapaign with no set email template which is verified, please contact Customer Support.');
                      return $this->redirect(['action' => 'index']);
                    }

                    $pcampaigns   = $this->PartnerCampaigns->find()->where(['campaign_id'=>$this->request->data['campaign_id'],'partner_id'=>$this->Auth->user('partner_id')])->first();
                    if(isset($pcampaigns->id)){
                        $this->request->data['partner_campaign_id'] =   $pcampaigns->id;
                    }
                }
                $sndnowflag =   false;
                if(isset($this->request->data['status']) && $this->request->data['status'] =='sent'){
                    $this->request->data['status'] = 'draft';
                    $sndnowflag =   true;
                }
                $partnerCampaignEmailSetting = $this->PartnerCampaignEmailSettings->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($pces=$this->PartnerCampaignEmailSettings->save($partnerCampaignEmailSetting)) {
				
				// Begin importing list from default list
				$defaultList = $this->PartnerMailinglistGroups->find()->where(['is_default'=>'1','partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')])->first();
				$partnerList = $this->PartnerMailinglists->find()->where(['partner_mailinglist_group_id'=>$defaultList->id,'partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status'=>'Y']);
				foreach($partnerList as $list)
				{
					$campaignList = $this->CampaignPartnerMailinglists->newEntity(['partner_id'=>$pces->partner_id,'campaign_id'=>$pces->campaign_id,'vendor_id'=>$this->Auth->user('vendor_id'),'partner_campaign_id'=>$pces->partner_campaign_id,'first_name'=>$list->first_name,'last_name'=>$list->last_name,'email'=>$list->email,'mandrillemailid'=>$list->mandrillemailid,'participate_campaign'=>'Y','subscribe'=>'Y','status'=>'Y','partner_campaign_email_setting_id'=>$pces->id]);
					$this->CampaignPartnerMailinglists->save($campaignList);
				}
				// End import
				
				if($sndnowflag == true){
                                    if($sent=$this->sentCampaignmail($pcampaigns->id)){
                                        $data['status'] =   'sent';
                                        $partnerCampaignEmailSettingnew = $this->PartnerCampaignEmailSettings->get($pces->id);
                                        $partnerCampaignEmailSettingnew = $this->PartnerCampaignEmailSettings->patchEntity($partnerCampaignEmailSettingnew, $data);
                                        $pces = $this->PartnerCampaignEmailSettings->save($partnerCampaignEmailSettingnew);
                                        
                                        // Linkedin Post to Personal and Company
                                        $this->loadComponent('Socialmedia');
                                        
                                        if($pces->post_linkedin=='1')
                                        {
                                        	$linkedin_text = $pces->linkedin_text;
                                        	$linkedin_text = str_replace('[*!EMAILURL!*]',$base_url.'e/'.$pces->email_template_id, $linkedin_text);
                                        	if($pces->linkedin_personal=='1')
                                        		$resp = $this->Socialmedia->linkedin_postPersonal($linkedin_text);
                                        
	                                        $linkedin_companies = explode(',',$pces->linkedin_companies);
	                                        if(count($linkedin_companies)>0)
	                                        	foreach($linkedin_companies as $linkedin_company)
	                                        		$resp = $this->Socialmedia->linkedin_postCompany($linkedin_company,$linkedin_text);
                                        }
                                        // End Linkedin Post
                                        //Start Twitter Post
										 if($pces->post_tweet=='1'){
										 	$tweet_text = $pces->tweet_text;
										 	$tweet_text = str_replace('[*!EMAILURL!*]',$base_url.'e/'.$pces->email_template_id, $tweet_text);
											$resp = $this->Socialmedia->twitter_tweet($tweet_text);

										 }
										// End Twitter Post
										//Start FB Post 
										if($pces->post_facebook=='1'){
											$facebook_text = $pces->facebook_text;

											$facebook_link = $base_url.'e/'.$pces->email_template_id;
											$facebook_text = str_replace('[*!EMAILURL!*]',$facebook_link, $facebook_text);
																			
											if($pces->facebook_personal=='1')
												$resp = $this->Socialmedia->facebook_post($facebook_text,$facebook_link);
																								
											$facebook_pages = explode(',',$pces->facebook_pages);
											if(count($facebook_pages)>0){
												foreach($facebook_pages as $facebook_page){
													$page_data = explode(':',$facebook_page);
													$resp = $this->Socialmedia->post_facebook_pages($page_data[0],$page_data[1],$facebook_text,$facebook_link);
												}
											}
										 }
										 // End FB Post	
								
										 $this->Flash->success('Your email has been sent to '.$sent.' recipients from your campaign mailinglist');
										 
                                    }else{
                                        $this->Flash->error('Your email settings have been saved, but we couldn\'t send the email. Please try again. If you continue to experience problems, please contact Customer Support.' );    
                                    }
                                }else{
                                    $this->Flash->success('Your email settings have been saved.');
                                }
                                
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('Your email settings could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
			/*
			 * Check the domains DKIM and SPF records
			 */
/*
			try {
				$mandrill = new Mandrill($this->portal_settings['mandrill_key']);
				$domain = substr(strrchr($this->request->data['from_email'], "@"), 1);
				$result = $mandrill->senders->addDomain($domain);
				print_r($result);
			} catch(Mandrill_Error $e) {
				echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
				throw $e;
			}
			try {
				$mandrill = new Mandrill($this->portal_settings['mandrill_key']);
				$domain = substr(strrchr($this->request->data['from_email'], "@"), 1);
				$result = $mandrill->senders->checkDomain($domain);
				print_r($result);
			} catch(Mandrill_Error $e) {
				echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
				throw $e;
			}
			*/
		}
	
        $option_campaigns = $this->Campaigns->find()
                                  ->contain(['EmailTemplates'])
                                  ->where(['id IN'=>$pcamparr]);
								  
		$this->set(compact('partnerCampaignEmailSetting','campaigns','option_campaigns'));
	
	}
	
	

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$base_url = Router::url('/',true);
		
		//Begin Socialmedia code
		if(!$this->request->is(['patch', 'post', 'put']))
		{
			$this->loadComponent('Socialmedia');
			
			$twitter_isauth = $this->Socialmedia->twitter_isauth();
			$facebook_isauth = $this->Socialmedia->facebook_isauth(); 
			$linkedin_isauth = $this->Socialmedia->linkedin_isAuth();
			 		
			$linkedin_companies = $linkedin_isauth?$this->Socialmedia->linkedin_getCompanies():'';
			$facebook_pages = $facebook_isauth?$this->Socialmedia->search_fb_pages():'';
						
			$this->set(compact('twitter_isauth','linkedin_isauth','linkedin_companies','facebook_isauth','facebook_pages'));
		}
		else // is post,patch,put
		{
			if(($cnt_comp = count($this->request->data['linkedin_companies']))>0)
			{
				$this->request->data['linkedin_companies'] = implode(',',$this->request->data['linkedin_companies']);
			}
			
			if(($cnt_fb_pages = count($this->request->data['facebook_pages']))>0){
				$this->request->data['facebook_pages'] = implode(',',$this->request->data['facebook_pages']);
			}
		}
		//End Socialmedia code
		
		$partnerCampaignEmailSetting = $this->PartnerCampaignEmailSettings->get($id);
			
		$email_url = $base_url.'e/'.$partnerCampaignEmailSetting->email_template_id;
			
		$this->set(compact('email_url'));
		
		if ($this->request->is(['patch', 'post', 'put'])) {
			if(isset($this->request->data['campaign_id'])){
	            $emtmplt    =   $this->EmailTemplates->find()->where(['campaign_id'=>$this->request->data['campaign_id']])->first();
	            if(isset($emtmplt->id)){
	                $this->request->data['email_template_id'] =   $emtmplt->id;
	            }
	            $pcampaigns   = $this->PartnerCampaigns->find()->where(['campaign_id'=>$this->request->data['campaign_id'],'partner_id'=>$this->Auth->user('partner_id')])->first();
	            if(isset($pcampaigns->id)){
	                $this->request->data['partner_campaign_id'] =   $pcampaigns->id;
	            }
	        }
	        $sntflag    =   false;
	        $snterrorflag    =   false;
	        if($this->request->data['status']== 'sent'){
	          /*
	           * Section to send email....
	           */
	          if($sent = $this->sentCampaignmail($pcampaigns->id)){
	            $sntflag    =   true;
	          } else {
	            $sntflag    =   false;
	            $snterrorflag    =   true;
	            $this->request->data['status']= 'draft';
	          }
	        }
        	$partnerCampaignEmailSetting = $this->PartnerCampaignEmailSettings->patchEntity($partnerCampaignEmailSetting, $this->request->data);
	        if ($pces = $this->PartnerCampaignEmailSettings->save($partnerCampaignEmailSetting)) {
				if($sntflag    ==   true){
					// Linkedin Post to Personal and Company
					$this->loadComponent('Socialmedia');
					
					if($pces->post_linkedin=='1')
					{
						$linkedin_text = $pces->linkedin_text;
						$linkedin_text = str_replace('[*!EMAILURL!*]',$base_url.'e/'.$pces->email_template_id, $linkedin_text);
						if($pces->linkedin_personal=='1')
							$resp = $this->Socialmedia->linkedin_postPersonal($linkedin_text);
					
						$linkedin_companies = explode(',',$pces->linkedin_companies);
						if(count($linkedin_companies)>0)
							foreach($linkedin_companies as $linkedin_company)
								$resp = $this->Socialmedia->linkedin_postCompany($linkedin_company,$linkedin_text);
					}
					// End Linkedin Post
					//Start Twitter Post
					if($pces->post_tweet=='1'){
						$tweet_text = $pces->tweet_text;
						$tweet_text = str_replace('[*!EMAILURL!*]',$base_url.'e/'.$pces->email_template_id, $tweet_text);
						$resp = $this->Socialmedia->twitter_tweet($tweet_text);
                        print_r("*********************");
                        var_dump($resp);
                        exit;
					}
					// End Twitter Post
					//Start FB Post 
					if($pces->post_facebook=='1'){
						$facebook_text = $pces->facebook_text;
	
						$facebook_link = $base_url.'e/'.$pces->email_template_id;
						$facebook_text = str_replace('[*!EMAILURL!*]',$facebook_link, $facebook_text);
															
						if($pces->facebook_personal=='1')

						$resp = $this->Socialmedia->facebook_post($facebook_text,$facebook_link);
																		
						$facebook_pages = explode(',',$pces->facebook_pages);
						if(count($facebook_pages)>0){
							foreach($facebook_pages as $facebook_page){
								$page_data = explode(':',$facebook_page);
								$resp = $this->Socialmedia->post_facebook_pages($page_data[0],$page_data[1],$facebook_text,$facebook_link);
							}
						}
					}
					// End FB Post
					
					
		            $this->Flash->success('Your email has been sent to '.$sent.' recipients from your campaign mailinglist');
		        }elseif($snterrorflag    ==   true){
		            $this->Flash->error('Your email settings have been saved, but we couldn\'t send the email. Please try again. If you continue to experience problems, please contact Customer Support.' );
		        }else{
		            $this->Flash->success('Your email settings have been saved');
		        }
		        
		        return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('Your email settings could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
    $pcamparr       =   array();
    $pcampaigns   = $this->PartnerCampaigns->find('all')
                         ->contain(['Campaigns'])
                         ->where(['Campaigns.html'=>'Y','PartnerCampaigns.partner_id'=>$this->Auth->user('partner_id')]);
		if(isset($pcampaigns) && !empty($pcampaigns)){
        foreach($pcampaigns as $cmps){
            /*
             * Section to check whether already created.....
             */
            $curcmp     = $this->PartnerCampaignEmailSettings->find()->where(['partner_campaign_id'=>$cmps->id])->first();
            if(isset($curcmp->id) && $curcmp->id > 0 && $curcmp->id != $id){
               ; 
            }else{
               $pcamparr[] =   $cmps->campaign_id; 
            }


        }
    }
    if(empty($pcamparr)){
        $this->Flash->error('There are no campaigns to create email settings for.');
        return $this->redirect(['action' => 'index']);
    }
    
    $campaigns  = $this->Campaigns->find('list')
                                  ->where(['id IN'=>$pcamparr]);
     $option_campaigns = $this->Campaigns->find()
                                  ->contain(['EmailTemplates'])
                                  ->where(['id IN'=>$pcamparr]);
		$this->set(compact('partnerCampaignEmailSetting', 'campaigns','option_campaigns'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$partnerCampaignEmailSetting = $this->PartnerCampaignEmailSettings->get($id);
		$this->request->allowMethod(['post', 'delete']);
		if ($this->PartnerCampaignEmailSettings->delete($partnerCampaignEmailSetting)) {
			$this->Flash->success('Your email settings have been deleted.');
		} else {
			$this->Flash->error('Your email settings could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
        public function ajaxpreviewemail(){
          $this->layout = 'ajax';   
          $viewhtml  		= '';
          $edm  =   array();
          if(isset($this->request->data['campaign_id']) && $this->request->data['campaign_id']>0) {
            $edm  = $this->EmailTemplates->find()
            ->contain(['MasterTemplates','Vendors'])
            ->where(['EmailTemplates.campaign_id'=>$this->request->data['campaign_id']])
            ->first();
            if(isset($edm['master_template']->content) && $edm->use_templates == 'Y'){
			  /*
				=====================================  
				START UNIQUE PREVIEW MERGE FIELD CONTENT	
				=====================================  
			  */      
	                $viewhtml  =   $edm['master_template']->content;

			        $viewhtml   =   str_replace('[*!SITE_URL!*]',$this->portal_settings['site_url'], $viewhtml); 
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
			        $viewhtml   =   str_replace('[*!VENDORNAME!*]',$edm['vendor']['company_name'], $viewhtml);
					//$viewhtml   =   str_replace('*|UNSUB:http://www.marketingconnex.com/unsub|*', '#', $viewhtml);
                   // $viewhtml   =   preg_replace('|\*\|UNSUB(.*?)\|\*|i','#', $viewhtml);
					$siteURL = $this->portal_settings['site_url'];
			
				  /*
					=====================================  
					END UNIQUE MERGE FIELD CONTENT	
					=====================================  
				  */      
                
            } elseif($edm->use_templates != 'Y' && $edm->custom_template != '') {
              $viewhtml   =   $edm->custom_template;
            }
             
          }
          $this->set(compact('viewhtml','emailTemplate', 'siteURL'));
          $this->set('emailTemplate', $edm);

          
        }
        public function ajaxpreviewlpg(){
            $this->layout = 'ajax';   
            $viewhtml  =   __('No landing page has been set');
            $lpgTemplate  =   array();
            if(isset($this->request->data['campaign_id']) && $this->request->data['campaign_id']>0){
                $lpgTemplate  = $this->LandingPages->find()
                                                        ->contain(['MasterTemplates','Vendors','LandingForms',])
                                                        ->where(['LandingPages.campaign_id'=>$this->request->data['campaign_id']])
                                                        ->first();
                if(isset($lpgTemplate['master_template']->content)){
                    $viewhtml  =   $lpgTemplate['master_template']->content;
                    $viewhtml   =   str_replace('[*!HEADING!*]',$lpgTemplate->heading, $viewhtml);
                    $viewhtml   =   str_replace('[*!BANNERTEXT!*]',$lpgTemplate->banner_text, $viewhtml);
                    $viewhtml   =   str_replace('[*!BODYTEXT!*]',$lpgTemplate->body_text, $viewhtml);
                    $viewhtml   =   str_replace('[*!FRMHEADING!*]',$lpgTemplate->form_heading, $viewhtml);
                    $viewhtml   =   str_replace('[*!FOOTERTEXT!*]',$lpgTemplate->footer_text, $viewhtml);
                        /*
                        * Section for external menu
                        */
                       $ext_menu   =   json_decode($lpgTemplate->external_links);
                       $mnu_str    =   '';
                       if(!empty($ext_menu)){
                           foreach($ext_menu as $mnu){
                               $mnu_str    .=   '<a href="'.$mnu->url.'">'.$mnu->text.'</a>';
                           }
                       }
                       $viewhtml   =   str_replace('[*!EXTERNALMENU!*]',$mnu_str, $viewhtml);
                }
               
            }   
            $this->set('viewhtml', $viewhtml);
            $this->set('landingPage', $lpgTemplate);
            
        }
        public function ajaxsenttestemail($emails=''){        	
	        
            $this->loadModel('Users');
            
            $user =   $this->Users->get($this->Auth->user('id'));

            $viewhtml  =   '';
            $emailTemplate  =   array();
            $image_url  = Router::url('/img/',true);
            
            if(isset($this->request->data['campaign_id']) && $this->request->data['campaign_id']>0){
                $edm  = $this->EmailTemplates->find()
                                                        ->contain(['MasterTemplates','Vendors'])
                                                        ->where(['EmailTemplates.campaign_id'=>$this->request->data['campaign_id']])
                                                        ->first();
                $partner = $this->Auth->user();
                
                if(isset($edm['master_template']->content) && $edm->use_templates == 'Y'){
                        $viewhtml  =   $edm['master_template']->content;
						  /*
							=====================================  
							START CONSISTENT MERGE FIELD CONTENT	
							=====================================  
						  */      
						        $viewhtml   =   str_replace('[*!SITE_URL!*]',$this->portal_settings['site_url'], $viewhtml); 
						        $viewhtml   =   str_replace('[*!WEBLINK!*]',$this->portal_settings['site_url'].'/partner_campaigns/view/'.$edm['id'].'/'.$partner['partner_id'], $viewhtml); 
												        
						        $viewhtml   =   str_replace('[*!HEADING!*]',$edm['heading'], $viewhtml);
						        $viewhtml   =   str_replace('[*!SUBJECTTEXT!*]',$edm['subject_text'], $viewhtml);
						        $viewhtml   =   str_replace('[*!BANNERTEXT!*]',$edm['banner_text'], $viewhtml);
						        $viewhtml   =   str_replace('[*!BODYTEXT!*]',$edm['body_text'], $viewhtml);
						        $viewhtml   =   str_replace('[*!FEATUREHEADING!*]',$edm['features_heading'], $viewhtml);
						        $viewhtml   =   str_replace('[*!FEATURES!*]',$edm['features'], $viewhtml);
						        $viewhtml   =   str_replace('[*!CTATEXT!*]','<a href="'.$edm['cta_url'].'">'.$edm['cta_text'].'</a>', $viewhtml);
						
						        $viewhtml   =   str_replace('[*!VENDORNAME!*]',$edm['vendor']['company_name'], $viewhtml);
						        $viewhtml   =   str_replace('[*!PARTNERNAME!*]',$partner['company_name'], $viewhtml); 
						        
						        if(isset($edm['vendor']['logo_url'])){
						            $vlogo      =    '<img src="'.$edm['vendor']['logo_url'].'" height="60" width="100" class="left"/>';
						            $viewhtml   =   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
						        } else {
						            $viewhtml   =   str_replace('[*!VENDORLOGO!*]','', $viewhtml);
						        }
						        
						        
						        
						        if(isset($edm['banner_bg_image'])&& $edm['banner_bg_image'] != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'bgimages'.DS.$edm['banner_bg_image'])){
						            $bannerbgimage   =   '<img src="'.$this->portal_settings['site_url'].'/img/emailtemplates' . DS .'bgimages'.DS.$edm['banner_bg_image'].'" alt="Banner" width="auto" height="auto"/>';
						            $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
						        } else {
						            $viewhtml   =   str_replace('[*!BANNERIMAGE!*]','', $viewhtml);
						        }
						        
						        if(isset($edm['cta_bg_image'])&& $edm['cta_bg_image'] != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'ctaimages'.DS.$edm['cta_bg_image'])){
						            $ctabgimage   =   '<a href="'.$edm['cta_url'].'"><img src="'.$this->portal_settings['site_url'].'/img/emailtemplates' . DS .'ctaimages'.DS.$edm['cta_bg_image'].'" alt="CTA Image"  width="auto" height="auto"/></a>';
						            $viewhtml   =   str_replace('[*!CTAIMAGE!*]',$ctabgimage, $viewhtml);
						        } else {
						            $viewhtml   =   str_replace('[*!CTAIMAGE!*]','', $viewhtml);
						        }
						        
						
						        if($partner['logo_url']){
						            $plogo      =    '<img src="'.$partner['logo_url'].'" height="60" width="100" class="left"/>';
						            $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
						        } else {
						            $viewhtml   =   str_replace('[*!PARTNERLOGO!*]','', $viewhtml);
						        }
						        
						
							  /*
								=====================================  
								END CONSISTENT MERGE FIELD CONTENT	
								=====================================  
							  */      
 
					if($emails=='')
					{
	                    $result = $this->sendmandrilltestpartner($viewhtml, $user->full_name, $user->email, $edm->subject_option1,$this->request->data['from_name'],$this->request->data['from_email'],$this->request->data['reply_to_email']);
	
	                    if(isset($result[0]['status']) && $result[0]['status'] == 'sent'){
	                        echo __('Test email has been sent to ').$user->email;
	                    }elseif(isset($result[0]['reject_reason'])&& $result[0]['reject_reason'] != ''){
	                        echo __($result[0]['reject_reason'].' Please contact Customer Support');
	                    }else{
	                        echo __('We couldn\'t send your test email. Please try again. If you continue to experience problems, please contact Customer Support.');
	                    }
					}
					else
					{
						$emails = explode(',',urldecode($emails));
						$failed = false;
						echo '<p>Your Test Email Sending Status:</p>';
						foreach($emails as $email)
						{
							$email = trim($email);
							$result = $this->sendmandrilltestpartner($viewhtml, '', $email, $edm->subject_option1,$this->request->data['from_name'],$this->request->data['from_email'],$this->request->data['reply_to_email']);
							
							if(isset($result[0]['status']) && $result[0]['status'] == 'sent'){
								echo '<p>'.$email.' (Sent)</p>';
							}elseif(isset($result[0]['reject_reason'])&& $result[0]['reject_reason'] != ''){
								echo '<p>'.$email.' (Failed: '.__($result[0]['reject_reason']).')</p>';
								$failed = true;
							}else{
								echo '<p>'.$email.' (Failed)</p>';
								$failed = true;
							}
						}
						if($failed===true)
							echo '<p>'.__('We couldn\'t send to recipients specified above. Please try again. If you continue to experience problems, please contact Customer Support.').'</p>';
						else
							echo '<p>'.__('We have successfully sent the test email to the specified recipients.').'</p>';
					}
                    
                }elseif($edm->use_templates != 'Y' && $edm->custom_template != ''){
                    $viewhtml   =   $edm->custom_template;
                    $result = $this->sendmandrilltestpartner($viewhtml, $user->full_name, $user->email, $edm->subject_option1,$this->request->data['from_name'],$this->request->data['from_email'],$this->request->data['reply_to_email']);
                    if(isset($result[0]['status']) && $result[0]['status'] == 'sent'){
                        echo __('Test email has been sent to ').$user->email;
                    }elseif(isset($result[0]['reject_reason'])&& $result[0]['reject_reason'] != ''){
                        echo __($result[0]['reject_reason'].' Please contact Customer Support');
                    }else{
                        echo __('We couldn\'t send your test email. Please try again. If you continue to experience problems, please contact Customer Support.');
                    }
                }else{
                    echo __('We couldn\'t find a valid email template for this campaign. If you continue to experience problems, please contact Customer Support.');
                    
                }
               exit;
            }
        }
        /*
        * Function to test mandrill integration...
        */
        public function sendmandrilltestpartner($vhtml=NULL,$toname=NULL,$toemail=NULL,$subject=NULL,$from_name=NULL,$from_email=NULL,$reply_email=NULL){
            if(NULL ==$from_email){
                $from_email =   $this->portal_settings['site_email'];
            }
            if(NULL ==$reply_email){
                $reply_email =   $this->portal_settings['site_email'];
            }
            if(NULL ==$from_name){
                $from_name  =   $this->portal_settings['site_name'];
            }
            $tobccemail='jipson@strategic-ic.co.uk';
            $tobccname='JT';

            
            $mandrill = new Mandrill($this->portal_settings['mandrill_key']);
            if($vhtml != NULL && $toemail !=NULL ){
                $message = array(
                    'html' => $vhtml,
                    'subject' => $subject,
                    'from_email' => $from_email,
                    'from_name' => $from_name,
                    'to' => array(
                        array(
                            'email' => $toemail,
                            'name' => $toname,
                            'type' => 'to'
                        )
                    ),
                    'headers' => array('Reply-To' => $reply_email),
                    'important' => false,
                    'track_opens' => true,
                    'track_clicks' => true,
                    'auto_text' => null,
                    'auto_html' => null,
                    'inline_css' => true,
                    'url_strip_qs' => null,
                    'preserve_recipients' => null,
                    'view_content_link' => null,
                    'tracking_domain' => null,
                    'signing_domain' => null,
                    'return_path_domain' => null,
                    'merge' => true,
                    'merge_language' => 'mailchimp',
                    'tags' => array('password-resets'),
                    'subaccount' => 'sic1',
                    'google_analytics_domains' => array('strategic-ic.co.uk'),
                    'google_analytics_campaign' => 'info@strategic-ic.co.uk',
                    'metadata' => array('website' => 'www.strategic-ic.co.uk'),

                );
                $async = false;
                $ip_pool = 'Main Pool';
                $send_at = date('Y-m-d H:i:s',strtotime('-1 days',time()));
                $result = $mandrill->messages->send($message, $async, $ip_pool);
                return $result;
            }   
            return false;
        }
        function sentCampaignmail($partner_campaign_id=0){
            $image_url  = Router::url('/img/',true);
            $retval =   false;
            if($partner_campaign_id > 0){ 
                $participants   = $this->CampaignPartnerMailinglists->find('all')->where(['partner_campaign_id'=>$partner_campaign_id,'participate_campaign'=>'Y','subscribe'=>'Y']);
                $totcurrentparticipants = $participants->count();
                $pcampaigndet   = $this->PartnerCampaigns->find()
                                                        ->contain(['Partners', 'Campaigns','PartnerCampaignEmailSettings','Campaigns.EmailTemplates','Campaigns.EmailTemplates.MasterTemplates','Campaigns.Vendors'])
                                                        ->where(['PartnerCampaigns.id'=>$partner_campaign_id])
                                                        ->first();
               
                if($totcurrentparticipants > $pcampaigndet['campaign']->send_limit){
                    /*
                     * Section to send notification emails to vendor and partner informing the no of participants exceed the the maximum allowed sends.......
                     */
                     //echo $pcampaigndet['campaign']->send_limit."=====".$totcurrentparticipants."--Test";exit;
                    $partnermngr    =   $this->PartnerManagers->find()->contain(['Users','Partners'])->where(['PartnerManagers.partner_id'=>$pcampaigndet->partner_id,'PartnerManagers.primary_contact'=>'Y'])->first();
                    $vendormngr     =   $this->VendorManagers->find()->contain(['Users','Vendors'])->where(['VendorManagers.vendor_id'=>$pcampaigndet['campaign']['vendor']->id,'VendorManagers.primary_manager'=>'Y'])->first();
                    $this->Prmsemails->notifycampaignlimitexceeds($vendormngr,$partnermngr,$pcampaigndet['campaign'],$totcurrentparticipants);
                    return false;
                }
                /*
                 * Section to create to email array...
                 */
                $to_part_array  =   array();$i=0;
                foreach($participants as $pc){
	                //print_r($pc->id); exit;
                    $to_part_array[$i]['name']= $pc->first_name.' '.$pc->last_name;
                    $to_part_array[$i]['email']= $pc->email;
                    $to_part_array[$i]['type']= 'to';
                    $to_part_array[$i]['mailing_list_id']= $pc->id;
                    $i++;
                }
                if(empty($to_part_array)){
                    return false; // As there is no valid participant to receive the email....
                }
                
                if(isset($pcampaigndet['partner_campaign_email_settings'][0]->id)){
                    /*
                     * Section to create email html 
                     */

                    if(isset($pcampaigndet['campaign']['email_templates'][0]['master_template']->content) && $pcampaigndet['campaign']['email_templates'][0]->use_templates == 'Y'){
			            $this->loadModel('Users');
                        $viewhtml  = $pcampaigndet['campaign']['email_templates'][0]['master_template']->content;
	
		                $edm  = $this->EmailTemplates->find()
                                                        ->contain(['MasterTemplates','Vendors'])
                                                        ->where(['EmailTemplates.campaign_id'=>$this->request->data['campaign_id']])
                                                        ->first();
	                   $partner = $this->Auth->user();
						
						  /*
							=====================================  
							START CONSISTENT MERGE FIELD CONTENT	
							=====================================  
						  */      
						        $viewhtml   =   str_replace('[*!SITE_URL!*]',$this->portal_settings['site_url'], $viewhtml); 
						        $viewhtml   =   str_replace('[*!WEBLINK!*]',$this->portal_settings['site_url'].'/partner_campaigns/view/'.$edm['id'].'/'.$partner['partner_id'], $viewhtml); 
												        
						        $viewhtml   =   str_replace('[*!HEADING!*]',$edm['heading'], $viewhtml);
						        $viewhtml   =   str_replace('[*!SUBJECTTEXT!*]',$edm['subject_text'], $viewhtml);
						        $viewhtml   =   str_replace('[*!BANNERTEXT!*]',$edm['banner_text'], $viewhtml);
						        $viewhtml   =   str_replace('[*!BODYTEXT!*]',$edm['body_text'], $viewhtml);
						        $viewhtml   =   str_replace('[*!FEATUREHEADING!*]',$edm['features_heading'], $viewhtml);
						        $viewhtml   =   str_replace('[*!FEATURES!*]',$edm['features'], $viewhtml);
						        $viewhtml   =   str_replace('[*!CTATEXT!*]','<a href="'.$edm['cta_url'].'">'.$edm['cta_text'].'</a>', $viewhtml);
						
						        $viewhtml   =   str_replace('[*!VENDORNAME!*]',$edm['vendor']['company_name'], $viewhtml);
						        $viewhtml   =   str_replace('[*!PARTNERNAME!*]',$partner['company_name'], $viewhtml); 
						        
						        if(isset($edm['vendor']['logo_url'])){
						            $vlogo      =    '<img src="'.$edm['vendor']['logo_url'].'" height="60" width="100" class="left"/>';
						            $viewhtml   =   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
						        } else {
						            $viewhtml   =   str_replace('[*!VENDORLOGO!*]','', $viewhtml);
						        }
						        
						        
						        
						        if(isset($edm['banner_bg_image'])&& $edm['banner_bg_image'] != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'bgimages'.DS.$edm['banner_bg_image'])){
						            $bannerbgimage   =   '<img src="'.$this->portal_settings['site_url'].'/img/emailtemplates' . DS .'bgimages'.DS.$edm['banner_bg_image'].'" alt="Banner" width="auto" height="auto"/>';
						            $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
						        } else {
						            $viewhtml   =   str_replace('[*!BANNERIMAGE!*]','', $viewhtml);
						        }
						        
						        if(isset($edm['cta_bg_image'])&& $edm['cta_bg_image'] != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'ctaimages'.DS.$edm['cta_bg_image'])){
						            $ctabgimage   =   '<a href="'.$edm['cta_url'].'"><img src="'.$this->portal_settings['site_url'].'/img/emailtemplates' . DS .'ctaimages'.DS.$edm['cta_bg_image'].'" alt="CTA Image"  width="auto" height="auto"/></a>';
						            $viewhtml   =   str_replace('[*!CTAIMAGE!*]',$ctabgimage, $viewhtml);
						        } else {
						            $viewhtml   =   str_replace('[*!CTAIMAGE!*]','', $viewhtml);
						        }
						        
						
						        if($partner['logo_url']){
						            $plogo      =    '<img src="'.$partner['logo_url'].'" height="60" width="100" class="left"/>';
						            $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
						        } else {
						            $viewhtml   =   str_replace('[*!PARTNERLOGO!*]','', $viewhtml);
						        }
						
							  /*
								=====================================  
								END CONSISTENT MERGE FIELD CONTENT	
								=====================================  
							  */      
							  ;
						///echo $viewhtml;               
                        //echo $unsuburl;
                        //exit;
                        
                    }elseif($pcampaigndet['campaign']['email_templates'][0]->use_templates != 'Y' && $pcampaigndet['campaign']['email_templates'][0]->custom_template != ''){
                        $viewhtml  =$pcampaigndet['campaign']['email_templates'][0]->custom_template;
                    }
                    
//                    echo $viewhtml;exit;
                }else{
                    return false;// There is no valid email settings to send the campaign....
                }
                //$pcampaigndet['campaign']['email_templates'][0][$pcampaigndet['partner_campaign_email_settings'][0]->subject_option],
                if($this->sendmanmail($partner_campaign_id,$viewhtml,$to_part_array,$pcampaigndet['campaign']['email_templates'][0][$pcampaigndet['partner_campaign_email_settings'][0]->subject_option],$pcampaigndet['partner_campaign_email_settings'][0]->from_name,$pcampaigndet['partner_campaign_email_settings'][0]->from_email,$pcampaigndet['partner_campaign_email_settings'][0]->reply_to_email)){
                    $retval=  $i>0?$i:true; // return number of recipients or true
                }
            }
            return $retval;
        }
        
        function sendmanmail($partner_campaign_id=0,$html=null,$topart=array(),$subject=NULL,$from_name=NULL,$from_email=NULL,$reply_email=NULL){
            if(NULL ==$from_email){
                $from_email =   $this->portal_settings['site_email'];
            }
            if(NULL ==$reply_email){
                $reply_email =   $this->portal_settings['site_email'];
            }
            if(NULL ==$from_name){
                $from_name  =   $this->portal_settings['site_name'];
            }

            $mandrill = new Mandrill($this->portal_settings['mandrill_key']);
            if($html != NULL && !empty($topart) ){
                $mergevaremail  =   array();
                $l=0;
                foreach($topart as $tp){
                    $mergevaremail[$l]['name']  =   'merge2';
                    $mergevaremail[$l]['content']  =   $tp['email'];
                    $l++;
                    /*
                     * 'global_merge_vars' => array(
                        array(
                            'name' => 'merge1',
                            'content' => 'merge1 content'
                        )
                    ),
                    'merge_vars' => array(
                        array(
                            'rcpt' => 'recipient.email@example.com',
                            'vars' => $mergevaremail
                        )
                    ),
                     */
                }
                $unsuburl       =   Router::url(['controller' => 'CampaignPartnerMailinglists', 'action' => 'unsubscribeme'], true); //,$partner_campaign_id, $tp['mailing_list_id']],true);
 				$html   =   str_replace('*|UNSUB|*', '*|UNSUB:'. $unsuburl.'|*', $html);

               // print_r($tp);
               // echo "<hr>";
               // echo $html;
               // exit;
                
                $message = array(
                    'html' => $html,
                    'subject' => $subject,
                    'from_email' => $from_email,
                    'from_name' => $from_name,
                    'to' => $topart,
                    'headers' => array('Reply-To' => $reply_email),
                    'important' => false,
                    'track_opens' => true,
                    'track_clicks' => true,
                    'auto_text' => null,
                    'auto_html' => true,
                    'inline_css' => true,
                    'url_strip_qs' => null,
                    'preserve_recipients' => null,
                    'view_content_link' => null,
                    'tracking_domain' => null,
                    'signing_domain' => null,
                    'return_path_domain' => null,
                    'merge' => true,
                    'merge_language' => 'mailchimp',
                    'tags' => array('password-resets'),
                    'subaccount' => 'sic1',
                    'google_analytics_domains' => array('marketingconnex.com'),
                    'google_analytics_campaign' => 'info@marketingconnex.com',
                    'metadata' => array('website' => 'www.marketingconnex.com'),

                );
                $async = false;
                $ip_pool = 'Main Pool';
                $send_at = date('Y-m-d H:i:s',strtotime('-1 days',time()));
                $result = $mandrill->messages->send($message, $async, $ip_pool);
                if($this->updateMailinglists($partner_campaign_id, $result)){
                    return true;
                }
            }
            return false;
        }
        
        public function updateMailinglists($partner_campaign_id=0,$results=array()){
            if(!empty($results) && $partner_campaign_id > 0){
                foreach($results as $res){
                    //print_r($res);exit;
                    if($res['status'] == 'sent'){
	                    
                        /*
                         * Section to update campaign partner mailing list table...
                         */
                         
                        $Cquery = $this->CampaignPartnerMailinglists->query();
                        $Cquery->update()
                            ->set(['mandrillemailid' =>$res['_id']])
                            ->where(['partner_campaign_id' =>  $partner_campaign_id,'email'=>$res['email'],'participate_campaign'=>'Y','subscribe'=>'Y'])
                            ->execute();
                    }
                }
                return true;
            }
            return false;
        }
}
