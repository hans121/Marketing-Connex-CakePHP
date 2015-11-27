<script>
	
	function renamemenu(menu_id, menu_name){
		var name = prompt("Enter New Menu Name:", menu_name);
		var dataString = 'id='+menu_id+'&name='+escape(name);
		if(name)
		$.ajax ({
			type: "POST",
			url: "<?php echo $this->Url->build([ "controller" => "HelpMenus","action" => "rename"],true);?>",
			data: dataString,
			cache: false,
			success: function(msg)
			{
				if(msg=='SUCCESS')
				{
					alert('The menu has been renamed.');
					document.location.reload();
				}
				else if(msg=='ERROR')
					alert('An error occurred whilst trying to rename this menu.  Please try again.');
				else
					alert('Invalid access!');
			}
		});
		return false;
	}
  
	function bulkdelete(){
		if($("input[name='bulkid[]']:checked").length>0)
			if(confirm('Are you sure you want to delete all checked pages?'))
			{
				var delids = {};           // Object
				delids['id'] = [];          // Array
				$.each($("input[name='bulkid[]']:checked"), function() {
				  delids['id'].push($(this).val());
				});

				$.ajax({
				  url: "<?php echo $this->Url->build([ "controller" => "HelpPages","action" => "bulkdelete"],true);?>",
				  type: "POST",
				  data: 'ids='+delids['id'],
				  async: false,
				  success: function (msg) {
			  	if(msg=='SUCCESS')
						alert('The selected pages have been deleted.');
					else
						alert('The selected pages have been deleted. With ' + msg + ' failed.');
				   	document.location.reload();
				  }
				});

			}

		return false;
	}
  
</script>

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-4 col-xs-6">
			<h2><?= __('Help Pages'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Help Pages', ['controller'=>'HelpPages', 'action'=>'index']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-md-7 col-sm-8 col-xs-6">
			<div class="btn-group pull-right">
        <?= $this->Html->link(__('Add menu'), ['controller'=>'HelpMenus','action' => 'add', $parentmenu->id],['class' => 'btn btn-lg pull-right']); ?>
         <?= $this->Html->link(__('Add page'), ['action' => 'add',$parentmenu->id],['class'=>'btn btn-lg pull-right']) ?>
			</div>
		</div>
		
	</div>

	<div class="row">
	
		<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 hidden-xs filter-form">
			
			<?=$this->Form->create(null, ['url' => ['action' => 'search']]) ?>

			<div class="input-group input text">
			
				<?=$this->Form->input('keyword',['value' => $keyword,'placeholder' => 'Filter','class' => 'form-control','label' => '','type'=> 'text']);?>
				
				<span class="input-group-btn">
					<?= $this->Form->button('<span class="glyphicon glyphicon-search"></span>',['class'=> 'btn btn-search btn-primary']); ?>   
				</span>
				
			</div>

			<?=$this->Form->end() ?>
			
		</div>

	</div>

</div> <!--row-table-title-->

<div class="row table-th hidden-xs">
		
	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="clearfix"></div>
	<div class="col-lg-1 col-md-1 col-sm-1">
	</div>
	<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
	  <?= $this->Paginator->sort('title','Page Title') ?>
	</div>
	<div class="col-lg-2 hidden-md hidden-sm">
		<?= $this->Paginator->sort('status','Publish Status') ?>
	</div>
	<div class="col-lg-4 col-md-5 col-sm-5 col-xs-12">
		
	</div>

</div> <!-- /.row .table-th -->

<?php 
	if($parentmenu) :
?>

<?php
	if($pages->count()>0) {
?>

<div class="row inner header-row">
	
	<div class="col-md-1 col-sm-1 hidden-xs">
		
	  <?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master-top','name'=>'bulk-selector-master-top'])?>
	  <label for="bulk-selector-master-top" class="css-checkbox-label"></label>
	
	</div>
	
	<div class="col-md-2 col-sm-3 col-xs-12">
		<?= __('Bulk actions')?>
	</div>
	
	<div class="col-md-9 col-sm-8 col-xs-12 btn-group">
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-danger pull-right','onclick'=>'return bulkdelete()']); ?>
	</div>
	
</div>

<?php
	}
?>

<?php 
	endif;
?>

<?php
	if($parentmenu->parent_id!=0) : // not root menu
?>

<div class="row inner withtop">
		
	<div class="col-lg-1 col-md-1 col-sm-1 hidden-xs">
    <?= $this->Html->link('<i class="fa fa-level-up fa-lg"></i>', ['action'=>'navigate',$parentmenu->parent_id],['escape' => false, 'title' => 'Go up a level']); ?>
  </div>
	
	<div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
    <?= $this->Html->link(__('/..'), ['action'=>'navigate',$parentmenu->parent_id],['title' => 'Go up a level']); ?>
	</div>
	
</div> <!--/.row.inner-->

<?php
	endif;
?>

<div class="row inner">
	
	<div class="col-md-1 col-sm-1 hidden-xs">
	</div>
	<?php
	if($parentmenu->parent_id!=0) : // not root menu
	?>
	<div class="col-md-7 col-sm-6 col-xs-12">
		<i class="fa fa-folder-open-o fa-lg"></i> <?= __($parentmenu->name)?>
	</div>
	<div class="col-md-4 col-sm-5 hidden-xs">
				<?= $this->Html->link(__('Delete'), ['controller'=>'HelpMenus','action'=>'delete',$parentmenu->parent_id,$parentmenu->id],['confirm' => __('Are you sure you want to delete this menu?'),'class' => 'btn btn-danger pull-right']); ?>
		    	<?= $this->Html->link(__('Edit'), ['controller' => 'HelpMenus', 'action' => 'edit',$parentmenu->parent_id, $parentmenu->id],['class' => 'btn pull-right']); ?>
		    	<?= $this->Html->link(__('Rename'), ['controller' => 'HelpMenus','action' => 'rename', $parentmenu->id],['class' => 'btn pull-right','onclick'=>'return renamemenu('.$parentmenu->id.',"'.$parentmenu->name.'")']); ?>
	</div>
	<?php
	else:
	?>
	<div class="col-md-5 col-sm-6 col-xs-12">
		<i class="fa fa-folder-open-o fa-lg"></i> <?= __('Main Menu')?>
	</div>
	<div class="col-md-4 hidden-sm hidden-xs">
		<?= __($parentmenu->status=='Y'?'Published':'Private') ?>
	</div>
	<?php 
	endif;
	?>
</div>

<?php
	if($menus->count())
	foreach($menus as $menu) {
?>

		<div class="row inner">

			<div class="col-lg-1 col-md-1 col-sm-1 hidden-xs">
		 	</div>
			
			<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
				<i class="fa fa-folder-o fa-lg"><?= $this->Html->link('', ['controller' => 'HelpPages', 'action' => 'navigate', $menu->id]) ?></i> <?= $this->Html->link($menu->name, ['controller' => 'HelpPages', 'action' => 'navigate', $menu->id]) ?>
			</div>

			<div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
			</div>
			
			<div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
			<?= __($menu->status=='Y'?'Published':'Private') ?>
			</div>

			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
				<?= $this->Html->link(__('Delete'), ['controller'=>'HelpMenus','action'=>'delete',$menu->parent_id,$menu->id],['confirm' => __('Are you sure you want to delete this menu?'),'class' => 'btn btn-danger pull-right']); ?>
		    	<?= $this->Html->link(__('Edit'), ['controller' => 'HelpMenus', 'action' => 'edit',$menu->parent_id, $menu->id],['class' => 'btn pull-right']); ?>
		    	<?= $this->Html->link(__('Rename'), ['controller' => 'HelpMenus','action' => 'rename', $menu->id],['class' => 'btn pull-right','onclick'=>'return renamemenu('.$menu->id.',"'.$menu->name.'")']); ?>
		  	</div>

		</div>
<?php
	}
?>  

<!-- Are there any resources in this folder? -->
	
<?php

if($pages->count()>0) {
			
?>

<!-- Start loop -->

<?php
	$j =0;
	$kb =0;
	foreach ($pages as $page):
	$j++;
?>
<div class="row inner">

	<div class="col-lg-1 col-md-1 col-sm-1">
   <?= $this->Form->checkbox('bulkid[]',['class'=>'css-checkbox bulk-selector','value'=>$page->id,'label'=>false,'id'=>'bulkid-'.$page->id])?>
   		<label for="bulkid-<?=$page->id?>" name="" class="css-checkbox-label"> </label>
  </div>
	
	<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
		<i class="fa fa-file-o fa-lg"></i> <?= $this->Html->link(h($page->title), ['controller'=>'HelpPages','action' => 'view', $page->id]); ?>
	</div>
	
	<div class="col-md-1 hidden-sm hidden-xs">
		<?= __($page->status=='Y'?'Published':'Private') ?>
	</div>

	
	<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">

		<div class="btn-group pull-right">
			
			<?= $this->Html->link(__('Delete'), ['action'=>'delete',$parentmenu->id,$page->id], ['confirm' => __('Are you sure you want to delete?', $page->id),'class' => 'btn btn-danger pull-right']); ?>
			<?= $this->Html->link(__('Edit'), ['controller'=>'HelpPages','action' => 'edit',$parentmenu->id, $page->id],['class' => 'btn pull-right']); ?>
			<?= $this->Html->link(__('View'), ['controller'=>'HelpPages','action' => 'view', $page->id],['class' => 'btn pull-right']); ?>

		</div>
	
	</div>
	
</div> <!--row-->

<?php endforeach; ?>

<div class="row inner header-row">
	
	<div class="col-md-1 col-sm-1 hidden-xs">
		
	  <?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master','name'=>'bulk-selector-master'])?>
	  <label for="bulk-selector-master" class="css-checkbox-label"></label>
	
	</div>
	
	<div class="col-md-2 col-sm-3 col-xs-12">
		<?= __('Bulk actions')?>
	</div>
	
	<div class="col-md-9 col-sm-8 col-xs-12 btn-group">
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-danger pull-right','onclick'=>'return bulkdelete()']); ?>
	</div>
	
</div>

<?php
	
} else {
	
?>

	<div class="row inner">
			
		<div class="col-sm-12 text-center">
			<?=	 __('No pages found in this menu') ?>
		</div>
		
	</div> <!--/.row.inner-->

<?php
	
}
	
?>

<?php echo $this->element('paginator'); ?>


<script type="text/javascript">

	$('#bulk-selector-master').click(function() {
	  if ($(this).is(':checked') == true) {
	      $('.bulk-selector').prop('checked', true);
	      $('#bulk-selector-master-top').prop('checked', true);
	  } else {
	      $('.bulk-selector').prop('checked', false);
	      $('#bulk-selector-master-top').prop('checked', false);
	  }
	});
	$('#bulk-selector-master-top').click(function() {
	  if ($(this).is(':checked') == true) {
	      $('.bulk-selector').prop('checked', true);
	      $('#bulk-selector-master').prop('checked', true);
	  } else {
	      $('.bulk-selector').prop('checked', false);
	      $('#bulk-selector-master').prop('checked', false);
	  }
	});
	
</script>