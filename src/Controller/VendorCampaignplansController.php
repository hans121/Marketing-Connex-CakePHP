<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
/**
 * VendorCampaignplans Controller
 *
 * @property App\Model\Table\VendorCampaignplansTable $VendorCampaignplans
 */
class VendorCampaignplansController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->loadModel('Businesplans');
        $this->loadModel('Campaigns');
        $this->loadModel('Vendors');
        $this->loadModel('Partners');
        $this->loadModel('PartnerCampaigns');
        $this->loadModel('LandingForms');
        $this->loadModel('Financialquarters');
        $this->loadModel('PartnerViewTracks');
        $this->loadModel('BusinesplanCampaigns');
        //$this->Auth->allow(['view','downloadfile']);
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
        $this->loadModel('VendorViewTracks');
                $this->paginate = [
            'contain' => ['Partners', 'Financialquarters', 'Vendors','BusinesplanCampaigns','BusinesplanCampaigns.Campaigns'],
                        'conditions' => ['Businesplans.vendor_id' => $this->Auth->user('vendor_id'),'Businesplans.status NOT IN' =>['Draft']],
        ];
                /*
                 * Section to filter 
                 */
                $whereconditions = array();
                if(isset($this->request->data['id']) && $this->request->data['id']!= ''){
                    $filters['id']=$this->request->data['id'];
                    $whereconditions['Businesplans.id'] =   $this->request->data['id'];
                }else{
                    $filters['id']='';
                }
                if(isset($this->request->data['campaign_id']) && $this->request->data['campaign_id']!= ''){
                    $filters['campaign_id']=$this->request->data['campaign_id'];
                   $whereconditions['BusinesplanCampaigns.campaign_id'] =   $this->request->data['campaign_id'];
                }else{
                    $filters['campaign_id']='';
                }
                if(isset($this->request->data['financialquarter_id']) && $this->request->data['financialquarter_id']!= ''){
                    $filters['financialquarter_id']=$this->request->data['financialquarter_id'];
                    $whereconditions['Businesplans.financialquarter_id'] =   $this->request->data['financialquarter_id'];
                }else{
                    $filters['financialquarter_id']='';
                }
                if(isset($this->request->data['partner_id']) && $this->request->data['partner_id']!= ''){
                    $filters['partner_id']=$this->request->data['partner_id'];
                    $whereconditions['Businesplans.partner_id'] =   $this->request->data['partner_id'];
                }else{
                    $filters['partner_id']='';
                }
                if(isset($this->request->data['status']) && $this->request->data['status']!= ''){
                    $filters['status']=$this->request->data['status'];
                    $whereconditions['Businesplans.status'] =   $this->request->data['status'];
                }else{
                    $filters['status']='';
                }

                $bps_partners_q = $this->Businesplans->find()->select(['partner_id'])->group(['partner_id']);
                foreach($bps_partners_q as $q)
                	$bps_partners[] = $q->partner_id;
        
                $bps_quarters_q = $this->Businesplans->find()->select(['financialquarter_id'])->group(['financialquarter_id']);
                foreach($bps_quarters_q as $q)
                	$bps_quarters[] = $q->financialquarter_id;
                
                $bps_campaigns_q = $this->BusinesplanCampaigns->find()->select(['campaign_id'])->group(['campaign_id']);
                foreach($bps_campaigns_q as $q)
                	$bps_campaigns[] = $q->campaign_id;
                
                $partners = $this->Partners->find('list')->where(['Partners.vendor_id'=>$this->Auth->user('vendor_id'),'id IN'=>$bps_partners]);
                $financialquarters = $this->Financialquarters->find('list')->where(['vendor_id'=>$this->Auth->user('vendor_id'),'id IN'=>$bps_quarters]);
                $campaigns = $this->Campaigns->find('list')->where(['vendor_id'=>$this->Auth->user('vendor_id'),'id IN'=>$bps_campaigns]);
                $statuses = $this->Businesplans->find()->select(['status'])->group(['status']);
                $stoptions = array();
                foreach($statuses as $status)
                    $stoptions[$status->status] = $status->status;
                //$partners = $this->Partners->find('list')->where(['vendor_id'=>$this->Auth->user('vendor_id')]);
                //$campaigns = $this->Campaigns->find('list')->where(['vendor_id'=>$this->Auth->user('vendor_id')]);
                //$financialquarters = $this->Financialquarters->find('list')->where(['vendor_id'=>$this->Auth->user('vendor_id')]);
                if ($this->request->is(['post', 'put'])) {
                    
                    if(!empty($whereconditions)){
                         $query = $this->Businesplans->find('all')->where($whereconditions);
                         
                    }else{
                       $query   =   $this->Businesplans->find();
                    }
                    if(isset($this->request->data['campaign_id']) && $this->request->data['campaign_id']!= ''){
                        $cmp_id =   $this->request->data['campaign_id'];
                        $query->matching('BusinesplanCampaigns', function($q) use($cmp_id) {
                            return $q->where(['BusinesplanCampaigns.campaign_id' => $cmp_id]);
                        });
                    }
                }else{
                    $query   =   $this->Businesplans->find('all');//->where(['Businesplans.status'=>'Submit']);

                }
                
                $this->set('businesplans', $this->paginate($query));
                $myviewedbpln   =   $this->VendorViewTracks->find('all')
                                                            ->where(['vendor_id'=>$this->Auth->user('vendor_id'),'type'=>'Campaignplan'])
                                                            ->hydrate(false);
                $myviewedbplnsarray = array();
                foreach($myviewedbpln as $mvcps){
                    $myviewedbplnsarray[]   =   $mvcps['businesplan_id'];
                }
                $this->set('myviewedbplnsarray', $myviewedbplnsarray);
                $this->set(compact('filters', 'partners', 'financialquarters', 'campaigns','stoptions'));
    }

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
    public function view($id = null) {
    global $businesplan;
        $businesplan = $this->Businesplans->get($id, [
            'contain' => ['Partners', 'Financialquarters', 'Vendors', 'BusinesplanCampaigns','BusinesplanCampaigns.Campaigns']
        ]);
        
                if($this->Auth->user('vendor_id') != $businesplan->vendor_id){
                    $this->Flash->error('Sorry, you do not have permission to view the details.');
                    return $this->redirect(array('controller' => 'Businesplans', 'action' => 'index'));
                }
                
                // Calculate ROI
                $partners_financialquarter = $this->Partners
                    ->find('all')
                    ->contain(['PartnerCampaigns.Campaigns.Financialquarters'=> function ($q) {
                                    global $businesplan;
                                    return $q->where(['Financialquarters.id'=>$businesplan->financialquarter_id,'Campaigns.financialquarter_id=Financialquarters.id']);
                            },'PartnerCampaigns.Campaigns.CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=> function ($q) {
                                    return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
                            }])
                    ->order(['Partners.company_name'=>'ASC'])
                    ->where(['Partners.id'=>$businesplan->partner_id]);

                $actual_roi = 0;
                foreach($partners_financialquarter as $row)
                {
                        //print_r($row);
                        $deals_count = 0;
                        $deals_value = 0;
                        foreach($row->partner_campaigns as $partner_campaigns)
                                foreach($partner_campaigns->campaign->campaign_partner_mailinglists as $campaign_partner_mailinglists)
                                        foreach($campaign_partner_mailinglists->campaign_partner_mailinglist_deals as $deal) {
                                                $deals_value += $deal->deal_value;
                                                $deals_count++;
                                        }
                        $campaigns_completed = 0;
                        $campaigns_active = 0;
                        $expected_revenue = 0;
                        $campaign_sendlimit = 0;
                        $campaign_total = 0;
                        foreach($row->partner_campaigns as $partner_campaign)
                        {
                                $campaign = $partner_campaign->campaign;
                                //print_r($campaign);
                                if($campaign->financialquarter){
                                        $campaign_sendlimit += $campaign->send_limit;
                                        if($campaign->status=='Y')
                                                $campaigns_completed++;

                                        if($partner_campaign->status=='A')
                                                $campaigns_active++;

                                        $expected_revenue += $campaign->sales_value;
                                        $campaign_total++;
                                }
                        }
                        //Get subscription package details
                        $vendor = $this->Vendors->get($this->Auth->user('vendor_id'),[
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
                        //save to actual roi
                        $actual_roi += $roi;
                }
                // end ROI
        
        $this->set(compact('businesplan','actual_roi'));
                $this->__insertViewTrack($id);
    }
        /*
         * Function to approve or deny 
         */
        public function approveplan($id=0,$status='',$msg=''){
            if($id > 0 && $status !=''){
                $businesplan = $this->Businesplans->get($id,['contain' => ['Partners', 'Financialquarters', 'Vendors', 'BusinesplanCampaigns','BusinesplanCampaigns.Campaigns']]);
                $businesplan = $this->Businesplans->patchEntity($businesplan, ['status'=>$status,'note'=>$msg]);
                if ($this->Businesplans->save($businesplan)) {
                    if($status == 'Approved')    {
                        /*
                         * section to send email notifications
                         */
                        $this->__createpartnercampaigns($id);
                        $this->Prmsemails->partnerbpapprovalnotification($businesplan['partner']->email,$businesplan['financialquarter']->quartertitle);
                        // Find duplicate campaigns and mark denied
                        $bpcmpgns   =   $this->BusinesplanCampaigns->find()->select(['campaign_id'])->where(['businesplan_id'=>$businesplan->id]);
                        $bpcmpgnids = array();
                        foreach($bpcmpgns as $cmp)
                        	$bpcmpgnids[] = $cmp->campaign_id;
                        
                        $businessplans = $this->Businesplans->find()->contain(['Partners', 'Financialquarters','BusinesplanCampaigns'])->where(['Businesplans.partner_id'=>$businesplan->partner_id,'Businesplans.vendor_id'=>$businesplan->vendor_id,'Businesplans.status'=>'Submit','Businesplans.id !='=>$businesplan->id]);
                        foreach($businessplans as $bp)
                        {
                        	$isdup = false;
                        	if(isset($bp->businesplan_campaigns))
                        		foreach($bp->businesplan_campaigns as $bpc)
                        			if(in_array($bpc->campaign_id,$bpcmpgnids))
                        				$isdup = true;
                        			
                        	if($isdup===true)
                        	{
                        		// Notify Partner
                        		$bp = $this->Businesplans->patchEntity($bp, ['status'=>'Denied','note'=>'Declined for duplicate campaign that has been approved already']);
                        		$bp = $this->Businesplans->save($bp);
                        		$this->Prmsemails->partnerbpdeclinenotification($bp['partner']->email,$bp['financialquarter']->quartertitle);
                        	}
                        }
                        // end
                        $this->Flash->success('The campaign plan has been approved.');
                    } elseif($status == 'Denied'){
                        /*
                         * section to send email notifications
                         */
                        $this->Prmsemails->partnerbpdeclinenotification($businesplan['partner']->email,$businesplan['financialquarter']->quartertitle);
                        $this->Flash->success('The campaign plan has been declined.');
                    }else{
                        $this->Flash->success('The campaign plan has been saved.');
                    }
                    return $this->redirect( $this->referer());
                } else {
                        $this->Flash->error('The campaign plan could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                        return $this->redirect( $this->referer());
                }
        
            }
        }
        /*
         * Function to filter campaignplans list using ajax
         */
        public function ajaxindex(){
            $this->loadModel('VendorViewTracks');
            $this->layout = 'ajax';
            if ($this->request->is(['patch', 'post', 'put'])) {
                $this->paginate = [
            'contain' => ['Partners', 'Financialquarters', 'Vendors','BusinesplanCampaigns','BusinesplanCampaigns.Campaigns'],
                        'conditions' => ['Businesplans.vendor_id' => $this->Auth->user('vendor_id'),'Businesplans.status NOT IN' =>['Draft']],
        ];
                /*
                 * Section to filter 
                 */
                $whereconditions = array();
                if(isset($this->request->data['id']) && $this->request->data['id']!= ''){
                    $whereconditions['Businesplans.id'] =   $this->request->data['id'];
                }
                if(isset($this->request->data['campaign_id']) && $this->request->data['campaign_id']!= ''){
                    $whereconditions['BusinesplanCampaigns.campaign_id'] =   $this->request->data['campaign_id'];
                }
                if(isset($this->request->data['financialquarter_id']) && $this->request->data['financialquarter_id']!= ''){
                    $whereconditions['Businesplans.financialquarter_id'] =   $this->request->data['financialquarter_id'];
                }
                if(isset($this->request->data['partner_id']) && $this->request->data['partner_id']!= ''){
                    $whereconditions['Businesplans.partner_id'] =   $this->request->data['partner_id'];
                }
                if(isset($this->request->data['status']) && $this->request->data['status']!= ''){
                    $whereconditions['Businesplans.status'] =   $this->request->data['status'];
                }
                if(!empty($whereconditions)){
                     $query = $this->Businesplans->find('all')->where($whereconditions);

                }else{
                   $query   =   $this->Businesplans->find();
                }
                if(isset($this->request->data['campaign_id']) && $this->request->data['campaign_id']!= ''){
                    $cmp_id =   $this->request->data['campaign_id'];
                    $query->matching('BusinesplanCampaigns', function($q) use($cmp_id) {
                        return $q->where(['BusinesplanCampaigns.campaign_id' => $cmp_id]);
                    });
                }
                $this->set('businesplans', $this->paginate($query));
            }
            $myviewedbpln   =   $this->VendorViewTracks->find('all')
                                                        ->where(['vendor_id'=>$this->Auth->user('vendor_id'),'type'=>'Campaignplan'])
                                                        ->hydrate(false);
            $myviewedbplnsarray = array();
            foreach($myviewedbpln as $mvcps){
                $myviewedbplnsarray[]   =   $mvcps['businesplan_id'];
            }
            $this->set('myviewedbplnsarray', $myviewedbplnsarray);
        }

        /*
         * Function for dynamic filter
         */
        function ajaxdynamicfilter() {
             $this->layout = 'ajax';

             $partner_id = $this->request->data['partner_id'];
             $quarter_id = $this->request->data['quarter_id'];
             $campaign_id = $this->request->data['campaign_id'];
             $status = $this->request->data['status'];

             $campaignplan = $this->Businesplans
                ->find('all')
                ->contain(['Partners','Financialquarters'])
                ->select(['Businesplans.id','Partners.id','Partners.company_name','Financialquarters.id','Financialquarters.quartertitle','Businesplans.status']);

            $whereconditions = array();

            if($campaign_id!='') {
                $campaign = $this->BusinesplanCampaigns
                ->find('all')
                ->where(['BusinesplanCampaigns.campaign_id'=>$campaign_id])
                ->toArray();


                $bps = array();
                foreach($campaign as $c)
                    $bps[] = $c->businesplan_id;

                $whereconditions['Businesplans.id IN'] = $bps;
            }
            else {                
                if($partner_id!='')
                    $whereconditions['Businesplans.partner_id'] = $partner_id;
                if($quarter_id!='')
                    $whereconditions['Businesplans.financialquarter_id'] = $quarter_id;
                if($status!='')
                    $whereconditions['Businesplans.status'] = $status;
            }
                
            if(count($whereconditions)>0)
                $campaignplan->where($whereconditions);

            $campaignplan->toArray();

            $partners = array();
            $quarters = array();
            $statuses = array();
            $campaignplans = array();
            foreach($campaignplan as $bp) {
                $partners[$bp->partner->id] = $bp->partner->company_name;
                $quarters[$bp->financialquarter->id] = $bp->financialquarter->quartertitle;
                $statuses[$bp->status] = $bp->status;
                $campaignplans[$bp->id] = $bp->id;
            }

            $campaign = $this->BusinesplanCampaigns
                ->find('all')
                ->contain(['Campaigns'])
                ->where(['BusinesplanCampaigns.businesplan_id IN'=>$campaignplans])
                ->toArray();


            $campaigns = array();
            foreach($campaign as $c)
                $campaigns[$c->campaign_id] = $c->campaign->name;

            $data = array('partners'=>$partners,'quarters'=>$quarters,'statuses'=>$statuses,'campaigns'=>$campaigns);

            echo json_encode($data);
        }


        /*
         * Function to insert vendor view track
         */
        function __insertViewTrack($bp_id){
            $this->loadModel('VendorViewTracks');
            $vendor_id   =   $this->Auth->user('vendor_id');
            if($bp_id > 0){
                $vtrecords  = $this->VendorViewTracks->find()
                                                      ->hydrate(false)
                                                      ->where(['businesplan_id'=>$bp_id,'vendor_id'=>$vendor_id])
                                                      ->first();
                if(isset($vtrecords['id'])&&$vtrecords['id'] > 0){
                    return false;
                    // Already exists a record in the tabe...
                }else{
                    $vrec               =   array();
                    $vrec['vendor_id']  =   $vendor_id;
                    $vrec['businesplan_id']=   $bp_id;
                    $vrec['type']       =   'Campaignplan';
                    $vrec['viewstatus'] =   'Viewed';
                    $vendorViewTracks  = $this->VendorViewTracks->newEntity($vrec);
                    if ($this->VendorViewTracks->save($vendorViewTracks)) {
                            return true;
                    }
                }
            }
            return false;  
        }
        /*
         * Function to insert campaigns to partner campaigns table on campaign plan approval....
         */
        function __createpartnercampaigns($bp_id=0){
            $rtflag =   false;
            if($bp_id > 0){
                $bpdetails = $this->Businesplans->get($bp_id,['contain' => ['Partners', 'Financialquarters', 'Vendors', 'BusinesplanCampaigns','BusinesplanCampaigns.Campaigns']
        ]);
                $bpcmpgns   =   $this->BusinesplanCampaigns->find('all')->where(['businesplan_id'=>$bp_id]);
                if(isset($bpcmpgns) && !empty($bpcmpgns)){
                    foreach($bpcmpgns as $cmpgns){
                        $rtflag =   false;
                        $prtcmpg    = array();
                        if(isset($cmpgns->campaign_id) && $cmpgns->campaign_id > 0){
                            $prtcmpg['campaign_id']     =   $cmpgns->campaign_id;
                            $prtcmpg['businesplan_id']  =   $bp_id;
                            $prtcmpg['partner_id']      =   $bpdetails->partner_id;
                            $prtcmp                     =   $this->PartnerCampaigns->newEntity($prtcmpg);
                            if($this->PartnerCampaigns->save($prtcmp)){
                                $rtflag =   true;
                            }
                            
                        }
                        
                    }
                }
            }
            if(true == $rtflag){
                return true;
            }else{
                return false;
            }
            
        }
}
