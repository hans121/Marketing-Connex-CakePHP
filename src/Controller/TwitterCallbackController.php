<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Abraham\TwitterOAuth\TwitterOAuth;
/**
 * Users Controller
 *
 * @property App\Model\Table\UsersTable $Users
 */
class TwitterCallbackController extends AppController {
	public $twitterConnect = NULL;
	public $linkedinhttp = NULL;
	public $requestToken = NULL;
	public $twitterUrl = NULL;
	public	$consumerKey='7oE1VeQjURjH9ZksRFbGzc7sT';
	public	$consumerSecret='qHtJtWiYrZwXUyIVMC15MCb8RpcRNmgLhskvFdpDwpkHoPuwUO';
	public	$token = '529419126-tmYSipKzaHlfIfNL3DNCOWszZM8mUiuuWeiEWn31';
	public	$tokenSecret = 'hyp5RbyPc86HsaEWwNs67azjD412sNPeGCloVGChW4oLb';
	
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
            return true;
        }
        // Default deny
        return false;
    }
	
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
		
		$this->loadModel('Partners');
       
		
        // Allow users to register and logout.
        $this->Auth->allow(['index']);
		
		//$this->loadComponent('Socialmedia');
    }

    public function index(){
		//die('test');
		
		$twitterCallback = $this->twitterCallback();
		$this->set(compact('twitterCallback'));
	}
	
	public function twitterCallback(){
		//echo "helloCallback";
		if(!empty($_GET['oauth_verifier']) && !empty($this->request->session()->read('oauth_token')) && !empty($this->request->session()->read('oauth_token_secret'))) {
		
		$connection = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->request->session()->read('oauth_token'), $this->request->session()->read('oauth_token_secret'));
				
		$access_tokencredential = $connection->getAccessToken($_REQUEST['oauth_verifier'], $this->request->session()->read('oauth_token'));
		
		$uniqueOauthToken = $access_tokencredential['oauth_token'];
		$uniqueOauthTokenSecret = $access_tokencredential['oauth_token_secret'];
		
		$twitteroauth = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $uniqueOauthToken,$uniqueOauthTokenSecret);	
		
			$message = "Tweet From Panovus Team!";
		
			//$output = $twitteroauth->get('friends/list');
			//$output = $twitteroauth->post("statuses/update", array("status" => $message));
			//echo"<pre style='color:red'>";
			//print_r($output);
			//echo'</pre>';
		
		
	/*
		echo"<pre style='color:red'>";
		print_r($access_tokencredential);
				echo "</pre>";
		*/		
			//return $output;
			$id =   $this->Auth->user('partner_id');
			$partner = $this->Partners->get($id);
			$data=[
				"twitter_oauth_token" => $uniqueOauthToken,
				"twitter_oauth_token_secret" => $uniqueOauthTokenSecret
			];
		
			$partner = $this->Partners->patchEntity($partner,$data);
			//echo "<pre style='color:red'>";
				//print_r($partner);
			//echo "</pre>";
			if ($this->Partners->save($partner)) {
				 $this->Flash->success('Token has been saved.');
				 return $this->redirect(['controller' => 'PartnerCampaignEmailSettings']);
			}else {
				$this->Flash->error('The partner could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
			
			
		}else {//end if get
			 $this->Flash->error('Authorization has failed!');
			 return $this->redirect(['controller' => 'PartnerCampaignEmailSettings']);
			
		}
	}
    
}       
