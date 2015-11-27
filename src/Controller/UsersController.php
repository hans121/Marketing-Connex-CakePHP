<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\NotFoundException;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\Routing\Router;

/**
 * Users Controller
 *
 * @property App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController {
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        	$this->Auth->allow(['logout','forgotpassword','resetpassword','testview','index']);
        	$this->Auth->deny(['add', 'edit', 'suspend','activate']);
    }

    public function login() {
        $this->loadModel('VendorManagers');
        $this->loadModel('Vendors');
        $this->loadModel('Partners');
        $this->loadModel('PartnerManagers');
        $this->layout = 'login';
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                
                if($user['role'] == 'vendor'){
                    $vendor = $this->Vendors->find()
                        ->hydrate(false)
                        ->select(['Vendors.id','Vendors.logo_url', 'Vendors.company_name','Vendors.subscription_type','Vendors.currency','Vendors.financial_quarter_start_month','m.primary_manager','s.name','s.annual_price','s.monthly_price','s.duration'])
                        ->join([
                            'c' => [
                                'table' => 'coupons',
                                'type' => 'LEFT',
                                'conditions' => 'c.id = Vendors.coupon_id',
                            ],
                            'm' => [
                                'table' => 'vendor_managers',
                                'type' => 'INNER',
                                'conditions' => [
                                    'Vendors.id = m.vendor_id'
                                ],
                            ],
                            's' => [
                                'table' => 'subscription_packages',
                                'type' => 'INNER',
                                'conditions' => 'Vendors.subscription_package_id = s.id',
                            ]
                        ],['m.user_id' => 'integer'])
                        ->where(['m.user_id' => $user['id']])->first();
                    foreach($vendor as $key => $val){
                        if($key == 'id'){
                                $user['vendor_id']= $val;
                        }elseif($key == 'm'){
                            foreach($val as $mk => $mv){
                                $user[$mk] =   $mv;
                            }
                        }elseif($key == 's'){
                            foreach($val as $sk => $sv){
                                if($sk == 'name'){
                                    $user['subscription_name']= $sv;
                                }else{
                                    $user[$sk] =   $sv;
                                }
                            }
                        }else{
                            $user[$key] =   $val;
                        }
                        
                    }
                    //print_r($user);exit;
                   // print_r($vendor);exit;
                }elseif($user['role'] == 'partner'){
                    /*$partner = $this->Partners->get([
                            'contain' => ['Vendors', 'PartnerManagers']
                    ]);*/
                    $partner = $this->Partners->find('all')
                            ->hydrate(false)
                            ->select(['v.id','v.logo_url','v.subscription_package_id','v.currency', 'Partners.company_name','v.subscription_type','m.primary_contact','Partners.id','Partners.logo_url','v.language'])
                            ->join([
                                'm' => [
                                    'table' => 'partner_managers',
                                    'type' => 'INNER',
                                    'conditions' => 'm.partner_id = Partners.id',
                                ],
                                'v' => [
                                    'table' => 'vendors',
                                    'type' => 'INNER',
                                    'conditions' => 'Partners.vendor_id = v.id',
                                ]
                            ],['m.user_id' => 'integer'])
                            ->where(['m.user_id' =>  $user['id']])->first();
                    foreach($partner as $key => $val){
                        if($key == 'id'){
                                $user['partner_id']= $val;
                        }elseif($key == 'm'){
                            foreach($val as $mk => $mv){
                                $user[$mk] =   $mv;
                            }
                        }elseif($key == 'v'){
                            foreach($val as $sk => $sv){
                                if($sk == 'id'){
                                    $user['vendor_id']= $sv;
                                }elseif($sk == 'logo_url'){
                                    if(!isset($user['logo_url']) || $user['logo_url'] == '' || $user['logo_url'] == ' '){
                                        $user['logo_url'] = $sv;
                                    }
                                }else{
                                    $user[$sk] =   $sv;
                                }
                            }
                        }else{
                            $user[$key] =   $val;
                        }
                        
                    }
                    
                }
                elseif($user['role'] == 'admin'){
                	$this->loadModel('Admins');
                	$this->loadModel('AdminRoles');
                	$this->loadModel('AdminRights');
                	$this->loadModel('AdminRoleRights');
                	
                	$admin = $this->Admins->find()
                			->select(['ro.role','ri.controller','ri.action'])
                			->join([
                                'ro' => [
                                    'table' => 'admin_roles',
                                    'type' => 'INNER',
                                    'conditions' => 'ro.id = Admins.admin_role_id',
                                ],
                                'rr' => [
                                    'table' => 'admin_role_rights',
                                    'type' => 'INNER',
                                    'conditions' => 'rr.admin_role_id = ro.id',
                                ],
                                'ri' => [
                                    'table' => 'admin_rights',
                                    'type' => 'INNER',
                                    'conditions' => 'ri.id = rr.admin_right_id',
                                ]
                            ],['m.user_id' => 'integer'])
                			->where(['Admins.user_id'=>$user['user_id']])->all();
                	//print_r($admin);die();
                }
                if(!isset($user['logo_url']) || $user['logo_url'] == '' || $user['logo_url'] == ' '){
                    $user['logo_url'] = 'logo-placeholder.png';
                }

                // set loggedin cookie
                $this->Cookie->write('last_session', time());
                $this->Cookie->write('loggedin', true);

               //print_r($user);exit;
                $this->Auth->setUser($user);
               // print_r($this->Auth->loginRedirect);exit;
			    if($this->Auth->user('role') == 'admin'){
                    $this->Auth->loginRedirect = array('controller' => 'admins', 'action' => 'index');
                }elseif($this->Auth->user('role') == 'vendor'){
                    $this->Auth->loginRedirect = array('controller' => 'vendors', 'action' => 'index');
                }else{
                    $this->Auth->loginRedirect = array('controller' => 'partners', 'action' => 'index');
                }
                return $this->redirect($this->Auth->redirectUrl($this->Auth->loginRedirect));
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
     public function forgotpassword() {
         $this->layout = 'login';
         if ($this->request->is('post')) {
            $query = $this->Users->findAllByUsernameAndStatus($this->request->data['username'], 'Y');
            $query->select(['id', 'username', 'email']);
            $validemal  =   false;
            if(isset($query)){
              foreach ($query as $row) {
                if(isset($row->email) && $row->email == $this->request->data['username']) {
                  $validemal = true;
                  $email = $row->email;
                }
              }
            }
            //echo $email;exit;
            if(true == $validemal) {
              $this->Prmsemails->passwordresetlink($email);
              return $this->redirect(['action' => 'login']);
            } else {
              $this->Flash->error(__('Unable to find an active user'));
            }
        }
    }
   
    public function resetpassword($token) {

        $this->loadModel('UserPwordResets');
        $upr = $this->UserPwordResets->find('all')->where(['token' => $token,'status' => 'A','expiry_date >' => time()])->first();

        if(isset($upr)) {
           $usrdet=   $this->Users->find('all')->where(['username' => $upr->username])->first();
          //print_r($usrdet);exit;
           if(isset($usrdet)){
              $rchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
              $pwrd = substr( str_shuffle( $rchars ), 0, 8 );
              $usrdet->password= $pwrd;
              $usrdet->role = $usrdet->role;
              if($this->Users->save($usrdet)) {
                   $site_url=  Router::url('/', true);   
                   $msg    =    __('Your password has been changed for the following account:<br>').$site_url.__(' <br> Username: ').$upr->username.__(' <br> Password: ').$pwrd;

                     $fgemail = new Email('default');
                     $fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
                         $fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
                             ->to($upr->email)
                             ->subject(__('New Password'))
              						   ->emailFormat('both')
                             ->send($msg);
                         $this->Flash->success(__('New log in details have been sent to your email address.'));
                         $upr->status = 'S';
                         $this->UserPwordResets->save($upr);
              }
           }
        } else {
             $this->Flash->error(__('Invalid token'));
        }
        return $this->redirect(['action' => 'login']);
    }
    public function changepassword() {
        if ($this->request->is('put')) {
            if($this->request->data['password'] == $this->request->data['conf_password']) {
                $usrdet=   $this->Users->find('all')->where(['id' => $this->Auth->user('id')])->first();
                if(isset($usrdet)){
                    $usrdet->password= $this->request->data['password'];
                    if($this->Users->save($usrdet)){
                         $this->Flash->success(__('Your password has been reset. Log in using your new password '));
                         return $this->redirect(['action' => 'logout']);
                    }
                }
            }else{
                $this->Flash->error(__('Your password and your retype password must match'));
            }
            
        }
        $this->layout = 'admin';
        $user =   $this->Users->get($this->Auth->user('id'),[ 'contain' => ['VendorManagers']]);
        $this->set('user', $user);
    }
    public function isAuthorized($user) {
        
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }elseif(isset($user['role']) && $user['role'] === 'vendor') {
            return true;
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
	    	$users = $this->Users->find()->contain(['Admins.AdminRoles']);
	    	$users = $this->paginate($users);
	    	$this->set(compact('users'));

    }

    public function add() {
    	 
    }
    
    public function edit($userid) {
    	$this->loadModel('Admins');
    	$this->loadModel('AdminRoles');
    	$this->loadModel('UserRoles');
    	$user = $this->Users->get($userid);
    	$error = false;
    	if ($this->request->is('post') || $this->request->is('put')) {
    		if($this->request->data['password1']==$this->request->data['password2'] && $this->request->data['password1']!='')
    		{
    			$this->request->data['password'] = $this->request->data['password1'];
    			unset($this->request->data['password1']);
    			unset($this->request->data['password2']);
    			$passchangemsg = 'Password was changed.';
    		}
    		else 
    			if($this->request->data['password1']!='')
    			{
    				$this->Flash->error('Password was not changed. Passwords has to match!');
    				$error=true;
    			}
    			
    		if($error==false)
    		{
    			if($this->request->data['role']=='admin')
    			{
	    			$admin = $this->Admins->find()->where(['user_id'=>$userid]);
	    			if($admin->count()>0)
	    			{
	    				$admin = $this->Admins->patchEntity($admin->first(),['admin_role_id'=>$this->request->data['admin_role']]);
	    			}
	    			else
	    			{
	    				$admin = $this->Admins->newEntity(['user_id'=>$userid,'admin_role_id'=>$this->request->data['admin_role']]);
	    			}
	    			$this->Admins->save($admin);
    			}
    			$user = $this->Users->patchEntity($user, $this->request->data);
    			if($passchangemsg)
    				$user->password = $this->request->data['password'];
    			$this->Users->save($user);
    			$this->Flash->success('The new user details was saved.'.($passchangemsg?$passchangemsg:' '.$passchangemsg));
    		}
    	}
    	
    	$admin = $this->Admins->find()->where(['user_id'=>$userid]);
    	if($admin->count()>0)
    		$admin_role = $admin->first()->admin_role_id;
    	else
    		$admin_role = '';    		
    	
    	$admin_roles = $this->AdminRoles->find('list');
    	$user_roles = $this->UserRoles->find();
    	foreach($user_roles as $role)
    	{
    		$roles[$role->role] = $role->role;
    	}
    	$this->set(compact('user','roles','admin_roles','admin_role'));
    }
    
    public function suspend($userid) {
    	$user = $this->Users->get($userid);
    	$user = $this->Users->patchEntity($user, ['status'=>'S']);
    	$this->Users->save($user);
    	$this->Flash->success('The user is now suspended.');
    	return $this->redirect(['controller' => 'Users','action' => 'index']);
    }
    
    public function activate($userid) {
    	$user = $this->Users->get($userid);
    	$user = $this->Users->patchEntity($user, ['status'=>'Y']);
    	$this->Users->save($user);
    	$this->Flash->success('The user is now active.');
    	return $this->redirect(['controller' => 'Users','action' => 'index']);
    }
    
    public function vendorSuspended(){

    }
    public function vendorBlocked(){

    }
    public function vendorInactive(){

    }
    public function testview(){

    }
        
        /**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
    public function myaccount() {

        $id =   $this->Auth->user('id');
        $user = $this->Users->get($id, [
                    'contain' => ['PartnerManagers', 'VendorManagers']
            ]);
        $this->set('user', $user);
        $this->layout = 'admin';
    }
/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
    public function editmyaccount() {

        $id =   $this->Auth->user('id');
        $user = $this->Users->get($id, [
                    'contain' => []
            ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
                $user = $this->Users->patchEntity($user, $this->request->data);
                if ($this->Users->save($user)) {
                        $this->Flash->success('The details have been saved.');
                        return $this->redirect(['action' => 'myaccount']);
                } else {
                        $this->Flash->error('The details could not be saved. Please, try again.');
                }
        }
        $this->set(compact('user'));
        $this->layout = 'admin';
    }
    
}       
