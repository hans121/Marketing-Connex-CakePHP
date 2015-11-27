<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;

/**
 * Limos component
 */
class LitmosComponent extends Component {

    public      $http           = NULL;
    protected   $inboxGUID      = NULL;
    protected   $testID         = NULL; 

    protected $_defaultConfig = [
		'host'      => 'api.litmos.com/v1.svc',
        'username'  => 'mark.duffey@panovus.com',
        'password'  => 'Brompton1',
        'apiKey'    => '13903DEE-3167-4941-886C-D53FD0B37876',
		'apiUrl'    => '/api/v1',
		'source'    => 'panovus',
		'sandbox'	=> true
    ];

    public function __construct(ComponentRegistry $collection, array $config = array())
    {
        parent::__construct($collection, $config);
        $this->controller = $collection->getController();

        $this->http = new Client([
            'host'      => $this->_defaultConfig['host'],
            'scheme'    => 'https',
            'type'      => 'application/json',
			'auth'      => ''
            //'auth'      => ['username' => $this->_defaultConfig['username'], 'password' => $this->_defaultConfig['password']]
        ]);
    }

    public function addUser($UserName,$FirstName,$LastName) {
       $resp = $this->http->post("/users?apikey=".$this->_defaultConfig['apiKey']."&source=".$this->_defaultConfig['source'],
			json_encode([
				"UserName"	 		 =>	$UserName,
				"FirstName" 		 => $FirstName,
				"LastName"           => $LastName,
				"AccessLevel"        => "Administrators",
				"Active"             => true,
				"IsCustomUsername"   => true,
				"SkipFirstLogin"     => true,
				"DisableMessages"    => false,
				"sendmessage"  		 => false
				
			])
	   );
	   
	  
      // return $this->_parse($resp);
	   return $resp;
    }
	
	
	public function getUser() {
		$resp = $this->http->get("/users?apikey=".$this->_defaultConfig['apiKey']."&source=".$this->_defaultConfig['source']);
		return $resp;
    }
    public function signIn($user_id) {
		$resp = $this->http->get("/users/{$user_id}?apikey=".$this->_defaultConfig['apiKey']."&source=".$this->_defaultConfig['source']);
		return $resp;
    }
	//echo "<pre>";print_r($signIn);echo "</pre>";
    private function _parse($resp , $conn = false) {
        return $resp->code!=200 ? ($conn===true ? die($resp->body) : false) : json_decode($resp->body,true);
    }
    
}