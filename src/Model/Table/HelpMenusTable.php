<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Resources Model
 */
class HelpMenusTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('help_menus');
		$this->displayField('name');
		$this->primaryKey('id');

		$this->belongsTo('HelpMenus', [
			'foreignKey' => 'parent_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->belongsTo('Users', [
			'foreignKey' => 'modified_by',
		]);
		$this->hasMany('HelpPages', [
			'foreignKey' => 'menu_id',
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
			->add('parent_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('parent_id', 'create')
			->notEmpty('parent_id')
			->requirePresence('name', 'create')
			->notEmpty('name')
			->allowEmpty('description')
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
