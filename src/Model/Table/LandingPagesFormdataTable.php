<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Folders Model
 */
class LandingPagesFormdataTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('landing_pages_formdata');
		$this->displayField('url');
		$this->primaryKey('id');

                $this->addBehavior('Timestamp', [
                    'events' => [
                        'Model.beforeSave' => [
                            'created_on' => 'new'
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
			->allowEmpty('url')
			->notEmpty('serialized_data');

		return $validator;
	}

}
