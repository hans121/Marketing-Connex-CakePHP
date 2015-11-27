<?php
namespace App\Controller;
use App\Controller\AppController;
//use Abraham\TwitterOAuth\TwitterOAuth;
/**
 * Users Controller
 *
 * @property App\Model\Table\UsersTable $Users
 */
class SocialAppsController extends AppController {
	
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
	
	public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
		
		$this->loadModel('Partners');
    }

    public function index(){
    	return $this->redirect(['controller' => 'Partners','action' => 'index']);
	}
	
	// Start Facebook Functions
	public function facebook($action='callback') {
		
		switch($action)
		{
			case 'callback':
				$facebookCallback = $this->facebookCallback();
				//$this->set(compact('twitterCallback'));
				break;
		}
		
	}
	public function facebookCallback(){
		
		$this->loadComponent('Socialmedia');
		if ($this->Socialmedia->facebook_callback()) {
			$this->Flash->success('Your account has been connected to the app.');
			
		}else{
			$this->Flash->error('Your account has not been connected to the app.');
	
		}
		$redirect_url = $this->request->session()->read('facebook_redirect_url');
		$this->request->session()->write('facebook_redirect_url','');
		return $this->redirect($redirect_url);
	}
	public function facebookInitialize() {
		$this->request->session()->write('facebook_redirect_url',$this->referer());
		$this->loadComponent('Socialmedia');
		$facebookUrl = $this->Socialmedia->facebook_initialize();
		return $this->redirect($facebookUrl);
	}
	
	// Start Twitter Functions
	
	public function twitter($action='callback') {
		
		switch($action)
		{
			case 'callback':
				$twitterCallback = $this->twitterCallback();
				//$this->set(compact('twitterCallback'));
				break;
		}
		
	}
	
	public function twitterCallback(){
		
		$this->loadComponent('Socialmedia');
		if ($this->Socialmedia->twitter_callback()) {
			$this->Flash->success('Your account has been connected to the app.');
			
		}else{
			$this->Flash->error('Your account has not been connected to the app.');
	
		}
		$redirect_url = $this->request->session()->read('twitter_redirect_url');
		$this->request->session()->write('twitter_redirect_url','');
		return $this->redirect($redirect_url);
	}
	
	public function twitterInitialize() {
		$this->request->session()->write('twitter_redirect_url',$this->referer());
		$this->loadComponent('Socialmedia');
		$twitterUrl = $this->Socialmedia->twitter_initialize();
		return $this->redirect($twitterUrl);
	}
	
	// End Twitter Functions
	
	/************************************************************/
	
	// Start Linkedin Functions
	
	public function linkedin($action='callback') {
		$this->layout = 'ajax';
		switch($action)
		{
			case 'callback':
				$this->linkedinCallback();
				break;
		}
	}
	
	public function linkedinCallback() {
		$this->loadComponent('Socialmedia');
	
		
		if($this->request->query('error'))
		{
			if($this->request->query['error']=='access_denied')//if user rejected linkedin access
				$this->Flash->error(__('You rejected access to your linkedin account, we won\'t be able to post your email campaign to your profile.'));
			elseif($this->request->query['error']!='')//other error aside from user rejected request
				$this->Flash->error(__('Your Linkedin authorization failed. Please try again below.'));			
		}
		
		if(($code = $this->request->query('code')) && ($state = $this->request->query('state')))
		{
			$is_expiring = $this->Socialmedia->linkedin_isExpiring();
			if($this->Socialmedia->linkedin_getToken())
			{
				if(false == $is_expiring)
					$this->Flash->success(__('Your have successfully authorized us to act as you on linkedin.'));
			}
			else
				$this->Flash->error(__('Your Linkedin authorization failed. Please try again below.'));
		}
		
		$redirect_url = $this->request->session()->read('linkedin_redirect_url');
		$this->request->session()->write('linkedin_redirect_url','');
		return $this->redirect($redirect_url);
	}
	
	public function linkedinInitialize() {
		$this->request->session()->write('linkedin_redirect_url',$this->referer());
		$this->loadComponent('Socialmedia');
		$linkedinUrl = $this->Socialmedia->linkedin_getURL();
		return $this->redirect($linkedinUrl);
	}
	
	// End Linkedin Functions
	
	public function test() {
		$this->loadComponent('Socialmedia');
		
	}
    
}       
