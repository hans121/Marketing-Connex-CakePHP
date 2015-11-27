<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Resources Controller
 *
 * @property App\Model\Table\ResourcesTable $Resources
 */
class HelpPagesController extends AppController {

    private $user;

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->loadModel('PartnerGroups');
        $this->loadModel('HelpMenus');
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
            
        }elseif(isset($user['role']) && $user['role'] === 'admin' || $user['role'] === 'superadmin') {            
            $this->user = $user; // store $user to class variable for easy access
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
       $menu = $this->HelpMenus->find()->where(['parent_id'=>0])->first(); //parent_id is default for main menu
        if($menu)
            $menuid = $menu->id;
        else
        {
            // if no default menu then create default menu
            $menuid = $this->createdefaultmenu();
        }
		$this->navigate($menuid);
				
	}

/**
 * Navigate method
 *
 * @return void
 */
    public function navigate($menuid=0) {
        $pages = $this->paginate($this->HelpPages->find()->where(['HelpPages.menu_id'=>$menuid]));
        
        if($menuid!=0)
            $parentmenu = $this->HelpMenus->get($menuid);

        $menus = $this->HelpMenus
                    ->find('all')
                    ->where(['parent_id'=>$menuid])
                    ->order($this->request->params['paging']['HelpPages']['sort']?[str_replace('HelpPages.','',$this->request->params['paging']['HelpPages']['sort'])=>$this->request->params['paging']['HelpPages']['direction']]:['name'=>'asc']);

        $this->set(compact('pages','menus','parentmenu'));
    }

/**
 * Add method
 *
 * @param int $menuid
 * @return void
 */

    public function add($menuid=NULL) {
        if ($this->request->is('post')) {
            $this->request->data['user_id'] = $this->user['id'];
            $this->request->data['modified_by'] = $this->user['id'];
            $page = $this->HelpPages->newEntity($this->request->data);
            if ($this->HelpPages->save($page))
                $this->Flash->success('The page has been saved.');
            else
                $this->Flash->error('Sorry, the page could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');

            return $this->redirect(['action' => 'navigate',$this->request->data['menu_id']]);
        }
        else
            $page = $this->HelpPages->newEntity([]);

        $sourceMenus = $this->HelpMenus   ->find('all')
                                            ->where(['user_id'=>$this->user['id'],'status'=>'Y'])
                                            ->order(['parent_id' => 'Asc']);
        $menus= array();
        foreach($sourceMenus as $sm){
            $menus[$sm->id] = $sm->parent_id==0 ? 'Main Menu' : $sm->name;
        }

        $this->set(compact('menuid','page','menus'));
    }

/**
 * Edit method
 *
 * @param int $menuid, int $pageid
 * @return void
 */

    public function edit($menuid,$pageid) {
        $page = $this->HelpPages->get($pageid);
        if ($this->request->is(['post','patch','put'])) {
            $this->request->data['modified_by'] = $this->user['id'];
            $page = $this->HelpPages->patchEntity($page,$this->request->data);
            if ($this->HelpPages->save($page))
                $this->Flash->success('The page has been saved.');
            else
                $this->Flash->error('Sorry, the page could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');

            return $this->redirect(['action' => 'navigate',$this->request->data['menu_id']]);
        }

        $this->set(compact('pageid','menuid','page'));
    }

/**
 * Delete method
 *
 * @param int $menuid, int $pageid
 * @return void
 */

    public function delete($menuid,$pageid) {
        $page = $this->HelpPages->get($pageid);
        if ($this->HelpPages->delete($page)) {
            $this->Flash->success('The page has been deleted.');
        } else {
            $this->Flash->error('Sorry, the page could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
        }
        return $this->redirect(['action' => 'navigate',$menuid]);
    }

/**
 * BulkDelete method
 *
 * @return void
 */
    public function bulkdelete() {

        $ids = $this->request->data['ids'];
        $ids = explode(',',$ids);
        $error = 0;
        foreach($ids as $id)
        {

            $page = $this->HelpPages->get($id);
            if ($this->HelpPages->delete($page)) {
               // do nothing
            } else {
               $error++;
            }
        }

        if($error==0)
            die('SUCCESS');
        else
            die($error);
    }

/**
 * View method
 *
 * @return void
 */
    public function view($pageid) {
        $page = $this->HelpPages->get($pageid);
        $this->set(compact('page'));
    }        

/**
 * Search method
 *
 * @return void
 */
    public function search() {
        $keyword = $this->request->data['keyword'];
        $keys = explode(' ', $keyword);
        $conds = Array();
        $conds[] = ['title LIKE'=>'%'.$keyword.'%'];
        foreach($keys as $key)
        {
            $conds[] = ['title LIKE'=>'%'.$key.'%'];
        }
        $pages = $this->paginate($this->HelpPages->find()->where( [ 'OR' => $conds ] ));
 
        $this->set(compact('pages','keyword'));
    }    

///////////////////////
// PRIVATE FUNCTIONS //
///////////////////////

/**
 * createdefaultmenu method
 *
 * @return menuid
 */

    private function createdefaultmenu() {
        $menu = [ 'parent_id'=>0, 'user_id'=>$this->user['id'],'name'=>'Main Menu','description'=>'Main Menu', 'modified_by'=>$this->user['id'] ];
        $default_menu = $this->HelpMenus->newEntity($menu);
        $this->HelpMenus->save($default_menu);
        return $default_menu->id;
    }    
}