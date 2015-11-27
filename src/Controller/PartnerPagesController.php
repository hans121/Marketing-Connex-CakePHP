<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Resources Controller
 *
 * @property App\Model\Table\ResourcesTable $Resources
 */
class PartnerPagesController extends AppController {

    private $user;

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->loadModel('VendorMenus');
        $this->loadModel('VendorPages');
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
            
        }elseif(isset($user['role']) && $user['role'] === 'partner') {            
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
        $menu = $this->VendorMenus->find()->where(['vendor_id'=>$this->user['vendor_id'],'parent_id'=>0])->first(); //parent_id is default for main menu
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
        $pages = $this->VendorPages->find()->contain(['Vendors'])->where(['VendorPages.menu_id'=>$menuid,'VendorPages.status'=>'Y']);
        $pagecopy = $this->VendorPages->find()->contain(['Vendors'])->where(['VendorPages.menu_id'=>$menuid,'VendorPages.status'=>'Y']);
        if($menuid!=0)
            $parentmenu = $this->VendorMenus->get($menuid);

        $menus = $this->VendorMenus
                    ->find('all')
                    ->where(['parent_id'=>$menuid,'vendor_id'=>$this->user['vendor_id'],'status'=>'Y'])
                    ->order($this->request->params['paging']['VendorPages']['sort']?[str_replace('VendorPages.','',$this->request->params['paging']['VendorPages']['sort'])=>$this->request->params['paging']['VendorPages']['direction']]:['name'=>'asc']);

        $firstpage = $pagecopy->first();

        $crumbs = $this->getpathcrumb($menuid);

        $this->set(compact('pages','menus','parentmenu','firstpage','crumbs','menuid'));
    }

/**
 * View method
 *
 * @return void
 */
    public function view($pageid) {
        $firstpage = $this->VendorPages->get($pageid);

        $menuid = $firstpage->menu_id;

        $parentmenu = $this->VendorMenus->get($menuid);

        $pages = $this->VendorPages->find()->contain(['Vendors'])->where(['VendorPages.menu_id'=>$menuid,'VendorPages.status'=>'Y']);

        $menus = $this->VendorMenus
                    ->find('all')
                    ->where(['parent_id'=>$menuid,'vendor_id'=>$this->user['vendor_id'],'status'=>'Y'])
                    ->order($this->request->params['paging']['VendorPages']['sort']?[str_replace('VendorPages.','',$this->request->params['paging']['VendorPages']['sort'])=>$this->request->params['paging']['VendorPages']['direction']]:['name'=>'asc']);

        $crumbs = $this->getpathcrumb($menuid);

        $this->set(compact('pages','menus','parentmenu','firstpage','crumbs','menuid'));
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
        $pages = $this->paginate($this->VendorPages->find()->contain(['Vendors'])->where( [ 'vendor_id'=>$this->user['vendor_id'],'OR' => $conds ] ));
 
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
        $menu = [ 'parent_id'=>0, 'vendor_id'=>$this->user['vendor_id'],'user_id'=>$this->user['id'],'name'=>$this->user['username'],'description'=>'Main Menu for user '.$this->user['username'] ];
        $default_menu = $this->VendorMenus->newEntity($menu);
        $this->VendorMenus->save($default_menu);
        return $default_menu->id;
    }    

/**
 * getpathcrumb method
 *
 * @return menuid
 */

    private function getpathcrumb($menuid) {
        $crumbs = Array();
        $root = $menuid===0;
        while($root===false)
        {            
            $menu = $this->VendorMenus->get($menuid);
            $root = $menu->parent_id===0;
            $menuid = $menu->parent_id;

            if($menuid!==0)
            $crumbs[] = ['id'=>$menu->id,'name'=>$menu->name];
        }

        return $crumbs;
    }    

}