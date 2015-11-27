<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Cake\Routing\Router;
/**
 * PartnerCampaigns Controller
 *
 * @property App\Model\Table\PartnerCampaignsTable $PartnerCampaigns
 */
class PartnerCampaignsController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->loadModel('Campaigns');
        $this->loadModel('LandingForms');
        $this->loadModel('Financialquarters');
        $this->loadModel('PartnerViewTracks');
        $this->loadModel('BusinesplanCampaigns');
        $this->loadModel('CampaignPartnerMailinglists');
        $this->loadModel('CampaignPartnerMailinglistDeals');
        $this->loadModel('PartnerManagers');
        $this->loadModel('MasterTemplates');
        $this->loadModel('EmailTemplates');
        $this->loadModel('Partners');
		  $this->Auth->allow(['view']);

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
    public function availablecampaigns(){
        // Find financial quarters of vendor
        $quarters   =   $this->Financialquarters->find('all')
                            ->where(['vendor_id'=>$this->Auth->user('vendor_id'),'enddate >= '=>strtotime(date('Y-m-d H:i:s'))]);
        $qtr_id_array   = array();
        if(isset($quarters)&& !empty($quarters)){
            foreach ($quarters as $qt){
                $qtr_id_array[] =   $qt->id;
            }
        }
        // May be to find Campaigns assigned to partner
        $my_av_camp = array();
        $my_c_partner_cmp_id   = array();
        $my_c_partner_cmp    = $this->PartnerCampaigns->find('all')->where(['partner_id' =>$this->Auth->user('partner_id')]);
        if(isset($my_c_partner_cmp) && !empty($my_c_partner_cmp)){
            foreach($my_c_partner_cmp as $pc){
                $my_c_partner_cmp_id[]  =   $pc->campaign_id;
            }
            
        }
        // Find all campaigns of each financial quarter and not present in allocated plans...
        if(!empty($my_c_partner_cmp_id)){
            $avqr = $this->Campaigns->find('all')
                        ->hydrate(false)
                        ->where(['Campaigns.vendor_id' => $this->Auth->user('vendor_id'),'Campaigns.financialquarter_id IN '=>$qtr_id_array,'Campaigns.id NOT IN' => $my_c_partner_cmp_id]);
        }else{
            $avqr = $this->Campaigns->find('all')
                        ->hydrate(false)
                        ->where(['Campaigns.vendor_id' => $this->Auth->user('vendor_id'),'Campaigns.financialquarter_id IN '=>$qtr_id_array]);
        }
       
        $cmp_fltr   = array();
        foreach ($avqr as $aq){
            $cmp_fltr[] =   $aq['id'];   
        } //print_r( $cmp_fltr);exit;
        $this->paginate = [
			'contain' => ['Vendors', 'Financialquarters'],'conditions' => ['Campaigns.id IN ' => $cmp_fltr],
		];
        // Section to find all the campaigns already visited...
        $myviewedcamp   =   $this->PartnerViewTracks->find('all')
                                                    ->where(['partner_id'=>$this->Auth->user('partner_id'),'type'=>'campaign','campaign_id IN' => $cmp_fltr])
                                                    ->hydrate(false);
        $myviewedcampaignsarray = array();
        foreach($myviewedcamp as $mvcps){
            $myviewedcampaignsarray[]   =   $mvcps['campaign_id'];
        }
        /*
         * Section to find the campaign status as part of business plan
         */
        $mybpcamp   =   $this->BusinesplanCampaigns->find('all')
                                                    ->where(['campaign_id IN'=>$cmp_fltr,'Businesplans.partner_id'=>$this->Auth->user('partner_id')])
                                                    ->contain(['Businesplans'])
                                                    ->hydrate(false);
        
        $mybpcampaignsarray = array();
        $mybpstatus     =   array();
        $mybpdetails    =   array();
        foreach($mybpcamp as $mbps){
            $myviewedcampaignsarray[]   =   $mbps['campaign_id'];
            $mybpstatus[$mbps['campaign_id']]   =   $mbps['businesplan']['status'];
            $mybpdetails[$mbps['campaign_id']]  =   $mbps['businesplan']['id'];
        }
	$this->set('campaigns', $this->paginate($this->Campaigns));
        $this->set('myviewedcampaignsarray', $myviewedcampaignsarray);
        $this->set('mybpdetails', $mybpdetails);
        $this->set('mybpstatus', $mybpstatus);
        $this->set('mybpcampaignsarray', $mybpcampaignsarray);
    }
/**
 * Index method
 *
 * @return void
 */
	public function index() {
		$this->paginate = [
			'contain' => ['Partners', 'Campaigns'],
                        'conditions'=>['Partners.vendor_id'=>$this->Auth->user('vendor_id')]
		];
		$this->set('partnerCampaigns', $this->paginate($this->PartnerCampaigns));
                return $this->redirect(['controller' => 'PartnerCampaigns','action' => 'availablecampaigns']);
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function viewCampaign($id = null) {
		$campaign = $this->Campaigns->get($id, ['contain' => ['Vendors', 'Financialquarters','CampaignResources']]);
                $this->set('campaign', $campaign);
                $this->__insertViewTrack($id);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$partnerCampaign = $this->PartnerCampaigns->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->PartnerCampaigns->save($partnerCampaign)) {
				$this->Flash->success('The campaign has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The campaign could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$partners = $this->PartnerCampaigns->Partners->find('list');
		$campaigns = $this->PartnerCampaigns->Campaigns->find('list');
		$this->set(compact('partnerCampaign', 'partners', 'campaigns'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$partnerCampaign = $this->PartnerCampaigns->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$partnerCampaign = $this->PartnerCampaigns->patchEntity($partnerCampaign, $this->request->data);
			if ($this->PartnerCampaigns->save($partnerCampaign)) {
				$this->Flash->success('The campaign has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The campaign could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$partners = $this->PartnerCampaigns->Partners->find('list');
		$campaigns = $this->PartnerCampaigns->Campaigns->find('list');
		$this->set(compact('partnerCampaign', 'partners', 'campaigns'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
            $partnerCampaign = $this->PartnerCampaigns->get($id);
            $this->request->allowMethod('post', 'delete');
            if ($this->PartnerCampaigns->delete($partnerCampaign)) {
                    $this->Flash->success('The campaign has been deleted.');
            } else {
                    $this->Flash->error('The campaign could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
            }
            return $this->redirect(['action' => 'index']);
	}
        
        /*
         * Function to insert partner view track
         */
        function __insertViewTrack($cmp_id){
            $prtnr_id   =   $this->Auth->user('partner_id');
            if($cmp_id > 0){
                $vtrecords  = $this->PartnerViewTracks->find()
                                                      ->hydrate(false)
                                                      ->where(['campaign_id'=>$cmp_id,'partner_id'=>$prtnr_id])
                                                      ->first();
                if(isset($vtrecords['id'])&&$vtrecords['id'] > 0){
                    return false;
                    // Already exists a record in the tabe...
                }else{
                    $vrec               =   array();
                    $vrec['partner_id'] =   $prtnr_id;
                    $vrec['campaign_id']=   $cmp_id;
                    $vrec['type']       =   'Campaign';
                    $vrec['viewstatus'] =   'Viewed';
                    $partnerViewTracks  = $this->PartnerViewTracks->newEntity($vrec);
                    if ($this->PartnerViewTracks->save($partnerViewTracks)) {
                            return true;
                    }
                }
            }
            return false;  
        }
        /*
         * Function to list assigned campaigns to the partner.....
         */
        public function mycampaignslist(){
            $prtnr_id   =   $this->Auth->user('partner_id');
            $this->paginate = [
                    'contain' => ['Partners', 'Campaigns','Businesplans','Campaigns.Financialquarters'],
                    'conditions'=>['PartnerCampaigns.partner_id'=>$prtnr_id]
            ];
            $mycamp =   $this->PartnerCampaigns->find('all')->where(['partner_id'=>$prtnr_id]);
            $my_camp_arr    = array();
            foreach($mycamp as $cmps){
                $my_camp_arr[]  =   $cmps->campaign_id;
            }
            $my_camp_list   = $this->Campaigns->find('list')->where(['id IN' =>$my_camp_arr ]);
            $this->set('my_camp_list', $my_camp_list);
            
            // Top Deals Section
            $campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals->find('all')
                                                                                    ->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
                                                                                    ->order(['CampaignPartnerMailinglistDeals.deal_value'=>'DESC'])
                                                                                    ->where(['PartnerManagers.partner_id'=>$prtnr_id])
                                                                                    ->limit(5);
            $this->set('campaignPartnerMailinglistDeal',$campaignPartnerMailinglistDeal);
            $allcampdeals   =   $this->CampaignPartnerMailinglistDeals->find('all')
                                                                    ->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
                                                                    ->where(['PartnerManagers.partner_id'=>$prtnr_id])
                                                                    ->order(['CampaignPartnerMailinglistDeals.closure_date'=>'ASC']);
            $this->set('allcampdeals',$allcampdeals);
            $default_avtar_url  = Router::url('/img/img-gravatar-placeholder.png',true);
            //$this->set('default_avtar_url',$default_avtar_url);
             
        }
        public function ajaxcampaigndetails(){
             $this->loadModel('Campaigns');
             $this->layout = 'ajax';
             $prtnr_id   =   $this->Auth->user('partner_id');
             $campaigndetails = $this->Campaigns->get($this->request->data['campaign_id'], [
                             'contain' => ['Vendors', 'Financialquarters','CampaignResources']
                     ]);
             $getclickdt	=	$this->gettotalclickandopen($this->request->data['campaign_id']);
             if(!empty($getclickdt)){
                 $conversiondata                =   $getclickdt;
                 $conversiondata['bounce']	=	0;
                 
             }else{
                $conversiondata['click']	=	0;
	        $conversiondata['open']         =	0;
	        $conversiondata['bounce']	=	0;
	        $conversiondata['unsubscribe']	=	0;
             }
             //print_r($conversiondata);exit;
             $opstatistics  = $this->openstatistics($this->request->data['campaign_id']);
             if(!empty($opstatistics)){
                 $campstatics                =   $opstatistics;
                 
             }else{
                $campstatics['click']           =	0;
	        $campstatics['open']            =	0;
	        $campstatics['totalsend']	=	0;
                $campstatics['unsubscribe']	=	0;
             }
             
             if($campstatics['totalsend'] > 0){
                $campstatics['clickperc']          =   ($campstatics['click']/$campstatics['totalsend'])*100;
                $campstatics['openperc']           =   ($campstatics['open']/$campstatics['totalsend'])*100;
                $campstatics['unsubperc']          =   ($campstatics['unsubscribe']/$campstatics['totalsend'])*100;
             }else{
                $campstatics['clickperc']          =   0;
                $campstatics['openperc']           =   0;
                $campstatics['unsubperc']          =   0;
             }
             
             $this->set('campaigndetails', $campaigndetails);
             $this->set('conversiondata', $conversiondata);
             $this->set('campstatics', $campstatics);
             /*
              * Section for top 5 deals of the campaign.....
              */
            $campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals->find('all')
                                                                                    ->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
                                                                                    ->order(['CampaignPartnerMailinglistDeals.deal_value'=>'DESC'])
                                                                                    ->limit(5)
                                                                                    ->where(['CampaignPartnerMailinglists.campaign_id'=>$this->request->data['campaign_id'], 'PartnerManagers.partner_id'=>$prtnr_id]);
            $this->set('campaignPartnerMailinglistDeal',$campaignPartnerMailinglistDeal);
            $allcampdeals   =   $this->CampaignPartnerMailinglistDeals->find('all')
                                                                    ->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
                                                                    ->order(['CampaignPartnerMailinglistDeals.closure_date'=>'ASC'])
                                                                    ->where(['CampaignPartnerMailinglists.campaign_id'=>$this->request->data['campaign_id'], 'PartnerManagers.partner_id'=>$prtnr_id]);
            $this->set('allcampdeals',$allcampdeals);
            $default_avtar_url  = Router::url('/img/img-gravatar-placeholder.png',true);
            //$this->set('default_avtar_url',$default_avtar_url);
        }
         /*
         * Function to download file
         */
        public function downloadfile($id=null){
            $this->loadModel('CampaignResources');
            if($id!=null){
                $campaignResource = $this->CampaignResources->get($id);
		$this->request->allowMethod('post');
                $this->Filemanagement->download('campaignresources/'.$campaignResource->filepath,$campaignResource->title);
                return $this->redirect($this->referer());
            }
            return false;
        }
        public function gettotalclickandopen($cmpid=0){
	        $retarr =   array();
	        if($cmpid > 0){
                    $query = $this->CampaignPartnerMailinglists->find()->where(['partner_id'=>$this->Auth->user('partner_id'),'campaign_id'=>$cmpid]);
                    if(isset($query)){
                        $res    =   $query->select(['tclicks' => $query->func()->sum('clicks'),'topens'=>$query->func()->sum('opens')]);
                        foreach($res as $rs){
                            if(isset($rs->tclicks) && $rs->tclicks >0){
                                $retarr['click']    =	$rs->tclicks;
                            }
                            if(isset($rs->topens) && $rs->topens >0){
                                $retarr['open']    =	$rs->topens;
                            }
                        }
                    }
                    $query2 = $this->CampaignPartnerMailinglists->find()->where(['partner_id'=>$this->Auth->user('partner_id'),'campaign_id'=>$cmpid,'subscribe'=>'N']);
                    if(isset($query2)){
                        $res2    =   $query2->select(['unsubs' => $query->func()->count('*')]);
                        foreach($res2 as $rs2){
                            if(isset($rs2->unsubs) && $rs2->unsubs >0){
                                $retarr['unsubscribe']    =	$rs2->unsubs;
                            }

                        }
                    }
                    
                }
                return $retarr;
        }
        public function openstatistics($cmpid=0){
            $retarr =   array();
	    if($cmpid > 0){
                $query = $this->CampaignPartnerMailinglists->find()->where(['partner_id'=>$this->Auth->user('partner_id'),'campaign_id'=>$cmpid]);
                if(isset($query)){
                    $res    =   $query->select(['tclicks' => $query->func()->sum('clicks'),'topens'=>$query->func()->sum('opens'),'totalsend' => $query->func()->count('*')]);
                    foreach($res as $rs){
                        if(isset($rs->tclicks) && $rs->tclicks >0){
                            $retarr['click']    =	$rs->tclicks;
                        }
                        if(isset($rs->topens) && $rs->topens >0){
                            $retarr['open']    =	$rs->topens;
                        }
                         if(isset($rs->totalsend) && $rs->totalsend >0){
                            $retarr['totalsend']    =	$rs->totalsend;
                        }
                    }
                    $query2 = $this->CampaignPartnerMailinglists->find()->where(['partner_id'=>$this->Auth->user('partner_id'),'campaign_id'=>$cmpid,'subscribe'=>'N']);
                    if(isset($query2)){
                        $res2    =   $query2->select(['unsubs' => $query->func()->count('*')]);
                        foreach($res2 as $rs2){
                            if(isset($rs2->unsubs) && $rs2->unsubs >0){
                                $retarr['unsubscribe']    =	$rs2->unsubs;
                            }

                        }
                    }else{
                        $retarr['unsubscribe']    = 0;
                    }
                }
            }
            return $retarr;
        }
        
    /*
     * Function to show Email Online
     */
    public function view($id=0, $partnerid=NULL){
	    if ($partnerid>0) {
			$partner = $this->Partners->find()
		    ->where(['id' => $partnerid])
		    ->first();		

	    } elseif($this->Auth->user('partner_id')) {
			    $partner=$this->Auth->user();
		} 
	    

        $rethome    =   false;
        
        if($id >0){
            $edm    =   $this->EmailTemplates->get($id, [
			'contain' => ['Campaigns', 'Vendors', 'Vendors.VendorManagers.Users']
			]);
		} else {
			$rethome    =   true;
		}

	    $this->loadModel('MasterTemplates');

        $this->layout = 'ajax';

	    $mteplate   			=   $this->MasterTemplates->get($edm['master_template_id']);
	    $viewhtml   			=   $mteplate->content;
	
	
		if ($edm['use_templates'] != "Y") {
			$this->set('custom_code', $edm['custom_template']);
		}

        $viewhtml  =   $mteplate->content;
  
  /*
						  /*
							=====================================  
							START CONSISTENT MERGE FIELD CONTENT	
							=====================================  
						  */      
						        $viewhtml   =   str_replace('[*!SITE_URL!*]',$this->portal_settings['site_url'], $viewhtml); 
						        $viewhtml   =   str_replace('[*!WEBLINK!*]',$this->portal_settings['site_url'].'/partner_campaigns/view/'.$edm['id'].'/'.$partner['id'], $viewhtml); 
												        
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
	
		$this->set('code_subject_line', $edm[campaign][subject_line]);   
		//$viewhtml   =   str_replace('*|UNSUB:http://www.marketingconnex.com/pages/unsubscribe|*','#', $viewhtml);
        $viewhtml   =   preg_replace('|\*\|UNSUB(.*?)\|\*|i','#', $viewhtml);
        $this->set('viewhtml', $viewhtml);
		$this->set('bannerbgfilename', $edm['banner_bg_image']);
		$this->set('$ctafilename', $edm['cta_bg_image']);
/*      $this->set('landingForm', $landingForm);
        
        $this->set('vendor_name', $vendor_name);
        $this->set('campaign_desc', $campaign_desc);
    
    $this->set(compact('viewhtml','bannerbgfilename','ctatempfilename','editflag','editbannerimg','editctaimg'));
       */
     
        
    }
        
}
