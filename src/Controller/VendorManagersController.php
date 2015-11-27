<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;

/**
 * VendorManagers Controller
 *
 * @property App\Model\Table\VendorManagersTable $VendorManagers
 */
class VendorManagersController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        $this->Auth->allow(['buypackage','primarycontact']);
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
        }/*
        elseif(isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }elseif(isset($user['role']) && $user['role'] === 'partner') {
            return true;
        }
*/
        // Default deny
        return false;
    }
/**
 * Index method
 *
 * @return void
 */
	public function index() {
		$this->paginate = [
			'contain' => ['Vendors', 'Users']
		];
		$this->set('vendorManagers', $this->paginate($this->VendorManagers));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view($id = null) {
		$vendorManager = $this->VendorManagers->get($id, [
			'contain' => ['Vendors', 'Users']
		]);
		$this->set('vendorManager', $vendorManager);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$vendorManager = $this->VendorManagers->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->VendorManagers->save($vendorManager)) {
				$this->Flash->success('The vendor manager has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The vendor manager could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$vendors = $this->VendorManagers->Vendors->find('list');
		$users = $this->VendorManagers->Users->find('list');
		$this->set(compact('vendorManager', 'vendors', 'users'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($id = null) {
		$vendorManager = $this->VendorManagers->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['post', 'put'])) {
			$vendorManager = $this->VendorManagers->patchEntity($vendorManager, $this->request->data);
			if ($this->VendorManagers->save($vendorManager)) {
				$this->Flash->success('The vendor manager has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The vendor manager could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$vendors = $this->VendorManagers->Vendors->find('list');
		$users = $this->VendorManagers->Users->find('list');
		$this->set(compact('vendorManager', 'vendors', 'users'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function delete($id = null) {
		$vendorManager = $this->VendorManagers->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->VendorManagers->delete($vendorManager)) {
			$this->Flash->success('The vendor manager has been deleted.');
		} else {
			$this->Flash->error('The vendor manager could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
}
