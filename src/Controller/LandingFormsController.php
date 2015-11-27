<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
/**
 * LandingForms Controller
 *
 * @property App\Model\Table\LandingFormsTable $LandingForms
 */
class LandingFormsController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->loadModel('Campaigns');
        $this->loadModel('LandingForms');
        $this->Auth->allow(['add']);
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
            
        }elseif(isset($user['role']) && $user['role'] === 'vendor') {
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
		$this->paginate = [
			'contain' => ['LandingPages']
		];
		$this->set('landingForms', $this->paginate($this->LandingForms));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$landingForm = $this->LandingForms->get($id, [
			'contain' => ['LandingPages']
		]);
		$this->set('landingForm', $landingForm);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$landingForm = $this->LandingForms->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->LandingForms->save($landingForm)) {
				$this->Flash->success('The landing page form has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The landing page form could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$landingPages = $this->LandingForms->LandingPages->find('list');
		$this->set(compact('landingForm', 'landingPages'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$landingForm = $this->LandingForms->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$landingForm = $this->LandingForms->patchEntity($landingForm, $this->request->data);
			if ($this->LandingForms->save($landingForm)) {
				$this->Flash->success('The landing page form has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The landing page form could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$landingPages = $this->LandingForms->LandingPages->find('list');
		$this->set(compact('landingForm', 'landingPages'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$landingForm = $this->LandingForms->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->LandingForms->delete($landingForm)) {
			$this->Flash->success('The landing page form has been deleted.');
		} else {
			$this->Flash->error('The landing page form could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
}
