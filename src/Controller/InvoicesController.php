<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Invoices Controller
 *
 * @property App\Model\Table\InvoicesTable $Invoices
 */
class InvoicesController extends AppController {
 public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
       $this->layout = 'admin';
    }
    public function isAuthorized($user) {
        // Admin can access every action
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
		$this->paginate = [
			'contain' => ['Vendors']
		];
		$this->set('invoices', $this->paginate($this->Invoices));
	}

/**
 * View method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function view($id = null) {
		$this->loadModel('Settings');
		$this->loadModel('VendorManagers');

		$site_settings = $this->Settings->find('all');
		$site_setting = Array();
		foreach($site_settings as $setting)
			$site_setting[$setting->settingname] = $setting->settingvalue;

		$invoice = $this->Invoices->get($id, [
			'contain' => ['Vendors']
		]);

		$manager = $this->VendorManagers->find()->contain(['Users'])->where(['vendor_id'=>$invoice->vendor->id,'primary_manager'=>'Y'])->first();

		$this->set(compact('invoice','site_setting','manager'));
	}

/**
 * Add method
 *
 * @return void
 */
	public function add() {
		$invoice = $this->Invoices->newEntity($this->request->data);
		if ($this->request->is('post')) {
			if ($this->Invoices->save($invoice)) {
				$this->Flash->success('The invoice has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The invoice could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$vendors = $this->Invoices->Vendors->find('list');
		$this->set(compact('invoice', 'vendors'));
	}

/**
 * Edit method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function edit($id = null) {
		$invoice = $this->Invoices->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['post', 'put'])) {
			$invoice = $this->Invoices->patchEntity($invoice, $this->request->data);
			if ($this->Invoices->save($invoice)) {
				$this->Flash->success('The invoice has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The invoice could not be saved. Please try again. If you continue to experience problems, please contact Customer Support.');
			}
		}
		$vendors = $this->Invoices->Vendors->find('list');
		$this->set(compact('invoice', 'vendors'));
	}

/**
 * Delete method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
	public function delete($id = null) {
		$invoice = $this->Invoices->get($id);
		$this->request->allowMethod('post', 'delete');
		if ($this->Invoices->delete($invoice)) {
			$this->Flash->success('The invoice has been deleted.');
		} else {
			$this->Flash->error('The invoice could not be deleted. Please try again. If you continue to experience problems, please contact Customer Support.');
		}
		return $this->redirect(['action' => 'index']);
	}
	
/**
 * Export method
 *
 * @param string $id
 * @return void
 * @throws NotFoundException
 */
 	public function export() {
 			$invoice = $this->Invoices
 			->find()
			->contain(['Vendors']);
			
			$invoice_data = array();
				$i=0;
			//set title
			$invoice_data[$i][$i]	=	"Invoices \n";
				$i++;
			$invoice_data[$i]['vendor']				=	'Vendor';
			$invoice_data[$i]['invoice_number']		=	'Invoice Number';
			$invoice_data[$i]['invoice_date']		=	'Date';
			$invoice_data[$i]['amount']				=	'Amount';
			$invoice_data[$i]['status']				=	'Status';
				$i++;
					foreach ($invoice as $row) {
						$invoice_data[$i]['vendor']				=	$row->vendor->company_name;
						$invoice_data[$i]['invoice_number']		=	$row->invoice_number;
						$invoice_data[$i]['invoice_date']		=	h(date('d/m/Y',strtotime($row->invoice_date)));
						$invoice_data[$i]['amount']				=	$row->amount;
						$invoice_data[$i]['status']				=	$row->status;
						$i++;					
					}
			//echo var_dump($invoice_data);
			$this->Filemanagement->getExportcsv($invoice_data,'invoice_data.csv', ',');
			echo __( 'Export Completed');
			exit;		
		}

 	
 		
	
	
}
