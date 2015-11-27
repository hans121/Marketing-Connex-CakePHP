<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartnerMailinglistSegments Model
 */
class PartnerMailinglistSegmentsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_mailinglist_segments');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->belongsTo('PartnerMailinglistGroups', [
			'foreignKey' => 'partner_mailinglist_group_id',
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
			->add('partner_mailinglist_group_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_mailinglist_group_id', 'create')
			->notEmpty('partner_mailinglist_group_id')
			->requirePresence('name', 'create')
			->notEmpty('name')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on');

		return $validator;
	}

}
