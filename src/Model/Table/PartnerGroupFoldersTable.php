<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PartnerGroups Model
 */
class PartnerGroupFoldersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_group_folders');

		$this->belongsTo('PartnerGroups', [
			'foreignKey' => 'partner_group_id',
		]);
		$this->belongsTo('Folders', [
			'foreignKey' => 'folder_id',
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
			->add('partner_group_id', 'valid', ['rule' => 'numeric'])
			->add('folder_id', 'valid', ['rule' => 'numeric'])
			->notEmpty('partner_group_id')
			->notEmpty('folder_id');

		return $validator;
	}

}
