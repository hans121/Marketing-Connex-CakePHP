<?php
namespace App\Controller;
use App\Controller\AppController;

/**
 * Users Controller
 *
 * @property App\Model\Table\UsersTable $Users
 */
class ExternalAppsController extends AppController {
	
	public function isAuthorized($user) {
		if(isset($user['status']) && $user['status'] === 'S') {
			$this->Flash->error(__('Your account is suspended, please contact Customer Support'));
			return $this->redirect(['controller' => 'Users','action' => 'vendorSuspended']);
		} elseif(isset($user['status']) && $user['status'] === 'B') {
			$this->Flash->error(__('Your account is blocked, please contact Customer Support'));
			return $this->redirect(['controller' => 'Users','action' => 'vendorBlocked']);
		} elseif(isset($user['status']) && $user['status'] === 'D') {
			$this->Flash->error(__('Your account is inactive, please contact Customer Support'));
			return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);
		} elseif(isset($user['status']) && $user['status'] === 'P') {
			$this->Flash->error(__('Your account is inactive, please contact Customer Support'));
			return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);
		} elseif(isset($user['role']) && $user['role'] === 'vendor') {
			return true;
		}
		// Default deny
		return false;
	}
	
	public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
		
		$this->loadModel('Vendors');
    }

    public function index(){
    	return $this->redirect(['controller' => 'Vendors','action' => 'index']);
	}
	
	// Start Salesforce Functions
	
	public function salesforce($action='callback') {
		$this->layout = 'ajax';
		switch($action)
		{
			case 'callback':
				$this->salesforceCallback();
				break;
		}
	}
	
	public function salesforceCallback() {
		$this->loadComponent('Salesforce');
	
	
		if($this->request->query('error'))
		{
			if($this->request->query['error']=='access_denied')//if user rejected salesforce access
				$this->Flash->error(__('You rejected access to your salesforce account, we won\'t be able to act on your behalf.'));
			elseif($this->request->query['error']!='')//other error aside from user rejected request
			$this->Flash->error(__('Your Salesforce authorization failed. Please try again below.'));
		}
	
		if(($code = $this->request->query('code')))
		{
			//$is_expiring = $this->Externalapps->salesforce_isExpiring();
			if($this->Salesforce->getToken())
			{
				//if(false == $is_expiring)
					$this->Flash->success(__('Your have successfully authorized us to act as you on salesforce.'));
			}
			else
				$this->Flash->error(__('Your Salesforce authorization failed. Please try again.'));
		}
	
		$redirect_url = $this->request->session()->read('salesforce_redirect_url');
		$this->request->session()->write('salesforce_redirect_url','');
		return $this->redirect($redirect_url);
	}
	
	public function salesforceInitialize() {
		$this->request->session()->write('salesforce_redirect_url',$this->referer());
		$this->loadComponent('Salesforce');
		$salesforceUrl = $this->Salesforce->getURL();
		return $this->redirect($salesforceUrl);
	}
		
	// End Salesforce Functions
	
	public function test() {
		$this->loadComponent('Salesforce');
				
	}
    
}       
