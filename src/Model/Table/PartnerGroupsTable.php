<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartnerGroups Model
 */
class PartnerGroupsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_groups');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
		$this->hasMany('Partners', [
			'foreignKey' => 'partner_group_id',
		]);
		$this->hasMany('PartnerGroupMembers',[
			'foreignKey' => 'group_id',
			'dependent' => true,
			'cascadeCallbacks' => true,
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
			->requirePresence('name', 'create')
			->notEmpty('name');

		return $validator;
	}

}
