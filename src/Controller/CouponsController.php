<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Coupons Controller
 *
 * @property App\Model\Table\CouponsTable $Coupons
 */
class CouponsController extends AppController {
    public $paginate = [
        'limit' => 5,
        'order' => [
            'status'=>'asc',
            'title' => 'asc'
        ]
    ];
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
            
        }elseif (isset($user['role']) && $user['role'] === 'admin' || $user['role'] === 'superadmin') {
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
    $query = $this->Coupons->find('all', ['contain' => ['Vendors']]);
    $this->set('coupons', $this->paginate($query));
	}
	

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view($id = null) {
		$coupon = $this->Coupons->get($id, [
			'contain' => ['Vendors.SubscriptionPackages']
		]);
		$this->set('coupon', $coupon);
	}
	


/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$coupon = $this->Coupons->newEntity($this->request->data);
		//print_r($coupon);exit;
    if ($this->request->is('post')) {
			if ($this->Coupons->save($coupon)) {
				$this->Flash->success('The coupon has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The coupon could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('coupon'));
	}


/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($id = null) {
		$coupon = $this->Coupons->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['post', 'put'])) {
			$coupon = $this->Coupons->patchEntity($coupon, $this->request->data);
			if ($this->Coupons->save($coupon)) {
				$this->Flash->success('The coupon has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The coupon could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('coupon'));
	}


/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function delete($id = null) {
		$coupon = $this->Coupons->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->Coupons->delete($coupon)) {
			$this->Flash->success('The coupon has been deleted.');
		} else {
			$this->Flash->error('The coupon could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
}
