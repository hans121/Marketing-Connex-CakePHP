<?php
	
  /*
   *  SYSTEM EMAILS
   */
	
	namespace App\Controller\Component;
	
	use Cake\Controller\Component;
	use Cake\Controller\ComponentRegistry;
	use Cake\Network\Email\Email;
	use Cake\ORM\TableRegistry;
	use Cake\Routing\Router;
	use Cake\View\Helper\UrlHelper;
	
	class PrmsemailsComponent extends Component {

    /*
     *  Default configuration
     *  @var array
     *
     */
     
	  protected $_defaultConfig = [];
	  public $components = ['Flash'];
	  public $portal_settings =   array();
	  public $controller;
	  
	  /*
	   *  SIGNUP - Send welcome e-mail to vendor
	   */
	   
	  public function __construct(ComponentRegistry $collection, array $config = array()) {
      parent::__construct($collection, $config);
      $this->controller = $collection->getController();
	  }
	
	  public function signupWelcomeMail($user, $vid=0) {
	    $users   = TableRegistry::get('Users');	  
	    $vendors   = TableRegistry::get('Vendors');  
	    
	    $user = $users->find()
	    ->hydrate(false)
	    ->where(['id' => $user['id']])
	    ->first();
				
 	    /*
	     *  SIGNUP - Send welcome e-mail to User
	     */
      
        $fgemail = new Email('default');
        $fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
		$fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
			->to($user['email'])
		      ->subject(__('Welcome to ').$this->portal_settings['site_name'])
			->emailFormat('html')
			->template('signupwelcome')
			->viewVars(array(
				'CUSTOMER_NAME' => $user['first_name'].' '.$user['last_name'],
				'SITE_NAME' => $this->portal_settings['site_name'],
				'site_url' => $this->portal_settings['site_url']
			))
	        ->send();


			        
	    /*
	     *  SIGNUP - Send welcome e-mail to administrator
	     */


        if($vid > 0) { 
	        $vendor_contacts = $vendors->find('all')
	                                    ->hydrate(false)
	                                    ->where(['Vendors.id' => $vid])
	                                    ->first();
            
            $admins   = $users->find()
	            ->hydrate(false)
	            ->where(['role' => 'admin','status' =>'Y']);

            $ademail  = new Email('default');
            $ademail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name'])
							      ->subject(__('New user registration on ').$this->portal_settings['site_name']);

            foreach($admins as $admin) {
					    $ademail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
			                ->to([$admin['email'] => $admin['first_name'].' '.$admin['last_name']])
							->emailFormat('html')
							->template('signupwelcome')
							->viewVars(array(
								'CUSTOMER_NAME' => $user['first_name'].' '.$user['last_name'],
								'SITE_NAME' => $this->portal_settings['site_name'],
								'username' => $admin['first_name'],
								'company_name' => $vendor_contacts['company_name'],
								'site_url' => $this->portal_settings['site_url'],
								'email_type' => 'admin',
								'vendor_id' => $vid
							))
						->send();
            }
       
					}
		      
      return true;
	      
	  }

	  /*
	   *  NEW - E-mail invoice to primary manager
	   */
	   
	  public function newInvoicemail($auth,$invdet) {

      $users    = TableRegistry::get('Users');
      $invoices = TableRegistry::get('Invoices');

      $user     = $users->find()
        ->hydrate(false)
        ->where(['id' => $auth['User']['id']])
        ->first();
      $invoice  = $invoices->find()
        ->hydrate(false)
        ->where(['id' => $invdet['id']])
        ->first();

	  $ind_details_string = '';
     
      if(isset($invoice)) {
       
      // get the relevant dates, for upgrades and new subscriptions
			$daybeforeupgradedate  = (date('d M Y', strtotime('-1 days', strtotime($invoice->invoice_date))));
			$todaysdate						 = (date('d M Y', time()));
			$daysremaining         = ($invoice->billing_period_days)-($invoice->days_used);
       
      $ind_details_string .= 
	               
			'<table class="invoice-table" style="border:2px solid #000000;">
								
				<thead>
				  <tr>
				    <th><a href="http://www.marketingconnex.com" title="MarketingConnex"><img src="'.UrlHelper::build("/img/logos/logo-marketing-connex.png", true).'" class="img-responsive" width="300px" height="auto"/></a></th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th style="text-align: right; text-transform: uppercase; font-size: 14px;">'.__("Invoice").'</th>
				  </tr>
				  <tr>
				    <th style="font-size: 10px; text-align: left;">'.$this->portal_settings["site_name"].'</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				  </tr>
				  <tr>
				    <th style="font-size: 10px; text-align: left;">VAT Reg No: '.$this->portal_settings["VAT_ID"].'</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				  </tr>
				</thead>
				
				<tbody>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong>'. __("Invoice No").'&nbsp;:&nbsp;</strong></td>
				    <td colspan="3">'.$invoice["invoice_number"].'</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong>'. __("Invoice Date").'&nbsp;:&nbsp;</strong></td>
				    <td colspan="3">'.date("d/m/Y",strtotime($invoice["invoice_date"])).'</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong>'. __("Your VAT ID").'&nbsp;:&nbsp;</strong></td>
				    <td colspan="3">'.$invoice["vat_number"].'</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong>'. __("Customer Service").'&nbsp;:&nbsp;</strong></td>
				    <td colspan="3">'.$this->portal_settings["site_email"].'</td>
				  </tr>
				  <tr>
				    <td><strong>Bill to:</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["primary_manager"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_name"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_address"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_city"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_state"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_postcode"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_country"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td colspan="5" style="border-bottom: 2px solid #eeeeee;">&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  	if($invoice["invoice_type"] != "Other") {
				  $ind_details_string .= '<tr>
				    <td><strong>*** '.$invoice["invoice_type"].' ***</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  	}
				  $ind_details_string .= '<tr>
				    <td><strong>'. __("Transactions this billing period").'</strong></td>
				    <td><strong>'. __("Description").'</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  if($invoice["balance_credit"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>'.$invoice["old_package"].'</td>
				    <td>'.$invoice["title"].' ('.h(date('d M Y',strtotime($invoice["sub_start_date"]))).' - '; if ($invoice["days_used"] == 0) { $ind_details_string .= h(date('d M Y',strtotime($invoice["sub_start_date"]))); } else { $ind_details_string .= $daybeforeupgradedate.')'; } $ind_details_string .= '</td>
				    <td width="75" style="text-align: right;">'.number_format(($invoice["old_package_price"] - $invoice["balance_credit"]), 2, '.', ',').'</td>
				    <td width="75">&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.($invoice["new_package"]).'</td>
				    <td>'.($invoice["title"]).' ('.h(date('d M Y',strtotime($invoice["upgrade_date"]))).' - '.h(date('d M Y',strtotime($invoice["sub_end_date"]))).')</td>
				    <td width="75" style="text-align: right;">'.number_format(($invoice["adjusted_package_price"] + $invoice["discount"]), 2, '.', ',').'</td>
				    <td width="75">&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td width="75" style="border-top: 1px solid #999999;">&nbsp;</td>
				    <td width="75" style="text-align: right;">'.number_format((($invoice["old_package_price"] - $invoice["balance_credit"]) + ($invoice["adjusted_package_price"] + $invoice["discount"])), 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  } else {
				  $ind_details_string .= '<tr>
				    <td>'.($invoice["description"]).'</td>
				    <td>'.($invoice["title"]).' ('.h(date('d M Y',strtotime($invoice["sub_start_date"]))).' - '.h(date('d M Y',strtotime($invoice["sub_end_date"]))).')</td>
				    <td width="75">&nbsp;</td>
				    <td width="75" style="text-align: right;">'.number_format(($invoice["amount"] - $invoice["vat"] + $invoice["discount"] - $invoice["fee"]), 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  if($invoice["discount"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>Discount</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;">- '.number_format($invoice["discount"], 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  if($invoice["fee"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>Other fees and charges</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;">'.number_format($invoice["fee"], 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  if($invoice["balance_credit"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>'. __("Amount of previous subscription paid on").' '.h(date('d M Y',strtotime($invoice["sub_start_date"]))).' '.__("excluding fees").'</td>
				    <td>&nbsp;</td>
				    <td width="75">&nbsp;</td>
				    <td width="75" style="text-align: right;">'.number_format((0 - $invoice["old_package_price"]), 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><strong>'. __("Total transactions this billing period").'</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right; border-top: 1px solid #999999;"><strong>'.number_format($invoice["subtotal"], 2, '.', ',').'</strong></td>
				    <td>&nbsp;</td>
				  </tr>';
					  } else {
				  $ind_details_string .='<tr>
				    <td><strong>'. __("Total transactions this billing period").'</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right; border-top: 1px solid #999999;"><strong>'.number_format($invoice["subtotal"], 2, '.', ',').'</strong></td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  $ind_details_string .='<tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  if($invoice["vat"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>&nbsp;</td>
				    <td>'. __("Subtotal").'</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;">'.number_format(($invoice["subtotal"]), 2, '.', ',').'</td>
				    <td>'.($invoice['currency']).'</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>'. __("VAT").' &#64; '.number_format(($invoice["vat_perc"]), 2, '.', ',').'&#37;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right; border-bottom: 1px solid #999999;">'.number_format(($invoice["vat"]), 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  $ind_details_string .='<tr>
				    <td>&nbsp;</td>
				    <td><strong>'. __('Total amount due').'</strong></td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;"><strong>'. number_format($invoice["amount"], 2, '.', ',').'</strong></td>
				    <td><strong>'.($invoice['currency']).'</strong></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  if($invoice["comments"] != '') {
				  $ind_details_string .='<tr>
				    <td><strong>'.__("Additional Notes").'</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td colspan="5">'.($invoice["comments"]).'</td>
				  </tr>';
  				}
				  $ind_details_string .='<tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				</tbody>
				
				<tfoot>
				  <tr>
				    <td colspan="5" style="text-align: center; font-size: 10px;">'.$this->portal_settings["site_address"].'</td>
				  </tr>
				</tfoot>
				
			</table>';
                                
			}
			 
      $fgemail = new Email('default');
      $fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
			$fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
			->to($user['email'])
		  ->subject(__('New Subscription package on').$this->portal_settings['site_name'])
			->emailFormat('html')
			->template('invoice')
			->viewVars(array(
				'CUSTOMER_NAME' => $user['first_name'].' '.$user['last_name'],
				'SITE_NAME' => $this->portal_settings['site_name'],
				'site_url' => $this->portal_settings['site_url'],
				'INVOICE_DETAILS' => $ind_details_string
			))
	        ->send();


      /*
       *  NEW SUBSCRIPTION - Send e-mail to administrator
       */
       
			$admins  = $users->find()
	      ->hydrate(false)
	      ->where(['role' => 'admin','status' =>'Y']);
			$amsg    =
			'<p>'.__("Hi,").'</p>
			<p>'.__("The vendor [CUSTOMER_NAME] has a new subscription on").' [SITE_NAME]</p>
			<p>'.__("Please find the invoice details below.").'</p>
			<p>'.__("Thanks and regards,").'</p>
			<p>&nbsp;</p>
			<p><strong>[SITE_NAME]</strong></p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			[INVOICE_DETAILS]
			';
			$amsg    = str_replace('[CUSTOMER_NAME]',$user['first_name'].' '.$user['last_name'],$amsg);
			$amsg    = str_replace('[SITE_NAME]',$this->portal_settings['site_name'],$amsg); 
			$amsg    = str_replace('[INVOICE_DETAILS]',$ind_details_string,$amsg);//echo $msg ;exit;
			$ademail = new Email('default');
			$ademail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
			foreach($admins as $admin) {
		    $ademail->from([$user['email'] => $this->portal_settings['site_name']])
						    ->to($admin['email'])
						    ->subject(__('New Subscription on ').$this->portal_settings['site_name'])
						    ->emailFormat('both')
						    ->send($amsg);
			}
			
			return true;
            
    }
	  
	  /*
	   *  UPGRADE - E-mail invoice to primary manager
	   */
	   
	  public function upgradeInvoicemail($auth,$invdet) {
      $users    = TableRegistry::get('Users');
      $invoices = TableRegistry::get('Invoices');
      $user     = $users->find()
        ->hydrate(false)
        ->where(['id' => $auth['User']['id']])
        ->first();
      $invoice  = $invoices->find()
        ->hydrate(false)
        ->where(['id' => $invdet['id']])
        ->first();
			$ind_details_string = '';
     
      if(isset($invoice)) {
       
      // get the relevant dates, for upgrades and new subscriptions
			$daybeforeupgradedate  = (date('d M Y', strtotime('-1 days', strtotime($invoice["invoice_date"]))));
			$todaysdate						 = (date('d M Y', time()));
			$daysremaining         = ($invoice["billing_period_days"])-($invoice["days_used"]);
 
       
      $ind_details_string .= 
	               
			'<table class="invoice-table" style="border:2px solid #000000;">
								
				<thead>
				  <tr>
				    <th><a href="http://www.marketingconnex.com" title="MarketingConnex"><img src="'.UrlHelper::build("/img/logos/logo-marketing-connex.png", true).'" class="img-responsive" width="300px" height="auto"/></a></th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th style="text-align: right; text-transform: uppercase; font-size: 14px;">'.__("Invoice").'</th>
				  </tr>
				  <tr>
				    <th style="font-size: 10px; text-align: left;">'.$this->portal_settings["site_name"].'</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				  </tr>
				  <tr>
				    <th style="font-size: 10px; text-align: left;">VAT Reg No: '.$this->portal_settings["VAT_ID"].'</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				  </tr>
				</thead>
				
				<tbody>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong>'. __("Invoice No").'&nbsp;:&nbsp;</strong></td>
				    <td colspan="3">'.$invoice["invoice_number"].'</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong>'. __("Invoice Date").'&nbsp;:&nbsp;</strong></td>
				    <td colspan="3">'.date("d/m/Y",strtotime($invoice["invoice_date"])).'</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong>'. __("Your VAT ID").'&nbsp;:&nbsp;</strong></td>
				    <td colspan="3">'.$invoice["vat_number"].'</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong>'. __("Customer Service").'&nbsp;:&nbsp;</strong></td>
				    <td colspan="3"><a href="'.$this->portal_settings["site_email"].'" title="'. __("Send an email to").' '.$this->portal_settings["site_email"].'">'.$this->portal_settings["site_email"].'</a></td>
				  </tr>
				  <tr>
				    <td><strong>Bill to:</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["primary_manager"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_name"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_address"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_city"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_state"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_postcode"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.$invoice["company_country"].'</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td colspan="5" style="border-bottom: 2px solid #eeeeee;">&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  	if($invoice["invoice_type"] != "Other") {
				  $ind_details_string .= '<tr>
				    <td><strong>*** '.$invoice["invoice_type"].' ***</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  	}
				  $ind_details_string .= '<tr>
				    <td><strong>'. __("Transactions this billing period").'</strong></td>
				    <td><strong>'. __("Description").'</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  if($invoice["balance_credit"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>'.$invoice["old_package"].'</td>
				    <td>'.$invoice["title"].' ('.h(date('d M Y',strtotime($invoice["sub_start_date"]))).' - '; if ($invoice["days_used"] == 0) { $ind_details_string .= h(date('d M Y',strtotime($invoice["sub_start_date"]))); } else { $ind_details_string .= $daybeforeupgradedate.')'; } $ind_details_string .= '</td>
				    <td width="75" style="text-align: right;">'.number_format(($invoice["old_package_price"] - $invoice["balance_credit"]), 2, '.', ',').'</td>
				    <td width="75">&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>'.($invoice["new_package"]).'</td>
				    <td>'.($invoice["title"]).' ('.h(date('d M Y',strtotime($invoice["upgrade_date"]))).' - '.h(date('d M Y',strtotime($invoice["sub_end_date"]))).')</td>
				    <td width="75" style="text-align: right;">'.number_format(($invoice["adjusted_package_price"] + $invoice["discount"]), 2, '.', ',').'</td>
				    <td width="75">&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td width="75" style="border-top: 1px solid #999999;">&nbsp;</td>
				    <td width="75" style="text-align: right;">'.number_format((($invoice["old_package_price"] - $invoice["balance_credit"]) + ($invoice["adjusted_package_price"] + $invoice["discount"])), 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  } else {
				  $ind_details_string .= '<tr>
				    <td>'.($invoice["description"]).'</td>
				    <td>'.($invoice["title"]).' ('.h(date('d M Y',strtotime($invoice["sub_start_date"]))).' - '.h(date('d M Y',strtotime($invoice["sub_end_date"]))).')</td>
				    <td width="75">&nbsp;</td>
				    <td width="75" style="text-align: right;">'.number_format(($invoice["package_price"]), 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  if($invoice["discount"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>Discount</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;">- '.number_format($invoice["discount"], 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  if($invoice["fee"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>Other fees and charges</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;">'.number_format($invoice["fee"], 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  if($invoice["balance_credit"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>'. __("Amount of previous subscription paid on").' '.h(date('d M Y',strtotime($invoice["sub_start_date"]))).' '.__("excluding fees").'</td>
				    <td>&nbsp;</td>
				    <td width="75">&nbsp;</td>
				    <td width="75" style="text-align: right;">'.number_format((0 - $invoice["old_package_price"]), 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><strong>'. __("Total transactions this billing period").'</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right; border-top: 1px solid #999999;"><strong>'.number_format($invoice["subtotal"], 2, '.', ',').'</strong></td>
				    <td>&nbsp;</td>
				  </tr>';
					  } else {
				  $ind_details_string .='<tr>
				    <td><strong>'. __("Total transactions this billing period").'</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right; border-top: 1px solid #999999;"><strong>'.number_format($invoice["subtotal"], 2, '.', ',').'</strong></td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  $ind_details_string .='<tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  if($invoice["vat"] != 0) {
				  $ind_details_string .= '<tr>
				    <td>&nbsp;</td>
				    <td>'. __("Subtotal").'</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;">'.number_format(($invoice["subtotal"]), 2, '.', ',').'</td>
				    <td>'.($invoice['currency']).'</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>'. __("VAT").' &#64; '.number_format(($invoice["vat_perc"]), 2, '.', ',').'&#37;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right; border-bottom: 1px solid #999999;">'.number_format(($invoice["vat"]), 2, '.', ',').'</td>
				    <td>&nbsp;</td>
				  </tr>';
					  }
				  $ind_details_string .='<tr>
				    <td>&nbsp;</td>
				    <td><strong>'. __('Total amount due').'</strong></td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;"><strong>'. number_format($invoice["amount"], 2, '.', ',').'</strong></td>
				    <td><strong>'.($invoice['currency']).'</strong></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>';
				  if($invoice["comments"] != '') {
				  $ind_details_string .='<tr>
				    <td><strong>'.__("Additional Notes").'</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td colspan="5">'.($invoice["comments"]).'</td>
				  </tr>';
  				}
				  $ind_details_string .='<tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				</tbody>
				
				<tfoot>
				  <tr>
				    <td colspan="5" style="text-align: center; font-size: 10px;">'.$this->portal_settings["site_address"].'</td>
				  </tr>
				</tfoot>
				
			</table>';
                                
			}
			
			$msg     =
			'<p>'.__("Hi").' [CUSTOMER_NAME],</p>
			<p>'.__("Thank you for your request to upgrade your subscription package on").' [SITE_NAME].</p>
			<p>'.__("Your new package is now active. Please find your invoice details below.").'</p>
			<p>'.__("Thanks and regards,").'</p>
			<p>&nbsp;</p>
			<p>'.__("Customer Support").'</p>
			<p><strong>[SITE_NAME]</strong></p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			[INVOICE_DETAILS]';
			$msg     = str_replace('[CUSTOMER_NAME]',$user['first_name'].' '.$user['last_name'],$msg);
			$msg     = str_replace('[SITE_NAME]',$this->portal_settings['site_name'],$msg);
			$msg     = str_replace('[INVOICE_DETAILS]',$ind_details_string,$msg);
			$fgemail = new Email('default');
			$fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
			$fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
						  ->to($user['email'])
						  ->subject(__('Subscription package upgraded on').$this->portal_settings['site_name'])
						  ->emailFormat('both')
						  ->send($msg);
            
            
      /*
       *  UPGRADE - Send e-mail to administrator
       */
       
			$admins  = $users->find()
	      ->hydrate(false)
	      ->where(['role' => 'admin','status' =>'Y']);
			$amsg    =
			'<p>'.__("Hi ,").'</p>
			<p>'.__("The vendor [CUSTOMER_NAME] has upgraded their subscription on").' [SITE_NAME].</p>
			<p>'.__("Please find the invoice details below.").'</p>
			<p>'.__("Thanks and regards,").'</p>
			<p>&nbsp;</p>
			<p><strong>[SITE_NAME]</strong></p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			[INVOICE_DETAILS]';
			$amsg    = str_replace('[CUSTOMER_NAME]',$user['first_name'].' '.$user['last_name'],$amsg);
			$amsg    = str_replace('[SITE_NAME]',$this->portal_settings['site_name'],$amsg); 
			$amsg    = str_replace('[INVOICE_DETAILS]',$ind_details_string,$amsg);
			$ademail = new Email('default');
			$ademail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
			foreach($admins as $admin) {
	    $ademail->from([$user['email'] => $this->portal_settings['site_name']])
					    ->to($admin['email'])
					    ->subject(__('Subscription upgrade on ').$this->portal_settings['site_name'])
					    ->emailFormat('both')
					    ->send($amsg);
			}
			
			return true;
            
    }
    
    /*
     *  NEW USER - Email to user giving username and password
     */
     
    public function userSignupemail($user) {
      $full_name  =   $user['title'].' '.$user['first_name'].' '.$user['last_name'];
      $user_email =   $user['email'];
      $username   =   $user['username'];
      $password   =   $user['password'];
      $msg    =   
      '<p>'.__("Hi").' [CUSTOMER_NAME],</p>
      <p>'.__("Your registration on").' [SITE_NAME] '.__("has been completed successfully.").'</p>
      <p>'.__("Please find your log in details below").'</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
      <p><strong>'.__("Username").' : [USER_NAME]</strong></p>
      <p><strong>'.__("Password").' : [PASSWORD]</strong></p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
      <p>'.__("Thanks and regards,").'</p>
			<p>&nbsp;</p>
      <p>'.__("Customer Support,").'</p>
      <p>[SITE_NAME]</p>';
      $msg    =   str_replace('[CUSTOMER_NAME]',$full_name,$msg);
      $msg    =   str_replace('[SITE_NAME]',$this->portal_settings['site_name'],$msg);
      $msg    =   str_replace('[USER_NAME]',$username,$msg);
      $msg    =   str_replace('[PASSWORD]',$password,$msg);
      $fgemail = new Email('default');
      $fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
      $fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
          ->to($user_email)
          ->subject(__('Welcome to ').$this->portal_settings['site_name'])
          ->emailFormat('both')
          ->send($msg);
      return true;
    }
    
    /*
     *  USER STATUS CHANGE - Email to vendors 
     */
     
    public function vendorStatusnotification($vid=0,$status='Y') {
	    $users      =   TableRegistry::get('Users');
	    $vendors    =   TableRegistry::get('Vendors');
	    if($vid > 0) {
	      $vendor_contacts = $vendors->find('all')
        ->contain(['VendorManagers', 'VendorManagers.Users'])
        ->hydrate(false)
        ->where(['Vendors.id' => $vid])
        ->first();
	      //print_r( $vendor_contacts);exit;
	      if($status == 'Y') {
	          $message = __("Hi [COMPANY_NAME],\n\nYour subscription with [SITE_NAME] has been activated successfully. \nYou and your partners can now access the system.  Thank you for doing business with us.\n\nThanks and regards,\n\nCustomer Support,\n[SITE_NAME]");
	          $subject = __('Subscription has been activated on ').$this->portal_settings['site_name'];
	      } elseif($status == 'S') {
	          $message = __("Hi [COMPANY_NAME],\n\nYour subscription with [SITE_NAME] has been suspended. We regret any inconvenience this may cause you. Please contact Customer Support if you wish to re-activate your subscription.\n\nIn the interim, access to the system will be blocked for you and your partners until your subscription is re-activated. \n\nThanks and regards,\nCustomer Support,\n[SITE_NAME]");
	          $subject = __('Subscription has been suspended on ').$this->portal_settings['site_name'];
	      } else {
	          $message = __('Hi [COMPANY_NAME],\n\nYour subscription with [SITE_NAME] has been blocked. We regret any inconvenience caused to you. Please contact Customer Support to re-activate it.\n\nYou and your partners access to the system is blocked until your subscription is re-activated. Thank you for your co operation.\n\nThanks and regards,\n\nCustomer Support,\n\n[SITE_NAME]');
	          $subject = __('Subscription de-activated on ').$this->portal_settings['site_name'];
	      }
	      $message     = str_replace('[COMPANY_NAME]',$vendor_contacts['company_name'],$message);
	      $message     = str_replace('[SITE_NAME]',$this->portal_settings['site_name'],$message);
	      $vndemail 	 = new Email('default');
	      $vndemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
	      
	      foreach ($vendor_contacts['vendor_managers'] as $vm) {
	        //echo $vm['user']['email'];
					$vndemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
					->to(([$vm['user']['email'] => $vm['user']['first_name'].' '.$vm['user']['last_name']]))
					->subject($subject)
					->emailFormat('both')
					->send($message);
        }
            
        /*
		     *  USER STATUS CHANGE - Email to administrator 
         */
           
        $admins     =   $users->find()
	      ->hydrate(false)
	      ->where(['role' => 'admin','status' =>'Y']);
           
        $ademail = new Email('default');
        $ademail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
        
        foreach($admins as $admin) {
          $ademail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
          ->to([$admin['email'] => $admin['first_name'].' '.$admin['last_name']])
          ->subject($subject)
          ->emailFormat('both')
          ->send($message);
        }
        
      }
      
      return true;
    
    }
    
   /*
    *  ACCOUNT SUSPENSION - Send e-mail to user
    */
    
    public function accountSuspensionreminder($vid=0,$reminder='first') {
        $users      =   TableRegistry::get('Users');
        $vendors    =   TableRegistry::get('Vendors');
        if($vid > 0) {
	        $vendor_contacts = $vendors->find('all')
	                                   ->contain(['VendorManagers', 'VendorManagers.Users'])
	                                   ->hydrate(false)
	                                   ->where(['Vendors.id' => $vid])
	                                   ->first();
	        if($reminder=='final') {
	          $suspended_days = $this->portal_settings['removal_final_warning'];
	        } elseif($reminder=='second') {
						$suspended_days = $this->portal_settings['removal_second_warning'];
	        } else {
						$suspended_days = $this->portal_settings['removal_first_warning'];
	        }
	        $remaining_prior_removal_days   =   $this->portal_settings['removal_interval_days'] - $suspended_days;
	        $message  = __("Hi {0},\n\nYour subscription with {1} has been suspended for last {2} days. If it is not re-activated within {3} days all your data from {1} will be deleted without any further notification. Please contact Customer Support if you require any assistance.\n\nThanks and regards,\nCustomer Support,\n{1}",[$vendor_contacts['company_name'], $this->portal_settings['site_name'], $suspended_days,$remaining_prior_removal_days]);
	        $subject  = __('Reminder : Subscription removal from ').$this->portal_settings['site_name'];
	        $vndemail = new Email('default');
	        $vndemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
	        
	        foreach ($vendor_contacts['vendor_managers'] as $vm) {
						$vndemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
						->to(([$vm['user']['email'] => $vm['user']['first_name'].' '.$vm['user']['last_name']]))
						->subject($subject)
						->emailFormat('both')
						->send($message);
        	}

            
						/*
						 *  ACCOUNT SUSPENSION - Send e-mail to administrator
						 */
           
            $admins   = $users->find()
            ->hydrate(false)
            ->where(['role' => 'admin','status' =>'Y']);
            $ademail  = new Email('default');
            $ademail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
            
            foreach($admins as $admin) {
                $ademail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
                ->to([$admin['email'] => $admin['first_name'].' '.$admin['last_name']])
                ->subject($subject)
                ->emailFormat('both')
                ->send($message);
            }
            
		      }
		      
        return true;
    	
    	}
    	
	    /*
	     *  PASSWORD RESET - Send password reset link to user
	     */
     
			public function passwordresetlink($email=null) {
				
			  $userPwordResets    = TableRegistry::get('UserPwordResets');
			  $upr = $userPwordResets->find('all')->where(['username' => $email,'status' => 'Y','expiry_date >' => time()])->first();
			  if(isset($upr) && !empty($upr)) {
		      $upr->status = 'C';
		      $userPwordResets->save($upr);
			  }
			  $arr['username']    = $email;
			  $arr['email']       = $email;
			  $arr['token']       = md5(time().'rpwd'.$email);
			  $arr['expiry_date'] = time()+(24*60*60); 
			  $arr['created_on']  = time(); 
			  $arr['status']      = 'A';
			  $data               = $userPwordResets->newEntity($arr);//print_r($data);exit;
			  if ($userPwordResets->save($data)) {
					$site_url=  Router::url('/', true);   
					$token_url= Router::url(['controller' => 'Users', 'action' => 'resetpassword',$arr['token'] ],true);
					// $site_url.'resetpassword/'.$arr['token'];
					$msg    =      '<p>'.__("A password reset has been requested for the following account:").'</p><p>'.$site_url.'</p>'.__("Username: ").$email.'</p><p>'.__("If you did not request this, or requested this in error, please ignore this email and no changes will be made.").'</p><p>'.__("To reset your password, visit the following link:").'<br />'.$token_url.'</p>';
					$fgemail = new Email('default');
					$fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
					$fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
					->to($email)
					->subject(__('Reset Password'))
					->emailFormat('both')
					->send($msg); 
					$this->Flash->success(__('We have sent an email to the email address you provided to us.  Please follow the link in our email to confirm your request to reset your password.'));
					return true;
			  }
			
			  return false;
			  
			}
			
    /*
     *  PASSWORD RESET - Send new password to user
     */
     
    public function newpasswordemail($username,$pwrd) {
			$site_url= Router::url('/', true);   
			$msg     = __("Your password has been changed for the following account:\n\n\n").$site_url.__("\n\nUsername: ").$username.__(" \nNew Password: ").$pwrd;
			
			$fgemail = new Email('default');
			$fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
			$fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
			->to($username)
			->subject(__('New Password'))
			->emailFormat('both')
			->send($msg);
			return true; 
    }
    
    /*
     *  LANDING PAGE - Send resource on form submission
     */
     
    public function sendLandingPageResource($toemail=null,$filename=null,$filepath=null,$frommail=null,$fromname=null) {
        if(null == $frommail) {
          $frommail = $this->portal_settings['site_email'];
        }
        if(null == $fromname) {
          $fromname = $this->portal_settings['site_name'];
        }
        if(null == $filename) {
          $filename = __('E-book');
        }
        if(null != $toemail && null != $filepath) { 
          $msg    = __("Thank you for your interest in our e-book. We have attached this for you.");
          $finfo  = finfo_open();

          $contentType = finfo_file($finfo, $filepath, FILEINFO_MIME);
//echo "IN EMAIL"; exit;
          finfo_close($finfo);
          $fgemail = new Email('default');
          $fgemail ->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
          $fgemail //->template('landingpageresource', 'landingpagelayout')
                   ->from([$frommail=>$fromname])
                   ->to($toemail)
                   ->subject(__('E-book attached')) 
                   ->attachments([$filename => ['file' => $filepath,'mimetype' => $contentType,'contentId' => strtotime('Y-m-d H:i:s')]])
                   ->emailFormat('both')
                   ->send($msg);
          return true; 
        }
        
        return false;

    }
    
    /*
     *  BUSINESS PLAN - Advise partner of approved business plan
     */
     
    public function partnerbpapprovalnotification($email=null,$qrter=null) {
	    if($email != null) {
        $msg     = __("Hi,\n Your campaign plan has been approved for ").$qrter.__(" Please log in to the website for more details.");
        $fgemail = new Email('default');
        
        $fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
        $fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']]);
        $fgemail->to($email);
        $fgemail->subject(__('Congratulations, your campaign plan application has been approved.'));
        $fgemail->emailFormat('both');
        $fgemail->send($msg);
        return true;
	    }
	    
	    return false;
	     
    }
    
    /*
     *  BUSINESS PLAN - Advise partner of declined business plan
     */
     
    public function partnerbpdeclinenotification($email=null,$qrter=null) {
	    if($email != null) {
	      $msg     = __("Hi,\n Your campaign plan for ").$qrter.__(" was not successful this time. Please log in to the website for more details.");
	      $fgemail = new Email('default');
	      $fgemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
	      $fgemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
			          ->to($email)
			          ->subject(__('Unfortunately your campaign plan application was not successful this time'))
			          ->emailFormat('both')
			          ->send($msg);
	      return true;
	    }
	    
	    return false;
    }
    
    /*
     * BUSINESS PLAN - Reminder partner to submit application for upcoming quartery
     */
     
    public function bpsubmissionreminder($pname=null,$pemail=null,$fqttitle=null,$vendor_name=null,$vendor_email=null,$vendor_cname=null) {
        if(null !== $pname && null !== $pemail ) {
	        if(null == $vendor_email) {
	          $vendor_email  = $this->portal_settings['site_email'];
	        }
	        if(null == $vendor_name) {
	          $vendor_name   = $this->portal_settings['site_name'];
	        }
	        if(null == $vendor_name) {
	          $vendor_cname  = $this->portal_settings['site_name'];
	        }
            $msg     = __("Hi ").$pname."\n\n".__("The deadline for submitting your campaign plan proposal for ").$fqttitle.  __(" is coming up.\n\nSo far you have no approved campaign plans or submissions awaiting approval for ").$fqttitle.  __(". Please visit the website to submit your campaign plan.")."\n\n\n".__("Thanks and regards")."\n".$vendor_name."\n". $vendor_cname;
            $fgemail = new Email('default');
            $fgemail->sender($vendor_email,$vendor_cname);
            $fgemail->from([$vendor_email => $vendor_name])
		                ->to($pemail)
		                ->subject(__('Campaign plan submission deadline for ').$fqttitle)
		                ->emailFormat('both')
		                ->send($msg);
            return true;
        }
        
        return false;
    
    }
    
    /*
     *  BUSINESS PLAN - Notify partner that campaign not sent because mailing list size exceeds campaign send limit
     */
     
    public function notifycampaignlimitexceeds($vendor=array(),$partner=array(),$campaign=array(),$totparticipants=0) {
		  if(!empty($vendor)&& !empty($partner)) {
	      //print_r($totparticipants);exit;
	      $pmsg  = __("Hi ").$partner['user']->full_name."\n\n".__("We couldn’t send your campaign email as the number of participants exceeds the campaign send limit.  Please either reduce the number of participants, or contact your vendor to request an increased send limit for this campaign.\nOnce you’ve made your amendments, please reschedule your campaign email for future date.");
	      $pmail = new Email('default');
	      $pmail->sender($vendor['user']->email,$vendor['vendor']->company_name);
	      $pmail->from([$vendor['user']->email => $vendor['vendor']->company_name])
              ->to($partner['user']->email)
              ->subject(__('Campaign send limit insufficient'))
              ->emailFormat('both')
              ->send($pmsg);
              
		    /*
		     *  BUSINESS PLAN - Notify vendor that campaign not sent because mailing list size exceeds campaign send limit
		     */
		     
	      $vmsg  = __("Hi ").$vendor['user']->full_name."\n\n".__("Your partner ".$partner['partner']->company_name." attempted to send a campaign email for ".$campaign->name.", with ".$totparticipants." participants.  You have set the send limit for this campaign to ".$campaign->send_limit."  Therefore the partner\’s campaign email was not sent.  We have informed the partner to consider reducing the number of campaign participants, or to contact you to request an upgrade to the campaign send limit.");
	      $vmail = new Email('default');
	      $vmail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
	      $vmail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
              ->to($vendor['user']->email)
              ->subject(__('Campaign send limit insufficient'))
              ->emailFormat('both')
              ->send($vmsg);
	      return true;
	      
		  }
		  
		  return false;
		  
	}
	
	
	/*
	*  ABANDONED USER - Send chaser e-mail to vendor
	*/
    
    public function abandonedVendorManager($vid=0) {
        $users      =   TableRegistry::get('Users');
        $vendors    =   TableRegistry::get('Vendors');
        if($vid > 0) { 
	        $vendor_contacts = $vendors->find('all')
	                                    ->contain(['VendorManagers', 'VendorManagers.Users'])
	                                    ->hydrate(false)
	                                    ->where(['Vendors.id' => $vid])
	                                    ->first();
	        
	        $subject  = __('Complete your registration to ').$this->portal_settings['site_name'];
	        $vndemail = new Email('default');
	        $vndemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
	        
	        foreach ($vendor_contacts['vendor_managers'] as $vm) {
				$vndemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
				->to(([$vm['user']['email'] => $vm['user']['first_name'].' '.$vm['user']['last_name']]))
				->subject($subject)
				->emailFormat('html')
				->template('vendorabandoned', 'system')
				->viewVars(array(
					'email_type' => 'vendor',
					'firstname' => $vm['user']['first_name'],
					'company_name' => $vendor_contacts['company_name'],
					'site_url' => $this->portal_settings['site_url'],
					'vendor_id' => $vid
				))
				->send();
				$vendorEmail = $vm['user']['email'];
				
        	}


			/*
			 *  ABANDONED USER - Send e-mail to administrator
			 */

            $admins   = $users->find()
            ->hydrate(false)
            ->where(['role' => 'admin','status' =>'Y']);
            $ademail  = new Email('default');
            $ademail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
 
	        $subject  = __('Abandoned Checkout Notification for ').$vendor_contacts['company_name'];
	        $vndemail = new Email('default');
	        $vndemail->sender($vendorEmail,$vendor_contacts['company_name']);

            
            foreach($admins as $admin) {
                $ademail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
                ->to([$admin['email'] => $admin['first_name'].' '.$admin['last_name']])
                ->subject($subject)
				->emailFormat('html')
				->template('vendorabandoned')
				->viewVars(array(
					'email_type' => 'admin',
					'username' => $admin['first_name'],
					'company_name' => $vendor_contacts['company_name'],
					'site_url' => $this->portal_settings['site_url'],
					'vendor_id' => $vid
				))
				->send();

            }
		}
		      
        return true;
    	
   	}


	/*
	 *  ABANDONED USER (PRE-MANAGER SIGN-UP) - Alert Admin by email
	 */
    
    public function abandonedVendorSignup($vid=0) {
        $users      =   TableRegistry::get('Users');
        $vendors    =   TableRegistry::get('Vendors');
        if($vid > 0) { 
	        $vendor_contacts = $vendors->find('all')
	                                    ->hydrate(false)
	                                    ->where(['Vendors.id' => $vid])
	                                    ->first();
            $admins   = $users->find()
            ->hydrate(false)
            ->where(['role' => 'admin','status' =>'Y']);
            $ademail  = new Email('default');
            $ademail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
 	        $subject  = __('Abandoned Checkout Notification (before user manager registered) for ').$vendor_contacts['company_name'];

            
            foreach($admins as $admin) {
			    $ademail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
                ->to([$admin['email'] => $admin['first_name'].' '.$admin['last_name']])
                ->subject($subject)
				->emailFormat('html')
				->template('vendorabandoned')
				->viewVars(array(
					'username' => $admin['first_name'],
					'company_name' => $vendor_contacts['company_name'],
					'site_url' => $this->portal_settings['site_url'],
					'vendor_id' => $vid
				))
				->send();
            }
            
		}
		      
        return true;
    	
   	}


	/*
	 *  FREE TRIAL - Alert Admin by email
	 */
    
    public function freeTrial($vid=0) {
        $users      =   TableRegistry::get('Users');
        $vendors    =   TableRegistry::get('Vendors');
        if($vid > 0) { 
	        $vendor_contacts = $vendors->find('all')
	                                    ->contain(['VendorManagers', 'VendorManagers.Users'])
	                                    ->hydrate(false)
	                                    ->where(['Vendors.id' => $vid])
	                                    ->first();
	        
	        $subject  = __('We have received your Free Trial Request for ').$this->portal_settings['site_name'];
	        $vndemail = new Email('default');
	        $vndemail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
	        
	        foreach ($vendor_contacts['vendor_managers'] as $vm) {
				$vndemail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
				->to(([$vm['user']['email'] => $vm['user']['first_name'].' '.$vm['user']['last_name']]))
				->subject($subject)
				->emailFormat('html')
				->template('freetrial', 'system')
				->viewVars(array(
					'email_type' => 'vendor',
					'firstname' => $vm['user']['first_name'],
					'company_name' => $vendor_contacts['company_name'],
					'site_url' => $this->portal_settings['site_url'],
					'vendor_id' => $vid
				))
				->send();
				$vendorEmail = $vm['user']['email'];
				
        	}


			/*
			 *  Send e-mail to administrator
			 */

            $admins   = $users->find()
            ->hydrate(false)
            ->where(['role' => 'admin','status' =>'Y']);
            $ademail  = new Email('default');
            $ademail->sender($this->portal_settings['site_email'],$this->portal_settings['site_name']);
 
	        $subject  = __('Free Trial Request for ').$vendor_contacts['company_name'];
	        $vndemail = new Email('default');
	        $vndemail->sender($vendorEmail,$vendor_contacts['company_name']);

            
            foreach($admins as $admin) {
                $ademail->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
                ->to([$admin['email'] => $admin['first_name'].' '.$admin['last_name']])
                ->subject($subject)
				->emailFormat('html')
				->template('freetrial')
				->viewVars(array(
					'email_type' => 'admin',
					'username' => $admin['first_name'],
					'company_name' => $vendor_contacts['company_name'],
					'site_url' => $this->portal_settings['site_url'],
					'vendor_id' => $vid
				))
				->send();

            }

            
		}
		      
        return true;
    	
   	}



   	public function unsentCampaignEmail($campaign_id)
   	{
   		$campaigns = TableRegistry::get('Campaigns');
   		$partners = TableRegistry::get('Partners');

   		$campaign = $campaigns->get($campaign_id);

   		$partners = $partners->find()->where(['vendor_id'=>$campaign->vendor_id]);

   		$cmpemail  = new Email('default');

   		foreach($partners as $partner)
   		{
   			$cmpemail 	->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
		                ->to([$partner->email => $partner->company_name])
		                ->subject('Campaign "' . $campaign->name . '" waiting to be sent')
						->emailFormat('html')
						->template('campaignfollowup')
						->viewVars(array(
							'campaign_name' => $campaign->name
						))
						->send();
   		}

   		return true;
   	}
   	
   	public function leadAssigned($lead_id)
   	{
   		$leads = TableRegistry::get('Leads');
   		$partners = TableRegistry::get('Partners');
   	
   		$lead = $leads->get($lead_id);
   		
   		$partner = $partners->get($lead->partner_id);
	   	
	   	$cmpemail  = new Email('default');
	   	
   		$cmpemail 	->from([$this->portal_settings['site_email'] => $this->portal_settings['site_name']])
			   		->to([$partner->email => $partner->company_name])
			   		->subject('Lead "' . $lead->email . '" waiting for acceptance')
			   		->emailFormat('html')
			   		->template('leadassigned')
			   		->viewVars(array(
			   			'email' => $lead->email,
			   			'vendor_msg' => $partner_lead->note
			   		))
			   		->send();
   		   	
   		return true;
   	}
	
}