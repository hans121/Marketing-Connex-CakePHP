<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
/**
 * CampaignResources Controller
 *
 * @property App\Model\Table\CampaignResourcesTable $CampaignResources
 */
class CampaignResourcesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
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
			'contain' => ['Campaigns', 'Vendors']
		];
		$this->set('campaignResources', $this->paginate($this->CampaignResources));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$campaignResource = $this->CampaignResources->get($id, [
			'contain' => ['Campaigns', 'Vendors']
		]);
		$this->set('campaignResource', $campaignResource);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$campaignResource = $this->CampaignResources->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->CampaignResources->save($campaignResource)) {
				$this->Flash->success('The campaign resource has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The campaign resource could not be saved. Please, try again.');
			}
		}
		$campaigns = $this->CampaignResources->Campaigns->find('list');
		$vendors = $this->CampaignResources->Vendors->find('list');
		$this->set(compact('campaignResource', 'campaigns', 'vendors'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$campaignResource = $this->CampaignResources->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$campaignResource = $this->CampaignResources->patchEntity($campaignResource, $this->request->data);
			if ($this->CampaignResources->save($campaignResource)) {
				$this->Flash->success('The campaign resource has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The campaign resource could not be saved. Please, try again.');
			}
		}
		$campaigns = $this->CampaignResources->Campaigns->find('list');
		$vendors = $this->CampaignResources->Vendors->find('list');
		$this->set(compact('campaignResource', 'campaigns', 'vendors'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$campaignResource = $this->CampaignResources->get($id);
		$this->request->allowMethod('post', 'delete');
                $this->Filemanagement->removeFile('campaignresources/'.$campaignResource->filepath);
		if ($this->CampaignResources->delete($campaignResource)) {
			$this->Flash->success('The campaign resource has been deleted.');
		} else {
			$this->Flash->error('The campaign resource could not be deleted. Please, try again.');
		}
		return $this->redirect($this->referer());
	}
        /*
         * Function to download file
         */
        public function downloadfile($id=null){
            if($id!=null){
                $campaignResource = $this->CampaignResources->get($id);
		$this->request->allowMethod('post');
                $this->Filemanagement->download('campaignresources/'.$campaignResource->filepath,$campaignResource->title);
                return $this->redirect($this->referer());
            }
            return false;
        }
}
