<?php
namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;

use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * PartnerMailinglists Controller
 *
 * @property App\Model\Table\PartnerMailinglistsTable $PartnerMailinglists
 */
class PartnerMailinglistSegmentsController extends AppController {

        public function beforeFilter(Event $event) {
            parent::beforeFilter($event);
            $this->layout = 'admin';
            $this->loadModel('PartnerMailinglists');
            $this->loadModel('PartnerMailinglistSegmentRules');
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
        	$partnerMailinglistSegments =   $this->paginate($this->PartnerMailinglistSegments);
        	
        	$this->set('PartnerMailinglistSegments', $partnerMailinglistSegments);
        }
        
        /**
         * Show method
         *
         * @return void
         */
        public function show($id) {
        	$PartnerMailinglistSegments =   $this->paginate($this->PartnerMailinglistSegments->find()->where(['partner_mailinglist_group_id'=>$id]));
        	$controller = $this;
        	$this->set(compact('PartnerMailinglistSegments','id','controller'));
        }
       
/**
 * Add method
 *
 * @return void
 */
	public function add($id) {
		$cities = $this->PartnerMailinglists->find()->select(['city'])->group(['city'])->order(['city'=>'asc'])->toArray();
		$countries = $this->PartnerMailinglists->find()->select(['country'])->group(['country'])->order(['country'=>'asc'])->toArray();
    	$partnerMailinglistSegment = $this->PartnerMailinglistSegments->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($partnerMailinglistSegment = $this->PartnerMailinglistSegments->save($partnerMailinglistSegment)) {
				// Save Rules
				$logic = [];
				foreach($this->request->data['logic'] as $key=>$val)
				{
					$variable = $this->request->data['type'][$key];
					$operand = $this->request->data['condition'][$key];
					$value = $this->request->data['value'][$key];
					
					if($this->request->data['type'][$key]=='created_on' && $this->request->data['condition'][$key]=='between')
						$value = $value[1].'|'.$value[2];
										
					$logic = ['id'=>$partnerMailinglistSegment->id.$key,'partner_mailinglist_segment_id'=>$partnerMailinglistSegment->id,'logic'=>$val,'variable'=>$variable,'operand'=>$operand,'value'=>$value,'priority'=>$key];
					$partnerMailinglistSegmentRule = $this->PartnerMailinglistSegmentRules->newEntity($logic);
					$partnerMailinglistSegmentRule = $this->PartnerMailinglistSegmentRules->save($partnerMailinglistSegmentRule);
				}
				// End Rules
				
				$this->Flash->success('Your new segment has been created.');
				return $this->redirect(['action' => 'view', $partnerMailinglistSegment->id]);
			} else {
				$this->Flash->error('Sorry, the segment could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$this->set(compact('partnerMailinglistSegment','id','cities','countries'));
	}	
	

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function edit($id = null) {
		$cities = $this->PartnerMailinglists->find()->select(['city'])->group(['city'])->order(['city'=>'asc'])->toArray();
		$countries = $this->PartnerMailinglists->find()->select(['country'])->group(['country'])->order(['country'=>'asc'])->toArray();
		
        $partnerMailinglistSegment = $this->PartnerMailinglistSegments->get($id);
        $partnerMailinglistSegmentRules = $this->PartnerMailinglistSegmentRules->find()->where(['partner_mailinglist_segment_id'=>$id])->order(['priority'=>'asc']);
                
		if ($this->request->is(['patch', 'post', 'put'])) {
			$partnerMailinglistSegment = $this->PartnerMailinglistSegments->patchEntity($partnerMailinglistSegment,$this->request->data);
			if ($partnerMailinglistSegment = $this->PartnerMailinglistSegments->save($partnerMailinglistSegment)) {
				// Save Rules
				$query = $this->PartnerMailinglistSegmentRules->query();
				$query	->delete()
						->where(['partner_mailinglist_segment_id'=>$id])
						->execute();
				$logic = [];				
				foreach($this->request->data['logic'] as $key=>$val)
				{
					$variable = $this->request->data['type'][$key];
					$operand = $this->request->data['condition'][$key];
					$value = $this->request->data['value'][$key];
					
					if($this->request->data['type'][$key]=='created_on' && $this->request->data['condition'][$key]=='between')
						$value = $value[1].'|'.$value[2];
										
					$logic = ['id'=>$partnerMailinglistSegment->id.$key,'partner_mailinglist_segment_id'=>$partnerMailinglistSegment->id,'logic'=>$val,'variable'=>$variable,'operand'=>$operand,'value'=>$value,'priority'=>$key];
					$partnerMailinglistSegmentRule = $this->PartnerMailinglistSegmentRules->newEntity($logic);
					$partnerMailinglistSegmentRule = $this->PartnerMailinglistSegmentRules->save($partnerMailinglistSegmentRule);
				}
				// End Rules
				
				$this->Flash->success('Your segment has been saved.');
				return $this->redirect(['action' => 'view', $partnerMailinglistSegment->id]);
			} else {
				$this->Flash->error('Sorry, the segment could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		
		$this->set(compact('partnerMailinglistSegment','partnerMailinglistSegmentRules','id','cities','countries'));
	}
	
	/**
	 * View method
	 *
	 * @param string $id
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException
	 */
	public function view($id = null) {
		$partnerMailinglistSegment = $this->PartnerMailinglistSegments->get($id);
		$partnerMailinglist = $this->_review($id);
		$this->set(compact('partnerMailinglist','partnerMailinglistSegment'));
	}
	
	public function _review($id) {
		
		$partnerMailinglistSegmentRules = $this->PartnerMailinglistSegmentRules->find()->where(['partner_mailinglist_segment_id'=>$id])->order(['priority'=>'asc']);
		
		$query = $this->PartnerMailinglists->find();
		
		foreach($partnerMailinglistSegmentRules as $rule)
		{
			if($rule->variable=='created_on')
			{
				$date = explode('/',$rule->value);
				$date = "{$date[2]}-{$date[1]}-{$date[0]}";
				if($rule->operand=='between')
				{
					$value = explode('|',$rule->value);
					$date1 = explode('/',$value[0]);
					$date1 = "{$date1[2]}-{$date1[1]}-{$date1[0]}";
					$date2 = explode('/',$value[1]);
					$date2 = "{$date2[2]}-{$date2[1]}-{$date2[0]}";
				}
			}
			switch($rule->operand)
			{
				case 'contains':
					$cond = ["`{$rule->variable}` like '%{$rule->value}%'"]; break;
				case '!contains':
					$cond = ["`{$rule->variable}` not like '%{$rule->value}%'"]; break;
				case 'provided':
					$cond = ["`{$rule->variable}` != ''"]; break;
				case '!provided':
					$cond = ["`{$rule->variable}` = ''"]; break;
				case '=':
					$cond = ["`{$rule->variable}` = '{$rule->value}'"]; break;
				case '!=':
					$cond = ["`{$rule->variable}` != '{$rule->value}'"]; break;
				case 'startswith':
					$cond = ["`{$rule->variable}` like '{$rule->value}%'"]; break;
				case '!startswith':
					$cond = ["`{$rule->variable}` not like '{$rule->value}%'"]; break;
				case 'endswith':
					$cond = ["`{$rule->variable}` like '%{$rule->value}'"]; break;
				case '!endswith':
					$cond = ["`{$rule->variable}` not like '%{$rule->value}'"]; break;
				case 'before':
					$cond = ["`{$rule->variable}` < '".date('Y-m-d h:i:s',strtotime($date))."'"]; break;
				case 'after':
					$cond = ["`{$rule->variable}` > '".date('Y-m-d h:i:s',strtotime($date))."'"]; break;
				case '<=':
					$cond = ["`{$rule->variable}` <= '".date('Y-m-d h:i:s',strtotime($date))."'"]; break;
				case '>=':
					$cond = ["`{$rule->variable}` >= '".date('Y-m-d h:i:s',strtotime($date))."'"]; break;
				case 'between':
					$cond = ["`{$rule->variable}` between '".date('Y-m-d h:i:s',strtotime($date1))."' and '".date('Y-m-d h:i:s',strtotime($date2))."'"]; break;
			}
			switch($rule->logic)
			{
				case 'and':
					$query->andWhere($cond);
					break;
				case 'or':
					$query->orWhere($cond);
					break;
				default:
					$query->where($cond);
			}
		}
		$partnerMailinglist =   $this->paginate($query);
		return $partnerMailinglist;
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws \Cake\Network\Exception\NotFoundException
 */
	public function delete($id = null) {
		$partnerMailinglistSegment = $this->PartnerMailinglistSegments->get($id);
		$segment_id = $partnerMailinglistSegment->partner_mailinglist_segment_id;
		$this->request->allowMethod('get', 'delete');
		if ($this->PartnerMailinglistSegments->delete($partnerMailinglistSegment)) {
			$query = $this->PartnerMailinglistSegmentRules->query();
			$query	->delete()
					->where(['partner_mailinglist_segment_id'=>$id])
					->execute();
			$this->Flash->success('The mailing list segment has been deleted.');
		} else {
			$this->Flash->error('Sorry, the mailing list segment could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'show',$segment_id]);
	}
	
	public function bulkdelete(){
		if ($this->request->is(['patch', 'post', 'put'])) {
			$ids    =   explode(',',$this->request->data['ids']);
			foreach($ids as $id){
				$partnerMailinglistSegment = $this->PartnerMailinglistSegments->get($id);
				if ($this->PartnerMailinglistSegments->delete($partnerMailinglistSegment)) {
					$query = $this->PartnerMailinglistSegmentRules->query();
					$query	->delete()
							->where(['partner_mailinglist_segment_id'=>$id])
							->execute();
				}
			}
	
	
		}
		exit;
	}
}
