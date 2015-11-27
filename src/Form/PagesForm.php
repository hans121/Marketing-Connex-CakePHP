<?php
	
	// Refer to: http://book.cakephp.org/3.0/en/core-libraries/form.html
	
	namespace App\Form;
	
	use Cake\Form\Form;
	use Cake\Form\Schema;
	use Cake\Validation\Validator;
	
	class PagesForm extends Form
	{
	
	    protected function _buildSchema(Schema $schema)
	    {
	      return $schema->addField('name', 'string')
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
		    echo 'success'; exit;
	        // Send an email.
	        return true;
	    }
	    
	}
?>