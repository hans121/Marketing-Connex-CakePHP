<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Email\Email;
/**
 * Vendors Controller
 *
 * @property App\Model\Table\VendorsTable $Vendors
 */
class CimtestsController extends AppController {
    public $components = ['Imagecreator','Authorizecim'];
    public function beforeFilter(Event $event) {
    parent::beforeFilter($event);
        // Allow users to register and logout.
        $this->Auth->allow(['buypackage','primarycontact','checkout','payment']);
        $this->loadModel('VendorManagers');
        $this->loadModel('Users');
        $this->loadModel('Partners');
        $this->loadModel('PartnerManagers');
    }
    public function isAuthorized($user) {
        
            return true;
       
    }
/**
 * Index method
 *
 * @return void
 */
	public function index() {
		$this->set('vendors', $this->paginate($this->Vendors));
	}

    public function createProfile(){
        $data['vendor_id']  =   '10009';
        $data["email"]  =   'jipson@yahoo.co.in';
        $data['firstName'] =   'Aidan';
        $data['lastName'] =   'J Thomas 2';
        $data['company'] =   'SIC';
        $data['address'] =   '14 Albany House';
        $data['city'] =   'Horsham';
        $data['state'] =   'West Sussex';
        $data['zip'] =   'RH12 1QN';
        $data['country']=   'United Kingdom';
        $data['cardNumber']='4111111111111111';
        $data['expirationDate']='2018-10';
        $data['cardCode']   =   '123';
        $ret    =   $this->Authorizecim->createProfile($data);
        print_r($ret);
        /*
         * Array ( [customerProfileId] => 28372382 [resultCode] => Ok [code] => I00001 [text] => Successful. [customerPaymentProfileId] => 25779173 ) 
         */
        exit;
    }
    public function maketransaction(){
        $data["amount"] =   '10.00';
        $data["customerProfileId"] = '28372382';
        $data["customerPaymentProfileId"]   =   '25779173';
        $data["invoice_number"] =   '001';
        $data['invoide_description']    =   'test';
        $ret    =   $this->Authorizecim->createTransaction($data);
        print_r($ret);
        exit;
        /*
         * Array ( [customerProfileId] => [resultCode] => Ok [code] => I00001 [text] => Successful. [customerPaymentProfileId] => [directResponse] => 1,1,1,This transaction has been approved.,U2WZYG,Y,2218042584,001,test,10.00,CC,auth_capture,10007,Aidan,J Thomas 2,SIC,14 Albany House,Horsham,West Sussex,RH12 1QN,United Kingdom,,,jipson@yahoo.co.in,,,,,,,,,,,,,,2C07ADB2D3D0DF46BC7EC0A5D523E3EF,,2,,,,,,,,,,,XXXX1111,Visa,,,,,,,,,,,,,,,, ) 
         */
    }
    public function mandrilltest(){
        echo "hi";
        exit;
    }
}
