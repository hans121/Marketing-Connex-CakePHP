<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Resources Model
 */
class VendorMenusTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('vendor_menus');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->belongsTo('VendorMenus', [
			'foreignKey' => 'parent_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
		$this->hasMany('VendorPages', [
			'foreignKey' => 'menu_id',
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
			->add('parent_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('parent_id', 'create')
			->notEmpty('parent_id')
			->requirePresence('name', 'create')
			->notEmpty('name')
			->allowEmpty('description')
			->add('user_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('user_id')
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('vendor_id')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->allowEmpty('status');

		return $validator;
	}

}
