<div class="Invoices view">
	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Invoice'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Vendors', ['controller'=>'Admins','action' => 'vendors']);
					$this->Html->addCrumb('Invoices', ['controller'=>'Invoices','action' => 'index']);
					$this->Html->addCrumb('View', ['controller'=>'Invoices','action' => 'view', $invoice->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	    <?//= $this->Html->link(__('Add new'), ['action' => 'add'],['class'=>'btn btn-lg pull-right']); ?>
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4"><strong><?= __('Invoice number').': '; ?><?= h($invoice->invoice_number); ?></strong></dt>
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
				<a class="btn pull-right" onclick="printDiv()"><?=__('Print');?></a>
				<?//= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete?', $invoice->id),'class' => 'btn btn-danger pull-right']); ?>
				<?//= $this->Html->link(__('Edit'), ['action' => 'edit', $invoice->id],['class' => 'btn pull-right']); ?>
			</div>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Invoice type'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($invoice->invoice_type); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Vendor'); ?>
    </dt>
		<dd class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<?= $invoice->has('vendor') ? h($invoice->vendor->company_name) : ''; ?>
		</dd>
		<dd class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<div class="btn-group pull-right">
				<?= $invoice->has('vendor') ? $this->Html->link(__('View'), ['controller' => 'Admins', 'action' => 'viewVendor', $invoice->vendor->id],['class' => 'btn btn-danger pull-right']) : ''; ?>
			</div>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Description'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($invoice->title); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Billing period'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($invoice->billing_period_days).' '.__('days'); ?>
		</dd>
	</div>

	<?php 
		if ($invoice->invoice_type == "Subscription Upgrade") {
	?>
	
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Previous package'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($invoice->old_package).' ('.h(date('d M Y',strtotime($invoice->sub_start_date))).' - '.h(date('d M Y',strtotime($invoice->upgrade_date))).')'; ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Upgraded to'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($invoice->new_package).' ('.h(date('d M Y',strtotime($invoice->upgrade_date))).' - '.h(date('d M Y',strtotime($invoice->sub_end_date))).')'; ?>
		</dd>
	</div>

	<?php
		} else if ($invoice->invoice_type == "Subscription") {
	?>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Subscribed to'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($invoice->new_package); ?>
		</dd>
	</div>

	<?php
		}
	?>

	<?php 
		if ($invoice->vat != 0) {
	?>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Subtotal'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($invoice->currency); ?> <?= number_format($invoice->subtotal, 2, '.', ',');?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('VAT'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($invoice->currency); ?> <?= number_format($invoice->vat, 2, '.', ',');?>
		</dd>
	</div>
	
	<?php
		}
	?>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Amount billed'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($invoice->currency); ?> <?= number_format($invoice->amount, 2, '.', ',');?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Status'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($invoice->status == 'paid'){ ?>
	      <i class="fa fa-check"></i> <?= __('Paid'); ?> <?php
	      } else if ($invoice->status == 'P'){ ?>
	      <i class="fa fa-minus"></i> <?= __('Pending'); ?> <?php
      } ?>
		</dd>
	</div>
	
	<div class="row inner">   
    <dd class="col-xs-12 table-responsive">

			<table id="areaToPrint" class="invoice-table">
								
				<thead>
				  <tr>
				    <th><a href="http://www.marketingconnex.com" title="MarketingConnex"><img src="<?= $this->Url->build('/img/logos/logo-marketing-connex.png', true)?>" class="img-responsive" width="300px" height="auto"/></a></th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th style="text-align: right; text-transform: uppercase; font-size: 14px;">Invoice</th>
				  </tr>
				  <tr>
				    <th style="font-size: 10px; text-align: left;"><?= $site_setting['site_name'] ?></th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				  </tr>
				  <tr>
				    <th style="font-size: 10px; text-align: left;">VAT Reg No: <?= $site_setting['VAT_ID'] ?></th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				    <th>&nbsp;</th>
				  </tr>
				</thead>
				
				<tbody>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong><?= __('Invoice No')?>&nbsp;:&nbsp;</strong></td>
				    <td colspan="3"><?= h($invoice->invoice_number); ?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong><?= __('Invoice Date')?>&nbsp;:&nbsp;</strong></td>
				    <td colspan="3"><?= h(date('d M Y',strtotime($invoice->invoice_date))); ?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong><?= __('Your VAT ID')?>&nbsp;:&nbsp;</strong></td>
				    <td colspan="3"><?= h($invoice->vendor->vat_number); ?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td style="text-align: right"><strong><?= __('Customer Service')?>&nbsp;:&nbsp;</strong></td>
				    <td colspan="3"><a href="<?= h($invoice->vendor->customer_service); ?>" title="<?= __('Send an email to').' '.h($invoice->customer_service); ?>"><?= h($invoice->customer_service); ?></a></td>
				  </tr>
				  <tr>
				    <td><strong>Bill to:</strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><?= h($invoice->primary_manager); ?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><?= h($invoice->company_name); ?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><?= h($invoice->company_address); ?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><?= h($invoice->company_city); ?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><?= h($invoice->company_state); ?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><?= h($invoice->company_postcode); ?></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><?= h($invoice->company_country); ?></td>
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
				  </tr>
				  <?php
				  	if($invoice["invoice_type"] != "Other") {
					?>
				  <tr>
				    <td><strong><?= '*** '.h($invoice->invoice_type).' ***'; ?></strong></td>
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
				  <?php
				  	}
					?>
				  <tr>
				    <td><strong><?= __('Transactions this billing period')?></strong></td>
				    <td><strong><?= __('Description')?></strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <?php // get the relevant dates, for upgrades and new subscriptions
					  
						$daybeforeupgradedate  = (date('d M Y', strtotime('-1 days', strtotime($invoice->invoice_date))));
						$todaysdate						 = (date('d M Y', time()));
						$daysremaining         = ($invoice["billing_period_days"])-($invoice["days_used"]);
					  
				  if($invoice["balance_credit"] != 0) {
					?>
				  <tr>
				    <td><?= h($invoice->old_package); ?></td>
				    <td><?= h($invoice->title).' ('.h(date('d M Y',strtotime($invoice->sub_start_date))).' - '; ?><?php if ($invoice["days_used"] == 0) { echo h(date('d M Y',strtotime($invoice->sub_start_date))).')'; } else { echo $daybeforeupgradedate.')'; }?></td>
				    <td width="75" style="text-align: right;"><?= number_format(($invoice["old_package_price"] - $invoice["balance_credit"]), 2, '.', ',');?></td>
				    <td width="75">&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><?= h($invoice->new_package); ?></td>
				    <td><?= h($invoice->title).' ('.h(date('d M Y',strtotime($invoice->upgrade_date))).' - '.h(date('d M Y',strtotime($invoice->sub_end_date))).')'; ?></td>
				    <td width="75" style="text-align: right;"><?= number_format(($invoice["adjusted_package_price"] + $invoice["discount"]), 2, '.', ',');?></td>
				    <td width="75">&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td width="75" style="border-top: 1px solid #999999;">&nbsp;</td>
				    <td width="75" style="text-align: right;"><?= number_format((($invoice["old_package_price"] - $invoice["balance_credit"]) + ($invoice["adjusted_package_price"] + $invoice["discount"])), 2, '.', ',');?></td>
				    <td>&nbsp;</td>
				  </tr>
					<?php	  
					  } else {
				  ?>
				  <tr>
				    <td><?= h($invoice->description); ?></td>
				    <td><?= h($invoice->title).' ('.h(date("d M Y",strtotime($invoice["sub_start_date"]))).' - '.h(date("d M Y",strtotime($invoice["sub_end_date"]))).')'; ?></td>
				    <td width="75">&nbsp;</td>
				    <td width="75" style="text-align: right;"><?= number_format(($invoice["amount"] - $invoice["vat"] + $invoice["discount"] - $invoice["fee"]), 2, '.', ',');?></td>
				    <td>&nbsp;</td>
				  </tr>
					<?php	  
					  }
				  ?>
				  <?php
				  if($invoice["discount"] != 0) {
					?>
				  <tr>
				    <td>Discount</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;">- <?= number_format($invoice["discount"], 2, '.', ',');?></td>
				    <td>&nbsp;</td>
				  </tr>
					<?php	  
					  }
				  ?>
				  <?php
				  if($invoice["fee"] != 0) {
					?>
				  <tr>
				    <td>Other fees and charges</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;"><?= number_format($invoice["fee"], 2, '.', ',');?></td>
				    <td>&nbsp;</td>
				  </tr>
					<?php	  
					  }
				  ?>
				  <?php
				  if($invoice["balance_credit"] != 0) {
					?>
				  <tr>
				    <td><?= __('Amount of previous subscription paid on').' '.h(date("d M Y",strtotime($invoice->sub_start_date))).' '.__('excluding fees'); ?></td>
				    <td>&nbsp;</td>
				    <td width="75">&nbsp;</td>
				    <td width="75" style="text-align: right;"><?= number_format((0 - $invoice["old_package_price"]), 2, '.', ',');?></td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td><strong><?= __('Total transactions this billing period'); ?></strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right; border-top: 1px solid #999999;"><strong><?= number_format($invoice["subtotal"], 2, '.', ','); ?></strong></td>
				    <td>&nbsp;</td>
				  </tr>
					<?php	  
					  } else {
				  ?>
				  <tr>
				    <td><strong><?= __('Total transactions this billing period'); ?></strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right; border-top: 1px solid #999999;"><strong><?= number_format($invoice["subtotal"], 2, '.', ','); ?></strong></td>
				    <td>&nbsp;</td>
				  </tr>
					<?php	  
					  }
				  ?>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <?php
				  if($invoice["vat"] != 0) {
					?>
				  <tr>
				    <td>&nbsp;</td>
				    <td><?= __('Subtotal');?></td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;"><?= number_format(($invoice->subtotal), 2, '.', ',');?></td>
				    <td><?= h($invoice->currency) ?></td>
				  </tr>
				  <tr>
				    <td>&nbsp;</td>
				    <td><?= __('VAT');?> &#64; <?= number_format(($invoice->vat_perc), 2, '.', ',');?>&#37;</td>
				    <td>&nbsp;</td>
				    <td style="text-align: right; border-bottom: 1px solid #999999;"><?= number_format(($invoice->vat), 2, '.', ',');?></td>
				    <td>&nbsp;</td>
				  </tr>
					<?php	  
					  }
				  ?>
				  <tr>
				    <td>&nbsp;</td>
				    <td><strong><?= __('Total amount due');?></strong></td>
				    <td>&nbsp;</td>
				    <td style="text-align: right;"><strong><?= number_format($invoice->amount, 2, '.', ',');?></strong></td>
				    <td><strong><?= h($invoice->currency) ?></strong></td>
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
				  </tr>
				  <?php
				  if($invoice["comments"] != '') {
					?>
				  <tr>
				    <td><strong><?= __('Additional Notes') ?></strong></td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				  <tr>
				    <td colspan="5"><?= h($invoice->comments); ?></td>
				  </tr>
				  <?php
  				}
  				?>
				  <tr>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				    <td>&nbsp;</td>
				  </tr>
				</tbody>
				
				<tfoot>
				  <tr>
				    <td colspan="5" style="text-align: center; font-size: 10px;"><?= $site_setting['site_address']; ?></td>
				  </tr>
				</tfoot>
				
			</table>
    </dd>
	</div>

</div>

<script> // Print the table (only)
	function printDiv()
	{
	  var divToPrint=document.getElementById('areaToPrint');
	  newWin= window.open("");
	  newWin.document.write(divToPrint.outerHTML);
	  newWin.print();
	  newWin.close();
	}
</script>
