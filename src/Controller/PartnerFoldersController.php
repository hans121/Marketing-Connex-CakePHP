<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Folders Controller
 *
 * @property App\Model\Table\FoldersTable $Folders
 */
class PartnerFoldersController extends AppController {
    
    private $user;

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->set('country_list',$this->country_list);
		$this->loadModel('Folders');
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
            
        }elseif (isset($user['role']) && $user['role'] === 'admin') {
            return false;
        }
        elseif(isset($user['role']) && $user['role'] === 'vendor') {
            return false;
        }elseif(isset($user['role']) && $user['role'] === 'partner') {
            $this->user = $user;
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
			'contain' => ['Users', 'Vendors']
		];
		$this->set('folders', $this->paginate($this->Folders->find('all')->where(['parentpath !='=> '0'])));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$folder = $this->Folders->get($id, [
			'contain' => ['Users', 'Vendors', 'Resources']
		]);
		$this->set('folder', $folder);
	}
}
