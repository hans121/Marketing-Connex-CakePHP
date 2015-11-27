<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * SubscriptionPackages Controller
 *
 * @property App\Model\Table\SubscriptionPackagesTable $SubscriptionPackages
 */
class SubscriptionPackagesController extends AppController {
    public $components = ['Paginator'];
    public $helpers = ['Paginator'];
    public $paginate = [
        'limit' => 5,
        'order' => [
            'name' => 'asc'
        ]
    ];
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        // Allow users to register and logout.
       $this->Auth->allow(['packagelist','buypackage']);
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
		$this->set('subscriptionPackages', $this->paginate($this->SubscriptionPackages));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view($id = null) {
		$subscriptionPackage = $this->SubscriptionPackages->get($id, [
			'contain' => ['Vendors']
		]);
		$this->set('subscriptionPackage', $subscriptionPackage);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$subscriptionPackage = $this->SubscriptionPackages->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->SubscriptionPackages->save($subscriptionPackage)) {
				$this->Flash->success('The subscription package has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The subscription package could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('subscriptionPackage'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($id = null) {
		$subscriptionPackage = $this->SubscriptionPackages->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['post', 'put'])) {
			$subscriptionPackage = $this->SubscriptionPackages->patchEntity($subscriptionPackage, $this->request->data);
			if ($this->SubscriptionPackages->save($subscriptionPackage)) {
				$this->Flash->success('The subscription package has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The subscription package could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('subscriptionPackage'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function delete($id = null) {
		$this->loadModel('Vendors');
                $vendors= $this->Vendors->findBySubscriptionPackageId($id)->first();
                if(isset($vendors->id) && $vendors->id > 0 ){
                    $this->Flash->error('The subscription package have active vendors');
                    return $this->redirect(['action' => 'index']);
                }
                //print_r($vendors);exit;
                $subscriptionPackage = $this->SubscriptionPackages->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->SubscriptionPackages->delete($subscriptionPackage)) {
			$this->Flash->success('The subscription package has been deleted.');
		} else {
			$this->Flash->error('The subscription package could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
 /*
     * Function to list subscription packages on front end....
     */
    public function packagelist() {
          $query = $this->SubscriptionPackages->findAllByStatus('A')->order(['monthly_price'=>'ASC']);
          $pkgs     =   $this->paginate($query);
          $chkbxarray   =   array();
          $chktitles    =   array();
          foreach($pkgs as $pk){
              /*
               * Order should be

Resource Library

Portal Content mgt

MDF

Deal Registration

Social Medial

Partner Incentive Prog

Training & Comm's

Mulit-Languages

Partner App
               */
              if(isset($pk->portal_cms) && $pk->portal_cms == 'Y'){
                  if(!in_array('portal_cms', $chkbxarray)){
                      $chkbxarray[0]    =   'portal_cms';
                      $chktitles['portal_cms']    =   __('Content Management');
                  }
              }
              if(isset($pk->resource_library) && $pk->resource_library == 'Y'){
                  if(!in_array('resource_library', $chkbxarray)){
                      $chkbxarray[3]    =   'resource_library';
                      $chktitles['resource_library']    =   __('Resource Library');
                  }
              }
              if(isset($pk->lead_distribution) && $pk->lead_distribution == 'Y'){
                  if(!in_array('lead_distribution', $chkbxarray)){
                      $chkbxarray[1]    =   'lead_distribution';
                      $chktitles['lead_distribution']    =   __('Lead Distribution');
                  }
              }
              if(isset($pk->joint_business) && $pk->joint_business == 'Y'){
                  if(!in_array('joint_business', $chkbxarray)){
                      $chkbxarray[2]    =   'joint_business';
                      $chktitles['joint_business']    =   __('Campaign Planning');
                  }
              }
              if(isset($pk->portal_cms) && $pk->portal_cms == 'Y'){
                  if(!in_array('portal_cms', $chkbxarray)){
                      $chkbxarray[4]    =   'portal_cms';
                      $chktitles['portal_cms']    =   __('Portal Content Management');
                  }
              }
              if(isset($pk->MDF) && $pk->MDF == 'Y'){
                  if(!in_array('MDF', $chkbxarray)){
                      $chkbxarray[5]    =   'MDF';
                      $chktitles['MDF']    =   __('MDF & Co-op fund management');
                  }
              }
              if(isset($pk->deal_registration) && $pk->deal_registration == 'Y'){
                  if(!in_array('deal_registration', $chkbxarray)){
                      $chkbxarray[6]    =   'deal_registration';
                      $chktitles['deal_registration']    =   __('Deal Registration');
                  }
              }
              if(isset($pk->Socialmedia) && $pk->Socialmedia == 'Y'){
                  if(!in_array('Socialmedia', $chkbxarray)){
                      $chkbxarray[7]    =   'Socialmedia';
                      $chktitles['Socialmedia']    =   __('Social Media');
                  }
              }
              if(isset($pk->partner_incentive) && $pk->partner_incentive == 'Y'){
                  if(!in_array('partner_incentive', $chkbxarray)){
                      $chkbxarray[8]    =   'partner_incentive';
                      $chktitles['partner_incentive']    =   __('Partner Incentive Program');
                  }
              }
              if(isset($pk->training) && $pk->training == 'Y'){
                  if(!in_array('training', $chkbxarray)){
                      $chkbxarray[9]    =   'training';
                      $chktitles['training']    =   __('Training & Communication module');
                  }
              }
              if(isset($pk->partner_recruit) && $pk->partner_recruit == 'Y'){
                  if(!in_array('partner_recruit', $chkbxarray)){
                      $chkbxarray[10]    =   'partner_recruit';
                      $chktitles['partner_recruit']    =   __('Partner Recruitment');
                  }
              }
              
              
              if(isset($pk->multilingual) && $pk->multilingual == 'Y'){
                  if(!in_array('multilingual', $chkbxarray)){
                      $chkbxarray[11]    =   'multilingual';
                      $chktitles['multilingual']    =   __('Multi-Currency and Multi-Lingual');
                  }
              }
              
              if(isset($pk->partner_app) && $pk->partner_app == 'Y'){
                   if(!in_array('partner_app', $chkbxarray)){
                       $chkbxarray[12]    =   'partner_app';
                       $chktitles['partner_app']    =   __('Partner App');
                   }
               }
          }
          ksort($chkbxarray);
          $this->set('chkbxarray', $chkbxarray);
          $this->set('chktitles', $chktitles);
           $this->set('packages', $pkgs);
          $this->layout = 'frontend';

    }
}
