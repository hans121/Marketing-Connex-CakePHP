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
class UserRolesController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        if($this->Auth->user('role') == 'superadmin'){
        	$this->Auth->allow(['index','add', 'edit', 'delete']);
        }
    }
    
    public function index() {
    	$user_roles = $this->UserRoles->find();
    	$user_roles = $this->paginate($user_roles);
    	$this->set(compact('user_roles'));
    }
    
    public function add() {
    	
    }
    
    public function edit() {
    	
    }
    
    public function delete() {
    	
    }
    
}