<div class="subscriptionPackages index">
			
	<div class="row index table-title admin-table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-5">
			<h2><?= __('Subscription Packages')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Subscription packages', '/subscription_packages');
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-7">
		
			<div class="pull-right btn btn-lg">
		    <?= $this->Html->link(__('Add new'), ['controller' => 'SubscriptionPackages', 'action' => 'add']); ?>
			</div>
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="row table-th hidden-xs">		
	
		<div class="col-lg-2 col-md-1 col-sm-6 col-xs-2">
			<?= $this->Paginator->sort('name','Title'); ?>
		</div>
		<div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-right">
			<?= $this->Paginator->sort('no_partners','Max Partners'); ?>
		</div>
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1 text-right">
			<?= $this->Paginator->sort('storage','Max Storage'); ?>
		</div>
		<div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-right">
			<?= $this->Paginator->sort('no_emails','Max e-mails (Month)'); ?>
		</div>
		<div class="col-lg-1 col-md-2 hidden-sm col-xs-1 text-right">
			<?= $this->Paginator->sort('monthly_price','Price (Month)'); ?>
		</div>
		<div class="col-lg-1 col-md-2 hidden-sm col-xs-1 text-right">
			<?= $this->Paginator->sort('annual_price','Price (Year)'); ?>
		</div>
		<div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-right">
			<?= $this->Paginator->sort('signup_fee','Initial fee'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= $this->Paginator->sort('status','Status'); ?>
		</div>
    <div class="col-lg-3 col-md-2 col-sm-4 col-xs-3">
	    
    </div>
	
	</div> <!--row-table-th-->
		
		
		
	<!-- Start loop -->
	
	<?php 
		$j =0;
		foreach ($subscriptionPackages as $subscriptionPackage): 
		$j++;
	?>
	
	<div class="row inner hidden-xs">
	
		<div class="col-lg-2 col-md-1 col-sm-6 col-xs-2">
			<?= h($subscriptionPackage->name); ?>
		</div>
		
		<div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-right">
			<?php echo $this->Number->precision(h($subscriptionPackage->no_partners), 0); ?>
		</div>
		
		<div class="col-lg-1 hidden-md hidden-sm col-xs-1 text-right">
			<?= $this->Number->toReadableSize($subscriptionPackage->storage*1073741824); ?>
		</div>

		<div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-right">
			<?php echo $this->Number->precision(h($subscriptionPackage->no_emails), 0); ?>
		</div>
		
		<div class="col-lg-1 col-md-2 hidden-sm col-xs-1 text-right">
			<?= $this->Number->currency(round($subscriptionPackage->monthly_price),$my_currency,['places'=>2]) ?>
		</div>
											
		<div class="col-lg-1 col-md-2 hidden-sm col-xs-1 text-right">
			<?= $this->Number->currency(round($subscriptionPackage->annual_price),$my_currency,['places'=>2]) ?>
		</div>

		<div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-right">
			<?= $this->Number->currency(round($subscriptionPackage->signup_fee),$my_currency,['places'=>2]) ?>
		</div>
                
    <div class="col-lg-1 col-md-1 col-sm-2 col-xs-1">
			<?php if($subscriptionPackage->status == 'A'){ ?>
	      <i class="fa fa-check"></i> <i class="fa fa-unlock"></i> <?php
	      } else if ($subscriptionPackage->status == 'C'){ ?>
	      <i class="fa fa-times"></i> <?php
	      } else { ?>
	      <i class="fa fa-check"></i> <i class="fa fa-lock"></i> <?php
	      }
	    ?>
		</div>

		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-3">
		
			<div class="btn-group pull-right">
			
				<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subscriptionPackage->id], ['confirm' => __('Are you sure you want to delete?', $subscriptionPackage->id),'class' => 'btn btn-danger pull-right']); ?>
				<?= $this->Html->link(__('Edit'), ['controller'=>'SubscriptionPackages','action' => 'edit', $subscriptionPackage->id],['class' => 'btn pull-right']); ?>
	      <?= $this->Html->link(__('View'), ['controller'=>'SubscriptionPackages','action' => 'view', $subscriptionPackage->id],['class' => 'btn pull-right']); ?>
                                  
			</div><!--nested row-->
			
		</div>
		
	</div> <!--row-->
	
		
	<div class="row inner visible-xs">
	
		<div class="col-xs-12 text-center">
			
			<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
				
				<h3><?= h($subscriptionPackage->name); ?></h3>
				
			</a>
			
		</div> <!--col-->

		<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
			
				<div class="col-xs-6">
					<?= __('Min Term')?>
				</div>

				<div class="col-xs-6">
					<?= h($subscriptionPackage->duration); ?>
				</div>
				
			</div>
				
			<div class="row inner">

				<div class="col-xs-6">
					<?= __('Max partners')?>
				</div>
				
				<div class="col-xs-6">
					<?php echo $this->Number->precision(h($subscriptionPackage->no_partners), 0); ?>
				</div>
				
			</div>
				
			<div class="row inner">

				<div class="col-xs-6">
					<?= __('Max Storage')?>
				</div>
				
				<div class="col-xs-6">
					<?= $this->Number->toReadableSize($subscriptionPackage->storage*1073741824); ?>
				</div>
				
			</div>
				
			<div class="row inner">

				<div class="col-xs-6">
					<?= __('Max e-mails')?>
				</div>
				
				<div class="col-xs-6">
					<?php echo $this->Number->precision(h($subscriptionPackage->no_emails), 0); ?>
				</div>
				
			</div>
				
			<div class="row inner">

				<div class="col-xs-6">
					<?= __('Monthly Price')?>
				</div>
				
				<div class="col-xs-6">
					<?= $this->Number->currency(round($subscriptionPackage->monthly_price),$my_currency,['places'=>2]) ?>
				</div>
				
			</div>
				
			<div class="row inner">

				<div class="col-xs-6">
					<?= __('Annual Price')?>
				</div>
				
				<div class="col-xs-6">
					<?= $this->Number->currency(round($subscriptionPackage->annual_price),$my_currency,['places'=>2]) ?>
				</div>
				
			</div>
				
			<div class="row inner">

				<div class="col-xs-6">
					<?= __('Initial fee')?>
				</div>
				
				<div class="col-xs-6">
					<?= $this->Number->currency(round($subscriptionPackage->signup_fee),$my_currency,['places'=>2]) ?>
				</div>
				
			</div>
				
			<div class="row inner">

				<div class="col-xs-12">
				
					<div class="btn-group pull-right">
						<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subscriptionPackage->id], ['confirm' => __('Are you sure you want to delete?', $subscriptionPackage->id),'class' => 'btn btn-danger pull-right']); ?>
						<?= $this->Html->link(__('Edit'), ['controller'=>'SubscriptionPackages','action' => 'edit', $subscriptionPackage->id],['class' => 'btn pull-right']); ?>
			      <?= $this->Html->link(__('View'), ['controller'=>'SubscriptionPackages','action' => 'view', $subscriptionPackage->id],['class' => 'btn pull-right']); ?>						
					</div>
										
				</div> <!--col-xs-12-->
		
			</div>
			
		</div> <!--collapseOne-->
		
	</div> <!--row-->
	
	
<?php endforeach; ?>
	
	
<!-- End loop -->
		
		

<?php echo $this->element('paginator'); ?>


		
</div><!-- /.container -->

	</div> <!-- /#content -->
