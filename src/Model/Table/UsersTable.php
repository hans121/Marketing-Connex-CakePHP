<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class UsersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('users');
		$this->displayField('username');
		$this->primaryKey('id');

		$this->hasOne('PartnerManagers', [
			'foreignKey' => 'user_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		$this->hasOne('VendorManagers', [
			'foreignKey' => 'user_id',
                        'dependent' => true,
                        'cascadeCallbacks' => true,
		]);
		
		$this->hasMany('Admins',[
				'foreignKey' => 'user_id'
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
			->requirePresence('username', 'create')
			->notEmpty('username')
			->add('username', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
			->add('email', 'valid', ['rule' => 'email'])
			->notEmpty('email')
			->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
			->requirePresence('password', 'create')
			->notEmpty('password')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->requirePresence('status', 'create')
			->notEmpty('status')
			->requirePresence('role', 'create')
			->notEmpty('role')
			->requirePresence('first_name', 'create')
			->notEmpty('first_name')
			->requirePresence('last_name', 'create')
			->notEmpty('last_name')
			->allowEmpty('job_title')
			->allowEmpty('title')
			->allowEmpty('phone');

		return $validator;
	}

}
