<div class="countries index">
			
			<div class="row table-title">
			
				<h2 class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
          <?= __('Countries List')?>
        </h2>
				
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				
					<div class="pull-right btn btn-lg">
            <?= $this->Html->link(__('Add new'), ['controller' => 'Countries', 'action' => 'add']); ?>
					</div>
					
				</div>
				
			</div> <!--row-table-title-->
			
    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
		<div class="row table-th hidden-xs">		
		
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-5"><?= $this->Paginator->sort('title'); ?></div>
						
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"> <?= $this->Paginator->sort('iso_alpha_code_2'); ?></div>
			
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><?= $this->Paginator->sort('iso_alpha_code_3'); ?></div>
			
      <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><?= $this->Paginator->sort('iso_numeric'); ?></div>
                        
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5"></div>
		
		</div> <!--row-table-th-->
		
		<?php 
      $j =0;
      foreach ($countries as $country): 
      $j++;?>
		<!-- Start loop -->
		
		<div class="row inner hidden-xs">
		
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><?= h($country->title); ?></div>
			
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><?= h($country->iso_alpha_code_2); ?></div>
			
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><?= h($country->iso_alpha_code_3); ?></div>
			
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1"><?= h($country->iso_numeric); ?></div>

			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
  			
				<div class="btn-group pull-right">
  				
  				<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $country->iso_alpha_code_2], ['confirm' => __('Are you sure you want to delete?', $country->iso_alpha_code_2),'class' => 'btn btn-danger pull-right']); ?>
  				<?= $this->Html->link(__('Edit'), ['controller'=>'Countries','action' => 'edit', $country->iso_alpha_code_2],['class' => 'btn pull-right']); ?>
          <?= $this->Html->link(__('View'), ['controller'=>'Countries','action' => 'view', $country->iso_alpha_code_2],['class' => 'btn pull-right']); ?>
                                    
				</div><!--nested row-->
				
			</div>
			
		</div> <!--row-->
		
		
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					
					<h3><?= h($country->title); ?></h3>
					
				</a>
				
			</div> <!--col-->

				
			<div id="basic<?= $j ?>" class="panel-collapse collapse">
			
			
			
				<div class="col-xs-12"><strong><?= __('Iso Alpha Code 2:')?></strong> <?= h($country->iso_alpha_code_2); ?></div>
				
				<div class="col-xs-12"><strong><?= __('Iso Alpha Code 3:')?></strong><?= h($country->iso_alpha_code_3); ?></div>
				
				<div class="col-xs-12"><strong><?= __('Iso Numeric:')?></strong><?= h($country->iso_numeric); ?></div>
				
				
				<div class="col-xs-12">
  				
  				<div class="btn-group pull-right">
    				
    				<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $country->iso_alpha_code_2], ['confirm' => __('Are you sure you want to delete?', $country->iso_alpha_code_2),'class' => 'btn btn-danger pull-right']); ?>
    				<?= $this->Html->link(__('Edit'), ['controller'=>'Countries','action' => 'edit', $country->iso_alpha_code_2],['class' => 'btn pull-right']); ?>
            <?= $this->Html->link(__('View'), ['controller'=>'Countries','action' => 'view', $country->iso_alpha_code_2],['class' => 'btn pull-right']); ?>
                                      
  				</div><!--nested row-->
					
				</div> <!--col-xs-12-->
				
			
			
			</div> <!--collapseOne-->
			
		</div> <!--row-->
<!-- End loop -->
			
		<?php endforeach; ?>
		
    <?php echo $this->element('paginator'); ?>
		
	</div><!--row table-th-->
	
</div> <!--subscriptionPackages index?-->