<div class="masterTemplates view">

	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Master Templates'); ?><small><?= $this->Html->link(__('See all'), ['controller' => 'MasterTemplates','action' => 'index']); ?></small></h2>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	    <?= $this->Html->link(__('Add new'), ['controller' => 'MasterTemplates','action' => 'add'],['class'=>'btn btn-lg pull-right']); ?>
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
	
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<strong><?= h($masterTemplate->title) ?></strong>
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Edit'), ['controller' => 'MasterTemplates','action' => 'edit', $masterTemplate->id],['class' => 'btn pull-right']); ?>
			</div>
		</dd>
		
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Template Type'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($masterTemplate->template_type); ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Content'); ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $masterTemplate->content; ?>
		</dd>
	</div>
</div>