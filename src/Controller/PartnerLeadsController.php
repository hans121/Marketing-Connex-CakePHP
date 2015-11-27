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
class PartnerLeadsController extends AppController {
	
	 public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		// Allow users to register and logout.
		$this->loadComponent('Salesforce');		
		$this->loadModel('Leads');
		$this->loadModel('LeadDeals');
		$this->loadModel('Partners');
		$this->loadModel('PartnerManagers');
		//$this->loadModel('PartnerLeadDeals');
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
		} elseif(isset($user['role']) && $user['role'] === 'partner') {
			return true;
		}
		// Default deny
		return false;
	}
	    
	public function index() {
		$query = $this->Leads->find('all', ['contain' => ['LeadDeals.PartnerManagers.Users']]);
		
		if($this->request->is(['post']))
		{
			if($this->request->data['query']!='')
			{
				$queries = explode(' ',$this->request->data['query']);
				foreach($queries as $key)
				{
					$query->orWhere(["Leads.company LIKE '%{$key}%'"]);
					$query->orWhere(["Leads.first_name LIKE '%{$key}%'"]);
					$query->orWhere(["Leads.last_name LIKE '%{$key}%'"]);
					$query->orWhere(["Leads.email LIKE '%{$key}%'"]);
				}
			}
		}
		
		$query->andWhere(['Leads.partner_id'=>$this->Auth->user('partner_id'),"((Leads.response='accepted' and (Leads.response='accepted' and Leads.response_status!='qualifiedout')) or Leads.response='')"]);
		$leads = $this->paginate($query);
				
		$this->set(compact('leads'));
	}
	
	// Ajax specific action function
	public function ajaxLeadAction($id)
	{
		$this->layout = 'ajax';
		
		if($this->request->is(['post','ajax']))
		{
		
			$partner_lead = $this->Leads->get($id);
			
			if($this->request->data['status']=='accepted')
			{
				$partner_lead = $this->Leads->patchEntity($partner_lead,['responsed'=>'1','response'=>'accepted','accepted_on'=>date('Y-m-d h:i:s'),'expire_on'=>'0000-00-00 00:00:00']);
				$this->Leads->save($partner_lead);
				
				echo 'accepted';
			}
			else 
			{
				$partner_lead = $this->Leads->patchEntity($partner_lead,['assigned'=>'0','responsed'=>'1','response'=>'rejected','response_note'=>$this->request->data['note'],'expire_on'=>'0000-00-00 00:00:00']);
				$this->Leads->save($partner_lead);
				
				$this->Flash->success('The lead has been rejected!');
				
				echo 'rejected';
			}
		
		}
		
		exit();
	}
	//end ajax function
	
	public function edit($id) {
		//$partner_lead = $this->PartnerLeads->get($id);
		$lead = $this->Leads->get($id,['contain'=>['Vendors','LeadDeals']]);
		if($lead->lead_deal)
			$lead_deal = $this->LeadDeals->get($lead->lead_deal->id);
		else
			$lead_deal = $this->LeadDeals->newEntity();
			
		if($lead->response_status=='converted')
		{
			$this->Flash->error('Sorry, a converted lead cannot be edited!');
			$this->redirect($this->referer());
		}
		else
			if($this->request->is(['post','patch','put']))
			{
				if($this->request->data['response_status'])
				{
					$lead = $this->Leads->patchEntity($lead,['response_status'=>$this->request->data['response_status'],'response_note'=>$this->request->data['response_note'],'lead_status'=>($this->request->data['response_status']!='qualifiedout'?'active':'inactive')]);
					$lead = $this->Leads->save($lead);
					
					$this->loadModel('LeadResponseNotes');
					
					$leadnote = $this->LeadResponseNotes->newEntity(['lead_id'=>$id,'partner_id'=>$this->Auth->user('partner_id'),'response_note'=>$this->request->data['response_note'],'response'=>$lead->response,'response_status'=>$this->request->data['response_status']]);
					$leadnote = $this->LeadResponseNotes->save($leadnote);
					
					$this->Flash->success('The lead has been updated!');
				}
				else
				{
					$lead = $this->Leads->patchEntity($lead,['response_status'=>'converted','response_note'=>'']);
					$lead = $this->Leads->save($lead);
					
					$this->request->data['closure_date'] = $this->request->data['status']=='0'?'0000-00-00 00:00:00.000000':date('Y-m-d h:i:s');
					$this->request->data['status'] = $this->request->data['status']=='0'?'N':'Y';
					$lead_deal = $this->LeadDeals->find()->where(['lead_id'=>$this->request->data['lead_id']]);
					if($lead_deal->count()>0)
					{
						$lead_deal = $lead_deal->first();
						$lead_deal = $this->LeadDeals->patchEntity($lead_deal,$this->request->data);
						$lead_deal = $this->LeadDeals->save($lead_deal);
					}
					else
					{
						$lead_deal = $this->LeadDeals->newEntity($this->request->data);
						$lead_deal = $this->LeadDeals->save($lead_deal);
					}
					
					$this->Flash->success('A deal has been registered!');
				}
	
				return $this->redirect(['action'=>'index']);
			}
		$partner_managers = $this->PartnerManagers->find()->contain(['Users'])->where(['partner_id'=>$this->Auth->user('partner_id')])->order(['primary_contact'=>'desc']);
		$partners = [];
		foreach($partner_managers as $partner_manager)
			$partners[$partner_manager->id] = $partner_manager->user->first_name . ' ' . $partner_manager->user->last_name;
		
		$this->set(compact('lead','partners','lead_deal'));
	}
	
	public function view($id) {
		$lead = $this->Leads->get($id,['contain'=>['Vendors','LeadDeals','LeadResponseNotes']]);
		if($lead->lead_deal)
			$partner_lead_deal = $this->LeadDeals->get($lead->lead_deal['id'],['contain'=>'PartnerManagers.Users']);
		else
			$partner_lead_deal = $this->LeadDeals->newEntity();
		$this->set(compact('lead','partner_lead_deal'));
	}
	  
}
