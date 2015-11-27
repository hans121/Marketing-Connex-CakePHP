<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Invoices Model
 */
class InvoicesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('invoices');
		$this->displayField('title');
		$this->primaryKey('id');

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
			->requirePresence('title', 'create')
			->notEmpty('title')
			->allowEmpty('description')
      ->allowEmpty('discount')
			->allowEmpty('invoice_number')
			->allowEmpty('comments')
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('vendor_id', 'create')
			->notEmpty('vendor_id')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('invoice_date', 'valid', ['rule' => 'datetime'])
			->allowEmpty('invoice_date')
			->add('amount', 'valid', ['rule' => 'numeric'])
			->requirePresence('amount', 'create')
			->notEmpty('amount')
			->allowEmpty('currency')
			->allowEmpty('status')
			->allowEmpty('fee')
			->allowEmpty('old_package')
			->allowEmpty('old_package_price')
			->add('old_package_price', 'valid', ['rule' => 'numeric'])
			->allowEmpty('new_package')
			->add('balance_credit', 'valid', ['rule' => 'numeric'])
			->allowEmpty('balance_credit')
			->add('adjusted_package_price', 'valid', ['rule' => 'numeric'])
			->allowEmpty('adjusted_package_price')
			->add('package_price', 'valid', ['rule' => 'numeric'])
			->allowEmpty('primary_manager')
			->allowEmpty('company_name')
			->allowEmpty('company_address')
			->allowEmpty('company_city')
			->allowEmpty('company_state')
			->allowEmpty('company_postcode')
			->allowEmpty('company_country')
			->allowEmpty('customer_service')
			->allowEmpty('invoice_type')
			->allowEmpty('subtotal')
			->allowEmpty('vat_perc')
			->allowEmpty('vat_number')
			->allowEmpty('sub_start_date')
			->allowEmpty('upgrade_date')
			->allowEmpty('sub_end_date')
			->allowEmpty('package_price');
			
		return $validator;
	}

}
