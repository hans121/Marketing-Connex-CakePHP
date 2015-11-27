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
                  <i class="icon ion-plus"></i></div>
                </div>
                <div class="card--info">
                  <h2 class="card--title"><?= __('Profile'); ?></h2>
			<div class="breadcrumbs"</h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
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

<?php 
 $auth = $this->Session->read('Auth');
 $auth_vendor_primary = $auth['User']['primary_contact'];
?>

<div class="partners--view">

	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
			<?= h($partner->company_name); ?>
		</dt>
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
			<div class="btn-group pull-right">
	            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $partner->id],['class' => 'btn btn-default']); ?> 
			</div>
		</dd>
	</div>

	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Related Vendor'); ?>
	    </dt>
	    <dd class="col-lg-5 col-md-5 col-sm-4 col-xs-6">
	    
	      <?php if(trim($partner->logo_url) != ''){?>
	      
					<a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image($partner->vendor->logo_url)?>'>
						<?= h($partner->vendor->company_name); ?> <i class="fa fa-info-circle"></i>
					</a>
					
	      <?php } else { ?>

					<?= h($partner->vendor->company_name); ?>

	      <?php } ?>
	      
	    </dd>
	    <dd class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
	    	<div class="btn-group pull-right">
				</div>
	    </dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Address'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->address); ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('City'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->city); ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('County/State'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->state); ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Zip / Post code'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->postal_code); ?>
		</dd>
	</div>
	
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Phone'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->phone); ?>
		</dd>
	</div>
	

	<?php 
		if (h($partner->website)!='') {
	?>
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Website'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $this->Html->link(h($partner->website), h($partner->website),['target' => '_blank']); ?> <i class="fa fa-external-link"></i>
		</dd>
	</div>
	<?php
		}
	?>
	
	<?php if(isset($partner->vendor_manager) && !empty($partner->vendor_manager)){?>
	<div class="row inner">   
	    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Vendor Manager'); ?>
	    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($partner->vendor_manager->user->full_name); ?>
		</dd>
	</div>
        <?php } ?>
        
    <div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Twitter'); ?>
	    </dt>
	    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
	    	<?php if($twitter_isauth) { ?>
				<?=$this->HTML->link(__('View Twitter Profile'),$partner->twitter, ['class'=>'btn btn-default btn-sm','target'=>'_blank']); ?>
			<?php } else { ?>
				<?=$this->HTML->link(__('Connect Twitter'), ['controller' => 'SocialApps', 'action' => 'twitterInitialize'], ['class'=>'btn btn-default btn-sm'])?>
			<?php } ?>
		</dd>
	</div>
	
	<div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('Facebook'); ?>
	    </dt>
	    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php if($facebook_isauth): ?>
				<?=$this->HTML->link(__('View Facebook Profile'),$partner->facebook, ['class'=>'btn btn-default btn-sm','target'=>'_blank']); ?>
			<?php else: ?>
				<?=$this->HTML->link(__('Connect Facebook'), ['controller' => 'SocialApps', 'action' => 'facebookInitialize'], ['class'=>'btn btn-default btn-sm'])?>
			<?php endif; ?>
		</dd>
	</div>
	
	<div class="row inner">
		<dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
	    	<?= __('LinkedIn'); ?>
	    </dt>
	    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">			
			<?php if($linkedin_isauth): ?>
				<?=$this->HTML->link(__('View Linkedin Profile'),$partner->linkedin, ['class'=>'btn btn-default btn-sm','target'=>'_blank']); ?>
			<?php else: ?>
				<?=$this->HTML->link(__('Connect Linkedin'), ['controller' => 'SocialApps', 'action' => 'linkedinInitialize'], ['class'=>'btn btn-default btn-sm'])?>
			<?php endif; ?>
		</dd>
	</div>

</div>


<div class="row sub--card_info">
<div class="col-md-6">
<h4><?= __('Related Partner Managers'); ?> <small class="hidden-xs"><?= $this->Html->link(__('View All'), ['controller' => 'PartnerManagers', 'action' => 'index']); ?></small></h4>
</div>
<div class="col-md-6">
	<?= $this->Html->link(__('Add new'), ['controller' => 'PartnerManagers', 'action' => 'add'],['class'=> 'btn btn-primary pull-right']); ?> 
</div>
</div>
<hr>


	
	
	<?php if (!empty($partner->partner_managers)): ?>
	
	
	
    <div class="partners view">
			
			<div class="row table-th hidden-xs">	
				<div class="col-md-4 col-sm-4">
					<?= $this->Paginator->sort('user_id'); ?>
				</div>
				<div class="col-md-2 hidden-sm text-center">
					<?= $this->Paginator->sort('created_on'); ?>
				</div>
				<div class="col-md-2 col-sm-2 text-center">
					<?= $this->Paginator->sort('primary_contact'); ?>
				</div>
				<div class="col-md-4 col-sm-6">
				</div>
				
			</div> <!--row-table-th-->
			
		<?php	$j=0;
        foreach ($partner->partner_managers as $partnerManagers): $j++;?>
			
			<div class="row inner hidden-xs">
			
				<div class="col-md-4 col-sm-4">
					<?= $partnerManagers['user']->full_name ?>
				</div>
				<div class="col-md-2 hidden-sm text-center">
					<?= h(date('d/m/Y',strtotime($partnerManagers->created_on))); ?>
				</div>
				<div class="col-md-2 col-sm-2 text-center">
					<?php if (h($partnerManagers->primary_contact) == 'Y') { ?>
						<span class="fa fa-check"></span> 
					<?php } ?>
				</div>
				
				<div class="col-md-4 col-sm-6">

<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
						<?php 
						if($auth_vendor_primary == 'Y'){?>
							<li><?= $this->Form->postLink(__('Delete'), ['controller' => 'PartnerManagers','action' => 'delete', $partnerManagers->id], ['confirm' => __('Are you sure you want to delete?', $partnerManagers->id)]); ?></li>
							<li><?= $this->Html->link(__('Edit'), ['controller' => 'PartnerManagers','action' => 'edit', $partnerManagers->id]); ?></li>
							<li><?= $this->Html->link(__('View'), ['controller' => 'PartnerManagers','action' => 'view', $partnerManagers->id]); ?></li>
							<?php 
							if($partnerManagers->primary_contact != 'Y'){ ?>
								<li><?= $this->Form->postLink(__('Make Primary'), ['controller' => 'PartnerManagers','action' => 'changePrimaryPmanager', $partnerManagers->id], ['confirm' => __('Are you sure you want to change primary manager?', $partnerManagers->id)]); ?></li>
							<?php }
						} 
						?>
  </ul>
</div>



				</div>
				
			</div>
			
	
	<!-- For mobile view only -->
	<div class="row inner visible-xs">
		
		<div class="col-xs-12 text-center">
		
			<a data-toggle="collapse" data-parent="#accordion" href="#pmanagers-<?= $j ?>">
			
				<h3><?= $partnerManagers['user']->full_name ?></h3>
				
			</a>	
								
		</div> <!--col-->
					
		<div id="pmanagers-<?= $j ?>" class="col-xs-12 panel-collapse collapse">
		
			<div class="row inner">
				<div class="col-xs-6"><?= __('Name'); ?></div>
				<div class="col-xs-6"><?= $partnerManagers['user']->full_name ?></div>
			</div>
			<div class="row inner">
				<div class="col-xs-6"><?= __('Primary Contact'); ?></div>
				<div class="col-xs-6">
					<?php if (h($partnerManagers->primary_contact) == 'Y') { ?>
						<span class="glyphicon glyphicon-ok"></span> 
					<?php } ?>
				</div>
				
			</div>
			<div class="row inner">
			<div class="col-xs-12">
					<div class="btn-group pull-right">
						<?php 
						if($auth_vendor_primary == 'Y'){?>
							<?= $this->Form->postLink(__('Delete'), ['controller' => 'PartnerManagers','action' => 'delete', $partnerManagers->id], ['confirm' => __('Are you sure you want to delete?', $partnerManagers->id),'class' => 'btn btn-danger pull-right']); ?>
							<?= $this->Html->link(__('Edit'), ['controller' => 'PartnerManagers','action' => 'edit', $partnerManagers->id],['class' => 'btn pull-right']); ?>
							<?= $this->Html->link(__('View'), ['controller' => 'PartnerManagers','action' => 'view', $partnerManagers->id],['class' => 'btn pull-right']); ?>
							<?php 
							if($partnerManagers->primary_contact != 'Y'){
								echo $this->Form->postLink(__('Make Primary'), ['controller' => 'PartnerManagers','action' => 'changePrimaryPmanager', $partnerManagers->id], ['confirm' => __('Are you sure you want to change primary manager?', $partnerManagers->id),'class' => 'btn pull-right']);
							}
						} 
						?>
					</div>
				</div>

			</div>
			
		
		</div> <!-- /.collapse -->				
	
	</div> <!-- /.row -->
	
	
	<?php endforeach; ?>
	
	<?php endif; ?>

  </div>
	
  </div>


<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
          				<?php
					$this->Html->addCrumb('Profile', ['controller' => 'Partners', 'action' => 'view']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Partners', 'action' => 'index'],
					    'escape' => false
					]);
				?>
          </li>
        </ol>
      </div>
      <div class="col-md-6 text-right">
        <?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>         


      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->

