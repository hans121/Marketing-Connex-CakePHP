<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Error;
use Cake\Utility\Inflector;
use Cake\Event\Event;
use Mandrill;
use JTEmail;
use Cake\Routing\Router;
/**
 * Systemjobs Controller
 *
 * @property App\Model\Table\SystemjobsTable $Systemjobs
 */
class SystemjobsController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        // Allow free access.
        $this->Auth->allow(['checkexpiredleads','updateFinanceQuarters','subscriptionStatusUpdate','updateVendorStatus','updateVendorBillDate','sendSuspensionReminder','removeSuspendedAccounts','index','bpsubmissionreminders','mandrilltest','removexpiredcampaigns','updatemandrillstatus','sendscheduledemails','campaignfollowup']);
        $this->loadModel('Vendors');
        $this->loadModel('VendorPayments');
        $this->loadModel('Users');
        $this->loadModel('Invoices');
        $this->loadModel('Settings');
        $this->loadModel('Financialquarters');
        $this->loadModel('Partners');
        $this->loadModel('Businesplans');
        $this->loadModel('LandingPages');
        $this->loadModel('CampaignPartnerMailinglists');
        $this->loadModel('PartnerCampaigns');
        $this->loadModel('PartnerCampaignEmailSettings');
        $this->loadModel('PartnerManager');
        $this->loadModel('VendorManager');
        $this->loadModel('Campaigns');
        $this->loadModel('Leads');
    }
    public function isAuthorized($user) {

        // Default allow
        return true;
    }
     /*
     * This function need to sent as cron job for every 15 minutes..
     */
    public function sendscheduledemails(){
        $frmdt      =   date('Y-m-d H:i:s',strtotime( '-15 minutes'));
        $todt       =   date('Y-m-d H:i:s',strtotime( '+1 minute'));//echo $frmdt.'====='.$todt;exit;
        $sendcamps  = $this->PartnerCampaignEmailSettings->find('all')->where(['PartnerCampaignEmailSettings.status'=>'schedule','PartnerCampaignEmailSettings.sent_date >' => $frmdt,'PartnerCampaignEmailSettings.sent_date <'=> $todt]);
        //print_r($sendcamps) ;exit;
        if(isset($sendcamps)){
            foreach($sendcamps as $stc){
                //print_r($stc);exit;
                if($this->sentCampaignmail($stc->partner_campaign_id)){
                    $Jquery = $this->PartnerCampaignEmailSettings->query();
                    $Jquery->update()
                        ->set(['status' =>  'sent','modified_on'=>date('Y-m-d H:i:s')])
                        ->where(['partner_campaign_id' =>  $stc->partner_campaign_id])
                        ->execute();
                }
            }
        }
        echo __('Scheduled email has been sent');
        exit;        
    }
    /*
     * This function need to be executed daily, so it will call all the system jobs need to execute once in a day....
     */
    public function index(){
    	$this->checkexpiredleads();
	    $this->subscriptionStatusUpdate();
        $this->notifyExpiryDates();
        $this->updateVendorStatus();
        $this->updateVendorBillDate();
        $this->sendSuspensionReminder();
        $this->removeSuspendedAccounts();
        $this->updateFinanceQuarters();
        $this->bpsubmissionreminders();
        $this->removexpiredcampaigns();
        $this->updatemandrillstatus();
        $this->campaignfollowup();
        echo __('All system jobs has been executed successfully');
        exit;
    }

    public function checkexpiredleads(){
    	$leads = $this->Leads->find()->where(['expire_on = NOW() and responsed=0']);
    	
    	$leads = $this->Leads->query();
    	$leads->update()
    	->set(['lead_status' => 'inactive'])
    	->where(['expire_on = NOW() and responsed=0'])
    	->execute();
    	
    	return true;
    }
    
    public function campaignfollowup(){
        // Get campaigns that has not been sent out by a partner 30days before start of the next quarter.
        $campaigns = $this->Campaigns   ->find()
                                        ->contain(['Financialquarters','CampaignPartnerMailinglists'=>function ($q) {
                                                    return $q->find('all')->where(['mandrillemailid IS NOT NULL']);
                                                 }])
                                        ->where(['Financialquarters.startdate <= NOW()','Financialquarters.enddate > (NOW() + INTERVAL 30 DAY)']);
        if($campaigns)
        {
            foreach($campaigns as $campaign)
            {
                 if(count($campaign->campaign_partner_mailinglists)==0)
                 {  
                    // Have not sent campaign email to anyone yet. Notify the partners.
                    $this->Prmsemails->unsentCampaignEmail($campaign->id);
                 }
            }
        }

        return true;
    }
    
    public function notifyExpiryDates(){
		print_r($this->Net->getSubscriptionList());
        return true;
    }
    
    public function subscriptionStatusUpdate(){
        
        $vPayments =    $this->VendorPayments->find('all')
                            ->hydrate(false);
        foreach($vPayments as $vpt){
            
            if($vstatus=$this->Net->getSubscriptionStatus($vpt['subscriptionid'])){
                if($vstatus['resultCode'] == 'Ok'){
                    //$vstatus['status']
                    $VPSquery = $this->VendorPayments->query();
                    $VPSquery->update()
                                  ->set(['status' => $vstatus['status']])
                                  ->where(['subscriptionid' =>  $vpt['subscriptionid']])
                                  ->execute();
                }
                
            }
        }
        return true;
    }
    public function updateVendorStatus(){
        /*
         * Update all active vendors subcriptions...
         */
       
        $vPayments =    $this->VendorPayments->find('all')
                            ->hydrate(false)
                            ->where(['status' => 'active']);
        foreach($vPayments as $vpt){
            if($vendor = $this->Vendors->find('all')
                    ->hydrate(false)
                    ->where(['id' => $vpt['vendor_id']])
                    ->first()){
                if($vendor['status'] == 'S'){
                    $this->changeVendorStatus($vendor['id'],'Y');
                    
                }
                      
            }
            
    	}

    	$vAbandoned =    $this->Vendors->find('all')
                            ->hydrate(false)
                            ->where(['status' => 'P']);                            
                       
        foreach($vAbandoned as $vpt){

	        if (strtotime($vpt['created_on']) > strtotime('1 day ago')) {
		    	echo $vpt['company_name'] . "has signed up in the last 24 hours and not completed checkout.<br/>";
	        
	        
				if($vendormans = $this->Vendors->find()
				    ->hydrate(false)
				    ->select(['u.email'])
				    ->join([
				        'm' => [
				            'table' => 'vendor_managers',
				            'type' => 'INNER',
				            'conditions' => [
				                'm.primary_manager' => 'Y',
				                'Vendors.id = m.vendor_id'
				            ],
				        ],
				        'u' => [
				            'table' => 'users',
				            'type' => 'INNER',
				            'conditions' => 'u.id = m.user_id',
				        ],
				        
				    ],['m.primary_manager' => 'string','u.id' => 'integer','m.user_id' => 'integer'])
				    ->where(['Vendors.id' => $vpt[id]])->first()
				 ) {
					//Send Vendor ID and EMAIL with link to Checkout:  eg: 'http://prms.panovus.com.sic.com/vendors/checkout/'.$vpt[id] 
					
	                $this->Prmsemails->abandonedVendorManager($vpt[id]);
	
				 } else {
					//EMAIL with link to vendor manager sign-up:  eg: http://prms.panovus.com.sic.com/vendors/primarycontact/43 
					$this->Prmsemails->abandonedVendorSignup($vpt[id]);
			     };
	        
	        }
	        
    	}
    	
        
        //
        
        /*
         * Section to find and suspend subscription inactive vendors....
         */
        $vInactivePayments =    $this->VendorPayments->find('all')
                            ->hydrate(false)
                            ->where(['status !=' => 'active']);
       foreach($vInactivePayments as $ipt){
          // print_r($ipt);
           /*
            * Section to check is there any other active subscription exists for thevendor
            */
           if($dup_sub =  $this->VendorPayments->find('all')
                            ->hydrate(false)
                            ->where(['status' => 'active','vendor_id' => $ipt['vendor_id']])
                            ->first()){
               //print_r($dup_sub);
           }else{
               
               /*
                * Section to suspend vendor and all his associate logins to the system if he is active..
                */
               if($vendor = $this->Vendors->find('all')
                        ->hydrate(false)
                        ->where(['id' => $ipt['vendor_id']])
                        ->first()){
                    if($vendor['status'] == 'Y'){
                        $this->changeVendorStatus($vendor['id'],'S');

                    }

                }
               
           }
           
           /**/
       }
        
        return true;
    }
    /*
     * Function to update billed dates...
     */

    public function updateVendorBillDate(){
        /*
         * This function will check the current billl end date of all active vendors.
         * If the current bill end date is less than current date, then the last_billed date shouls update using current_bill_end _date
         * The current_bill end_date will be updated using the newly calculated value based on subscription type.
         * The system will add an invoice table entry also
         */
        $vendors    = $this->Vendors->find('all')
                    ->hydrate(false)
                    ->contain(['SubscriptionPackages', 'Coupons', 'VendorManagers'=>function ($q) {
                                return $q->where(['VendorManagers.primary_manager'=>'Y','VendorManagers.status'=>'Y']);
                            }])
                    ->where(['Vendors.status' => 'Y','Vendors.current_bill_end_date <' => time()]);//print_r($vendors);exit;
        foreach($vendors as $vnd){
            //print_r($vnd);exit;
            $new_last_billed_date   =   strtotime($vnd['current_bill_end_date']);
            if($vnd['subscription_type'] == 'monthly'){
                $new_current_bill_end_date = strtotime('+1 month',strtotime($vnd['current_bill_end_date']));
                $total_price    =   $vnd['subscription_package']['monthly_price'];
            }else{
                $new_current_bill_end_date = strtotime('+1 year',strtotime($vnd['current_bill_end_date']));
                $total_price    =   $vnd['subscription_package']['annual_price'];
            }
            if(isset($vnd['coupon']['discount'])){
                if($vnd['coupon']['type'] == 'Perc'){
                    $discount_amount    =   $total_price * ($vnd['coupon']['discount'] /100);
                }else{
                    $discount_amount    =   $vnd['coupon']['discount'];
                }
            }else{
                $discount_amount    =   0;
            }
            
            /* Section to insert invoice table....
             * 
             */
           $inv_arr['title']            =   $vnd['subscription_package']['name'];
           $inv_arr['description']      =   $vnd['subscription_package']['name'].__(' subscription payment by '). $vnd['company_name'];
           $inv_arr['invoice_number']   =   $this->portal_settings['invoice_prefix'].($this->portal_settings['last_invoice_id']+1). $this->portal_settings['invoice_suffix'];
           $inv_arr['vendor_id']        =   $vnd['id'];
           $inv_arr['invoice_date']     =   $new_last_billed_date;
           $inv_arr['amount']           =   round(($total_price - $discount_amount) ,2);
           $inv_arr['discount']         =   round($discount_amount,2);
           $inv_arr['currency']         =   'USD';
           $inv_arr['status']           =   'paid';
           $invc = $this->Invoices->newEntity($inv_arr);
           $inv_result  =   $this->Invoices->save($invc);
           $last_invoice_id =   $inv_result->id;

           // Send Invoice to vendor for recurring billing
           if($vnd['vendor_managers'])
            $this->Prmsemails->newInvoicemail(['User'=>['id'=>$vnd['vendor_managers'][0]['user_id']]],['id'=>$last_invoice_id]);

            /*
            * Section to upfdate Last invoice id on settings table...
            */

           $STquery = $this->Settings->query();
           $STquery->update()
                ->set(['settingvalue' => $last_invoice_id])
                ->where(['settingname' =>  'last_invoice_id'])
                ->execute();
           /*
            * Section to update vendors table....
            */
           $VQuery  =   $this->Vendors->query();
           $VQuery->update()
                ->set(['current_bill_end_date' => $new_current_bill_end_date,'last_billed_date' => $new_last_billed_date])
                ->where(['id' =>  $vnd['id']])
                ->execute();
        } 
        return true;
    }
     /*
     * Function to send notification emails to suspended accounts.......
     * The intervals will be read from settings table...
     * There will be 3 notifications to each vendor.....
     */
    public function sendSuspensionReminder(){
        /*
         * Find the vendors for first warning
         */
        $current_day_stamp =   strtotime(date('Y-m-d'));
        $first_reminder_stamp   =   $this->portal_settings['removal_first_warning']*60*60*24;
        $second_reminder_stamp   =   $this->portal_settings['removal_second_warning']*60*60*24;
        $final_reminder_stamp   =   $this->portal_settings['removal_final_warning']*60*60*24;
        $vendors    = $this->Vendors->find('all')
                    ->hydrate(false)
                    ->contain(['VendorManagers.Users'])
                    ->where(['Vendors.status' => 'S']);
        foreach($vendors as $vndr){
            $status_change_stamp =strtotime(date('Y-m-d',strtotime($vndr['status_change_date'])));
            if($current_day_stamp == ($status_change_stamp + $first_reminder_stamp)){
                /*
                 * Section to send first warning 
                 */
                $this->Prmsemails->accountSuspensionreminder($vndr['id'],'first');
            }
            if($current_day_stamp == ($status_change_stamp + $second_reminder_stamp)){
                /*
                 * Section to send second warning 
                 */
                $this->Prmsemails->accountSuspensionreminder($vndr['id'],'second');
            }
            if($current_day_stamp == ($status_change_stamp + $final_reminder_stamp)){
                /*
                 * Section to send final warning 
                 */
                $this->Prmsemails->accountSuspensionreminder($vndr['id'],'final');
            }
            
        }
      return true;
    }
    
    /*
     * Function to remove suspended accounts after the fixed period
     * The no of days will be read from settings table.....
     */
    public function removeSuspendedAccounts(){
        /*
         * 
         */
        $current_day_stamp =   strtotime(date('Y-m-d'));
        $removal_interval_days_stamp   =   $this->portal_settings['removal_interval_days']*60*60*24;
        $vendors    = $this->Vendors->find('all')
                    ->hydrate(false)
                    ->contain(['VendorManagers.Users'])
                    ->where(['Vendors.status' => 'S']);
        foreach($vendors as $vndr){
            
            $status_change_stamp =strtotime(date('Y-m-d',strtotime($vndr['status_change_date'])));
            if($current_day_stamp >= ($status_change_stamp + $removal_interval_days_stamp)){
                $this->__deleteVendor($vndr['id']);
                
            }
        }
        return true;
    }
    /*
     * Function to update finance quarters of active vendors
     */
    public function updateFinanceQuarters(){
        $vendors    = $this->Vendors->find('all')
                ->hydrate(false)
                ->contain(['Financialquarters'])
                ->where(['Vendors.status' => 'Y']);
        foreach($vendors as $vendor){
            if(isset($vendor['financialquarters']) && !empty($vendor['financialquarters'])){
                /*
                 * If current date is inside a quarter no need to have a new entry
                 */
                $qrter  =   $this->Financialquarters->find('all')
                                                    ->where(['vendor_id'=>$vendor['id'],'enddate > '=>time()])
                                                    ->order(['enddate  '=> 'ASC']);
                $skipflag = 0;
                foreach($qrter as $qt){
                    $skipflag ++;
                    
                }
                //echo $last_qrtr_number;exit;
                $i=4 - $skipflag;
                if($i > 0){
                    $this->__createquarters($vendor['financial_quarter_start_month'],$i,$vendor['id']);
                }

            }else{
                $this->__createquarters($vendor['financial_quarter_start_month'],4,$vendor['id']);
                
            }
        }
       return true;
    }
     /*
     * Function to remind partners to submit business plan....
     * This function will send the partners a reminder 30 days before the new financial quarter is due to start and if the partner is not already submitted a business plan.
     * This function need to be executed as a cron job once in a day.
     */
    public function bpsubmissionreminders(){
        $finstartdate   =   date('Y-m-d H:i:s',strtotime(date('Y-m-d',strtotime('+30 days',time()))));
        $finenddate     =   date('Y-m-d H:i:s',strtotime(date('Y-m-d',time())));
        $fqtrs        = $this->Financialquarters->find()
                                                ->where(['startdate'=>$finstartdate, 'enddate >'=>$finenddate]);
        foreach($fqtrs as $fq):
            $this->__notifypartners($fq);
        endforeach;
        return true;
    }
     /*
     * Function to remove expired campaigns and resources from the system after XX days.....
     */
    public function removexpiredcampaigns(){
        //$this->portal_settings['campaign_asset_removal'];
        $finenddate     =   date('Y-m-d H:i:s',strtotime(date('Y-m-d',strtotime('-'.$this->portal_settings['campaign_asset_removal'].' days',time()))));
        $fqtrs          =   $this->Financialquarters->find()
                                                    ->contain(['Campaigns'])
                                                    ->where(['enddate '=>$finenddate]);
        $cmpaigns_to_remove =   array();

       ///echo $finenddate;
        foreach($fqtrs as $fqt){
            if(isset($fqt['campaigns']) && !empty($fqt['campaigns'])){
                foreach($fqt['campaigns'] as $rcmp){
                    $cmpaigns_to_remove[]   =   $rcmp->id;
                }
            }
        }
        if(!empty($cmpaigns_to_remove)){
            $landingpgs = $this->LandingPages->find('all')->where(['campaign_id IN'=>$cmpaigns_to_remove]);
            if(isset($landingpgs)&& !empty($landingpgs)){
                foreach ($landingpgs as $lpgs):
                $this->__deletelpg($lpgs->id);
                endforeach;
            }
        }
        return true;
    }
    /*
     * Function to update the opens and clicks of emails sent in last one month.....
     */
    public function updatemandrillstatus(){
        //CampaignPartnerMailinglists
       
        $frmdt      =   date('Y-m-d H:i:s',strtotime( '-1 month'));
        $todt       =   date('Y-m-d H:i:s');
        $cpm        =   $this->CampaignPartnerMailinglists->find('all')
                                                            ->contain(['PartnerCampaignEmailSettings'])
                                                            ->where(['PartnerCampaignEmailSettings.status'=>'sent','PartnerCampaignEmailSettings.sent_date >' => $frmdt,'PartnerCampaignEmailSettings.sent_date <'=> $todt]);
        if($cpm->count() > 0){
            foreach($cpm as $cm){
                $mnddata    = $this->__getmandrillstatus($cm->mandrillemailid);
                if(!empty($mnddata) && isset($mnddata['clicks']) && $mnddata['opens']){
                    $Cquery = $this->CampaignPartnerMailinglists->query();
                    $Cquery->update()
                        ->set(['opens' =>$mnddata['opens'],'clicks'=>$mnddata['clicks']])
                        ->where(['mandrillemailid' =>  $cm->mandrillemailid])
                        ->execute();
                }

            }
        }
        return true;
    }
    
    
    
        
    
    
    
    
    
    
    /*
     * The following are sub functions executed by any of the above functions....................
     */
    
    /*
     * This is a sub function used by another function...
     */
    protected function changeVendorStatus($id=null,$status= 'Y'){
        if($id > 0){
           // $this->request->allowMethod('post', 'put');
            if($this->__updateVendorUsers($id,$status)){
                $Vquery = $this->Vendors->query();
                $Vquery->update()
                     ->set(['status' => $status,'status_change_date' => time()])
                     ->where(['id' =>  $id])
                     ->execute();
                $this->Prmsemails->vendorStatusnotification($id,$status);
                $this->Flash->success(__('Vendor status has been changed successfully.'));
            }
        }
        return $this->redirect(['action' => 'vendors']);
    }
    /*
     * This is a sub function used by another function...
     */
    function __updateVendorUsers($id=null,$status= 'Y'){
        if($id > 0){
            /*
             * Find vendor users 
             */
            $vusers =   array();
            $vmanagers = $this->Users->find()
                    ->hydrate(false)
                    ->select(['Users.id'])
                    ->join([
                        'm' => [
                            'table' => 'vendor_managers',
                            'type' => 'INNER',
                            'conditions' => [
                                'Users.id = m.user_id'
                            ],
                        ]
                    ],['m.user_id' => 'integer'])
                    ->where(['m.vendor_id' => $id]);
            foreach($vmanagers as $vm){
               array_push($vusers,$vm['id']);
            }


            /*
             * Find Partner Users
             */
            $this->__findVendorPUsers($id, $vusers);
            //print_r($vusers);exit;
            $this->Users->updateAll(['status' => $status], ['users.id IN' => $vusers]);


        }
         return true;
    }
    /*
     * This is a sub function used by another function...
     */
    function __findVendorPUsers($id=null,&$vusers=  array()){
        if($id > 0){
            $pmanagers = $this->Users->find()
                ->hydrate(false)
                ->select(['Users.id'])
                ->join([
                    'm' => [
                        'table' => 'partner_managers',
                        'type' => 'INNER',
                        'conditions' => [
                            'Users.id = m.user_id'
                        ],

                    ],
                    'p' => [
                        'table' => 'partners',
                        'type' => 'INNER',
                        'conditions' => [
                            'p.id = m.partner_id'
                        ],

                    ]
                ],['m.user_id' => 'integer','m.partner_id' => 'integer'])
                ->where(['p.vendor_id' => $id]);
             foreach($pmanagers as $pm){
                array_push($vusers,$pm['id']);
             }
        }
        return true;
    }
    
   
    
    
    
    
    
     
    function __deleteVendor($id = null) {
        $this->loadModel('Partners');
        $vendor = $this->Vendors->get($id, [
            'contain' => ['VendorPayments','Partners','VendorManagers','VendorManagers.Users','Partners.PartnerManagers','Partners.PartnerManagers.Users']
    ]); 



        /*
         * Section to cancel authorize.net payment subscription
         */

        if(isset($vendor['vendor_payments']) && !empty($vendor['vendor_payments'])){
            foreach($vendor['vendor_payments'] as $vp){
                if(($vp->status == 'Active')){

                    $this->Net->cancelSubscription($vp->subscriptionid);
                }
            }
        }
        /*
         * Delete Vedor managers
         */
        if(isset($vendor['vendor_managers']) && !empty($vendor['vendor_managers'])){
            foreach($vendor['vendor_managers'] as $vm){
               if(isset($vm->user)&& !empty($vm->user)){
                   $this->__delete_user($vm->user_id);
               }

            }
        }

        /*
         * Section to delete Patrners & Partner Managers
         */
        if(isset($vendor['partners']) && !empty($vendor['partners'])){
            foreach($vendor['partners'] as $prtnr){
               if(isset($prtnr['partner_managers']) && !empty($prtnr['partner_managers'])){
                   foreach($prtnr['partner_managers'] as $pm){
                        if(isset($pm->user)&& !empty($pm->user)){
                            $this->__delete_user($pm->user_id);
                        }
                   }
               }
               $partner =   $this->Partners->get($prtnr->id);
               $this->Partners->delete($partner);



            }
        }
        if ($this->Vendors->delete($vendor)) {
                $this->Flash->success('The vendor has been deleted.');
        } else {
                $this->Flash->error('The vendor could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
    function __delete_vendor_manager($id=null){
        $vendorManager = $this->VendorManagers->get($id);
        if ($this->VendorManagers->delete($vendorManager)) {
                return true;
        } else {
               return false;
        }

    }
    function __delete_user($id=null){
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
                return true;
        } else {
               return false;
        }

    }
    
    
    function findcurrentquarterstartdate($strtmonth=null){       
        $fyr_strt_date  =   date('Y').'-'.$strtmonth.'-01 00:00:00';
        if(date('Y-m-d H:i:s') < $fyr_strt_date){
            $yr  =   date('Y')-1;
            $fyr_strt_date  =   $yr.'-'.$strtmonth.'-01 00:00:00';
        }
        $fq_strt_date   =   $fyr_strt_date;
        return $fq_strt_date;
        /*
        $fq_end_date    =   date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($fq_strt_date)) . " + 3 months"));
        while ($fq_end_date < date('Y-m-d H:i:s')){
            $fq_strt_date   =   $fq_end_date;
            $fq_end_date    =   date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($fq_strt_date)) . " + 3 months"));
        }
        return $fq_strt_date;
        */
    }
    function __createquarters($strtmonth=null,$i=4,$vid=0){
        //$final_start_date   =   date('Y-m-d', strtotime('+one year', $strtdate));
        $current_month  =   date('m');
        $qrter  =   $this->Financialquarters->find('all')
                                                    ->where(['vendor_id'=>$vid,'enddate > '=>time()])
                                                    ->order(['enddate  '=> 'DESC'])
                                                    ->limit(1);
        if($qrter->count()>0){
            // This vendor should have some entry in the table, so we can get the start date from the last quarted end date...
            foreach($qrter as $prqtr){
                $new_qtr_start_date =   date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($prqtr->enddate))));
                $new_qtr_end_date =   date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($new_qtr_start_date)) . " + 3 MONTHS"));
            }
        }else{
            $new_qtr_start_date =   $this->findcurrentquarterstartdate($strtmonth);
            $new_qtr_end_date   =   date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($new_qtr_start_date)) . " + 3 MONTHS"));
        }

        $qrter_all  =  $this->Financialquarters->find('all')
                        ->where(['vendor_id'=>$vid])
                        ->order(['enddate  '=> 'DESC'])
                        ->limit(1);

        if($qrter_all->count()>0) {
            $qrtr = $qrter_all->first();
            $qrtr_title = $qrtr->quartertitle;

            preg_match('|([A-Za-z]+?)(\s?)([0-9])(\s?)\(([0-9]+?)\)|i', $qrtr_title, $q);

            $i_qtr_num = ( $q[3] == '4' ? 0 : $q[3] );
            $i_qtr_yr  = ( $q[3] == '4' ? $q[5] + 1 : $q[5] );
        }
        else
        {
            $i_qtr_num = 0;
            $i_qtr_yr  = date('Y',strtotime($new_qtr_end_date));
        }

        $qtr_yr = $i_qtr_yr;
        $qtr_num = $i_qtr_num;
        for($j=0;$j<$i;$j++){
            $qtr_num++;
            $qtr[$j]['startdate']       =   $new_qtr_start_date;
            $qtr[$j]['enddate']         =   date("Y-m-d H:i:s", strtotime($new_qtr_end_date . ' - 1 DAY'));
            $qtr[$j]['vendor_id']       =   $vid;
            $qtr[$j]['quartertitle']    =   __('Q'.$qtr_num.' ('.$qtr_yr.')');//__('Financial quarter ').date('M',strtotime($new_qtr_start_date)).' '.date('Y',strtotime($new_qtr_start_date)).' - '.date('M',strtotime($new_qtr_end_date)).' '.date('Y',strtotime($new_qtr_end_date));
            $new_qtr_start_date         =   $new_qtr_end_date;
            $new_qtr_end_date           =   date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime($new_qtr_start_date)) . " + 3 months"));

            if($qtr_num == '4') {
                $qtr_num = 0;
                $qtr_yr = $qtr_yr + 1;
            }
        } 
        foreach ($qtr as $qt){
            $fqc = $this->Financialquarters->newEntity($qt);
            $fqc_result  =   $this->Financialquarters->save($fqc); 
        }
       return true;
    }
   

    function __notifypartners($fqtr=  array()){
        if(isset($fqtr->vendor_id) && isset($fqtr->id) && $fqtr->vendor_id > 0 && $fqtr->id > 0){
            $partners  = $this->Partners->find()
                                        ->contain(['PartnerManagers'=> function ($q) {
                                                                            return $q->find('all')->where(['primary_contact'=>'Y']);
                                                                         },'PartnerManagers.Users','Vendors','Vendors.VendorManagers'=> function ($q) {
                                                                            return $q->find('all')->where(['primary_manager'=>'Y']);
                                                                         },'Vendors.VendorManagers.Users'])
                                        ->where(['vendor_id'=>$fqtr->vendor_id]);
            foreach($partners as $prt){
               $bpdet  =   $this->Businesplans->find()
                                                ->where(['partner_id'=>$prt->id,'financialquarter_id'=> $fqtr->id,'status IN'=>['Submit','Approved']])
                                                ->first();
                if(isset($bpdet->id) && $bpdet->id >0){
                    // Partner already submitted a business plan
                }else{
                    //notify the partner to send a business plan.
                   $this->Prmsemails->bpsubmissionreminder($prt['partner_managers'][0]['user']->full_name,$prt->email,$fqtr->quartertitle,$prt['vendor']['vendor_managers'][0]['user']->full_name,$prt['vendor']['vendor_managers'][0]['user']->email,$prt['vendor']->company_name);
                }
            }return true;
        }
        return false;
    }
   
    function __deletelpg($id = null) {
            $lpg = $this->LandingPages->get($id);
            $this->Filemanagement->removeFile('landingpages/'.$lpg->downloadable_item);
            if ($this->LandingPages->delete($lpg)) {
                return true;
            } else {
                return false;
            }

    }
        
    
    function __getmandrillstatus($id=null){
        $mandrill   =   new Mandrill($this->portal_settings['mandrill_key']);
        $return = array();
        if($id != null){
            $return = $mandrill->messages->info($id);
        }

        return $return;
    }
    function sendmanmail($partner_campaign_id=0,$html=null,$topart=array(),$subject=NULL,$from_name=NULL,$from_email=NULL,$reply_email=NULL){
        if(NULL ==$from_email){
            $from_email =   $this->portal_settings['site_email'];
        }
        if(NULL ==$reply_email){
            $reply_email =   $this->portal_settings['site_email'];
        }
        if(NULL ==$from_name){
            $from_name  =   $this->portal_settings['site_name'];
        }
        $mandrill = new Mandrill($this->portal_settings['mandrill_key']);
        if($html != NULL && !empty($topart) ){
            $message = array(
                'html' => $html,
                'subject' => $subject,
                'from_email' => $from_email,
                'from_name' => $from_name,
                'to' => $topart,
                'headers' => array('Reply-To' => $reply_email),
                'important' => false,
                'track_opens' => true,
                'track_clicks' => true,
                'auto_text' => null,
                'auto_html' => true,
                'inline_css' => true,
                'url_strip_qs' => null,
                'preserve_recipients' => null,
                'view_content_link' => null,
                'tracking_domain' => null,
                'signing_domain' => null,
                'return_path_domain' => null,
                'merge' => true,
                'merge_language' => 'mailchimp',
                'tags' => array('password-resets'),
                'subaccount' => 'sic1',
                'google_analytics_domains' => array('marketingconnex.com'),
                'google_analytics_campaign' => 'marketingconnex.com',
                'metadata' => array('website' => 'www.marketingconnex.com'),

            );
            $async = false;
            $ip_pool = 'Main Pool';
            $send_at = date('Y-m-d H:i:s',strtotime('-1 days',time()));
            $result = $mandrill->messages->send($message, $async, $ip_pool);
            if($this->updateMailinglists($partner_campaign_id, $result)){
                return true;
            }
        }
        return false;
    }

    function updateMailinglists($partner_campaign_id=0,$results=array()){
        if(!empty($results) && $partner_campaign_id > 0){
            foreach($results as $res){
                //print_r($res);exit;
                if($res['status'] == 'sent'){
                    /*
                     * Section to update campaign partner mailing list table.....
                     */
                    $Cquery = $this->CampaignPartnerMailinglists->query();
                    $Cquery->update()
                        ->set(['mandrillemailid' =>$res['_id']])
                        ->where(['partner_campaign_id' =>  $partner_campaign_id,'email'=>$res['email'],'participate_campaign'=>'Y','subscribe'=>'Y'])
                        ->execute();
                }
            }
            return true;
        }
        return false;
    }
   
    function sentCampaignmail($partner_campaign_id=0){
            $image_url  = Router::url('/img/',true);
            //echo $partner_campaign_id;exit;
            $retval =   false;
            if($partner_campaign_id > 0){
                $participants   = $this->CampaignPartnerMailinglists->find('all')->where(['partner_campaign_id'=>$partner_campaign_id,'participate_campaign'=>'Y','subscribe'=>'Y']);
                $totcurrentparticipants = $participants->count();
                $pcampaigndet   = $this->PartnerCampaigns->find()
                                                        ->contain(['Partners', 'Campaigns','PartnerCampaignEmailSettings','Campaigns.EmailTemplates','Campaigns.EmailTemplates.MasterTemplates','Campaigns.Vendors'])
                                                        ->where(['PartnerCampaigns.id'=>$partner_campaign_id])
                                                        ->first();
                if($totcurrentparticipants > $pcampaigndet['campaign']->send_limit){
                    /*
                     * Section to send notification emails to vendor and partner informing the no of participants exceed the the maximum allowed sends.......
                     */
                    $partnermngr    =   $this->PartnerManagers->find()->contain(['Users','Partners'])->where(['PartnerManagers.partner_id'=>$pcampaigndet->partner_id,'PartnerManagers.primary_contact'=>'Y'])->first();
                    $vendormngr     =   $this->VendorManagers->find()->contain(['Users','Vendors'])->where(['VendorManagers.vendor_id'=>$pcampaigndet['campaign']['vendor']->id,'VendorManagers.primary_manager'=>'Y'])->first();
                    $this->Prmsemails->notifycampaignlimitexceeds($vendormngr,$partnermngr,$pcampaigndet['campaign'],$totcurrentparticipants);
                    return false;
                }
                /*
                 * Section to create to email array...
                 */
                $to_part_array  =   array();$i=0;
                foreach($participants as $pc){
                    $to_part_array[$i]['name']= $pc->first_name.' '.$pc->last_name;
                    $to_part_array[$i]['email']= $pc->email;
                    $to_part_array[$i]['type']= 'to';
                    $i++;
                }
                if(empty($to_part_array)){
                    return false; // As there is no valid participant to receive the email....
                }
                if(isset($pcampaigndet['partner_campaign_email_settings'][0]->id)){
                    /*
                     * Section to create email html 
                     */
                    $emailTemplate  =   $pcampaigndet['campaign']['email_templates'][0];

                    if(isset($pcampaigndet['campaign']['email_templates'][0]['master_template']->content) && $pcampaigndet['campaign']['email_templates'][0]->use_templates == 'Y'){
                        $viewhtml  =   $pcampaigndet['campaign']['email_templates'][0]['master_template']->content;
                        
                        $viewhtml   =   str_replace('[*!SITE_URL!*]',$this->portal_settings['site_url'], $viewhtml); 
                        $viewhtml   =   str_replace('[*!WEBLINK!*]',$this->portal_settings['site_url'].'/email_templates/view/'.$emailTemplate->id, $viewhtml); 
                        $viewhtml   =   str_replace('[*!HEADING!*]',$emailTemplate->heading, $viewhtml);
                        $viewhtml   =   str_replace('[*!SUBJECTTEXT!*]',$emailTemplate->subject_text, $viewhtml);
                  	    if ($emailTemplate->banner_text != '') {
                  	    $viewhtml   =   str_replace('[*!BANNERTEXT!*]',$emailTemplate->banner_text, $viewhtml);
                  	    } else {
                  	    $viewhtml   =   str_replace('[*!BANNERTEXT!*]',' ', $viewhtml);
                  	    }
                        $viewhtml   =   str_replace('[*!BODYTEXT!*]',$emailTemplate->body_text, $viewhtml);
                        $viewhtml   =   str_replace('[*!FEATUREHEADING!*]',$emailTemplate->features_heading, $viewhtml);
                        $viewhtml   =   str_replace('[*!FEATURES!*]',$emailTemplate->features, $viewhtml);
                        $viewhtml   =   str_replace('[*!CTATEXT!*]','<a href="'.$emailTemplate->cta_url.'">'.$emailTemplate->cta_text.'</a>', $viewhtml);
                        if(isset($pcampaigndet['partner']->logo_url) && is_file(WWW_ROOT  .'img' . DS . 'logos' . DS.$pcampaigndet['partner']->logo_url)){
                            $plogo      =    '<img src="'.$image_url.'logos' . DS .$pcampaigndet['partner']->logo_url.'" height="60" width="100" class="left"/>';
                            $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
                        }
                        if(isset($emailTemplate->banner_bg_image)&& $emailTemplate->banner_bg_image != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'bgimages'.DS.$emailTemplate->banner_bg_image)){
                            $bannerbgimage   =   '<img src="'.$image_url.'emailtemplates' . DS .'bgimages'.DS.$emailTemplate->banner_bg_image.'" alt="Banner" width="auto" height="auto"/>';
                            $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
                        }
                        if(isset($emailTemplate->cta_bg_image)&& $emailTemplate->cta_bg_image != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'ctaimages'.DS.$emailTemplate->cta_bg_image)){
                            $ctabgimage   =   '<a href="'.$emailTemplate->cta_url.'"><img src="'.$image_url.'emailtemplates' . DS .'ctaimages'.DS.$emailTemplate->cta_bg_image.'" alt="CTA Image"  width="auto" height="auto"/></a>';
                            $viewhtml   =   str_replace('[*!CTAIMAGE!*]',$ctabgimage, $viewhtml);
                        }
                        if(isset($pcampaigndet['campaign']['vendor']->logo_url) && is_file(WWW_ROOT  .'img' . DS . 'logos' . DS.$pcampaigndet['campaign']['vendor']->logo_url)){
                            $vlogo      =    '<img src="'.$image_url.'logos' . DS .$pcampaigndet['campaign']['vendor']->logo_url.'" height="60" width="100" class="left"/>';
                            $viewhtml   =   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
                        }
                    }elseif($pcampaigndet['campaign']['email_templates'][0]->use_templates != 'Y' && $pcampaigndet['campaign']['email_templates'][0]->custom_template != ''){
                        $viewhtml  =$pcampaigndet['campaign']['email_templates'][0]->custom_template;
                        
                        if(isset($pcampaigndet['partner']->logo_url) && is_file(WWW_ROOT  .'img' . DS . 'logos' . DS.$pcampaigndet['partner']->logo_url)){
                            $plogo      =    '<img src="'.$image_url.'logos' . DS .$pcampaigndet['partner']->logo_url.'" height="60" width="100" class="left"/>';
                            $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
                        }

                        if($emailTemplate->cta_url)
                            if($emailTemplate->cta_text)
                                $viewhtml   =   str_replace('[*!CTATEXT!*]','<a href="'.$emailTemplate->cta_url.'">'.$emailTemplate->cta_text.'</a>', $viewhtml);
                            else
                                $viewhtml   =   str_replace('[*!CTATEXT!*]',$emailTemplate->cta_url, $viewhtml);
                    }
                    
                   
                }else{
                    return false;// There is no valid email settings to send the campaign....
                }
                if($this->sendmanmail($partner_campaign_id,$viewhtml,$to_part_array,$pcampaigndet['campaign']['email_templates'][0][$pcampaigndet['partner_campaign_email_settings'][0]->subject_option],$pcampaigndet['partner_campaign_email_settings'][0]->from_name,$pcampaigndet['partner_campaign_email_settings'][0]->from_email,$pcampaigndet['partner_campaign_email_settings'][0]->reply_to_email)){
                	$base_url = Router::url('/',true);
                	// Linkedin Post to Personal and Company
                	$this->loadComponent('Socialmedia');
                	$pces = $pcampaigndet['partner_campaign_email_settings'][0];
                	if($pces->post_linkedin=='1')
                	{
                		$linkedin_text = $pces->linkedin_text;
                		$linkedin_text = str_replace('[*!EMAILURL!*]',$base_url.'e/'.$pces->email_template_id, $linkedin_text);
                		if($pces->linkedin_personal=='1')
                			$resp = $this->Socialmedia->linkedin_postPersonal($linkedin_text);
                			
                		$linkedin_companies = explode(',',$pces->linkedin_companies);
                		if(count($linkedin_companies)>0)
                		foreach($linkedin_companies as $linkedin_company)
                			$resp = $this->Socialmedia->linkedin_postCompany($linkedin_company,$linkedin_text);
                	}
                	// End Linkedin Post
                	// Twitter Tweet
					if($pces->post_tweet=='1'){
						$tweet_text = $pces->tweet_text;
						$tweet_text = str_replace('[*!EMAILURL!*]',$base_url.'e/'.$pces->email_template_id, $tweet_text);
						$resp = $this->Socialmedia->twitter_tweet($tweet_text);
					}
					// End Twitter Tweet
					//Start FB Post 
					if($pces->post_facebook=='1'){
						$facebook_text = $pces->facebook_text;
						$facebook_link = $base_url.'e/'.$pces->email_template_id;
						$facebook_text = str_replace('[*!EMAILURL!*]',$facebook_link, $facebook_text);
						
						if($pces->facebook_personal=='1')	
						$resp = $this->Socialmedia->facebook_post($facebook_text,$facebook_link);
							
						$facebook_pages = explode(',',$pces->facebook_pages);
						if(count($facebook_pages)>0){
							foreach($facebook_pages as $facebook_page){
								$page_data = explode(':',$facebook_page);
								$resp = $this->Socialmedia->post_facebook_pages($page_data[0],$page_data[1],$facebook_text,$facebook_link);
							}
						}
					}
					// End FB Post
                	$retval=    true;
                }

                
            }
            return $retval;
        }
}
