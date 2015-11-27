<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampaignPartnerMailinglistVerifications Model
 */
class PartnerMailinglistVerificationsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('partner_mailinglist_verifications');
		$this->displayField('email');
		$this->primaryKey('id');
		
		$this->belongsTo('Partners', [
				'foreignKey' => 'partner_id',
				]);
		$this->belongsTo('Vendors', [
				'foreignKey' => 'vendor_id',
				]);		
		$this->belongsTo('PartnerMailinglistGroups', [
				'foreignKey' => 'partner_mailinglist_group_id',
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
			->add('partner_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_id', 'create')
			->notEmpty('partner_id')
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('vendor_id', 'create')
			->notEmpty('vendor_id')
			->add('partner_mailinglist_group_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_mailinglist_group_id', 'create')
			->notEmpty('partner_mailinglist_group_id')			
			->requirePresence('first_name', 'create')
			->notEmpty('first_name')
			->requirePresence('last_name', 'create')
			->notEmpty('last_name')
			->add('email', 'valid', ['rule' => 'email'])
			->requirePresence('email', 'create')
			->notEmpty('email')
			->allowEmpty('company')
			->allowEmpty('industry')
			->allowEmpty('city')
			->allowEmpty('country')
			->allowEmpty('status')
			->allowEmpty('info')
			->allowEmpty('code')
			->allowEmpty('details');

		return $validator;
	}

}
