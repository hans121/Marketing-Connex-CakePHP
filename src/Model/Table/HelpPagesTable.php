<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * HelpPages Model
 */
class HelpPagesTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('help_pages');
		$this->displayField('title');
		$this->primaryKey('id');

		$this->belongsTo('HelpMenus', [
			'foreignKey' => 'menu_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'modified_by',
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
			->add('menu_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('menu_id', 'create')
			->notEmpty('menu_id')
			->requirePresence('title', 'create')
			->notEmpty('title')
			->allowEmpty('content')
			->add('user_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('user_id')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->allowEmpty('status')
			->allowEmpty('group_assignment')
			->allowEmpty('modified_by');

		return $validator;
	}

}
