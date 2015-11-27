<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Resources Controller
 *
 * @property App\Model\Table\ResourcesTable $Resources
 */
class HelpController extends AppController {

    private $user;

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->loadModel('HelpMenus');
        $this->loadModel('HelpPages');
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
            
        }elseif(isset($user['role']) && ($user['role'] === 'partner' || $user['role'] === 'vendor')) {            
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
        $menu = $this->HelpMenus->find()->where(['parent_id'=>0,'status'=>'Y'])->first(); //parent_id is default for main menu
        if($menu)
            $menuid = $menu->id;
        else
        {
            // if no default menu then show message and redirect to home
            $this->Flash->error('No Help Pages Available For Browsing!');
            return $this->redirect(['Controller'=>'Users','action' => 'login']);
        }
		$this->navigate($menuid);
	}
	

/**
 * Navigate method
 *
 * @return void
 */
    public function navigate($menuid=0) {
        $pages = $this->HelpPages->find()->where(['HelpPages.menu_id'=>$menuid,'HelpPages.status'=>'Y']);
        $pagecopy = $this->HelpPages->find()->where(['HelpPages.menu_id'=>$menuid,'HelpPages.status'=>'Y']);
        if($menuid!=0)
            $parentmenu = $this->HelpMenus->get($menuid);

        $menus = $this->HelpMenus
                    ->find('all')
                    ->where(['parent_id'=>$menuid,'status'=>'Y'])
                    ->order($this->request->params['paging']['HelpPages']['sort']?[str_replace('HelpPages.','',$this->request->params['paging']['HelpPages']['sort'])=>$this->request->params['paging']['HelpPages']['direction']]:['name'=>'asc']);

        $firstpage = $pagecopy->first();

        $crumbs = $this->getpathcrumb($menuid);

        $user = $this->user;

        $this->set(compact('pages','menus','parentmenu','firstpage','crumbs','menuid','user'));
    }

/**
 * View method
 *
 * @return void
 */
    public function view($pageid) {
        $firstpage = $this->HelpPages->get($pageid);

        $menuid = $firstpage->menu_id;

        $parentmenu = $this->HelpMenus->get($menuid);

        $pages = $this->HelpPages->find()->where(['HelpPages.menu_id'=>$menuid,'HelpPages.status'=>'Y']);

        $menus = $this->HelpMenus
                    ->find('all')
                    ->where(['parent_id'=>$menuid,'status'=>'Y'])
                    ->order($this->request->params['paging']['HelpPages']['sort']?[str_replace('HelpPages.','',$this->request->params['paging']['HelpPages']['sort'])=>$this->request->params['paging']['HelpPages']['direction']]:['name'=>'asc']);

        $crumbs = $this->getpathcrumb($menuid);

        $user = $this->user;

        $this->set(compact('pages','menus','parentmenu','firstpage','crumbs','menuid','user'));
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
        $pages = $this->paginate($this->HelpPages->find()->where( [ 'status'=>'Y','OR' => $conds ] ));

        $user = $this->user;
 
        $this->set(compact('pages','keyword','user'));
    }

///////////////////////
// PRIVATE FUNCTIONS //
///////////////////////


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
            $menu = $this->HelpMenus->get($menuid);
            $root = $menu->parent_id===0;
            $menuid = $menu->parent_id;

            if($menuid!==0)
            $crumbs[] = ['id'=>$menu->id,'name'=>$menu->name];
        }

        return $crumbs;
    }    

}