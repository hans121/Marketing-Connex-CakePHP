<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Folders Model
 */
class FoldersTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('folders');
		$this->displayField('folderpath');
		$this->primaryKey('id');

		$this->belongsTo('Users', [
			'foreignKey' => 'user_id',
		]);
		$this->belongsTo('Vendors', [
			'foreignKey' => 'vendor_id',
		]);
		$this->belongsTo('ParentFolders', [
			'className' => 'Folders',
			'foreignKey' => 'parent_id',
		]);
		$this->hasMany('ChildFolders', [
			'className' => 'Folders',
			'foreignKey' => 'parent_id',
		]);
		$this->hasMany('Resources', [
			'foreignKey' => 'folder_id',
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
			->requirePresence('parentpath', 'create')
			->allowEmpty('parentpath')
			->add('user_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('user_id')
			->allowEmpty('user_role')
			->add('vendor_id', 'valid', ['rule' => 'numeric'])
			->allowEmpty('vendor_id')
			->requirePresence('name', 'create')
			->notEmpty('name')
			->allowEmpty('description')
			->requirePresence('folderpath', 'create')
			->notEmpty('folderpath')
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on')
			->allowEmpty('status')
			->add('parent_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('parent_id', 'create')
			->notEmpty('parent_id')
			->notEmpty('assigned');

		return $validator;
	}

}
