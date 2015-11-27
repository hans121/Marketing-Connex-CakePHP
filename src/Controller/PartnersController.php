<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Partners Controller
 *
 * @property App\Model\Table\PartnersTable $Partners
 */
class PartnersController extends AppController {
    public $components = ['Imagecreator','Opencloud'];
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
            
        }elseif (isset($user['role']) && $user['role'] === 'admin') {
            return false;
        }
        elseif(isset($user['role']) && $user['role'] === 'vendor') {
            return false;
        }elseif(isset($user['role']) && $user['role'] === 'partner') {
            return true;
        }
        // Default deny
        return false;
    }
     public function beforeFilter(Event $event) {
        parent::beforeFilter($event);       
       
        $this->loadModel('Financialquarters');
        $this->loadModel('PartnerManagers');

        $this->layout = 'admin';
    }
/**
 * Index method
 *
 * @return void
 */
	public function index() {
        $id =   $this->Auth->user('vendor_id');
        $partner_id = $this->Auth->user('partner_id');
        $partner_name = $this->Auth->user('company_name');

		$this->paginate = [
			'contain' => ['Vendors']
		];
		$this->set('partners', $this->paginate($this->Partners));

        // For Chart
        // Get current quarter
        $financialquarter_current = $this->Financialquarters->find()
            ->select(['id','quartertitle'])
            ->where(['vendor_id'=>$id, 'NOW() BETWEEN startdate AND  enddate'])
            ->first();

        preg_match('|([A-Za-z]+?)(\s?)([0-9])(\s?)\(([0-9]+?)\)|i', $financialquarter_current->quartertitle, $quartertitle);

        // Get next quarter
        $financialquarter_next = $this->Financialquarters->find()
            ->select(['id'])
            ->where(['vendor_id'=>$id, 'quartertitle LIKE'=>'Q'.($quartertitle[3]<4?$quartertitle[3]+1:1).' ('.($quartertitle[3]<4?$quartertitle[5]:$quartertitle[5]+1).')'])
            ->first();

        // Get Campaign Status Count
        $campaign_q = $this->Campaigns->find('all');
        $campaign_status = $campaign_q->select(['cnt'=>$campaign_q->func()->count('status'),'status'])
                                ->group(['status'])
                                ->where(['vendor_id'=>$id]);
                                
                                
                               
        // Get Number of deals and value this quarter
        $campaign_deals = $this->Campaigns
                            ->find('all')
                            ->contain(['CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
                                return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
                            }])
                            ->where(['Campaigns.financialquarter_id'=>$financialquarter_current->id, 'Campaigns.vendor_id'=>$id]);
                            
                           
        // Get Active Campaigns this quarter
        $campaign_active = $this->Campaigns
                            ->find('all')
                            ->contain(['Financialquarters'])
                            ->limit(5)
                            ->where(['Campaigns.financialquarter_id <='=>$financialquarter_current->id,'Campaigns.status'=>'Y', 'Campaigns.vendor_id'=>$id]); // Just temporary solution to display data, development needed


        // Get Upcoming Campaigns next quarter
        $campaign_next = $this->Campaigns
                            ->find('all')
                            ->contain(['Financialquarters'])
                            ->limit(5)
                            ->where(['Campaigns.financialquarter_id >='=>$financialquarter_next->id, 'Campaigns.vendor_id'=>$id]); // Just temporary solution to display data, development needed

        // Get League data for partner managers for current partner
        $partner_managers = $this->PartnerManagers
                                ->find('all')
                                ->contain(['Users','CampaignPartnerMailinglistDeals'=>function ($q) {
                                    return $q->where(['status'=>'Y']);
                                },'Partners.PartnerCampaigns.Campaigns'])
                                ->where(['PartnerManagers.partner_id'=>$partner_id]);

        $partner_manager_data = array();
        foreach ($partner_managers as $row):
            // compute campaigns data
            $campaigns_completed = 0;
            $campaigns_active = 0;
            foreach($row->partner->partner_campaigns as $pc)
                if($pc->campaign->status=='Y')
                    $campaigns_completed++;
                elseif($pc->campaign->status=='A')
                    $campaigns_active++;

            // compute deals data
            $deals_cnt = 0;
            $deals_val = 0;
            foreach($row->campaign_partner_mailinglist_deals as $d) {
                $deals_cnt++;
                $deals_val += $d->deal_value;
            }

            $partner_manager_data[] = array('id'=>$row->id,'partner_name'=>$row->user->first_name . ' ' . $row->user->last_name,'campaigns_completed'=>$campaigns_completed,'deals_closed'=>$deals_cnt,'deals_value'=>$deals_val,'campaigns_active'=>$campaigns_active);

        endforeach;

        usort($partner_manager_data, array($this,"__cmp_desc"));

        $this->set(compact(['financialquarter_current','financialquarter_next','campaign_status','campaign_deals','campaign_active','campaign_next','partner_name','partner_manager_data']));
	}

/**
* Sorting functions
**/

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
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view() {
		$id =   $this->Auth->user('partner_id');
		$partner = $this->Partners->get($id, ['contain' => ['Vendors', 'PartnerManagers.Users','VendorManagers.Users']]);
		// Load Social App
		$this->loadComponent('Socialmedia');
			
		$twitter_isauth = $this->Socialmedia->twitter_isauth();
		$linkedin_isauth = $this->Socialmedia->linkedin_isAuth();
		$facebook_isauth = $this->Socialmedia->facebook_isAuth();
		// End
		$this->set(compact('partner','linkedin_isauth','twitter_isauth','facebook_isauth'));
	}


/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($from='index') {
		
            $id =   $this->Auth->user('partner_id');
            $partner = $this->Partners->get($id, [
			'contain' => []
		]);
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

                        $user = $this->Auth->user();
                        $user['logo_url'] = isset($this->request->data['logo_url']) ? $this->request->data['logo_url'] : $partner->logo_url;
                        $this->Auth->setUser($user);

                    }else{
                        if(!empty($this->request->data['logo_url']['tmp_name']) && $this->request->data['logo_url']['error']!=0)
                            $this->Flash->error('Profile was saved but your logo was not uploaded! It is either corrupted or invalid format.');

                        if(!empty($this->request->data['logo_url']['tmp_name']) && !in_array($this->request->data['logo_url']['type'],$allwed_types))
                            $this->Flash->error('Profile was saved but your logo was not uploaded! It has to be a JPEG, PNG or GIF.');

                        $logo_error = true;
                        if(empty($this->request->data['logo_url']['tmp_name']))
                            $logo_error = false;

                        if(isset($this->request->data['logo_url'])){
                          unset($this->request->data['logo_url']);
                        }
                    }
                    $partner = $this->Partners->patchEntity($partner, $this->request->data);
                    if ($this->Partners->save($partner)) {
                            if(!$logo_error)
                            $this->Flash->success('The partner has been saved.');
                            if($from == 'index'){
                                return $this->redirect(['action' => 'index']);
                            }else{
                                return $this->redirect(['controller'=>'Partners','action' => 'view']);
                            }
                    } else {
                            $this->Flash->error('The partner could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
                    }
            }
            $vendors = $this->Partners->Vendors->find('list');
            $this->set(compact('partner', 'vendors'));
            $this->set('country_list',$this->country_list);
	}
	
/**
 * Export method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
 	public function export() {

	 		$id =   $this->Auth->user('vendor_id');
	 		$partner_id = $this->Auth->user('partner_id');
	 		$partner_name = $this->Auth->user('company_name');
	 		
	 		// Get chart data
	 		// Get current quarter
	 		$financialquarter_current = $this->Financialquarters->find()
            ->select(['id','quartertitle'])
            ->where(['vendor_id'=>$id, 'NOW() BETWEEN startdate AND  enddate'])
            ->first();

        preg_match('|([A-Za-z]+?)(\s?)([0-9])(\s?)\(([0-9]+?)\)|i', $financialquarter_current->quartertitle, $quartertitle);

        // Get next quarter
        $financialquarter_next = $this->Financialquarters->find()
            ->select(['id'])
            ->where(['vendor_id'=>$id, 'quartertitle LIKE'=>'Q'.($quartertitle[3]<4?$quartertitle[3]+1:1).' ('.($quartertitle[5]<4?$quartertitle[5]:$quartertitle[5]+1).')'])
            ->first();

        // Get Campaign Status Count
        $campaign_q = $this->Campaigns->find('all');
        $campaign_status = $campaign_q->select(['cnt'=>$campaign_q->func()->count('status'),'status'])
                                ->group(['status'])
                                ->where(['vendor_id'=>$id]);
        $status_y = 0;
		$status_n = 0;
		$status_a = 0;
			foreach($campaign_status as $c_s) {
				switch($c_s->status) {
					case 'Y': //Completed
						$status_y = $c_s->cnt;
					break;
			
					case 'N': // Not Started
						$status_n = $c_s->cnt;
					break;
			
					case 'A': // Active
						$status_a = $c_s->cnt;
					break;
		}
		
		$campaign_status_array = array();
			$i=0;
		$campaign_status_array[$i][$i]			=	"Campaign Status \n";
			$i++;
		$campaign_status_array['status']		=	'Status';
		$campaign_status_array['count']			=	'';
			$i++;
		$campaign_status_array[$i]['status']	=	'Active';
		$campaign_status_array[$i]['count']		=	$status_a;
			$i++;
		$campaign_status_array[$i]['status']	=	'Completed';
		$campaign_status_array[$i]['count']		=	$status_y;
			$i++;
		$campaign_status_array[$i]['status']	=	'Not Started';
		$campaign_status_array[$i]['count']		=	$status_n;
		
		}
		

                             
        // Get Number of deals and value this quarter
        $campaign_deals = $this->Campaigns
                            ->find('all')
                            ->contain(['CampaignPartnerMailinglists.CampaignPartnerMailinglistDeals'=>function ($q) {
                                return $q->where(['CampaignPartnerMailinglistDeals.status'=>'Y']);
                            }])
                            ->where(['Campaigns.financialquarter_id'=>$financialquarter_current->id, 'Campaigns.vendor_id'=>$id]);
                            
        $campaign_deals_array = array();
        	$i=0;
        $campaign_deals_array[$i][$i]				=		"\n Number of deals/value of deals (this qtr) \n";
        	$i++;
        $campaign_deals_array[$i]['campaign']		=		'Campaign';
        $campaign_deals_array[$i]['deals']			=		'Number of Deals (this qtr)';
        $campaign_deals_array[$i]['value']			=		'Total Value of Deals (this qtr)';
        	$i++;
        
        foreach($campaign_deals as $cd):
				$deals_cnt = 0;
				$deals_val = 0;
				foreach($cd->campaign_partner_mailinglists as $cml)
					foreach($cml->campaign_partner_mailinglist_deals as $cmld) {
						$deals_cnt++;
						$deals_val += $cmld->deal_value;
					}
		$campaign_deals_array[$i]['campaign']		=		$cd->name;
		$campaign_deals_array[$i]['deals']			=		$deals_cnt;
		$campaign_deals_array[$i]['value']			=		$deals_val;
		$i++;
		endforeach; 
        
        								
	 		// Get Campaign Status Count
	 		$campaign_q = $this->Campaigns->find('all');
	 		$campaign_status = $campaign_q->select(['cnt'=>$campaign_q->func()->count('status'),'status'])
                                ->group(['status'])
                                ->where(['vendor_id'=>$id]);
                                
            //foreach ($campaign_status as $status) {
	            //echo 'Name ' . $status->name . ' Status: ' . $status->status . '<br>';
            //}
            
            // Get current quarter
        $financialquarter_current = $this->Financialquarters->find()
            ->select(['id','quartertitle'])
            ->where(['vendor_id'=>$id, 'NOW() BETWEEN startdate AND  enddate'])
            ->first();

        preg_match('|([A-Za-z]+?)(\s?)([0-9])(\s?)\(([0-9]+?)\)|i', $financialquarter_current->quartertitle, $quartertitle);
                       
            $financialquarter_next = $this->Financialquarters->find()
            ->select(['id'])
            ->where(['vendor_id'=>$id, 'quartertitle LIKE'=>'Q'.($quartertitle[3]<4?$quartertitle[3]+1:1).' ('.($quartertitle[5]<4?$quartertitle[5]:$quartertitle[5]+1).')'])
            ->first();
            
            // Get Active Campaigns this quarter
			$campaign_active = $this->Campaigns
                            ->find('all')
                            ->contain(['Financialquarters'])
                            ->limit(5)
                            ->where(['Campaigns.status'=>'A', 'Campaigns.vendor_id'=>$id]);
                            
            $active_campaign_data_array = array();
			
			$i=0;
			
			$active_campaign_data_array[$i][$i]					= 	"\n Active Campaigns \n";
			
			$i=1;
			
			//$active_campaign_data_array[$i]['campaign_name']	=	'Campaign Name';
			
			//$i++;
			if (0 == $campaign_active->count()) {
				$active_campaign_data_array[$i][$i]					=	'No Active Campaigns';
			}
			else {
			foreach ($campaign_active as $row) {
				$active_campaign_data_array[$i][$i]					=	$row->name;
				$i++;
			}
			}	

            
			// Get Upcoming Campaigns next quarter
			$campaign_next = $this->Campaigns
                            ->find('all')
                            ->contain(['Financialquarters'])
                            ->limit(5)
                            ->where(['Campaigns.financialquarter_id'=>$financialquarter_next->id, 'Campaigns.vendor_id'=>$id]);

			$upcoming_upcoming_campaign_data_array = array();
			
			$i=0;
			
			$upcoming_campaign_data_array[$i][$i]				= "\n Upcoming Campaigns (next Qtr) \n";
			
			$i=1;
			
			//$upcoming_campaign_data_array[$i]['campaign_name']	= 'Campaign Name';
			
			//$i++;
			if (0 == $campaign_next->count()) {
				$upcoming_campaign_data_array[$i][$i]					=	'No Upcoming Campaigns';
			}
			else {

			foreach ($campaign_next as $row) {
				 $upcoming_campaign_data_array[$i][$i]	 = $row->name;
				 $i++;
			}
			}
			
			// Get League data for partner managers for current partner
        $partner_managers = $this->PartnerManagers
                                ->find('all')
                                ->contain(['Users','CampaignPartnerMailinglistDeals'=>function ($q) {
                                    return $q->where(['status'=>'Y']);
                                },'Partners.PartnerCampaigns.Campaigns'])
                                ->where(['PartnerManagers.partner_id'=>$partner_id]);

		$partner_manager_data = array();
        foreach ($partner_managers as $row) {
	        // compute campaigns data
            $campaigns_completed = 0;
            $campaigns_active = 0;
            	foreach($row->partner->partner_campaigns as $pc) {
	                if($pc->campaign->status=='Y') {
	                    $campaigns_completed++;
	                }
	                elseif ($pc->campaign->status=='A') {
	                    $campaigns_active++;
	                }
	            }
            // compute deals data
            $deals_cnt = 0;
            $deals_val = 0;
            foreach($row->campaign_partner_mailinglist_deals as $d) {
                $deals_cnt++;
                $deals_val += $d->deal_value;
            }
			$partner_manager_data[] = array('id'=>$row->id,'partner_name'=>$row->user->first_name . ' ' . $row->user->last_name,'campaigns_completed'=>$campaigns_completed,'deals_closed'=>$deals_cnt,'deals_value'=>$deals_val,'campaigns_active'=>$campaigns_active);

            }
            usort($partner_manager_data, array($this,"__cmp_desc"));
            
            //foreach ($partner_manager_data as $row) {
	         //  echo '<br>' . 'Name: ' . $row['partner_name'] . ' Campaigns Completed: ' . $row['campaigns_completed'] . ' Deals Closed: ' . $row['deals_closed'] . ' Total Value of Deals Closed: ' . $row['deals_value'] . ' Campaigns Active: ' . $row['campaigns_active'];            
	        //}
	        
	        $export_array = array();
	        
	        $i=0;
	        
	        //set title
	        $export_array[$i][$i]						=	"\n Partner Manager League Table $partner_name $financialquarter_current->quartertitle \n";
	        
	        $i = 1;
	        
	        $export_array[$i]['name']					=	'Name';
	        $export_array[$i]['campaigns_completed']	=	'Campaigns Completed';
	        $export_array[$i]['deals_closed']			=	'Deals Closed';
	        $export_array[$i]['deals_value']			=	'Total Value of Deals Closed';
	        $export_array[$i]['campaigns_active']		=	'Campaigns Active';
			
	        
	        $i++;
	        
	        if (!empty( $partner_manager_data )) {
		        foreach ($partner_manager_data as $row):
			        $export_array[$i]['name']					=	$row['partner_name'];
			        $export_array[$i]['campaigns_completed']	=	$row['campaigns_completed'];
			        $export_array[$i]['deals_closed']			=	$row['deals_closed'];	
			        $export_array[$i]['deals_value']			=	$row['deals_value'];
			        $export_array[$i]['campaigns_active']		=	$row['campaigns_active'];
			         
			    $i++;
				    
		        endforeach;
		        
		        
	        }
	        

	        $export_array_final = array();
	        $export_array_final[0] = $campaign_status_array;
	        $export_array_final[1] = $campaign_deals_array;
	        $export_array_final[2] = $active_campaign_data_array;
	        $export_array_final[3] = $upcoming_campaign_data_array;
	        $export_array_final[4] = $export_array; 
	        
			$this->Filemanagement->getExportcsvMulti($export_array_final,'dashboard_data.csv', ',');
			echo __("Export completed");
			exit;								
	 		
	 	}
	 	
	 	
}