<div class="UserRoles index">
			
	<div class="row index table-title admin-table-title">
	
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		
			<h2><?= __('User Roles')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('User Roles', '/user_roles');
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'UserRoles'],
					    'escape' => false
					]);
				?>
			</div>
			
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">			
			<div class="pull-right btn btn-lg">					
				<?= $this->Html->link(__('Add Role'), ['controller' => 'UserRoles', 'action' => 'add']); ?>			    
			</div>		
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<!-- Are there any users? -->
	<?php
		if($user_roles)
		{
	?>
	
	<div class="row table-th hidden-xs">	
		
		<div class="clearfix"></div>
	
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			<?= $this->Paginator->sort('role','Role'); ?>
		</div>
    <div class="col-lg-6 hidden-md hidden-sm col-xs-6">
	    <?= $this->Paginator->sort('description','Description'); ?>
	   </div>
		<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 text-right">
			
		</div>
		
	</div> <!--row-table-th-->
		
		
	<!-- Start loop -->
	
	
	<?php 
		$j =0;
		foreach ($user_roles as $role):
		$j++;
	?>
	
		<div class="row inner hidden-xs">
		
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<?= h($role->role); ?>
			</div>
			<div class="col-lg-6 hidden-md hidden-sm col-xs-6">
				<?= h($role->description); ?>
			</div>

			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
			
				<div class="btn-group pull-right">
					<?//=$this->Form->postLink(__('Delete'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete this user role?', $role->id),'class' => 'btn btn-danger pull-right']); ?>
					<?=$this->Html->link(__('Edit Permission'), ['action' => 'edit', $role->id],['class' => 'btn pull-right']); ?>
				</div>
				
			</div>
			
		</div> <!--row-->
		
		
		<div class="row inner visible-xs">
		
			<div class="col-xs-12 text-center">
				
				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					
					<h3><?= h($role->role); ?></h3>
					
				</a>
				
			</div> <!--col-->

				
			<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
			
				<div class="row inner">
					
					<div class="col-xs-12">
						<?= h($role->description); ?>
					</div>
				
				</div>
				
				<div class="row inner">
				
					<div class="col-xs-12">
					
						<div class="btn-group pull-right">
							<?//=$this->Form->postLink(__('Delete'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete this user role?', $role->id),'class' => 'btn btn-danger pull-right']); ?>
							<?=$this->Html->link(__('Edit Permission'), ['action' => 'edit', $role->id],['class' => 'btn pull-right']); ?>
						</div>
						
					</div>
					
				</div>
				
			</div>
			
		</div> <!--row-->
	
	
<!-- End loop -->

			
<?php
  
  	endforeach;

	} else {
			
	?>
		
	<div class="row inner withtop">
			
		<div class="col-sm-12 text-center">
			<?=	 __('No user roles found') ?>
		</div>
		
	</div> <!--/.row.inner-->
	
	<?php
	
	}
	
?>

<?php echo $this->element('paginator'); ?>
		
		
</div><!-- /.container -->

	</div> <!-- /#content -->
