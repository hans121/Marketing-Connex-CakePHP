<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Folders Controller
 *
 * @property App\Model\Table\FoldersTable $Folders
 */
class VendorMenusController extends AppController {
    
    private $user;

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
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
            
        }elseif(isset($user['role']) && $user['role'] === 'vendor') {            
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
		return void;
	}

/**
 * Add method
 *
 * @param int $parent_id
 * @return void
 */

    public function add($parent_id) {
        if ($this->request->is('post')) {
            $this->request->data['vendor_id'] = $this->user['vendor_id'];
            $this->request->data['user_id'] = $this->user['id'];
            $menu = $this->VendorMenus->newEntity($this->request->data);
            if ($this->VendorMenus->save($menu))
                $this->Flash->success('The menu has been saved.');
            else
                $this->Flash->error('Sorry, the menu could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');

            return $this->redirect(['controller' => 'VendorPages','action' => 'navigate',$this->request->data['parent_id']]);
        }
        else
            $menu = $this->VendorMenus->newEntity([]);

        $sourceMenus = $this->VendorMenus   ->find('all')
                                            ->where(['vendor_id'=>$this->user['vendor_id'],'status'=>'Y'])
                                            ->order(['parent_id' => 'Asc']);
                                            
        $menus= array();
        foreach($sourceMenus as $sm){
            $menus[$sm->id] = $sm->parent_id==0 ? 'Main Menu' : $sm->name;
        }


        $this->set(compact('parent_id','menu','menus'));
    }

/**
 * Edit method
 *
 * @param int $parent_id, int $menu_id
 * @return void
 */

    public function edit($parent_id = 0, $menu_id) {
        $menu = $this->VendorMenus->get($menu_id);
        if ($this->request->is(['post','patch','put'])) {
            $this->request->data['vendor_id'] = $this->user['vendor_id'];
            $this->request->data['user_id'] = $this->user['id'];
            $menu = $this->VendorMenus->patchEntity($menu, $this->request->data);
            if ($this->VendorMenus->save($menu))
                $this->Flash->success('The menu has been saved.');
            else
                $this->Flash->error('Sorry, the menu could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');

            return $this->redirect(['controller' => 'VendorPages','action' => 'navigate',$this->request->data['parent_id']]);
        }

        $sourceMenus = $this->VendorMenus   ->find('all')
                                            ->where(['vendor_id'=>$this->user['vendor_id'],'status'=>'Y'])
                                            ->order(['parent_id' => 'Asc']);

        $menus= array();
        foreach($sourceMenus as $sm){
            $menus[$sm->id] = $sm->parent_id==0 ? 'Main Menu' : $sm->name;
        }


        $this->set(compact('parent_id','menu_id','menu','menus'));
    }    

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($parent_id = 0,$menu_id) {
        if (isset($menu_id)) {
            $menu = $this->VendorMenus->get($menu_id, ['contain'=>['VendorPages']]);
            $submenus = $this->VendorMenus->find()->where(['parent_id'=>$menu_id]);
            if(count($menu->vendor_pages)<=0 && $submenus->count()<=0) {
                $entity = $this->VendorMenus->get($menu_id);
                if($this->VendorMenus->delete($entity))
                {
                    $this->Flash->success('The menu has been deleted.');                     
                }
            }
            else
                $this->Flash->error('The menu could not be deleted. Folder not empty.');
        }
        return $this->redirect(['controller'=>'VendorPages','action'=>'navigate',$parent_id]);
	}

/**
 * rename method
 *
 * @return void
 */
    public function rename() {
        if ($this->request->is('post')) {
            $menu = $this->VendorMenus->get($this->request->data['id'], ['contain'=>['VendorPages']]);            
            $menu = $this->VendorMenus->patchEntity($menu,$this->request->data);
            if($this->VendorMenus->save( $menu ))
            {
                die('SUCCESS');
            }
            die('ERROR');
        }
        die('INVALID');
    }

}