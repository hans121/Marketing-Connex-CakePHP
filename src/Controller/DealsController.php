<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class DealsController extends AppController {
	
	 public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		// Allow users to register and logout.
		$this->loadComponent('Salesforce');
		$this->loadModel('LeadDeals');
		//$this->loadModel('PartnerLeads');
		$this->loadModel('Leads');
		$this->layout = 'admin';
	}
	
	public function isAuthorized($user) {		
		if(isset($user['status']) && $user['status'] === 'S') {
			$this->Flash->error(__('Your account is suspended, please contact Customer Support'));
			return $this->redirect(['controller' => 'Users','action' => 'vendorSuspended']);
		} elseif(isset($user['status']) && $user['status'] === 'B') {
			$this->Flash->error(__('Your account is blocked, please contact Customer Support'));
			return $this->redirect(['controller' => 'Users','action' => 'vendorBlocked']);
		} elseif(isset($user['status']) && $user['status'] === 'D') {
			$this->Flash->error(__('Your account is inactive, please contact Customer Support'));
			return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);
		} elseif(isset($user['status']) && $user['status'] === 'P') {
			$this->Flash->error(__('Your account is inactive, please contact Customer Support'));
			return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);
		} elseif(isset($user['role']) && $user['role'] === 'vendor') {
			return true;
		}
		// Default deny
		return false;
	}
	    
	public function index() {
		// Look for deals under current vendor leads and compose search conditions
		$leads_query = $this->Leads->find()->contain(['Partners']);
		
		//$partner_leads_query = $this->PartnerLeads->find()->contain(['Partners']);
		
		$lead_deals_query = $this->LeadDeals->find()->contain(['PartnerManagers.Users']);
		
		// start search query
		if($this->request->is(['post']))
		{
			if($this->request->data['query']!='')
			{
				$queries = explode(' ',$this->request->data['query']);
				foreach($queries as $key)
				{
					switch($this->request->data['field'])
					{
						case 'partner':
							$leads_query->orWhere(["Partners.company_name LIKE '%{$key}%'"]);
							break;
							
						case 'name':
							$lead_deals_query->orWhere(["Users.first_name LIKE '%{$key}%'"]);
							$lead_deals_query->orWhere(["Users.last_name LIKE '%{$key}%'"]);
							break;
							
						case 'company':
							$leads_query->orWhere(["Leads.company LIKE '%{$key}%'"]);
							break;
					}
				}
			}
		}
		
		$leads_query->andWhere(['Leads.vendor_id'=>$this->Auth->user('vendor_id')]);
		$leads = [];
		foreach($leads_query as $lead)
			$leads[$lead->id] = $lead->id;
				
		$lead_deals_query->andWhere(['lead_id IN'=>$leads]);
		$lead_deals = [];
		foreach($lead_deals_query as $lead_deal)
			$lead_deals[$lead_deal->id] = $lead_deal->id;
		
		// end lookup
		
		$query = $this->LeadDeals->find('all', ['contain' => ['Leads','PartnerManagers.Users','Partners']]);
		
		$query->andWhere(['LeadDeals.id IN'=>$lead_deals]);
		//$query->andWhere(["Partners.company_name LIKE '%country%'"]);
		
		$deals = $this->paginate($query);
		
		// check if connected to salesforce
		//$salesforce_isauth = $this->Salesforce->isAuth();
		
		$this->set(compact('salesforce_isauth','deals'));
	}  
		
	public function view($id) {
		$deal = $this->LeadDeals->get($id,['contain'=>['Leads','Partners','PartnerManagers.Users']]);
		$this->set(compact('deal'));
	}
	
	  
}
