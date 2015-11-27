<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Resources Model
 */
class ResourcesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('resources');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->belongsTo('Folders', [
			'foreignKey' => 'folder_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
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
			->add('folder_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('folder_id', 'create')
			->notEmpty('folder_id')
			->requirePresence('name', 'create')
			->notEmpty('name')
			->allowEmpty('description')
			->add('user_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('user_id')
			->allowEmpty('user_role')
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('vendor_id')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->allowEmpty('status')
			->requirePresence('sourcepath', 'create')
			->allowEmpty('sourcepath')
			->allowEmpty('publicurl')
			->allowEmpty('type')
			->allowEmpty('size')
			->notEmpty('assigned');

		return $validator;
	}

}
