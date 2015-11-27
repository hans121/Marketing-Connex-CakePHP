
<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-4 col-xs-6">
			<h2><?= __($partnerMailinglistSegment->name); ?></h2>
			<div class="breadcrumbs">
				<?php					
					$this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglistGroups', 'action' => 'index']);					
					$this->Html->addCrumb('list', ['controller' => 'PartnerMailinglists', 'action' => 'show',$partnerMailinglistSegment->partner_mailinglist_group_id]);
					$this->Html->addCrumb('segments', ['controller' => 'PartnerMailinglistSegments', 'action' => 'show',$partnerMailinglistSegment->partner_mailinglist_group_id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-md-7 col-sm-8 col-xs-6">
			<div class="btn-group pull-right">
	      		<?= $this->Html->link(__('Edit Segment'), ['action' => 'edit',$partnerMailinglistSegment->id],['class'=>'btn btn-lg pull-right']) ?>	
			</div>
		</div>
	
	</div>
	
</div> <!--row-table-title-->

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
<div class="row table-th hidden-xs">
		
	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="clearfix"></div>
  	<div class="col-lg-2"><?= $this->Paginator->sort('first_name','First Name'); ?></div>
	<div class="col-lg-2"><?= $this->Paginator->sort('last_name','Last Name') ?></div>
	<div class="col-lg-3"><?= $this->Paginator->sort('email','Email') ?></div>
	<div class="col-lg-2"><?= $this->Paginator->sort('city','City'); ?></div>
	<div class="col-lg-2"><?= $this->Paginator->sort('country','Country') ?></div>
	<div class="col-lg-1"><?= $this->Paginator->sort('created_on','Date Added') ?></div>

</div> <!-- /.row .table-th -->

<!-- Start loop -->

<?php

if($partnerMailinglist->count()==0):
?>
<div class="row inner hidden-xs">

	<div class="col-lg-12 text-center">
    	<b>No Mailinglist Segments</b>
	</div>
	
</div> <!--row-->
<?php
endif;

$j =0;
foreach ($partnerMailinglist as $list):
$j++;
?>
    
<div class="row inner hidden-xs">
	
	<div class="col-lg-2">
		<?= h($list->first_name); ?>
	</div>
	
	<div class="col-lg-2">
		<?= h($list->last_name); ?>
	</div>
	
	<div class="col-lg-3">
		<?= h($list->email); ?>
	</div>
	
	<div class="col-lg-2">
		<?= h($list->city); ?>
	</div>
	
	<div class="col-lg-2">
		<?= h($list->country); ?>
	</div>
	
	<div class="col-lg-1">
		<?= h(date('d/m/Y',strtotime($list->created_on))); ?>	
	</div>
	
</div> <!--row-->
		
		
<div class="row inner visible-xs">

	<div class="col-xs-12 text-center">
		
		<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
			<h3><?= h($list->first_name.' '.$list->last_name); ?></h3>
		</a>
		
	</div> <!-- /.col -->

	<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
		
		<div class="row inner">
		  <div class="col-xs-6">
		  	<?= __("Email")?>
		  </div>
		  <div class="col-xs-6">
				<?= h($list->email) ?>
		  </div>      
		</div>
		
		<div class="row inner">
		  <div class="col-xs-6">
		  	<?= __("Date Created")?>
		  </div>
		  <div class="col-xs-6">
			<?= h(date('d/m/Y',strtotime($list->created_on))); ?>	
		  </div>      
		</div>
				
	</div> <!--collapseOne-->
			
</div> <!--row-->


<?php endforeach; ?>

<!-- End loop -->
			
<?php echo $this->element('paginator'); ?>