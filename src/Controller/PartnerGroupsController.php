<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * PartnerGroups Controller
 *
 * @property App\Model\Table\PartnerGroupsTable $PartnerGroups
 */
class PartnerGroupsController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        
       $this->layout = 'admin';
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

            }elseif (isset($user['role']) && $user['role'] === 'vendor') {
                return true;
            }
           
            return false;
        }
/**
 * Index method
 *
 * @return void
 */
	public function index() {
		$this->paginate = [
			'contain' => ['Vendors'],'conditions' => ['vendor_id' => $this->Auth->user('vendor_id')],
		];
		$this->set('partnerGroups', $this->paginate($this->PartnerGroups));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view($id = null) {
		$this->loadModel('PartnerGroupMembers');
		$partnerGroup = $this->PartnerGroups->get($id, [
			'contain' => ['Vendors']
		]);
		
		$partnerGroupMembers = $this->PartnerGroupMembers->find()->contain(['Partners'])->where(['group_id'=>$id]);
                if($this->Auth->user('vendor_id') != $partnerGroup->vendor_id){
                    $this->Flash->error(' Sorry, you do not have permission to view the details.');
                    return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
                }
		$this->set(compact('partnerGroup', 'partnerGroupMembers'));
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$partnerGroup = $this->PartnerGroups->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->PartnerGroups->save($partnerGroup)) {
				$this->Flash->success('The partner group has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The partner group could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$vendors = $this->PartnerGroups->Vendors->find('list');
		$this->set(compact('partnerGroup', 'vendors'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($id = null) {
		$partnerGroup = $this->PartnerGroups->get($id, [
			'contain' => []
		]);
                if($this->Auth->user('vendor_id') != $partnerGroup->vendor_id){
                    $this->Flash->error(' Sorry, you do not have permission to view the details.');
                    return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
                }
		if ($this->request->is(['post', 'put'])) {
			$partnerGroup = $this->PartnerGroups->patchEntity($partnerGroup, $this->request->data);
			if ($this->PartnerGroups->save($partnerGroup)) {
				$this->Flash->success('The partner group has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The partner group could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$vendors = $this->PartnerGroups->Vendors->find('list');
		$this->set(compact('partnerGroup', 'vendors'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function delete($id = null) {
		$partnerGroup = $this->PartnerGroups->get($id);
                if($this->Auth->user('vendor_id') != $partnerGroup->vendor_id){
                    $this->Flash->error(' Sorry, you do not have permission to view the details.');
                    return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
                }
		$this->request->allowMethod('post', 'delete');
                $this->loadModel('Partners');
                $partners= $this->Partners->findByPartnerGroupId($id)->first();
                if(isset($partners->id) && $partners->id > 0 ){
                    $this->Flash->error('This subscription package has active partners.');
                    return $this->redirect(['action' => 'index']);
                }
		if ($this->PartnerGroups->delete($partnerGroup)) {
			$this->Flash->success('The partner group has been deleted.');
		} else {
			$this->Flash->error('The partner group could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
}
