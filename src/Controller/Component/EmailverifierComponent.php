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
 * Email Verifier component
 */
class EmailverifierComponent extends Component {
		
	private $api_key = 'ev-bb61957a33cc3a04b18ba5853996007b';
	private $api_url = 'email-validator.net/api/verify';

    public function __construct(ComponentRegistry $collection, array $config = array())
    {
        parent::__construct($collection, $config);
        
        $this->http = new Client();       
    }
    
    public function verify($email='')
    {
    	$response = $this->http->post('http://api.'.$this->api_url,['EmailAddress'=>$email,'APIKey'=>$this->api_key]);
    	if($ret = $this->_parse($response))
    	{
	    	if($ret->status >= 200 && $ret->status <= 215) //valid
	    	{
	    		return ['status'=>'valid','code'=>$ret->status,'info'=>$ret->info,'details'=>$ret->details];
	    	}
	    	elseif($ret->status >= 302 && $ret->status <= 317) //suspect
	    	{
	    		return ['status'=>'suspect','code'=>$ret->status,'info'=>$ret->info,'details'=>$ret->details];
	    	}
	    	elseif($ret->status >= 401 && $ret->status <= 420) //invalid
	    	{
	    		return ['status'=>'invalid','code'=>$ret->status,'info'=>$ret->info,'details'=>$ret->details];
	    	}
	    	elseif($ret->status >= 114 && $ret->status <= 121) //indeterminate
	    	{
	    		return ['status'=>'indeterminate','code'=>$ret->status,'info'=>$ret->info,'details'=>$ret->details];
	    	}
	    	else //error
	    		return ['status'=>'error','code'=>$ret->status,'info'=>$ret->info,'details'=>$ret->details];
    	}
    	else
    		return false;
    }
    
	private function _parse($resp) {
		$good_codes = ['200'];
		return !in_array($resp->code,$good_codes) ? false : json_decode($resp->body);
	}
	
}