

<div class="Admins vendors">

	<div class="row table-title">
	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			
			<h2>
				<?= __('Vendors List'.($country!=''? ' for '  .ucwords($country . ($state!=''?', ' . $state : '')) : ''))?> <?php if($country!='' || $state!=''):?><small><?= $this->Html->link(__('See all'), ['action' => 'vendors']); ?></small><?php endif; ?>                         
			</h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Vendors', '/vendors');
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
			
		</div>
		
	</div>
		
</div> <!--row-table-title-->
	
	
<div class="row table-th hidden-xs">	
  
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="clearfix"></div>

	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-3"> <?= $this->Paginator->sort('company_name'); ?></div>
	<div class="col-lg-1 hidden-md hidden-sm col-xs-1"><?= $this->Paginator->sort('state'); ?></div>
	<div class="col-lg-2 col-md-2 hidden-sm col-xs-2"><?= $this->Paginator->sort('country'); ?></div>
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><?= $this->Paginator->sort('status'); ?></div>
	<div class="col-lg-4 col-md-5 col-sm-6 col-xs-4"></div>

</div> <!-- /.row .table-th -->




<!-- Start loop -->

<?php
	$j =0;
  foreach ($vendors as $vendor): 
 $j++;
?>
    
<div class="row inner hidden-xs">

	<div class="col-lg-3 col-md-3 col-sm-4 col-xs-3">
   
    <?php if(trim($vendor->logo_url) != ''){ ?>
    
			<a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image('logos/'.$vendor->logo_url)?>'>
				<?= h($vendor->company_name); ?> <i class="fa fa-info-circle"></i>
			</a>

    <?php } else { ?>

			<?= h($vendor->company_name); ?>

    <?php }?>
    
  </div>
	
	<div class="col-lg-1 hidden-md hidden-sm col-xs-1">
		<?= h($vendor->state); ?>
	</div>
	
	<div class="col-lg-2 col-md-2 hidden-sm col-xs-2">
		<?= h($vendor->country); ?>
	</div>
	
	<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
		<?php if($vendor->status == 'Y'){ ?>
      <span class="glyphicon glyphicon-star"></span> <?= __('Active'); ?> <?php
      } else if ($vendor->status == 'S'){ ?>
      <span class="glyphicon glyphicon-star-empty"></span> <?= __('Suspended'); ?> <?php
      } else if ($vendor->status == 'B'){ ?>
      <span class="glyphicon glyphicon-remove"></span> <?= __('Blocked'); ?> <?php
      } else if ($vendor->status == 'P'){ ?>
      <span class="glyphicon glyphicon-star-empty"></span> <?= __('Pending'); ?> <?php
      } else { ?>
      <span class="glyphicon glyphicon-star-empty"></span> <?= __('Inactive'); ?> <?php
      } ?>
	</div>

	<div class="col-lg-4 col-md-5 col-sm-6 col-xs-4">

		<div class="btn-group pull-right">
			
			<?= $this->Form->postLink(__('Delete'), ['action' => 'deleteVendor', $vendor->id], ['confirm' => __('Are you sure you want to delete?', $vendor->id),'class' => 'btn btn-danger pull-right']);

			if($vendor->status == 'Y') {
			
				echo $this->Form->postLink(__('Suspend'), ['action' => 'changeVendorStatus', $vendor->id,'S'], ['confirm' => __('Are you sure you want to suspend vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				echo $this->Form->postLink(__('Block'), ['action' => 'changeVendorStatus', $vendor->id,'B'], ['confirm' => __('Are you sure you want to block vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
			
			} elseif ($vendor->status == 'P') {
			
				// echo $this->Form->postLink(__('Suspend'), ['action' => 'changeVendorStatus', $vendor->id,'S'], ['confirm' => __('Are you sure you want to suspend vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				echo $this->Form->postLink(__('Activate'), ['action' => 'changeVendorStatus', $vendor->id,'Y'], ['confirm' => __('Are you sure you want to activate vendor?', $vendor->id),'class' => 'btn btn-success pull-right']);
				// echo $this->Form->postLink(__('Block'), ['action' => 'changeVendorStatus', $vendor->id,'B'], ['confirm' => __('Are you sure you want to block vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				
			} elseif ($vendor->status == 'S') {
			
				echo $this->Form->postLink(__('Activate'), ['action' => 'changeVendorStatus', $vendor->id,'Y'], ['confirm' => __('Are you sure you want to activate vendor?', $vendor->id),'class' => 'btn btn-success pull-right']);
				echo $this->Form->postLink(__('Block'), ['action' => 'changeVendorStatus', $vendor->id,'B'], ['confirm' => __('Are you sure you want to block vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
			
			} elseif ($vendor->status == 'B') {
			
				echo $this->Form->postLink(__('Suspend'), ['action' => 'changeVendorStatus', $vendor->id,'S'], ['confirm' => __('Are you sure you want to suspend vendor?', $vendor->id),'class' => 'btn bt-danger pull-right']);
				echo $this->Form->postLink(__('Activate'), ['action' => 'changeVendorStatus', $vendor->id,'Y'], ['confirm' => __('Are you sure you want to activate vendor?', $vendor->id),'class' => 'btn btn-success pull-right']);
			
			} else {
			
				echo $this->Form->postLink(__('Suspend'), ['action' => 'changeVendorStatus', $vendor->id,'S'], ['confirm' => __('Are you sure you want to suspend vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				echo $this->Form->postLink(__('Activate'), ['action' => 'changeVendorStatus', $vendor->id,'Y'], ['confirm' => __('Are you sure you want to activate vendor?', $vendor->id),'class' => 'btn btn-success pull-right']);
				echo $this->Form->postLink(__('Block'), ['action' => 'changeVendorStatus', $vendor->id,'B'], ['confirm' => __('Are you sure you want to block vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				
			} ?>
			
			<?= $this->Html->link(__('Edit'), ['controller'=>'Admins','action' => 'editVendor', $vendor->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('View'), ['controller'=>'Admins','action' => 'viewVendor', $vendor->id],['class' => 'btn pull-right']); ?>
			
		</div>
	
	</div>
	
</div> <!--row-->
		
		
		
<div class="row inner visible-xs">

	<div class="col-xs-12 text-center">
		
		<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
			<h3><?= h($vendor->company_name); ?></h3>
		</a>
		
	</div> <!-- /.col -->

			
	<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

		<div class="row inner">
		
		  <div class="col-xs-6">
		  	<?= __('Logo')?>
		  </div>
		  
		  <div class="col-xs-6">
   
		    <?php if(trim($vendor->logo_url) != ''){ ?>
		    
					<div class="image-preview">
						<?= $this->Html->image('logos/'.$vendor->logo_url)?>
			    	<div><?= $this->Html->image('logos/'.$vendor->logo_url)?></div>
			    </div>
		
		    <?php } ?>
    
		  </div>
	  
		</div>
		
		<div class="row inner">
		
			<div class="col-xs-6">
				<?= __('City')?>
			</div>
			
			<div class="col-xs-6">
				<?= h($vendor->city); ?>
			</div>
		
		</div>

		<div class="row inner">
		
			<div class="col-xs-6">
				<?= __('Country')?>
			</div>
			
			<div class="col-xs-6">
				<?= h($vendor->country); ?>
			</div>
		
		</div>
		
		<div class="row inner">
			
			<div class="col-xs-12">
			
		<div class="btn-group pull-right">
			
			<?= $this->Form->postLink(__('Delete'), ['action' => 'deleteVendor', $vendor->id], ['confirm' => __('Are you sure you want to delete?', $vendor->id),'class' => 'btn btn-danger pull-right']);

			if($vendor->status == 'Y') {
			
				echo $this->Form->postLink(__('Suspend'), ['action' => 'changeVendorStatus', $vendor->id,'S'], ['confirm' => __('Are you sure you want to suspend vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				echo $this->Form->postLink(__('Block'), ['action' => 'changeVendorStatus', $vendor->id,'B'], ['confirm' => __('Are you sure you want to block vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
			
			} elseif ($vendor->status == 'P') {
			
				// echo $this->Form->postLink(__('Suspend'), ['action' => 'changeVendorStatus', $vendor->id,'S'], ['confirm' => __('Are you sure you want to suspend vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				echo $this->Form->postLink(__('Activate'), ['action' => 'changeVendorStatus', $vendor->id,'Y'], ['confirm' => __('Are you sure you want to activate vendor?', $vendor->id),'class' => 'btn btn-success pull-right']);
				// echo $this->Form->postLink(__('Block'), ['action' => 'changeVendorStatus', $vendor->id,'B'], ['confirm' => __('Are you sure you want to block vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				
			} elseif ($vendor->status == 'S') {
			
				echo $this->Form->postLink(__('Activate'), ['action' => 'changeVendorStatus', $vendor->id,'Y'], ['confirm' => __('Are you sure you want to activate vendor?', $vendor->id),'class' => 'btn btn-success pull-right']);
				echo $this->Form->postLink(__('Block'), ['action' => 'changeVendorStatus', $vendor->id,'B'], ['confirm' => __('Are you sure you want to block vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
			
			} elseif ($vendor->status == 'B') {
			
				echo $this->Form->postLink(__('Suspend'), ['action' => 'changeVendorStatus', $vendor->id,'S'], ['confirm' => __('Are you sure you want to suspend vendor?', $vendor->id),'class' => 'btn bt-danger pull-right']);
				echo $this->Form->postLink(__('Activate'), ['action' => 'changeVendorStatus', $vendor->id,'Y'], ['confirm' => __('Are you sure you want to activate vendor?', $vendor->id),'class' => 'btn btn-success pull-right']);
			
			} else {
			
				echo $this->Form->postLink(__('Suspend'), ['action' => 'changeVendorStatus', $vendor->id,'S'], ['confirm' => __('Are you sure you want to suspend vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				echo $this->Form->postLink(__('Activate'), ['action' => 'changeVendorStatus', $vendor->id,'Y'], ['confirm' => __('Are you sure you want to activate vendor?', $vendor->id),'class' => 'btn btn-success pull-right']);
				echo $this->Form->postLink(__('Block'), ['action' => 'changeVendorStatus', $vendor->id,'B'], ['confirm' => __('Are you sure you want to block vendor?', $vendor->id),'class' => 'btn btn-danger pull-right']);
				
			} ?>
			
			<?= $this->Html->link(__('Edit'), ['controller'=>'Admins','action' => 'editVendor', $vendor->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('View'), ['controller'=>'Admins','action' => 'viewVendor', $vendor->id],['class' => 'btn pull-right']); ?>
			
		</div>
				
			</div>
			
		</div>
				
	</div> <!--collapseOne-->
			
</div> <!--row-->


<?php endforeach; ?>


<!-- End loop -->

			
<?php echo $this->element('paginator'); ?>
