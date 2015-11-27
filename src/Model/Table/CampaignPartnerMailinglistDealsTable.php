<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CampaignPartnerMailinglistDeals Model
 */
class CampaignPartnerMailinglistDealsTable extends Table {
	
	/**
	 * Initialize method
	 *
	 * @param array $config
	 *        	The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		$this->table ( 'campaign_partner_mailinglist_deals' );
		
		$this->primaryKey ( 'id' );
		
		$this->belongsTo('PartnerManagers', [
				'foreignKey' => 'partner_manager_id',
				]);
		
		$this->belongsTo('CampaignPartnerMailinglists', [
				'foreignKey' => 'campaign_partner_mailinglist_id',
				]);
		
		$this->addBehavior ( 'Timestamp', [ 
				'events' => [ 
						'Model.beforeSave' => [ 
								'created_on' => 'new',
								'modified_on' => 'always' 
						] 
				]
				 
		] );
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
			
			->add('campaign_partner_mailinglist_id', 'valid', ['rule' => 'numeric'])
			->requirePresence('campaign_partner_mailinglist_id', 'create')
			->notEmpty('campaign_partner_mailinglist_id')

			->add('product_sold', 'valid', ['rule' => ['maxLength',100]])
			->requirePresence('product_sold', 'create')
			->notEmpty('product_sold')
			
			->add('quantity_sold', 'valid', ['rule' => 'numeric'])
			->requirePresence('quantity_sold', 'create')
			->notEmpty('quantity_sold')
			
			->add('campaign_price', 'valid', ['rule' => 'numeric'])
			->allowEmpty('campaign_price')
			
			->add('deal_value', 'valid', ['rule' => 'numeric'])
			->requirePresence('deal_value', 'create')
			->notEmpty('deal_value')
			
      ->add('closure_date', 'valid', ['rule' => 'date'])
      ->requirePresence('closure_date', 'create')
      ->notEmpty('closure_date')
                        
			->add('created_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('created_on')
			->add('modified_on', 'valid', ['rule' => 'datetime'])
			->allowEmpty('modified_on');
		
		return $validator;
	}
}
