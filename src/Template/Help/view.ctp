<div class="row table-title partner-table-title help-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-4 col-xs-6">
			<?php
				$admn = $this->Session->read('Auth');
				switch ($admn['User']['role']) {		
				  case 'vendor':
			?>
				<h2><i class="fa fa-question-circle text-center cyan"></i> <?= __('Help & Support'); ?></h2>
			<?php
				  break;
				  case 'partner':
			?>
				<h2><i class="fa fa-question-circle text-center claret"></i> <?= __('Help & Support'); ?></h2>
			<?php
				  break;
				  default:
			?>
				<h2><i class="fa fa-question-circle text-center"></i> <?= __('Help & Support'); ?></h2>
			<?php
				  break;
				}
			?>
			
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Help & Support', ['controller'=>'Help', 'action'=>'index']);
					
					//if($parentmenu->parent_id!=0) : // not root menu, add the parent folder to the breadcrumb
					if(count($crumbs)>0)
						foreach($crumbs as $crumb)
							$this->Html->addCrumb( __($crumb['id']===0?'main menu':$crumb['name']), ['controller' => 'Help', 'action' => 'navigate', $crumb['id']]);
					//endif;

						$this->Html->addCrumb( h($firstpage->title), ['controller' => 'Help', 'action' => 'view', $firstpage->id]);

					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => ($user['role']=='vendor'?'Vendors':'Partners'), 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-md-7 col-sm-8 col-xs-6">
			
			<?php				
			
			if($menus->count()) {
				
				foreach($menus as $menu) :
			
			?>
			
			<div class="btn-group pull-right">				
					<?= $this->Html->link($menu->name, ['controller' => 'Help', 'action' => 'navigate', $menu->id],['class'=>'btn btn-lg'.($menu->id==$menuid?' active':''),'role'=>'button']) ?>					 
			  
			</div>
			
			<?php
				
				endforeach;
			
			}
			
			?>
			
			<!-- Are there any pages in the root menu folder? -->
				
			<?php
			
			if($parentmenu->parent_id!=0) {
						
			?>
			
			<div class="btn-group pull-right">
				<?= $this->Html->link(__($parentmenu->name), ['controller' => 'Help', 'action' => 'navigate',$parentmenu->id],['class'=>'btn btn-lg'.($parentmenu->id==$menuid?' active':''),'role'=>'button']) ?>			  
			</div>
			
			<?php
				
			}
			
			?>
			
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('Help Home'), ['controller' => 'Help', 'action' => 'index'],['class'=>'btn btn-lg'.(0==$menuid?' active':''),'role'=>'button']) ?>			  
			</div>
				
		</div>


		
	</div>

</div> <!--row-table-title-->

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<div class="row">

	<div class="col-lg-3 col-lg-offset-9 col-md-4 col-md-offset-8 col-sm-5 col-sm-offset-7">
		<p>
			<i class="fa fa-phone fa-lg text-center cyan"></i>
			<?= $this->Html->link(__('+44 (0)1628 566 001 (Mon-Fri 8am-6pm)'),'tel:+441628566001',['title'=>'Call our support team on +44 (0)1628 566 001', 'class' => '']);?>
		</p>
	</div>
	
</div>
<div class="row">
	
	<div class="col-lg-3 col-lg-offset-9 col-md-4 col-md-offset-8 col-sm-5 col-sm-offset-7">
		<p>
			<i class="fa fa-at fa-lg text-center olive"></i>
			<?= $this->Html->link(__('support@marketingconnex.com'),'mailto:support@marketingconnex.com',['title'=>'email support@marketingconnex.com', 'class' => '']);?>
		</p>
	</div>
	
</div>


<?php
if($pages->count()>0) :
?>

<ul class="nav nav-tabs">
	
	<?php				
		foreach ($pages as $page):	
	?>
			
  <li role="presentation" <?=$firstpage->id==$page->id?'class="active"':''?>><!-- we only need class="active" on the 'current' page-->
  	<?= $this->Html->link(h($page->title), ['controller'=>'Help','action' => 'view', $page->id]); ?>
  </li>

	<?php
		endforeach;
	
	?>
  
  
</ul>

<div class="row">
	<div class="col-md-12"><?=$firstpage->content?></div>
</div>

<?php 
	else :
?>

	<div class="row inner withtop">
		
	  <div class="col-sm-12 text-center">
			<?= __("Sorry, there's no content in this section yet.  Please look elsewhere, or contact us if you need assistance.") ?>
	  </div>
		  
	</div>

<?php	
	endif;
?>


<div class="help-page-social">
	<?php echo $this->element('social-links'); ?>
</div>


<?php echo $this->Html->script('twitter-feed/twitter-feed.js');?>
<?= $this->fetch('script');?>
