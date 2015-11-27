<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Settings Controller
 *
 * @property App\Model\Table\SettingsTable $Settings
 */
class SettingsController extends AppController {

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
		$this->set('settings', $this->paginate($this->Settings));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view($id = null) {
		$setting = $this->Settings->get($id, [
			'contain' => []
		]);
		$this->set('setting', $setting);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$setting = $this->Settings->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->Settings->save($setting)) {
				$this->Flash->success('Your settings have been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('Your settings could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('setting'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($id = null) {
		$setting = $this->Settings->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['post', 'put'])) {
			$setting = $this->Settings->patchEntity($setting, $this->request->data);
			if ($this->Settings->save($setting)) {
				$this->Flash->success('Your settings have been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('Your settings could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('setting'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function delete($id = null) {
		$setting = $this->Settings->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->Settings->delete($setting)) {
			$this->Flash->success('Your settings have been deleted.');
		} else {
			$this->Flash->error('Your settings could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
}
