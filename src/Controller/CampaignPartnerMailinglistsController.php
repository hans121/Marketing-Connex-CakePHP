<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * CampaignPartnerMailinglists Controller
 *
 * @property App\Model\Table\CampaignPartnerMailinglistsTable $CampaignPartnerMailinglists
 */
class CampaignPartnerMailinglistsController extends AppController {

/**
 * Index method
 *
 * @return void
 */
	public function index($cmp_id=0) {
            $allowed_to_see = false;
            $keyword  =   '';
            if($cmp_id > 0){
                $pcmp_id    = $this->__getPartnerCampaign($cmp_id);
                if(isset($pcmp_id) && $pcmp_id > 0){
                    $allowed_to_see =   TRUE;
                }
            }
            if(TRUE != $allowed_to_see){
                $this->Flash->error(__('Sorry, you do not have permission to view this list.'));
                return $this->redirect(['controller'=>'PartnerCampaigns','action' => 'mycampaignslist']);
            }
            $campaign   = $this->Campaigns->find()->where(['id'=>$cmp_id])->first();
            $this->paginate = [
			'contain' => ['Partners', 'Campaigns', 'Vendors', 'PartnerCampaigns', 'PartnerCampaignEmailSettings'],
                        'conditions' => ['CampaignPartnerMailinglists.partner_id' => $this->Auth->user('partner_id'),'CampaignPartnerMailinglists.campaign_id'=>$cmp_id],
		];
            if ($this->request->is(['post', 'put'])) {
                $keyword  =   $this->request->data['keyword'];
                $lkeyword  =   '%'.$keyword.'%';
                if(trim($keyword) != ''){
                    $query = $this->CampaignPartnerMailinglists->find('all')->where(['CampaignPartnerMailinglists.first_name LIKE ' => $lkeyword])
                                                                ->orWhere(['CampaignPartnerMailinglists.last_name LIKE ' => $lkeyword])
                                                                ->orWhere(['CampaignPartnerMailinglists.email LIKE ' => $lkeyword]);
                    $this->set('vendors', $this->paginate($query));
                    $cmplemails =   $this->paginate($query);
                }else{
                   $cmplemails =   $this->paginate($this->CampaignPartnerMailinglists);
                }
            }else{
                $cmplemails =   $this->paginate($this->CampaignPartnerMailinglists);
            }
            /*
             * Section to find no of current participants
             */
            $totcurrentparticipants = $this->getotalparticipants($cmp_id);
            
            $this->set('totcurrentparticipants', $totcurrentparticipants);
            $this->set('campaignPartnerMailinglists', $cmplemails);
            $this->set('campaign', $campaign);
            $this->set('keyword', $keyword);
	}
        function getotalparticipants($cmp_id=0){
            $total=0;
            if($cmp_id > 0){
                $query = $this->CampaignPartnerMailinglists->find('all') ->where(['CampaignPartnerMailinglists.partner_id ' => $this->Auth->user('partner_id'),'CampaignPartnerMailinglists.campaign_id'=>$cmp_id,'participate_campaign'=>'Y','subscribe'=>'Y']);
                $total = $query->count();
            }
            return $total;
        }
        public function beforeFilter(Event $event) {
            parent::beforeFilter($event);
            $this->layout = 'admin';
            $this->loadModel('Campaigns');
            $this->loadModel('PartnerCampaigns');
            $this->loadModel('EmailTemplates');
            $this->loadModel('LandingPages');
            $this->loadModel('PartnerCampaignEmailSettings');
            $this->loadModel('UnsubscribedContacts');
            $this->loadModel('CampaignPartnerMailinglistDeals');
            $this->loadModel('PartnerManagers');
            $this->loadComponent('Emailverifier');
            $this->Auth->allow(['unsubscribeme']);
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
 * Registerdeal method
 * 
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
        public function registerdeal($id = null) {
        	
        	if(count($this->request->data)>0)
        	{
        		$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals->newEntity($this->request->data);
        		if($this->CampaignPartnerMailinglistDeals->save( $campaignPartnerMailinglistDeal ))
        		{
        			$this->Flash->success('The deal has been saved');
                                return $this->redirect(['controller'=>'PartnerCampaigns','action' => 'mycampaignslist']);
        		}
        		else
        			$this->Flash->error('Sorry, the deal could not be saved. Please try again.  If you continue to experience problems, please contact Customer Support.');
        	}
        	
        	$campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->get($id, [
				'contain' => ['Campaigns']
			]);
        	
        	$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals
        		->find();
        	
        	$partnerManagerUsers = $this->PartnerManagers
        		->find('all')
        		->contain(['Users'])
        		->where(['partner_id' => $campaignPartnerMailinglist->partner_id]);
        	
        	$this->set('campaignPartnerMailinglist', $campaignPartnerMailinglist);
        	$this->set('campaignPartnerMailinglistDeal', $campaignPartnerMailinglistDeal);
        	$this->set('partnerManagerUsers', $partnerManagerUsers);
        	$this->set('mailinglist_id', $id);
        }
        
        /**
         * listdeals method
         *
         * @return void
         */
        public function listdeals() {
        	$prtnr_id   =   $this->Auth->user('partner_id');
        	$mycamp =   $this->PartnerCampaigns->find('all')->where(['partner_id'=>$prtnr_id]);
            $my_camp_arr    = array();
            foreach($mycamp as $cmps){
                $my_camp_arr[]  =   $cmps->campaign_id;
            }
            
            $my_camp_list   = $this->Campaigns->find('list')->where(['id IN' =>$my_camp_arr ]);
           
            $this->set('my_camp_list', $my_camp_list);
        	
        	$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals
        	->find('all')
        	->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
                ->order(['CampaignPartnerMailinglistDeals.deal_value'=>'DESC'])
                ->where(['Partners.id'=>$prtnr_id]);
        	
        	$this->paginate = ['limit'=>50];
        	$campaignPartnerMailinglistDeal = $this->paginate($campaignPartnerMailinglistDeal);
        	 
        	$this->set('campaignPartnerMailinglistDeal', $campaignPartnerMailinglistDeal);
                $default_avtar_url  = Router::url('/img/img-gravatar-placeholder.png',true);
                //$this->set('default_avtar_url',$default_avtar_url);
        	 
        }
        
        /**
         * listdealsajax method
         *
         * @return void
         */
        public function ajaxlistdeals() {
        	if($this->request->is('post'))
        	{
        		$this->layout = 'ajax';
        		
        		$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals
        		->find('all')
        		->where(['campaign_partner_mailinglist_id'=>$this->request->data['campaign_id']])
        		->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
                        ->order(['CampaignPartnerMailinglistDeals.deal_value'=>'DESC']);
        		
        		$this->paginate = ['limit'=>50];
        		$campaignPartnerMailinglistDeal = $this->paginate($campaignPartnerMailinglistDeal);
        		
        		$this->set('campaignPartnerMailinglistDeal', $campaignPartnerMailinglistDeal);
                        $default_avtar_url  = Router::url('/img/img-gravatar-placeholder.png',true);
                        $this->set('default_avtar_url',$default_avtar_url);
        	}
        }
        
        /**
         * viewdeal method
         *
         * @param int $mailinglist_id, int $deal_id
         * @return void
         */
        public function viewdeal($mailinglist_id,$deal_id) {
        	$campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->get($mailinglist_id, [
        			'contain' => ['Campaigns']
        			]);
        	
        	$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals->get($deal_id,[
        			'contain' => ['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists']
        	]);
        	
        	
        	$this->set('campaignPartnerMailinglist', $campaignPartnerMailinglist);
        	$this->set('campaignPartnerMailinglistDeal', $campaignPartnerMailinglistDeal);
        	
        }
        
        /**
         * editdeal method
         *
         * @param int $mailinglist_id, int $deal_id
         * @return void
         */
        public function editdeal($mailinglist_id,$deal_id) {
        	
        	if(count($this->request->data)>0)
        	{
        		$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals->get($deal_id);
        		$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals->patchEntity($campaignPartnerMailinglistDeal,$this->request->data);
        		if($this->CampaignPartnerMailinglistDeals->save( $campaignPartnerMailinglistDeal ))
        		{
        			$this->Flash->success('The deal has been updated');
        			return $this->redirect('/campaign_partner_mailinglists/view/'.$mailinglist_id);
        		}
        		else
        			$this->Flash->error('Your deal could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
        	}
        	
        	$campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->get($mailinglist_id, [
        			'contain' => ['Campaigns']
        			]);
        	 
        	$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals->get($deal_id);

        	$partnerManagerUsers = $this->PartnerManagers
        	->find('all')
        	->contain(['Users'])
        	->where(['partner_id' => $campaignPartnerMailinglist->partner_id]);
        	 
        	$this->set('campaignPartnerMailinglist', $campaignPartnerMailinglist);
        	$this->set('campaignPartnerMailinglistDeal', $campaignPartnerMailinglistDeal);
        	$this->set('partnerManagerUsers', $partnerManagerUsers);
        }
        
        /**
         * deletedeal method
         *
         * @param int $mailinglist_id, int $deal_id
         * @return void
         */
        public function deletedeal($mailinglist_id,$deal_id) {
        	$entity = $this->CampaignPartnerMailinglistDeals->get($deal_id);
        	if($this->CampaignPartnerMailinglistDeals->delete($entity))
        	{
        		$this->Flash->success('Your deal has been deleted');
        		return $this->redirect('/campaign_partner_mailinglists/view/'.$mailinglist_id);
        	}
        	else
        	{
        		$this->Flash->error('Sorry, your deal could not be deleted. If you continue to experience problems, please contact Customer Support.');
        		return $this->redirect('/campaign_partner_mailinglists/view/'.$mailinglist_id);
        	}
        		        	
        }
        
/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {		
		$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals
			->find('all')
			->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists','CampaignPartnerMailinglists.Campaigns'])
			->where(['campaign_partner_mailinglist_id'=>$id])
			->order(['CampaignPartnerMailinglistDeals.deal_value'=>'DESC']);
			
			
		$campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->get($id, [
			'contain' => ['Partners', 'Campaigns', 'Vendors', 'PartnerCampaigns', 'PartnerCampaignEmailSettings']
		]);
		$this->set('campaignPartnerMailinglist', $campaignPartnerMailinglist);
		$this->set('campaignPartnerMailinglistDeal', $campaignPartnerMailinglistDeal);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add($cmp_id = 0) {
		$allowed_to_see = false;
    $pcmp_id    =   0;
    if($cmp_id > 0){
      $pcmp_id    = $this->__getPartnerCampaign($cmp_id);
      if(isset($pcmp_id) && $pcmp_id > 0){
        $allowed_to_see =   TRUE;
      }
    }
    if(TRUE != $allowed_to_see){
      $this->Flash->error(__('Sorry, you do not have permission to view this list'));
      return $this->redirect(['controller'=>'PartnerCampaigns','action' => 'mycampaignslist']);
    }
    $campaign = $this->Campaigns->find()->where(['id'=>$cmp_id])->first();
    $campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->newEntity($this->request->data);
		if ($this->request->is('post')) {
			// check email
			$ret = $this->Emailverifier->verify($this->request->data['email']);
			if($ret['status']=='valid')
			{
				if ($this->CampaignPartnerMailinglists->save($campaignPartnerMailinglist)) {
					$this->Flash->success('Your mailing list has been saved.');
					return $this->redirect(['action' => 'index',$cmp_id]);
				} else {
					$this->Flash->error('Sorry, the mailing list could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
				}
			}
			else
				$this->Flash->error("The email you entered did not pass the verification! ".$ret['info'].". ".$ret['details']);
		}
		$partnerCampaignEmailSetting = $this->PartnerCampaignEmailSettings->find()->where(['partner_campaign_id'=>$pcmp_id])->first();
      if(empty($partnerCampaignEmailSetting)){
        $this->Flash->error('Please configure the email for this campaign by visiting Email Management.');
        return $this->redirect(['controller'=>'PartnerCampaignEmailSettings','action' => 'add']);
      }
		$this->set(compact('campaignPartnerMailinglist', 'campaign','partnerCampaignEmailSetting','pcmp_id'));
		$this->set('country_list',$this->country_list);
	}
	
	public function successdropcsv($cmp_id = null) {
		$this->Flash->success('The mailing list has been imported.');
		$this->syncunsubscribe();
		return $this->redirect(['action' => 'index',$cmp_id]);
	}
	public function errordropcsv($cmp_id = null) {
		 $this->Flash->error('Sorry, file selected was not a valid csv file. Please try again. If you continue to experience problems, please contact Customer Support.');
		 return $this->redirect(['action' => 'addcsv',$cmp_id]);
	}
	/**
	 * Add CSV method
	 *
	 * @return void
	 */
	
    public function addcsv($cmp_id = 0) {
			$allowed_to_see = false;
      $allowed_resource_file_types    =   ['text/csv','text/x-csv','application/vnd.ms-excel','"text/x-comma-separated-values"'];
      $pcmp_id    =   0;
      if($cmp_id > 0){
          $pcmp_id    = $this->__getPartnerCampaign($cmp_id);
          if(isset($pcmp_id) && $pcmp_id > 0){
              $allowed_to_see =   TRUE;
          }
      }
      if(TRUE != $allowed_to_see){
          $this->Flash->error(__('Sorry, you do not have permission to view this list'));
          return $this->redirect(['controller'=>'PartnerCampaigns','action' => 'mycampaignslist']);
      }
      $campaign   = $this->Campaigns->find()->where(['id'=>$cmp_id])->first();
      $upload_error   =   false;
       if ($this->request->is(['ajax'])) {
         // print_r($this->request->data['importcsv']);exit();
          $this->Filemanagement->allowed_resource_file_types = $allowed_resource_file_types;
          if (!empty($this->request->data['importcsv']['tmp_name']) && $this->request->data['importcsv']['error'] == '0' && in_array($this->request->data['importcsv']['type'],$allowed_resource_file_types)) {
				 
              if($srcfile = $this->Filemanagement->uploadFiletoFolder($this->request->data['importcsv'],'importemaillist/')){
					
                  if(isset($srcfile['success']) && $srcfile['success'] == 200){
                      $this->request->data['importcsv'] = 'importemaillist/'.$srcfile['filename'];
					 
                  }else{
                      unset($this->request->data['importcsv']);
                      $upload_error   =   true;
                      $this->Flash->error($srcfile['msg']);
                  }
                  
              }else{
                  unset($this->request->data['importcsv']);
                  $upload_error   =   true;
              }
          }else{
              $this->Flash->error('Sorry, file selected was not a valid csv file. Please try again. If you continue to experience problems, please contact Customer Support.');
              unset($this->request->data['importcsv']);$upload_error   =   true;
          }
			if(TRUE != $upload_error){
				$new_frm_data   = $this->__getdatafromCSV($this->request->data);
				// print_r($new_frm_data);exit(0);
				$campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->newEntities($new_frm_data);
				$retval=false;
				//print_r($campaignPartnerMailinglist);exit;
				foreach($campaignPartnerMailinglist as $cmplist):
					if ($this->CampaignPartnerMailinglists->save($cmplist)) {
						$retval=true;
					}
					endforeach;
				if (true == $retval) {
					$this->Flash->success('The mailing list has been imported.');
					$this->syncunsubscribe();
					return $this->redirect(['action' => 'index',$cmp_id]);
				} else {
					$this->Flash->error('Sorry, the mailing list could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
				}
          }
		  exit();
      }
$partnerCampaignEmailSetting = $this->PartnerCampaignEmailSettings->find()->where(['partner_campaign_id'=>$pcmp_id])->first();
      if(empty($partnerCampaignEmailSetting)){
          $this->Flash->error('Please configure the email for this campaign by visiting Email Management');
          return $this->redirect(['controller'=>'PartnerCampaignEmailSettings','action' => 'add']);
      }$this->set(compact('campaignPartnerMailinglist',  'campaign','partnerCampaignEmailSetting','pcmp_id'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$allowed_to_see = false;
                $pcmp_id    =   0;
                $campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->get($id, [
			'contain' => []
		]);
                $cmp_id =   $campaignPartnerMailinglist->campaign_id;
                $pcmp_id    = $this->__getPartnerCampaign($cmp_id);
                if(isset($pcmp_id) && $pcmp_id > 0){
                    $allowed_to_see =   TRUE;
                }
                if(TRUE != $allowed_to_see){
                    $this->Flash->error(__('Sorry, you do not have permission to view this list'));
                    return $this->redirect(['controller'=>'PartnerCampaigns','action' => 'mycampaignslist']);
                }
                $campaign   = $this->Campaigns->find()->where(['id'=>$cmp_id])->first();
		if ($this->request->is(['patch', 'post', 'put'])) {
			// check email
			$ret = $this->Emailverifier->verify($this->request->data['email']);
			if($ret['status']=='valid')
			{
                    if(isset($this->request->data['subscribe']) && !$this->request->data['subscribe'])
                      $this->request->data['subscribe']='Y';
                    
                    $campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->patchEntity($campaignPartnerMailinglist, $this->request->data);
                    //print_r($campaignPartnerMailinglist);exit;
                    if ($this->CampaignPartnerMailinglists->save($campaignPartnerMailinglist)) {
                            $this->Flash->success('The mailing list has been saved.');
                            $this->syncunsubscribe();
                            return $this->redirect(['action' => 'index',$cmp_id]);
                    } else {
                            $this->Flash->error('Sorry, the mailing list could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                    }
             }
             else
                 $this->Flash->error("The email you entered did not pass the verification! ".$ret['info'].". ".$ret['details']);
		}
		
		$this->set(compact('campaignPartnerMailinglist', 'campaign'));
		$this->set('country_list',$this->country_list);
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null,$cmp_id=0) {
		$campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->CampaignPartnerMailinglists->delete($campaignPartnerMailinglist)) {
			$this->Flash->success('The mailing list has been deleted.');
		} else {
			$this->Flash->error('Sorry, the mailing list could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index',$cmp_id]);
	}
        function __getPartnerCampaign($cmp_id){
            $pcmp   = $this->PartnerCampaigns->find()->where(['campaign_id'=>$cmp_id,'partner_id'=>$this->Auth->user('partner_id')])->first();
            if(isset($pcmp->id) && $pcmp->id > 0){
                return $pcmp->id;
            }
            return false;
        }
        function __getdatafromCSV($frdata=array()){
            $return_array   =   array();
            $newfilename = WWW_ROOT  .'files' . DS .$frdata['importcsv']; 
            $arrLines = file($newfilename);
            foreach($arrLines as $line) {
            $arrResult[] = explode( ',', $line);
            }
            $i=0;
            if (($handle = fopen($newfilename, "r")) !== FALSE) { 
                while (($file = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    if($i>0){
                        $return_array[$i-1]['partner_id']                           =   $frdata['partner_id'];
                        $return_array[$i-1]['vendor_id']                            =   $frdata['vendor_id'];
                        $return_array[$i-1]['campaign_id']                          =   $frdata['campaign_id'];
                        $return_array[$i-1]['partner_campaign_email_setting_id']    =   $frdata['partner_campaign_email_setting_id'];
                        $return_array[$i-1]['partner_campaign_id']                  =   $frdata['partner_campaign_id'];
                        $return_array[$i-1]['subscribe']                            =   $frdata['subscribe'];
                        $return_array[$i-1]['status']                               =   $frdata['status'];
                        if(isset($file[0])&& $file[0]!= ''){
                            $return_array[$i-1]['first_name']                       =   $file[0];
                        }
                        if(isset($file[1])&& $file[1]!= ''){
                            $return_array[$i-1]['last_name']                        =   $file[1];
                        }
                        if(isset($file[2])&& $file[2]!= ''){
                            $return_array[$i-1]['email']                            =   $file[2];
                        }
                        if(isset($file[3])&& $file[3]!= ''){
                            $return_array[$i-1]['participate_campaign']             =   $file[3];
                        }
                    }
                    $i++;
                }
                fclose($handle);
                unlink($newfilename);
            }
            
            return $return_array;
        }
        public function gettemplate(){
            if($this->Filemanagement->download('samplemailinglist/samplecsv.csv','mailinglisttemplate','text/csv; charset=utf-8')){
                return $this->redirect($this->referer());
            }
            
        }
        public function updateparticipation(){
            if ($this->request->is(['patch', 'post', 'put'])) {
                $STquery = $this->CampaignPartnerMailinglists->query();
                $STquery->update()
                     ->set(['participate_campaign' => $this->request->data['participate_campaign']])
                     ->where(['id' =>  $this->request->data['id']])
                     ->execute();
            }
            $totcurrentparticipants = $this->getotalparticipants($this->request->data['campaign_id']);
            echo $totcurrentparticipants;exit;
            //return $this->redirect($this->referer());
        }
        
        public function updatesubscription(){
            if ($this->request->is(['patch', 'post', 'put'])) {
                $STquery = $this->CampaignPartnerMailinglists->query();
                $STquery->update()
                     ->set(['subscribe' => $this->request->data['subscribe']])
                     ->where(['id' =>  $this->request->data['id']])
                     ->execute();
            }
            $totcurrentparticipants = $this->getotalparticipants($this->request->data['campaign_id']);
            echo $totcurrentparticipants;exit;
            //return $this->redirect($this->referer());
        }
        
        public function bulkupdateparticipation(){
            
            if ($this->request->is(['patch', 'post', 'put'])) {
                $ids    =   explode(',',$this->request->data['ids']);
                foreach($ids as $id){
                    $cpms   =   $this->CampaignPartnerMailinglists->get($id);
                    if($cpms->participate_campaign == 'Y'){
                        $cpvl   =   'N';
                    }else{
                        $cpvl   =   'Y';
                    }
                    $STquery = $this->CampaignPartnerMailinglists->query();
                    $STquery->update()
                     ->set(['participate_campaign' => $cpvl])
                     ->where(['id' =>  $id])
                     ->execute();
                }
                
                
            }
            return $this->redirect(['action' => 'index',$this->request->data['campaign_id']]);
            exit;
        }
        public function bulkupdatesubscription(){
            
            if ($this->request->is(['patch', 'post', 'put'])) {
                $ids    =   explode(',',$this->request->data['ids']);
                foreach($ids as $id){
                    $cpms   =   $this->CampaignPartnerMailinglists->get($id);
                    if($cpms->subscribe == 'Y'){
                        $cpvl   =   'N';
                    }else{
                        $cpvl   =   'Y';
                    }
                    $STquery = $this->CampaignPartnerMailinglists->query();
                    $STquery->update()
                     ->set(['subscribe' => $cpvl])
                     ->where(['id' =>  $id])
                     ->execute();
                }
                
                
            }
            return $this->redirect(['action' => 'index',$this->request->data['campaign_id']]);
            exit;
        }
        public function bulkdelete(){
            if ($this->request->is(['patch', 'post', 'put'])) {
                $ids    =   explode(',',$this->request->data['ids']);
                foreach($ids as $id){
                    $cpms   =   $this->CampaignPartnerMailinglists->get($id);
                    $this->CampaignPartnerMailinglists->delete($cpms);
                }
                
                
            }
            return $this->redirect(['action' => 'index',$this->request->data['campaign_id']]);
            exit;
        }
        public function unsubscribeme(){
	         if (isset($this->request->query['md_id'])) {
			 	$mdmail = $this->request->query['md_email'];
			 	$mdid = $this->request->query['md_id'];
			 	$unsubscribedContact = $this->UnsubscribedContacts->newEntity([]);			
					if ($this->request->is('post')) {
            $mailingList = $this->CampaignPartnerMailinglists->find()->where(['mandrillemailid'=>$mdid,'email'=>$mdmail])->first();
            if($mailingList)
            {
              $data = ['partner_id'=>$mailingList->partner_id,'email'=>$mdmail];
              $unsubscribedContact = $this->UnsubscribedContacts->newEntity($data);
  						if ($this->UnsubscribedContacts->save($unsubscribedContact)) {
  							//$campaignPartnerMailinglist = $this->CampaignPartnerMailinglists->patchEntity($mailingList,['subscribe'=>'N']);
  							//$this->CampaignPartnerMailinglists->save($campaignPartnerMailinglist);
  							$this->syncunsubscribe();
  							$this->Flash->success('You have been unsubscribed from the mailing list');
  							
  						}
  						
            }
			    return $this->redirect(['controller'=>'Pages','action' => 'display']);
					}
					$this->set(compact('unsubscribedContact' ,'mdmail'));	  	
	 	  	}
	 	  	//else{
		 	  	
                //return $this->redirect(['controller'=>'Pages','action' => 'display']);
           // }
            $this->layout = 'signup';
        }
        
        /* public function unsubscribeme($pid=0){
            if($pid > 0){
                $unsubscribedContact = $this->UnsubscribedContacts->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->UnsubscribedContacts->save($unsubscribedContact)) {
				$this->Flash->success('You have been unsubscribed from the mailing list');
				
			}
                        return $this->redirect(['controller'=>'Pages','action' => 'display']);
		}
		$this->set(compact('unsubscribedContact', 'pid'));
            }else{
                return $this->redirect(['controller'=>'Pages','action' => 'display']);
            }
            $this->layout = 'signup';
        } */
        
        
			  /*
		     * Sync unsubscribe list
		     */
        public function syncunsubscribe(){
          $glunsubscribers    = $this->UnsubscribedContacts->find('all');
          if(isset($glunsubscribers)){
            foreach($glunsubscribers as $unscb):
              $STquery = $this->CampaignPartnerMailinglists->query();
              $STquery->update()
               ->set(['subscribe' => 'N'])
               ->where(['email' =>  $unscb->email,'partner_id'=>$unscb->partner_id])
               ->execute();
            endforeach;
          }
          return true;
        }
        
	  /*
     * Function to export list of deals matched against campaigns.....
     */
    public function exportdeals($campid) {

			if ($campid != '') {
			
        	$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals
        		->find('all')
        		->where(['campaign_partner_mailinglist_id' => $campid])
        		->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
                        ->order(['CampaignPartnerMailinglistDeals.deal_value'=>'DESC']);
            }
            else {
	            $campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals
				->find('all')
				->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
                ->order(['CampaignPartnerMailinglistDeals.deal_value'=>'DESC']);
            }

        		//$this->set('campaignPartnerMailinglistDeal', $campaignPartnerMailinglistDeal);
        	
        	
        	
        	//$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals
        	//}
        	
        	$partnerdata    =   array();
	        $i=0;
	        $partnerdata[$i]['company_name'] 	=   'Company Name';
	        $partnerdata[$i]['name']  			=   'Name';
	        $partnerdata[$i]['product_sold']  	=   'Product Sold';
	        $partnerdata[$i]['deal_value']  	=   'Deal Value';
	        $partnerdata[$i]['closure_date'] 	=   'Closure Date';	        
	        $partnerdata[$i]['status']  		=   'Status';

			
        	$i++;
        	
        	
        	
        if($campaignPartnerMailinglistDeal->count()>0){
            foreach($campaignPartnerMailinglistDeal as $prtnr):
            	//echo var_dump($prtnr->rank); 
				//if ($i==1) { break;}
				
            	$partnerdata[$i]['company_name']	 =	 $prtnr->partner_manager->partner->company_name;
            	$partnerdata[$i]['name']			 =	 $prtnr->partner_manager->user->first_name . ' ' . $prtnr->partner_manager->user->last_name;
                $partnerdata[$i]['product_sold'] 	 =   $prtnr->product_sold;
				$partnerdata[$i]['deal_value']  	 =   $prtnr->deal_value;
                $partnerdata[$i]['closure_date'] 	 =   h(date('d/m/Y',strtotime($prtnr->closure_date)));
                if ('N' == $prtnr->status) {
                $partnerdata[$i]['status'] 	 		 =   'Registered';
                }
                else if ('Y' == $prtnr->status) {
	            $partnerdata[$i]['status'] 	 		 =   'Closed'; 
                }                
                
                
                $i++;
            endforeach;
        }   

          

        
        $this->Filemanagement->getExportcsv($partnerdata,'dealslist.csv', ',');
        echo __("Export completed");
        exit; 
    }


}
