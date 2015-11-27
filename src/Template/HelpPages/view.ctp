<div class="folders view">

	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('View Page'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Help Pages', ['controller'=>'HelpPages', 'action'=>'index']);
					$this->Html->addCrumb('view', ['controller' => 'HelpPages', 'action' => 'view', $page->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	    <?= $this->Html->link(__('Go Back'), 'javascript:history.back()',['class'=>'btn btn-lg pull-right']); ?>
		</div>
		
	</div> <!--row-table-title-->

	<div class="row inner header-row ">
		
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			
			<strong><?= h($page->title) ?></strong>
			
		</div>
		
	</div>

	<div class="row inner">   
	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    	<?= $page->content ?>
	    </div>
	</div>
	
</div>
