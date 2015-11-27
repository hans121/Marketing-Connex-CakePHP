<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Coupons Model
 */
class CouponsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('coupons');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->hasMany('Vendors', [
			'foreignKey' => 'coupon_id',
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
			->requirePresence('title', 'create')
			->notEmpty('title')
			->requirePresence('type', 'create')
			->notEmpty('type')
			->add('discount', 'valid', ['rule' => 'decimal'])
			->requirePresence('discount', 'create')
			->notEmpty('discount')
			->add('expiry_date', 'valid', ['rule' => 'datetime'])
			->requirePresence('expiry_date', 'create')
			->notEmpty('expiry_date')
			->notEmpty('coupon_code')
			->add('coupon_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
			->requirePresence('status', 'create')
			->notEmpty('status');

		return $validator;
	}

}
