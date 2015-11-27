<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Configure\Engine\PhpConfig;
use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

/**
 * Components this controller uses.
 *
 * Component names should not include the `Component` suffix. Components
 * declared in subclasses will be merged with components declared here.
 *
 * @var array
 */
	 //...
    public $portal_settings =   array();
    public $allowed_resource_file_types=    ['image/jpg','image/jpeg','image/png','image/gif','application/pdf','text/csv','application/vnd.ms-powerpoint.template.macroenabled.12','application/vnd.ms-word.document.macroenabled.12','application/vnd.ms-word.template.macroenabled.12','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/msword','application/vnd.ms-excel','text/x-csv'];
    public $country_list=   array();
    public $layout = 'admin';
    public $components = [
        'Flash',
        'Auth' => [
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Pages',
                'action' => 'display',
                'home'
            ], 'authorize' => array('Controller') // Added this line
        ],
        'Net','Authorizecim','Prmsemails','Filemanagement','Cookie'
    ];
    //public $helpers = ['Tinymce'];
    public function beforeFilter(Event $event) {

        /* Detect Session Timeout and change authError message */
        $last_session = $this->Cookie->read('last_session');
        $loggedin = $this->Cookie->read('loggedin');
        $time_lapsed = (time() - $last_session)/60;
        $session_timeout = Configure::read('Session.timeout');
        if($time_lapsed >= $session_timeout && $loggedin == true)
            $this->Auth->config('authError','Your session has timed out. Please log back in.');

        if($this->request->session()->read('Auth.User.id'))
            $this->Cookie->write('last_session', time());
        else
            $this->Cookie->write('loggedin', false);
        // end

        $this->set('allowed_resource_file_types', $this->allowed_resource_file_types);
        $this->loadModel('Settings');
        $this->loadModel('Countries');
        $this->loadModel('Campaigns');
        $this->loadModel('PartnerViewTracks');
        $this->loadModel('Financialquarters');

        $new_campaigns  =   0;
        $new_approved_bp=   0;
        $new_denied_bp  =   0;
        $new_bp_submit  =   0;
        $new_bp_alert   =   0;
        $sett =  $this->Settings->find('all');
        if(isset($sett) && !empty($sett)){
            foreach($sett as $set){
                $this->portal_settings[$set->settingname]   =   $set->settingvalue;
                
            }
        }
        $this->Prmsemails->portal_settings =     $this->portal_settings;
        $this->Filemanagement->allowed_resource_file_types =     $this->allowed_resource_file_types;
        $this->set('portal_settings', $this->portal_settings);
        $coquery = $this->Countries->find()
                        ->order(['title' => 'ASC']);
        $coquery->select(['title']);
        foreach ($coquery as $row) {
             $this->country_list[$row->title] =   $row->title;
        }
        Configure::write('Config.language', 'eng');
        $this->set('last_visited_page', $this->referer());
        /*
         * section to find campaign notifications
         */
        $prtnrid    =   $this->Auth->user('partner_id');
        if(null !== $prtnrid && $prtnrid > 0 ){
            $partner_id         =   $this->Auth->user('partner_id');
            $new_campaigns      =   $this->__getnewcampaignscount();
            $new_approved_bp    =   $this->__getbpcount('Approved');
            $new_denied_bp      =   $this->__getbpcount('Denied');
            $new_bp_alert       =   $this->__getbpsubmissionalert();
        }
        $this->set('partner_new_campaigns', $new_campaigns);
        $this->set('partner_approved_bp', $new_approved_bp);
        $this->set('partner_denied_bp', $new_denied_bp);
        /*
         * section to find businessplan notifications for vendor
         */
        $vendor_id    =   $this->Auth->user('vendor_id');
        if(null !== $vendor_id && $vendor_id > 0 ){
            $new_bp_submit      =   $this->__getnewbpcount();
            
        }
        $this->set('vendor_sbmt_bp', $new_bp_submit);
        $this->set('new_bp_alert', $new_bp_alert);
    
    }
    /*
     * Function to find no of new campaigns
     */
    function __getnewcampaignscount(){
        $this->loadModel('Campaigns');
        $this->loadModel('PartnerViewTracks');
        $this->loadModel('PartnerCampaigns');
        $this->loadModel('BusinesplanCampaigns');
        $partner_id    =   $this->Auth->user('partner_id');
        $no_new_campaigns   =   0;
        if(null !== $partner_id && $partner_id > 0 ){
            $vendor_id  =   $this->Auth->user('vendor_id');
            /*
             * Find start dat current quarter start date...
             */
            $current_date_stamp   =   strtotime(date('Y-m-d H:i:s'));

            /* Get financian quarters applicable */
            $quarters   =   $this->Financialquarters->find('all')
                                ->where(['vendor_id'=>$this->Auth->user('vendor_id'),'enddate >= '=>strtotime(date('Y-m-d H:i:s'))]);
            $qtr_id_array   = array();
            if(isset($quarters)&& !empty($quarters)){
                foreach ($quarters as $qt){
                    $qtr_id_array[] =   $qt->id;
                }
            }

            $my_c_partner_cmp_id   = array();
            $my_c_partner_cmp    = $this->PartnerCampaigns->find('all')->where(['partner_id' =>$this->Auth->user('partner_id')]);
            if(isset($my_c_partner_cmp) && !empty($my_c_partner_cmp)){
                foreach($my_c_partner_cmp as $pc){
                    $my_c_partner_cmp_id[]  =   $pc->campaign_id;
                }

            }
            $my_c_bpc_cmp    = $this->BusinesplanCampaigns->find('all')->contain(['Businesplans'])->where(['Businesplans.partner_id' =>$this->Auth->user('partner_id')]);
            if(isset($my_c_bpc_cmp) && !empty($my_c_bpc_cmp)){
                foreach($my_c_bpc_cmp as $pc){
                    $my_c_partner_cmp_id[]  =   $pc->campaign_id;
                }

            }
            if(!empty($my_c_partner_cmp_id)){
                
                $cmpgn  =   $this->Campaigns->find()
                                            ->contain(['Financialquarters'])   
                                            //->where(['Campaigns.vendor_id'=>$vendor_id,'Financialquarters.enddate >='=>$current_date_stamp,'Campaigns.id NOT IN' => $my_c_partner_cmp_id]);
                                            ->where(['Campaigns.vendor_id'=>$vendor_id,'Campaigns.financialquarter_id IN '=>$qtr_id_array,'Campaigns.id NOT IN' => $my_c_partner_cmp_id]);

                
            }else{
                $cmpgn  =   $this->Campaigns->find()
                                            ->contain(['Financialquarters'])   
                                            //->where(['Campaigns.vendor_id'=>$vendor_id,'Financialquarters.enddate >='=>$current_date_stamp]);
                                            ->where(['Campaigns.vendor_id'=>$vendor_id,'Campaigns.financialquarter_id IN '=>$qtr_id_array]);
            
            }
            $campaignmaster = array();
            foreach($cmpgn as $cpg){
                $pvt        = $this->PartnerViewTracks->find()
                                                            ->where(['campaign_id'=>$cpg->id,'partner_id'=>$partner_id])
                                                            ->first();
                if(isset($pvt->id) && $pvt->id > 0){
                   
                }else{
                    $campaignmaster[$no_new_campaigns] =   $cpg->id;
                    $no_new_campaigns++;
                }
            }
        }
        return $no_new_campaigns;
    }
    /*
     * function to getn no of new approved/rejected business plans...
     */
    function __getbpcount($status='Approved'){
        $this->loadModel('Businesplans');
        $partner_id    =   $this->Auth->user('partner_id');
        $no_new_bp_approved   =   0;
        if(null !== $partner_id && $partner_id > 0 ){
            $bpln  =   $this->Businesplans->find()  
                                            ->where(['partner_id'=>$partner_id,'status'=>$status]);
            $bplnmaster = array();
            foreach($bpln as $bpn){
                $pvt        = $this->PartnerViewTracks->find()
                                                            ->where(['businesplan_id'=>$bpn->id,'partner_id'=>$partner_id])
                                                            ->first();
                if(isset($pvt->id) && $pvt->id > 0){
                   
                }else{
                    $bplnmaster[$no_new_bp_approved] =   $bpn->id;
                    $no_new_bp_approved++;
                }
            }
        }
        return $no_new_bp_approved; 
    }
    /*
     * function to getn no of new business plans submitted...
     */
    function __getnewbpcount($status='Submit'){
        $this->loadModel('Businesplans');
        $this->loadModel('VendorViewTracks');
        $vendor_id    =   $this->Auth->user('vendor_id');
        $no_new_bp_sbmt   =   0;
        if(null !== $vendor_id && $vendor_id > 0 ){
            $bpln  =   $this->Businesplans->find()  
                                            ->where(['vendor_id'=>$vendor_id,'status'=>$status]);
            $bplnmaster = array();
            foreach($bpln as $bpn){
                $pvt        = $this->VendorViewTracks->find()
                                                            ->where(['businesplan_id'=>$bpn->id,'vendor_id'=>$vendor_id])
                                                            ->first();
                if(isset($pvt->id) && $pvt->id > 0){
                   
                }else{
                    $bplnmaster[$no_new_bp_sbmt] =   $bpn->id;
                    $no_new_bp_sbmt++;
                }
            }
        }
        return $no_new_bp_sbmt; 
    }
    /*
     * Function to find business plan submission due
     */
    function __getbpsubmissionalert(){
        $this->loadModel('Businesplans');
        $no_bp          =   0;
        $partner_id     =   $this->Auth->user('partner_id');
        $vendor_id      =   $this->Auth->user('vendor_id');
        $finstartdate   =   date('Y-m-d H:i:s',strtotime(date('Y-m-d',strtotime('+31 days',time()))));
        $finenddate     =   date('Y-m-d H:i:s',strtotime(date('Y-m-d',time())));
        $fqtrs          =   $this->Financialquarters->find()
                                                    ->where(['startdate <'=>$finstartdate,'enddate >'=>$finenddate,'vendor_id'=>$vendor_id]);
        foreach($fqtrs as $fq):
            $bpdet  =   $this->Businesplans->find()
                                            ->where(['partner_id'=>$partner_id ,'financialquarter_id'=> $fq->id,'status IN'=>['Submit','Approved']])
                                            ->first();
            if(isset($bpdet->id) && $bpdet->id >0){
                // Partner already submitted a business plan
            }else{
               $no_bp++;
            }
            
        endforeach;
        return $no_bp;
    }
}
