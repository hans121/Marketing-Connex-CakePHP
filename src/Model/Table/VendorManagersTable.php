<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VendorManagers Model
 */
class VendorManagersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('vendor_managers');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
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
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('vendor_id', 'create')
			->notEmpty('vendor_id')
			->add('user_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('user_id', 'create')
			->notEmpty('user_id')
			->requirePresence('primary_manager', 'create')
			->notEmpty('primary_manager')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->requirePresence('status', 'create')
			->notEmpty('status')
			->allowEmpty('litmos_id');

		return $validator;
	}

}
