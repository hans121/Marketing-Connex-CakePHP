<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * PartnerMailinglists Controller
 *
 * @property App\Model\Table\PartnerMailinglistsTable $PartnerMailinglists
 */
class PartnerMailinglistsController extends AppController {

        public function beforeFilter(Event $event) {
            parent::beforeFilter($event);
            $this->layout = 'admin';
            $this->loadModel('UnsubscribedContacts');
            $this->loadModel('PartnerManagers');
            $this->loadModel('PartnerMailinglistVerifications');
            $this->loadModel('PartnerMailinglistGroups');
            $this->loadComponent('Emailverifier');
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
        	$keyword  =   '';
        	
        	if ($this->request->is(['post', 'put'])) {
        		$keyword  =   $this->request->data['keyword'];
        		$lkeyword  =   '%'.$keyword.'%';
        		if(trim($keyword) != ''){
        			$query = $this->PartnerMailinglists->find('all')->where(['PartnerMailinglists.first_name LIKE ' => $lkeyword])
        			->orWhere(['PartnerMailinglists.last_name LIKE ' => $lkeyword])
        			->orWhere(['PartnerMailinglists.email LIKE ' => $lkeyword]);
        			$this->set('vendors', $this->paginate($query));
        			$cmplemails =   $this->paginate($query);
        		}else{
        			$cmplemails =   $this->paginate($this->PartnerMailinglists);
        		}
        	}else{
        		$cmplemails =   $this->paginate($this->PartnerMailinglists);
        	}
        	/*
        	 * Section to find no of current participants
        	*/
        	$this->set('PartnerMailinglists', $cmplemails);
        	$this->set('keyword', $keyword);
        }
        
        /**
         * List method
         *
         * @return void
         */
        public function show($group_id=0) {
        	$keyword  =   '';
        	
        	if ($this->request->is(['post', 'put'])) {
        		$keyword  =   $this->request->data['keyword'];
        		$lkeyword  =   '%'.$keyword.'%';
        		if(trim($keyword) != ''){
        			$query = $this->PartnerMailinglists->find('all')->where(['PartnerMailinglists.first_name LIKE ' => $lkeyword])
        			->orWhere(['PartnerMailinglists.last_name LIKE ' => $lkeyword])
        			->orWhere(['PartnerMailinglists.email LIKE ' => $lkeyword])
        			->andWhere(['PartnerMailinglists.partner_mailinglist_group_id'=>$group_id]);
        			$this->set('vendors', $this->paginate($query));
        			$cmplemails =   $this->paginate($query);
        		}else{
        			$cmplemails =   $this->paginate($this->PartnerMailinglists->find()->where(['partner_mailinglist_group_id'=>$group_id]));
        		}
        	}else{
        		$cmplemails =   $this->paginate($this->PartnerMailinglists->find()->where(['partner_mailinglist_group_id'=>$group_id]));
        	}
        	
        	$group = $this->PartnerMailinglistGroups->get($group_id);
        	//print_r($group);
        	/*
        	 * Section to find no of current participants
        	*/
        	$this->set('PartnerMailinglists', $cmplemails);
        	$this->set('keyword', $keyword);
        	$this->set('group', $group);
        }
        
/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {		
		$partnerMailinglist = $this->PartnerMailinglists->get($id, [
			'contain' => ['Partners', 'Vendors']
		]);
		$this->set('partnerMailinglist', $partnerMailinglist);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add($grp_id = 0) {		
    	$partnerMailinglist = $this->PartnerMailinglists->newEntity($this->request->data);
		if ($this->request->is('post')) {
			// check email
			$ret = $this->Emailverifier->verify($this->request->data['email']);
			if($ret['status']=='valid')
			{
				if ($this->PartnerMailinglists->save($partnerMailinglist)) {
					$this->Flash->success('Your mailing list has been saved.');
					return $this->redirect(['action' => 'show',$grp_id]);
				} else {
					$this->Flash->error('Sorry, the mailing list could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
				}
			}
			else
				$this->Flash->error("The email you entered did not pass the verification! ".$ret['info'].". ".$ret['details']);
		}
		$this->set(compact('partnerMailinglist','grp_id'));
		$this->set('country_list',$this->country_list);
	}
	
	
	/**
	 * Add CSV method
	 *
	 * @return void
	 */
	
    public function addcsv($grp_id = 0) {
      $allowed_resource_file_types    =   ['text/csv','text/x-csv','application/vnd.ms-excel','"text/x-comma-separated-values"','application/force-download'];
      
      $upload_error   =   false;
      if ($this->request->is(['ajax'])) {
          
          $this->Filemanagement->allowed_resource_file_types = $allowed_resource_file_types;
		  //echo $this->request->data['importcsv']['type'];exit();
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
	             
	              // delete existing temp mailinglist verification data
	              $query = $this->PartnerMailinglistVerifications->query();
	              $query->delete()
	              		->where(['partner_id'=>$this->request->data['partner_id'],'vendor_id'=>$this->request->data['vendor_id']])
	              		->execute();
	              
	              // insert new temp data
	              $partnerMailinglist = $this->PartnerMailinglistVerifications->newEntities($new_frm_data);
	              $retval=false;
	              foreach($partnerMailinglist as $cmplist){
		              if ($this->PartnerMailinglistVerifications->save($cmplist)) {
		              	$retval=true;
					
		              }
	              }
	              if (true == $retval) {
					//$this->Flash->success('Please wait while we are verifying the email addresses.');
					return $this->redirect(['action' => 'verify']);
					
	              } else {
	              	$this->Flash->error('Sorry, the mailing list could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
	              }
          }
		  exit();
      }
	  
      $this->set(compact('partnerMailinglist','grp_id'));
	}
	public function errordropcsv($grp_id = null) {
		 $this->Flash->error('Sorry, file selected was not a valid csv file. Please try again. If you continue to experience problems, please contact Customer Support.');
		 return $this->redirect(['action' => 'addcsv',$grp_id]);
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
        $partnerMailinglist = $this->PartnerMailinglists->get($id);
                
		if ($this->request->is(['patch', 'post', 'put'])) {
			// check email
			$ret = $this->Emailverifier->verify($this->request->data['email']);
			if($ret['status']=='valid')
			{
                    if(isset($this->request->data['subscribe']) && !$this->request->data['subscribe'])
                      $this->request->data['subscribe']='Y';
                    
                    $partnerMailinglist = $this->PartnerMailinglists->patchEntity($partnerMailinglist, $this->request->data);
                    if ($this->PartnerMailinglists->save($partnerMailinglist)) {
                            $this->Flash->success('The mailing list has been saved.');
                            return $this->redirect(['action' => 'index']);
                    } else {
                            $this->Flash->error('Sorry, the mailing list could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                    }
            }
            else
                $this->Flash->error("The email you entered did not pass the verification! ".$ret['info'].". ".$ret['details']);
		}
		
		$this->set(compact('partnerMailinglist'));
		$this->set('country_list',$this->country_list);
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$partnerMailinglist = $this->PartnerMailinglists->get($id);
		$this->request->allowMethod('get', 'delete');
		if ($this->PartnerMailinglists->delete($partnerMailinglist)) {
			$this->Flash->success('The mailing list has been deleted.');
		} else {
			$this->Flash->error('Sorry, the mailing list could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
	
	public function verify() {
		if ($this->request->is(['ajax'])){
			$verification_pending = $this->PartnerMailinglistVerifications->find()
									->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status'=>'pending']);
			foreach($verification_pending as $contact)
			{
				if($ret = $this->Emailverifier->verify($contact->email))
				{
					$contact->status = $ret['status'];
					$contact->info = $ret['info'];
					$contact->code = $ret['code'];
					$contact->details = $ret['details'];
					$this->PartnerMailinglistVerifications->save($contact);
				}
				
			}
			echo "verifying";
			exit();
		}
	}
	
	public function verifyCheck() {
		if ($this->request->is(['ajax'])){
			$verification_total = $this->PartnerMailinglistVerifications->find()
									->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')]);
			$verification_processed = $this->PartnerMailinglistVerifications->find()
										->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status !='=>'pending']);
			
			$total = $verification_total->count();
			$completed = $verification_processed->count();
			$percent = ($total/$completed) * 100;
			echo $percent;
				
			exit();
		}
	}
	
	public function review($grp_id = 0) {
		$verification_total = $this->PartnerMailinglistVerifications->find()
									->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')])->count();
		
		$verification_valid = $this->PartnerMailinglistVerifications->find()
									->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status'=>'valid'])->count();
		
		$verification_suspect = $this->PartnerMailinglistVerifications->find()
									->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status'=>'suspect'])->count();
		
		$verification_invalid = $this->PartnerMailinglistVerifications->find()
									->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status'=>'invalid'])->count();
		
		$verification_indeterminate = $this->PartnerMailinglistVerifications->find()
									->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status'=>'indeterminate'])->count();
		
		$verification_error = $this->PartnerMailinglistVerifications->find()
									->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status'=>'error'])->count();
		
		$this->set(compact('verification_total','verification_valid','verification_suspect','verification_invalid','verification_indeterminate','verification_error','grp_id'));
	}
	
	public function verifyDownload($status)
	{
		header("Content-Disposition: attachment;filename=verifydata_$status.csv");
		header('Content-Type: text/csv');
		header("Accept-Ranges: bytes");
		header("Pragma: public");
		header("Expires: -1");
		header("Cache-Control: no-cache");
		header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
		
		$verification = $this->PartnerMailinglistVerifications->find()
								->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status'=>$status]);
		
		$out = fopen('php://output', 'w');
		
		fputcsv($out, ['First Name','Last Name','Email','Status','Code','Summary']);
		
		foreach($verification as $contact)
		{
			fputcsv($out, [$contact->first_name,$contact->last_name,$contact->email,$contact->status,$contact->code,$contact->info]);
		}
		
		fclose($out);
		ob_flush();
		flush();
		exit();
	}
	
	public function verifySave($grp_id=0)
	{
		$verification = $this->PartnerMailinglistVerifications->find()
						->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id'),'status'=>'valid']);
						//->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')]); //for test purpose only.
		$contacts_temp = [];
		
		$saved = false;
		foreach($verification as $contact)
		{
			$contact = $this->PartnerMailinglists->newEntity(['partner_id'=>$contact->partner_id,'vendor_id'=>$contact->vendor_id,'partner_mailinglist_group_id'=>$contact->partner_mailinglist_group_id,'first_name'=>$contact->first_name,'last_name'=>$contact->last_name,'email'=>$contact->email,'company'=>$contact->company,'industry'=>$contact->industry,'city'=>$contact->city,'country'=>$contact->country,'status'=>'Y']);
			if($this->PartnerMailinglists->save($contact))
				$saved = true;
		}
		
		if($saved!=false)
		{
			// delete existing temp mailinglist verification data
			$query = $this->PartnerMailinglistVerifications->query();
			$query	->delete()
					->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')])
					->execute();
			
			$this->Flash->success('The mailing list has been saved.');			
			return $this->redirect(['action' => 'show',$contact->partner_mailinglist_group_id]);
		}
		else
		{
			$this->Flash->error('Sorry, the mailing list could not be saved. Please try again.');
			return $this->redirect(['action' => 'review',$grp_id]);
		}
	}

        public function gettemplate(){
            if($this->Filemanagement->download('samplemailinglist/samplemlcsv.csv','defaultmailinglisttemplate','text/csv; charset=utf-8')){
                return $this->redirect($this->referer());
            }
            
        }
        public function bulkdelete(){
            if ($this->request->is(['patch', 'post', 'put'])) {
                $ids    =   explode(',',$this->request->data['ids']);
                foreach($ids as $id){
                    $cpms   =   $this->PartnerMailinglists->get($id);                    
                    $this->PartnerMailinglists->delete($cpms);
                }
                
                
            }
            return $this->redirect(['action' => 'index']);
            exit;
        }
        
        function __getdatafromCSV($frdata=array()){
        	$return_array   =   array();
        	$newfilename = WWW_ROOT  .'files' . DS .$frdata['importcsv'];
        	$arrLines = file($newfilename);
        	foreach($arrLines as $line) {
        		$arrResult[] = explode( ',', $line);
        	}
			ini_set('auto_detect_line_endings', true);
        	$i=0;
        	if (($handle = fopen($newfilename, "r")) !== FALSE) {
        		while (($file = fgetcsv($handle, 1000, ",")) !== FALSE) {
				
        			if($i>0){
        				$return_array[$i-1]['id']                           		=   $frdata['partner_id'].$frdata['vendor_id'].$i;
        				$return_array[$i-1]['partner_id']                           =   $frdata['partner_id'];
        				$return_array[$i-1]['vendor_id']                            =   $frdata['vendor_id'];
        				$return_array[$i-1]['partner_mailinglist_group_id']         =   $frdata['partner_mailinglist_group_id'];
        				$return_array[$i-1]['status']                               =   'pending';
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
        					$return_array[$i-1]['company']                          =   $file[3];
        				}
						if(isset($file[4])&& $file[4]!= ''){
        					$return_array[$i-1]['industry']                         =   $file[4];
        				}
						if(isset($file[5])&& $file[5]!= ''){
        					$return_array[$i-1]['city']                             =   $file[5];
        				}
						if(isset($file[6])&& $file[6]!= ''){
        					$return_array[$i-1]['country']                          =   $file[6];
        				}
        			}
        			$i++;
        		}
        		fclose($handle);
        		unlink($newfilename);
        	}
        
        	return $return_array;
        }
}
