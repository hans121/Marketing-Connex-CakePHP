<?php
	namespace App\Controller;
	
	use App\Controller\AppController;
	
	use Cake\Event\Event;

/**
 * Litmos Controller
 *
 * @property App\Model\Table\
 */
 
class LitmosController extends AppController {
	
	private $user;
    public function beforeFilter(Event $event) {
      parent::beforeFilter($event);
      $this->layout = 'admin';
      $this->loadModel('Campaigns');
      $this->loadModel('LandingPages');
      $this->loadModel('EmailTemplates');
	  $this->loadModel('Users');
	  $this->loadModel('VendorManagers');
	 
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
		$this->loadComponent('Litmos');
		$user_id = $this->Auth->user('id');
		$UserName =   $this->Auth->user('username');
		$FirstName = $this->Auth->user('first_name');
		$LastName = $this->Auth->user('last_name');
		$litmos= array();
		
		$user = $this->VendorManagers->find();
		$user->where(['user_id'=>$user_id]);
		
		foreach($user as $us) {
			array_push($litmos,$us->litmos_id);
		}
		$litmos_id = $litmos[0];
		
		
		$add = $this->Litmos->addUser($UserName,$FirstName,$LastName);
		
		$data = json_decode($add->body,true);
		
		$newLitmosID = $data['Id'];
		if($newLitmosID) {
			$query = $this->VendorManagers->query();
			$query->update()
				->set(['litmos_id' => $newLitmosID])
				->where(['user_id' => $user_id])
				->execute();
		}
		
		
	
		
		
		
		if ($this->request->is(['ajax'])) {
			$userLitmosID = $this->request->data['userLitmosID'];
			$signIn = $this->Litmos->signIn($userLitmosID);
			$signInKey = json_decode($signIn->body,true);
			$loginKey = $signInKey['LoginKey'];
			$userLitmosID = $signInKey['Id'];
			echo json_encode(array("userLitmosID"=>$userLitmosID,"loginKey"=>$loginKey));
			exit();
		}
		
		$signIn = $this->Litmos->signIn($litmos_id);
		$signInKey = json_decode($signIn->body,true);
		
		$loginKey = $signInKey['LoginKey'];
		$userLitmosID = $signInKey['Id'];
		
		 $this->set(compact('userLitmosID','loginKey'));
		
	}
}

?>