<div class="subscriptionPackages view">

	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Subscription Package'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Subscription packages', '/subscription_packages');
					$this->Html->addCrumb('View subscription package', ['controller' => 'subscription_packages', 'action' => 'view/'.h($subscriptionPackage->id)]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	    <?= $this->Html->link(__('Add new'), ['action' => 'add'],['class'=>'btn btn-lg pull-right']); ?>
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4"><strong><?= h($subscriptionPackage->name); ?></strong></dt>
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
				<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $subscriptionPackage->id], ['confirm' => __('Are you sure you want to delete?', $subscriptionPackage->id),'class' => 'btn btn-danger pull-right']); ?>
				<?= $this->Html->link(__('Edit'), ['action' => 'edit', $subscriptionPackage->id],['class' => 'btn pull-right']); ?>
			</div>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Annual price'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->currency($subscriptionPackage->annual_price,'USD',['places'=>2]);?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Monthly price'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->currency($subscriptionPackage->monthly_price,'USD',['places'=>2]);?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Signup fee'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Number->currency($subscriptionPackage->signup_fee,'USD',['places'=>2]);?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Duration'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($subscriptionPackage->duration); ?> Months
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Max. Number of Partners'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php echo $this->Number->precision(h($subscriptionPackage->no_partners), 0); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Max Storage Capacity'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($subscriptionPackage->storage).' GB'; ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Max Number of E-mails'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php echo $this->Number->precision(h($subscriptionPackage->no_emails), 0); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Resource Library'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->resource_library == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Portal Cms'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->portal_cms == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('MDF'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->MDF == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Deal Registration'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->deal_registration == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Partner Recruit'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->partner_recruit == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Training'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->training == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Socialmedia'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->Socialmedia == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Multilingual'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->multilingual == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Partner Incentive'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->partner_incentive == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Partner App'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->partner_app == 'Y'){?>
	      <span class="glyphicon glyphicon-ok"></span> <?php
	      }?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Status'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($subscriptionPackage->status == 'A'){ ?>
	      <i class="fa fa-check"></i> <i class="fa fa-unlock"></i> Active (public)<?php
	      } else if ($subscriptionPackage->status == 'C'){ ?>
	      <i class="fa fa-times"></i> Cancelled <?php
	      } else { ?>
	      <i class="fa fa-check"></i> <i class="fa fa-lock"></i> Private<?php
	      } ?>
		</dd>
	</div>




	<div class="row related">
		<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
			<h3><?= __('Related Vendors')?><small><?= $this->Html->link(__('View all'), ['controller' => 'Admins', 'action' => 'vendors'],['title'=>'View all Vendors']); ?></small></h3>
		</div>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-4">
		</div>	
	</div>
			
					
	<?php if (!empty($subscriptionPackage->vendors)):?>
        
	
	<div class="row table-th hidden-xs">	
	                            
		<div class="col-lg-4 col-md-4 col-sm-4">
			<?= __('Company Name'); ?>
		</div>		
		<div class="col-lg-4 col-md-4 col-sm-4">
			<?= __('Subscription Package'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2">
			<?= __('Subscription Type'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2">
		</div>
	</div>
	
	<?php foreach ($subscriptionPackage->vendors as $vendors): ?>
	
		<div class="row inner hidden-xs">
			<div class="col-lg-4 col-md-4 col-sm-4">
				<?= h($vendors->company_name) ?>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4">
				<?= h($subscriptionPackage->name) ?>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2">
				<?php
					if($vendors->subscription_type == 'monthly'){ ?>
		      	<?= __('Monthly'); ?> <?php
		      } else if ($vendors->subscription_type == 'yearly'){ ?>
			      </span> <?= __('Yearly'); ?> <?php
		      }
		    ?>
			</div>
			<div class="col-lg-2 col-md-2 col-sm-2">
				<div class="btn-group pull-right">
					<?= $this->Html->link(__('View'), ['controller' => 'Admins', 'action' => 'viewVendor', $vendors->id],['class'=>'btn pull-right']); ?>
				</div>
			</div>
		</div>
	
			
	<!-- For mobile view only -->
	<div class="row inner visible-xs">
	
		<div class="col-xs-12 text-center">
			<a data-toggle="collapse" data-parent="#accordion" href="#coupons-1">
				
				<h3><?= h($vendors->company_name) ?></h3>
				
			</a>						
		</div> <!-- /.col -->
					
		<div id="coupons-1" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
				<div class="col-xs-6"><?= __('Website'); ?></div>
				<div class="col-xs-6"><?= h($vendors->website) ?></div>
			</div>
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Subscription Package'); ?>
				</div>
				<div class="col-xs-6">
					<?= h($subscriptionPackage->name) ?>
				</div>
			</div>
			<div class="row inner">
				<div class="col-xs-6">
					<?= __('Subscription Type'); ?>
				</div>
				<div class="col-xs-6">
					<?php
						if($vendors->subscription_type == 'monthly'){ ?>
			      	<?= __('Monthly'); ?> <?php
			      } else if ($vendors->subscription_type == 'yearly'){ ?>
				      </span> <?= __('Yearly'); ?> <?php
			      }
			    ?>
				</div>
			</div>
			<div class="row inner">
				<div class="col-xs-12">
					<div class="btn-group pull-right">
						<?= $this->Html->link(__('View'), ['controller' => 'Vendors', 'action' => 'view', $vendors->id],['class'=>'btn pull-right']); ?>
						<?= $this->Html->link(__('Edit'), ['controller' => 'Vendors', 'action' => 'edit', $vendors->id],['class'=>'btn pull-right']); ?>
						<?= $this->Form->postLink(__('Delete'), ['controller' => 'Vendors', 'action' => 'delete', $vendors->id],['class'=>'btn btn-danger pull-right'],['confirm' => __('Are you sure you want to delete # %s?', $vendors->id)]); ?>
					</div>
				</div>
			</div>	
		
		</div> <!-- /.collapse -->				
				
	</div> <!-- /.row -->
	
	
	<?php endforeach; ?>

	<?php else:?>
	
	
	<div class="row inner withtop">
		<div class="col-sm-12 text-center">
			<?= __('No related vendors found') ?>
		</div>
	</div>
		
		
	<?php endif;?>


</div>

