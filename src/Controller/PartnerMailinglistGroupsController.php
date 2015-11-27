<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * PartnerMailinglists Controller
 *
 * @property App\Model\Table\PartnerMailinglistsTable $PartnerMailinglists
 */
class PartnerMailinglistGroupsController extends AppController {

        public function beforeFilter(Event $event) {
            parent::beforeFilter($event);
            $this->layout = 'admin';
            $this->loadModel('PartnerMailinglists');
        }
        
        public function isAuthorized($user) {
            if(isset($user['status']) && $user['status'] === 'S') {
                $this->Flash->error(__('Your account is suspended, please contact Customer Support'));
                return $this->redirect(['controller' => 'Users','action' => 'vendorSuspended']);
            }elseif(isset($user['status']) && $user['status'] === 'B') {
                $this->Flash->error(__('Your account is blocked, please contact Customer Support'));
                return $this->redirect(['controller' => 'Users','action' => 'vendorBlocked']);
             }elseif(isset($user['status']) && $user['status'] === 'D') {
                $this->Flash->error(__('Your account is inactive, please contact Customer Support'));
                return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);

             }elseif(isset($user['status']) && $user['status'] === 'P') {
               $this->Flash->error(__('Your account is inactive, please contact Customer Support'));
               return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);

            }elseif(isset($user['role']) && $user['role'] === 'partner') {
                return true;
            }
            // Default deny
            return false;
        }

        /**
         * Index method
         *
         * @return void
         */
        public function index() {
        	$partnerMailinglistGroups =   $this->paginate($this->PartnerMailinglistGroups->find()->order(['is_default'=>'desc'])->where(['partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')]));
        	
        	$this->set('PartnerMailinglistGroups', $partnerMailinglistGroups);
        	$this->set('PartnerMailinglists', $this->PartnerMailinglists);
        }
       
/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$defaultgroup = $this->PartnerMailinglistGroups->find('all')->where(['is_default'=>'1','partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')]);
    	$partnerMailinglistGroup = $this->PartnerMailinglistGroups->newEntity($this->request->data);
		if ($this->request->is('post')) {			
			if ($partnerMailinglistGroup = $this->PartnerMailinglistGroups->save($partnerMailinglistGroup)) {
				$this->Flash->success('Your new list has been created. Please add contacts.');
				return $this->redirect(['controller'=>'PartnerMailinglists', 'action' => 'show', $partnerMailinglistGroup->id]);
			} else {
				$this->Flash->error('Sorry, the mailing list could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('partnerMailinglistGroup','defaultgroup'));
	}
	
	
	

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
        $partnerMailinglist = $this->PartnerMailinglistGroups->get($id);
                
		if ($this->request->is(['patch', 'post', 'put'])) {
             $partnerMailinglist = $this->PartnerMailinglistGroups->patchEntity($partnerMailinglist, $this->request->data);
             if ($this->PartnerMailinglistGroups->save($partnerMailinglist)) {
                 $this->Flash->success('The mailing list has been saved.');
                 return $this->redirect(['action' => 'index']);
             } else {
                 $this->Flash->error('Sorry, the mailing list could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
             }
		}
		
		$this->set(compact('partnerMailinglist'));
		$this->set('country_list',$this->country_list);
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$partnerMailinglist = $this->PartnerMailinglistGroups->get($id);
		$this->request->allowMethod('get', 'delete');
		if ($this->PartnerMailinglistGroups->delete($partnerMailinglist)) {
			$query = $this->PartnerMailinglists->query();
			$query	->delete()
					->where(['partner_mailinglist_group_id'=>$id,'partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')])
					->execute();
			$this->Flash->success('The mailing list has been deleted.');
		} else {
			$this->Flash->error('Sorry, the mailing list could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
	
	public function bulkdelete(){
		if ($this->request->is(['patch', 'post', 'put'])) {
			$ids    =   explode(',',$this->request->data['ids']);
			foreach($ids as $id){
				$partnerMailinglist = $this->PartnerMailinglistGroups->get($id);
				if($partnerMailinglist->is_default==0) //Delete non default only
				if ($this->PartnerMailinglistGroups->delete($partnerMailinglist)) {
					$query = $this->PartnerMailinglists->query();
					$query	->delete()
					->where(['partner_mailinglist_group_id'=>$id,'partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')])
					->execute();
				}
			}
	
	
		}
		return $this->redirect(['action' => 'index']);
		exit;
	}
	
	public function makedefault($id = null)
	{		
		$list = $this->PartnerMailinglistGroups->get($id);
		$prev_list = $this->PartnerMailinglistGroups->find()->where(['is_default'=>'1','partner_id'=>$this->Auth->user('partner_id'),'vendor_id'=>$this->Auth->user('vendor_id')])->first();

		$list = $this->PartnerMailinglistGroups->patchEntity($list,['is_default'=>'1']);
		$prev_list = $this->PartnerMailinglistGroups->patchEntity($prev_list,['is_default'=>'0']);
		
		$this->PartnerMailinglistGroups->save($list);
		$this->PartnerMailinglistGroups->save($prev_list);
		
		$this->Flash->success('The mailing list "'.$list->name.'" has been marked as default.');
		return $this->redirect(['action' => 'index']);
	}
}
