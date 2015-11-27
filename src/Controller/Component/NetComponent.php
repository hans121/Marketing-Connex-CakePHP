<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Net component
 */
class NetComponent extends Component {

/**
 * Default configuration.
 *
 * @var array
 */
 
 //GATEWAY ID = 1430199
        public $loginname;
        public $transactionkey;
  protected $_defaultConfig = [
		'loginname' => '7jxPy288Dpe7',
		'transactionkey' => '7ar837Q3sDL4MjRY',
		'host' => 'api.authorize.net',
		'path' => '/xml/v1/request.api'
	];
	protected $_gbpConfig = [
		'loginname' => '4eSVgJE73rt7',
		'transactionkey' => '2m43kd44RpKXtQ3v',
		'host' => 'api.authorize.net',
		'path' => '/xml/v1/request.api'
	];
	protected $_eurConfig = [
		'loginname' => '28fxkJC3ZYrB',
		'transactionkey' => '3DHB5u7R4vhQp982',
		'host' => 'api.authorize.net',
		'path' => '/xml/v1/request.api'
	];
	/****NOTE***
	Please download the PHP SDK available at https://developer.authorize.net/downloads/ for more current code.
	*/
	
	/*
	D I S C L A I M E R                                                                                          
	WARNING: ANY USE BY YOU OF THE SAMPLE CODE PROVIDED IS AT YOUR OWN RISK.                                                                                   
	Authorize.Net provides this code "as is" without warranty of any kind, either express or implied, including but not limited to the implied warranties of merchantability and/or fitness for a particular purpose.   
	Authorize.Net owns and retains all right, title and interest in and to the Automated Recurring Billing intellectual property.
	*/ 
	//function to send xml request via fsockopen
	function send_request_via_fsockopen($host,$path,$content)
	{
		$posturl = "ssl://" . $host;
		$header = "Host: $host\r\n";
		$header .= "User-Agent: PHP Script\r\n";
		$header .= "Content-Type: text/xml\r\n";
		$header .= "Content-Length: ".strlen($content)."\r\n";
		$header .= "Connection: close\r\n\r\n";
		$fp = fsockopen($posturl, 443, $errno, $errstr, 30);
		if (!$fp)
		{
			$response = false;
		}
		else
		{
			error_reporting(E_ERROR);
			fputs($fp, "POST $path  HTTP/1.1\r\n");
			fputs($fp, $header.$content);
			fwrite($fp, $out);
			$response = "";
			while (!feof($fp))
			{
				$response = $response . fgets($fp, 128);
			}
			fclose($fp);
			error_reporting(E_ALL ^ E_NOTICE);
		}
		return $response;
	}
	
	//function to send xml request via curl
	function send_request_via_curl($host,$path,$content)
	{
		$posturl = "https://" . $host . $path;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $posturl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		return $response;
	}
	
	
	//function to parse Authorize.net response
	function parse_return($content)
	{
		$refId = $this->substring_between($content,'<refId>','</refId>');
		$resultCode = $this->substring_between($content,'<resultCode>','</resultCode>');
		$code = $this->substring_between($content,'<code>','</code>');
		$text = $this->substring_between($content,'<text>','</text>');
		$subscriptionId = $this->substring_between($content,'<subscriptionId>','</subscriptionId>');
                $status = $this->substring_between($content,'<status>','</status>');
		return array ('refId'=>$refId,'resultCode'=> $resultCode, 'code'=>$code, 'text'=>$text,'subscriptionId'=> $subscriptionId,'status'=>$status);
	}
	
	//helper function for parsing response
	function substring_between($haystack,$start,$end) 
	{
		if (strpos($haystack,$start) === false || strpos($haystack,$end) === false) 
		{
			return false;
		} 
		else 
		{
			$start_position = strpos($haystack,$start)+strlen($start);
			$end_position = strpos($haystack,$end);
			return substr($haystack,$start_position,$end_position-$start_position);
		}
	}
	public function subscription_create($data){
           // echo $data["currency_choice"]."<hr>";
            //define variables to send
            $amount = $data["amount"];
            $refId = $data["refId"];
            $name = $data["name"];
            $length = $data["length"];
            $unit = $data["unit"];
            $startDate = $data["startDate"];
            $totalOccurrences = $data["totalOccurrences"];
            //$trialOccurrences = $data["trialOccurrences"];
            $trialOccurrences = 1;
            $trialAmount = $data["trialAmount"];
            $cardNumber = $data["cardNumber"];
            $expirationDate = $data["expirationDate"];
            $firstName = $data["firstName"];
            $lastName = $data["lastName"];
            $invoice_number = $data["invoice_number"];
            $vendor_id = $data["vendor_id"];
            
            $currency_choice = $data["currency_choice"];
            $content =
            "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
            "<ARBCreateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
            "<merchantAuthentication>";
			
			if ($currency_choice == "GBP") {
				$content .=
				"<name>" . $this->_gbpConfig['loginname'] . "</name>".
				"<transactionKey>" . $this->_gbpConfig['transactionkey'] . "</transactionKey>";
			} elseif ($currency_choice == "EUR") {
				$content .=
				"<name>" . $this->_eurConfig['loginname'] . "</name>".
				"<transactionKey>" . $this->_eurConfig['transactionkey'] . "</transactionKey>";
			} else {
				$content .=
				"<name>" . $this->_defaultConfig['loginname'] . "</name>".
				"<transactionKey>" . $this->_defaultConfig['transactionkey'] . "</transactionKey>";
			};
			$content .=
            "</merchantAuthentication>".
            "<refId>" . $refId . "</refId>".
            "<subscription>".
            "<name>" . $name . "</name>".
            "<paymentSchedule>".
            "<interval>".
            "<length>". $length ."</length>".
            "<unit>". $unit ."</unit>".
            "</interval>".
            "<startDate>" . $startDate . "</startDate>".
            "<totalOccurrences>". $totalOccurrences . "</totalOccurrences>".
            "<trialOccurrences>". $trialOccurrences . "</trialOccurrences>".
            "</paymentSchedule>".
            "<amount>". $amount ."</amount>".
            "<trialAmount>" . ($trialAmount + $amount) . "</trialAmount>".
            "<payment>".
            "<creditCard>".
            "<cardNumber>" . $cardNumber . "</cardNumber>".
            "<expirationDate>" . $expirationDate . "</expirationDate>".
            "<cardCode>" . $data['cardCode'] ."</cardCode>".
            "</creditCard>".
            "</payment>".
            "<order>".
            "<invoiceNumber>".substr($invoice_number, -20).
            "</invoiceNumber>".
            "</order>".
			"<customer>".
            "<id>".$vendor_id.
            "</id>".
            "<email>". $data['email'] . "</email>".
            "<phoneNumber>". $data['phone'] . "</phoneNumber>".
            "<faxNumber>". $data['fax'] . "</faxNumber>".
            "</customer>".
            "<billTo>".
            "<firstName>". $firstName . "</firstName>".
            "<lastName>" . $lastName . "</lastName>".
            "<company>" . $data['company'] . "</company>".
            "<address>" . $data['address'] . "</address>".
            "<city>" . $data['city'] . "</city>".
            "<state>" . $data['state'] . "</state>".
            "<zip>" . $data['zip'] . "</zip>".
            "<country>" . $data['country'] . "</country>".
            "</billTo>".
            "</subscription>".
            "</ARBCreateSubscriptionRequest>";
//print_r($content);exit;
            //send the xml via curl
            $response = $this->send_request_via_curl($this->_defaultConfig['host'],$this->_defaultConfig['path'],$content);
            //if curl is unavilable you can try using fsockopen
            /*
            $response = send_request_via_fsockopen($host,$path,$content);
            */

			//echo $response; exit;

            //if the connection and send worked $response holds the return from Authorize.net
            if ($response)
            {
	            
                /*
                a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
                please explore using SimpleXML in php 5 or xml parsing functions using the expat library
                in php 4
                parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
                */
                $result =$this->parse_return($response);
                //print_r( $result); 
                return $result;
            }
            else
            {
               return false;
            }
	}
        public function UpdateSubscriptionAmount($arr){
	        $currency_choice = $arr['currency_choice'];
            $content =
                    "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
                    "<ARBUpdateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
                    "<merchantAuthentication>";
					if ($currency_choice == "GBP") {
						$content .=
						"<name>" . $this->_gbpConfig['loginname'] . "</name>".
						"<transactionKey>" . $this->_gbpConfig['transactionkey'] . "</transactionKey>";
					} elseif ($currency_choice == "EUR") {
						$content .=
						"<name>" . $this->_eurConfig['loginname'] . "</name>".
						"<transactionKey>" . $this->_eurConfig['transactionkey'] . "</transactionKey>";
					} else {
						$content .=
						"<name>" . $this->_defaultConfig['loginname'] . "</name>".
						"<transactionKey>" . $this->_defaultConfig['transactionkey'] . "</transactionKey>";
					};
					$content .=
	                "</merchantAuthentication>".
                    "<subscriptionId>".$arr['subscriptionId']."</subscriptionId>".
                    "<subscription>".
                    "<amount>". $arr['amount'] ."</amount>".
                    "</subscription>".
                    "</ARBUpdateSubscriptionRequest>";
//echo $content;exit;
            //send the xml via curl
            $response = $this->send_request_via_curl($this->_defaultConfig['host'],$this->_defaultConfig['path'],$content);
            //if curl is unavilable you can try using fsockopen
            /*
            $response = send_request_via_fsockopen($host,$path,$content);
            */

            //if the connection and send worked $response holds the return from Authorize.net
            if ($response)
            {
                            /*
                    a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
                    please explore using SimpleXML in php 5 or xml parsing functions using the expat library
                    in php 4
                    parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
                    */
                //print_r($response);exit;
                   // list ($resultCode, $code, $text) =$this->parse_return($response);
                    $result =$this->parse_return($response);
                    if($result['resultCode'] == 'Ok'){
                        return true;
                    }else{
                        return false;
                    }
                    

            


            }
            else
            {
                    return false;
            }
            
        }
        public function UpdateSubscriptionCardDetails($arr){
            $currency_choice = $arr['currency_choice'];
            $content =
                    "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
                    "<ARBUpdateSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
                    "<merchantAuthentication>";
					if ($currency_choice == "GBP") {
						$content .=
						"<name>" . $this->_gbpConfig['loginname'] . "</name>".
						"<transactionKey>" . $this->_gbpConfig['transactionkey'] . "</transactionKey>";
					} elseif ($currency_choice == "EUR") {
						$content .=
						"<name>" . $this->_eurConfig['loginname'] . "</name>".
						"<transactionKey>" . $this->_eurConfig['transactionkey'] . "</transactionKey>";
					} else {
						$content .=
						"<name>" . $this->_defaultConfig['loginname'] . "</name>".
						"<transactionKey>" . $this->_defaultConfig['transactionkey'] . "</transactionKey>";
					};
					$content .=
                    "</merchantAuthentication>".
                    "<subscriptionId>" . $arr['subscriptionId'] . "</subscriptionId>".
                    "<subscription>".
                    "<payment>".
                    "<creditCard>".
                    "<cardNumber>" . $arr['cardNumber'] ."</cardNumber>".
                    "<expirationDate>" . $arr['expirationDate'] . "</expirationDate>".
                    "<cardCode>" . $arr['cardCode'] ."</cardCode>".
                    "</creditCard>".
                    "</payment>".
                    "<billTo>".
                    "<firstName>".$arr['firstName']."</firstName>".
                    "<lastName>".$arr['lastName']."</lastName>".
                    "<company>".$arr['company']."</company>".
                    "<address>".$arr['address']."</address>".
                    "<city>".$arr['city']."</city>".
                    "<state>".$arr['state']."</state>".
                    "<zip>".$arr['zip']."</zip>".
                    "<country>".$arr['country']."</country>".
                    "</billTo>".
                    "</subscription>".
                    "</ARBUpdateSubscriptionRequest>";

            //send the xml via curl
            $response = $this->send_request_via_curl($this->_defaultConfig['host'],$this->_defaultConfig['path'],$content);
            //if curl is unavilable you can try using fsockopen
            /*
            $response = send_request_via_fsockopen($host,$path,$content);
            */
//print_r( $response);exit;
            //if the connection and send worked $response holds the return from Authorize.net
            if ($response)
            {
                /*
                a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
                please explore using SimpleXML in php 5 or xml parsing functions using the expat library
                in php 4
                parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
                */
                $result =$this->parse_return($response); 
                return $result;


            }
            else
            {
                    return false;
            }
            
        }
        public function cancelSubscription($subscriptionId){
            //build xml to post
            $content =
                    "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
                    "<ARBCancelSubscriptionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
                    "<merchantAuthentication>".
                    "<name>" . $this->_defaultConfig['loginname'] . "</name>".
                    "<transactionKey>" . $this->_defaultConfig['transactionkey'] . "</transactionKey>".
                    "</merchantAuthentication>" .
                    "<subscriptionId>" . $subscriptionId . "</subscriptionId>".
                    "</ARBCancelSubscriptionRequest>";

            //send the xml via curl
            $response = $this->send_request_via_curl($this->_defaultConfig['host'],$this->_defaultConfig['path'],$content);
            return true;
        }
        /*
         * Function to check subscription status
         */
    public function getSubscriptionStatus($subscriptionId){
        $content =
                "<?xml version=\"1.0\" encoding=\"utf-8\"?>".
                "<ARBGetSubscriptionStatusRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">".
                "<merchantAuthentication>".
                "<name>" . $this->_defaultConfig['loginname'] . "</name>".
                "<transactionKey>" . $this->_defaultConfig['transactionkey'] . "</transactionKey>".
                "</merchantAuthentication>" .
                "<subscriptionId>" . $subscriptionId . "</subscriptionId>".
                "</ARBGetSubscriptionStatusRequest>";

        //send the xml via curl
        $response = $this->send_request_via_curl($this->_defaultConfig['host'],$this->_defaultConfig['path'],$content);
        
        //if curl is unavilable you can try using fsockopen
        /*
        $response = send_request_via_fsockopen($host,$path,$content);
        */


        //if the connection and send worked $response holds the return from Authorize.net
        if ($response)
        {
                        /*
                a number of xml functions exist to parse xml results, but they may or may not be avilable on your system
                please explore using SimpleXML in php 5 or xml parsing functions using the expat library
                in php 4
                parse_return is a function that shows how you can parse though the xml return if these other options are not avilable to you
                */
                $result =$this->parse_return($response);

                return $result;
        }
        return false;

    }
    /*
     * Function to get list of subscription based on different search types...
     *  Values include:
     * cardExpiringThisMonth
     * subscriptionActive
     * subscriptionInactive
     * subscriptionExpiringThisMonth
     */
    public function getSubscriptionList($searchtype='cardExpiringThisMonth'){
        $content=   '<?xml version="1.0" encoding="utf-8"?>
                    <ARBGetSubscriptionListRequest xmlns:xsi="http://www.w3.org/2001/
                    XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                    xmlns="AnetApi/xml/v1/schema/AnetApiSchema.xsd">
                    <merchantAuthentication>
                    <name>api_login</name>
                    <transactionKey>transaction_key</transactionKey>
                    </merchantAuthentication> 
                    <searchType>'.$searchtype.'</searchType>
                    <sorting>
                    <orderBy>Id</orderBy>
                    <orderDescending>false</orderDescending>
                    </sorting>
                    <paging>
                    <limit>1000</limit>
                    <offset>10000</offset>
                    </paging>
                    </ARBGetSubscriptionListRequest>';
    }
        
}
