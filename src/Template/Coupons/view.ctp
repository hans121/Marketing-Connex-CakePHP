<div class="coupons view">

	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('View Coupon'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Coupons', '/coupons');
					$this->Html->addCrumb('View coupon', ['controller' => 'coupons', 'action' => 'view/'.h($coupon->id)]);
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
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4"><strong><?= h($coupon->title); ?></strong></dt>
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $coupon->id], ['confirm' => __('Are you sure you want to delete?', $coupon->id),'class' => 'btn btn-danger pull-right']); ?>
			<?= $this->Html->link(__('Edit'), ['action' => 'edit', $coupon->id],['class' => 'btn pull-right']); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Coupon Code'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($coupon->coupon_code); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Discount Type'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if ($coupon->type == 'Perc'){
					echo __('Percentage');
				} else if ($coupon->type == 'Cash'){
					echo __('Cash');
				}
			?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Discount Value'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if ($coupon->type == 'Perc'){
					echo $this->Number->toPercentage($coupon->discount);
				} else if ($coupon->type == 'Cash'){
					echo $this->Number->currency($coupon->discount,'USD',['places'=>2]);
				}
			?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Expiry Date'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h(date('d/m/Y',strtotime($coupon->expiry_date))); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Status'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($coupon->status == 'U'){ ?>
	      <i class="fa fa-check"></i> <?= __('Used'); ?> <?php
	      } else if ($coupon->status == 'E'){ ?>
	      <i class="fa fa-times"></i> <?= __('Expired'); ?> <?php
	      } else { ?>
	      <i class="fa fa-star"></i> <?= __('New'); ?> <?php
	      }
	    ?>
		</dd>
	</div>



	<div class="row related">
		<div class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
			<h3><?= __('Related Vendors')?><small><?= $this->Html->link(__('View all'), ['controller' => 'Admins', 'action' => 'vendors'],['title'=>'View all Vendors']); ?></small></h3>
		</div>
		
	</div>
			
					
	<?php if (!empty($coupon->vendors)):?>
        
	
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
	
	<?php foreach ($coupon->vendors as $vendors): ?>
	<?php //echo var_dump($vendors); exit; ?>
		<div class="row inner hidden-xs">
			<div class="col-lg-4 col-md-4 col-sm-4">
				<?= h($vendors->company_name) ?>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4">
				<?= h($vendors->subscription_package->name) ?>
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
					<?= h($vendors->subscription_package->name) ?>
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







