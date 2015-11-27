<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Http\Client;
use Cake\Routing\Router;

use Abraham\TwitterOAuth\TwitterOAuth;

use Facebook\GraphSessionInfo;
use Facebook\FacebookSession;
use Facebook\FacebookCurl;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookResponse;
use Facebook\FacebookAuthorizationException;
use Facebook\FacebookRequestException;
use Facebook\FacebookRequest;
use Facebook\FacebookSDKException;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\Entities\AccessToken;
use Facebook\FacebookCanvasLoginHelper;


/**
 * Rackspace OpenCloud component
 */
class SocialmediaComponent extends Component {
		
		
	private $facebook = [
		'appID'=>'868951443178050',
		'appSecret' =>'688f110c6d6c585880cef796f6177ae0',
		'default_scope' =>'public_profile,publish_actions,manage_pages,publish_pages',
		'callback_url' =>NULL
		];
	
	private $twitter = [
		'app_key'=>'oUNXMJX8ZRRYZhowSEUmZ0bp5',
		'app_secret'=>'qTXvenj9fvSK3OEauQWeFfkjsGqM2jamUQUCZHOaLjVtKQVQFn',
		'token'=>'2647245739-V2oH6ESDLzvb7hadhP7HsRwBX3K7zCDWg3bJVkb',
		'token_secret'=>'wRzM7BQLBsHig1meM5IhE8B9ohtusplTVaXtbADbIBHV2',
		'callback_url'=>NULL
		
	];
	private $linkedin = [
		'app'=>NULL,
		'app_key'=>'758u0do3zbxa3h',
		'app_secret'=>'RUnye3f7Y4LqSV2b',
		'callback_url'=>NULL,
		'token'=>''
	];

    public function __construct(ComponentRegistry $collection, array $config = array())
    {
        parent::__construct($collection, $config);
        
        // initialize callback urls
        $router = new Router();
        $baseurl = $router->url('/', true);
        $this->facebook['callback_url'] 	= $baseurl.'social_apps/facebook/callback';
        $this->twitter['callback_url'] 		= $baseurl.'social_apps/twitter/callback';
        $this->linkedin['callback_url'] 	= $baseurl.'social_apps/linkedin/callback';
        //end
        
        $this->controller = $collection->getController();
        $this->http = new Client();
		
		FacebookSession::setDefaultApplication( $this->facebook['appID'], $this->facebook['appSecret']);
        
        $this->controller->loadModel('Partners');
        // prefetch partner details
        $this->Partners = $this->controller->Partners;        
        $this->partner_id = $this->controller->Auth->user('partner_id');
        $this->partner = $this->Partners->get($this->partner_id);
        // end prefetch
        
    }
	// facebook functions here
	public function facebook_helper() {
		$redirectUrl= $this->facebook["callback_url"];
		$helper = new FacebookRedirectLoginHelper($redirectUrl);
		try {
			$session = $helper->getSessionFromRedirect();
		} catch(FacebookSDKException $e) {
			$session = null;
		}
		return compact('helper','session');
	}
	public function facebook_initialize() {
		$fbInit = $this->facebook_helper();
		
		//$params = array('scope'=> $this->facebook['default_scope'],'redirect_uri'=>'http://localhost/marketingconnex.com/httpdocs/social_apps/facebook/callback');
		$params = array(
  'scope' => $this->facebook['default_scope']
);

		
		
		$loginUrl = $fbInit['helper']->getLoginUrl($params);
		
		return $loginUrl;
	}
	public function facebook_callback() {
		$fbInit = $this->facebook_helper();
		
		
		if($fbInit['session']) {
			$user_profile = (new FacebookRequest(
					$fbInit['session'], 'GET', '/me' ))->execute()->getGraphObject(GraphUser::className());
					
			$accessToken = $fbInit['session']->getAccessToken();
			$longLivedAccessToken = $accessToken->extend();
			$accessTokenInfo = $longLivedAccessToken->getInfo();
			
			$data = $accessTokenInfo->asArray();
			$userProfileUrl = "https://www.facebook.com/app_scoped_user_id/".$data['user_id'];
			
			$partner = $this->Partners->patchEntity($this->partner,["fb_longlived_access_token" => $longLivedAccessToken,"facebook" => $userProfileUrl]);

			$this->Partners->save($partner);
			return true;
			
		}elseif($this->request->query('error')){ //denied
			return false;
		}
		
	}
	public function facebook_isauth() {
	
	
		$partner = $this->partner;
		if($partner->fb_longlived_access_token =='') {// not authorized if blank
			return false;
		}
		
		$longLivedAccessToken = new AccessToken($partner->fb_longlived_access_token);
		
		try {
			// Get a code from a long-lived access token
			$code = AccessToken::getCodeFromAccessToken($longLivedAccessToken);
				//$this->post_facebook_pages('123',1231,1232);die();		
			if($code) 
			return true;
			
		} catch(FacebookSDKException $e) {
			//echo 'Error getting code: ' . $e->getMessage();
			//exit;
			return false;
		}
		
	}
	
	public function facebook_post($message,$link) {
		$partner = $this->partner;
		
		$session = new FacebookSession($partner->fb_longlived_access_token);
		if($session) {
		
		  try {
			
			$response = (new FacebookRequest(
			  $session, 'POST', '/me/feed', array(
				'link' => $link,
				'message' => $message
			  )
			))->execute()->getGraphObject();
			
			//echo "Posted with id: " . $response->getProperty('id');die();
		  } catch(FacebookRequestException $e) {
			//echo "Exception occured, code: " . $e->getCode();
			//echo " with message: " . $e->getMessage();die();
		  }   
		}
	}
	public function post_facebook_pages($page_id,$page_access_token,$message,$link) {
			
		
		$session = new FacebookSession($page_access_token);
		if($session) {
		
		  try {
					
			$response = (new FacebookRequest(
			  $session, 'POST', "/{$page_id}/feed", array(
				'link' => $link,
				'message' => $message
			  )
			))->execute()->getGraphObject();
			
			//echo "Posted with id: " . $response->getProperty('id');die();
		  } catch(FacebookRequestException $e) {
			//echo "Exception occured, code: " . $e->getCode();
			//echo " with message: " . $e->getMessage();die();
		  }   
		}
	}
	public function search_fb_pages() {
		$partner = $this->partner;
		
		
		$longLivedAccessToken = new AccessToken($partner->fb_longlived_access_token);
		$code = AccessToken::getCodeFromAccessToken($longLivedAccessToken);
		$newLongLivedAccessToken = AccessToken::getAccessTokenFromCode($code);
		$session = new FacebookSession($newLongLivedAccessToken);
		if($session) {
			$user_id = (new FacebookRequest(
			  $session, 'GET', '/me'
			))->execute()->getGraphObject(GraphUser::className());
			
			$pages = (new FacebookRequest(
			  $session, "GET", "/{$user_id->getId()}/accounts"
			))->execute()->getGraphObject(GraphUser::className());
					
			
			$data = $pages->asArray();
			
			return $data;
		}
		
	}
	 
    // twitter functions here
	public function twitter_connection($token='',$token_secret='') {
		if($token!='' && $token_secret!='')
			$twitterConnect = new TwitterOAuth($this->twitter['app_key'], $this->twitter['app_secret'],$token,$token_secret);
		else 
			$twitterConnect = new TwitterOAuth($this->twitter['app_key'], $this->twitter['app_secret']);
		return $twitterConnect;
	}
	public function twitter_initialize() {
			
		$twitterConnect = $this->twitter_connection();
		$requestToken = $twitterConnect->oauth('oauth/request_token', array('oauth_callback' => $this->twitter['callback_url']));
		
		$this->request->session()->write('oauth_token',$requestToken['oauth_token']);
		$this->request->session()->write('oauth_token_secret',$requestToken['oauth_token_secret']);
			
		
		$twitter_url = $twitterConnect->url('oauth/authorize', array('oauth_token' => $requestToken['oauth_token']));
		return $twitter_url;
		
	}
	public function twitter_callback() {
	

		if($this->request->query('denied')){ //denied
			return false;
		}else {
			if ($this->request->query('oauth_token') && $this->request->session()->read('oauth_token') !== $this->request->query('oauth_token')) // deny if request manipulated
				return false;
			
			$connection = $this->twitter_connection($this->request->session()->read('oauth_token'), $this->request->session()->read('oauth_token_secret'));
			
		
			$access_tokencredential = $connection->oauth("oauth/access_token", array("oauth_verifier" => $this->request->query('oauth_verifier')));
			
			$profileurl = 'https://twitter.com/'.$access_tokencredential['screen_name'];
			$uniqueOauthToken = $access_tokencredential['oauth_token'];
			$uniqueOauthTokenSecret = $access_tokencredential['oauth_token_secret'];


			$partner = $this->Partners->patchEntity($this->partner,["twitter_oauth_token" => $uniqueOauthToken,"twitter_oauth_token_secret" => $uniqueOauthTokenSecret,"twitter"=>$profileurl]);

			$this->Partners->save($partner);
			return true;
		}	
		
		
	}
    public function twitter_isauth() {
		$partner = $this->partner;
		
		if($partner->twitter_oauth_token=='' || $partner->twitter_oauth_token_secret=='') // not authorized if blank
			return false;
		
		$connection = $this->twitter_connection($partner->twitter_oauth_token, $partner->twitter_oauth_token_secret);

		$status = $connection->get("application/rate_limit_status");
		if(200 == $connection->getLastHttpCode() && !isset($status->errors))
			return true;
		elseif(isset($status->errors))
		{
			switch($status->errors[0]->code)
			{
				case '88':
					$this->controller->Flash->error('Twitter API ping rate limit exceeded. Please revisit page within 15 minutes. Or contact support if problem persists.');
					break;
				case '89': // Invalid token
					// do not inform just return false
					break;
			}
		}
		
		
		return false;
	}
	public function twitter_tweet($tweet) {

		$partner = $this->partner;
		$connection = $this->twitter_connection($partner->twitter_oauth_token, $partner->twitter_oauth_token_secret);
		
		$output = $connection->post("statuses/update", array("status" => $tweet));
		var_dump($connection);
	}
    // linkedin functions here
    public function linkedin_isAuth(){
    	if($user = $this->linkedin_getUser())
    		if($user->id)
    		{
    			// check if token approaching expired, then renew while active
				if(true == $this->linkedin_isExpiring())
					return $this->controller->redirect(['controller'=>'SocialApps','action'=>'linkedinInitialize']);
    			return true;
    		}
    		else
    			return false;
    		
    	return false;
    }
    
    public function linkedin_isExpiring(){
    	$today = strtotime(date('Y-m-d h:i:s'));
    	$expiry = strtotime($this->partner->linkedin_oauth_token_expiry);
    	if($expiry > $today)
    	{
    		if(($expiry - $today)<=864000) //if 10 days to expiry
    			return true;
    		
    		return false;
    	}
    	
    	return false;
    }
    
    public function linkedin_getUser(){
    	$partner = $this->partner;
    	$response = $this->http->get('https://api.linkedin.com/v1/people/~:(id,public-profile-url)?format=json',[],['headers' => ['Authorization'=>'Bearer '.$partner->linkedin_oauth_token]]);
    	return $this->_parse($response);
		
    }
    
    public function linkedin_getCompanies(){    	
    	$partner = $this->partner;
    	$response = $this->http->get('https://api.linkedin.com/v1/companies?format=json&is-company-admin=true',[],['headers' => ['Authorization'=>'Bearer '.$partner->linkedin_oauth_token]]);
       	return $this->_parse($response);
    }
    
    public function linkedin_getToken(){
    	if(($code = $this->request->query('code')) && ($state = $this->request->query('state')))
    	if($state==$this->request->session()->read('Linkedin.state'))
    	{
    		$response = $this->http->post('https://www.linkedin.com/uas/oauth2/accessToken?'.http_build_query([
    				'grant_type'=>'authorization_code',
    				'code'=>$code,
    				'redirect_uri'=>$this->linkedin['callback_url'],
    				'client_id'=>$this->linkedin['app_key'],
    				'client_secret'=>$this->linkedin['app_secret']
    				])
    		);
    	
    		if($response = $this->_parse($response))
    		{
	    		$partner = $this->Partners->patchEntity($this->partner,['linkedin_oauth_token'=>$response->access_token,'linkedin_oauth_token_expiry'=>date('Y-m-d h:i:s',time()+$response->expires_in)]);
	    		$this->Partners->save($partner);
				
				$this->partner = $partner;
				
				if($user = $this->linkedin_getUser())
				{
					$partner = $this->Partners->patchEntity($partner,['linkedin'=>$user->publicProfileUrl]);
					$this->Partners->save($partner);
				}
	    		
	    		return true;
    		}
    	}
    	return false;
    }
    
	public function linkedin_getURL(){
		$curr_state = $this->linkedin_getState();
		return 'https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id='.urlencode($this->linkedin['app_key']).'&redirect_uri='.urlencode($this->linkedin['callback_url']).'&state='.urlencode($curr_state);
	}
	
	public function linkedin_postPersonal($comment){
		$partner = $this->partner;
		$response = $this->http->post('https://api.linkedin.com/v1/people/~/shares?format=json',json_encode(['comment'=>$comment,'visibility'=>['code'=>'anyone']]),['type'=>'json','headers' => ['Authorization'=>'Bearer '.$partner->linkedin_oauth_token]]); //,'Content-Type'=>'application/json','x-li-format'=>'json'
		return $this->_parse($response);
	}
	
	public function linkedin_postCompany($companyID,$comment){
		$partner = $this->partner;
		$response = $this->http->post('https://api.linkedin.com/v1/companies/'.$companyID.'/shares?format=json',json_encode(['comment'=>$comment,'visibility'=>['code'=>'anyone']]),['type'=>'json','headers' => ['Authorization'=>'Bearer '.$partner->linkedin_oauth_token]]); //,'Content-Type'=>'application/json','x-li-format'=>'json'
		return $this->_parse($response);
	}
	
	
	protected function linkedin_getState(){
		$curr_state = $this->request->session()->read('Linkedin.state');
		if($curr_state!=null)
			return $curr_state;
		else 
		{
			$curr_state = md5(uniqid(mt_rand(), true));
			$this->request->session()->write('Linkedin.state',$curr_state);
			return $curr_state;
		}
	}
	
	private function _parse($resp) {
		$good_codes = ['200','201'];
		return !in_array($resp->code,$good_codes) ? false : json_decode($resp->body);
	}
	
}