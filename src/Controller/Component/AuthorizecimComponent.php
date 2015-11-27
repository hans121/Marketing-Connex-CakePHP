<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Authorizecim component
 */
class AuthorizecimComponent extends Component {

/**
 * Default configuration.
 *
 * @var array
 */
        public $loginname;
        public $transactionkey;
        protected $_defaultConfig = [
		'loginname' => '7jxPy288Dpe7',
		'transactionkey' => '7ar837Q3sDL4MjRY',
		'host' => 'api.authorize.net',
		'path' => '/xml/v1/request.api'
	];
	
	
	function send_xml_request($content)
        {
            return $this->send_request_via_fsockopen($this->_defaultConfig['host'],$this->_defaultConfig['path'],$content);
        }

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
                        $body = false;
                }
                else
                {
                        error_reporting(E_ERROR);
                        fputs($fp, "POST $path  HTTP/1.1\r\n");
                        fputs($fp, $header.$content);
                        if(!isset($out)){
                            $out=   '';
                        }
                        fwrite($fp, $out);
                        $response = "";
                        while (!feof($fp))
                        {
                                $response = $response . fgets($fp, 128);
                        }
                        fclose($fp);
                        error_reporting(E_ALL ^ E_NOTICE);

                        $len = strlen($response);
                        $bodypos = strpos($response, "\r\n\r\n");
                        if ($bodypos <= 0)
                        {
                                $bodypos = strpos($response, "\n\n");
                        }
                        while ($bodypos < $len && $response[$bodypos] != '<')
                        {
                                $bodypos++;
                        }
                        $body = substr($response, $bodypos);
                }
                return $body;
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
	
	
	//function to parse the api response
        //The code uses SimpleXML. http://us.php.net/manual/en/book.simplexml.php 
        //There are also other ways to parse xml in PHP depending on the version and what is installed.
        function parse_api_response($content)
        {
                $parsedresponse = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOWARNING);
                if ("Ok" != $parsedresponse->messages->resultCode) {
                        echo "The operation failed with the following errors:<br>";
                        foreach ($parsedresponse->messages->message as $msg) {
                                echo "[" . htmlspecialchars($msg->code) . "] " . htmlspecialchars($msg->text) . "<br>";
                        }
                        echo "<br>";
                }
                return $parsedresponse;
        }

        function MerchantAuthenticationBlock() {
                
                return
                "<merchantAuthentication>".
                "<name>" . $this->_defaultConfig['loginname'] . "</name>".
                "<transactionKey>" . $this->_defaultConfig['transactionkey'] . "</transactionKey>".
                "</merchantAuthentication>";
        }
	public function createProfile($data){
            //build xml to post
            $content =
                    "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                    "<createCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
                    $this->MerchantAuthenticationBlock().
                    "<profile>".
                    "<merchantCustomerId>". $data['vendor_id'] ."</merchantCustomerId>". // Your own identifier for the customer.
                    "<description></description>".
                    "<email>" . $data['email'] . "</email>".
                    "<paymentProfiles>".
                    "<billTo>".
                    "<firstName>". $data['firstName'] . "</firstName>".
                    "<lastName>" . $data['lastName'] . "</lastName>".
                    "<company>" . $data['company'] . "</company>".
                    "<address>" . $data['address'] . "</address>".
                    "<city>" . $data['city'] . "</city>".
                    "<state>" . $data['state'] . "</state>".
                    "<zip>" . $data['zip'] . "</zip>".
                    "<country>" . $data['country'] . "</country>".
                    "</billTo>".
                    "<payment>".
                    "<creditCard>".
                    "<cardNumber>" . $data['cardNumber'] . "</cardNumber>".
                    "<expirationDate>" . $data['expirationDate'] . "</expirationDate>".
                    "<cardCode>" . $data['cardCode'] ."</cardCode>".
                    "</creditCard>".
                    "</payment>".
                    "</paymentProfiles>".
                    "</profile>".
                    "</createCustomerProfileRequest>";
//echo $content;exit;
           
            $response = $this->send_xml_request($content);
           
			//echo "TEST..."; print_r( $response); exit;
           
            if($response){
                $ret_arr    =   $this->parse_return($response);
                return $ret_arr;
            }
            
           return false;
            
            
            
        }
        public function createPaymentProfile($data){
            //build xml to post
            /*
             * <?xml version="1.0" encoding="utf-8"?>
<createCustomerPaymentProfileRequest xmlns="AnetApi/xml/v1/schema/
AnetApiSchema.xsd">
<merchantAuthentication>
<name>YourUserLogin</name>
<transactionKey>YourTranKey</transactionKey>
</merchantAuthentication>
<customerProfileId>10000</customerProfileId>
<paymentProfile>
<billTo>
<firstName>John</firstName>
<lastName>Doe</lastName>
<company></company>
<address>123 Main St.</address>
<city>Bellevue</city>
<state>WA</state>
<zip>98004</zip>
<country>USA</country>
<phoneNumber>000-000-0000</phoneNumber>
<faxNumber></faxNumber>
</billTo>
<payment>
<creditCard>
<cardNumber>4111111111111111</cardNumber>
<expirationDate>2023-12</expirationDate>
</creditCard>
</payment>
</paymentProfile>
<validationMode>liveMode</validationMode>
</createCustomerPaymentProfileRequest>
             */
            $content =
                    "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                    "<createCustomerPaymentProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
                    $this->MerchantAuthenticationBlock().
                    "<customerProfileId>" . $data["customerProfileId"] . "</customerProfileId>".
                    "<paymentProfile>".
                    "<billTo>".
                     "<firstName>".$data['first_name']."</firstName>".
                     "<lastName>".$data['last_name']."</lastName>".
                     "<phoneNumber>".$data['phone']."</phoneNumber>".
                    "</billTo>".
                    "<payment>".
                     "<creditCard>".
                      "<cardNumber>".$data['cardNumber']."</cardNumber>".
                      "<expirationDate>".$data['expirationDate']."</expirationDate>". // required format for API is YYYY-MM
                     "</creditCard>".
                    "</payment>".
                    "</paymentProfile>".
                    "<validationMode>liveMode</validationMode>". // or testMode
                    "</createCustomerPaymentProfileRequest>";

            
            $response = $this->send_xml_request($content);
            $parsedresponse = $this->parse_api_response($response);
            /*
             * if ("Ok" == $parsedresponse->messages->resultCode) {
                    echo "customerPaymentProfileId <b>"
                            . htmlspecialchars($parsedresponse->customerPaymentProfileId)
                            . "</b> was successfully created for customerProfileId <b>"
                            . htmlspecialchars($_POST["customerProfileId"])
                            . "</b>.<br><br>";
            }

            echo "<br><a href=index.php?customerProfileId=" 
                    . urlencode($_POST["customerProfileId"])
                    . "&customerPaymentProfileId="
                    . urlencode($parsedresponse->customerPaymentProfileId)
                    . "&customerShippingAddressId="
                    . urlencode($customerShippingAddressId)
                    . ">Continue</a><br>";
             */
            
        }
    public function deleteProfile($data){
        $content =
                "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                "<deleteCustomerProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
                $this->MerchantAuthenticationBlock().
                "<customerProfileId>" . $data["customerProfileId"] . "</customerProfileId>".
                "</deleteCustomerProfileRequest>";

        
        $response = $this->send_xml_request($content);
        
        $parsedresponse = $this->parse_api_response($response);
        print_r($parsedresponse);exit;
        /*
         * if ("Ok" == $parsedresponse->messages->resultCode) {
                echo "customerProfileId <b>"
                        . htmlspecialchars($data["customerProfileId"])
                        . "</b> was successfully deleted.<br><br>";
        }

        echo "<br><a href=index.php?customerProfileId="
                . urlencode($data["customerProfileId"])
                . ">Continue</a><br>";
         */
        
    }
    public function createTransaction($data){
        //build xml to post
        /*
         * <?xml version="1.0" encoding="utf-8"?>
<createCustomerProfileTransactionRequest xmlns="AnetApi/xml/v1/schema/
AnetApiSchema.xsd">
<merchantAuthentication>
<name>YourUserLogin</name>
<transactionKey>YourTranKey</transactionKey>
</merchantAuthentication>
<transaction>
<profileTransAuthCapture>
<amount>10.95</amount>
<tax>
<amount>1.00</amount>
<name>WA state sales tax</name>
<description>Washington state sales tax</description>
</tax>
<shipping>
<amount>2.00</amount>
<name>ground based shipping</name>
<description>Ground based 5 to 10 day shipping</description>
</shipping>
<lineItems>
<itemId>ITEM00001</itemId>
<name>name of item sold</name>
<description>Description of item sold</description>
<quantity>1</quantity>
 <unitPrice>6.95</unitPrice>
<taxable>true</taxable>
</lineItems>
<lineItems>
<itemId>ITEM00002</itemId>
<name>name of other item sold</name>
<description>Description of other item sold</description>
<quantity>1</quantity>
<unitPrice>1.00</unitPrice>
<taxable>true</taxable>
</lineItems>
<customerProfileId>10000</customerProfileId>
<customerPaymentProfileId>20000</customerPaymentProfileId>
<customerShippingAddressId>30000</customerShippingAddressId>
<order>
<invoiceNumber>INV000001</invoiceNumber>
<description>description of transaction</description>
<purchaseOrderNumber>PONUM000001</purchaseOrderNumber>
</order>
<taxExempt>false</taxExempt>
<recurringBilling>false</recurringBilling>
<cardCode>000</cardCode>
<splitTenderId>123456</splitTenderId>
</profileTransAuthCapture>
</transaction>
<extraOptions><![CDATA[x_customer_ip=100.0.0.1]]></extraOptions>
</createCustomerProfileTransactionRequest>
         */
        $content =
                "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                "<createCustomerProfileTransactionRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
                $this->MerchantAuthenticationBlock().
                "<transaction>".
                "<profileTransAuthCapture>".
                "<amount>" . $data["amount"] . "</amount>". // should include tax, shipping, and everything.
                "<customerProfileId>" . $data["customerProfileId"] . "</customerProfileId>".
                "<customerPaymentProfileId>" . $data["customerPaymentProfileId"] . "</customerPaymentProfileId>".
                "<order>".
                "<invoiceNumber>".$data["invoice_number"]."</invoiceNumber>".
                "<description>".$data['invoice_description']."</description>".
                "</order>".
                "</profileTransAuthCapture>".
                "</transaction>".
                "</createCustomerProfileTransactionRequest>";

       
        $response = $this->send_xml_request($content);
        if($response){
            $ret_arr    =   $this->parse_return($response);
            return $ret_arr;
        }
        return false;
        
    }
    public function createShippingAddress(){
        //build xml to post
        /*
         * <?xml version="1.0" encoding="utf-8"?>
<createCustomerShippingAddressRequest xmlns="AnetApi/xml/v1/schema/
AnetApiSchema.xsd">
<merchantAuthentication>
<name>YourUserLogin</name>
<transactionKey>YourTranKey</transactionKey>
</merchantAuthentication>
<customerProfileId>10000</customerProfileId>
<address>
<firstName>John</firstName>
<lastName>Doe</lastName>
<company></company>
<address>123 Main St.</address>
<city>Bellevue</city>
<state>WA</state>
<zip>98004</zip>
<country>USA</country>
<phoneNumber>000-000-0000</phoneNumber>
<faxNumber></faxNumber>
</address>
</createCustomerShippingAddressRequest>
         */
        $content =
                "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                "<createCustomerShippingAddressRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
                $this->MerchantAuthenticationBlock().
                "<customerProfileId>" . $_POST["customerProfileId"] . "</customerProfileId>".
                "<address>".
                "<firstName>John</firstName>".
                "<lastName>Smith</lastName>".
                "<phoneNumber>000-000-0000</phoneNumber>".
                "</address>".
                "</createCustomerShippingAddressRequest>";

       
        $response = $this->send_xml_request($content);
       
        $parsedresponse = $this->parse_api_response($response);
        print_r( $parsedresponse);
        /*
         * if ("Ok" == $parsedresponse->messages->resultCode) {
                echo "customerAddressId <b>"
                        . htmlspecialchars($parsedresponse->customerAddressId)
                        . "</b> was successfully created for customerProfileId <b>"
                        . htmlspecialchars($_POST["customerProfileId"])
                        . "</b>.<br><br>";
        }

        echo "<br><a href=index.php?customerProfileId=" 
                . urlencode($_POST["customerProfileId"])
                . "&customerPaymentProfileId="
                . urlencode($customerPaymentProfileId)
                . "&customerShippingAddressId="
                . urlencode($parsedresponse->customerAddressId)
                . ">Continue</a><br>";
         */
        
    }
    function parse_return($content)
    {
         // echo $content;exit;
        $resultCode = $this->substring_between($content,'<resultCode>','</resultCode>');
        $code = $this->substring_between($content,'<code>','</code>');
        $text = $this->substring_between($content,'<text>','</text>');
        $directResponse=    $this->substring_between($content,'<directResponse>','</directResponse>');
        $customerProfileId = $this->substring_between($content,'<customerProfileId>','</customerProfileId>');
        $customerPaymentProfileId = $this->substring_between($content,'<customerPaymentProfileIdList><numericString>','</numericString></customerPaymentProfileIdList>');
        return array ('customerProfileId' =>$customerProfileId, 'resultCode' =>$resultCode, 'code' =>$code, 'text' =>$text, 'customerPaymentProfileId' =>$customerPaymentProfileId,'directResponse'=>$directResponse);
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
    /*
     * Function to update credit card details of existing payment profile
     */
    public function updatePaymentProfile($data){

        $content =
                "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
                "<updateCustomerPaymentProfileRequest xmlns=\"AnetApi/xml/v1/schema/AnetApiSchema.xsd\">" .
                $this->MerchantAuthenticationBlock().
                "<customerProfileId>" . $data["customerProfileId"] . "</customerProfileId>".
                "<paymentProfile>".
                "<billTo>".
                "<firstName>".$data['firstName']."</firstName>".
                "<lastName>".$data['lastName']."</lastName>".
                "<company>".$data['company']."</company>".
                "<address>".$data['address']."</address>".
                "<city>".$data['city']."</city>".
                "<state>".$data['state']."</state>".
                "<zip>".$data['zip']."</zip>".
                "<country>".$data['country']."</country>".
                "</billTo>".
                "<payment>".
               "<creditCard>".
                "<cardNumber>".$data['cardNumber']."</cardNumber>".
                "<expirationDate>".$data['expirationDate']."</expirationDate>". // required format for API is YYYY-MM
                "<cardCode>".$data['cardCode']."</cardCode>".
                "</creditCard>".
                "</payment>".
                "<customerPaymentProfileId>".$data["customerPaymentProfileId"]."</customerPaymentProfileId>".
                "</paymentProfile>".
                "<validationMode>liveMode</validationMode>". // or testMode
                "</updateCustomerPaymentProfileRequest>";


        $response = $this->send_xml_request($content);
        if($response){
            $ret_arr    =   $this->parse_return($response);
            return $ret_arr;
        }
            
        return false;
    }
}
