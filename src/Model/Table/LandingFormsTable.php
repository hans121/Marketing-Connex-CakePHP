<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LandingForms Model
 */
class LandingFormsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('landing_forms');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('LandingPages', [
			'foreignKey' => 'landing_page_id',
		]);
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
			->add('landing_page_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('landing_page_id', 'create')
			->notEmpty('landing_page_id')
			->allowEmpty('first_name')
			->allowEmpty('last_name')
			->allowEmpty('email_address')
			->allowEmpty('phone')
			->allowEmpty('fax')
			->allowEmpty('company')
			->allowEmpty('job_title')
			->allowEmpty('message')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->allowEmpty('status');

		return $validator;
	}

}
