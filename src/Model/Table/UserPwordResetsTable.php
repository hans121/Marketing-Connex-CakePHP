<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserPwordResets Model
 */
class UserPwordResetsTable extends Table {

/**
 * Initialize method
 *
 * @param array $config The configuration for the Table.
 * @return void
 */
	public function initialize(array $config) {
		$this->table('user_pword_resets');
		$this->displayField('id');
		$this->primaryKey('id');
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
	

}
