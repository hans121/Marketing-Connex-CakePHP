<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Network\Email\Email;

class LandingPageForm extends Form
{
	  public $portal_settings =   array();

    protected function _buildSchema(Schema $schema)
    {
      return $schema->addField('firstname', 'string')
				    ->addField('lastname', 'string')
				    ->addField('email', ['type' => 'email'])
				    ->addField('website', ['type' => 'string'])
				    ->addField('phone', ['type' => 'tel']);
    }

    protected function _buildValidator(Validator $validator)
    {
      return $validator->add('firstname', 'length', [
	      'rule' => ['minLength', 1],
	      'message' => 'Firstname is required'
      ])->add('lastname', 'length', [
	      'rule' => ['minLength', 1],
	      'message' => 'Lastname is required'
      ])->add('website', 'length', [
	      'rule' => ['minLength', 1],
	      'message' => 'Website URL is required'
      ])->add('email', 'format', [
        'rule' => 'email',
        'message' => 'A valid email address is required',
      ]);
    }

    protected function _execute(array $data)
    {
//print_r($data); exit;
        if(null != $data['email'] ) { 
	        
	        $adminEmail = "contact@marketingconnex.com";

			//EMAIL THE Admin
	        $subject  = __('A new form submission been received from the MarketingConneX.com Challenges landing page');
	        $email = new Email('default');
	        
	        $email->sender($data['email'],$data['firstname']);

				$email->from([$data['email'] => $data['firstname']])
				->to([$adminEmail => 'marketingconneX.com'])
				->subject($subject)
				->emailFormat('html')
				->template('landingpageform')
				->viewVars(array(
					'firstname' => $data['firstname'],
					'lastname' => $data['lastname'],
					'email' => $data['email'],
					'website' => $data['website'],
					'phone' => $data['phone'],
					'info' => $data['info'],
					'landingpage' => $data['landingpage']
				))
				->send();
				
			
          return true; 
        }
        
        return false;

    }
    
}
?>