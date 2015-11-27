<?php 
$this->layout = 'admin--ui';
?>


<!-- Card -->

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="card">

        <div class="card--header">

          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="card--icon">
                <div class="bubble">
                  <i class="icon ion-document"></i></div>
                </div>
                <div class="card--info">
                  <h2 class="card--title"><?= __('Communications'); ?></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
                	<div class="dropdown pull-right">
  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><?= $this->Html->link(__('Add menu'), ['controller'=>'VendorMenus','action' => 'add', $parentmenu->id]); ?></li>
    <li><?= $this->Html->link(__('Add page'), ['action' => 'add',$parentmenu->id]) ?></li>
  </ul>
</div>
                </div>
              </div>
            </div>   
          </div>


          <div class="card-content">
<!--
<div class="row">
<div class="col-md-12">
<h4>Campaign Options</h4>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
</p>
<hr>
</div>
</div>
-->
<!-- content below this line -->




<script>
	
	function renamemenu(menu_id, menu_name){
		var name = prompt("Enter New Menu Name:", menu_name);
		var dataString = 'id='+menu_id+'&name='+escape(name);
		if(name)
		$.ajax ({
			type: "POST",
			url: "<?php echo $this->Url->build([ "controller" => "VendorMenus","action" => "rename"],true);?>",
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
				  url: "<?php echo $this->Url->build([ "controller" => "VendorPages","action" => "bulkdelete"],true);?>",
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


<div class="row">
<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3 hidden-xs filter-form">
			
			<?=$this->Form->create(null, ['url' => ['action' => 'search']]) ?>


			          <div class="input-group">
                <?=$this->Form->input('keyword',['value' => $keyword,'placeholder' => 'Filter','class' => 'form-control','label'=>false,'type'=> 'text']);?> <span class="input-group-btn"><?= $this->Form->button('<span class="fa fa-search"></span>',['class'=> 'btn btn-search btn-primary']); ?> </span></div>



			<?=$this->Form->end() ?>
			

</div>

</div>
<hr>
<!-- content below this line -->




<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<div class="row table-th hidden-xs">
	
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
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-default pull-right','onclick'=>'return bulkdelete()']); ?>
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

<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
  	<li><?= $this->Html->link(__('Edit'), ['controller' => 'VendorMenus', 'action' => 'edit',$parentmenu->parent_id, $parentmenu->id]); ?></li>
  	<li><?= $this->Html->link(__('Rename'), ['controller' => 'VendorMenus','action' => 'rename', $parentmenu->id],['onclick'=>'return renamemenu('.$parentmenu->id.',"'.$parentmenu->name.'")']); ?></li>
    <li><?= $this->Html->link(__('Delete'), ['controller'=>'VendorMenus','action'=>'delete',$parentmenu->parent_id,$parentmenu->id],['confirm' => __('Are you sure you want to delete this menu?')]); ?></li>
  </ul>
</div>

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
				<i class="fa fa-folder-o fa-lg"><?= $this->Html->link('', ['controller' => 'VendorPages', 'action' => 'navigate', $menu->id]) ?></i> <?= $this->Html->link($menu->name, ['controller' => 'VendorPages', 'action' => 'navigate', $menu->id]) ?>
			</div>

			<div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
			</div>
			
			<div class="col-lg-1 col-md-1 hidden-sm hidden-xs">
			<?= __($menu->status=='Y'?'Published':'Private') ?>
			</div>

			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
  	<li><?= $this->Html->link(__('Edit'), ['controller' => 'VendorMenus', 'action' => 'edit',$menu->parent_id, $menu->id]); ?></li>
    <li><?= $this->Html->link(__('Delete'), ['controller'=>'VendorMenus','action'=>'delete',$menu->parent_id,$menu->id],['confirm' => __('Are you sure you want to delete this menu?')]); ?></li>
    <li><?= $this->Html->link(__('Rename'), ['controller' => 'VendorMenus','action' => 'rename', $menu->id],['class' => 'btn pull-right','onclick'=>'return renamemenu('.$menu->id.',"'.$menu->name.'")']); ?></li>
  </ul>
</div>



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
		<i class="fa fa-file-o fa-lg"></i> <?= $this->Html->link(h($page->title), ['controller'=>'VendorPages','action' => 'view', $page->id]); ?>
	</div>
	
	<div class="col-md-1 hidden-sm hidden-xs">
		<?= __($page->status=='Y'?'Published':'Private') ?>
	</div>

	
	<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">

		<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
   Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><?= $this->Html->link(__('View'), ['controller'=>'VendorPages','action' => 'view', $page->id]); ?></li>
    <li><?= $this->Html->link(__('Edit'), ['controller'=>'VendorPages','action' => 'edit',$parentmenu->id, $page->id]); ?></li>
    <li><?= $this->Html->link(__('Delete'), ['action'=>'delete',$parentmenu->id,$page->id], ['confirm' => __('Are you sure you want to delete?', $page->id)]); ?></li>
  </ul>
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
    <?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-default pull-right','onclick'=>'return bulkdelete()']); ?>
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


  <!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
<?php
					$this->Html->addCrumb('Communications', ['controller'=>'VendorPages', 'action'=>'index']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Vendors', 'action' => 'index'],
					    'escape' => false
					]);
				?>
          </li>
        </ol>
      </div>
      <div class="col-md-6 text-right">
        

      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->

