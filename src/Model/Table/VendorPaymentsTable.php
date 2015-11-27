<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VendorPayments Model
 */
class VendorPaymentsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('vendor_payments');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
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
			->allowEmpty('reference')
			->add('subscriptionid', 'valid', ['rule' => 'numeric'])
			->allowEmpty('subscriptionid')
                        ->add('customerPaymentProfileId', 'valid', ['rule' => 'numeric'])
			->allowEmpty('customerPaymentProfileId')
                        ->add('customerProfileId', 'valid', ['rule' => 'numeric'])
			->allowEmpty('customerProfileId');
		return $validator;
	}

}
