<div class="Settings index">

			<div class="row table-title">
			
			<div class="col-md-5 col-sm-4 col-xs-6">
				
				<h2>
        	<?= __('Website Configuration Settings')?>
        </h2>
        
				<div class="breadcrumbs">
					<?php
						$this->Html->addCrumb('Settings', '/settings');
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
		      <?= $this->Html->link(__('Add new'), ['controller' => 'Settings', 'action' => 'add'],['class' => 'btn btn-lg pull-right']); ?>
				</div>
			</div>
				
		</div> <!--row-table-title-->
		
    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
		<div class="row table-th hidden-xs">		
		
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?= $this->Paginator->sort('settingname','Setting'); ?></div>
						
			<div class="col-lg-3 col-md-6 col-sm-6 col-xs-6"> <?= $this->Paginator->sort('settingvalue','Value'); ?></div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>
		
		</div> <!--row-table-th-->
		
		<?php 
	    $j =0;
	    foreach ($settings as $setting):
	    $j++;
    ?>
    
		<!-- Start loop -->
		<div class="row inner hidden-xs">
		
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?= h($setting->settingname); ?></div>
			
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"><?= h($setting->settingvalue); ?></div>
			
			
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<div class="btn-group pull-right">
					<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $setting->settingname], ['confirm' => __('Are you sure you want to delete?', $setting->settingname),'class' => 'btn pull-right btn-danger']); ?>
					<?= $this->Html->link(__('Edit'), ['controller'=>'Settings','action' => 'edit', $setting->settingname],['class' => 'btn pull-right']); ?>
		      <?//= $this->Html->link(__('View'), ['controller'=>'Settings','action' => 'view', $setting->settingname],['class' => 'btn pull-right']); ?>
				</div><!--nested row-->
				
			</div>
			
		</div> <!--row-->
		
		
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					
					<h3><?= h($setting->settingname); ?></h3>
					
				</a>
				
			</div> <!--col-->

				
			<div id="basic<?= $j ?>" class="panel-collapse collapse">
			
				<div class="col-xs-12"><strong><?= __('Configuration Value:')?></strong> <?= h($setting->settingvalue); ?></div>
				
				
				<div class="col-xs-12">
					<div class="row">
						<?= $this->Html->link(__('View'), ['controller'=>'Settings','action' => 'view', $setting->settingname],['class' => 'button col-xs-3 btn btn-default']); ?>
		        <?= $this->Html->link(__('Edit'), ['controller'=>'Settings','action' => 'edit', $setting->settingname],['class' => 'button col-xs-3 btn btn-default']); ?>
		        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $setting->settingname], ['confirm' => __('Are you sure you want to delete?', $setting->settingname),'class' => 'button col-xs-3 btn btn-default']); ?>
					</div><!--nested row-->
					
				</div> <!--col-xs-12-->
				
			</div> <!--collapseOne-->
			
		</div> <!--row-->
<!-- End loop -->
			
		<?php endforeach; ?>
		
		<?php echo $this->element('paginator'); ?>

		</div><!--row table-th-->
	
	</div> <!--subscriptionPackages index?-->

