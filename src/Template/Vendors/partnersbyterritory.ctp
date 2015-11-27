<div class="partners vendors">

	<div class="row table-title">
	
		<h2 class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?= __('Partners List'.($state!=''? ' for '  .ucwords($state) : ''))?> <?php if($country!='' || $state!=''):?><small><?= $this->Html->link(__('See all'), ['action' => 'partnersbyterritory']); ?></small><?php endif; ?>                         
		</h2>
		
	</div>
		
</div> <!--row-table-title-->
	
<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
<div class="row table-th hidden-xs">
	
	<!--<div class="col-xs-1">
		<?= __('Logo')?>
	</div>-->
	<div class="col-xs-3">
		<?= $this->Paginator->sort('company_name'); ?>
	</div>		
	<div class="col-xs-4">
		<?= $this->Paginator->sort('country'); ?>
	</div>
	
	<div class="col-xs-5">

	</div>

</div> <!--row-table-th-->
		
		
<!-- Start loop -->

<?php 
	$j =0;
	foreach ($partners as $partner): 
	$j++;
?>
		
<div class="row inner hidden-xs">

	<!--<div class="col-xs-1">
		    <?php if(trim($partner->logo_url) != ''){ ?>	 
		       
					<a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image('logos/'.$partner->logo_url)?>'>
						<?= $this->Html->image('logos/'.$partner->logo_url)?>
					</a>
			    
		    <?php } ?>
	</div>-->
	<div class="col-xs-3">
		<strong>
			<a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image('logos/'.$partner->logo_url)?>'>
				<?= h($partner->company_name); ?>
			</a>
		</strong>
	</div>		
	<div class="col-xs-4">
		<?= h($partner->country); ?>
	</div>
	
	<div class="col-xs-5">
		<div class="btn-group pull-right">
			<?= $this->Form->postLink(__('Delete'), ['action' => 'deletePartner', $partner->id], ['confirm' => __('Are you sure you want to delete ?', $partner->id),'class' => 'btn btn-danger pull-right']); ?>
			<?= $this->Html->link(__('Edit'), ['action' => 'editPartner', $partner->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('View'), ['action' => 'viewPartner', $partner->id],['class' => 'btn pull-right']); ?>
		</div>
	</div>
	
</div> <!--row-->
		
		
<!-- For mobile view only -->
<div class="row inner visible-xs">

	<div class="col-xs-12 text-center">
		
		<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
			
			<h3><?= h($partner->company_name); ?></h3>
			
		</a>
		
	</div> <!--col-->

	<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
	
		<div class="row inner">
		  <div class="col-xs-6">
		  	<?= __('Logo')?>
		  </div>
		  <div class="col-xs-6">
				<?php if(trim($partner->logo_url) != ''){?>
				  <?= $this->Html->image('logos/'.h($partner->logo_url),['alt' =>$partner->company_name ,'class' => 'img-responsive'])?>
				<?php }?>
		  </div>
		</div>
		
		<div class="row inner">
		  <div class="col-xs-6">
		  	<?= __('City')?>
		  </div>
		  <div class="col-xs-6">
		  	<?= h($partner->city); ?>
		  </div>
		</div>
		
		<div class="row inner">
		  <div class="col-xs-6">
		  	<?= __('Country')?>
		  </div>
		  <div class="col-xs-6">
		  	<?= h($partner->country); ?>
		  </div>
		</div>
		
		<div class="row inner">
		  <div class="col-xs-6">
		  	<?= __('Employees')?>
		  </div>
		  <div class="col-xs-6">
		  	<?= h($partner->no_employees); ?>
		  </div>
		</div>
		
		<div class="row inner">
		  <div class="col-xs-6">
		  	<?= __('Office')?>
		  </div>
		  <div class="col-xs-6">
		  	<?= h($partner->no_offices); ?>
		  </div>
		</div>
		
		<div class="row inner">
		  <div class="col-xs-6">
		  	<?= __('Total Revenue')?>
		  </div>
		  <div class="col-xs-6">
		  	<?= h($partner->total_a_revenue); ?>
		  </div>
		</div>
			
		<div class="row inner">		
			<div class="col-xs-12">
				<div class="btn-group pull-right">
					<?= $this->Form->postLink(__('Delete'), ['action' => 'deletePartner', $partner->id], ['confirm' => __('Are you sure you want to delete ?', $partner->id),'class' => 'btn  btn-danger pull-right']); ?>
					<?= $this->Html->link(__('Edit'), ['action' => 'editPartner', $partner->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('View'), ['action' => 'viewPartner', $partner->id],['class' => 'btn pull-right']); ?>
				</div>
			</div>
		</div>
			
	</div> <!-- /.collapse -->
	
</div> <!-- /.row -->


<!-- End loop -->
			
<?php endforeach; ?>
		
		
<?php echo $this->element('paginator'); ?>









