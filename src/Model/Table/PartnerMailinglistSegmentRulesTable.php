<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartnerMailinglistSegmentRules Model
 */
class PartnerMailinglistSegmentRulesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_mailinglist_segment_rules');
		$this->primaryKey('id');

		$this->belongsTo('PartnerMailinglistSegments', [
			'foreignKey' => 'partner_mailinglist_segment_id',
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
			->add('partner_mailinglist_segment_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_mailinglist_segment_id', 'create')
			->notEmpty('partner_mailinglist_segment_id')
			->allowEmpty('logic')
			->requirePresence('variable', 'create')
			->notEmpty('variable')
			->requirePresence('operand', 'create')
			->notEmpty('operand')
			->allowEmpty('value')
			->requirePresence('priority', 'create')
			->notEmpty('priority');

		return $validator;
	}

}
