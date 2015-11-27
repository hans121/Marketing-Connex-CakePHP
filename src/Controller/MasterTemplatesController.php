<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * MasterTemplates Controller
 *
 * @property App\Model\Table\MasterTemplatesTable $MasterTemplates
 */
class MasterTemplatesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
       $this->loadModel('Vendors');
       $this->loadModel('Coupons');
       $this->loadModel('SubscriptionPackages');
       $this->loadModel('VendorPayments');
       $this->loadModel('VendorManagers');
       $this->loadModel('Users');
       $this->layout = 'admin';
    }
    public function isAuthorized($user) {
        // Admin can access every action
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
            
        }elseif (isset($user['role']) && $user['role'] === 'admin') {
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
		$this->set('masterTemplates', $this->paginate($this->MasterTemplates));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$masterTemplate = $this->MasterTemplates->get($id, [
			'contain' => []
		]);
		$this->set('masterTemplate', $masterTemplate);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$masterTemplate = $this->MasterTemplates->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->MasterTemplates->save($masterTemplate)) {
				$this->Flash->success('The master template has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The master template could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('masterTemplate'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$masterTemplate = $this->MasterTemplates->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$masterTemplate = $this->MasterTemplates->patchEntity($masterTemplate, $this->request->data);
			if ($this->MasterTemplates->save($masterTemplate)) {
				$this->Flash->success('The master template has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The master template could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('masterTemplate'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$masterTemplate = $this->MasterTemplates->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->MasterTemplates->delete($masterTemplate)) {
			$this->Flash->success('The master template has been deleted.');
		} else {
			$this->Flash->error('The master template could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
}
