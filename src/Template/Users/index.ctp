<div class="Coupons index">
			
	<div class="row index table-title admin-table-title">
	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		
			<h2><?= __('Users')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Users', '/users');
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Users'],
					    'escape' => false
					]);
				?>
			</div>
			
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		
			<div class="pull-right btn btn-lg">
			
        <?= $this->Html->link(__('Manage Admin Roles'), ['controller' => 'AdminRoles', 'action' => 'index']); ?>
        
      </div>
      
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<!-- Are there any users? -->
	<?php
		if(count($users)>0)
		{
	?>
	
	<div class="row table-th hidden-xs">	
		
		<div class="clearfix"></div>
	
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= $this->Paginator->sort('role','Role'); ?>
		</div>
    <div class="col-lg-3 hidden-md hidden-sm col-xs-2">
	    <?= $this->Paginator->sort('username'); ?>
	   </div>
		<div class="col-lg-2 col-md-1 col-sm-1 col-xs-1">
			<?= $this->Paginator->sort('first_name','First Name'); ?>
		</div>
		<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
			<?= $this->Paginator->sort('last_name','Last Name'); ?>
		</div>
		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-1">
			<?= $this->Paginator->sort('created_on','Created On'); ?>
		</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2 text-right">
			
		</div>
		
	</div> <!--row-table-th-->
		
		
	<!-- Start loop -->
	
	
	<?php 
		$j =0;
		foreach ($users as $user):
		$j++;
	?>
	
		<div class="row inner hidden-xs">
		
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<?= h($user->role).($user->role=='admin'?' ('.$user->admins[0]->admin_role->role.')':''); ?>
			</div>
			<div class="col-lg-3 hidden-md hidden-sm col-xs-2">
				<?= h($user->username); ?>
			</div>
			<div class="col-lg-2 col-md-1 col-sm-1 col-xs-1">
				<?= h($user->first_name); ?>
			</div>
			
			<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
				<?= h($user->last_name); ?>
			</div>					
			
			<div class="col-lg-1 col-md-2 col-sm-2 col-xs-1">
				<?= h(date('d/m/Y',strtotime($user->created_on))); ?>
			</div>

			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			
				<div class="btn-group pull-right">
					<?=$user->status=='Y'?$this->Form->postLink(__('Suspend'), ['action' => 'suspend', $user->id], ['confirm' => __('Are you sure you want to suspend this user?', $user->id),'class' => 'btn btn-danger pull-right']):''; ?>
					<?=$user->status!='Y'?$this->Form->postLink(__('Activate'), ['action' => 'activate', $user->id], ['confirm' => __('Are you sure you want to activate this user?', $user->id),'class' => 'btn btn-danger pull-right']):''; ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id],['class' => 'btn pull-right']); ?>
				</div>
				
			</div>
			
		</div> <!--row-->
		
		
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					
					<h3><?= h($coupon->title); ?></h3>
					
				</a>
				
			</div> <!--col-->

				
			<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
			
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Coupon Code')?>
					</div>
					
					<div class="col-xs-6">
						<?= h($coupon->coupon_code); ?>
					</div>
				
				</div>
                                <div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Discount Type')?>
					</div>
					
					<div class="col-xs-6">
						<?php if ($coupon->type == 'Perc'){
							echo __('%');
							} else if ($coupon->type == 'Cash'){
							echo __('$');
							}
						?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Discount Value')?>
					</div>
					
					<div class="col-xs-6">
						<?= h($coupon->discount); ?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Vendor')?>
					</div>
					
					<div class="col-xs-6">
						<?php 
	            $i =0 ;
	            foreach($coupon['vendors'] as $vndr){
                if($i > 0){
                    echo ',';
                }
                $i++;
                ?>
	            <?= h($vndr->company_name); ?>
	            
            <?php } ?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Expiry Date')?>
					</div>
					
					<div class="col-xs-6">
						<?= h(date('d/m/Y',strtotime($coupon->expiry_date))); ?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Status')?>
					</div>
					
					<div class="col-xs-6">
						<?php if($coupon->status == 'U'){ ?>
				      <i class="fa fa-check"></i> <?= __('Used'); ?> <?php
				      } else if ($coupon->status == 'E'){ ?>
				      <i class="fa fa-times"></i> <?= __('Expired'); ?> <?php
				      } else { ?>
				      <i class="fa fa-star"></i> <?= __('New'); ?> <?php
				      }
				    ?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-12">
					
						<div class="btn-group pull-right">
						
							<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $coupon->id], ['confirm' => __('Are you sure you want to delete?', $coupon->id),'class' => 'btn btn-danger pull-right']); ?>
					<?= $this->Html->link(__('Edit'), ['controller'=>'Coupons','action' => 'edit', $coupon->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('View'), ['controller'=>'Coupons','action' => 'view', $coupon->id],['class' => 'btn pull-right']); ?>		                                 
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div> <!--row-->
	
	
<!-- End loop -->

			
<?php
  
  endforeach;

	} else {
			
	?>
		
	<div class="row inner withtop">
			
		<div class="col-sm-12 text-center">
			<?=	 __('No users found') ?>
		</div>
		
	</div> <!--/.row.inner-->
	
	<?php
	
	}
	
?>

<?php echo $this->element('paginator'); ?>
		
		
</div><!-- /.container -->

	</div> <!-- /#content -->
