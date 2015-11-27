<div class="vendors view">

	<div class="row table-title">

		<div class="col-lg-6">
		
			<h2><?= __('Vendor'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Vendors', ['controller'=>'Admins','action' => 'vendors']);
					$this->Html->addCrumb('view', ['controller'=>'Admins','action' => 'viewVendor', $vendor->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		<div class="col-lg-6">	
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Upload Partners').' <i class="fa fa-cloud-upload"></i>', ['action' => 'importpartners',$vendor->id], ['escape' => false, 'title' => 'Import from CSV', 'class'=>'btn btn-lg']); ?>
				<?= $this->Html->link(__('CSV Template').' <i class="fa fa-cloud-download"></i>', ['controller'=>'Admins', 'action' => 'getexportcsvtemplate'], ['escape' => false, 'title' => 'Export dashboard data', 'class'=>'btn btn-lg']); ?>	
			</div>

		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
                                
	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
		
	    <?php if(trim($vendor->logo_url) != ''){ ?>
	    
				<a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image($vendor->logo_url)?>'>
					<strong><?= h($vendor->company_name); ?></strong> <i class="fa fa-info-circle"></i>
				</a>
	
	    <?php } else { ?>
	    
					<strong><?= h($vendor->company_name); ?></strong>
					
	    <?php } ?>
	    
		</dt>
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
		
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Edit'), ['controller'=>'Admins','action' => 'editVendor', $vendor->id],['class' => 'btn pull-right']); ?>
				<?= $this->Form->postLink(__('Delete'), ['action' => 'deleteVendor', $vendor->id], ['confirm' => __('Are you sure you want to delete?', $vendor->id),'class' => 'btn btn-danger pull-right']); ?>
			</div>
			
		</dd>
		
	</div>
	
	<?php 
		if (h($vendor->website)!='') {
	?>
	  <div class="row inner">
			<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
				<?= __('Website'); ?>
			</dt>
			<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
				<?= $this->Html->link(h($vendor->website), h($vendor->website),['target' => '_blank']); ?> <i class="fa fa-external-link"></i>
			</dd>
	  </div>
	<?php
		}
	?>
 	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Address'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($vendor->address); ?>
		</dd>
  </div>
  
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('City'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($vendor->city); ?>
		</dd>
  </div>
  	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('County/State'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($vendor->state); ?>
		</dd>
  </div>
  	
	<div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Zip / Postcode'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($vendor->postalcode); ?>
		</dd>
  </div>
  	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Country'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($vendor->country); ?>
		</dd>
  </div>
  	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Phone'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($vendor->phone); ?>
	  </dd>
	</div>	

  	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Subscription Package'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($vendor['subscription_package']->name); ?>
		</dd>
  </div>
  	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Subscription Type'); ?>
		</dt>
		<dd class="col-lg-5 col-md-5 col-sm-4 col-xs-4">
			<?php
				if($vendor->subscription_type == 'monthly'){ ?>
	      	<?= __('Monthly'); ?> <?php
	      } else if ($vendor->subscription_type == 'yearly'){ ?>
		      </span> <?= __('Yearly'); ?> <?php
	      }
	    ?>
		</dd>
    <dd class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
    	<div class="btn-group pull-right">
	      <?= $this->Html->link("Edit payment card", ['controller' => 'Admins', 'action' => 'editcard',$vendor->id],['class'=> 'btn pull-right']); ?>
    	</div>
    </dd>
  </div>
				
	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Subscription Expiry Date'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h(date('d/m/Y',strtotime($vendor->subscription_expiry_date))); ?>
		</dd>
	</div>

  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Coupon used'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($vendor->coupon['title']).' / '.h($vendor->coupon['coupon_code']).' ('; if (h($vendor->coupon['type'])=="Perc") { echo h($vendor->coupon['discount']).'%'; } else { echo '$'.h($vendor->coupon['discount']);}; echo (' '.__('reduction)')); ?>
		</dd>
  </div>
  	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Email send limit'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php echo $this->Number->precision(h($vendor['subscription_package']->no_emails), 0); ?>
		</dd>
  </div>
  	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Maximum permitted partners'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php echo $this->Number->precision(h($vendor['subscription_package']->no_partners), 0); ?>
		</dd>
  </div>	
  
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Language'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php
				$country==h($vendor->language);
				if ($country='en') {
					$country='gb';
				};
			?>
		  <?php $flag = strtoupper($vendor->language) ?>
			<?php echo $this->Html->image('flags/flat/24/'.$flag.'.png', [ 'alt'=>'Panovus','width'=>'24','height'=>'24','class'=>'pull-left img-responsive']).' ('.h($vendor->language).')';?>						
		</dd>
  </div>
  	
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('VAT ID'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($vendor->vat_no); ?>
		</dd>
  </div>	
  
  <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= __('Status'); ?>
		</dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($vendor->status == 'Y'){ ?>
	      <i class="fa fa-check"></i> <?= __('Active'); ?> <?php
	      } else if ($vendor->status == 'S'){ ?>
	      <i class="fa fa-exclamation-triangle"></i> <?= __('Suspended'); ?> <?php
	      } else if ($vendor->status == 'B'){ ?>
	      <i class="fa fa-times"></i> <?= __('Blocked'); ?> <?php
	      } else if ($vendor->status == 'P'){ ?>
	      <i class="fa fa-circle-o-notch fa-spin"></i> <?= __('Pending'); ?> <?php
	      } else { ?>
	      <i class="fa fa-circle-o"></i> <?= __('Inactive'); ?> <?php
	      }
	    ?>
		</dd>
  </div>
  
	
	
	
	<div class="row related">
		<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
			<h3><?= __('Related Coupons')?><small><?= $this->Html->link(__('View all'), ['controller' => 'Coupons', 'action' => 'index'],['title'=>'View all coupons']); ?></small></h3>
		</div>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-4">
			<?= $this->Html->link(__('Add new'), ['controller' => 'Coupons', 'action' => 'add'],['class'=>'btn btn-lg pull-right']); ?> 
		</div>	
	</div>
			
					
	<?php 
    if (!empty($vendor['coupon'])) {
        
      $coupons = $vendor['coupon'];
      ?>
	<?php //foreach ($vendor->coupons as $coupons): ?>
	
	<div class="row table-th hidden-xs">	
	                            
		<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
			<?= __('Title'); ?>
		</div>		
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= __('Expiry Date'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= __('Discount Type'); ?>
		</div>
		<div class="col-lg-1 col-md-1 hidden-sm col-xs-1">
			<?= __('Value'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= __('Status'); ?>
		</div>
	</div>
	
	<div class="row inner hidden-xs">
		<div class="col-lg-2 col-md-2 col-sm-4 col-xs-4">
			<?= h($coupons->title) ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= h(date('d/m/Y',strtotime($coupons->expiry_date))) ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?php if ($coupons->type == 'Perc'){
					echo __('Percentage');
				} else if ($coupons->type == 'Cash'){
					echo __('Cash');
				}
			?>
		</div>
		<div class="col-lg-1 col-md-1 hidden-sm col-xs-1">
			<?php if ($coupons->type == 'Perc'){
					echo $this->Number->toPercentage($coupons->discount);
				} else if ($coupons->type == 'Cash'){
					echo $this->Number->currency($coupons->discount,'USD',['places'=>2]);
				}
			?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?php if($coupons->status == 'U'){ ?>
	      <i class="fa fa-check"></i> <?= __('Used'); ?> <?php
	      } else if ($coupons->status == 'E'){ ?>
	      <i class="fa fa-times"></i> <?= __('Expired'); ?> <?php
	      } else { ?>
	      <i class="fa fa-star"></i> <?= __('New'); ?> <?php
	      }
	    ?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-2 col-xs-2">
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('View'), ['controller' => 'Coupons', 'action' => 'view/'.h($coupons->id)],['class'=>'btn','title'=>'View all coupons']); ?>
			</div>
		</div>
	</div>
	
			
	<!-- For mobile view only -->
	<div class="row inner visible-xs">
	
		<div class="col-xs-12 text-center">
			<a data-toggle="collapse" data-parent="#accordion" href="#coupons-1">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#coupons-1">
					<h3><?= h($coupons->title) ?></h3>
				</a>
				
			</a>						
		</div> <!-- /.col -->
					
		<div id="coupons-1" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Discount Value'); ?>
				</div>
				<div class="col-xs-6">
					<?php if ($coupons->type == 'Perc'){
							echo $this->Number->toPercentage($coupons->discount);
						} else if ($coupons->type == 'Cash'){
							echo $this->Number->currency($coupons->discount,'USD',['places'=>2]);
						}
					?>
				</div>
			</div>
			<div class="row inner">
				<div class="col-xs-6"><?= __('Discount Type'); ?></div>
				<div class="col-xs-6">
					<?php if ($coupons->type == 'Perc'){
							echo __('Percentage');
						} else if ($coupons->type == 'Cash'){
							echo __('Cash');
						}
					?>
	      </div>
			</div>
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Expiry Date'); ?>
				</div>
				<div class="col-xs-6">
					<?= h(date('d/m/Y',strtotime($coupons->expiry_date))) ?>
				</div>
			</div>
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Status'); ?>
				</div>
				<div class="col-xs-6">
					<?php if($coupons->status == 'U'){ ?>
			      <i class="fa fa-check"></i> <?= __('Used'); ?> <?php
			      } else if ($coupons->status == 'E'){ ?>
			      <i class="fa fa-times"></i> <?= __('Expired'); ?> <?php
			      } else { ?>
			      <i class="fa fa-star"></i> <?= __('New'); ?> <?php
			      }
			    ?>
				</div>
			</div>	
		
		</div> <!-- /.collapse -->				
				
	</div> <!-- /.row -->
	
	
	
	<?php
		
		} else {
												
	?>
		
	<div class="row inner withtop">
			
		<div class="col-sm-12 text-center">
			<?=	 __('No coupons found') ?>
		</div>
		
	</div> <!--/.row.inner-->
	
	<?php
	
	 }
	
	?>
					
					
	<div class="row related">
		<div class="col-lg-9 col-md-8 col-sm-6 col-xs-12"><h3>Related Invoices<small><?= $this->Html->link(__('View all'), ['controller' => 'Invoices', 'action' => 'index'],['title'=>'View all invoices']); ?></small></h3></div>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
			<?php // echo $this->Html->link(__('Add new'), ['controller' => 'Invoices', 'action' => 'add'],['class'=>'btn btn-lg pull-right']); ?> 
		</div>	
	</div>
					
					
	<?php if (!empty($vendor->invoices)) { ?>
	
	
	<div class="row table-th hidden-xs">	
	                           
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= __('Invoice Number'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= __('Invoice Date'); ?>
		</div>
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
			<?= __('Title'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-1 text-right">
			<?= __('Amount'); ?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-2">
			<?= __('Status'); ?>
		</div>
			
	</div>
	
	
	<?php 
    $j=0;
    foreach ($vendor->invoices as $invoices): $j++;
   ?>
	
	
	<div class="row inner hidden-xs">
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= h($invoices->invoice_number) ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= h(date('d/m/Y',strtotime($invoices->invoice_date))) ?>
		</div>
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
			<?= h($invoices->title) ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
			<?= h($invoices->currency) ?> <?= h($invoices->amount) ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?php if($invoices->status == 'paid'){ ?>
	      <i class="fa fa-check"></i> <?= __('Paid'); ?> <?php
	      } else if ($invoices->status == 'P'){ ?>
	      <i class="fa fa-minus"></i> <?= __('Pending'); ?> <?php
      } ?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3">
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('View'), ['controller' => 'Invoices', 'action' => 'view', $invoices->id],['class'=>'btn']); ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'Invoices', 'action' => 'edit', $invoices->id],['class'=>'btn']); ?>
			</div>
		</div>
	</div>
					
					
	<!-- For mobile view only -->
	<div class="row inner visible-xs">
	
		<div class="col-xs-12 text-center">
			<a data-toggle="collapse" data-parent="#accordion" href="#invoices-<?= $j ?>">
				<h3><?= h($invoices->invoice_number) ?></h3>
			</a>						
		</div> <!--col-->
					
		<div id="invoices-<?= $j ?>" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Title'); ?>
				</div>
				<div class="col-xs-6">
					<?= h($invoices->title) ?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Description'); ?>
				</div>
				<div class="col-xs-6">
					<?= h($invoices->description) ?>
				</div>
			</div>
			
			<div class="row inner">						
				<div class="col-xs-6">
					<?= __('Currency'); ?>
				</div>
				<div class="col-xs-6">
					<?= h($invoices->currency) ?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Amount'); ?>
				</div>
				<div class="col-xs-6">
					<?= h($invoices->amount) ?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Invoice Date'); ?>
				</div>
				<div class="col-xs-6">
					<?= h(date('d/m/Y',strtotime($invoices->invoice_date))) ?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Status'); ?>
				</div>
				<div class="col-xs-6">
					<?php if($invoices->status == 'paid'){ ?>
			      <span class="glyphicon glyphicon-star"></span> <?= __('Paid'); ?> <?php
			      } else if ($invoices->status == 'P'){ ?>
			      <span class="glyphicon glyphicon-star-empty"></span> <?= __('Pending'); ?> <?php
			      } ?>
				</div>
			</div>	
		
		</div> <!-- /.collapse -->				
					
	</div> <!-- /.row -->
	
	
	<?php
		
		endforeach;
	
		} else {
												
	?>
		
	<div class="row inner withtop">
			
		<div class="col-sm-12 text-center">
			<?=	 __('No invoices found') ?>
		</div>
		
	</div> <!--/.row.inner-->
	
	<?php
	
	 }
	
	?>
	
	
	<div class="row related">
		<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8"><h3><?= __('Related Vendor Managers')?></h3></div>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-4">
			<?= $this->Html->link(__('Add new'), ['controller' => 'Admins', 'action' => 'addVendorManager', $vendor->id],['class'=> 'btn btn-lg pull-right']); ?>
		</div>	
	</div>
	
	
	<?php if (!empty($vendor->vendor_managers)): ?>
	
	<div class="row table-th hidden-xs">		
		<div class="col-sm-4">
			<?= __('Name'); ?>
		</div>		
		<div class="col-sm-3 text-center">
			<?= __('Primary Manager'); ?>
		</div>
		<div class="col-sm-5">
		</div>
	</div>
	
	
	<?php 
    $j=0;
    foreach ($vendor->vendor_managers as $vendorManagers): $j++;
   ?>
			
			
	<div class="row inner hidden-xs">
	
		<div class="col-sm-4">
			<?= h($vendorManagers['user']->full_name) ?>
		</div>	
			
		<div class="col-sm-3 text-center">
			<?php if($vendorManagers->primary_manager == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      } ?>
		</div>
		
		<div class="col-sm-5">
			<div class="btn-group pull-right">

				
				<?= $this->Html->link(__('Edit'), ['controller' => 'Admins', 'action' => 'editVendorManager', $vendorManagers->user_id,$vendor->id],['class'=> 'btn pull-right']);
				if($vendorManagers->primary_manager != 'Y'){
            echo $this->Form->postLink(__('Make Primary'), ['controller' => 'Admins', 'action' => 'changePrimaryVmanager', $vendorManagers->id, $vendor->id],['class'=>'btn pull-right'], ['confirm' => __('Are you sure you want to change the Primary Vendor Manager?', $vendorManagers->id, $vendor->id)]);
            echo $this->Form->postLink(__('Delete'), ['controller' => 'Admins', 'action' => 'deleteVendorManager', $vendorManagers->id, $vendor->id],['class'=>'btn btn-danger pull-right'], ['confirm' => __('Are you sure you want to deete Manager?', $vendorManagers->id, $vendor->id)]);?>
        <?php  
        }
      ?>

			</div>
		</div>
		
	</div>
	
	
	<!-- For mobile view only -->
	<div class="row inner visible-xs">
		
		<div class="col-xs-12 text-center">
		
			<a data-toggle="collapse" data-parent="#accordion" href="#vmanagers-<?= $j ?>">
			
				<h3><?= h($vendorManagers['user']->full_name) ?></h3>
				
			</a>	
								
		</div> <!--col-->
					
		<div id="vmanagers-<?= $j ?>" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
				<div class="col-xs-6"><?= __('Name'); ?></div>
				<div class="col-xs-6"><?= h($vendorManagers['user']->full_name) ?></div>
			</div>
			<div class="row inner">
				<div class="col-xs-6"><?= __('Primary Manager'); ?></div>
				<div class="col-xs-6">
					<?php if($vendorManagers->primary_manager == 'Y'){?>
			      <span class="glyphicon glyphicon-ok"></span> <?php
			      } ?>
				</div>
			</div>
			<div class="row inner">
				<div class="col-xs-12">
					<div class="btn-group pull-right">
						<?= $this->Html->link(__('View'), ['controller' => 'Vendors', 'action' => 'viewManager', $vendorManagers->id],['class'=>'btn']); ?>
						<?= $this->Html->link(__('Edit'), ['controller' => 'Vendors', 'action' => 'editManager', $vendorManagers->id],['class'=>'btn']);
						if($vendorManagers->primary_manager != 'Y'){
				        echo $this->Form->postLink(__('Make Primary'), ['controller' => 'Admins', 'action' => 'changePrimaryVmanager', $vendorManagers->id, $vendor->id],['class'=>'btn'], ['confirm' => __('Are you sure you want to change the Primary Vendor Manager?', $vendorManagers->id, $vendor->id)]);?>
				      <?php  
				      }
				    ?>
					</div>
				</div>
			</div>
		
		</div> <!-- /.collapse -->				
	
	</div> <!-- /.row -->
	
	
	<?php endforeach; ?>
	
	<?php endif; ?>


</div> <!-- /.vendors.view -->		
