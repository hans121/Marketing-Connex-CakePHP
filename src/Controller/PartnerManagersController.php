<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * PartnerManagers Controller
 *
 * @property App\Model\Table\PartnerManagersTable $PartnerManagers
 */
class PartnerManagersController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);       
        $this->loadModel('Users');
        $this->loadModel('Partners');
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
            
        }elseif (isset($user['role']) && $user['role'] === 'admin') {
            return false;
        }
        elseif(isset($user['role']) && $user['role'] === 'vendor') {
            return false;
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
		$this->paginate = [
			'contain' => ['Partners', 'Users'],
                        'conditions' => ['PartnerManagers.partner_id'=>$this->Auth->user('partner_id')]
		];
		$this->set('partnerManagers', $this->paginate($this->PartnerManagers));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view($id = null) {
		$partnerManager = $this->PartnerManagers->get($id, [
			'contain' => ['Partners', 'Users']
		]);
                if($this->Auth->user('partner_id') != $partnerManager->partner_id){
                    $this->Flash->error(' Sorry, you do not have permission to view the details.');
                    return $this->redirect(array('controller' => 'Partners', 'action' => 'index'));
                }
		$this->set('partnerManager', $partnerManager);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		if(isset($this->request->data['email'])){
                    $this->request->data['username']   =   $this->request->data['email'];
                    $existingusers_array = array();
                    $existingusers = $this->Users->find('all')
                    							 ->select('username');
                    foreach ($existingusers as $exist) {
	                    array_push($existingusers_array, $exist->username);
                    }
                }
                $user = $this->Users->newEntity($this->request->data);
                
                if ($this->request->is('post')) {
                    if($this->request->data['conf_password'] == $this->request->data['password']){
                        $udata  =   $this->request->data;
                        unset($udata['partner_manager']);
                        
                        if ($uresult = $this->Users->save($user)) {
                            $this->request->data['partner_manager']['user_id'] =   $uresult->id;
                            $this->request->data['partner_manager']['status'] = 'Y';
                           if($this->__addPmanager($this->request->data['partner_manager'])){
                               $this->Prmsemails->userSignupemail($udata);
                               $this->Flash->success(__('The partner manager has been added successfully.'));
                               return $this->redirect(['action' => 'index']);
                           }

                        }
                        if (in_array($this->request->data['email'], $existingusers_array)) {
	                        $this->Flash->error(__('Sorry, the email address is already associated with a user, please try again with a different email address'));
                        }else{
                         $this->Flash->error(__('Unable to add the Partner Manager. Please try again. If you continue to experience problems, please contact Customer Support.'));
                         }
                    }else{
                         $this->Flash->error(__('The passwords entered do not match. Please try again.'));
                    }

                }
                $this->set('user', $user);
                $this->set('partner_id', $this->Auth->user('partner_id'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($id = null) {
            $partnerManager = $this->PartnerManagers->get($id, [
                        'contain' => ['Partners', 'Users']
                ]);
            $pid=   $partnerManager->partner_id;
            if($this->Auth->user('partner_id') != $pid){
                 $this->Flash->error(' Sorry, you do not have permission to view the details.');
                 return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
            }
            $user = $this->Users->get($partnerManager->user_id, [
                    'contain' => []
             ]);
            if ($this->request->is(['post', 'put'])) {
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if ($this->Users->save($user)) {
                         $this->Flash->success('The partner manager has been saved.');
                         return $this->redirect(['action' => 'view',$partnerManager->id]);

                    } else {
                            $this->Flash->error('The partner manager could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                    }
            }

            $this->set('user', $user);
            $this->set('partner_id',$partnerManager->partner_id);
	}
        function __addPmanager($pmgr){
            $this->loadModel('PartnerManagers');
            $manager = $this->PartnerManagers->newEntity($pmgr);
            if($this->PartnerManagers->save($manager)){
                return true;
            }
            return false;
        }
        function __delete_user($id=null){
            $user = $this->Users->get($id);
            if ($this->Users->delete($user)) {
                    return true;
            } else {
                   return false;
            }
            
        }
/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function delete($id = null) {
            $partnerManager = $this->PartnerManagers->get($id);
            $this->request->allowMethod('post', 'delete');

            $partnermanager = $this->PartnerManagers->get($id, ['contain' => ['Partners', 'Users']]); 
            $pid   =  $this->Auth->user('partner_id');
            if($pid != $partnermanager->partner_id){
                $this->Flash->error(' Sorry , You are not authorized to delete');
                return $this->redirect(array('controller' => 'partners', 'action' => 'index'));
            }
            if($partnermanager->primary_contact == 'Y'){
               $this->Flash->error(__('A primary manager cannot be deleted. Please assign another manager as the primary manager and then try again. If you continue to experience problems, please contact Customer Support.'));

            }else{
                if($this->__delete_user($partnermanager->user_id)){
                    $this->Flash->success(__('The partner manager has been deleted successfully.'));
                }else{
                    $this->Flash->error(__('Sorry, we couldn\'t delete the partner manager. Please try again. If you continue to experience problems, please contact Customer Support.'));
                }

            }
            return $this->redirect(['action' => 'index']);
                
	}
        
        public function changePrimaryPmanager($id = null) {
            $partnermanager = $this->PartnerManagers->get($id); 
            $vid   =  $this->Auth->user('vendor_id');
            if($partnermanager->partner_id != $this->Auth->user('partner_id')){
                $this->Flash->error(' Sorry, you do not have permission to view the details.');
                return $this->redirect(array('controller' => 'Partners', 'action' => 'index'));
            }
            if($id > 0){
                $this->request->allowMethod('post', 'put');
                $this->PartnerManagers->updateAll(['primary_contact' => 'N'], ['partner_id' => $partnermanager->partner_id]);
                $this->PartnerManagers->updateAll(['primary_contact' => 'Y'], ['id' => $id,'partner_id' => $partnermanager->partner_id]);
                $this->Flash->success(__('The primary manager has been changed successfully.'));

            }
            return $this->redirect(['controller'=>'users','action' => 'login']);
    }
        
   
    
    
}
