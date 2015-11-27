<script>
	 
  function bulkdelete(){
    var test = {};           // Object
    test['id'] = [];          // Array
    $.each($("input[name='bulkid[]']:checked"), function() {
      test['id'].push($(this).val());
      
    // or you can do something to the actual checked checkboxes by working directly with 'this'
    // something like $(this).hide() (only something useful, probably) :P
    });
    $.ajax({
      url: "<?php echo $this->Url->build([ "controller" => "PartnerMailinglistGroups","action" => "bulkdelete"],true);?>",
      type: "POST",
      data: 'ids='+test['id'],
      async: false,
      success: function (msg) {
       //alert(msg);
       window.location.replace("<?php echo $this->Url->build([ "controller" => "PartnerMailinglistGroups","action" => "index"],true);?>");
      }
    });
  }
  
</script>

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-4 col-xs-6">
			<h2><?= __('Central Mailing list'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglistGroups', 'action' => 'index']);
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
	      		<?= ($PartnerMailinglistGroups->count()<3?$this->Html->link(__('Add New List'), ['action' => 'add'],['class'=>'btn btn-lg pull-right']):'') ?>	
			</div>
		</div>
	
	</div>
	
</div> <!--row-table-title-->

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
<?= $this->Form->create('',['id'=>'frmbulkupt']); ?>

<div class="row table-th hidden-xs">
		
	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="clearfix"></div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
	</div>
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?= $this->Paginator->sort('name','List Name'); ?></div>
	<div class="col-lg-2 hidden-md hidden-sm col-xs-2"><?= $this->Paginator->sort('created_on','Date Created') ?></div>
	<div class="col-lg-2 hidden-md hidden-sm  col-xs-2">Contacts</div>
	<div class="col-lg-4 col-md-4 col-sm-3 col-xs-4"></div>

</div> <!-- /.row .table-th -->


<div class="row inner header-row hidden-xs">
	
	<div class="col-md-1 col-sm-1">
	  <?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master-top','name'=>'bulk-selector-master-top'])?>
	  <label for="bulk-selector-master-top" class="css-checkbox-label"></label>
	</div>
	
	<div class="col-md-2 col-sm-3">
		<?= __('Bulk actions')?>
	</div>

	<div class="col-md-9 col-sm-8 btn-group">
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-danger pull-right','onclick'=>'bulkdelete()', 'title' => 'Delete selection']); ?>
    </div>
	
</div>

<!-- Start loop -->

<?php

if($PartnerMailinglistGroups->count()==0):
?>
<div class="row inner hidden-xs">

	<div class="col-lg-12 text-center">
    	<b>No Mailinglist</b>
	</div>
	
</div> <!--row-->
<?php
endif;

$j =0;
foreach ($PartnerMailinglistGroups as $partnerMailinglist):
$j++;
?>
    
<div class="row inner hidden-xs">

	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
    <?= $this->Form->checkbox('bulkid[]',['class'=>'css-checkbox bulk-selector','value'=>$partnerMailinglist->id,'label'=>false,'id'=>'bulkid-'.$partnerMailinglist->id])?>
    <label for="bulkid-<?=$partnerMailinglist->id?>" name="" class="css-checkbox-label"></label>
  </div>
	
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		<?= h($partnerMailinglist->name).($partnerMailinglist->is_default==1?'<small><b><i> - default</i></b></small>':''); ?>
	</div>
	
	<div class="col-lg-2 hidden-md hidden-sm col-xs-1">
		<?= h(date('d/m/Y',strtotime($partnerMailinglist->created_on))); ?>
	</div>
	
	<div class="col-lg-2 hidden-md hidden-sm col-xs-1">
		<?php
			$mailinglist = $PartnerMailinglists->find()->where(['partner_mailinglist_group_id'=>$partnerMailinglist->id]);
			echo $mailinglist->count();
		?>
	</div>
	
	<div class="col-lg-4 col-md-5 col-sm-4 col-xs-4">

		<div class="btn-group pull-right">
			<?php 
			if($partnerMailinglist->is_default==0)
			{
				echo $this->Html->link(__('Make Default'), ['action' => 'makedefault', $partnerMailinglist->id],['class' => 'btn pull-right']);
				echo $this->Html->link(__('Delete'), ['action' => 'delete', $partnerMailinglist->id], ['confirm' => __('Are you sure you want to delete?', $partnerMailinglist->id),'class' => 'btn btn-danger pull-right']);
			}	 
			?>
			<?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerMailinglist->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('View'), ['controller'=>'PartnerMailinglists','action' => 'show', $partnerMailinglist->id],['class' => 'btn pull-right']); ?>		
		</div>
	
	</div>
	
</div> <!--row-->
		
		
<div class="row inner visible-xs">

	<div class="col-xs-12 text-center">
		
		<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
			<h3><?= h($partnerMailinglist->email); ?></h3>
		</a>
		
	</div> <!-- /.col -->

	<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

		<div class="row inner">
		
		  <div class="col-xs-12">
		    <?= h($partnerMailinglist->name); ?>
		  </div>  
      
		</div>
		
		<div class="row inner">
			
			<div class="col-xs-12">
			
				<div class="btn-group pull-right">
					<?php 
					if($partnerMailinglist->is_default==0)
					{
						echo $this->Html->link(__('Make Default'), ['action' => 'makedefault', $partnerMailinglist->id],['class' => 'btn pull-right']);
						echo $this->Html->link(__('Delete'), ['action' => 'delete', $partnerMailinglist->id], ['confirm' => __('Are you sure you want to delete?', $partnerMailinglist->id),'class' => 'btn btn-danger pull-right']);
					}	 
					?>
					<?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerMailinglist->id],['class' => 'btn pull-right']); ?>
					<?= $this->Html->link(__('View'), ['controller'=>'PartnerMailinglists','action' => 'show', $partnerMailinglist->id],['class' => 'btn pull-right']); ?>
		      	</div>
				
			</div>
			
		</div>
				
	</div> <!--collapseOne-->
			
</div> <!--row-->


<?php endforeach; ?>

<div class="row inner header-row hidden-xs">
	
	<div class="col-md-1 col-sm-1">
	  <?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master','name'=>'bulk-selector-master'])?>
	  <label for="bulk-selector-master" class="css-checkbox-label"></label>
	</div>
	
	<div class="col-md-2 col-sm-3">
		<?= __('Bulk actions')?>
	</div>

	<div class="col-md-9 col-sm-8 btn-group">
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-danger pull-right','onclick'=>'bulkdelete()', 'title' => 'Delete selection']); ?>
    </div>
	
</div>

<!-- End loop -->

<?= $this->Form->end(); ?>
			
<?php echo $this->element('paginator'); ?>

<script type="text/javascript">

	$('#bulk-selector-master').click(function() {
	  if ($(this).is(':checked') == true) {
	      $('.bulk-selector').prop('checked', true);
	      $('#bulk-selector-master-top').prop('checked', true);
	  }else{
	      $('.bulk-selector').prop('checked', false);
	      $('#bulk-selector-master-top').prop('checked', false);
	  }
	});
	$('#bulk-selector-master-top').click(function() {
	  if ($(this).is(':checked') == true) {
	      $('.bulk-selector').prop('checked', true);
	      $('#bulk-selector-master').prop('checked', true);
	  }else{
	      $('.bulk-selector').prop('checked', false);
	      $('#bulk-selector-master').prop('checked', false);
	  }
	});
	
</script>