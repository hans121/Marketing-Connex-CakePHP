<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartnerGroups Model
 */
class PartnerGroupMembersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_group_members');
		$this->displayField('group_id');
		$this->primaryKey('id');

		$this->belongsTo('PartnerGroups', [
			'foreignKey' => 'group_id',
		]);
		$this->belongsTo('Partners', [
			'foreignKey' => 'partner_id',
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
			->requirePresence('group_id', 'create')
			->notEmpty('id')
			->add('group_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('group_id', 'create')
			->notEmpty('group_id')
			->add('partner_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_id', 'create')
			->notEmpty('partner_id');

		return $validator;
	}

}
