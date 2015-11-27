<?php
namespace App\Controller;
use App\Controller\AppController;
use Authorizenet\AuthorizeNetARB;
use Authorizenet\AuthorizeNet_Subscription;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Network\Email\Email;
use App\Model\Entity\Partner;
use App\Model\Entity\User;
use App\Model\Entity\PartnerManager;

/**
 * Vendors Controller
 *
 * @property App\Model\Table\VendorsTable $Vendors
 */
 
class VendorsController extends AppController {
  public $components = ['Imagecreator','Opencloud'];
  public function beforeFilter(Event $event) {
    parent::beforeFilter($event);
    // Allow users to register and logout.
    $this->Auth->allow(['buypackage','primarycontact','checkout','payment']);
    $this->loadModel('VendorManagers');
    $this->loadModel('Users');
    $this->loadModel('Partners');
    $this->loadModel('PartnerManagers');
    $this->loadModel('PartnerCampaigns');
    $this->loadModel('Financialquarters');
    $this->loadModel('Campaigns');
    $this->loadModel('CampaignPartnerMailinglistDeals');
    $this->loadModel('Folders');
    $this->loadModel('Resources');
    $this->loadModel('PartnerGroupMembers');
	$this->loadModel('VendorSortablePosition');
    $this->layout = 'admin';
    $this->set('country_list',$this->country_list);
  }
  public function isAuthorized($user) {
    if(isset($user['status']) && $user['status'] === 'S') {
      $this->Flash->error(__('Your account is suspended, please contact Customer Support'));
      return $this->redirect(['controller' => 'Users','action' => 'vendorSuspended']);
    } elseif(isset($user['status']) && $user['status'] === 'B') {
      $this->Flash->error(__('Your account is blocked, please contact Customer Support'));
      return $this->redirect(['controller' => 'Users','action' => 'vendorBlocked']);
    } elseif(isset($user['status']) && $user['status'] === 'D') {
      $this->Flash->error(__('Your account is inactive, please contact Customer Support'));
      return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);
    } elseif(isset($user['status']) && $user['status'] === 'P') {
      $this->Flash->error(__('Your account is inactive, please contact Customer Support'));
      return $this->redirect(['controller' => 'Users','action' => 'vendorInactive']);
    } elseif(isset($user['role']) && $user['role'] === 'vendor') {
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
		
		$id =   $this->Auth->user('vendor_id');
		if ($this->request->is(['ajax'])){
			$data = $this->request->data;
			
			foreach($data as $position){
				$pos =  implode(",",$position);
				$update_pos = $this->VendorSortablePosition->query();
					$update_pos->update()
					->set(['position' => $pos])
					->where(['vendor_id' => $id])
					->execute();
			}
			exit();
		}
		/**Sortable position **/
		$sort_position = $this->VendorSortablePosition->find()
			->where(['vendor_id'=>$id])
			->first();
		
		if($id != $sort_position->vendor_id){ // insert position
			$insert_position = $this->VendorSortablePosition->query();
			$insert_position->insert(['vendor_id','position'])
				->values([
					'vendor_id'=>$id,
					'position' => '1,2,3,4,5,6,7,8,9'
				])
				->execute();
		} 
		/**End Sortable position **/
		
		
		$financial_m = $this->Auth->user('financial_quarter_start_month'); //$admn['User']['financial_quarter_start_month']-1;
		$this->set('admin', $this->paginate($this->Vendors));
		$campaignQ = $this->Campaigns
			->find('all')
			->contain(['Financialquarters','CampaignPartnerMailinglists','CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
						return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
					}])
			->where(['Campaigns.vendor_id'=>$id,'NOW() BETWEEN Financialquarters.startdate AND  Financialquarters.enddate','Campaigns.status'=>'Y']);
		
		global $financialquarter_current;
		$financialquarter_current = $this->Financialquarters->find()
		    ->select(['id'])
			->where(['vendor_id'=>$id,'NOW() BETWEEN startdate AND enddate'])
			->first();

		/* Get Current Quarter Year */
		$quarter = $this->Financialquarters->get($financialquarter_current->id);
		preg_match('|\((.+?)\)|',$quarter->quartertitle,$match);
		$quarteryear = $match[1];
		
		/* YTD */
		$financialquarter_current_year = $this->Financialquarters->find()
		    ->select(['id','quartertitle','startdate','enddate'])
			->where(['vendor_id'=>$id, 'quartertitle LIKE'=>'%('.$quarteryear.')' ]) //, '(MONTH(NOW()) > MONTH(startdate) OR MONTH(startdate) < '.$financial_m.') AND \''.date('Y-m-d h:i:s').'\' > startdate'
			->order(['quartertitle'=>'ASC'])
			->toArray();
			
		/* YTD last year */
		$financialquarter_last_year = $this->Financialquarters->find()
		    ->select(['id','quartertitle','startdate','enddate'])
			->where(['vendor_id'=>$id, 'quartertitle LIKE'=>'%('.($quarteryear-1).')']) //, '(MONTH(NOW()) > MONTH(startdate) OR MONTH(startdate) < '.$financial_m.') AND \''.date('Y-m-d h:i:s',strtotime((date('Y')-1).'-'.date('m').'-'.date('d').' '.date('h').':'.date('i').':'.date('s'))).'\' > startdate'
			->order(['quartertitle'=>'ASC'])
			->toArray();

		
		global $financialquarters_current_year;
		$financialquarters_current_year = '';
		foreach($financialquarter_current_year as $row)
		$financialquarters_current_year[] = $row['id'];
		$financialquarters_current_year = implode(',',$financialquarters_current_year);
		$financialquarters_last_year = '';
		foreach($financialquarter_last_year as $row)
		$financialquarters_last_year = implode(',',$financialquarters_last_year);

		/* Funding approved YTD current year */
		if($financialquarters_current_year!='')
		$funding_approved_current = $this->Businesplans
			->find('all')
			->where(['Businesplans.vendor_id'=>$id,'Businesplans.financialquarter_id IN('.$financialquarters_current_year.')']);//'YEAR(Businesplans.created_on) = YEAR(NOW())']); 
		else
			$funding_approved_current = array();
		
		/* Funding approved YTD previous year */
		if($financialquarters_last_year!='')
		$funding_approved_last = $this->Businesplans
			->find('all')
			->where(['Businesplans.vendor_id'=>$id,'Businesplans.financialquarter_id IN('.$financialquarters_last_year.')']);//'YEAR(Businesplans.created_on) = YEAR(NOW())-1']); 
		else
			$funding_approved_last = array();
		
		/* Funding approved by partner */
		$funding_approved_partner = $this->Partners
			->find('all')
			->contain(['Businesplans'=> function ($q) {
				global $financialquarters_current_year;
				return $q->where(['Businesplans.status'=>'Approved','Businesplans.financialquarter_id IN('.$financialquarters_current_year.')']); //'YEAR(Businesplans.created_on) = YEAR(NOW())']);
			}])
			->where(['Partners.vendor_id'=>$id]);

		/* Funding approved by partner quarter */
		$funding_approved_partnerq = $this->Partners
			->find('all')
			->contain(['Businesplans'=> function ($q) {
				global $financialquarter_current;
				return $q->where(['Businesplans.status'=>'Approved','Businesplans.financialquarter_id IN('.$financialquarter_current->id.')']); //'YEAR(Businesplans.created_on) = YEAR(NOW())']);
			}])
			->where(['Partners.vendor_id'=>$id])
			->toArray();
		
		$partners = $this->Partners->find('all')->where(['vendor_id'=>$id]);
			
		$partners_territory = $partners
			->select(['id','country','state','count'=>$partners->func()->count('id')])
			->group(['state','country'])
			->order(['country'=>'ASC','city'=>'ASC']);
		
		$partners_list = $this->Partners
			->find('all')
			->select(['Partners.id','Partners.company_name'])
			->contain(['PartnerCampaigns.Campaigns.FinancialQuarters','PartnerManagers.CampaignPartnerMailinglistDeals'=> function ($q) {
					return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
				}])
			->order(['Partners.company_name'=>'ASC'])
			->where(['Partners.vendor_id'=>$id]);

		/* Top Deals Section */
		$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals
            ->find('all')
            ->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
            ->order(['CampaignPartnerMailinglistDeals.deal_value'=>'DESC'])
            ->where(['Partners.vendor_id'=>$id,'CampaignPartnerMailinglistDeals.status'=>'Y'])
            ->limit(5);
		
		$partner_lowest = NULL;
		$partner_lowest_value = 0;
		$partner_highest = NULL;
		$partner_highest_value = 0;
		$partners_registered = array();
		foreach($partners_list as $row)
		{
			//print_r($row);
			$deals_count = 0;
			$deals_value = 0;
			foreach($row->partner_managers as $partner_manager)
			{
				$deals_count += count($partner_manager->campaign_partner_mailinglist_deals);
				foreach($partner_manager->campaign_partner_mailinglist_deals as $deal)
					$deals_value += $deal->deal_value;
			}
			$campaigns_completed = 0;
			$campaigns_active = 0;
			$expected_revenue = 0;
			$campaign_sendlimit = 0;
			$campaign_total = 0.0001;
			foreach($row->partner_campaigns as $partner_campaign)
			{
				$campaign = $partner_campaign->campaign;
				$campaign_sendlimit += $campaign->send_limit;
				if($campaign->status=='Y')
					$campaigns_completed++;
				
				if($partner_campaign->status=='A')
					$campaigns_active++;
				
				$expected_revenue += $campaign->sales_value;
				$campaign_total++;
			}
			//Get subscription package details
			$vendor = $this->Vendors->get($id,[
				'contain'=>['SubscriptionPackages']
			]);
			$package_limit = $vendor->subscription_package->no_emails;
			$package_monthly = $vendor->subscription_package->monthly_price;
			$roi=0;
			// calculate ROI
			$return = $deals_value;
			$costpersend = $package_monthly / $package_limit;
			$investment =  ($campaign_sendlimit * $costpersend) + ($package_monthly / $campaign_total);
			if ($investment == 0) { $investment = 0.0001; }
			$roi = ($return - $investment) / $investment;
			$roi = ($roi==''?0:$roi);
			//get highest performing partner
			if($roi >= $partner_highest_value) {
				$partner_highest = $row->id;
				$partner_highest_value = $roi;
			}
			//get lowest performing partner
			if($roi <= $partner_lowest_value) {
				$partner_lowest = $row->id;
				$partner_lowest_value = $roi;
			}

			$partners_registered[$row->id] = array('id'=>$row->id,'partner_name'=>$row->company_name,'deals_count'=>$deals_count,'deals_value'=>$deals_value,'roi'=>$roi,'campaigns_completed'=>$campaigns_completed,'campaigns_active'=>$campaigns_active,'expected_revenue'=>$expected_revenue);
		}	

		usort($partners_registered, array($this,"__cmp_partner_asc"));
		
		$partners_registered_highest = $partners_registered;
		$partners_registered_lowest = $partners_registered;
		usort($partners_registered_highest, array($this,"__cmp_desc"));
		usort($partners_registered_lowest, array($this,"__cmp_asc"));
		
		//ROI values for the quarterly report chart
		$financialquarters = array();
		for($quarter=1;$quarter<=4;$quarter++)
		{
			$fq = $this->Campaigns
					->find('all')
					->contain(['Financialquarters','CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
						return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
					}])
					->where(['Financialquarters.quartertitle LIKE'=>'Q'.$quarter.' ('.$quarteryear.')','Campaigns.vendor_id'=>$id,'Campaigns.financialquarter_id=Financialquarters.id']);

			$financialquarters[$quarter]=0;
			$deals_value = 0;
			foreach($fq as $row)
			{				
				foreach($row->campaign_partner_mailinglists as $ml)
					foreach($ml->campaign_partner_mailinglist_deals as $d)
						$deals_value += $d->deal_value;				
			}
			$financialquarters[$quarter] += $deals_value;
		}
		
		$this->set(compact('campaignQ','partners_territory','partners_registered','partners_registered_highest','partners_registered_lowest','partner_lowest','partner_highest','financialquarters','financialquarter_current_year','financialquarter_last_year','funding_approved_partner','funding_approved_partnerq','funding_approved_current','funding_approved_last','campaignPartnerMailinglistDeal','sort_position'));
	}
	
	function __cmp_partner_asc($a, $b) {
		if ($a['partner_name'] == $b['partner_name']) {
			return 0;
		}
		return ($b['partner_name'] > $a['partner_name']) ? -1 : 1;
	}
	
	function __cmp_asc($a, $b) {
		if ($a['deals_value'] == $b['deals_value']) {
			return 0;
		}
		return ($b['deals_value'] > $a['deals_value']) ? -1 : 1;
	}
	
	function __cmp_desc($a, $b) {
		if ($a['deals_value'] == $b['deals_value']) {
			return 0;
		}
		return ($b['deals_value'] < $a['deals_value']) ? -1 : 1;
	}
/**
 * Export method
 *
 * @return void
 */

 		public function export() {
	 		$id =   $this->Auth->user('vendor_id');
	 		$financial_m = $this->Auth->user('financial_quarter_start_month'); //$admn['User']['financial_quarter_start_month']-1;
	 		
	 		global $financialquarter_current;
	 		$financialquarter_current = $this->Financialquarters->find()
		    ->select(['id'])
			->where(['vendor_id'=>$id, 'NOW() BETWEEN startdate AND  enddate'])
			->first();

		/* Get Current Quarter Year */
		$quarter = $this->Financialquarters->get($financialquarter_current->id);
		preg_match('|\((.+?)\)|',$quarter->quartertitle,$match);
		$quarteryear = $match[1];
		/* end */

		
		//YTD
		$financialquarter_current_year = $this->Financialquarters->find()
		    ->select(['id','quartertitle','startdate','enddate'])
			->where(['vendor_id'=>$id, 'quartertitle LIKE'=>'%('.$quarteryear.')' ]) //, '(MONTH(NOW()) > MONTH(startdate) OR MONTH(startdate) < '.$financial_m.') AND \''.date('Y-m-d h:i:s').'\' > startdate'
			->order(['quartertitle'=>'ASC'])
			->toArray();
		//YTD last year
		$financialquarter_last_year = $this->Financialquarters->find()
		    ->select(['id','quartertitle','startdate','enddate'])
			->where(['vendor_id'=>$id, 'quartertitle LIKE'=>'%('.($quarteryear-1).')']) //, '(MONTH(NOW()) > MONTH(startdate) OR MONTH(startdate) < '.$financial_m.') AND \''.date('Y-m-d h:i:s',strtotime((date('Y')-1).'-'.date('m').'-'.date('d').' '.date('h').':'.date('i').':'.date('s'))).'\' > startdate'
			->order(['quartertitle'=>'ASC'])
			->toArray();

	 		
	 		global $financialquarters_current_year;
	 		$financialquarters_current_year = array();
	 		foreach($financialquarter_current_year as $row)
			$financialquarters_current_year[] = $row['id'];
			$financialquarters_current_year = implode(',',$financialquarters_current_year);

			$financialquarters_last_year = array();
			foreach($financialquarter_last_year as $row)
			$financialquarters_last_year[] = $row['id'];
			$financialquarters_last_year = implode(',',$financialquarters_last_year);
			
			
	 		
	 		
	 		//$this->set('admin', $this->paginate($this->Vendors));
	 		$campaignQ = $this->Campaigns
				->find('all')
				->contain(['FinancialQuarters','CampaignPartnerMailinglists','CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
						return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
					}])
					->where(['Campaigns.vendor_id'=>$id,'NOW() BETWEEN Financialquarters.startdate AND  Financialquarters.enddate','Campaigns.status'=>'Y']);
	 		
	 		$campaignQuarter = $campaignQ->toArray();
	 		$i=0;
	 		$campaigns_active_complete_array = array();
	 			$i++;
	 		$campaigns_active_complete_array[$i][$i]		=		"Campaigns Active/Complete in " . $campaignQuarter[0]['Financialquarters']['quartertitle'] .  "\n";
	 			$i++;
	 		$campaigns_active_complete_array[$i]['campaign_name']	=	'Campaign Name';
	 		$campaigns_active_complete_array[$i]['deals']			=	'Deals';
	 		$campaigns_active_complete_array[$i]['deals_value']		=	'Deals Value';
	 			$i++;
	 		
	 		$j = 0;
		 	foreach ($campaignQ as $row) {
			$j++;
		  	$total_deal = 0;
			$deal_count = 0;
				foreach($row->campaign_partner_mailinglists as $row2) {					  		
					if($row2['campaign_partner_mailinglist_deals'][0]['status']=='Y') {
						$total_deal += $row2['campaign_partner_mailinglist_deals'][0]['deal_value'];
						$deal_count++;
					}		  	
				}
				
			$campaigns_active_complete_array[$i]['campaign_name']	=	$row->name;
			$campaigns_active_complete_array[$i]['deals']			=	$deal_count;
			$campaigns_active_complete_array[$i]['deals_value']		=	$total_deal;	
			$i++;
			}
			
			foreach($financialquarter_current_year as $qytd) {
			$quarters[] = $qytd->quartertitle . ' ' . date('M',strtotime($qytd->startdate)) . '-' . date('M',strtotime($qytd->enddate));
			$current_quarter_haystack[] = $qytd->id;
		}
		
		$funding_approved_partner_array = array();
			$i=0;
		//set title
		$funding_approved_partner_array[$i][$i]				=		"\n Funding Approved (by partner) \n";
			$i++;
		$funding_approved_partner_array[$i]['partner']		=		'Partner';
		$funding_approved_partner_array[$i]['qtd']			=		'QTD';
		$funding_approved_partner_array[$i]['ytd']			=		'YTD';
			$i++;
	
		
		
		// Funding approved by partner
		$funding_approved_partner = $this->Partners
			->find('all')
			->contain(['Businesplans'=> function ($q) {
					global $financialquarters_current_year;
					return $q->where(['Businesplans.status'=>'Approved','Businesplans.financialquarter_id IN('.$financialquarters_current_year.')']); //'YEAR(Businesplans.created_on) = YEAR(NOW())']);
				}])
			->where(['Partners.vendor_id'=>$id]);
		// Funding approved by partner quarter
		$funding_approved_partnerq = $this->Partners
			->find('all')
			->contain(['Businesplans'=> function ($q) {
					global $financialquarter_current;
					return $q->where(['Businesplans.status'=>'Approved','Businesplans.financialquarter_id IN('.$financialquarter_current->id.')']); //'YEAR(Businesplans.created_on) = YEAR(NOW())']);
				}])
			->where(['Partners.vendor_id'=>$id])
			->toArray();

			
			//echo var_dump($funding_approved_partner);
			
			$m =0;
							  foreach ($funding_approved_partner as $key=>$row):
							  $m++;
							  
							  // data for QTD
							  $rowq = $funding_approved_partnerq[$key];

							  // total for YTD
							  $total_funding=0;
							  foreach($row->businesplans as $businesplan)
							  	$total_funding += $businesplan->required_amount;

							  // total for QTD
							  $total_fundingq=0;
							  foreach($rowq['businesplans'] as $businesplan)
							  	$total_fundingq += $businesplan['required_amount'];
					
		
		$funding_approved_partner_array[$i]['partner']		=		$row['company_name'];
		$funding_approved_partner_array[$i]['qtd']			=		round($total_fundingq);
		$funding_approved_partner_array[$i]['ytd']			=		round($total_funding);

		//echo 'Name' . ' ' . $row['company_name'] . ' ' . 'Total Funding' . round($total_funding) . ' ' . 'Total Q' . ' ' . round($total_fundingq) . '<br>';
		
		$i++;		  	
		endforeach;
		
		$partners = $this->Partners->find('all')->where(['vendor_id'=>$id]);
			
		$partners_territory = $partners
			->select(['id','country','state','count'=>$partners->func()->count('id')])
			->group(['state','country'])
			->order(['country'=>'ASC','city'=>'ASC']);
		
		$partners_list = $this->Partners
			->find('all')
			->select(['Partners.id','Partners.company_name'])
			->contain(['PartnerCampaigns.Campaigns.FinancialQuarters','PartnerManagers.CampaignPartnerMailinglistDeals'=> function ($q) {
					return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
				}])
			->order(['Partners.company_name'=>'ASC'])
			->where(['Partners.vendor_id'=>$id]);
		
		
		// Top Deals Section
		$campaignPartnerMailinglistDeal = $this->CampaignPartnerMailinglistDeals
            ->find('all')
            ->contain(['PartnerManagers','PartnerManagers.Users','PartnerManagers.Partners','CampaignPartnerMailinglists'])
            ->order(['CampaignPartnerMailinglistDeals.deal_value'=>'DESC'])
            ->where(['Partners.vendor_id'=>$id,'CampaignPartnerMailinglistDeals.status'=>'Y'])
            ->limit(5);
            
        $top5deals_array = array();
        	$i=0;
        $top5deals_array[$i][$i]	=	"\n Top 5 Deals \n";
        	$i++;
        $top5deals_array[$i]['name']			=		'Name';
        $top5deals_array[$i]['company_name']	=		'Company Name';
        $top5deals_array[$i]['deal_value']		=		'Deal Value';
        $top5deals_array[$i]['closure_date']	=		'Closure Date';
        $top5deals_array[$i]['status']			=		'Status';
        	$i++;
            
         foreach ($campaignPartnerMailinglistDeal as $row) {
	       	$top5deals_array[$i]['name']				=		$row['partner_manager']['user']->first_name.' '.$row['partner_manager']['user']->last_name ;
	       	$top5deals_array[$i]['company_name']		=		$row['partner_manager']['partner']->company_name;
	       	$top5deals_array[$i]['deal_value']			=		round($row->deal_value);
	       	$top5deals_array[$i]['closure_date']		=		date('d/m/Y',strtotime($row->closure_date));
	       	if ('Y' == $row->status) {
		       	$top5deals_array[$i]['status']			=		'Closed';
	       	}
	       	else {
		       	$top5deals_array[$i]['status']			=		'Registered';
	       	}
	       	$i++;
         }
		
			$partner_lowest = NULL;
		$partner_lowest_value = 0;
		$partner_highest = NULL;
		$partner_highest_value = 0;
		$partners_registered = array();
		foreach($partners_list as $row)
		{
			//print_r($row);
			$deals_count = 0;
			$deals_value = 0;
			foreach($row->partner_managers as $partner_manager)
			{
				$deals_count += count($partner_manager->campaign_partner_mailinglist_deals);
				foreach($partner_manager->campaign_partner_mailinglist_deals as $deal)
					$deals_value += $deal->deal_value;
			}
			$campaigns_completed = 0;
			$campaigns_active = 0;
			$expected_revenue = 0;
			$campaign_sendlimit = 0;
			$campaign_total = 0;
			foreach($row->partner_campaigns as $partner_campaign)
			{
				$campaign = $partner_campaign->campaign;
				$campaign_sendlimit += $campaign->send_limit;
				if($campaign->status=='Y')
					$campaigns_completed++;
				
				if($partner_campaign->status=='A')
					$campaigns_active++;
				
				$expected_revenue += $campaign->sales_value;
				$campaign_total++;
			}
			//Get subscription package details
			$vendor = $this->Vendors->get($id,[
				'contain'=>['SubscriptionPackages']
			]);
			$package_limit = $vendor->subscription_package->no_emails;
			$package_monthly = $vendor->subscription_package->monthly_price;
			$roi=0;
			// calculate ROI
			$return = $deals_value;
			$costpersend = $package_monthly / $package_limit;
			$investment =  ($campaign_sendlimit * $costpersend) + ($package_monthly / $campaign_total);
			$roi = ($return - $investment) / $investment;
			$roi = ($roi==''?0:$roi);
			//get highest performing partner
			if($roi >= $partner_highest_value) {
				$partner_highest = $row->id;
				$partner_highest_value = $roi;
			}
			//get lowest performing partner
			if($roi <= $partner_lowest_value) {
				$partner_lowest = $row->id;
				$partner_lowest_value = $roi;
			}

			$partners_registered[$row->id] = array('id'=>$row->id,'partner_name'=>$row->company_name,'deals_count'=>$deals_count,'deals_value'=>$deals_value,'roi'=>$roi,'campaigns_completed'=>$campaigns_completed,'campaigns_active'=>$campaigns_active,'expected_revenue'=>$expected_revenue);
		}	

		usort($partners_registered, array($this,"__cmp_partner_asc"));
		
		$partners_registered_highest = $partners_registered;
		$partners_registered_lowest = $partners_registered;
		usort($partners_registered_highest, array($this,"__cmp_desc"));
		usort($partners_registered_lowest, array($this,"__cmp_asc"));			
	
		$partner_location_array = array();
			$i=0;
		$partner_location_array[$i][$i]						=		"\n Partner Locations \n";
			$i++;
		$partner_location_array[$i]['country']				=		'Country';
		$partner_location_array[$i]['county_state']			=		'County/State';
		$partner_location_array[$i]['partner_count']		=		'Number of Partners';
			$i++;	
			
		foreach ($partners_territory as $row) {
			$partner_location_array[$i]['country']			=		$row->country;
			$partner_location_array[$i]['county_state']		=		$row->state;
			$partner_location_array[$i]['partner_count']	=		$row->count;
			$i++;
		}
		
		$partners_array = array();
			$i=0;
		//set the title
		$partners_array[$i][$i]						=		"\n Registered Partners \n";
			$i++;
		$partners_array[$i]['name']					= 	'Partner';
		$partners_array[$i]['campaigns_completed'] 	= 	'Campaigns Completed';
		$partners_array[$i]['deals_closed']			= 	'Deals Closed';
		$partners_array[$i]['deals_value'] 			= 	'Total value of closed deals';
		$partners_array[$i]['roi'] 					= 	'ROI';
		$partners_array[$i]['campaigns_active'] 	= 	'Campaigns Active';
		$partners_array[$i]['est_revenue'] 			= 	'Estimated Revenue';
			$i++;
				
		//echo var_dump($partners_registered);
		foreach ($partners_registered as $row) {
			$partners_array[$i]['name']					= 		$row['partner_name'];
			$partners_array[$i]['campaigns_completed'] 	= 		$row['campaigns_completed'];
			$partners_array[$i]['deals_closed']			= 		$row['deals_count'];
			$partners_array[$i]['deals_value'] 			= 		round($row['deals_value']);
			$partners_array[$i]['roi'] 					= 		round($row['roi']);
			$partners_array[$i]['campaigns_active'] 	= 		$row['campaigns_active'];
			$partners_array[$i]['est_revenue'] 			= 		round($row['expected_revenue']);
			
			$i++;
		}
		
		//highest partners
		$highest_partners_array = array();
			$i=0;
		//set the title
		$highest_partners_array[$i][$i]					=		"\n Highest Performing Partners \n";
			$i++;
		$highest_partners_array[$i]['name']				=		'Partner';
		$highest_partners_array[$i]['deals_closed']		=		'Deals Closed';
		$highest_partners_array[$i]['deals_value']		=		'Value of Closed Deals';
		$highest_partners_array[$i]['roi']				=		'ROI';
			$i++;
		
		foreach ($partners_registered_highest as $row) {
			$highest_partners_array[$i]['name']				=		$row['partner_name'];
			$highest_partners_array[$i]['deals_closed']		=		$row['deals_count'];
			$highest_partners_array[$i]['deals_value']		=		round($row['deals_value']);
			$highest_partners_array[$i]['roi']				=		round($row['roi']);
			$i++;

		}
		
		//lowest partners
		$lowest_partners_array = array();
			$i=0;
		//set the title
		$lowest_partners_array[$i][$i]					=		"\n Lowest Performing Partners \n";
			$i++;
		$lowest_partners_array[$i]['name']				=		'Partner';
		$lowest_partners_array[$i]['deals_closed']		=		'Deals Closed';
		$lowest_partners_array[$i]['deals_value']		=		'Value of Closed Deals';
		$lowest_partners_array[$i]['roi']				=		'ROI';
			$i++;
		
		foreach ($partners_registered_lowest as $row) {
			$lowest_partners_array[$i]['name']				=		$row['partner_name'];
			$lowest_partners_array[$i]['deals_closed']		=		$row['deals_count'];
			$lowest_partners_array[$i]['deals_value']		=		round($row['deals_value']);
			$lowest_partners_array[$i]['roi']				=		round($row['roi']);
			$i++;

		}	
	
		usort($partners_registered, array($this,"__cmp_partner_asc"));
		
		$partners_registered_highest = $partners_registered;
		$partners_registered_lowest = $partners_registered;
		usort($partners_registered_highest, array($this,"__cmp_desc"));
		usort($partners_registered_lowest, array($this,"__cmp_asc"));
		
		//ROI values for the quarterly report chart
		$financialquarters = array();
		for($quarter=1;$quarter<=4;$quarter++)
		{
			$fq = $this->Campaigns
					->find('all')
					->contain(['Financialquarters','CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
						return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
					}])
					->where(['Financialquarters.quartertitle LIKE'=>'Q'.$quarter.' ('.$quarteryear.')','Campaigns.vendor_id'=>$id,'Campaigns.financialquarter_id=Financialquarters.id']);

			$financialquarters[$quarter]=0;
			$deals_value = 0;
			foreach($fq as $row)
			{				
				foreach($row->campaign_partner_mailinglists as $ml)
					foreach($ml->campaign_partner_mailinglist_deals as $d)
						$deals_value += $d->deal_value;				
			}
			$financialquarters[$quarter] += $deals_value;
		}
		
		$doughnut	=	array();
			$i=0;
		$doughnut[$i][$i]		=		"Total Deal Value, by Quarter \n";
			$i++;
		$doughnut[$i]['quarter']	=	'Quarter';
		$doughnut[$i]['value']		=	'Value';
			$i++;
		
		$k=1;
		foreach ($financialquarters as $row) {
			$doughnut[$i]['quarter']	=	"Q$k";
			$doughnut[$i]['value']		=	$row;
			$i++;
			$k++;
		}

		
			$final_data_array = array();	
			$final_data_array[0] = $doughnut;	
			$final_data_array[1] = $campaigns_active_complete_array;
			$final_data_array[2] = $funding_approved_partner_array;	
			$final_data_array[3] = $top5deals_array;
			$final_data_array[4] = $partner_location_array;	
			$final_data_array[5] = $partners_array;
			$final_data_array[6] = $highest_partners_array;
			$final_data_array[7] = $lowest_partners_array;
			
		
			$this->Filemanagement->getExportcsvMulti($final_data_array, 'vendor_dashboard_data.csv', ',');
			echo __('Export Complete');
			exit;		
 		}

public function getexportcsvtemplate() {
		
		//$template_array = array('0' => 'test', '1' => 'fmndskl', '2' => 'fdaf');
		$i=0;
		
		$template_array[0][0]		=		'Company Name';
		$template_array[0][1]		=		'Email Address';
		$template_array[0][2]		=		'Phone';
		$template_array[0][3]		=		'Website';
		$template_array[0][4]		=		'Twitter';
		$template_array[0][5]		=		'Facebook';
		$template_array[0][6]		=		'Linkedin';
		$template_array[0][7]		=		'Address';
		$template_array[0][8]		=		'City';
		$template_array[0][9]		=		'County/State';
		$template_array[0][10]		=		'Country';
		$template_array[0][11]		=		'Zip/Postal Code';
		$template_array[0][12]		=		'Primary Contact Firstname';
		$template_array[0][13]		=		'Lastname';
		$template_array[0][14]		=		'Job Title';
		$template_array[0][15]		=		'Title (Mr/Mrs etc)';
		$template_array[0][16]		=		'Phone'; 
		//echo var_dump($template_array);exit;
			
		$this->Filemanagement->getExportcsv($template_array, 'import_partner_template.csv', ',');
		echo 'export complete';
		exit;
					
}


/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */

  public function profile() {
      $id =   $this->Auth->user('vendor_id');
      $vendor = $this->Vendors->get($id, [
              'contain' => ['Coupons', 'Partners', 'VendorManagers.Users','SubscriptionPackages']
      ]);
      //print_r($vendor);exit;
      $this->set('vendor', $vendor);
      $user =   $this->Users->get($this->Auth->user('id'),[ 'contain' => ['VendorManagers']]);
     // print_r( $user->vendor_manager->id);exit;
      $this->set('user', $user);
  }


/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit() {
    $id = $this->Auth->user('vendor_id');
	$this->loadModel('Currencies');
    $vendor = $this->Vendors->get($id, [
      'contain' => []
    ]);
		
    if ($this->request->is(['post', 'put'])) {
      
      /*
       *  Upload logo
       */
      
      $filename = null;
      $allwed_types = array('image/jpg','image/jpeg','image/png','image/gif');
      if (!empty($this->request->data['logo_url']['tmp_name']) && $this->request->data['logo_url']['error'] == 0 && in_array($this->request->data['logo_url']['type'],$allwed_types)) {
        /*
        // Strip path information
        $filename = time().basename($this->request->data['logo_url']['name']); 
        
        if($this->Imagecreator->uploadImageFile($filename,$this->request->data['logo_url']['name'],$this->request->data['logo_url']['tmp_name'],$this->request->data['logo_url']['type'],WWW_ROOT  .'img' . DS . 'logos' . DS . $filename,$this->request->data['logo_url']['size'],$this->portal_settings['logo_width'])){
            $this->request->data['logo_url'] = $filename;
        } else {
            unset($this->request->data['logo_url']);
        }
        */

        $file_ext = substr(strrchr($this->request->data['logo_url']['name'],'.'),1);
        $source_ext = substr(strrchr($vendor->logo_path,'.'),1);

        // Resize and format Logo
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

        $user = $this->Auth->user();
        $user['logo_url'] = isset($this->request->data['logo_url']) ? $this->request->data['logo_url'] : $vendor->logo_url;
        $this->Auth->setUser($user);
    
        }
		else 
		{
			if(!empty($this->request->data['logo_url']['tmp_name']) && $this->request->data['logo_url']['error']!=0)
				$this->Flash->error('Your logo was not uploaded! It is either corrupted or invalid format.');

			if(!empty($this->request->data['logo_url']['tmp_name']) && !in_array($this->request->data['logo_url']['type'],$allwed_types))
				$this->Flash->error('Your logo was not uploaded! It has to be a JPEG, PNG or GIF.');

			$logo_error = true;
			if(empty($this->request->data['logo_url']['tmp_name']))
				$logo_error = false;

			if(isset($this->request->data['logo_url'])){
			  unset($this->request->data['logo_url']);
			}			
		}


	
		$currencies = $this->Currencies->find('all')
			->where(['Currencies.countryname = ' => 'United States'])
			->orWhere(['Currencies.countryname = ' => 'United Kingdom'])
			/*->orWhere(['Currencies.countryname = ' => 'China'])*/
			->orWhere(['Currencies.countryname = ' => 'Europe'])
			->order(['Currencies.countryname' => 'DESC']);
	
		$currency_list  =   array();
	
		foreach($currencies as $curr) {
			$currency_list[$curr->currency_code]    =   $curr->currency_name.' - '.$curr->countryname;
		}


  		$vendor = $this->Vendors->patchEntity($vendor, $this->request->data);
  		if ($this->Vendors->save($vendor)) {
  			if(!$logo_error)
  			$this->Flash->success('The vendor has been saved.');
  			return $this->redirect(['action' => 'profile']);
  		} else {
  			$this->Flash->error('The vendor could not be saved. Please, try again.');
  		}
		}
		$this->set(compact('vendor','currency_list'));
	}


  /*
   *  Buy a package
   *
   */
          
	public function buypackage($id=null) {
	
		$this->loadModel('Currencies');
	
		if($this->request->session()->check('user')) {
			$this->request->session()->destroy();
		}
	
		$currencies = $this->Currencies->find('all')
			->where(['Currencies.countryname = ' => 'United States'])
			->orWhere(['Currencies.countryname = ' => 'United Kingdom'])
			/*->orWhere(['Currencies.countryname = ' => 'China'])*/
			->orWhere(['Currencies.countryname = ' => 'Europe'])
			->order(['Currencies.countryname' => 'DESC']);
	
		$currency_list  =   array();
	
		foreach($currencies as $curr) {
			$currency_list[$curr->currency_code]    =   $curr->currency_name.' - '.$curr->countryname;
		}
	
		$this->layout = 'signup';
	
		$vendor = $this->Vendors->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($result = $this->Vendors->save($vendor)) {
				$vid=   $result->id;

				// Upload logo and update db
				$allwed_types = array('image/jpg','image/jpeg','image/png','image/gif');
				if (!empty($this->request->data['logo_url']['tmp_name']) && $this->request->data['logo_url']['error'] == 0 && in_array($this->request->data['logo_url']['type'],$allwed_types)) {
					// Strip path information
                    $file_ext = substr(strrchr($this->request->data['logo_url']['name'],'.'),1);
                    $filename = 'vendors/' . $vid . '/vendorlogo.' . $file_ext;

					//$filename = time().basename($this->request->data['logo_url']['name']); 
					$this->Imagecreator->formatImage($this->request->data['logo_url']['name'],$this->request->data['logo_url']['tmp_name'],$this->portal_settings['logo_width']);
	                if($this->Opencloud->addObject($filename,$this->request->data['logo_url']['tmp_name']))
	                {
					//if($this->Imagecreator->uploadImageFile($filename,$this->request->data['logo_url']['name'],$this->request->data['logo_url']['tmp_name'],$this->request->data['logo_url']['type'],WWW_ROOT  .'img' . DS . 'logos' . DS . $filename,$this->request->data['logo_url']['size'],$this->portal_settings['logo_width'])){
						$this->request->data['logo_url'] = $this->Opencloud->getobjecturl($filename);
						$this->request->data['logo_path'] = $filename;
					}
					else
						$this->request->data['logo_url'] = null;

					//$vendor = $this->Vendors->get($vid);
					$vendor = $this->Vendors->patchEntity($vendor, $this->request->data);
					$result = $this->Vendors->save($vendor);
				}
				elseif(!empty($this->request->data['logo_url']['tmp_name']) && $this->request->data['logo_url']['error']!=0)
					$this->Flash->error('Your logo was not uploaded! It is either corrupted or invalid format.');
				elseif(!empty($this->request->data['logo_url']['tmp_name']) && !in_array($this->request->data['logo_url']['type'],$allwed_types))
					$this->Flash->error('Your logo was not uploaded! It has to be a JPEG, PNG or GIF.');

				return $this->redirect(['action' => 'primarycontact',$vid]);
			} else {
					$this->Flash->error('The vendor could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set('subscription_package', $id);
		// $this->set('subscription_type', $payoption);
		$this->set('country_list',$this->country_list);
		$this->set(compact('vendor','currency_list'));
	}
	
	
  /*
   *  Set primary contact for vendor
   *
   */
          
  public function primarycontact($vid) {
	  
    $this->loadModel('Users');
    $this->layout = 'signup';
    if(isset($this->request->data['email'])) {
      $this->request->data['username']   =   $this->request->data['email'];
    }
    $user = $this->Users->newEntity($this->request->data);
    $vendor = $this->Vendors->find()
    ->hydrate(false)
    ->select(['Vendors.id', 'Vendors.company_name', 'Vendors.currency_choice', 'Vendors.subscription_type', 'subscription_package_id'])
    ->where(['Vendors.id' => $vid])->first();
   
    if ($this->request->is('post')) {
      // print_r($this->request->data);exit;
      if($this->request->data['conf_password'] == $this->request->data['password']) {
        if ($uresult = $this->Users->save($user)) {
          $this->request->data['vendor_manager']['user_id'] =   $uresult->id;
          $this->request->session()->write('Vendor.primary_manager', $uresult->id);
          $this->request->data['vendor_manager']['status'] = 'Y';
          if($this->__addVmanager($this->request->data['vendor_manager'])) {
            //$this->Flash->success(__('The vendor has been saved'));
            // Copy Templates
         		$this->copyresourcetemplate($vid,$uresult->id,$uresult->username);
            return $this->redirect(['action' => 'checkout',$vid]);
          }

        }
        $this->Flash->error(__('Sorry, we were unable to add the vendor. Please try again. If you continue to experience problems, please contact Customer Support. Maybe email issue?'));
      } else {
        $this->Flash->error(__('Your passwords do not match. Please try again.'));
      }
       
    }
    $this->set('subscription_package', $vendor['subscription_package_id']);
    $this->set('user', $user);
    $this->set('vendor_id', $vid);
  }



	// Functions for copying template when vendor account created
	private function copyresourcetemplate($vendorid,$vendoruserid,$vendorusername) {
    $this->copyfoldercontents(2,4,$vendorid,$vendoruserid,$vendorusername); // default templates folderid=2, parentid_new=4(Vendors)
    $folder = $this->Folders->find()->where(['vendor_id'=>$vendorid,'user_id'=>$vendoruserid,'parent_id'=>4])->first(); //parent_id is default for folder for vendors
    return $folder->id;
  }

  private function copyfoldercontents($folderid,$parentid_new,$vendorid,$vendoruserid,$vendorusername) {
    // copy folder        
    if($folderid==2) // if default template folder
    {
        // Create Vendor Root Folder
        $folder_new = $this->Folders->newEntity(['parentpath'=>'vendors','user_id'=>$vendoruserid,'user_role'=>'vendor','vendor_id'=>$vendorid,'name'=>$vendorusername,'folderpath'=>'vendors/'.$vendorid,'status'=>'Y','parent_id'=>$parentid_new]);
    }
    else
    {
      // Copy Template Folder
      $folder = $this->Folders->get($folderid);
      $parentfolder_new = $this->Folders->get($parentid_new);
      $folder_new = $this->Folders->newEntity(['parentpath'=>$parentfolder_new->folderpath,'user_id'=>$vendoruserid,'user_role'=>'vendor','vendor_id'=>$vendorid,'name'=>$folder->name,'folderpath'=>substr_replace($folder->folderpath,$parentfolder_new->folderpath,0,strlen($folder->parentpath)),'status'=>$folder->status,'parent_id'=>$parentid_new]);
    }
    $this->Folders->save($folder_new);
    $folderid_new = $folder_new->id;
    // copy folder contents
    $resources = $this->Resources->find()->where(['folder_id'=>$folderid]);
    if($resources->count()>0)
    foreach($resources as $resource)
    {
      $resource_new = $this->Resources->newEntity(['folder_id'=>$folderid_new,'name'=>$resource->name,'description'=>$resource->description,'user_id'=>$vendoruserid,'user_role'=>'vendor','vendor_id'=>$vendorid,'status'=>$resource->status,'sourcepath'=>$resource->sourcepath,'publicurl'=>$resource->publicurl,'type'=>$resource->type,'size'=>$resource->size]);
      $this->Resources->save($resource_new);
    }
  
    // copy subfolders
    $subfolders = $this->Folders->find()->where(['parent_id'=>$folderid]);
    if($subfolders->count()>0)
    foreach($subfolders as $subfolder)
      $this->copyfoldercontents($subfolder->id,$folderid_new,$vendorid,$vendoruserid,$vendorusername);
  
    return true;
    }	
    
    
  /*
   *  Add Vendor manager
   *
   */
          
  function __addVmanager($vmgr) {
    $this->loadModel('VendorManagers');
    $manager = $this->VendorManagers->newEntity($vmgr);
     if($this->VendorManagers->save($manager)) {
       return true;
     }
     return false;
  }


   /*
   *  Checkout
   *
   */
        
  public function freetrial($vid=null){
    $this->layout = 'frontend';

    $vendor = $this->Vendors->find()
	    ->hydrate(false)
	    ->select(['Vendors.id', 'Vendors.company_name', 'Vendors.currency_choice', 'Vendors.subscription_type', 'subscription_package_id'])
	    ->where(['Vendors.id' => $vid])->first();
   
    $this->set('vendor_name', $vendor['company_name']);

  } 
  /*
   *  Checkout
   *
   */
        
  public function checkout($vid=null){
    $this->layout = 'signup';
    /*if (!$this->request->is('post')) {
		$vendor = $this->Vendors->find()
		->hydrate(false)
		->select(['Vendors.id', 'Vendors.company_name','Vendors.coupon_id','Vendors.subscription_type', 'subscription_package_id','s.name','s.annual_price','s.monthly_price','s.duration'])
		 ->join([
		    'c' => [
		      'table' => 'coupons',
		      'type' => 'LEFT',
		      'conditions' => 'c.id = Vendors.coupon_id',
		    ],
			's' => [
				'table' => 'subscription_packages',
				'type' => 'INNER',
				'conditions' => 'Vendors.subscription_package_id = s.id',
			]
	    ])
		->where(['Vendors.id' => $vid])->first();
	} else {
    */
	    $vendor = $this->Vendors->find()
	    ->hydrate(false)
	    ->select(['Vendors.id', 'Vendors.company_name', 'Vendors.currency_choice', 'Vendors.coupon_id','Vendors.subscription_type', 'Vendors.subscription_package_id','u.email','u.first_name','u.last_name','s.name','s.annual_price','s.monthly_price','s.duration'])
	    ->join([
		    'c' => [
		      'table' => 'coupons',
		      'type' => 'LEFT',
		      'conditions' => 'c.id = Vendors.coupon_id',
		    ],
			's' => [
				'table' => 'subscription_packages',
				'type' => 'INNER',
				'conditions' => 'Vendors.subscription_package_id = s.id',
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
			]
	    ],['m.primary_manager' => 'string','u.id' => 'integer','m.user_id' => 'integer'])
	    ->where(['Vendors.id' => $vid])->first();
    //}
	if($vendor['subscription_package_id'] == 4 ) {
	 
	 	$totdays        =   (($vendor['s']['duration']/12)*365 )+1;	

		$sub_exp_date   =   date('Y-m-d h:i:s',time()+($totdays*24*60*60));
		
		$vendor_data = $this->Vendors->get($vid);		
		$vendor_updated = $this->Vendors->patchEntity($vendor_data,['status' => 'Y','subscription_expiry_date' => $sub_exp_date]);
		$this->Vendors->save($vendor_updated);

		$this->updateFinanceQuarters();

		$vendor_updated = $this->Vendors->patchEntity($vendor_data,['status' => 'P']);
		$this->Vendors->save($vendor_updated);       
  
		$this->Prmsemails->freeTrial($vid);
        //return $this->redirect(['controller' => 'pages','action' => 'freetrial',$vid]);
		return $this->redirect(['controller' => 'pages','action' => 'freetrial']);
	}
	
    if($vendor['subscription_type'] == 'monthly') {
		/*	
			Calculate subscripton amount based on currency choice:
		*/	
		
		if ($vendor['currency_choice'] == 'GBP') {
			$exchanged_amount = number_format(($vendor['s']['monthly_price'] / $this->portal_settings['gbp_rate']), 2, '.', '');
		} elseif ($vendor['currency_choice'] == 'EUR') {
			$exchanged_amount = number_format(($vendor['s']['monthly_price'] / $this->portal_settings['eur_rate']), 2, '.', '');
		} else {
			$exchanged_amount = round($vendor['s']['monthly_price']);
		}

	    $vendor['amount']   =   $exchanged_amount;
	    $vendor['length']   =   $vendor['s']['duration'];
	    $vendor['unit']     =   'months';
    } else {
		/*	
			Calculate subscripton amount based on currency choice:
		*/	

		if ($vendor['currency_choice'] == 'GBP') {
			$exchanged_amount = number_format(($vendor['s']['annual_price'] / $this->portal_settings['gbp_rate']), 2, '.', '');
		} elseif ($vendor['currency_choice'] == 'EUR') {
			$exchanged_amount = number_format(($vendor['s']['annual_price'] / $this->portal_settings['eur_rate']), 2, '.', '');
		} else {
			$exchanged_amount = round($vendor['s']['annual_price']);
		}
	    $vendor['amount']   =   $exchanged_amount;
	    $vendor['length']   =   $vendor['s']['duration'] / 12;
	    $vendor['unit']     =   'years';
    }
    
    $vendor['refId']    =   $vendor['s']['duration'].'*^&^*'. $vid.'*^&^*'.$vendor['company_name'];
    $this->request->session()->write('Vendor.id', $vid);
    
    if ($this->request->is('post')) {
	 
	  //echo "DICOUNT:".$this->request->data['discount_coupon_code'];
	 // exit;	
	 
	  if(isset($this->request->data['discount_coupon_code']) && strlen(trim($this->request->data['discount_coupon_code'])) > 0) {
        $sees_coupon_code   =  $this->request->session()->read('Vendor.coupon_code') ;
        
        if($sees_coupon_code == $this->request->data['discount_coupon_code']) {
          return $this->redirect(['action' => 'payment']);
        }
        
        $this->loadModel('Coupons');
        $coupon     =   $this->Coupons->find()
        ->hydrate(false)
        ->where(['coupon_code' => $this->request->data['discount_coupon_code'],'status' => 'Y','expiry_date >=' => time()])
        ->first();
        
        if(isset($coupon) && !empty($coupon)) {
          if($coupon['type'] == 'Perc'){
            $discount_amount  =  $vendor['amount'] * ($coupon['discount'] / 100);
          } else {
            $discount_amount  =  $coupon['discount'];
          }
          if( $discount_amount > $vendor['amount']) {
            $discount_amount	=  $vendor['amount']-0.01;
          }

          $this->request->session()->write('Vendor.discount_amount', $discount_amount);
          $this->request->session()->write('Vendor.coupon_id', $coupon['id']);
          $this->request->session()->write('Vendor.coupon_code', $coupon['coupon_code']);
          $this->Flash->success('Discount is added');

          $vendor['discount_amount']   =   $discount_amount;
          return $this->redirect(['action' => 'payment']);
        } else {
          $this->Flash->error('Invalid discount coupon code');
        }
      } else {
	      return $this->redirect(['action' => 'payment']);
      }
    }

    $this->set('vendor', $vendor);
    $ver =   $this->Vendors->get($vid);
    $this->set('ver', $ver);
    
  }
  
  
  /*
   *  Payment
   *
   */
        
  public function payment($id=null) {
	$this->layout = 'signup';
    $this->loadModel('Coupons');
    $this->loadModel('Users');
    $this->loadModel('VendorPayments');
    $this->loadModel('Settings');
    $this->loadModel('Invoices');

    $vid             		=  $this->request->session()->read('Vendor.id');
    $primary_manager 		=  $this->request->session()->read('Vendor.primary_manager');
    $coupon_id  				=  $this->request->session()->read('Vendor.coupon_id');
    $discount_amount    =  $this->request->session()->read('Vendor.discount_amount');

	if (!isset($vid) && isset ($id)) {
		$vid = $id;
		
		$vendorquery= $this->Vendors->find()
					    ->hydrate(false)
					    ->select(['u.id', 'coupon_id', 'currency_choice'])
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
					    ->where(['Vendors.id' => $vid])->first();

        $coupon_id = $vendorquery[coupon_id];
        $discount_amount = 0;
        
        $primary_manager =  $vendorquery[u][id];

        //echo "NO ID";
      //exit;
	};

	 //exit;


    if(!isset($vid) || $vid < 1) {
      $this->Flash->error('Session Expired');
      return $this->redirect(['controller' => 'subscriptionpackages','action' => 'packagelist']);
    }
    $vendor = $this->Vendors->find()
    ->hydrate(false)
    ->select(['Vendors.id','Vendors.company_name', 'Vendors.currency_choice','Vendors.country', 'Vendors.address', 'Vendors.city', 'Vendors.state', 'Vendors.postalcode','Vendors.phone','Vendors.fax','u.title','u.email','u.first_name','u.last_name', 'Vendors.subscription_type','s.name','s.no_emails','s.no_partners','s.annual_price','s.monthly_price','s.duration','s.signup_fee','Vendors.last_billed_date','Vendors.current_bill_end_date','Vendors.currency','Vendors.vat_no','c.type','c.discount'])
    //->select(['Vendors.id', 'Vendors.company_name','Vendors.subscription_type','Vendors.address','Vendors.city','Vendors.state','Vendors.postalcode','Vendors.country','Vendors.phone','Vendors.fax','u.title','u.email','u.first_name','u.last_name','s.name','s.annual_price','s.monthly_price','s.duration','s.signup_fee'])
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
    ->where(['Vendors.id' => $vid])->first();
 

  if($vendor['subscription_type'] == 'monthly') {

		if ($vendor['currency_choice'] == 'GBP') {
			$exchanged_amount = number_format(($vendor['s']['monthly_price'] / $this->portal_settings['gbp_rate']), 2, '.', '');
			$exchanged_signup = number_format(($vendor['s']['signup_fee'] / $this->portal_settings['gbp_rate']), 2, '.', '');
		} elseif ($vendor['currency_choice'] == 'EUR') {
			$exchanged_amount = number_format(($vendor['s']['monthly_price'] / $this->portal_settings['eur_rate']), 2, '.', '');
			$exchanged_signup = number_format(($vendor['s']['signup_fee'] / $this->portal_settings['eur_rate']), 2, '.', '');
		} else {
			$exchanged_amount = round($vendor['s']['monthly_price']);
			$exchanged_signup = number_format($vendor['s']['signup_fee'], 2, '.', '');
		}

	  $sub_type          			=  __('Monthly');
	  $vendor['amount']       =  $exchanged_amount;
	  $vendor['signup_fee']	  =  $exchanged_signup;
	  $vendor['unit']         =  'months';
	  $vendor['length']       =  '1';
	  $days_this_month   			=  cal_days_in_month ( CAL_GREGORIAN , date('m') , date('Y') );
	  $billing_period    			=  $days_this_month;
  } else {
		if ($vendor['currency_choice'] == 'GBP') {
			$exchanged_amount = number_format(($vendor['s']['annual_price'] / $this->portal_settings['gbp_rate']), 2, '.', '');
			$exchanged_signup = number_format(($vendor['s']['signup_fee'] / $this->portal_settings['gbp_rate']), 2, '.', '');
		} elseif ($vendor['currency_choice'] == 'EUR') {
			$exchanged_amount = number_format(($vendor['s']['annual_price'] / $this->portal_settings['eur_rate']), 2, '.', '');
			$exchanged_signup = number_format(($vendor['s']['signup_fee'] / $this->portal_settings['eur_rate']), 2, '.', '');
		} else {
			$exchanged_amount = round($vendor['s']['annual_price']);
			$exchanged_signup = number_format($vendor['s']['signup_fee'], 2, '.', '');
		}

	  $sub_type          			=  __('Annual');
	  $vendor['amount']       =  $exchanged_amount;
	  $vendor['signup_fee']	  =  $exchanged_signup;
	  $vendor['unit']         =  'months';
	  $vendor['length']       =  '12';
	  $billing_period    			=  365;
	  
  }
  
  if(isset($discount_amount) && $discount_amount > 0) {
    $vendor['discount_amount']   	=  	round($discount_amount,2);
  }
  if(!isset($vendor['discount_amount'])) {
    $vendor['discount_amount']  	= 	0;
  }

  $vat = 0; // always set to zero as default
  $vat_perc = $this->portal_settings['VAT_rate'];
 
  if(substr($vendor['vat_no'], 0, 2) == 'GB') {
    $amount_to_pay  = ( $vendor['amount'] - $vendor['discount_amount'] + $vendor['signup_fee']);
    $vat = ($amount_to_pay / 100) * $vat_perc;
    $vendor['vat_perc'] = $vat_perc;
    
   // echo "SIGN-UP FEE: ".$vendor['signup_fee']."<hr/>";
    
    $vendor['substotal_incvat'] =round( $vendor['amount'] +(($vendor['amount']/100) * $vat_perc), 2);
    $vendor['signup_incvat'] = round($vendor['signup_fee'] +(($vendor['signup_fee']/100) * $vat_perc), 2);
    
    $vendor['vat'] = $vat;
  } else {
    $amount_to_pay  = ( $vendor['amount'] - $vendor['discount_amount'] + $vendor['signup_fee']);
	  
  }
 
  $vendor['occlength']    				=   '9999';
  $companyname										=		$vendor['company_name']; // Keep a copy of the company name without hyphens
  $string = str_replace(' ', '-', $vendor['company_name']); // Replaces all spaces with hyphens
  $vendor['company_name'] 				= 	preg_replace('/[^A-Za-z0-9\-]/', '', $string); 
  $vendor['refId']        				=   $vid.'__'.substr($vendor['company_name'],0,5);

  
  $vendor['country_list']      		=   $this->country_list;
  
  
  /*
   *  If based in UK, add VAT
   */
  
  /* removed for redundancy and irrelevance
  $vat = 0; // always set to zero as default
  $vat_perc = $this->portal_settings['VAT_rate'];

  if($vendor['country'] == 'United Kingdom') {
    $amount_to_pay  = ($exchanged_amount - $vendor['discount_amount'] + $exchanged_signup);
    $vat = ($amount_to_pay / 100) * $vat_perc;
  }
  */

//echo $this->request->data['amount'] ; exit;
	//ADD VAT TO SIGNUP FEE'S AND AMOUNTS TO BE SEND FOR PAYMENT...
	if ($vendor['signup_incvat'] > 0) {
		$this->request->data['trialAmount']   =  $vendor['signup_incvat'];
	} else {
		$this->request->data['trialAmount']   =  $vendor['signup_fee'];
	}
	if ($vendor['substotal_incvat'] > 0) {
		$this->request->data['amount']   =  $vendor['substotal_incvat'];
	}
	
	$this->request->data['vendor_id']  = $vendor['id'];
	$this->request->data['currency_choice']    =  $vendor['currency_choice'];
	
	$this->request->data['invoice_number'] = $this->portal_settings['invoice_prefix'].($this->portal_settings['last_invoice_id']+1). $this->portal_settings['invoice_suffix'];

if ($this->request->is(['post', 'put'])) {

//print_r($this->request->data); 
//exit;

$this->request->data['expirationDate']   =  implode('-',$this->request->data['expirationDate']);
 if($ret =$this->Net->subscription_create($this->request->data)){
      if($ret['resultCode'] == 'Error') {
       $this->Flash->error($ret['text']. ' For more assistance please contact Customer Support');
      } elseif($ret['resultCode'] == 'Ok') {
	  
	 
        /*
         * Update vendor table status
         */
         //print_r($this->Authorizecim->createProfile($this->request->data));
       
        if($cimret = $this->Authorizecim->createProfile($this->request->data)){
          $parr['customerProfileId']           =   $cimret['customerProfileId'];
          $parr['customerPaymentProfileId']    =   $cimret['customerPaymentProfileId'];
        }
  
        /*
         *  Update invoice table
         */
       
              
		$inv_arr['primary_manager']			=  $vendor['u']['title'].' '.$vendor['u']['first_name'].' '.$vendor['u']['last_name'];
		$inv_arr['company_name']			=  $companyname;
		$inv_arr['company_address']			=  $vendor['address'];
		$inv_arr['company_city']			=  $vendor['city'];
		$inv_arr['company_state']			=  $vendor['state'];
		$inv_arr['company_postcode']		=  $vendor['postalcode'];
		$inv_arr['company_country']			=  $vendor['country'];
		$inv_arr['customer_service']		=  $this->portal_settings['site_email'];
		$inv_arr['sub_start_date']			=  date('Y-m-d', time());
		$inv_arr['upgrade_date']			=  date('Y-m-d', time());
		$inv_arr['sub_end_date']			=  date('Y-m-d', strtotime('+'.($billing_period - 1).' days'));
		$inv_arr['invoice_type']			=  __('Subscription');						 // 'Subscription', 'Subscription Upgrade', or 'Other'
		$inv_arr['title']					=  $sub_type.' '.__('subscription');
		$inv_arr['description']				=  $vendor['s']['name'].' '.__('package');
		$inv_arr['invoice_number']			=  $this->portal_settings['invoice_prefix'].($this->portal_settings['last_invoice_id']+1). $this->portal_settings['invoice_suffix'];
		$inv_arr['vendor_id']				=  $vid;
		$inv_arr['invoice_date']			=  date('Y-m-d h:i:s', time());
		$inv_arr['amount']					=  round($amount_to_pay + $vat,2);
		$inv_arr['subtotal']				=  round(($exchanged_amount - $vendor['discount_amount'] + $exchanged_signup),2);										
		$inv_arr['fee']						=  $exchanged_signup;		 // One-time fee is trialAmount
		$inv_arr['currency']				=  $vendor['currency_choice'];
		$inv_arr['vat_perc']				=  $vat_perc;															 
		$inv_arr['vat_number']				=  $vendor['vat_no'];											 
		$inv_arr['vat']						=  $vat;																	 
		$inv_arr['new_package']				=  $vendor['s']['name'].' '.__('package'); // New package name
		$inv_arr['package_price']			=  round($exchanged_amount,2);						// New package recurring amount (before discount and additional fees)
		$inv_arr['billing_period_days']		=  $billing_period;
		$inv_arr['status']					=  'paid';
		$inv_arr['discount']				=  round($vendor['discount_amount'],2);
	
		$invc =  $this->Invoices->newEntity($inv_arr);
		$inv_result =  $this->Invoices->save($invc);
		$last_invoice_id =  $inv_result->id;

		$this->request->session()->write('Invoice.id', $last_invoice_id);
            		
        /*
         *  Update the last invoice id in the settings table
         */
  
        $STquery = $this->Settings->query();
        $STquery->update()
        ->set(['settingvalue' => $last_invoice_id])
        ->where(['settingname' =>  'last_invoice_id'])
        ->execute();
   
   /*
    * 
    */

   
	$totdays        		=   (($vendor['s']['duration']/12)*365 )+1;
	$sub_exp_date    		=   time()+($totdays*24*60*60);
	if($vendor['subscription_type'] == 'monthly') {
		$totime  				  =   (strtotime($this->request->data['startDate']))+(24*60*60);
		$bill_end_date    =   strtotime('+1 month',$totime);
	} else {
		$bill_end_date    =   $sub_exp_date;
	}
	$last_bill_date  		=   $this->request->data['startDate'];
	$Vquery 						= 	$this->Vendors->query();
	$Vquery->update()
        ->set(['coupon_id' => $coupon_id,'status' => 'Y','subscription_expiry_date' => $sub_exp_date,'last_billed_date'=>$last_bill_date,'current_bill_end_date'=>$bill_end_date])
        ->where(['id' =>  $vid])
        ->execute();
        
   /*
    *  Activate primary manager login
    */
    
   $Uquery = $this->Users->query();
   $Uquery->update()
        ->set(['status' => 'Y'])
        ->where(['id' =>  $primary_manager])
        ->execute();
        
   /*
    *  Update coupon status
    */
    
   if(isset($coupon_id) && $coupon_id > 0) {
        $Cquery = $this->Coupons->query();
        $Cquery->update()
             ->set(['status' => 'U','vendor_id' => $vid])
             ->where(['id' =>  $coupon_id])
             ->execute();
   }
   
   /*
    *  Insert record into the payments table
    */
   
    $parr['vendor_id']   =   $vid;
    $parr['subscriptionid']  =   $ret['subscriptionId'];
    $parr['reference']  =   $ret['refId'];
    $parr['status']  =   'active';
    $vpmt = $this->VendorPayments->newEntity($parr);
    $this->VendorPayments->save($vpmt);
    $this->updateFinanceQuarters();
   /*
    *  Send welcome email
    */
    $user     = $this->Users->find()
	  ->hydrate(false)
	  ->where(['id' => $primary_manager])
	  ->first();
    $this->Prmsemails->signupWelcomeMail($user, $vid);

    /*** Send New Invoice Email ***/
	$auth['User']['id']   = $primary_manager;
	$invdet = $this->request->session()->read('Invoice');
	$this->Prmsemails->newInvoicemail($auth,$invdet);

    $this->request->session()->delete('Vendor');

    $this->Flash->success('Your account has been activated successfully. You can now log in to the system.');
    return $this->redirect(['controller' => 'Users','action' => 'login']);
  }
  //exit;
  } else {
	  $this->Flash->error(' Sorry, we couldn\'t complete your payment. For more assistance please contact Customer Support.');
  }
  }    
  //print_r($vendor);exit;
  $this->set('country_list',$this->country_list);
  $this->set('vendor', $vendor);
  $ver =   $this->Vendors->get($vid);
  $this->set('ver', $ver);
  }
  
  public function listvendormanagers(){
  
	  $this->paginate = [
		  'VendorManagers' => [
	      'conditions' => ['vendor_id' => $this->Auth->user('vendor_id')],
	      'contain' => ['Vendors', 'Users']

		  ]
		];
	  $this->set('vendorManagers', $this->paginate($this->VendorManagers));
	  
  }


  public function viewManager($id=null){
  if($id <1){
  return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
  }
  $vendorManager = $this->VendorManagers->get($id, [
  'contain' => ['Vendors', 'Users']
  ]);
  if($this->Auth->user('vendor_id') != $vendorManager->vendor_id){
  $this->Flash->error(' Sorry, you do not have permission to view the details.');
  return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
  }
  $this->set('vendorManager', $vendorManager);
  }


  public function editManager($id=null,$viewfile='list'){
  $vendorManager = $this->VendorManagers->get($id, [
  'contain' => ['Vendors', 'Users']
  ]);
  $vid   =  $this->Auth->user('vendor_id');
  if($vid != $vendorManager->vendor_id){
  $this->Flash->error(' Sorry, you do not have permission to view the details.');
  return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
  }
  $user = $this->Users->get($vendorManager->user_id, [
  'contain' => []
  ]);
  if ($this->request->is(['post', 'put'])) {
  $user = $this->Users->patchEntity($user, $this->request->data);
  if ($this->Users->save($user)) {
        $this->Flash->success('The vendor manager has been saved.');
      if($viewfile=='view'){
          return $this->redirect(['action' => 'profile']);
      }else{
          return $this->redirect(['action' => 'listvendormanagers']);
      }
        
      
  } else {
        $this->Flash->error('The vendor manager could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
  }
  }
  
  $this->set('user', $user);
  $this->set('vendor_id',$vid);
  }


  public function addVendorManager() {
  $vid   =  $this->Auth->user('vendor_id');
  if(isset($this->request->data['email'])){
  $this->request->data['username']   =   $this->request->data['email'];
  $existingusers_array = array();
                $existingusers = $this->Users->find('all')
                							 ->select('username');
                foreach ($existingusers as $users) {
	                array_push($existingusers_array, $users->username);
                }

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
       $this->Flash->success(__('The new Vendor Manager has been added successfully.'));
       return $this->redirect(['action' => 'listvendormanagers']);
   }
   }
  
  if (in_array($this->request->data['email'], $existingusers_array)) {
		                $this->Flash->error(__('Sorry, the email address is already associated with a user, please try again with a different email address'));
	                }else {
                     $this->Flash->error(__('Sorry, we were unable to add the Vendor Manager. Please try again. If you continue to experience problems, please contact Customer Support.'));
                	}
                }else{
                     $this->Flash->error(__('Sorry, your passwords don\'t match. Please try again.'));
                }

  
  }
  $this->set('user', $user);
  $this->set('vendor_id', $vid);
  }


  public function changePrimaryVmanager($id = null) {
	  $vendorManager = $this->VendorManagers->get($id, [
	  'contain' => ['Vendors', 'Users']
	  ]);
	  $vid   =  $this->Auth->user('vendor_id');
	  if($vid != $vendorManager->vendor_id){
	  $this->Flash->error(' Sorry, you do not have permission to view the details.');
	  return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
	  }
	  if($id > 0){
	  $this->request->allowMethod('post', 'put');
	  $this->VendorManagers->updateAll(['primary_manager' => 'N'], ['vendor_id' => $vid]);
	  $this->VendorManagers->updateAll(['primary_manager' => 'Y'], ['id' => $id,'vendor_id' => $vid]);
	  $this->Flash->success(__('The primary manager has been changed successfully.'));
	  return $this->redirect(['controller' => 'users','action' => 'logout']);
	  }
	  return $this->redirect(['action' => 'listvendormanagers']);
  }


  public function deleteVendorManager($id=null){
  $this->request->allowMethod('post', 'delete');
  $vendormanager = $this->VendorManagers->get($id); 
  $vid   =  $this->Auth->user('vendor_id');
  if($vid != $vendormanager->vendor_id){
  $this->Flash->error(' Sorry, you do not have permission to delete the vendor manager.');
  return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
  }
  if($vendormanager->primary_manager == 'Y'){
  $this->Flash->error(__('The primary vendor manager can not be deleted. Please assign another manager as the primary manager, and then try again.'));
  
  }else{
  if($this->__delete_user($vendormanager->user_id)){
  $this->Flash->success(__('The vendor manager has been deleted successfully.'));
  }else{
  $this->Flash->error(__('Sorry, we couldn\'t delete the vendor manager. Please try again. If you continue to experience problems, please contact Customer Support.'));
  }
  
  }
  return $this->redirect(['action' => 'listvendormanagers']);
  
  }
  function __delete_user($id=null){
  $user = $this->Users->get($id);
  if ($this->Users->delete($user)) {
  return true;
  } else {
  return false;
  }
  
  }
  
  
  
  public function editcard() {
  $this->loadModel('VendorPayments');
  $id = $this->Auth->user('vendor_id');
  $vpments    =  $this->VendorPayments->find()
                            ->where(['VendorPayments.vendor_id' => $id,'status' => 'active'])->first();
  //  $vpments    =  $this->VendorPayments->find(['condition'=>['status' => 'Active','vendor_id' =>$id]]);
  // print_r($vpments);exit;
  $vendor = $this->Vendors->find()
    ->hydrate(false)
    ->select(['Vendors.id', 'Vendors.company_name', 'Vendors.currency_choice','Vendors.subscription_type','Vendors.address','Vendors.city','Vendors.state','Vendors.postalcode','Vendors.country','Vendors.phone','Vendors.fax','u.email','u.first_name','u.last_name','s.name','s.annual_price','s.monthly_price','s.duration'])
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
  $this->request->data['currency_choice']   =   $vendor['currency_choice'];
  $this->request->data['expirationDate']   =  implode('-',$this->request->data['expirationDate']);
  if($ret =$this->Net->UpdateSubscriptionCardDetails($this->request->data)){
   //print_r($ret);exit;
   if($ret['resultCode'] == 'Error'){
       $this->Flash->error($ret['text']. ' For more assistance please contact Customer Support,');
   }elseif($ret['code'] == 'Ok' || $ret['resultCode'] == 'Ok' ){
       $this->Flash->success('Your card details have been updated.');
       $cmret=  $this->Authorizecim->updatePaymentProfile($this->request->data);
      // print_r($cmret);exit;
       return $this->redirect(['action' => 'profile']);
   }
   
   $this->Flash->error(__("Sorry, we couldn't update your card details because the ".$ret['text']." Please try again. If you continue to experience problems, please contact Customer Support." ));
  }
  
  }
  }else{
  $this->Flash->error(__("Sorry, we couldn't find an active subscription. Please try again. If you continue to experience problems, please contact Customer Support."));
  return $this->redirect(['action' => 'profile']);
  }
  $this->set('vendor', $vendor);
  $this->set('subscriptionid', $vpments->subscriptionid);
  $this->set('customerProfileId', $vpments->customerProfileId);
  $this->set('customerPaymentProfileId', $vpments->customerPaymentProfileId);
  
  $ver =   $this->Vendors->get($id);
  $this->set('ver', $ver);
  
  }
  
  
  public function partnersbyterritory($country='',$state=''){
  $this->paginate = [
  'conditions' => ['Partners.vendor_id' => $this->Auth->user('vendor_id')],
  'contain' => ['Vendors']
  ];
  
  if ($state!='' || $country!='') {        		
  $query = $this->Partners->find('all')
  ->where(['Partners.country LIKE' => $country])
  ->andWhere(['Partners.state LIKE' => $state]);
  $this->set('partners', $this->paginate($query));
  $this->set(compact('state','country'));
  
  }else{
  $this->set('partners', $this->paginate($this->Partners));
  }
  
  
  }        
  
  public function partners(){
  $this->paginate = [
  'conditions' => ['Partners.vendor_id' => $this->Auth->user('vendor_id')],        
  'contain' => ['Vendors']
  ];
  
  if ($this->request->is(['post', 'put'])) {
  //print_r( $this->request->data);exit;
  $keyword  =   $this->request->data['keyword'];
  $lkeyword  =   '%'.$keyword.'%';
  if(trim($keyword) != ''){
  $query = $this->Partners->find('all')->where(['Partners.company_name LIKE ' => $lkeyword])
                                ->orWhere(['Partners.website LIKE ' => $lkeyword])
       ->orWhere(['Partners.address LIKE ' => $lkeyword])
       ->orWhere(['Partners.country LIKE ' => $lkeyword])
       ->orWhere(['Partners.city LIKE ' => $lkeyword])
       ->orWhere(['Partners.state LIKE ' => $lkeyword]);
  $this->set('partners', $this->paginate($query));
  }else{
  $this->set('partners', $this->paginate($this->Partners));
  }
  
  }else{
  $this->set('partners', $this->paginate($this->Partners));
  $keyword  =   '';
  }
  $this->set('keyword', $keyword);
  
  }
  
  
public function viewPartner($id=null){
	$partner = $this->Partners->get($id, [
	'contain' => ['Vendors', 'PartnerManagers.CampaignPartnerMailinglistDeals','PartnerManagers.Users','PartnerCampaigns.Campaigns']
	]);

	if($this->Auth->user('vendor_id') != $partner->vendor_id){
		$this->Flash->error(' Sorry , You are not authorized to view the details');
		return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
	}

	$this->paginate =  [
	  'contain' => ['Campaigns.Financialquarters','CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=> function ($q) {
	  return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
	  }],'conditions' => ['PartnerCampaigns.partner_id' => $id],
	  'limit' => 10
	];


	// Statistics
	/*
	Campaigns Completed
	Deals closed
	Total value of closed deals
	ROI
	Campaigns Active
	Est. Revenue
	*/
	$campaigns_completed = 0;
	$deals_closed = 0;
	$total_closed_deals = 0;
	$roi = 0;
	$campaigns_active = 0;
	$expected_revenue = 0;

	$campaign_sendlimit = 0;
	$campaign_total = 0.0001;
	$deals_count = 0;
	$deals_value = 0;

	// Campaigns Completed
	//print_r($partner->partner_campaigns);die();
	foreach($partner->partner_campaigns as $partner_campaign)
	{
		$campaign = $partner_campaign->campaign;
		$campaign_sendlimit += $campaign->send_limit;
		if($campaign->status=='Y')
			$campaigns_completed++;

		if($partner_campaign->status=='A')
			$campaigns_active++;

		$expected_revenue += $campaign->sales_value;
		$campaign_total++;
	}

	// Get deals details
	foreach($partner->partner_managers as $partner_manager)
	{
		$deals_count += count($partner_manager->campaign_partner_mailinglist_deals);
			foreach($partner_manager->campaign_partner_mailinglist_deals as $deal)
				$deals_value += $deal->deal_value;
	}

	//Get subscription package details
	$vendor = $this->Vendors->get($partner->vendor_id,[
		'contain'=>['SubscriptionPackages']
	]);
	$package_limit = $vendor->subscription_package->no_emails;
	$package_monthly = $vendor->subscription_package->monthly_price;
	$roi=0;
	// calculate ROI
	$return = $deals_value;
	$costpersend = $package_monthly / $package_limit;
	$investment =  ($campaign_sendlimit * $costpersend) + ($package_monthly / $campaign_total);
	if ($investment == 0) { $investment = 0.0001; }
	$roi = ($return - $investment) / $investment;
	$roi = ($roi==''?0:$roi);

	$stats = 	[
					'campaigns_completed'=>$campaigns_completed,
					'deals_closed'=>$deals_count,
					'total_closed_deals'=>$deals_value,
					'roi'=>$roi,
					'campaigns_active'=>$campaigns_active,
					'expected_revenue'=>$expected_revenue
				];

	$this->set('stats', $stats);
	$this->set('campaignHistory', $this->paginate($this->PartnerCampaigns));
	$this->set('partner', $partner);
}
  
  
  
  public function viewPartnerCampaign($id = null) {
  $campaignHistory = $this->PartnerCampaigns->get($id,[
  'contain' => ['Campaigns','Campaigns.Financialquarters','CampaignPartnerMailinglists']    	
  ]);
  $this->set('campaignHistory', $campaignHistory);
  }
  
  
  
  public function addPartner(){
  $this->loadModel('PartnerGroups');
  $partnergroups = $this->PartnerGroups->find('list')->where(['vendor_id' => $this->Auth->user('vendor_id')]);
  if($this->__checkPartnerLimit($this->Auth->user('vendor_id'))){
  $filename = null;
  $allwed_types = array('image/jpg','image/jpeg','image/png','image/gif');
  if (!empty($this->request->data['partner']['logo_url']['tmp_name']) && $this->request->data['partner']['logo_url']['error'] == 0 && in_array($this->request->data['partner']['logo_url']['type'],$allwed_types)) {
  // Strip path information
  /*
  $filename = time().basename($this->request->data['partner']['logo_url']['name']); 
  
  if($this->Imagecreator->uploadImageFile($filename,$this->request->data['partner']['logo_url']['name'],$this->request->data['partner']['logo_url']['tmp_name'],$this->request->data['partner']['logo_url']['type'],WWW_ROOT  .'img' . DS . 'logos' . DS . $filename,$this->request->data['partner']['logo_url']['size'],$this->portal_settings['logo_width'])){
  $this->request->data['partner']['logo_url'] = $filename;
  }else{
  unset($this->request->data['partner']['logo_url']);
  }
  */
	$this->Imagecreator->formatImage($this->request->data['partner']['logo_url']['name'],$this->request->data['partner']['logo_url']['tmp_name'],$this->portal_settings['logo_width']);
  }else{

		if(!empty($this->request->data['partner']['logo_url']['tmp_name']) && $this->request->data['partner']['logo_url']['error']!=0)
			$this->Flash->error('The partner has been saved. But partner logo was not uploaded! It is either corrupted or invalid format.');

		if(!empty($this->request->data['partner']['logo_url']['tmp_name']) && !in_array($this->request->data['partner']['logo_url']['type'],$allwed_types))
			$this->Flash->error('The partner has been saved. But partner logo was not uploaded! It has to be a JPEG, PNG or GIF.');

		$logo_error = true;
		if(empty($this->request->data['partner']['logo_url']['tmp_name']))
			$logo_error = false;

		if(isset($this->request->data['partner']['logo_url'])){
		  unset($this->request->data['partner']['logo_url']);
		}		
  }
  if(isset($this->request->data['partner']['email'])){
  $this->request->data['user']['email'] = $this->request->data['partner']['email'];
  $this->request->data['user']['username'] = $this->request->data['partner']['email'];
  $existingusers_array = array();
                  $existingusers = $this->Users->find('all')
                  							   ->select('username');
                  foreach ($existingusers as $users) {
	                  array_push($existingusers_array, $users->username);
                  }

  }
  $saveflag = false;
  if(isset($this->request->data['user'])){
  if(isset($this->request->data['title'])){
  $this->request->data['user']['title']   =   $this->request->data['title'];
  }
  $rchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
  $rpassword = substr( str_shuffle( $rchars ), 0, 8 );
  $this->request->data['user']['password']    =  $rpassword;
  $this->request->data['user_id']  =  $this->__addUser($this->request->data['user']);
  $udata  =   $this->request->data['user'];
  unset( $this->request->data['user']);
  if(isset($this->request->data['user_id']) && $this->request->data['user_id'] > 0){
  if(isset($this->request->data['partner'])){
    $this->request->data['partner_id']  =   $this->__addPartner($this->request->data['partner']);
    unset( $this->request->data['partner']);
    $saveflag = true;
  }
  }
  
  }
  
  $partner = $this->PartnerManagers->newEntity($this->request->data);
  if ($this->request->is('post')) {
  if($saveflag == true){
    	// Determine allowable number of partners
        $vendor = $this->Vendors->get($this->Auth->user('vendor_id'), ['contain'=>['SubscriptionPackages','Partners']]);
        $no_partners_allowed = $vendor->subscription_package->no_partners;
        $current_no_partners = $vendor->has('partners') ? count($vendor->partners) : 0;  
        if($no_partners_allowed<($current_no_partners + 1))
        {
        	$this->Flash->error('Sorry, the partner could not be saved as you have reached the partner limit for your subscription package.  Please upgrade to increase your partner limit, or remove an existing partner to make space for the new one.');
        	return $this->redirect(array('controller' => 'Vendors', 'action' => 'suggestUpgrade'));
        }
        
  		if(count($this->request->data['partner_groups'])>0)
  		{
  			//$members = $this->PartnerGroupMembers->find()->where(['partner_id'=>$this->request->data['partner_id']]);
  			//$this->PartnerGroupMembers->delete($members);
  			$this->PartnerGroupMembers->deleteAll(['partner_id'=>$this->request->data['partner_id']]);
  			foreach($this->request->data['partner_groups'] as $group)
  			{
  				$group_member = $this->PartnerGroupMembers->newEntity(['id'=>$group.$this->request->data['partner_id'],'partner_id'=>$this->request->data['partner_id'],'group_id'=>$group]);
  				$this->PartnerGroupMembers->save($group_member);
  			}
  		}
        
		if($ret = $this->PartnerManagers->save($partner)){
			if(!$logo_error)
			$this->Flash->success('The partner has been saved.');
			$this->Prmsemails->userSignupemail($udata);
			return $this->redirect(['action' => 'partners']);
	  	} else {
	    	$this->Flash->error('Sorry, the partner could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
	    }
    } else {
      if (in_array($this->request->data['partner']['email'], $existingusers_array)) { 
        $this->Flash->error(__('Sorry, the email address is already associated with a user, please try again with a different email address'));
      } else {
        $this->Flash->error('Sorry, the partner could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
	    }
	  }
    
  
  }
  $vendor_id = $this->Auth->user('vendor_id');
  
  $vendormanagers = $this->VendorManagers->find('all')
    ->hydrate(false)
    ->select(['VendorManagers.id', 'u.username','u.first_name','u.last_name'])
    ->join([
        
        
        'u' => [
            'table' => 'users',
            'type' => 'INNER',
            'conditions' => 'VendorManagers.user_id = u.id',
        ]
    ])
    ->where(['VendorManagers.vendor_id' => $vendor_id]);
  $vmanagers=  array();
  foreach($vendormanagers as $vm){
  
  $vmanagers[$vm['id']]    =   $vm['u']['first_name'].' '.$vm['u']['last_name'].'--'.$vm['u']['username'];
  }
  
  $this->set(compact('partner', 'vendor_id','vmanagers','partnergroups'));
  $this->set('country_list',$this->country_list);
  }else{
  return $this->redirect(array('controller' => 'vendors', 'action' => 'suggestUpgrade')); 
  }
  }
  
  public function editPartner($id = null) {
  $this->loadModel('PartnerGroups');
  $partnergroups = $this->PartnerGroups->find('list')->where(['vendor_id' => $this->Auth->user('vendor_id')]);
  $partnergroupmembers_q = $this->PartnerGroupMembers->find()->select(['group_id'])->where(['partner_id'=>$id]);
  foreach($partnergroupmembers_q as $partnergroupmember)
  	$partnergroupmembers[] = $partnergroupmember->group_id;
  
  $partner = $this->Partners->get($id, [
  'contain' => []
  ]);
  if($this->Auth->user('vendor_id') != $partner->vendor_id){
  $this->Flash->error('Sorry, you do not have permission to view the details.');
  return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
  }
  $vendor_id = $this->Auth->user('vendor_id');
  $vendormanagers = $this->VendorManagers->find('all')
  ->hydrate(false)
  ->select(['VendorManagers.id', 'u.username','u.first_name','u.last_name'])
  ->join([
  
  
    'u' => [
        'table' => 'users',
        'type' => 'INNER',
        'conditions' => 'VendorManagers.user_id = u.id',
    ]
  ])
  ->where(['VendorManagers.vendor_id' => $vendor_id]);
  $vmanagers=  array();
  foreach($vendormanagers as $vm){
  
  $vmanagers[$vm['id']]    =   $vm['u']['first_name'].' '.$vm['u']['last_name'].'--'.$vm['u']['username'];
  }
  
  if ($this->request->is(['post', 'put'])) {
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
		$source_ext = substr(strrchr($partner->logo_path,'.'),1);
		$this->Imagecreator->formatImage($this->request->data['logo_url']['name'],$this->request->data['logo_url']['tmp_name'],$this->portal_settings['logo_width']);
		if($file_ext==$source_ext)
		{
		    $this->Opencloud->updateObject($partner->logo_path,$this->request->data['logo_url']['tmp_name']);
		    unset($this->request->data['logo_url']);
		}
		else
		{
		    $newfilepath = 'partners/' . $id . '/partnerlogo.' . $file_ext;
		    if($partner->logo_path!='')
		        $this->Opencloud->replaceObject($partner->logo_path,$newfilepath,$this->request->data['logo_url']['tmp_name']);
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
  
  $partner = $this->Partners->patchEntity($partner, $this->request->data);
  if ($this->Partners->save($partner)) {
  		if(count($this->request->data['partner_groups'])>0)
  		{
  			$this->PartnerGroupMembers->deleteAll(['partner_id'=>$partner->id]);
  			foreach($this->request->data['partner_groups'] as $group)
  			{
  				$group_member = $this->PartnerGroupMembers->newEntity(['id'=>$group.$partner->id,'partner_id'=>$partner->id,'group_id'=>$group]);
  				$this->PartnerGroupMembers->save($group_member);
  			}
  		}
  		
        $this->Flash->success('The partner has been saved.');
        return $this->redirect(['action' => 'viewPartner', $id]);
  } else {
        $this->Flash->error('Sorry, the partner could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
  }
  }
  $vendors = $this->Partners->Vendors->find('list');
  $this->set(compact('partner', 'vendor_id','vmanagers','partnergroups','partnergroupmembers'));
  $this->set('country_list',$this->country_list);
  }
  
    
    /*
     *  Check the partner limit
     */
    
    function __checkPartnerLimit($vid) {
      $vendor = $this->Vendors->get($vid, [
        'contain' => ['SubscriptionPackages', 'Partners']
      ]);
      $max_allowed        =   $vendor['subscription_package']->no_partners;
      $current_number     =   count($vendor['partners']);
      if($current_number < $max_allowed) {
          return true;
      }
      
      return false;
         
    }
    
    
    /*
     *  Suggest upgrade
     */
    
    public function suggestUpgrade() {
      if($pkg = $this->__findMyNextPackage('partner')) {
        $this->set('package', $pkg);
        
        /*
         *  Find the current package
         */
         
        $id = $this->Auth->user('vendor_id');
        $vendor = $this->Vendors->find()
        ->hydrate(false)
        ->select(['Vendors.id', 'Vendors.currency_choice', 'Vendors.subscription_type','s.no_emails','s.no_partners','s.annual_price','s.monthly_price','s.duration','s.name'])
        ->join([
          's' => [
            'table' => 'subscription_packages',
            'type' => 'INNER',
            'conditions' => 'Vendors.subscription_package_id = s.id',
          ]
        ])
        ->where(['Vendors.id' => $id])->first();
        $this->set('current_package', $vendor);
        //$this->Flash->error('Your have reached your maximum number of partners. Please upgrade your package or remove an existing partner in order to add a new one');
       
       } else {
         
        $this->Flash->error('Your have reached your maximum number of partners. No higher subscription package available. You may remove an existing partner in order to add a new one. Alternatively you can contact Customer Support to discuss your requirements, as we may be able to build a custom package for you.');
        return $this->redirect(array('controller' => 'Vendors', 'action' => 'partners'));
      
      }
      
    }
    
    
    /*
     *  Find the next package, for upgrages
     */

    function __findMyNextPackage($filter='partner') {
      $this->loadModel('SubscriptionPackages');
      $id = $this->Auth->user('vendor_id');
      $vendor = $this->Vendors->find()
        ->hydrate(false)
        ->select(['Vendors.id', 'Vendors.subscription_type','s.no_emails','s.no_partners','s.annual_price','s.monthly_price','s.duration'])
        ->join([
            's' => [
                'table' => 'subscription_packages',
                'type' => 'INNER',
                'conditions' => 'Vendors.subscription_package_id = s.id',
            ]
        ])
        ->where(['Vendors.id' => $id])->first();
        if($filter == 'partner') {
          
        /*
         *  To upgrade the number of partners
         */
          
        $npackage = $this->SubscriptionPackages->find()
                        ->hydrate(false)
                        ->select(['SubscriptionPackages.id','SubscriptionPackages.name','SubscriptionPackages.annual_price','SubscriptionPackages.monthly_price','SubscriptionPackages.no_partners','SubscriptionPackages.no_emails'])
                        ->where(['SubscriptionPackages.no_partners >' => $vendor['s']['no_partners'],'SubscriptionPackages.annual_price >' => $vendor['s']['annual_price'],'SubscriptionPackages.monthly_price >' => $vendor['s']['monthly_price'] ])
                        ->order(['SubscriptionPackages.monthly_price' => 'ASC','SubscriptionPackages.annual_price' => 'ASC'])
                        ->first();
        } else {
          
        /*
         *  To upgrade the email send limit
         */
        
        $npackage = $this->SubscriptionPackages->find()
                      ->hydrate(false)
                      ->select(['SubscriptionPackages.id','SubscriptionPackages.name','SubscriptionPackages.annual_price','SubscriptionPackages.monthly_price','SubscriptionPackages.no_partners','SubscriptionPackages.no_emails'])
                      ->where(['SubscriptionPackages.no_emails >' => $vendor['s']['no_emails'],'SubscriptionPackages.annual_price >' => $vendor['s']['annual_price'],'SubscriptionPackages.monthly_price >' => $vendor['s']['monthly_price'] ])
                      ->order(['SubscriptionPackages.monthly_price' => 'ASC','SubscriptionPackages.annual_price' => 'ASC'])
                      ->first();
        }
        if(isset($npackage) && !empty($npackage)){
          $npackage['vendor_subscription_type']    =   $vendor['subscription_type'];
          return $npackage;
        }
          return false;
        }
        
        /*
         *  UPGRADE PACKAGE
         */         

        public function upgradeMyPackage($pkgid=null) {
	       
          $this->loadModel('SubscriptionPackages');
          $this->loadModel('VendorPayments');
          $this->loadModel('Invoices');
          $this->loadModel('Settings');
	       
          if($pkgid > 0) {
 	       
	          $vendor_id = $this->Auth->user('vendor_id');
            $vendor    = $this->Vendors->find()
            ->hydrate(false)
            ->select(['Vendors.id', 'Vendors.currency_choice', 'Vendors.company_name', 'Vendors.country', 'Vendors.address', 'Vendors.city', 'Vendors.state', 'Vendors.postalcode', 'Vendors.subscription_type','s.name','s.no_emails','s.no_partners','s.annual_price','s.monthly_price','s.duration','Vendors.last_billed_date','Vendors.current_bill_end_date','Vendors.currency','Vendors.vat_no','c.type','c.discount'])
            ->join([
              'c' => [
              'table' => 'coupons',
              'type' => 'LEFT',
              'conditions' => 'Vendors.coupon_id = c.id',
              ],
              's' => [
              'table' => 'subscription_packages',
              'type' => 'INNER',
              'conditions' => 'Vendors.subscription_package_id = s.id',
              ]
            ])
            ->where(['Vendors.id' => $vendor_id])->first();
            $npackage = $this->SubscriptionPackages->find()
            ->hydrate(false)
            ->select('id,name,annual_price,monthly_price,no_partners,no_emails,duration')
            ->where(['id ' =>$pkgid])
            ->first();
                            
            /*
             *  Get the 'days used' and 'days remaining' for the current billing period
             */
                
            $now = time();
            $c_end_date 			 = strtotime($vendor['current_bill_end_date']);
            $c_start_date 			 = strtotime($vendor['last_billed_date']);
            $pkgused_time     		 = $now - $c_start_date;								// Time used
            $npkgrest_time    		 = $c_end_date - $now;									// Time remaining
            $days_used_pkg     		 = floor($pkgused_time/(60*60*24));			// Days used
            $days_balance_npkg 		 = floor($npkgrest_time/(60*60*24));		// Days remaining
            
            /*
             *  If the subscriber used a discount code on sign-up, adjust the new and old package prices accordingly
             */
             
                                    
            $discount_amount      = 0;
            $new_discount_annualy = 0;
            $new_discount_monthly = 0;
            
            if(isset($vendor['c']['discount'])&& $vendor['c']['discount'] > 0) {
	            
	            if($vendor['c']['type'] == 'Perc') {
	                $vendor['s']['monthly_price']   =   $vendor['s']['monthly_price'] - ($vendor['s']['monthly_price'] * ($vendor['c']['discount'] / 100));
	                $vendor['s']['annual_price']    =   $vendor['s']['annual_price'] - ($vendor['s']['annual_price'] * ($vendor['c']['discount'] / 100));
	            } else {
	                $vendor['s']['monthly_price']   =   $vendor['s']['monthly_price'] - $vendor['c']['discount'];
	                $vendor['s']['annual_price']    =   $vendor['s']['annual_price'] - $vendor['c']['discount'];
	            }

            }
                
            /*
             *  Calculate the old and new package prices on a day basis and set the start date
             */
			
			 
            if($vendor['subscription_type'] == 'monthly') {
	          $sub_type          =  __('Monthly');
              $startdate         =  date('Y-m-d',strtotime($vendor['current_bill_end_date']));
              $days_this_month   =  cal_days_in_month ( CAL_GREGORIAN , date('m') , date('Y') );
              $day_rate_old_pkg  =  $vendor['s']['monthly_price'] / $days_this_month;
              $day_rate_new_pkg  =  $npackage['monthly_price'] / $days_this_month;
              $last_paid_amount  =  $vendor['s']['monthly_price'];
              $billing_period    =  $days_this_month;
	            /* APPLY VAT AND CONVERSION TO UPGRADE FIGURES  */
				if ($vendor['currency_choice'] == 'GBP') {
					$day_rate_old_pkg = $day_rate_old_pkg / $this->portal_settings['gbp_rate'];
					$day_rate_new_pkg = $day_rate_new_pkg / $this->portal_settings['gbp_rate'];
					$last_paid_amount = $last_paid_amount / $this->portal_settings['gbp_rate'];
				} elseif ($vendor['currency_choice'] == 'EUR') {
					$day_rate_old_pkg = $day_rate_old_pkg / $this->portal_settings['eur_rate'];
					$day_rate_new_pkg = $day_rate_new_pkg / $this->portal_settings['eur_rate'];
					$last_paid_amount = $last_paid_amount / $this->portal_settings['eur_rate'];
				};


            } else {
				$sub_type          =  __('Annual');
				$startdate         =  date('Y-m-d');
				$day_rate_old_pkg  =  $vendor['s']['annual_price'] / 365;
				$day_rate_new_pkg  =  $npackage['annual_price'] / 365;
				$last_paid_amount  =  $vendor['s']['annual_price'];
				$billing_period    =  365;
 	            /* APPLY  CONVERSION TO UPGRADE FIGURES  */
				if ($vendor['currency_choice'] == 'GBP') {
					$day_rate_old_pkg = $day_rate_old_pkg / $this->portal_settings['gbp_rate'];
					$day_rate_new_pkg = $day_rate_new_pkg / $this->portal_settings['gbp_rate'];
					$last_paid_amount = $last_paid_amount / $this->portal_settings['gbp_rate'];
				} elseif ($vendor['currency_choice'] == 'EUR') {
					$day_rate_old_pkg = $day_rate_old_pkg / $this->portal_settings['eur_rate'];
					$day_rate_new_pkg = $day_rate_new_pkg / $this->portal_settings['eur_rate'];
					$last_paid_amount = $last_paid_amount / $this->portal_settings['eur_rate'];
				};

            }

            $old_pkg_used_amount =  $day_rate_old_pkg * $days_used_pkg;                // Amount to charge this billing period for old package
            $new_pkg_req_amount  =  $day_rate_new_pkg * $days_balance_npkg;		       	 // Amount to charge this billing period for new package
            $balance_credit      =  round($last_paid_amount - $old_pkg_used_amount,2); // Calculate the amount of credit remaining
            
			/*
			*  Calculate how much the subscriber must pay to upgrade their package
			*/
			 
          $discount_amount     =  0;
                 
          if($vendor['subscription_type'] == 'monthly') {
	          
 	            /* APPLY VAT AND CONVERSION TO UPGRADE FIGURES  */
 	            
					if ($vendor['currency_choice'] == 'GBP') {
	              $trial_amount     =  $npackage['monthly_price'] / $this->portal_settings['gbp_rate'];
	              $regular_price		=  $npackage['monthly_price'] / $this->portal_settings['gbp_rate'];
						} elseif ($vendor['currency_choice'] == 'EUR') {
	              $trial_amount     =  $npackage['monthly_price'] / $this->portal_settings['eur_rate'];
	              $regular_price		=  $npackage['monthly_price'] / $this->portal_settings['eur_rate'];
						} else {
	              $trial_amount     =  $npackage['monthly_price'];
	              $regular_price		=  $npackage['monthly_price'];
            }
		            
          } else {
	            
					if ($vendor['currency_choice'] == 'GBP') {
	              $trial_amount     =  $npackage['annual_price'] / $this->portal_settings['gbp_rate'];
	              $regular_price		=  $npackage['annual_price'] / $this->portal_settings['gbp_rate'];
						} elseif ($vendor['currency_choice'] == 'EUR') {
	              $trial_amount     =  $npackage['annual_price'] / $this->portal_settings['eur_rate'];
	              $regular_price		=  $npackage['annual_price'] / $this->portal_settings['eur_rate'];
						} else {
	              $trial_amount     =  $npackage['annual_price'];
	              $regular_price		=  $npackage['annual_price'];
            }
            
          }
            
          if(isset($vendor['c']['discount'])&& $vendor['c']['discount'] > 0) {
	            
	          if($vendor['c']['type'] == 'Perc') {
		          
                $discount_amount =  round($new_pkg_req_amount *($vendor['c']['discount'] / 100),2);
                $trial_amount    =  round($trial_amount - ($trial_amount *($vendor['c']['discount'] /100)),2);
	            
	          } else {
		          
                $discount_amount =  round($vendor['c']['discount'],2);
                $trial_amount    =  $trial_amount - $discount_amount;
	            
	          }
	            
          }
            
            $trial_amount        =  round($trial_amount,2);
            
            $new_pkg_req_amount_before_discount  = $new_pkg_req_amount;
            $new_pkg_req_amount                  = $new_pkg_req_amount - $discount_amount;
            $new_balance_to_pay                  = round($new_pkg_req_amount - $balance_credit,2);

            /*
             *  If based in UK, add VAT
             */
             
            $vat = 0; // always set to zero as default
            $vat_perc = $this->portal_settings['VAT_rate'];
						if(substr($vendor['vat_no'], 0, 2) == 'GB') {
	            $vat = ($new_balance_to_pay / 100) * $vat_perc;
            }

            /*
             *  Retrieve existing subscription details from Authorize.net
             */
             
						$vpments    =  $this->VendorPayments->find()
			            	->where(['VendorPayments.vendor_id' => $vendor_id,'status' => 'Active'])->order(['id'=>'desc'])->first();
			                
						/*
						*  Insert details into the Invoice DB table
						*/
						$manager = $this->VendorManagers->find()->contain(['Users'])->where(['vendor_id'=>$vendor['id'],'primary_manager'=>'Y'])->first();
			
						$inv_arr['primary_manager']										=  ( $manager->has('user') ? ($manager->user->title!=''?$manager->user->title.' ':'').$manager->user->first_name.' '.$manager->user->last_name : '' ); // the primary manager's title and name, i.e. 'Mr John Smith'
						$inv_arr['company_name']											=  $vendor['company_name'];
						$inv_arr['company_address']									  =  $vendor['address'];
						$inv_arr['company_city']											=  $vendor['city'];
						$inv_arr['company_state']											=  $vendor['state'];
						$inv_arr['company_postcode']									=  $vendor['postalcode'];
						$inv_arr['company_country']										=  $vendor['country'];
						$inv_arr['customer_service']									=  $this->portal_settings['site_email'];   // the customer service email address retreived from the Admin > Settings table
						$inv_arr['sub_start_date']										=  date('Y-m-d', strtotime('-'.$days_used_pkg.' days'));
						$inv_arr['upgrade_date']											=  date('Y-m-d', time());
						$inv_arr['sub_end_date']											=  date('Y-m-d', strtotime('+'.($days_balance_npkg-1).' days'));
						$inv_arr['invoice_type']											=  __('Subscription Upgrade');						 // 'Subscription', 'Subscription Upgrade', or 'Other'
						$inv_arr['title']                  						=  $sub_type.' '.__('subscription');			 // 'Monthly Subscription' or 'Annual Subscription'
						$inv_arr['description']            						=  $npackage['name'].' '.__('package');
						$inv_arr['invoice_number']         						=  $this->portal_settings['invoice_prefix'].($this->portal_settings['last_invoice_id']+1). $this->portal_settings['invoice_suffix'];
						$inv_arr['vendor_id']              					  =  $vendor['id'];
						$inv_arr['invoice_date']           						=  date('Y-m-d h:i:s', time());
						$inv_arr['amount']                 						=  round($new_balance_to_pay + $vat,2);		 // Amount to pay (inc VAT if relevant)
						$inv_arr['subtotal']													=  round($new_balance_to_pay,2);										
						$inv_arr['vat_perc']													=  $vat_perc;															 
						$inv_arr['vat_number']												=  $vendor['vat_no'];											 // Vendor's VAT number
						$inv_arr['vat']																=  $vat;																	 // Amount of VAT charged
						$inv_arr['discount']               						=  round($discount_amount,2);							 // Discount amount given, from coupon code
						$inv_arr['currency']               						=  $vendor['currency_choice'];
						$inv_arr['old_package']            						=  $vendor['s']['name'].' '.__('package'); // Old package name
						$inv_arr['old_package_price']     						=  $last_paid_amount;											 // Last amount paid
						$inv_arr['billing_period_days']								=  $billing_period;												 // No. of days in current billing cycle (i.e. 365 or 28/29/30/31)
						$inv_arr['days_used']													=  $days_used_pkg;												 // No. of days consumed so far
						$inv_arr['new_package']            						=  $npackage['name'].' '.__('package');		 // New package name
						$inv_arr['package_price']          						=  round($regular_price,2);								 // New package recurring amount (before discount and additional fees)
						$inv_arr['balance_credit']         						=  round($balance_credit,2);							 // Last amount paid, less pro-rata old subscription amount
						$inv_arr['adjusted_package_price'] 						=  round($new_pkg_req_amount,2);           // Pro-rata new subscription amount, less discount
						$inv_arr['comments']               						=  __('There are').' '.$days_this_month.' '.__('days in the current billing cycle.  We have pro-rated your old and new subscriptions for you to take into account that').' '.$days_used_pkg.' '.__('days of this billing period have elapsed as at the date of upgrade.  Your future recurring subscription payment will be').' '.$vendor['currency_choice'].' '.number_format($trial_amount, 2, '.', ',').' '.__('for your').' '.$npackage['name'].' '.__('package.');
						$inv_arr['status']                 						=  'pending';
			      $invc                              						=  $this->Invoices->newEntity($inv_arr);
			      $inv_result                        						=  $this->Invoices->save($invc);
			      $last_invoice_id                   						=  $inv_result->id;
      
            /*
             *  Update the last invoice id in the settings table
             */
            
            $STquery = $this->Settings->query();
            $STquery->update()
              ->set(['settingvalue' => $last_invoice_id])
              ->where(['settingname' =>  'last_invoice_id'])
              ->execute();
            $this->request->session()->write('Invoice.id', $last_invoice_id);
            
            /*
             *  Update Subscription Amount
             */
            
            $this->request->session()->write('Invoice.new_package_price_next_billing', $trial_amount);
            $this->request->session()->write('Invoice.balance_in_credit', $balance_credit);
            $this->request->session()->write('Invoice.new_package_current_billing_price', $new_pkg_req_amount);
            $this->request->session()->write('Invoice.new_package_current_balance_price', $new_balance_to_pay);
            $arr['name']                      = __('Upgraded to ').$npackage['name'];
            $arr['amount']                    = $trial_amount;
            $arr['subscriptionId']            = $vpments->subscriptionid;
            $arr['currency_choice']           = $vendor['currency_choice'];
            $data["amount"]                   = $new_balance_to_pay;
            $data["customerProfileId"]        = $vpments->customerProfileId;
            $data["customerPaymentProfileId"] = $vpments->customerPaymentProfileId;
            $data["invoice_number"]           = $this->portal_settings['invoice_prefix'].$last_invoice_id. $this->portal_settings['invoice_suffix'];
            $data['invoice_description']      = $vendor['s']['name'].__(' subscription upgrade by '). $vendor['company_name'];

            if(strtotime($vendor['last_billed_date']) < strtotime(date('Y-m-d'))) {
              if($cmret = $this->Authorizecim->createTransaction($data) ) {
                $INVquery = $this->Invoices->query();
                $INVquery->update()
                  ->set(['status' => 'paid'])
                  ->where(['id' =>  $last_invoice_id])
                  ->execute();
              }
               
            } else {
              $INVquery = $this->Invoices->query();
                $INVquery->update()
                  ->set(['status' => 'paid'])
                  ->where(['id' =>  $last_invoice_id])
                  ->execute();
            }
            
			if($ret = $this->Net->UpdateSubscriptionAmount($arr)) {
				$vendQry  =   $this->Vendors->query();
				$vendQry->update()
					->set(['subscription_package_id' => $pkgid])
					->where(['id' =>  $vendor['id']])
					->execute();

				$this->Flash->success('Your subscription has been upgraded');
			
				/*
				*  Email an upgrade notification
				*/
				
				$auth   = $this->request->session()->read('Auth');
				$invdet = $this->request->session()->read('Invoice');
				$this->Prmsemails->upgradeInvoicemail($auth,$invdet);
				$this->request->session()->delete('Invoice');
				return $this->redirect(array('controller' => 'vendors', 'action' => 'profile')); 
			
			}
			
		/*
		*  Make an instant payment for invoice amount
		*/
		
		$this->Flash->error("Sorry, we couldn't upgrade the subscription. Please try again. If you continue to experience problems, please contact Customer Support.");
		return $this->redirect(array('controller' => 'vendors', 'action' => 'profile')); 
		
		}
            
  }

    
    /*
     *  Delete Partner
     */

    public function deletePartner($id=null){
        	
        $partner = $this->Partners->get($id, [
            'contain' => ['PartnerManagers','PartnerManagers.Users']
    ]); 
        if($this->Auth->user('vendor_id') != $partner->vendor_id){
            $this->Flash->error(' Sorry , You are not authorized to view the details');
            return $this->redirect(array('controller' => 'vendors', 'action' => 'partners'));
        }

        $this->request->allowMethod('post', 'delete');
        
        /*
         * Delete Partner managers
         */
        if(isset($partner['partner_managers']) && !empty($partner['partner_managers'])){
            foreach($partner['partner_managers'] as $pm){
               if(isset($pm->user)&& !empty($pm->user)){
                   $this->__delete_user($pm->user_id);
               }

            }
        }

        /*
         * Section to delete Patrners
         */
        $partnerlogo = $partner->logo_path;
        if ($this->Partners->delete($partner)) {
        		/* Delete OpenCloud Logo File */
	            if($partnerlogo!='')
	                $this->Opencloud->deleteObject($partnerlogo);

                $this->Flash->success('The partner has been deleted.');
        } else {
                $this->Flash->error('Sorry. the partner could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
        }
        return $this->redirect(['action' => 'partners']);
    }
    function __addUser($users){
        $user = $this->Users->newEntity($users);
        if($usr =   $this->Users->save($user)){
            return $usr->id;
        }
        return false;
    }
    function __addPartner($partners){
        $partner = $this->Partners->newEntity($partners);
        if($ptnr =   $this->Partners->save($partner)){

				$pid=   $ptnr->id;

	    		// upload and save logo url and path
	    		if(isset($partners['logo_url']))
	    		{
	    			$file_ext = substr(strrchr($partners['logo_url']['name'],'.'),1);
	    			$newfilepath = 'partners/' . $pid . '/partnerlogo.' . $file_ext;
	    			$this->Imagecreator->formatImage($partners['logo_url']['name'],$partners['logo_url']['tmp_name'],$this->portal_settings['logo_width']);
		    		if($this->Opencloud->addObject($newfilepath,$partners['logo_url']['tmp_name']))
				    {
				        $partner_logo['logo_url'] = $this->Opencloud->getobjecturl($newfilepath);
				        $partner_logo['logo_path'] = $newfilepath;
				        $partner = $this->Partners->patchEntity($partner, $partner_logo);
	            		$this->Partners->save($partner);
				    }
				}

            return $pid;
        }
        return false;
    }
    /*
     * Function to add partner manager
     */
    public function addPartnerManager($pid=null){
        $partner = $this->Partners->get($pid, [
                'contain' => ['PartnerManagers','PartnerManagers.Users']
        ]); 
        if($this->Auth->user('vendor_id') != $partner->vendor_id){
            $this->Flash->error('Sorry, you do not have permission to view the details.');
            return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
        }
        if(isset($this->request->data['email'])){
            $this->request->data['username']   =   $this->request->data['email'];
        }
        $user = $this->Users->newEntity($this->request->data);
        if ($this->request->is('post')) {
            if($this->request->data['conf_password'] == $this->request->data['password']){
                if ($uresult = $this->Users->save($user)) {
                    $this->request->data['partner_manager']['user_id'] =   $uresult->id;
                    $this->request->data['partner_manager']['status'] = 'Y';
                   if($this->__addPmanager($this->request->data['partner_manager'])){
                       $udata  =   $this->request->data;
                       $this->Prmsemails->userSignupemail($udata);
                       $this->Flash->success(__('Partner Manager has been added successfully.'));
                       return $this->redirect(['action' => 'viewPartner',$pid]);
                   }

                }
                 $this->Flash->error(__('Sorry, we were unable to add the Partner Manager. Please try again. If you continue to experience problems, please contact Customer Support.'));
            }else{
                 $this->Flash->error(__('Sorry, your passwords don\'t match. Please try again.'));
            }

        }
        $this->set('user', $user);
        $this->set('partner_id', $pid);
    }
    function __addPmanager($pmgr){
        $this->loadModel('PartnerManagers');
        $manager = $this->PartnerManagers->newEntity($pmgr);
        if($this->PartnerManagers->save($manager)){
            return true;
        }
        return false;
    }
    public function viewPartnerManager($id = null) {
        
        
        $partnerManager = $this->PartnerManagers->get($id, [
                'contain' => ['Partners', 'Users','CampaignPartnerMailinglistDeals.CampaignPartnerMailinglists.Campaigns']
        ]);
        $vid=   $partnerManager['partner']->vendor_id;
        if($this->Auth->user('vendor_id') != $vid){
            $this->Flash->error('Sorry, you do not have permission to view the details.');
            return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
        }
        $this->set('partnerManager', $partnerManager);
    }
    public function editPartnerManager($id = null) {
        
        $partnerManager = $this->PartnerManagers->get($id, [
                   'contain' => ['Partners', 'Users']
           ]);
        $vid=   $partnerManager['partner']->vendor_id;
        if($this->Auth->user('vendor_id') != $vid){
            $this->Flash->error('Sorry, you do not have permission to view the details.');
            return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
        }
         $user = $this->Users->get($partnerManager->user_id, [
               'contain' => []
        ]);
        if ($this->request->is(['post', 'put'])) {
               $user = $this->Users->patchEntity($user, $this->request->data);
               if ($this->Users->save($user)) {
                    $this->Flash->success('The partner manager has been saved.');
                    return $this->redirect(['action' => 'viewPartner',$partnerManager->partner_id]);
                
               } else {
                       $this->Flash->error('The partner manager could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
               }
        }

        $this->set('user', $user);
        $this->set('partner_id',$partnerManager->partner_id);
         
    }
    public function deletePartnerManager($id=null){
        $this->request->allowMethod('post', 'delete');
        $partnermanager = $this->PartnerManagers->get($id, ['contain' => ['Partners', 'Users']]); 
        $vid   =  $this->Auth->user('vendor_id');
        if($vid != $partnermanager['partner']->vendor_id){
            $this->Flash->error('Sorry, you do not have permission to delete.');
            return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
        }
        if($partnermanager->primary_contact == 'Y'){
           $this->Flash->error(__('The primary manager cannot be deleted. Please assign another manager as the primary manager and then try again. If you continue to experience problems, please contact Customer Support.'));

        }else{
            if($this->__delete_user($partnermanager->user_id)){
                $this->Flash->success(__('Partner Manager has been deleted successfully.'));
            }else{
                $this->Flash->error(__('Sorry, we couldn\'t delete the partner manager. Please try again. If you continue to experience problems, please contact Customer Support.'));
            }

        }
        return $this->redirect(['action' => 'viewPartner',$partnermanager->partner_id]);

    } 
    public function changePrimaryPmanager($id = null) {
        $partnermanager = $this->PartnerManagers->get($id, ['contain' => ['Partners', 'Users']]); 
        $vid   =  $this->Auth->user('vendor_id');
        if($vid != $partnermanager['partner']->vendor_id){
              $this->Flash->error('Sorry, you do not have permission to view the details.');
              return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
          }
        if($id > 0){
            $this->request->allowMethod('post', 'put');
            $this->PartnerManagers->updateAll(['primary_contact' => 'N'], ['partner_id' => $partnermanager->partner_id]);
            $this->PartnerManagers->updateAll(['primary_contact' => 'Y'], ['id' => $id,'partner_id' => $partnermanager->partner_id]);
            $this->Flash->success(__('The primary manager has been changed successfully.'));

        }
         return $this->redirect(['action' => 'viewPartner',$partnermanager->partner_id]);
    }
    public function changePartnerStatus($id=null,$status= 'Y'){
        if($id > 0){
        $partner = $this->Partners->get($id, [
            'contain' => ['PartnerManagers','PartnerManagers.Users']
    ]); 
        if($this->Auth->user('vendor_id') != $partner->vendor_id){
            $this->Flash->error('Sorry, you do not have permission to view the details.');
            return $this->redirect(array('controller' => 'vendors', 'action' => 'index'));
        }
            $this->request->allowMethod('post', 'put');
            if($this->__updatePartnerUsers($id,$status)){
                $Vquery = $this->Partners->query();
                $Vquery->update()
                     ->set(['status' => $status,'status_change_date' => time()])
                     ->where(['id' =>  $id])
                     ->execute();
                $this->Flash->success(__('The partner status has been updated.'));
            }
        }
        return $this->redirect(['action' => 'partners']);
    }
    function __updatePartnerUsers($id=null,$status= 'Y'){
        if($id > 0){
            /*
             * Find partner users 
             */
            $vusers =   array();
            $pmanagers = $this->Users->find()
                ->hydrate(false)
                ->select(['Users.id'])
                ->join([
                    'm' => [
                        'table' => 'partner_managers',
                        'type' => 'INNER',
                        'conditions' => [
                            'users.id = m.user_id'
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

            $this->Users->updateAll(['status' => $status], ['Users.id IN' => $vusers]);
        }
         return true;
    }
    /*
     * Function to upgrade to next package for more e-mails
     */
    public function sendUpgrade(){
        if($pkg = $this->__findMyNextPackage('email')){
           $this->set('package', $pkg);
           /*
            * Section to find current package details...
            */
            $id = $this->Auth->user('vendor_id');
            $vendor = $this->Vendors->find()
                        ->hydrate(false)
                        ->select(['Vendors.id', 'Vendors.currency_choice', 'Vendors.subscription_type','s.no_emails','s.no_partners','s.annual_price','s.monthly_price','s.duration','s.name'])
                        ->join([
                            
                            
                            's' => [
                                'table' => 'subscription_packages',
                                'type' => 'INNER',
                                'conditions' => 'Vendors.subscription_package_id = s.id',
                            ]
                        ])
                        ->where(['Vendors.id' => $id])->first();
            //print_r($vendor);exit;
            $vendor['GBP_rate'] = $this->portal_settings['gbp_rate'];
            $vendor['EUR_rate'] = $this->portal_settings['eur_rate'];

            $this->set('current_package', $vendor);
            
        }else{
            $this->Flash->error('Your have reached your maximum number of sends. No higher subscription package available. Please contact Customer Support to discuss your requirements as we may be able to create a custom package for you.');
            return $this->redirect(array('controller' => 'Vendors', 'action' => 'index')); 
        }
    }
    /*
     * Function to create financial quarters...
     */
    function updateFinanceQuarters(){
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
                                                    ->where(['Financialquarters.vendor_id'=>$vendor['id'],'Financialquarters.enddate > '=>time()])
                                                    ->order(['Financialquarters.enddate  '=> 'ASC']);
                $skipflag = 0;
                foreach($qrter as $qt){
                    $skipflag ++;
                    
                }
                //echo $last_qrtr_number;exit;
                $i=4 - $skipflag;
                
                if($i > 0){
	                
                   $this->__createquarters($vendor['financial_quarter_start_month'],$i,$vendor['id']);
                }

	        }  else{
				echo "IN";
                $this->__createquarters($vendor['financial_quarter_start_month'],4,$vendor['id']);
	                
	        }
        }
       
       return true;

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
    /*
     * Function to export list of partners.....
     */
    public function exportpartners($keyword=''){
        
        if ($keyword !='') {
            $lkeyword  =   '%'.$keyword.'%';
            if(trim($keyword) != ''){
                 $partners = $this->Partners->find('all')->where(['Partners.company_name LIKE ' => $lkeyword])
                                                   ->orWhere(['Partners.website LIKE ' => $lkeyword])
                        ->orWhere(['Partners.address LIKE ' => $lkeyword])
                        ->orWhere(['Partners.country LIKE ' => $lkeyword])
                        ->orWhere(['Partners.city LIKE ' => $lkeyword])
                        ->orWhere(['Partners.state LIKE ' => $lkeyword])
                        ->andWhere(['Partners.vendor_id' => $this->Auth->user('vendor_id')]);
            }else{
               $partners   =   $this->Partners->find('all')->where(['Partners.vendor_id' => $this->Auth->user('vendor_id')]);
            }

        }else{
            $partners   =   $this->Partners->find('all')->where(['Partners.vendor_id' => $this->Auth->user('vendor_id')]);
        }
        $partnerdata    =   array();
        $i=0;
        $partnerdata[$i]['company_name']  =   'Company Name';
        $partnerdata[$i]['email']         =   'Email';
        $partnerdata[$i]['phone']         =   'Phone';
        $partnerdata[$i]['website']       =   'Website';
        $partnerdata[$i]['address']       =   'Address';
        $partnerdata[$i]['city']          =   'City';
        $partnerdata[$i]['state']         =   'State';
        $partnerdata[$i]['country']       =   'Country';
        $partnerdata[$i]['postal_code']   =   'Zip / Post Code';
        $i++;
        if($partners->count()>0){
            foreach($partners as $prtnr):
                $partnerdata[$i]['company_name']  =   $prtnr->company_name;
                $partnerdata[$i]['email']         =   $prtnr->email;
                $partnerdata[$i]['phone']         =   $prtnr->phone;
                $partnerdata[$i]['website']       =   $prtnr->website;
                $partnerdata[$i]['address']       =   $prtnr->address;
                $partnerdata[$i]['city']          =   $prtnr->city;
                $partnerdata[$i]['state']         =   $prtnr->state;
                $partnerdata[$i]['country']       =   $prtnr->country;
                $partnerdata[$i]['postal_code']   =   $prtnr->postal_code;
                $i++;
            endforeach;
        }   
        $this->Filemanagement->getExportcsv($partnerdata,'partnerlist.csv', ',');
        echo __("Export completed");
        exit;
    }
 
 
    public function importpartners() {
		   
		   //get data from users table to check emails against emails about to be input via csv

    	if($this->request->is(['post']))
    	{
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
				//$my_array = array();
				$skiplist = array();
				$thisvendorid = $this->Auth->user('vendor_id');

				$i=-1;
				$partnersaved = false;
				$usersaved = false;
				$partnermanagersaved = false;

				// Determine allowable number of partners
                $vendor = $this->Vendors->get($thisvendorid, ['contain'=>['SubscriptionPackages','Partners']]);
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
					
					
					$partners_array['company_name']			=		$row['']['company_name'];
					$partners_array['email']				=		$row['']['email'];
					$partners_array['phone']				=		$row['']['phone'];
					$partners_array['website']				=		$row['']['website'];
					$partners_array['twitter']				=		$row['']['twitter'];
					$partners_array['facebook']				=		$row['']['facebook'];
					$partners_array['linkedin']				=		$row['']['linkedin'];
					$partners_array['address']				=		$row['']['address'];
					$partners_array['city']					=		$row['']['city'];
					$partners_array['state']				=		$row['']['state'];
					$partners_array['country']				=		$row['']['country'];
					$partners_array['postal_code']			=		$row['']['postal_code'];
					$partners_array['vendor_manager_id']	=		$thisvendorid;
					
					//set random password
					$rchars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
					$rpassword = substr( str_shuffle( $rchars ), 0, 8 );
					
					$userdata_array['username']			=		$row['']['email'];
					$userdata_array['email']			=		$row['']['email'];
					$userdata_array['password']			=		$rpassword;
					$userdata_array['status']			=		'Y';
					$userdata_array['role']				=		'partner';
					$userdata_array['first_name']		=		$row['']['first_name'];
					$userdata_array['last_name']		=		$row['']['last_name'];
					$userdata_array['job_title']		=		$row['']['job_title'];
					$userdata_array['title']			=		$row['']['title'];
					$userdata_array['phone']			=		$row['']['phone'];
					
					

									
					
					
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
		
					$partners = $this->Partners->newEntity(array_merge($partners_array,['vendor_id'=>$this->Auth->user('vendor_id')]));
					
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
						$this->Prmsemails->userSignupemail($userdata_array);
					}
					
					$partnerManagerdata['partner_id']		=		$partner_id;
					$partnerManagerdata['user_id']			=		$user_id;
					$partnerManagerdata['status']			=		'Y';
					$partnerManagerdata['primary_contact']	=		'Y';
					
					$partnermanagers = $this->PartnerManagers->newEntity($partnerManagerdata);
					
					if ($this->PartnerManagers->save($partnermanagers)) {
						$partnermanagersaved = true;
					}

					}
					
					if ($partnersaved == true && $usersaved == true && $partnermanagersaved == true) {
						
						if (!empty($skiplist)) {
							$message 	= 	"The import completed, but some partners could not be added as the email address used already exists and is associated with a user - ";
							foreach ($skiplist as $row) {
								$message.=  $row . ", ";
							}			
						}
						else {
							$message = 'The import completed successfully.';
						}
						$this->Flash->success($message);
						return $this->redirect(array('controller' => 'vendors', 'action' => 'partners'));
					}
					else {
						if($overload==true)
						{
                            $this->Flash->error('You are only allowed to add '.($no_partners_allowed - $current_no_partners) . ' partners. Please remove some data from your csv sheet.');
                            $this->Flash->error('Please upgrade to increase your partner limit, or remove an existing partner to make space for the new ones.');
        					return $this->redirect(array('controller' => 'Vendors', 'action' => 'suggestUpgrade'));
						}
                        else
                        {
							$this->Flash->error('There was a problem with the upload, please try again ensuring the columns are formatted and ordered as per the template, and check that this file has not previously been uploaded');
							return $this->redirect(array('controller' => 'vendors', 'action' => 'partners'));
                        }						
					}
					
				}
				else
					$this->Flash->error('Please make sure to select a valid csv file');

			}
		
		}
    


    
}
