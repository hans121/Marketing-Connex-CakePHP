<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// src/Controller/UsersController.php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Error\NotFoundException;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use Cake\Routing\Router;
class AdminsController extends AppController {
    public $components = ['Imagecreator','Opencloud'];
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
       $this->loadModel('Vendors');
       $this->loadModel('Coupons');
       $this->loadModel('SubscriptionPackages');
       $this->loadModel('VendorPayments');
       $this->loadModel('VendorManagers');
       $this->loadModel('Users');
       $this->loadModel('Financialquarters');
       $this->loadModel('Campaigns');
       $this->layout = 'admin';
    }

    public function index() { 
       // Number of Vendors by Subscription Package
        $vendors_bypackage = $this->SubscriptionPackages
                                ->find('all')
                                ->contain(['Vendors']);

        // Expiring vendor subscriptions
        $vendors_expiring = $this->Vendors
                                ->find('all')
                                ->contain(['SubscriptionPackages'])
                                ->where(['(TO_DAYS(Vendors.subscription_expiry_date) - TO_DAYS(NOW())) <= 90','(TO_DAYS(Vendors.subscription_expiry_date) - TO_DAYS(NOW())) >= 0'])
                                ->order(['Vendors.subscription_expiry_date'=>'ASC']);

        // Subscription Packages
        $subscription_packages = $this->SubscriptionPackages
                                    ->find('all')
                                    ->contain(['Vendors'=>function ($q){
                                        return $q->where(['Vendors.status'=>'Y']);
                                    }])
                                    ->order(['SubscriptionPackages.name'=>'ASC']);

        // Vendors locations
        $vendors = $this->Vendors->find('all');
        $vendors  ->select(['country','state'])
                            ->where(['status'=>'Y'])
                            ->order(['country'=>'ASC'])
                            ->group(['country','state']);

        $vendors_locations = array();
        foreach($vendors as $row) {
            $vendor = $this->Vendors->find()->contain(['SubscriptionPackages','Campaigns.CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
                                return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
                            }])->where(['country'=>$row->country,'state'=>$row->state])->toArray();
            
            $vids = array();
            $vendorscnt = count($vendor);
            $campaignscnt = 0;
            $deals_val = 0;
            $revenue = 0;
            foreach($vendor as $v) {
                $vids[] = $v['id'];
                foreach($v->campaigns as $c) {
                    $campaignscnt++;
                    foreach($c->campaign_partner_mailinglists as $m)
                        foreach($m->campaign_partner_mailinglist_deals as $d)
                            $deals_val += $d->deal_value;
                }

                if($v->last_billed_date!='')
                    if((date('Y',strtotime($v->subscription_expiry_date)) - date('Y',strtotime($v->last_billed_date))) >= 0)
                        $revenue += ($v->subscription_type=='monthly' ? $v->subscription_package->monthly_price*12 : $row->subscription_package->annual_price);
            }

            $vendors_locations[] = array('country'=>$row->country,'state'=>$row->state,'vendorscnt'=>$vendorscnt,'campaignscnt'=>$campaignscnt,'deals_value'=>$deals_val,'annualised_revenue'=>$revenue);
        }

        /*Query Vendors to get financial month and subscription package*/
        $vendors = $this->Vendors->find('all')
                                 ->contain(['SubscriptionPackages'])
                                 ->where(['Vendors.status'=>'Y','Vendors.last_billed_date IS NOT NULL']);

        $campaigns_current_cnt = 0;
        $deals_current_val = 0;
        $campaigns_last_cnt = 0;
        $deals_last_val = 0;
        $profit_bycountry = array();
        foreach($vendors as $v)
        {
            $financial_m = $v->financial_quarter_start_month;

            //YTD
            $financialquarter_current_year = $this->Financialquarters->find()
                ->select(['id','quartertitle','startdate','enddate'])
                ->where(['vendor_id'=>$v->id, 'quartertitle LIKE'=>'%('.(date('m')<$financial_m?date('Y')-1:date('Y')).')','(MONTH(NOW()) > MONTH(startdate) OR MONTH(startdate) < '.$financial_m.') AND \''.date('Y-m-d h:i:s').'\' > startdate' ]) 
                ->order(['quartertitle'=>'ASC'])
                ->toArray();
            //YTD last year
            $financialquarter_last_year = $this->Financialquarters->find()
                ->select(['id','quartertitle','startdate','enddate'])
                ->where(['vendor_id'=>$v->id, 'quartertitle LIKE'=>'%('.(date('m')<$financial_m?((date('Y')) - 2):((date('Y')) - 1)).')','(MONTH(NOW()) > MONTH(startdate) OR MONTH(startdate) < '.$financial_m.') AND \''.date('Y-m-d h:i:s',strtotime((date('Y')-1).'-'.date('m').'-'.date('d').' '.date('h').':'.date('i').':'.date('s'))).'\' > startdate']) 
                ->order(['quartertitle'=>'ASC'])
                ->toArray();

            $financialquarters_current_year = array();
            foreach($financialquarter_current_year as $row)
                $financialquarters_current_year[] = $row['id'];

            $financialquarters_last_year = array();
            foreach($financialquarter_last_year as $row)
                $financialquarters_last_year[] = $row['id'];

            $campaigns_current_year = $this->Campaigns
                            ->find('all')
                            ->contain(['CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
                                return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
                            }])
                            ->where(['Campaigns.financialquarter_id IN'=>$financialquarters_current_year]);

            $campaigns_last_year = $this->Campaigns
                            ->find('all')
                            ->contain(['CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'])
                            ->where(['Campaigns.financialquarter_id IN'=>$financialquarters_last_year]);

            foreach($campaigns_current_year as $c) {
                $campaigns_current_cnt++;
                foreach($c->campaign_partner_mailinglists as $m)
                    foreach($m->campaign_partner_mailinglist_deals as $d)
                        $deals_current_val += $d->deal_value;
            }

            foreach($campaigns_last_year as $c) {
                $campaigns_last_cnt++;
                foreach($c->campaign_partner_mailinglists as $m)
                    foreach($m->campaign_partner_mailinglist_deals as $d)
                        $deals_last_val += $d->deal_value;
            }

            // Get subscription package details  for profit by territory             
            $country_i = preg_replace('|[^a-z]|', '', strtolower($v->country));

            if($v->last_billed_date!='')
                if((date('Y',strtotime($v->subscription_expiry_date)) - date('Y',strtotime($v->last_billed_date))) >= 0)
                    $$country_i += ($v->subscription_type=='monthly' ? $v->subscription_package->monthly_price*12 : $row->subscription_package->annual_price);

            $profit_bycountry[ $country_i ] = array('country'=>$v->country,'profit'=>$$country_i);

        }

        // Campaigns and deal value
        $fyear_current = array('campaigns'=>$campaigns_current_cnt,'deals'=>$deals_current_val);
        $fyear_last = array('campaigns'=>$campaigns_last_cnt,'deals'=>$deals_last_val); 

        // Profit by Territory
        usort($profit_bycountry, array($this,"__cmp_desc"));   

        $this->set(compact('vendors_bypackage','vendors_expiring','subscription_packages','vendors_locations','fyear_current','fyear_last','profit_bycountry'));
    }
    
    public function export() {
	    
	    // Number of Vendors by Subscription Package
        $vendors_bypackage = $this->SubscriptionPackages
                                ->find('all')
                                ->contain(['Vendors']);
        
        $chart_data = array();
        	$i=0;
        $chart_data[$i][$i]		=		"No. of Vendors by Subscription Package \n";
        	$i++;
        $chart_data[$i]['package']			=		'Subscription Package';
        $chart_data[$i]['count']			=		'';
        	$i++;
        foreach ($vendors_bypackage as $row) {
	        $chart_data[$i]['package']		=		$row->name;
	        $chart_data[$i]['count']		=		count($row->vendors);
	        $i++;
        }
  
	    
	  	// Expiring vendor subscriptions
        $vendors_expiring = $this->Vendors
                                ->find('all')
                                ->contain(['SubscriptionPackages'])
                                ->where(['(TO_DAYS(Vendors.subscription_expiry_date) - TO_DAYS(NOW())) <= 90','(TO_DAYS(Vendors.subscription_expiry_date) - TO_DAYS(NOW())) >= 0'])
                                ->order(['Vendors.subscription_expiry_date'=>'ASC']);
                                
       $vendors_expiring_array = array();
       
       		$i=0;
       $vendors_expiring_array[$i][$i]			=		"Expiring vendor subscriptions (next 90 days) \n";
       		$i++;
       if (0 == $vendors_expiring->count()) {
				$vendors_expiring_array[$i][$i]					=	'No expiring vendors';
			}
			else {
			foreach ($vendors_expiring as $row) {
				$vendors_expiring_array[$i][$i]					=	$row->company_name;
				$i++;
			}
			}	
			
	   $count=0;
	   $dashboard_array = array();
       		$i=0;
       //set title
       $dashboard_array[$i][$i]									=	"\n Subscription Packages \n";
       		$i++;
       $dashboard_array[$i]['title']							=	'Title';
       $dashboard_array[$i]['subscribers_all']					=	'Subscribers (all)';
       $dashboard_array[$i]['annualised_income_all']			=	'Annualised Income (all)';
       $dashboard_array[$i]['subscribers_new']					=	'Subscribers (new this month)';
       $dashboard_array[$i]['annualised_income_month']			=	'Annualised Income (this month\'s new subscribers)';
       
	   $subscription_packages = $this->SubscriptionPackages
                                    ->find('all')
                                    ->contain(['Vendors'=>function ($q){
                                        return $q->where(['Vendors.status'=>'Y']);
                                    }])

                                    
                                    ->order(['SubscriptionPackages.name'=>'ASC']);
									$j =0;	
									foreach ($subscription_packages as $row):
									$j++;

									$subscribers_cnt = count($row->vendors);
									$annual_income = 0;
									$subscribers_cnt_currmonth = 0;
									$subscribers_curr_income = 0;
									foreach($row->vendors as $v) {
										// Get current income, annualised
										if($v->last_billed_date!='')
											if((date('Y',strtotime($v->subscription_expiry_date)) - date('Y',strtotime($v->last_billed_date))) >= 0)
												$annual_income += ($v->subscription_type=='monthly' ? $row->monthly_price*12 : $row->annual_price);

										// Get new subscription count and income, annualised
										if($v->last_billed_date!='')
											if((date('Y',strtotime($v->created_on)) == date('Y',strtotime($v->last_billed_date))) && date('Y',strtotime($v->last_billed_date)) == date('Y') && date('m',strtotime($v->last_billed_date)) == date('m')) {
												$subscribers_cnt_currmonth++;
												$subscribers_curr_income += ($v->subscription_type=='monthly' ? $row->monthly_price*12 : $row->annual_price);
											}
									}
			$i++;						
		$dashboard_array[$i]['title']							=		$row->name;
		$dashboard_array[$i]['subscribers_all']					=		$subscribers_cnt;
		$dashboard_array[$i]['annualised_income_all']			=		round($annual_income);
		$dashboard_array[$i]['subscribers_new']					=		$subscribers_cnt_currmonth;
		$dashboard_array[$i]['annualised_income_month']			=		round($subscribers_curr_income);
		
		$i++;
		endforeach;
		
	   $dashboard_array_locations = array();
       		$i=0;
       //set title
       $dashboard_array_locations[$i][$i]									=	"\n Vendor Locations \n";
       		$i++;
       $dashboard_array_locations[$i]['country']							=	'Country';
       $dashboard_array_locations[$i]['county_state']						=	'County/State';
       $dashboard_array_locations[$i]['vendors']							=	'Vendors';
       $dashboard_array_locations[$i]['campaigns']							=	'Campaigns';
       $dashboard_array_locations[$i]['closed_deals']						=	'Closed Deals';
       $dashboard_array_locations[$i]['annualised_revenue']					=	'Annualised Revenue';
	   		$i++;
  		 // Vendors locations
       $vendors = $this->Vendors->find('all');
        $vendors  ->select(['country','state'])
                            ->where(['status'=>'Y'])
                            ->order(['country'=>'ASC'])
                            ->group(['country','state']);

        $vendors_locations = array();
        foreach($vendors as $row) {
            $vendor = $this->Vendors->find()->contain(['SubscriptionPackages','Campaigns.CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
                                return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
                            }])->where(['country'=>$row->country,'state'=>$row->state])->toArray();
		       $vids = array();
            $vendorscnt = count($vendor);
            $campaignscnt = 0;
            $deals_val = 0;
            $revenue = 0;
            foreach($vendor as $v) {
                $vids[] = $v['id'];
                foreach($v->campaigns as $c) {
                    $campaignscnt++;
                    foreach($c->campaign_partner_mailinglists as $m)
                        foreach($m->campaign_partner_mailinglist_deals as $d)
                            $deals_val += $d->deal_value;
                }

                if($v->last_billed_date!='')
                    if((date('Y',strtotime($v->subscription_expiry_date)) - date('Y',strtotime($v->last_billed_date))) >= 0)
                        $revenue += ($v->subscription_type=='monthly' ? $v->subscription_package->monthly_price*12 : $row->subscription_package->annual_price);
            }

            $vendors_locations[] = array('country'=>$row->country,'state'=>$row->state,'vendorscnt'=>$vendorscnt,'campaignscnt'=>$campaignscnt,'deals_value'=>$deals_val,'annualised_revenue'=>$revenue);
        
        $dashboard_array_locations[$i]['country']							=	$row->country;
		$dashboard_array_locations[$i]['county_state']						=	$row->state;
		$dashboard_array_locations[$i]['vendors']							=	$vendorscnt;
		$dashboard_array_locations[$i]['campaigns']							=	$campaignscnt;
		$dashboard_array_locations[$i]['closed_deals']						=	$deals_val;
		$dashboard_array_locations[$i]['annualised_revenue']				=	$revenue;
        $i++;        
        
        }
        
        $i=0;
        $dashboard_array_campaigns = array();
       		$i=0;
       //set title
       $dashboard_array_campaigns[$i][$i]									=	"\n Campaigns \n";
       		$i++;
       $dashboard_array_campaigns[$i]['financial_year']							=	'Financial Year';
       $dashboard_array_campaigns[$i]['number_campaigns']						=	'No. Campaigns';
       $dashboard_array_campaigns[$i]['fclosed_deals']							=	'Closed Deals';
       		$i++;
       
	   /*Query Vendors to get financial month and subscription package*/
        $vendors = $this->Vendors->find('all')
                                 ->contain(['SubscriptionPackages'])
                                 ->where(['Vendors.status'=>'Y','Vendors.last_billed_date IS NOT NULL']);

        $campaigns_current_cnt = 0;
        $deals_current_val = 0;
        $campaigns_last_cnt = 0;
        $deals_last_val = 0;
        $profit_bycountry = array();
        foreach($vendors as $v)
        {
            $financial_m = $v->financial_quarter_start_month;

            //YTD
            $financialquarter_current_year = $this->Financialquarters->find()
                ->select(['id','quartertitle','startdate','enddate'])
                ->where(['vendor_id'=>$v->id, 'quartertitle LIKE'=>'%('.(date('m')<$financial_m?date('Y')-1:date('Y')).')','(MONTH(NOW()) > MONTH(startdate) OR MONTH(startdate) < '.$financial_m.') AND \''.date('Y-m-d h:i:s').'\' > startdate' ]) 
                ->order(['quartertitle'=>'ASC'])
                ->toArray();
            //YTD last year
            $financialquarter_last_year = $this->Financialquarters->find()
                ->select(['id','quartertitle','startdate','enddate'])
                ->where(['vendor_id'=>$v->id, 'quartertitle LIKE'=>'%('.(date('m')<$financial_m?((date('Y')) - 2):((date('Y')) - 1)).')','(MONTH(NOW()) > MONTH(startdate) OR MONTH(startdate) < '.$financial_m.') AND \''.date('Y-m-d h:i:s',strtotime((date('Y')-1).'-'.date('m').'-'.date('d').' '.date('h').':'.date('i').':'.date('s'))).'\' > startdate']) 
                ->order(['quartertitle'=>'ASC'])
                ->toArray();

            $financialquarters_current_year = array();
            foreach($financialquarter_current_year as $row)
                $financialquarters_current_year[] = $row['id'];

            $financialquarters_last_year = array();
            foreach($financialquarter_last_year as $row)
                $financialquarters_last_year[] = $row['id'];

            $campaigns_current_year = $this->Campaigns
                            ->find('all')
                            ->contain(['CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
                                return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
                            }])
                            ->where(['Campaigns.financialquarter_id IN'=>$financialquarters_current_year]);

            $campaigns_last_year = $this->Campaigns
                            ->find('all')
                            ->contain(['CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'])
                            ->where(['Campaigns.financialquarter_id IN'=>$financialquarters_last_year]);

            foreach($campaigns_current_year as $c) {
                $campaigns_current_cnt++;
                foreach($c->campaign_partner_mailinglists as $m)
                    foreach($m->campaign_partner_mailinglist_deals as $d)
                        $deals_current_val += $d->deal_value;
            }

            foreach($campaigns_last_year as $c) {
                $campaigns_last_cnt++;
                foreach($c->campaign_partner_mailinglists as $m)
                    foreach($m->campaign_partner_mailinglist_deals as $d)
                        $deals_last_val += $d->deal_value;
            }

            // Get subscription package details  for profit by territory             
            $country_i = preg_replace('|[^a-z]|', '', strtolower($v->country));

            if($v->last_billed_date!='')
                if((date('Y',strtotime($v->subscription_expiry_date)) - date('Y',strtotime($v->last_billed_date))) >= 0)
                    $$country_i += ($v->subscription_type=='monthly' ? $v->subscription_package->monthly_price*12 : $row->subscription_package->annual_price);

            $profit_bycountry[ $country_i ] = array('country'=>$v->country,'profit'=>$$country_i);

        }

        // Campaigns and deal value
        $fyear_current = array('campaigns'=>$campaigns_current_cnt,'deals'=>$deals_current_val);
        $fyear_last = array('campaigns'=>$campaigns_last_cnt,'deals'=>$deals_last_val); 

        // Profit by Territory
        usort($profit_bycountry, array($this,"__cmp_desc"));   

        $this->set(compact('vendors_bypackage','vendors_expiring','subscription_packages','vendors_locations','fyear_current','fyear_last','profit_bycountry'));
	   
	   
	   //define table contents
	   $dashboard_array_campaigns[$i]['financial_year']							=		'Current';
       $dashboard_array_campaigns[$i]['number_campaigns']						=		$fyear_current['campaigns'];
	   $dashboard_array_campaigns[$i]['fclosed_deals']							=		$fyear_current['deals'];
       		$i++;
       $dashboard_array_campaigns[$i]['financial_year']							=		'Previous';	
       $dashboard_array_campaigns[$i]['number_campaigns']						=		$fyear_last['campaigns'];	
       $dashboard_array_campaigns[$i]['fclosed_deals']							=		$fyear_last['deals'];

       
        $dashboard_array_income_country = array();
       		$i=0;
       //set title
      $dashboard_array_income_country[$i][$i]									=	"\n Income, by country \n";
       		$i++;
       $dashboard_array_income_country[$i]['country']							=	'Country';
       $dashboard_array_income_country[$i]['income_all']						=	'Income (all packages)';
	   		$i++;
	   		
	   foreach ($profit_bycountry as $row) {
		   $dashboard_array_income_country[$i]['country']						=	$row['country'];
	       $dashboard_array_income_country[$i]['income_all']					=	$row['profit'];
	       $i++;
	   }
	   
        $final_dashboard_array = array();
        $final_dashboard_array[0] = $chart_data;
        $final_dashboard_array[1] = $vendors_expiring_array;        
        $final_dashboard_array[2] = $dashboard_array;
        $final_dashboard_array[3] = $dashboard_array_locations;
        $final_dashboard_array[4] = $dashboard_array_campaigns;
        $final_dashboard_array[5] =	$dashboard_array_income_country;
        
        
        
        
		$this->Filemanagement->getExportcsvMulti($final_dashboard_array, 'dashboard_details.csv', ', ');
		exit;			
         
        }


    function __cmp_asc($a, $b) {
        if ($a['profit'] == $b['profit']) {
            return 0;
        }
        return ($b['profit'] > $a['profit']) ? -1 : 1;
    }
    
    function __cmp_desc($a, $b) {
        if ($a['profit'] == $b['profit']) {
            return 0;
        }
        return ($b['profit'] < $a['profit']) ? -1 : 1;
    }    

    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'superadmin') {
            return true;
        }
		if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }
        if (isset($user['role']) && $user['role'] === 'vendor') {
            return $this->redirect(['controller' => 'Vendors','action' => 'index']);
        }
        if (isset($user['role']) && $user['role'] === 'partner') {
            return $this->redirect(['controller' => 'Partners','action' => 'index']);
        }
        // Default deny
        return false;
    }
    public function vendors() {
        if ($this->request->is(['post', 'put'])) {
            //print_r( $this->request->data);exit;
            $keyword  =   $this->request->data['keyword'];
            $lkeyword  =   '%'.$keyword.'%';
            if(trim($keyword) != ''){
                 $query = $this->Vendors->find('all')->where(['company_name LIKE ' => $lkeyword])
                                                   ->orWhere(['website LIKE ' => $lkeyword])
                          ->orWhere(['address LIKE ' => $lkeyword])
                          ->orWhere(['country LIKE ' => $lkeyword])
                          ->orWhere(['city LIKE ' => $lkeyword])
                          ->orWhere(['state LIKE ' => $lkeyword]);
                 $this->set('vendors', $this->paginate($query));
            }else{
                $this->set('vendors', $this->paginate($this->Vendors));
            }

        }else{
            $this->set('vendors', $this->paginate($this->Vendors));
            $keyword  =   '';
        }
        $this->set('keyword', $keyword);
    }

    public function vendorsbyterritory($country='',$state=''){
    
        if ($state!='' || $country!='') {               
            $query = $this->Vendors->find('all')
                ->where(['Vendors.country LIKE' => $country])
                ->andWhere(['Vendors.state LIKE' => $state]);
            $this->set('vendors', $this->paginate($query));
            $this->set(compact('state','country'));
             
        }else{
            $this->set('vendors', $this->paginate($this->Vendors));
        }
        
    
    }  

    public function viewVendor($id = null) {
        $vendor = $this->Vendors->get($id, [
                'contain' => ['Coupons','SubscriptionPackages', 'Partners', 'VendorManagers','VendorManagers.Users','Invoices']
        ]);//print_r( $vendor['coupon']->title );exit;
        $this->set('vendor', $vendor);
    }
    public function editVendor($id = null) {
        $subscription_payment_update    =   false;
        $vendor = $this->Vendors->get($id, [
                'contain' => []
        ]);
        if ($this->request->is(['post', 'put'])) {
            if($vendor->subscription_package_id != $this->request->data['subscription_package_id']){
                //echo "Package Cjanged!";exit;
                 $subscription_payment_update    = true;
            }
            if($vendor->coupon_id != $this->request->data['coupon_id']){
                //echo "Coupon Cjanged!";exit;
                 $subscription_payment_update    = true;
            }
            /*
                * Section for logo upload
                */

               $filename = null;
               $allwed_types = array('image/jpg','image/jpeg','image/png','image/gif');
               if (!empty($this->request->data['logo_url']['tmp_name']) && $this->request->data['logo_url']['error'] == 0 && in_array($this->request->data['logo_url']['type'],$allwed_types)) {
                   // Strip path information

                    /*
                   $filename = time().basename($this->request->data['logo_url']['name']); 

                   if($this->Imagecreator->uploadImageFile($filename,$this->request->data['logo_url']['name'],$this->request->data['logo_url']['tmp_name'],$this->request->data['logo_url']['type'],WWW_ROOT  .'img' . DS . 'logos' . DS . $filename,$this->request->data['logo_url']['size'],$this->portal_settings['logo_width'])){
                       $this->request->data['logo_url'] = $filename;
                   }else{
                       unset($this->request->data['logo_url']);
                   }
                    */

                    $file_ext = substr(strrchr($this->request->data['logo_url']['name'],'.'),1);
                    $source_ext = substr(strrchr($vendor->logo_path,'.'),1);
                    $this->Imagecreator->formatImage($this->request->data['logo_url']['name'],$this->request->data['logo_url']['tmp_name'],$this->portal_settings['logo_width']);
                    if($file_ext==$source_ext)
                    {
                        $this->Opencloud->updateObject($vendor->logo_path,$this->request->data['logo_url']['tmp_name']);
                        unset($this->request->data['logo_url']);
                    }
                    else
                    {
                        $newfilepath = 'vendors/' . $id . '/vendorlogo.' . $file_ext;
                        if($vendor->logo_path!='')
                            $this->Opencloud->replaceObject($vendor->logo_path,$newfilepath,$this->request->data['logo_url']['tmp_name']);
                        else
                            $this->Opencloud->addObject($newfilepath,$this->request->data['logo_url']['tmp_name']);
                        
                        $this->request->data['logo_url'] = $this->Opencloud->getobjecturl($newfilepath);
                        $this->request->data['logo_path'] = $newfilepath;

                    }


               }else{
                   if(isset($this->request->data['logo_url'])){
                       unset($this->request->data['logo_url']);
                   } 
               }
               
               /*
                * End of section to upload logo
                */
            $vendor = $this->Vendors->patchEntity($vendor, $this->request->data);
            if ($this->Vendors->save($vendor)) {
                    $this->Flash->success('The vendor has been saved.');
                    if( true == $subscription_payment_update){
                        $this->__upgradePaymentPackage($id);
                    }
                    return $this->redirect(['action' => 'vendors']);
            } else {
                    $this->Flash->error('The vendor could not be saved. Please, try again.');
            }
        }
        $copuery = $this->Coupons->find()
                        ->order(['title' => 'ASC']);
        $copuery->select(['id','title']);
         
        foreach ($copuery as $row) {
             $coupon_list[$row->id] =   $row->title;
        }
        $pkuery = $this->SubscriptionPackages->find()
                        ->where(['status !='=> 'C'])
                        ->order(['name' => 'ASC']);
        $pkuery->select(['id','name']);
         
        foreach ($pkuery as $pk) {
             $pkg_list[$pk->id] =   $pk->name;
        }
        //$coupon_list[''] =   'Select Coupon';
        $this->set('package_list',$pkg_list);
        $this->set('coupon_list',$coupon_list);
        $this->set('country_list',$this->country_list);
        $this->set(compact('vendor'));
    }
    function __upgradePaymentPackage($id=null){
       
        /*
         * Section to calculate new amount....
         */
        $vendor = $this->Vendors->find()
                        ->hydrate(false)
                        ->select(['Vendors.id', 'Vendors.company_name','Vendors.subscription_type','u.email','u.first_name','u.last_name','s.name','s.annual_price','s.monthly_price','s.duration','c.type','c.discount'])
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
                                    'm.primary_manager' => 'Y',
                                    'Vendors.id = m.vendor_id'
                                ],
                            ],
                            'u' => [
                                'table' => 'users',
                                'type' => 'INNER',
                                'conditions' => 'u.id = m.user_id',
                            ],
                            's' => [
                                'table' => 'subscription_packages',
                                'type' => 'INNER',
                                'conditions' => 'Vendors.subscription_package_id = s.id',
                            ]
                        ],['m.primary_manager' => 'string','u.id' => 'integer','m.user_id' => 'integer'])
                        ->where(['Vendors.id' => $id])->first();
        
        if($vendor['subscription_type'] == 'monthly'){
            $vendor['amount']   =   $vendor['s']['monthly_price'];
            $vendor['length']   =   $vendor['s']['duration'];
            $vendor['unit']     =   'months';
        }else{
            $vendor['amount']   =   $vendor['s']['annual_price'];
            $vendor['length']   =   $vendor['s']['duration'] / 12;
            $vendor['unit']     =   'years';
        }
        if(isset($vendor['c']['discount']) && (int)$vendor['c']['discount'] > 0){
           if($vendor['c']['type'] == 'Perc'){
               $discount_amount =   $vendor['amount'] * ($vendor['c']['discount'] / 100);
           }else{
               $discount_amount = $vendor['c']['discount'];
           }
        }else{
            $discount_amount = 0;
        }
        $newval['amount']   =   round($vendor['amount'] - $discount_amount,2);
        $spdet =  $this->VendorPayments->find()
                                        ->hydrate(false)
                                        ->where(['vendor_id' => $id,'status' => 'Active'])
                                        ->first();
       $newval['subscriptionId']    =   $spdet['subscriptionid'];
       $newval['reference']         =   $spdet['reference'];
       $this->Net->UpdateSubscriptionAmount($newval);
       
    }
    /**
    * Delete method
    *
    * @param string $id
    * @return void
    * @throws NotFoundException
    */
	public function deleteVendor($id = null) {
            $this->loadModel('Partners');
            $vendor = $this->Vendors->get($id, [
                'contain' => ['VendorPayments','Partners','VendorManagers','VendorManagers.Users','Partners.PartnerManagers','Partners.PartnerManagers.Users']
        ]); 
            
            
            $this->request->allowMethod('post', 'delete');
            
            /* Delete OpenCloud Logo File */
            if($vendor->logo_path!='')
                $this->Opencloud->deleteObject($vendor->logo_path);



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
            return $this->redirect(['action' => 'vendors']);
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
        
        public function addVendorManager($vid) {
           
            if(isset($this->request->data['email'])){
                $this->request->data['username']   =   $this->request->data['email'];
            }
            
            $user = $this->Users->newEntity($this->request->data);
            if ($this->request->is('post')) {
                if($this->request->data['conf_password'] == $this->request->data['password']){
                    if ($uresult = $this->Users->save($user)) {
                        $this->request->data['vendor_manager']['user_id'] =   $uresult->id;
                        $this->request->data['vendor_manager']['status'] = 'Y';
                       if($this->__addVmanager($this->request->data['vendor_manager'])){
                           $udata  =   $this->request->data;
                           $this->Prmsemails->userSignupemail($udata);
                           $this->Flash->success(__('Vendor Manager has been added successfully.'));
                           return $this->redirect(['action' => 'viewVendor',$vid]);
                       }

                    }
                     $this->Flash->error(__('Unable to add the Vendor Manager.'));
                }else{
                     $this->Flash->error(__('Mismatch between passwords.'));
                }
               
            }
            $this->set('user', $user);
            $this->set('vendor_id', $vid);
	}
        public function editVendorManager($id=null,$vid=null) {
            $user = $this->Users->get($id, [
                    'contain' => []
            ]);
            if ($this->request->is(['post', 'put'])) {
                    $user = $this->Users->patchEntity($user, $this->request->data);
                    if ($this->Users->save($user)) {
                            $this->Flash->success('The vendor manager has been saved.');
                          if($vid != null){
                              return $this->redirect(['action' => 'viewVendor',$vid]);
                          }else{
                            return $this->redirect(['action' => 'index']);
                          }
                    } else {
                            $this->Flash->error('The vendor manager could not be saved. Please, try again.');
                    }
            }
            
            $this->set('user', $user);
            $this->set('vendor_id', $vid);
	}
        function __addVmanager($vmgr){
            $manager = $this->VendorManagers->newEntity($vmgr);
             if($this->VendorManagers->save($manager)){
                 return true;
             }
             return false;
        }
        /**
        * Delete method
        *
        * @param string $id
        * @return void
        * @throws NotFoundException
        */
               public function changePrimaryVmanager($id = null,$vid=null) {
                    $this->request->allowMethod('post', 'put');
                    $this->VendorManagers->updateAll(['primary_manager' => 'N'], ['vendor_id' => $vid]);
                    $this->VendorManagers->updateAll(['primary_manager' => 'Y'], ['id' => $id]);
                    $this->Flash->success(__('Primary Manager has been changed successfully.'));
                    return $this->redirect(['action' => 'viewVendor',$vid]);
               }
        public function deleteVendorManager($id=null,$vid=null){
            $this->request->allowMethod('post', 'delete');
            $vendormanager = $this->VendorManagers->get($id); 
            if($vendormanager->primary_manager == 'Y'){
               $this->Flash->error(__('Primary Vendor Manager can not be deleted.'));
                
            }else{
                if($this->__delete_user($vendormanager->user_id)){
                    $this->Flash->success(__('Vendor Manager has been deleted successfully.'));
                }else{
                    $this->Flash->error(__('Couldn\'t delete the vendor manager.'));
                }
                
            }
            return $this->redirect(['action' => 'viewVendor',$vid]);
            
        }
        public function changeVendorStatus($id=null,$status= 'Y'){
            if($id > 0){
                $this->request->allowMethod('post', 'put');
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
                $this->Users->updateAll(['status' => $status], ['id IN' => $vusers]);
               
                
            }
             return true;
        }
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
        /*
         * Functin to update vendor credit card details....
         */
        public function editcard($vid = 0) {
            $this->loadModel('VendorPayments');
            if($vid > 0){
                $id = $vid;
                $vpments    =  $this->VendorPayments->find()
                                                    ->where(['VendorPayments.vendor_id' => $id,'status' => 'active'])->first();
                 $vendor = $this->Vendors->find()
                            ->hydrate(false)
                            ->select(['Vendors.id', 'Vendors.company_name','Vendors.subscription_type','Vendors.address','Vendors.city','Vendors.state','Vendors.postalcode','Vendors.country','Vendors.phone','Vendors.fax','u.email','u.first_name','u.last_name','s.name','s.annual_price','s.monthly_price','s.duration'])
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
                                        'm.primary_manager' => 'Y',
                                        'Vendors.id = m.vendor_id'
                                    ],
                                ],
                                'u' => [
                                    'table' => 'users',
                                    'type' => 'INNER',
                                    'conditions' => 'u.id = m.user_id',
                                ],
                                's' => [
                                    'table' => 'subscription_packages',
                                    'type' => 'INNER',
                                    'conditions' => 'Vendors.subscription_package_id = s.id',
                                ]
                            ],['m.primary_manager' => 'string','u.id' => 'integer','m.user_id' => 'integer'])
                            ->where(['Vendors.id' => $id])->first();

                $vendor['country_list']    =   $this->country_list;


                if(isset($vpments->subscriptionid) && ($vpments->subscriptionid > 0)){
                if ($this->request->is(['post', 'put'])) {
                     //print_r($this->request->data);exit;
                        $this->request->data['expirationDate']   =  implode('-',$this->request->data['expirationDate']);
                        if($ret =$this->Net->UpdateSubscriptionCardDetails($this->request->data)){
                           //print_r($ret);exit;
                           if($ret['resultCode'] == 'Error'){
                               $this->Flash->error($ret['text']. ' For more assistance please contact Customer Support');
                           }elseif($ret['code'] == 'Ok' || $ret['resultCode'] == 'Ok' ){
                               $this->Flash->success(' Card details have been updated');
                               $cmret=  $this->Authorizecim->updatePaymentProfile($this->request->data);
                              // print_r($cmret);exit;
                               return $this->redirect(['action' => 'vendors']);
                           }

                           $this->Flash->error(__('Card Update Error:'. $ret [text]));
                        }

                    }
                }else{
                    $this->Flash->error(__('Couldn\'t find an active subscription'));
                    return $this->redirect(['action' => 'vendors']);
                }
                $this->set('vendor', $vendor);
                $this->set('subscriptionid', $vpments->subscriptionid);
                $this->set('customerProfileId', $vpments->customerProfileId);
                $this->set('customerPaymentProfileId', $vpments->customerPaymentProfileId);
            }else{
                $this->Flash->error(__('Couldn\'t find an active subscription'));
                    return $this->redirect(['action' => 'vendors']);
            }
             $ver =   $this->Vendors->get($id);
         $this->set('ver', $ver);
        }


        // Export templlate
        public function getpartnerimportcsvtemplate() {
                
                //$template_array = array('0' => 'test', '1' => 'fmndskl', '2' => 'fdaf');
                $i=0;
                
                $template_array[0][0]       =       'Company Name';
                $template_array[0][1]       =       'Email Address';
                $template_array[0][2]       =       'Phone';
                $template_array[0][3]       =       'Website';
                $template_array[0][4]       =       'Twitter';
                $template_array[0][5]       =       'Facebook';
                $template_array[0][6]       =       'Linkedin';
                $template_array[0][7]       =       'Address';
                $template_array[0][8]       =       'City';
                $template_array[0][9]       =       'County/State';
                $template_array[0][10]      =       'Country';
                $template_array[0][11]      =       'Zip/Postal Code';
                $template_array[0][12]      =       'Primary Contact Firstname';
                $template_array[0][13]      =       'Lastname';
                $template_array[0][14]      =       'Job Title';
                $template_array[0][15]      =       'Title (Mr/Mrs etc)';
                $template_array[0][16]      =       'Phone'; 
                //echo var_dump($template_array);exit;
                    
                $this->Filemanagement->getExportcsv($template_array, 'import_partner_template.csv', ',');
                echo 'export complete';
                exit;
                            
        }

        public function getexportcsvtemplate() {
                
                //$template_array = array('0' => 'test', '1' => 'fmndskl', '2' => 'fdaf');
                $i=0;
                
                $template_array[0][0]       =       '*Company Name';
                $template_array[0][1]       =       '*Email Address';
                $template_array[0][2]       =       'Phone';
                $template_array[0][3]       =       'Website';
                $template_array[0][4]       =       'Twitter';
                $template_array[0][5]       =       'Facebook';
                $template_array[0][6]       =       'Linkedin';
                $template_array[0][7]       =       '*Address Line 1';
                $template_array[0][8]       =       '*City';
                $template_array[0][9]       =       'County/State';
                $template_array[0][10]      =       '*Country';
                $template_array[0][11]      =       '*Zip/Postal Code';
                $template_array[0][12]      =       '*Primary Contact Firstname';
                $template_array[0][13]      =       '*Lastname';                
                $template_array[0][14]      =       'Job Title';
                $template_array[0][15]      =       'Title (Mr/Mrs etc)';
                $template_array[0][16]      =       'Phone'; 
                //echo var_dump($template_array);exit;
                    
                $this->Filemanagement->getExportcsv($template_array, 'import_partner_template.csv', ',');
                echo 'export complete';
                exit;
                            
        }

        public function importpartners($vendorID=null) {
           
           //get data from users table to check emails against emails about to be input via csv
            if($this->request->is(['post']))
            {
                $this->loadModel('Partners');
                $this->loadModel('PartnerManagers');

                $allowed_types = array('"text/x-comma-separated-values"','text/x-comma-separated-values','text/csv','application/csv','application/excel','application/vnd.ms-excel','application/vnd.msexcel');
                if(!empty($this->request->data['partnerscsv']['tmp_name']) && $this->request->data['partnerscsv']['error'] == 0 && in_array(strtolower($this->request->data['partnerscsv']['type']),$allowed_types))
                {

                   $users_array = array();
                   $existing = $this->Users->find('all');
                   foreach ($existing as $row) {
                       array_push($users_array, $row->email);
                   }
                   
                   $options = array(
                   'length' => 0,
                    'delimiter' => ',',
                    'enclosure' => '"',
                    'escape' => '\\',
                    'headers' => true
                    );

                    $this->data = $this->Filemanagement->import($this->request->data['partnerscsv']['tmp_name'], array('company_name', 'email', 'phone', 'website', 'twitter', 'facebook', 'linkedin', 'address', 'city', 'state', 'country', 'postal_code', 'first_name', 'last_name', 'job_title', 'title', 'phone'),$options);

                    $partners_array = array();
                    $userdata_array = array();
                    $partnerManagerdata = array();
                    $outerarray = array();

                    $skiplist = array();

                    $i=-1;
                    $partnersaved = false;
                    $usersaved = false;
                    $partnermanagersaved = false;

                    // Determine allowable number of partners
                    $vendor = $this->Vendors->get($vendorID, ['contain'=>['SubscriptionPackages','Partners']]);
                    $no_partners_allowed = $vendor->subscription_package->no_partners;
                    $current_no_partners = $vendor->has('partners') ? count($vendor->partners) : 0;
                    $no_partners_toimport = count($this->data);
                    $overload = false;                    
                    if($no_partners_allowed<($current_no_partners + $no_partners_toimport))
                        $overload = true;
                    else
                    foreach ($this->data as $row) {
                        $i++;
                        //skip headings
                        if ($i==0) {continue;}
                        //skip blanks rows (company name is required, so if empty - whole row should be empty)
                        if ($row['']['company_name'] == '') { continue; }
                        
                        $partners_array['company_name']         =       $row['']['company_name'];
                        $partners_array['email']                =       $row['']['email'];
                        $partners_array['phone']                =       $row['']['phone'];
                        $partners_array['website']              =       $row['']['website'];
                        $partners_array['twitter']              =       $row['']['twitter'];
                        $partners_array['facebook']             =       $row['']['facebook'];
                        $partners_array['linkedin']             =       $row['']['linkedin'];
                        $partners_array['address']              =       $row['']['address'];
                        $partners_array['city']                 =       $row['']['city'];
                        $partners_array['state']                =       $row['']['state'];
                        $partners_array['country']              =       $row['']['country'];
                        $partners_array['postal_code']          =       $row['']['postal_code'];
                        $partners_array['vendor_manager_id']    =       $vendorID;
                        
                        //set random password
                        $rchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
                        $rpassword = substr( str_shuffle( $rchars ), 0, 8 );
                        
                        $userdata_array['username']         =       $row['']['email'];
                        $userdata_array['email']            =       $row['']['email'];
                        $userdata_array['password']         =       $rpassword;
                        $userdata_array['status']           =       'Y';
                        $userdata_array['role']             =       'partner';
                        $userdata_array['first_name']       =       $row['']['first_name'];
                        $userdata_array['last_name']        =       $row['']['last_name'];
                        $userdata_array['job_title']        =       $row['']['job_title'];
                        $userdata_array['title']            =       $row['']['title'];
                        $userdata_array['phone']            =       $row['']['phone'];
                                     
                        
                        
                        //don't partners from csv whose email address is already being used, 
                        //add email to array to print to user upon completion of csv import
                        if (in_array($row['']['email'], $users_array)) {
                            array_push($skiplist, $row['']['email']);
                            continue;
                        }               
                        //append http:// to website addresses that do not already have a http or https prefix
                        $urlfromfile = $row['']['website'];
                        
                        if(substr($urlfromfile, 0, 7) != "http://" && substr($urlfromfile, 0,8) != 'https://') {
                            $partners_array['website'] = 'http://' . $urlfromfile;
                        }
            
                        $partners = $this->Partners->newEntity(array_merge($partners_array,['vendor_id'=>$vendorID]));
                        
                        if ($this->Partners->save($partners))
                        {
                            
                            // do something after save
                            $partner_id = $partners->id;
                            $partnersaved = true;
                            
                        }
                                        
                        $users = $this->Users->newEntity($userdata_array);
            
                        if ($this->Users->save($users))
                        {   
                            $usersaved = true;
                            $user_id = $users->id;
                            //$this->Prmsemails->userSignupemail($userdata_array);
                        }
                        
                        $partnerManagerdata['partner_id']       =       $partner_id;
                        $partnerManagerdata['user_id']          =       $user_id;
                        $partnerManagerdata['status']           =       'Y';
                        $partnerManagerdata['primary_contact']  =       'Y';
                        
                        $partnermanagers = $this->PartnerManagers->newEntity($partnerManagerdata);
                        
                        if ($this->PartnerManagers->save($partnermanagers)) {
                            $partnermanagersaved = true;
                        }

                    }

                    if ($partnersaved == true && $usersaved == true && $partnermanagersaved == true) {
                        
                        if (!empty($skiplist)) {
                            $message    =   "The import completed, but some partners could not be added as the email address/addresses used already exist(s) and is associated with a user - ";
                            foreach ($skiplist as $row) {
                                $message.=  $row . ", ";
                            }           
                        }
                        else {
                            $message = 'The import completed successfully.';
                        }
                        $this->Flash->success($message);
                        return $this->redirect(array('controller' => 'admins', 'action' => 'viewVendor/'.$vendorID));
                    }
                    else {
                        if($overload==true)
                            $this->Flash->error('You are only allowed to add '.($no_partners_allowed - $current_no_partners) . ' partners. Please remove some data from your csv sheet.');
                        else
                            $this->Flash->error('There was a problem with the upload, either some required fields were left blank or the email address(es) given are already in use by another user');

                        return $this->redirect(array('controller' => 'admins', 'action' => 'viewVendor/'.$vendorID));
                    }
                    
                }
                else
                    $this->Flash->error('Please make sure to select a valid csv file');

                }
            
        }

        
}