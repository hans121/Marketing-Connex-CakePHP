<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmailTemplates Model
 */
class EmailTemplatesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('email_templates');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
		$this->belongsTo('Campaigns', [
			'foreignKey' => 'campaign_id',
		]);
		$this->belongsTo('MasterTemplates', [
			'foreignKey' => 'master_template_id',
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
			->add('campaign_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('campaign_id', 'create')
			->notEmpty('campaign_id')
			->allowEmpty('use_templates')
			->allowEmpty('custom_template')
			->allowEmpty('template_override')
			->add('master_template_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('master_template_id')
			->allowEmpty('subject_text')
			->requirePresence('subject_option1', 'create')
			->notEmpty('subject_option1')
			//->allowEmpty('subject_option1')
			->allowEmpty('subject_option2')
			->allowEmpty('subject_option3')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->allowEmpty('status')
			->allowEmpty('spam');

		return $validator;
	}

}
