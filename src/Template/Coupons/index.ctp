<div class="Coupons index">
			
	<div class="row index table-title admin-table-title">
	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		
			<h2><?= __('Coupons')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Coupons', '/coupons');
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
			
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		
			<div class="pull-right btn btn-lg">
			
        <?= $this->Html->link(__('Add new'), ['controller' => 'Coupons', 'action' => 'add']); ?>
        
      </div>
      
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<!-- Are there any coupons? -->
	<?php
		if(count($coupons)>0)
		{
	?>
	
	<div class="row table-th hidden-xs">	
		
		<div class="clearfix"></div>
	
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<?= $this->Paginator->sort('title','Title'); ?>
		</div>
    <div class="col-lg-2 hidden-md hidden-sm col-xs-2">
	    <?= $this->Paginator->sort('coupon_code'); ?>
	   </div>
		<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
			<?= $this->Paginator->sort('discount','Discount'); ?>
		</div>
		<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
			<?= $this->Paginator->sort('vendor_id','Vendor'); ?>
		</div>
		<div class="col-lg-1 col-md-1 hidden-sm col-xs-1">
			<?= $this->Paginator->sort('expiry_date','Expiry'); ?>
		</div>
		<div class="col-lg-1 col-md-2 col-sm-2 col-xs-1">
			<?= $this->Paginator->sort('status','Status'); ?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-3 text-right">
			
		</div>
		
	</div> <!--row-table-th-->
		
		
	<!-- Start loop -->
	
	
	<?php 
		$j =0;
		foreach ($coupons as $coupon):
		$j++;
	?>
	
		<div class="row inner hidden-xs">
		
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<?= h($coupon->title); ?>
			</div>
			<div class="col-lg-2 hidden-md hidden-sm col-xs-2">
				<?= h($coupon->coupon_code); ?>
			</div>
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<?php if ($coupon->type == 'Perc'){
						echo $this->Number->toPercentage($coupon->discount);
					} else if ($coupon->type == 'Cash'){
						echo $this->Number->currency($coupon->discount,'USD',['places'=>2]);
					}
				?>
			</div>
			
			<div class="col-lg-2 col-md-3 col-sm-3 col-xs-2">
	      <?php 
		      $c = 0 ; foreach($coupon['vendors'] as $vndrc){ $c++; } // count up the number of vendors
		      
		      if ($c == 1) {
			      
			      echo h($vndrc->company_name);  // if there just one vendor, show it
			      
		      } else if ($c > 1) { // else if there's more than one vendor, display these in a 'popover'
			      
	      ?>
	      
	      
	      
	      
	      
					<span role="button"  id="popover" data-toggle="popover" data-container=".row" data-trigger="hover" title="<?= __('Vendors')?>" data-placement="bottom" data-content="<?php $i = 0 ; foreach($coupon['vendors'] as $vndr) { if($i > 0) { echo ', '; } $i++; echo (h($vndr->company_name)); } ?>"><?= __('Multi').' ';?><i class="fa fa-info-circle"></i></span>
			      
				<?php
					}
				?>
	    </div>
			
					
					
					
					
			<div class="col-lg-1 col-md-1 hidden-sm col-xs-1">
				<small><?= h(date('d/m/Y',strtotime($coupon->expiry_date))); ?></small>
			</div>
			
			<div class="col-lg-1 col-md-2 col-sm-2 col-xs-1">
				<?php if($coupon->status == 'U'){ ?>
		      <i class="fa fa-check"></i> <?= __('Used'); ?> <?php
		      } else if ($coupon->status == 'E'){ ?>
		      <i class="fa fa-times"></i> <?= __('Expired'); ?> <?php
		      } else { ?>
		      <i class="fa fa-star"></i> <?= __('New'); ?> <?php
		      }
		    ?>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-3">
			
				<div class="btn-group pull-right">
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $coupon->id], ['confirm' => __('Are you sure you want to delete?', $coupon->id),'class' => 'btn btn-danger pull-right']); ?>
					<?= $this->Html->link(__('Edit'), ['controller'=>'Coupons','action' => 'edit', $coupon->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('View'), ['controller'=>'Coupons','action' => 'view', $coupon->id],['class' => 'btn pull-right']); ?>
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
			<?=	 __('No coupons found') ?>
		</div>
		
	</div> <!--/.row.inner-->
	
	<?php
	
	}
	
?>

<?php echo $this->element('paginator'); ?>
		
		
</div><!-- /.container -->

	</div> <!-- /#content -->
