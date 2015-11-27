<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Network\Http\Client;
use Cake\Routing\Router;

/**
 * Salesforce component
 */
class SalesforceComponent extends Component {
		
	private $app = NULL;
	private $app_key = '3MVG9ZL0ppGP5UrBPdVksW7RCS.zbYGcDWRdmAA7n1ITItCkbBJWKiUMigAtCD4.XP395ZdrcoUl9oAc0DDGh';
	private $app_secret = '595515526676796548';
	private $callback_url = NULL;
	private $token = '';

    public function __construct(ComponentRegistry $collection, array $config = array())
    {
        parent::__construct($collection, $config);
        
        // initialize callback urls
        $router = new Router();
        $baseurl = $router->url('/', true);
        $this->callback_url 	= $baseurl.'external_apps/salesforce/callback';
        //end
        
        $this->controller = $collection->getController();
        $this->http = new Client();
		
        
        $this->controller->loadModel('Vendors');
        // prefetch vendor details
        $this->Vendors = $this->controller->Vendors;        
        $this->vendor_id = $this->controller->Auth->user('vendor_id');
        $this->vendor = $this->Vendors->get($this->vendor_id);
        // end prefetch
        
    }
	
    // functions here
    public function isAuth(){
    	if($user = $this->getUser())
    		if($user->user_id)
    		{
    			return true;
    		}
    		else
    			return $this->refreshToken();
    		
    	return false;
    }
    
    public function getUser(){
    	$vendor = $this->vendor;
    	$response = $this->http->get($vendor->salesforce_identity,[],['headers' => ['Authorization'=>'Bearer '.$vendor->salesforce_token]]);
    	return $this->_parse($response);
		
    }
    
    public function getToken(){
    	if(($code = $this->request->query('code')))
    	{
    		$response = $this->http->post('https://login.salesforce.com/services/oauth2/token?'.http_build_query([
    				'grant_type'=>'authorization_code',
    				'code'=>$code,
    				'redirect_uri'=>$this->callback_url,
    				'client_id'=>$this->app_key,
    				'client_secret'=>$this->app_secret
    				])
    		);
    	
    		if($response = $this->_parse($response))
    		{
	    		$vendor = $this->Vendors->patchEntity($this->vendor,['salesforce_token'=>$response->access_token,'salesforce_refresh_token'=>$response->refresh_token,'salesforce_instance_url'=>$response->instance_url,'salesforce_identity'=>$response->id]);
	    		$this->Vendors->save($vendor);
				
				$this->vendor = $vendor;
	    		
	    		return true;
    		}
    	}
    	return false;
    }
    
    public function refreshToken() {
    	if($this->vendor->salesforce_refresh_token!='')
    	{
	    	$response = $this->http->post('https://login.salesforce.com/services/oauth2/token?'.http_build_query([
	    			'grant_type'=>'refresh_token',
	    			'refresh_token'=>$this->vendor->salesforce_refresh_token,
	    			'client_id'=>$this->app_key,
	    			'client_secret'=>$this->app_secret
	    			])
	    	);
	    	
	    	if($response = $this->_parse($response))
	    	{
		    	$vendor = $this->Vendors->patchEntity($this->vendor,['salesforce_token'=>$response->access_token,'salesforce_instance_url'=>$response->instance_url,'salesforce_identity'=>$response->id]);
		    	$this->Vendors->save($vendor);
					
				$this->vendor = $vendor;
		    		
		    	return true;
	    	}
    	}
    	
    	return false;    	 
    }
    
	public function getURL(){
		return 'https://login.salesforce.com/services/oauth2/authorize?response_type=code&client_id='.urlencode($this->app_key).'&redirect_uri='.urlencode($this->callback_url);
	}
	
	private function _parse($resp) {
		$good_codes = ['200','201'];
		return !in_array($resp->code,$good_codes) ? false : json_decode($resp->body);
	}
	
}