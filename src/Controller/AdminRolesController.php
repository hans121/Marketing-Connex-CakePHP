<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\NotFoundException;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

/**
 * Users Controller
 */
class AdminRolesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['index','add', 'edit', 'delete']);
        
        $this->loadModel('AdminRights');
        $this->loadModel('AdminRoleRights');
    }
    
    public function index() {
    	$admin_roles = $this->AdminRoles->find();
    	$admin_roles = $this->paginate($admin_roles);
    	$this->set(compact('admin_roles'));
    }
    
    public function add() {
    	if ($this->request->is('post') || $this->request->is('put')) {
    		$role = $this->AdminRoles->newEntity(['role'=>$this->request->data['role'],'description'=>$this->request->data['description']]);
    		$role = $this->AdminRoles->save($role);
    		
    		foreach($this->request->data['rights'] as $right)
    		{
    			$adminright = $this->AdminRoleRights->newEntity(['admin_role_id'=>$role->id,'admin_right_id'=>$right]);
    			$this->AdminRoleRights->save($adminright);
    		}
    		$this->Flash->success('The new admin role was created.');
    		return $this->redirect(['controller' => 'AdminRoles','action' => 'index']);
    	}
    	$rights = $this->AdminRights->find('all');
    	$role = $this->AdminRoles->newEntity();
    	$this->set(compact('role','rights'));
    }
    
    public function edit($roleid) {
    	$role = $this->AdminRoles->get($roleid);
    	
    	if ($this->request->is('post') || $this->request->is('put')) {
    		$role = $this->AdminRoles->patchEntity($role,['role'=>$this->request->data['role'],'description'=>$this->request->data['description']]);
    		$this->AdminRoles->save($role);
    		
    		$this->AdminRoleRights->deleteAll(['admin_role_id'=>$roleid]);
    		foreach($this->request->data['rights'] as $right)
    		{
    			$adminright = $this->AdminRoleRights->newEntity(['admin_role_id'=>$roleid,'admin_right_id'=>$right]);
    			$this->AdminRoleRights->save($adminright);
    			
    		}

    		$this->Flash->success('The new admin role details was saved.');
    	}
    	
    	$rights = $this->AdminRights->find('all');
    	$admin_role_rights = $this->AdminRoleRights->find()->where(['admin_role_id'=>$roleid])->select(['admin_right_id']);
    	$role_rights = array();
    	if($admin_role_rights->count()>0)
    		foreach($admin_role_rights as $right)
    			$role_rights[] = $right->admin_right_id;
    	
    	$this->set(compact('role','rights','role_rights'));
    }
    
}