<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Countries Controller
 *
 * @property App\Model\Table\CountriesTable $Countries
 */
class CountriesController extends AppController {
public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
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
		$this->set('countries', $this->paginate($this->Countries));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view($id = null) {
		$country = $this->Countries->get($id, [
			'contain' => []
		]);
		$this->set('country', $country);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$country = $this->Countries->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->Countries->save($country)) {
				$this->Flash->success('The country has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The country could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('country'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($id = null) {
		$country = $this->Countries->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['post', 'put'])) {
			$country = $this->Countries->patchEntity($country, $this->request->data);
			if ($this->Countries->save($country)) {
				$this->Flash->success('The country has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The country could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('country'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function delete($id = null) {
		$country = $this->Countries->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->Countries->delete($country)) {
			$this->Flash->success('The country has been deleted.');
		} else {
			$this->Flash->error('The country could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
}
