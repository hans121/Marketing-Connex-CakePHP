<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-4 col-xs-6">
			<h2><?= __('Help'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Help', ['controller'=>'Help', 'action'=>'index']);
					
					if($parentmenu->parent_id!=0) : // not root menu, add the parent folder to the breadcrumb
						$this->Html->addCrumb( h($page->title), ['controller' => 'Help', 'action' => 'view', $parentmenu->id, $page->id]);
					endif;

					$this->Html->addCrumb( h($page->title), ['controller' => 'Help', 'action' => 'view', $page->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => ($user['role']=='vendor'?'Vendors':'Partners'), 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		</div>
		
		<div class="col-md-7 col-sm-8 col-xs-6">
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

<div class="row table-th">
		
	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="clearfix"></div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	  <?= $this->Paginator->sort('title','Page Title') ?>
	</div>

</div> <!-- /.row .table-th -->

<?php
	if($parentmenu->parent_id!=0) : // not root menu
?>

<div class="row inner withtop">
		
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?= $this->Html->link('<i class="fa fa-level-up fa-lg"></i>', ['action'=>'navigate',$parentmenu->parent_id],['escape' => false, 'title' => 'Go up a level']); ?>
    <?= $this->Html->link(__('/..'), ['action'=>'navigate',$parentmenu->parent_id],['title' => 'Go up a level']); ?>
	</div>
	
</div> <!--/.row.inner-->

<?php
	endif;
?>

<!-- Are there any pages in this folder? -->
	
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
	
	<div class="col-lg-11 col-md-11 col-sm-11 col-xs-11">
		<i class="fa fa-file-o fa-lg"></i> <?= $this->Html->link(h($page->title), ['controller'=>'Help','action' => 'view', $page->id]); ?>
	</div>

	
	<div class="col-lg-1 col-md-1 col-sm-1 hidden-xs">

		<div class="btn-group pull-right">
			
			<?= $this->Html->link(__('View'), ['action'=>'view',$page->id],['class' => 'btn btn-danger pull-right']); ?>
			
		</div>
	
	</div>
	
</div> <!--row-->

<?php endforeach; ?>

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
