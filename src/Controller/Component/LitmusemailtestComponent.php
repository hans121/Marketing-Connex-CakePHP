<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;

/**
 * Rackspace OpenCloud component
 */
class LitmusemailtestComponent extends Component {

    public      $http           = NULL;
    protected   $inboxGUID      = NULL;
    protected   $testID         = NULL; 

    protected $_defaultConfig = [
		'host'      => 'previews-api.litmus.com',
        'username'  => 'panovus-api',
        'password'  => 'EAq5U8^7!dU?tHm',
        'apiUrl'    => '/api/v1',
    ];

    public function __construct(ComponentRegistry $collection, array $config = array())
    {
        parent::__construct($collection, $config);
        $this->controller = $collection->getController();

        $this->http = new Client([
            'host'      => $this->_defaultConfig['host'],
            'scheme'    => 'https',
            'type'      => 'application/json',
            'auth'      => ['username' => $this->_defaultConfig['username'], 'password' => $this->_defaultConfig['password']]
        ]);
    }

    public function getSpamCheckers() {
        $testapps = $this->_getTestApplications();
        $testapps = $this->_grabSpamTypeOnly($testapps);
        $conn = $this->_connect($testapps);
        $this->inboxGUID    = $conn['InboxGuid'];
        $this->testID       = $conn['Id'];

        if($checkerEmails = $this->_getSpamSeedAddresses())
        {
            return ['InboxGUID'=>$this->inboxGUID,'TestID'=>$this->testID,'CheckerEmails'=>$checkerEmails];
        }
        else
            return false;

    }

    public function getEmailCheckers() {
        $testapps = $this->_getTestApplications();
        $testapps = $this->_grabEmailTypeOnly($testapps);
        $conn = $this->_connect($testapps);
        $this->inboxGUID    = $conn['InboxGuid'];
        $this->testID       = $conn['Id'];
		return ['InboxGUID'=>$this->inboxGUID,'TestID'=>$this->testID];
    }

    public function getStatus($testID) {
        $resp = $this->http->get(
            $this->_defaultConfig['apiUrl'].'/EmailTests/'.$testID
        );

        return $this->_parse($resp);
    }
	public function getLinkCheckers($bodyText) {
        $conn = $this->_connectLinkCheck($bodyText);
		
		$this->testID  = $conn['Id'];
		return $conn;
    }
	public function getlinkCheckerStatus($testID){
		$resp = $this->http->get(
            $this->_defaultConfig['apiUrl'].'/LinkTests/'.$testID
        );

        return $this->_parse($resp);
	}

    /* Private Functions */

    private function _connect($testapps='') {        
        $resp = $this->http->post(
            $this->_defaultConfig['apiUrl'].'/EmailTests',
            json_encode(["TestingApplications" => $testapps])
        );
        
        return $this->_parse($resp , true);
    }
    
	private function _connectLinkCheck($bodyText) {        
        
		$resp = $this->http->post(
            $this->_defaultConfig['apiUrl']."/LinkTests", "'{$bodyText}'");
		
        return $this->_parse($resp , true);
    }
	
    private function _getTestApplications() {
        $resp = $this->http->get(
            $this->_defaultConfig['apiUrl'].'/EmailTests/TestingApplications'
        );

        $res = $this->_parse($resp);    
        
        return $res;
    }

    private function _grabSpamTypeOnly($res) {
        $testapps = Array();
        foreach($res as $testapp)
            if($testapp['ResultType']==1 && preg_match('[(yahoo|gmail|gmx|postini|aol|mail\.com|sender policy framework|domainkeys|sender id)]i',$testapp['ApplicationLongName'])===0) // Only Use Spam type Test Apps excluding nonserver based type apps
                $testapps[] = $testapp;
            
        $res = $testapps;       
        
        return $res;
    }

    private function _grabEmailTypeOnly($res) {
        $testapps = Array();
        foreach($res as $testapp)
            if($testapp['ResultType']==0 && preg_match('[(lotus|aol|thunderbird|blackberry|plain text|android 2\.3|outlook 2000|outlook 2002|outlook 2003|outlook 2007|iphone 5s|iphone 6 plus|windows phone 8|color blindness|apple mail 7|ibm notes|office 365|outlook 2010|outlook 2013 120 dpi|gmail app|android 4\.2|ipad mini|google apps)]i',$testapp['ApplicationLongName'])===0) // Only Use Email type Test Apps
                $testapps[] = $testapp;
            
        $res = $testapps;       
        
        return $res;
    }

    private function _getSpamSeedAddresses() {
        $resp = $this->http->get(
            $this->_defaultConfig['apiUrl'].'/SpamSeedAddresses'
        );

        return $this->_parse($resp);
    }

    private function _parse($resp , $conn = false) {
        return $resp->code!=200 ? ($conn===true ? die($resp->body) : false) : json_decode($resp->body,true);
    }
    
}