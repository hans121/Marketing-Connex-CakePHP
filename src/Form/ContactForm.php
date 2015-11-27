<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Network\Email\Email;

class ContactForm extends Form
{
	  public $portal_settings =   array();

    protected function _buildSchema(Schema $schema)
    {
      return $schema->addField('firstname', 'string')
      								->addField('lastname', 'string')
								    ->addField('position', 'string')
								    ->addField('company', 'string')
								    ->addField('email', ['type' => 'email'])
								    ->addField('phone', ['type' => 'tel'])
								    ->addField('info', ['type' => 'select'])
								    ->addField('message', ['type' => 'text']);
    }

    protected function _buildValidator(Validator $validator)
    {
      return $validator->add('name', 'length', [
	      'rule' => ['minLength', 6],
	      'message' => 'A name is required'
      ])->add('email', 'format', [
        'rule' => 'email',
        'message' => 'A valid email address is required',
      ]);
    }

    protected function _execute(array $data)
    {
	//print_r($data); exit;




        if(null != $data['email'] ) { 

			//SEND TO SALES FORCE
			//-----------------------------------
			
			//then bundle the request and send it to Salesforce.com
			$req  = "&lead_source=". "Web";
			$req .= "&first_name=" . $data['firstname'];
			$req .= "&last_name=" . $data['lastname']; 
			$req .= "&company=" . $data['company'];
			$req .= "&00N20000009ZAQB=" . $data['position'];
			$req .= "&email=" . $data['email'];
			$req .= "&phone=" . $data['phone'];
			$req .= "&debug=" . urlencode("0");
			$req .= "&oid=" . urlencode("00D20000000ozqG"); 
			$req .= "&retURL=" . urlencode("http://qa.marketingconnex.com/pages/thank-you");
			$req .= "&debugEmail=" . urlencode("dom@huxleydigital.co.uk");
			
			$header  = "POST /servlet/servlet.WebToLead?encoding=UTF-8 HTTP/1.0\r\n";
			$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$header .= "Host: www.salesforce.com\r\n";
			$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
			$fp = fsockopen ('www.salesforce.com', 80, $errno, $errstr, 30);
			
			if (!$fp) {
				echo "No connection made";
			} else {
				fputs ($fp, $header . $req);
				while (!feof($fp)) {
					$res = fgets ($fp, 1024);
					//echo $res;
				}
			}
			
			fclose($fp);

			//-----------------------------------
	        
	        
	        $adminEmail = "contact@marketingconnex.com";
	        
			//EMAIL THE CUSTOMER
	        $subject  = __('Thank you for contacting MarketingConneX.com');
	        $email = new Email('default');
	        $email->sender($adminEmail,'marketingconneX.com');

				$email->from([$adminEmail => 'marketingconneX.com'])
				->to([$data['email'] => $data['name']])
				->subject($subject)
				->emailFormat('html')
				->template('contactform', 'system')
				->viewVars(array(
					'email_type' => 'customer',
					'name' => $data['firstname'],
					'company' => $data['company'],
					'position' => $data['position'],
					'email' => $data['email'],
					'site_url' => 'http://www.marketingconnex.com',
					'SITE_NAME' => 'MarketingConneX.com',
					'phone' => $data['phone'],
					'info' => $data['info'],
					'message' => $data['message']
				))
				->send();

			//EMAIL THE Admin
	        $subject  = __('A new enquiry has been received on MarketingConneX.com');
	        $email = new Email('default');
	        $email->sender($adminEmail,'marketingconneX.com');


				$email->from([$data['email'] => $data['name']])
				->to([$adminEmail => 'marketingconneX.com'])
				->subject($subject)
				->emailFormat('html')
				->template('contactform', 'system')
				->viewVars(array(
					'email_type' => 'admin',
					'name' => $data['firstname'],
					'company' => $data['company'],
					'position' => $data['position'],
					'email' => $data['email'],
					'site_url' => 'http://www.marketingconnex.com',
					'SITE_NAME' => 'MarketingConneX.com',
					'phone' => $data['phone'],
					'info' => $data['info'],
					'message' => $data['message']
				))
				->send();
				
			
          return true; 
        }
        
        return false;

    }
    
}
?>