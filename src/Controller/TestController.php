<?php
namespace App\Controller;
use App\Controller\AppController;
use Abraham\TwitterOAuth\TwitterOAuth;
/**
 * Users Controller
 *
 * @property App\Model\Table\UsersTable $Users
 */
class TestController extends AppController {
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
        // Allow users to register and logout.
        $this->Auth->allow(['index']);
		
		//$this->loadComponent('Socialmedia');
    }

    public function index(){
		//die('test');
		
		$users = ['test'=>'This is a test'];
		$twitterPost = $this->postTwitter();
		//$twitterCallback = $this->twitterCallback();
		$this->set(compact('users','twitterPost'));
	}
	
	private function postTwitter(){
		$this->twitterConnect = new TwitterOAuth($this->consumerKey, $this->consumerSecret, $this->token, $this->tokenSecret);
		$this->requestToken = $this->twitterConnect->oauth('oauth/request_token', array('oauth_callback' => 'http://localhost/marketingconnex.com/httpdocs/twitterCallback'));
				
		//$_SESSION['oauth_token'] = $this->requestToken['oauth_token'];
		//$_SESSION['oauth_token_secret'] = $this->requestToken['oauth_token_secret'];
		$this->request->session()->write('oauth_token',$this->requestToken['oauth_token']);
		$this->request->session()->write('oauth_token_secret',$this->requestToken['oauth_token_secret']);
		
		$this->twitterUrl = $this->twitterConnect->url('oauth/authorize', array('oauth_token' => $this->requestToken['oauth_token']));	
		
		
		return $this->twitterUrl;
		
		//return $this->twitterConnect;
	}
	
	private function postLinkedIn() {
		$resp = $this->Socialmedia->connectLinkedIn();
		return $resp;
	}
    
}       
