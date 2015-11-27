<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
/**
 * Campaignplans Controller
 *
 * @property App\Model\Table\BusinesplansTable $Businesplans
 */
class CampaignplansController extends AppController {

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->layout = 'admin';
        $this->loadModel('Campaigns');
        $this->loadModel('PartnerCampaigns');
        $this->loadModel('LandingForms');
        $this->loadModel('Financialquarters');
        $this->loadModel('PartnerViewTracks');
        $this->loadModel('BusinesplanCampaigns');
        $this->loadModel('Businesplans');
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
            
        }elseif(isset($user['role']) && $user['role'] === 'partner') {
            //if (in_array($this->request->action, ['edit', 'delete'])) {
                
           // }
            return true;
        }elseif(isset($user['role']) && $user['role'] === 'vendor') {
            //if (in_array($this->request->action, ['edit', 'delete'])) {
                
           // }
            //return true;
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
		$this->paginate = [
			'contain' => ['Partners', 'Financialquarters', 'Vendors'],
                        'conditions' => ['partner_id' => $this->Auth->user('partner_id')],
		];
		$this->set('businesplans', $this->paginate($this->Businesplans));
                $myviewedbpln   =   $this->PartnerViewTracks->find('all')
                                                            ->where(['partner_id'=>$this->Auth->user('partner_id'),'type'=>'Businessplan'])
                                                            ->hydrate(false);
                $myviewedbplnsarray = array();
                foreach($myviewedbpln as $mvcps){
                    $myviewedbplnsarray[]   =   $mvcps['businesplan_id'];
                }
                $this->set('myviewedbplnsarray', $myviewedbplnsarray);
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function view($id = null) {
		$businesplan = $this->Businesplans->get($id, [
			'contain' => ['Partners', 'Financialquarters', 'Vendors', 'BusinesplanCampaigns','BusinesplanCampaigns.Campaigns']
		]);
                if($this->Auth->user('partner_id') != $businesplan->partner_id){
                    $this->Flash->error(' Sorry , You are not authorized to view the details');
                    return $this->redirect(array('controller' => 'Campaignplans', 'action' => 'index'));
                }
                $this->__insertViewTrack($id);
		$this->set('businesplan', $businesplan);
	}

/**
 * Add method
 *
 * @return void
 */
	public function add($dupid=0,$cmpid=0,$fqid=0) {
        // set default quarter and campaign to prefill fields
        $this->set(compact(['cmpid','fqid']));

        $this->loadModel('Partners');
        if($dupid > 0){
            $this->__insertViewTrack($dupid);
        }
        $bpcampaigns    =   array();
        $error = false;
		if(isset($this->request->data['campaign_id'])){
            $campaignsselected  =   $this->request->data['campaign_id'];
			
           unset($this->request->data['campaign_id']);
            $req_amt=   0;
            if(isset($campaignsselected) && !empty($campaignsselected)){
                foreach($campaignsselected as $cmpgn){
                    if($cmpgn > 0){
                        $cmpg_det   =   $this->Campaigns->find()
                                                        ->where(['id'=>$cmpgn])
                                                        ->first();
                        $req_amt    += $cmpg_det->sales_value * $this->request->data['expected_result'];
                    }
                }
            }
            else
            {
                $this->Flash->error('At least 1 campaign has to be selected.');
                $error = true;
            }
            
            $this->request->data['required_amount'] =    $req_amt;
        }
        $prtnr_id   =   $this->Auth->user('partner_id');
        $partner    = $this->Partners->get($prtnr_id);
        $businesplan = $this->Businesplans->newEntity($this->request->data);
		
		if ($this->request->is(['post', 'put']) && $error!==true) {
            //print_r($this->request->data);exit;
			if ($bps=$this->Businesplans->save($businesplan)) {
                                if(isset($campaignsselected) && !empty($campaignsselected)){
                                    $this->__updateBPCampaigns($bps->id, $campaignsselected);
                                }
                                $this->Flash->success('The campaign plan has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The campaign plan could not be saved. Please, try again.');
			}
		}else{
            /*
             * Section to fill values on duplications....
             */
            if($dupid   !=  0){
                $businesplan = $this->Businesplans->get($dupid);
            }
            //print_r($businesplan);exit;
        }
		
		$partners = $this->Businesplans->Partners->find('list');
                /*
                 * Section to restrict partner to submit single campaign plan for a quarter
                 */
		$fquarters = $this->Financialquarters->find()
                                                     ->where(['enddate >'=>time(),'vendor_id'=>$this->Auth->user('vendor_id')])
                                                     ->order(['enddate'=>'ASC']);
        $financialquarters  = array();
        $flg= false;
        
        foreach($fquarters as $fq){
            $flg=  $this->__checkfqcampaigns($fq->id); //$this->__checkfquarterbp($fq->id);
            if($flg){
                $financialquarters[$fq->id] =   $fq->quartertitle;
            }            
        }
        /*
         * Section to find current quarter...
         */
        $current_qtr    =   $this->Financialquarters->find()
                                                    ->where(['enddate >'=>time(),'startdate <'=>time(),'vendor_id'=>$this->Auth->user('vendor_id')])
                                                    ->first();
        
        
        if($dupid   ==  0){
            $campaigns  = array();
        }else{
           $campaigns  =   $this->Campaigns->find('list')
                                        ->where(['financialquarter_id'=>$businesplan->financialquarter_id]); 
        }
                
        if(empty($financialquarters)){
            $this->Flash->error('There are no available campaigns to create a new campaign plan for');
            return $this->redirect(['action' => 'index']);
        }
        $this->set('campaigns', $campaigns);
        $this->set('bpcampaigns', $bpcampaigns);
        $this->set('current_qtr', $current_qtr);
		$vendors = $this->Businesplans->Vendors->find('list');
		$this->set(compact('businesplan', 'partners', 'financialquarters', 'vendors','partner'));
	}


	/*
	 * Function to update campaigns of a campaign plan....
	 */
        function __updateBPCampaigns($bpid=0,$cmp=  array()){
            if($bpid > 0){
                /*
                 * Section to remove existing campaign ids from DB...
                 */
                $query = $this->BusinesplanCampaigns->query();
                $query->delete()
                    ->where(['businesplan_id' => $bpid])
                    ->execute();
                /*
                 * Section to add new campaign ids to DB...
                 */
                if(!empty($cmp)){
                    foreach($cmp as $cp){
                        if($cp > 0){
                            $bpc    =   array();
                            $bpc['businesplan_id']  =   $bpid;
                            $bpc['campaign_id']  =   $cp;
                            $bpcgn = $this->BusinesplanCampaigns->newEntity($bpc);
                            $this->BusinesplanCampaigns->save($bpcgn);
                        }
                    }
                }
                return true;
            }
        }
/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$this->loadModel('Partners');
                $prtnr_id   =   $this->Auth->user('partner_id');
                $partner    = $this->Partners->get($prtnr_id);
                $bpcampaigns    =   array();
                $businesplan = $this->Businesplans->get($id, [
			'contain' => ['BusinesplanCampaigns']
		]);
                if(isset($businesplan['businesplan_campaigns']) && !empty($businesplan['businesplan_campaigns'])){
                    foreach($businesplan['businesplan_campaigns'] as $bpc){
                        $bpcampaigns[]  =   $bpc->campaign_id;
                    }
                }
                //print_r($businesplan);exit;
                if($businesplan->status != 'Draft'){
                    $this->Flash->error('You can only edit draft campaign plans.');
                    return $this->redirect(['action' => 'index']);
                }
                if($this->Auth->user('partner_id') != $businesplan->partner_id){
                    $this->Flash->error(' Sorry , You are not authorized to edit the details');
                    return $this->redirect(array('controller' => 'Campaignplans', 'action' => 'index'));
                }
                if(isset($this->request->data['campaign_id'])){
                    $campaignsselected  =   $this->request->data['campaign_id'];
                    unset($this->request->data['campaign_id']);
                    $req_amt=   0;
                    if(isset($campaignsselected) && !empty($campaignsselected)){
                        foreach($campaignsselected as $cmpgn){
                            if($cmpgn > 0){
                                $cmpg_det   =   $this->Campaigns->find()
                                                                ->where(['id'=>$cmpgn])
                                                                ->first();
                                $req_amt    += $cmpg_det->sales_value * $this->request->data['expected_result'];
                            }
                        }
                        $this->request->data['required_amount'] =    $req_amt;
                    }
                }
                if(!isset($campaignsselected)){
                    $campaignsselected=array();
                }
		if ($this->request->is(['patch', 'post', 'put'])) {
			$businesplan = $this->Businesplans->patchEntity($businesplan, $this->request->data);
			if ($bps=$this->Businesplans->save($businesplan)) {
				$this->__updateBPCampaigns($bps->id, $campaignsselected);
                                $this->Flash->success('The campaign plan has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The campaign plan could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$partners = $this->Businesplans->Partners->find('list');
		
                /*
                 * Section to restrict partner to submit single campaign plan for a quarter
                 */
		$fquarters = $this->Financialquarters->find()
                                                        ->where(['vendor_id'=>$this->Auth->user('vendor_id')])
                                                        ->order(['enddate'=>'ASC']);
                $financialquarters  = array();
                $flg= false;
                foreach($fquarters as $fq){
                    $flg=   $this->__checkfquarterbp($fq->id,$businesplan->id);
                    if(!$flg){
                        $financialquarters[$fq->id] =   $fq->quartertitle;
                    }
                    
                }
                if(empty($financialquarters)){
                    $this->Flash->error('There are no financial quarters available for you to assign a new campaign plan.');
                    return $this->redirect(['action' => 'index']);
                }
		$vendors = $this->Businesplans->Vendors->find('list');
                $campaigns  =   $this->Campaigns->find('list')
                                                ->where(['financialquarter_id'=>$businesplan->financialquarter_id]);
                $this->set('campaigns', $campaigns);
                $this->set('bpcampaigns', $bpcampaigns);
		$this->set(compact('businesplan', 'partners', 'financialquarters', 'vendors','partner'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$businesplan = $this->Businesplans->get($id);
                if($this->Auth->user('partner_id') != $businesplan->partner_id){
                    $this->Flash->error(' Sorry, You do not have permission to delete the campaign plan.');
                    return $this->redirect(array('controller' => 'Campaignplans', 'action' => 'index'));
                }
		$this->request->allowMethod('post', 'delete');
		if ($this->Businesplans->delete($businesplan)) {
			$this->Flash->success('The businesplan has been deleted.');
		} else {
			$this->Flash->error('The campaign plan could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
        /*
         * Function to display campaigns based on selected finance quarter on businessplan add/edit forms...
         */
        public function getcampaignsofquarter(){
           $this->layout = 'ajax';
            if ($this->request->is(['patch', 'post', 'put'])) {

                $pcamps = $this->PartnerCampaigns->find()->select('campaign_id')->where(['partner_id'=>$this->Auth->user('partner_id')]);
                $pcmp_ids = array();
                if($pcamps->count()>0)
                    foreach($pcamps as $cmp)
                        $pcmp_ids[] = $cmp->campaign_id;
                
                $campaigns  =   $this->Campaigns->find('list')
                                                ->where(['financialquarter_id'=>$this->request->data['qtid'],'vendor_id'=>$this->Auth->user('vendor_id')]);
                if(count($pcmp_ids))
                	$campaigns = $campaigns->where(['id NOT IN'=>$pcmp_ids]);
                
                $campaigns = $campaigns->all();
                $this->set('campaigns', $campaigns);
                $bpcampaigns    =   array();
                if(isset($this->request->data['bpid']) && $this->request->data['bpid'] > 0){

                    $businesplancmp = $this->BusinesplanCampaigns->find('all')->where(['businesplan_id'=>$this->request->data['bpid']]);
                    if(isset($businesplancmp) && !empty($businesplancmp)){
                        foreach($businesplancmp as $bpc){
                            $bpcampaigns[]  =   $bpc->campaign_id;
                        }
                    }
                }
                else
                {
                    if($this->request->data['cmpid'] > 0)
                        $bpcampaigns[] = $this->request->data['cmpid'];
                    else
                        $bpcampaigns[] = $this->Campaigns->find()->where(['financialquarter_id'=>$this->request->data['qtid'],'vendor_id'=>$this->Auth->user('vendor_id'),'id NOT IN'=>$pcmp_ids])->first()->id;
                }
                $this->data['campaign_id'] = $campaigns->first()->id;//11; 
                $this->set('bpcampaigns', $bpcampaigns);
           }
        }
        /*
         * Function to find the financial quarter is added to any campaign plan with a status other than denied for the logged in partner.
         * If it found a result it will return true otherwise false...
         */
        function __checkfquarterbp($fqtid=0,$bpid=0){
            if($fqtid > 0){
                $bpdet  = $this->Businesplans->find()
                                                ->where(['financialquarter_id'=>$fqtid,'partner_id'=>$this->Auth->user('partner_id'),'status !='=>'Denied'])
                                                ->first();
                if(isset($bpdet->id) && $bpdet->id > 0 && $bpdet->id != $bpid ){
                    return true;
                }
            }
            return false;
        }
        function __checkfqcampaigns($fqtid=0){
            $pcamps = $this->PartnerCampaigns->find()->select('campaign_id')->where(['partner_id'=>$this->Auth->user('partner_id')]);
            $pcmp_ids = array();
            if($pcamps->count()>0)
                foreach($pcamps as $cmp)
                    $pcmp_ids[] = $cmp->campaign_id;

            if(!empty($pcmp_ids))
                $campaigns = $this->Campaigns->find()->where(['financialquarter_id'=>$fqtid,'vendor_id'=>$this->Auth->user('vendor_id'),'id NOT IN'=>$pcmp_ids]);
            else
                $campaigns = $this->Campaigns->find()->where(['financialquarter_id'=>$fqtid,'vendor_id'=>$this->Auth->user('vendor_id')]);

            if($campaigns->count()>0)
                return true;

            return false;
        }
        /*
         * Function to insert partner view track
         */
        function __insertViewTrack($bp_id){
            $prtnr_id   =   $this->Auth->user('partner_id');
            if($bp_id > 0){
                $vtrecords  = $this->PartnerViewTracks->find()
                                                      ->hydrate(false)
                                                      ->where(['businesplan_id'=>$bp_id,'partner_id'=>$prtnr_id])
                                                      ->first();
                if(isset($vtrecords['id'])&&$vtrecords['id'] > 0){
                    return false;
                    // Already exists a record in the tabe...
                }else{
                    $vrec               =   array();
                    $vrec['partner_id'] =   $prtnr_id;
                    $vrec['businesplan_id']=   $bp_id;
                    $vrec['type']       =   'Businessplan';
                    $vrec['viewstatus'] =   'Viewed';
                    $partnerViewTracks  = $this->PartnerViewTracks->newEntity($vrec);
                    if ($this->PartnerViewTracks->save($partnerViewTracks)) {
                            return true;
                    }
                }
            }
            return false;  
        }
        public function getreqamnt(){
            $this->layout = 'ajax';
            $data = $this->request->data;
            if(isset($this->request->data['expresult'])&& $this->request->data['expresult'] > 0){
                $quantity   =   $this->request->data['expresult'];
            }else{
                $quantity   =   1;
            }
            $req_amount =   0;
            if(isset($this->request->data['campaigns'])){
                $cmparray   =   explode(',',$this->request->data['campaigns']);
                if(isset($cmparray) && !empty($cmparray)){
                    foreach($cmparray as $cp){
                        if($cp > 0){
                            $cpdet   = $this->Campaigns->find()->where(['id'=>$cp])->first();
                            if(isset($cpdet->sales_value) && $cpdet->sales_value > 0){
                                $nreq_amt   =   $cpdet->sales_value * $quantity;
                                $req_amount +=  $nreq_amt;
                            }
                        }
                    }
                }
            }
            $this->set('req_amount', $req_amount);
        }
}
