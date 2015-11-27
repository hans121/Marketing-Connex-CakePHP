<div class="masterTemplates index">
			
	<div class="row table-title">
	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		
			<h2><?= __('Master Templates List')?></h2>
			
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		
			<div class="pull-right btn btn-lg">
			
        <?= $this->Html->link(__('Add new'), ['controller' => 'MasterTemplates', 'action' => 'add']); ?>
        
      </div>
      
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="row table-th hidden-xs">	
		
		<div class="clearfix"></div>
	
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?= $this->Paginator->sort('title') ?></div>
      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?= $this->Paginator->sort('template_type') ?></div>
		
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
		
	</div> <!--row-table-th-->
		
	<!-- Start loop -->
	
	<?php 
		$j =0;
		foreach ($masterTemplates as $masterTemplate):
		$j++;
	?>
	
	<div class="row inner hidden-xs">
	
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= $masterTemplate->title ?>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<?= $masterTemplate->template_type ?>
		</div>
		

		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
		
			<div class="btn-group pull-right">
				<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $masterTemplate->id], ['confirm' => __('Are you sure you want to delete?', $masterTemplate->id),'class' => 'btn btn-danger pull-right']); ?>
				<?= $this->Html->link(__('Edit'), ['controller'=>'MasterTemplates','action' => 'edit', $masterTemplate->id],['class' => 'btn pull-right']); ?>
				<?= $this->Html->link(__('View'), ['controller'=>'MasterTemplates','action' => 'view', $masterTemplate->id],['class' => 'btn pull-right']); ?>
			</div>
			
		</div>
		
	</div> <!--row-->
		
		
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					
					<h3><?= $masterTemplate->title ?></h3>
					
				</a>
				
			</div> <!--col-->

				
			<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
			
				<div class="row inner">
				
					<div class="col-xs-6">
						<?= __('Template Type')?>
					</div>
					
					<div class="col-xs-6">
						<?= $masterTemplate->template_type ?>
					</div>
				
				</div>
                               
				
				<div class="row inner">
				
					<div class="col-xs-12">
					
						<div class="btn-group pull-right">
                                                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $masterTemplate->id], ['confirm' => __('Are you sure you want to delete?', $masterTemplate->id),'class' => 'btn btn-danger pull-right']); ?>
                                                    <?= $this->Html->link(__('Edit'), ['controller'=>'MasterTemplates','action' => 'edit', $masterTemplate->id],['class' => 'btn pull-right']); ?>
                                                    <?= $this->Html->link(__('View'), ['controller'=>'MasterTemplates','action' => 'view', $masterTemplate->id],['class' => 'btn pull-right']); ?>
                                                </div>
						
					</div>
					
				</div>
				
			</div>
			
		</div> <!--row-->
	
	
<!-- End loop -->

			
<?php endforeach; ?>


<?php echo $this->element('paginator'); ?>
		
		
</div><!-- /.container -->

	</div> <!-- /#content -->