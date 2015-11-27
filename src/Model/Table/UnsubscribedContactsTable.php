<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UnsubscribedContacts Model
 */
class UnsubscribedContactsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('unsubscribed_contacts');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('Partners', [
			'foreignKey' => 'partner_id',
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
			->add('partner_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('partner_id', 'create')
			->notEmpty('partner_id')
			->add('email', 'valid', ['rule' => 'email'])
			->requirePresence('email', 'create')
			->notEmpty('email')
			->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on');

		return $validator;
	}

}
