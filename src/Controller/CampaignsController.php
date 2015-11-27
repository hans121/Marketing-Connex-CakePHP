<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Routing\Router;
use Mandrill;
use JTEmail;
use Cake\Network\Email\Email;
/**
 * Campaigns Controller
 *
 * @property App\Model\Table\CampaignsTable $Campaigns
 */
class CampaignsController extends AppController {
    //public $helpers = ['ColorPicker'];
	public $components = ['Imagecreator', 'Campaignemails'];
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin--ui';
        $this->loadModel('Financialquarters');
        $this->loadModel('Vendors');
        $this->loadModel('SubscriptionPackages');
        $this->loadModel('LandingPages');
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
            
        }elseif (isset($user['role']) && $user['role'] === 'vendor') {
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
    public function index($fqt=0,$chksendlimit=0) {
        $prompt_upgrade =   0;
                $send_details   =   array();
                if($chksendlimit > 0 && $fqt > 0){
                    /*
                     * Section to find the send limit used by vendor. If it is more than 50% of the maximum allowed vendor will prompt to upgrade the package..
                     */
                    $send_details   = $this->__checkUsedSendlimit($fqt);
                    if($send_details['usage_perc'] > 50){
                        $prompt_upgrade = 1;
                    }
                }
                $this->paginate = [
            'contain' => ['Vendors', 'Financialquarters', 'BusinesplanCampaigns.Businesplans','PartnerCampaigns','CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'],'conditions' => ['Campaigns.vendor_id' => $this->Auth->user('vendor_id')],
        ];
        $this->set('campaigns', $this->paginate($this->Campaigns));
                $this->set('prompt_upgrade', $prompt_upgrade);
                $this->set('send_details', $send_details);
    }

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
    public function view($id = null) {
        $campaign = $this->Campaigns->get($id, [
            'contain' => ['Vendors', 'Financialquarters','CampaignResources', 'EmailTemplates']
        ]);
               //print_r($campaign[email_templates][0][id]);exit;
        $this->set('campaign', $campaign);
        $this->set('email_id', $campaign[email_templates][0][id]);
        
        
        $landingpages = $this->LandingPages->find()
                        ->select('id')
                        ->where(['campaign_id'=>$campaign[id]])
                        ->first();
        
        $this->set('landingpages', $landingpages);
    }

/**
 * Add method
 *
 * @return void
 */
    public function add() {
		if ($this->request->is(['ajax'])){
			
			if($resourceFile= $this->Filemanagement->uploadFiletoFolder($this->request->data['resource'],'campaignresources/')){ 
				if($this->request->data['campaign_type']=='other')
					$this->request->data['campaign_type'] = $this->request->data['campaign_type_other'];

				$campaign = $this->Campaigns->newEntity($this->request->data);
			
				if ($cmp=$this->Campaigns->save($campaign)) {
					
					$this->loadModel('CampaignResources');
					if($cmp->id > 0 && !empty($this->request->data['resource'])){
						$vendor_id  =   $this->Auth->user('vendor_id');
						$title = $resourceFile['filename'];
						$filepath = $resourceFile['filename'];
						
						$query = $this->CampaignResources->query();
						$query->insert(['vendor_id', 'campaign_id','title','filepath'])
							->values([
								'vendor_id' => $vendor_id,
								'campaign_id' => $cmp->id,
								'title' => $title,
								'filepath' => $filepath
							])
						->execute();
					
					}
					$this->Flash->success($msg.'The campaign has been saved.');
					//return $this->redirect(['action' => 'index',$fqt_id,true]);
					echo "success";
				} else {
						$this->Flash->error($msg.'The campaign could not be saved. Please try again.');
				} 
			}
			exit();
			
		}
		if(isset($this->request->data['financialquarter_id'])){
			$fqt_id =   $this->request->data['financialquarter_id'];
		}else{
			$fqt_id =   0;
		}
		$max_send_limit =   $this->__getMaxSendLimit($this->Auth->user('vendor_id'), $fqt_id);
		$resource_array = array();
		if(isset($this->request->data['resource'])){
			$resource_array = $this->__campresourceUpload($this->request->data['resource']);
			unset($this->request->data['resource']);
		}
			
			

		if($this->request->data['campaign_type']=='other')
			$this->request->data['campaign_type'] = $this->request->data['campaign_type_other'];

		$campaign = $this->Campaigns->newEntity($this->request->data);
		if ($this->request->is('post')) {
			$msg='';
			if(!empty($resource_array))   {
				foreach($resource_array as $rs){
					if($rs['success'] != 200){
						$msg    .= $rs['message'];
					}

				}
			} 
			if($max_send_limit < $this->request->data['send_limit']){
				
					$this->redirect(array('controller' => 'Vendors', 'action' => 'sendUpgrade'));
				
				$this->Flash->error($msg.'The send limit exceeds your maximum allowance of '.$max_send_limit.' sends per partner for the selected quarter. Please choose a lower send limit, or upgrade your subscription.');
				
			} else {
				
				if ($cmp=$this->Campaigns->save($campaign)) {
					if(!empty($resource_array))   {
						$this->__campresourceUpdate($cmp->id, $resource_array);
					} 
					$this->Flash->success($msg.'The campaign has been saved.');
					return $this->redirect(['action' => 'index',$fqt_id,true]);
				} else {
						$this->Flash->error($msg.'The campaign could not be saved. Please try again.');
				} 
			}    
				
		}
		$this->set('current_send_limit',$campaign->send_limit);
		$vendors = $this->Campaigns->Vendors->find('list');
		
		$currentquarter = $this->Campaigns->Financialquarters->find()
			->where(['NOW() BETWEEN startdate and enddate'])->first();


		$datenow = date('Y-m-d h:i:s',strtotime(date('Y').'-'.date('m').'-01 00:00:00'));
		//echo $datenow; exit;      
		$financialquarters = $this->Campaigns->Financialquarters->find('list')
		  ->where(['enddate >' => $datenow , 'vendor_id'=>$this->Auth->user('vendor_id')])
		  ->order(['enddate'=>'ASC']);
		

		$this->set(compact('campaign', 'vendors', 'financialquarters','max_send_limit','currentquarter'));
            
    }

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
    public function edit($id = null) {
        $campaign = $this->Campaigns->get($id, [
            'contain' => []
        ]);
                if(isset($this->request->data['financialquarter_id'])){
                    $fqt_id =   $this->request->data['financialquarter_id'];
                }else{
                    $fqt_id =   $campaign->financialquarter_id;
                }
                $max_send_limit =   $this->__getMaxSendLimit($this->Auth->user('vendor_id'), $fqt_id);
                $resource_array = array();
                if(isset($this->request->data['resource'])){
                    $resource_array = $this->__campresourceUpload($this->request->data['resource']);
                    unset($this->request->data['resource']);
                }
        if ($this->request->is(['patch', 'post', 'put'])) {
                    $msg='';
                    if(!empty($resource_array))   {
                        foreach($resource_array as $rs){
                            if($rs['success'] != 200){
                                $msg    .= $rs['message'];
                            }

                        }
                    }
                     
                    if($this->request->data['campaign_type']=='other')
                        $this->request->data['campaign_type'] = $this->request->data['campaign_type_other'];

            $campaign = $this->Campaigns->patchEntity($campaign, $this->request->data);
            if($max_send_limit < $this->request->data['send_limit']){
                        $this->redirect(array('controller' => 'Vendors', 'action' => 'sendUpgrade'));
                    
                    $this->Flash->error($msg.'The send limit exceeds your maximum allowance of '.$max_send_limit.' sends per partner for the selected quarter. Please choose a lower send limit, or upgrade your subscription.');
                        }else{
                            if ($this->Campaigns->save($campaign)) {
                                if(!empty($resource_array))   {
                                    $this->__campresourceUpdate($campaign->id, $resource_array);
                                }    
                                $this->Flash->success($msg.'The campaign has been saved.');
                                return $this->redirect(['Controller'=>'Campaigns','action' => 'index',$fqt_id,1]);
                            } else {
                                    $this->Flash->error($msg.'The campaign could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                            }
                        }
        }
                $this->set('current_send_limit',$campaign->send_limit);
        $vendors = $this->Campaigns->Vendors->find('list');
        $financialquarters = $this->Campaigns->Financialquarters->find('list')
    ->where(['vendor_id'=>$this->Auth->user('vendor_id')])
    ->order(['enddate'=>'ASC']);
        $this->set(compact('campaign', 'vendors', 'financialquarters','max_send_limit'));
    }

    /**
     * Delete method
     *
     * @param string $id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function delete($id = null) {
        $this->loadModel('BusinesplanCampaigns');
        $bpcs= $this->BusinesplanCampaigns->findByCampaignId($id)->first();
        if(isset($bpcs->id) && $bpcs->id > 0 ){
            $this->Flash->error('This campaign is part of a submitted campaign plan, so it can\'t be deleted.');
            return $this->redirect(['action' => 'index']);
        }
        $campaign = $this->Campaigns->get($id);
        $this->request->allowMethod('post', 'delete');
        if ($this->Campaigns->delete($campaign)) {
                $this->Flash->success('The campaign has been deleted.');
        } else {
                $this->Flash->error('The campaign could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
        }
        return $this->redirect(['action' => 'index']);
    }
    /*
     * Function to find maximum send limit for the quarter...
     * 
     * 
     * @param int vendor_id,int financialquarter_id, int current limit
     * @return int maximum_limit..
     */
    function __getMaxSendLimit($vendor_id=0,$fqt_id=0,$call=0){
       /*
        * For getting the maximum limit of quarter 
        * We multiply monthly package limit by 3
        */
        if($vendor_id > 0){
            if($fqt_id == 0){
                /*
                 * Section to find current financial quarter id....
                 */
                $qrter  =   $this->Financialquarters->find()
                                                        ->where(['vendor_id'=>$vendor_id,'enddate >= '=>time(),'startdate <=' => time()])
                                                        ->first();
                if(isset($qrter->id) && $qrter->id > 0){
                    $fqt_id =   $qrter->id;
                }else{
                     return 0;
                }
                   
            }
            /*
             * Section to find the maximum allowed limit for vendors subscription package X 3
             *
             */
            $package_max_limit  = $this->__getMaxPackageallowance();
            /*
             * Section to find the maximum allocated for existing campaigns in the quarter
             */
           
            $total_assigned = $this->__getMaxAllocatedsend($fqt_id);
           // echo  $total_assigned;exit;
            /*
             * Section to calculate the maximum limit
             */
            
            $max_allowance_balance  =   ($package_max_limit - $total_assigned) + $call;
            if($max_allowance_balance < 0){
                $max_allowance_balance  =   0;
            }
            return $max_allowance_balance;
        }
        return 0;
    }
    /*
     * Function to upload campaign resources
     * Accept array of files
     * Return array of uploaded filenames
     */
    function __campresourceUpload($files=  array()){
        $ret_array  =   array();
        $i=0;
        foreach($files as $fls){
            if (!empty($fls['file']['tmp_name']) && $fls['file']['error'] == 0 && in_array($fls['file']['type'],$this->allowed_resource_file_types)) {
                $updfile = $this->Filemanagement->uploadFiletoFolder($fls['file'],'campaignresources/');
                if($updfile['success'] == 200){
                    $srcfile    =   $updfile['filename'];
                    $ret_array[$i]['filepath'] = $srcfile;
                    if(isset($fls['title']) && trim($fls['title']) != ''){
                        $ret_array[$i]['title'] = $fls['title'];
                    }else{
                        $ret_array[$i]['title'] = $srcfile;
                    }
                    $ret_array[$i]['message']     =   $updfile['msg'];
                    $ret_array[$i]['success']     =   $updfile['success'];
                }else{
                    $ret_array[$i]['message']     =   $updfile['msg'];
                    $ret_array[$i]['success']     =   $updfile['success'];
                    
                }
                $i++;
            }
        }
        return $ret_array;
    }
    
    /*
     * Function to insert campaign resource details to database
     * 
     */
    function __campresourceUpdate($cmp_id=0,$rearray=  array()){
        $this->loadModel('CampaignResources');
        if($cmp_id > 0 && !empty($rearray)){
            $vendor_id  =   $this->Auth->user('vendor_id');
            foreach($rearray as $rec){
                if($rec['success']==200){
                    $rec['vendor_id']   =   $vendor_id;
                    $rec['campaign_id'] =   $cmp_id;
                    unset($rec['message'],$rec['success']);
                    $rqr = $this->CampaignResources->newEntity($rec);
                    $this->CampaignResources->save($rqr);
                }
                
            }
            return true;
        }
        
        return false;
    }
    function __getMaxPackageallowance(){
        $vendor_id  =   $this->Auth->user('vendor_id');
        /*
        * Section to find the maximum allowed limit for vendors subscription package X 3
        */
        $vendor = $this->Vendors->find()
                    ->hydrate(false)
                    ->select(['Vendors.id','s.name','s.no_emails'])
                    ->join([
                        's' => [
                            'table' => 'subscription_packages',
                            'type' => 'INNER',
                            'conditions' => 'Vendors.subscription_package_id = s.id',
                        ]
                    ])
                    ->where(['Vendors.id' => $vendor_id])->first();

        if(isset($vendor['s']['no_emails'])){
            $package_max_limit  =   $vendor['s']['no_emails'] * 3;
        }else{
            $package_max_limit  =   0;
        }
        return $package_max_limit;
    }
    function __getMaxAllocatedsend($fqt_id=0){
        $vendor_id  =   $this->Auth->user('vendor_id');
        $total_assigned =   0;
        if($fqt_id > 0){
            /*
             * Section to find the maximum allocated for existing campaigns in the quarter
             */
            $query  =   $this->Campaigns->find()->where(['financialquarter_id'=>$fqt_id,'vendor_id'=>$vendor_id]);
            $mlmt   =   $query->select([
                                    'total_assigned_send' => $query->func()->sum('send_limit')
                                ])
                                ->group('financialquarter_id')
                                ->first();
            if(isset($mlmt->total_assigned_send)){
                $total_assigned =   $mlmt->total_assigned_send;
            }
            
        }
        return $total_assigned;
    }
    function __checkUsedSendlimit($fqt_id=0){
        $vendor_id  =   $this->Auth->user('vendor_id');
        $results    =   array();
        if($fqt_id > 0){
            $max_allowed_package    =   $this->__getMaxPackageallowance();
            $total_used             =   $this->__getMaxAllocatedsend($fqt_id);
            $used_percentage        =   ($total_used / $max_allowed_package) * 100;
            $results['allowance']   =   $max_allowed_package;
            $results['usage']       =   $total_used;
            $results['usage_perc']  =   $used_percentage;
        }
        return $results;
    }
    public function getBalanceAllowance(){
        $this->layout = 'ajax';
        if ($this->request->is(['patch', 'post', 'put'])) {
            $package_max_limit  = $this->__getMaxPackageallowance();
            $total_assigned = $this->__getMaxAllocatedsend($this->request->data['qtid']);
            $max_send_limit  =   ($package_max_limit - $total_assigned) + $this->request->data['cal'];
            if($max_send_limit < 0){
                $max_send_limit  =   0;
            }
            $this->set('max_send_limit', $max_send_limit);
            $this->set('current_send_limit', $this->request->data['cal']);
        }
    }
    public function marknotspam($id){
        // Mark Template for Campaign as Not Spam. Defaults to Spam=Y
        $this->loadModel('EmailTemplates');
        $emailtemplate   = $this->EmailTemplates->find()->where(['campaign_id'=>$id])->first();
        $emailtemplate = $this->EmailTemplates->patchEntity($emailtemplate, ['spam'=>'N']);
        $this->EmailTemplates->save($emailtemplate);
        exit();
    }
	public function browserandspamchecker($id=null) {
		$browserCheck = $this->browsercheck($id);
		$linkChecker = $this->linkcheck($id); //go to link checker
		$this->loadComponent('Litmusemailtest');
        if ($this->request->is(['ajax']))
        {
            $spamChecker = $this->Litmusemailtest->getStatus($id);
            echo json_encode($spamChecker);
            exit();
        }
		//spam check
		
		$this->loadModel('EmailTemplates');
        $emailTemplate = $this->EmailTemplates->find()->where(['campaign_id'=>$id])->first();
        if($emailTemplate)
        {            
            $spamChecker = $this->Litmusemailtest->getSpamCheckers();
           
            if($this->sendtestemail($id,array($this->Litmusemailtest->inboxGUID.'@emailtests.com')))
            {
                $this->sendtestemail($id,$spamChecker['CheckerEmails']);
                $spamChecker['CheckerRes'] = $this->Litmusemailtest->getStatus($this->Litmusemailtest->testID);
				
            }
            $this->set(compact(['spamChecker','id']));
        }
        else
        {
            $this->Flash->error('We couldn\'t check for spam on the test email, You have no email templates on record.');
            return $this->redirect(['action' => 'view',$id]);
        }
		
		
	}
	
	public function linkcheck($id=null) {
		$this->loadComponent('Litmusemailtest');
        if ($this->request->is(['ajax'])){
			$linkChecker = $this->Litmusemailtest->getlinkCheckerStatus($id);
			echo json_encode($linkChecker);
			
            exit();
        }
		$this->loadModel('EmailTemplates');
        $emailTemplate = $this->EmailTemplates->find()->where(['campaign_id'=>$id])->first();
        if($emailTemplate)
        {     
			
			$linkCheckGetID = $this->Litmusemailtest->getLinkCheckers(addslashes($this->htmlEmailContent($id)));
			$linkChecker = $this->Litmusemailtest->getlinkCheckerStatus($this->Litmusemailtest->testID);
         
            $this->set(compact(['linkChecker','linkCheckGetID','id']));
        }
       
		
	}
	
    public function spamcheck($id=null){
       $this->loadComponent('Litmusemailtest');
        if ($this->request->is(['ajax']))
        {
            $checker = $this->Litmusemailtest->getStatus($id);
            echo json_encode($checker);
            exit();
        }

        $this->loadModel('EmailTemplates');
        $emailTemplate = $this->EmailTemplates->find()->where(['campaign_id'=>$id])->first();
        if($emailTemplate)
        {            
            $checker = $this->Litmusemailtest->getSpamCheckers();
            
            if($this->sendtestemail($id,array($this->Litmusemailtest->inboxGUID.'@emailtests.com')))
            {
                $this->sendtestemail($id,$checker['CheckerEmails']);
                $checker['CheckerRes'] = $this->Litmusemailtest->getStatus($this->Litmusemailtest->testID);
            }
            $this->set(compact(['checker','id']));
        }
        else
        {
            $this->Flash->error('We couldn\'t check for spam on the test email, You have no email templates on record.');
            return $this->redirect(['action' => 'view',$id]);
        }
    }
    public function browsercheck($id=null){
        $this->loadComponent('Litmusemailtest');
        if ($this->request->is(['ajax']))
        {
            $checker = $this->Litmusemailtest->getStatus($id);
            //file_put_contents(WWW_ROOT.'files'.DS.'litmus_status.json',json_encode($checker));
            //$checker = json_decode(file_get_contents(WWW_ROOT.'files'.DS.'litmus_status.json'),true);
            echo json_encode($checker);
            exit();
        }

        $this->loadModel('EmailTemplates');
        $emailTemplate = $this->EmailTemplates->find()->where(['campaign_id'=>$id])->first();
        if($emailTemplate)
        {            
            $checker = $this->Litmusemailtest->getEmailCheckers();
            
            //$checker = ['InboxGUID'=>'1stw4tj','TestID'=>'19590728','CheckerEmails'=>''];
            if($this->sendtestemail($id,array($this->Litmusemailtest->inboxGUID.'@emailtests.com')))
            {
                $checker['CheckerRes'] = $this->Litmusemailtest->getStatus($this->Litmusemailtest->testID);
                //file_put_contents(WWW_ROOT.'files'.DS.'litmus_status.json',json_encode($checker['CheckerRes']));
                //$checker['CheckerRes'] = json_decode(file_get_contents(WWW_ROOT.'files'.DS.'litmus_status.json'),true);
            }
            $this->set(compact(['checker','id']));
        }
        else
        {
            $this->Flash->error('We couldn\'t check for browser output on the test email, You have no email templates on record.');
            return $this->redirect(['action' => 'view',$id]);
        }
    }
	public function webbased($id=null){
		$this->loadComponent('Litmusemailtest');
        if ($this->request->is(['ajax'])) {
			$image_url  = Router::url('/img/logos/',true);
			$appName = $this->request->data['appName'];
			$classes = $this->request->data['classes'];
			$image = $this->request->data['image'];
			$browserArr = array("explorer"=>"","firefox"=>"ff","chrome"=>"chrome");
			foreach($browserArr as $browser=>$code) {
				$appVer = $code.$appName;
				
				$realImg = str_replace($appName,$appVer,$image);
				echo "<button type='button' class='btn btn-default btn-xs {$browser}' data-app='{$appName}' onclick='browserClick(\"{$appVer}\",\"{$classes}\",\"{$realImg}\",\"{$browser}\");'><img src='{$image_url}{$browser}-logo.png' /></button>";
				
			}
			
			exit();
		}
	}
    public function sendtestemail($id=null,$checkers=null){
        $this->loadModel('EmailTemplates');
        $this->loadModel('Users');
        $this->loadModel('Partners');
        $image_url  = Router::url('/img/',true);
        $chkemtmp   =   false;
        if($id!=null && $id > 0){
            $campaign   = $this->Campaigns->find()->where(['id'=>$id])->first();
            $partner = $this->Partners->find()->where(['vendor_id'=>$this->Auth->user('vendor_id')])->first();
            if(isset($campaign->id) && $campaign->html == 'Y'){
                $edm  = $this->EmailTemplates->find()->contain(['MasterTemplates','Vendors'])->where(['EmailTemplates.campaign_id'=>$id])->first();
                if(isset($edm->id)){
                    $chkemtmp   =   true;
                }
                if(isset($edm['master_template']->content)  && $edm->use_templates == 'Y'){

                        $viewhtml  =   $edm['master_template']->content;
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
                        
                }elseif($edm->use_templates != 'Y' && $edm->custom_template != ''){
                    $viewhtml   =   $edm->custom_template;

                    if($partner['logo_url']){
                        $plogo      =    '<img src="'.$partner['logo_url'].'" height="60" width="100" class="left"/>';
                        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
                    } else {
                        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]','', $viewhtml);
                    }

                    if($edm['cta_url'])
                        if($edm['cta_text'])
                            $viewhtml   =   str_replace('[*!CTATEXT!*]','<a href="'.$edm['cta_url'].'">'.$edm['cta_text'].'</a>', $viewhtml);
                        else
                            $viewhtml   =   str_replace('[*!CTATEXT!*]',$edm['cta_url'], $viewhtml);
                }
            }
        }
        if(false == $chkemtmp){
            $this->Flash->error('Couldn\'t find any valid email template for this campaign');
            return $this->redirect(['action' => 'view',$id]);
        }else{
            $user =   $this->Users->get($this->Auth->user('id'));
            $this->set('user', $user);
        }
        if ($this->request->is(['patch', 'post', 'put']) && is_null($checkers)) {
           
                $result = $this->sendmandrilltestvendor($viewhtml, $edm->vendor_id, $this->request->data['to_name'], $this->request->data['to_email'], $this->request->data['subject']);
                if(isset($result[0]['status']) && $result[0]['status'] == 'sent'){
                    $this->Flash->success('Test email has been sent');
                }elseif(isset($result[0]['reject_reason'])&& $result[0]['reject_reason'] != ''){
                    $this->Flash->error($result[0]['reject_reason'].' Please contact the website administrator');
                }else{
                    $this->Flash->error('We couldn\'t send the test email, please try again. If you continue to experience problems, please contact Customer Support.');
                }
                return $this->redirect(['action' => 'view',$id]);
            
        }
        else
        {
            $ret = false;
            foreach($checkers as $checker)
                $ret = $this->sendmandrilltestvendor($viewhtml, $edm->vendor_id, 'Litmus Spam Checker', $checker, 'Check My Email Template');
                
            if(count($checkers)==1)
                return $ret;
        }
    }
    /*
    * Function to test mandrill integration...
    */
    public function sendmandrilltestvendor($vhtml=NULL,$vid=0,$toname=NULL,$toemail=NULL,$subject=NULL){
        $from_email =   $this->portal_settings['site_email'];
        $from_name  =   $this->portal_settings['site_name'];
        $mandrill = new Mandrill($this->portal_settings['mandrill_key']);
        if($vhtml != NULL && $toemail !=NULL ){
            if($vid > 0){
                $vendor = $this->Vendors->find()
                        ->hydrate(false)
                        ->select(['Vendors.company_name','u.email'])
                        ->join([
                            'm' => [
                                'table' => 'vendor_managers',
                                'type' => 'INNER',
                                'conditions' => [
                                    'm.primary_manager' => 'Y',
                                    'Vendors.id = m.vendor_id'
                                ],
                            ],
                            'u' => [
                                'table' => 'users',
                                'type' => 'INNER',
                                'conditions' => 'u.id = m.user_id',
                            ],
                            
                        ],['m.primary_manager' => 'string','u.id' => 'integer','m.user_id' => 'integer'])
                        ->where(['Vendors.id' => $vid])->first();
                if(isset($vendor['u']['email'])){
                    $from_email =   $vendor['u']['email'];
                }
                if(isset($vendor['company_name'])){
                    $from_name =   $vendor['company_name'];
                }
            }
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
                'headers' => array('Reply-To' => $from_email),
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
                'google_analytics_campaign' => 'marketingconnex.com',
                'metadata' => array('website' => 'www.marketingconnex.com'),
            );
            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = date('Y-m-d H:i:s',strtotime('-1 days',time()));//echo $send_at;exit;
            $result = $mandrill->messages->send($message, $async, $ip_pool);
            return $result;
        }   
        return false;
    }
	
	public function htmlEmailContent($id=null){
		$this->loadModel('EmailTemplates');
        $this->loadModel('Users');
        $this->loadModel('Partners');
        $image_url  = Router::url('/img/',true);
        $chkemtmp   =   false;
		if($id!=null && $id > 0){
			$campaign   = $this->Campaigns->find()->where(['id'=>$id])->first();
            $partner = $this->Partners->find()->where(['vendor_id'=>$this->Auth->user('vendor_id')])->first();
			if(isset($campaign->id) && $campaign->html == 'Y'){
				$edm  = $this->EmailTemplates->find()->contain(['MasterTemplates','Vendors'])->where(['EmailTemplates.campaign_id'=>$id])->first();
				 if(isset($edm->id)){
                    $chkemtmp   =   true;
                }
				if(isset($edm['master_template']->content)  && $edm->use_templates == 'Y'){
					$viewhtml  =   $edm['master_template']->content;
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
				}elseif($edm->use_templates != 'Y' && $edm->custom_template != ''){
					$viewhtml   =   $edm->custom_template;
					if($partner['logo_url']){
                        $plogo      =    '<img src="'.$partner['logo_url'].'" height="60" width="100" class="left"/>';
                        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
                    } else {
                        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]','', $viewhtml);
                    }
					
					if($edm['cta_url'])
                        if($edm['cta_text'])
                            $viewhtml   =   str_replace('[*!CTATEXT!*]','<a href="'.$edm['cta_url'].'">'.$edm['cta_text'].'</a>', $viewhtml);
                        else
                            $viewhtml   =   str_replace('[*!CTATEXT!*]',$edm['cta_url'], $viewhtml);
				}
			}
		}
		
		
		return $viewhtml;
	}
    
}

