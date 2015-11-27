<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VendorSortablePosition Model
 */
class VendorSortablePositionTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('vendor_sortable_position');
		$this->displayField('position');
		
			
        
	}

/**
 * Default validation rules.
 *
 * @param \Cake\Validation\Validator $validator
 * @return \Cake\Validation\Validator
 */
	public function validationDefault(Validator $validator) {
		$validator
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('vendor_id', 'create')
			->allowEmpty('position');

		return $validator;
	}

}
