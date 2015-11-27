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
class LeadsController extends AppController {
	
	 public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		// Allow users to register and logout.
		$this->loadComponent('Salesforce');		
		$this->loadModel('PartnerLeads');
		$this->loadModel('Partners');
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
		$query = $this->Leads->find('all', ['contain' => ['Partners']]);

		if($this->request->is(['post']))
		{				
			if($this->request->data['name']!='')
			{
				$names = explode(' ',$this->request->data['name']);
				foreach($names as $name)
				{
					$query->orWhere(["Leads.first_name LIKE '%{$name}%'"]);
					$query->orWhere(["Leads.last_name LIKE '%{$name}%'"]);
				}
			}
			
			if($this->request->data['status']!='')
				$query->andWhere([ 'Leads.assigned'=>$this->request->data['status'] ]);
		}
		
		$query->andWhere(['Leads.vendor_id'=>$this->Auth->user('vendor_id'),'Leads.lead_status'=>'active']);
		
		$leads = $this->paginate($query);
		
		// check if connected to salesforce
		//$salesforce_isauth = $this->Salesforce->isAuth();
		
		$this->set(compact('salesforce_isauth','leads'));
	}
	
	public function inactive() {
		$query = $this->Leads->find('all', ['contain' => ['Partners']]);
	
		if($this->request->is(['post']))
		{
			if($this->request->data['name']!='')
			{
				$names = explode(' ',$this->request->data['name']);
				foreach($names as $name)
				{
					$query->orWhere(["Leads.first_name LIKE '%{$name}%'"]);
					$query->orWhere(["Leads.last_name LIKE '%{$name}%'"]);
				}
			}
				
			if($this->request->data['status']!='')
				$query->andWhere([ 'Leads.assigned'=>$this->request->data['status'] ]);
		}
	
		$query->andWhere(['Leads.vendor_id'=>$this->Auth->user('vendor_id'),'Leads.lead_status'=>'inactive']);
	
		$leads = $this->paginate($query);
	
		// check if connected to salesforce
		//$salesforce_isauth = $this->Salesforce->isAuth();
	
		$this->set(compact('salesforce_isauth','leads'));
	}
	
	public function add() {
		$lead = $this->Leads->newEntity();
		$partners = $this->Partners->find('list')->where(['vendor_id'=>$this->Auth->user('vendor_id')]);
		if ($this->request->is('post')) {
			$this->request->data['assigned'] = '1';
			$this->request->data['assigned_on'] = date('Y-m-d h:i:s');
			$this->request->data['expire_on'] = date('Y-m-d h:i:s',strtotime('+'.$this->request->data['response_time'].' DAY'));			
			$lead = $this->Leads->newEntity($this->request->data);
			$lead = $this->Leads->save($lead);
			if($lead->id)
			{				
				// Send notification to partner/s for assigned lead
				$this->Prmsemails->leadAssigned($lead->id);
			}
			
			$this->Flash->success('New lead has been saved'.$assigned.'!');
			return $this->redirect(['action'=>'index']);
			
		}
		$this->set(compact('lead','partners'));
	}
	
	public function edit($id) {
		$lead = $this->Leads->get($id,['contain'=>['Partners']]);
		if($this->request->is(['post','patch','put']))
		{
			$this->request->data['assigned'] = '1';
			$this->request->data['assigned_on'] = date('Y-m-d h:i:s');
			$this->request->data['expire_on'] = date('Y-m-d h:i:s',strtotime('+'.$this->request->data['response_time'].' DAY'));
			
			if($lead->partner_id!=$this->request->data['partner_id']) //if changed assigned partner, clear response data
			{
				$this->request->data['responsed'] = '0';
				$this->request->data['response'] = '';
				$this->request->data['response_status'] = '';
				$this->request->data['response_note'] = '';
				$this->request->data['accepted_on'] = '0000-00-00 00:00:00';
			}
			
			$lead = $this->Leads->patchEntity($lead,$this->request->data);
			$lead = $this->Leads->save($lead);
						
			$this->Flash->success('The lead has been saved!');
			return $this->redirect(['action'=>'index']);
		}
		$partners = $this->Partners->find('list')->where(['vendor_id'=>$this->Auth->user('vendor_id')]);
		$this->set(compact('lead','partners'));
	}
	
	public function view($id) {
		$lead = $this->Leads->get($id,['contain'=>['Partners','LeadResponseNotes']]);
		$this->set(compact('lead'));
	}
	
	public function delete($id) {
		$this->request->allowMethod('post', 'delete');
		
		// delete lead
		$lead = $this->Leads->get($id);
		$this->Leads->delete($lead);
		
		$this->Flash->success('Lead was deleted!');
		
		return $this->redirect(['action' => 'index']);
	}
	  
}
