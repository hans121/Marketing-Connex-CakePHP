<div class="invoices index">
			
	<div class="row index table-title admin-table-title">
			
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			
			<h2>
	      <?= __('Invoices')?>
	    </h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Vendors', ['controller'=>'Admins','action' => 'vendors']);
					$this->Html->addCrumb('Invoices', ['controller'=>'Invoices','action' => 'index']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
					
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
	    <?//= $this->Html->link(__('Add New'), ['controller' => 'Invoices', 'action' => 'add'],['class'=>'btn btn-lg pull-right']); ?>
	    <?= $this->Html->link(__('Export data').' '.$this->Html->tag('true',__('',false),['class' => 'fa fa-share-square-o']), ['controller'=>'Invoices', 'action' => 'export'], ['escape' => false, 'title' => 'Export invoice data', 'class'=>'pull-right btn btn-lg']); ?>

    </div>
				
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<!-- Are there any invoices? -->
	<?php
		if(count($invoices)>0)
		{
	?>
	
		<div class="row table-th hidden-xs">		
		
			<div class="col-lg-3 col-md-2 col-sm-2">
				<?= $this->Paginator->sort('vendor_id','Vendor'); ?>
			</div>

			<div class="col-lg-2 col-md-3 hidden-sm">
				<?= $this->Paginator->sort('invoice_number'); ?>
			</div>

			<div class="col-lg-1 col-md-1 col-sm-2">
				<?= $this->Paginator->sort('invoice_date'); ?>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-2 text-right">
				<?= $this->Paginator->sort('amount'); ?>
			</div>
                        
			<div class="col-lg-1 col-md-1 col-sm-2">
				<?= $this->Paginator->sort('status'); ?>
			</div>
                        
			<div class="col-lg-3 col-md-3 col-sm-4">
			</div>
		
		</div> <!--row-table-th-->
		
		<?php 
			$j =0;
			foreach ($invoices as $invoice):
			$j++;
		?>
		
		<!-- Start loop -->
		
		<div class="row inner hidden-xs">
		
			<div class="col-lg-3 col-md-2 col-sm-2">
				<strong>
					<?= $invoice->has('vendor') ? $this->Html->link($invoice->vendor->company_name, ['controller' => 'Admins', 'action' => 'viewVendor', $invoice->vendor->id]) : ''; ?>
				</strong>
			</div>
			
			<div class="col-lg-2 col-md-3 hidden-sm">
				<?= h($invoice->invoice_number); ?>
			</div>
			
			<div class="col-lg-1 col-md-1 col-sm-2 small">
				<?= h(date('d/m/Y',strtotime($invoice->invoice_date))); ?>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-2 text-right">
				<?= h($invoice->currency) ?> <?= $this->Number->precision(h($invoice->amount), 2); ?>
			</div>
			
			<div class="col-lg-1 col-md-1 col-sm-2">
				<?php if($invoice->status == 'paid'){ ?>
		      <i class="fa fa-check"></i> <?= __('Paid'); ?> <?php
		      } else if ($invoice->status == 'P'){ ?>
		      <i class="fa fa-minus"></i> <?= __('Pending'); ?> <?php
	      } ?>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-4">
				
				<div class="btn-group pull-right">
					
	        <?= $this->Html->link(__('View'), ['controller'=>'Invoices','action' => 'view', $invoice->id],['class' => 'btn']); ?>
					<?//= $this->Html->link(__('Edit'), ['controller'=>'Invoices','action' => 'edit', $invoice->id],['class' => 'btn']); ?>
					<?//= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete?', $invoice->id),'class' => 'btn btn-danger']); ?>
                                    
				</div>
				
			</div>
			
		</div> <!--row-->
		
		
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					
					<h3><?= h($invoice->invoice_number); ?></h3>
					
				</a>
				
			</div> <!--col-->

				
			<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
			
			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Title'); ?>
				</div>
				<div class="col-xs-7">
					<?= h($invoice->title) ?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Description'); ?>
				</div>
				<div class="col-xs-7">
					<?= h($invoice->description) ?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Amount'); ?>
				</div>
				<div class="col-xs-7">
					<?= h($invoice->currency) ?> <?= h($invoice->amount) ?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Invoice Date'); ?>
				</div>
				<div class="col-xs-7">
					<?= h(date('d/m/Y',strtotime($invoice->invoice_date))) ?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-5">
					<?= __('Status'); ?>
				</div>
				<div class="col-xs-7">
					<?php if($invoice->status == 'paid'){ ?>
			      <span class="glyphicon glyphicon-star"></span> <?= __('Paid'); ?> <?php
			      } else if ($invoice->status == 'P'){ ?>
			      <span class="glyphicon glyphicon-star-empty"></span> <?= __('Pending'); ?> <?php
			      } ?>
				</div>
			</div>
			
			<div class="row inner">
				<div class="col-xs-12">
					<div class="btn-group pull-right">
						
		        <?= $this->Html->link(__('View'), ['controller'=>'Invoices','action' => 'view', $invoice->id],['class' => 'btn']); ?>
						<?//= $this->Html->link(__('Edit'), ['controller'=>'Invoices','action' => 'edit', $invoice->id],['class' => 'btn']); ?>
						<?//= $this->Form->postLink(__('Delete'), ['action' => 'delete', $invoice->id], ['confirm' => __('Are you sure you want to delete?', $invoice->id),'class' => 'btn btn-danger']); ?>
					
					</div>
				</div>
			</div>
			
			</div> <!--collapseOne-->
			
		</div> <!--row-->
		
		
		<!-- End loop -->
			
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
		
		
		<?php echo $this->element('paginator'); ?>
		
		
		</div><!--row table-th-->
	
			</div> <!--subscriptionPackages index?-->

