<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContactFormSubmissions Model
 */
class ContactFormSubmissionsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('contact_form_submissions');
		$this->displayField('first_name');
		$this->primaryKey('id');
			
        $this->addBehavior('Timestamp', [
            'events' => [
                'Model.beforeSave' => [
                    'created_on' => 'new',
                    'modified_on' => 'always',
                ]
                
            ]
        ]);
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('id', 'create')
			->allowEmpty('firstname')
			->allowEmpty('lastname')
			->allowEmpty('position')
			->allowEmpty('company')
			->allowEmpty('email')
			->allowEmpty('phone')
			->allowEmpty('info')
			->allowEmpty('message')
			->allowEmpty('ip_address')
			->allowEmpty('browser_agent');

		return $validator;
	}

}
