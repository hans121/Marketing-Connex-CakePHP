<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BusinesplanCampaigns Model
 */
class BusinesplanCampaignsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('businesplan_campaigns');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('Businesplans', [
			'foreignKey' => 'businesplan_id',
		]);
		$this->belongsTo('Campaigns', [
			'foreignKey' => 'campaign_id',
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
			->add('businesplan_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('businesplan_id', 'create')
			->notEmpty('businesplan_id')
			->add('campaign_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('campaign_id', 'create')
			->notEmpty('campaign_id')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->allowEmpty('status');

		return $validator;
	}

}
