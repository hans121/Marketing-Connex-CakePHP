<div class="row table-title partner-table-title">

	<div class="partner-sub-menu clearfix">
	
		<div class="col-md-5 col-sm-4 col-xs-6">
			<h2><?= __('Pages'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Pages', ['controller'=>'PartnerPages', 'action'=>'index']);
					
					//if($parentmenu->parent_id!=0) : // not root menu, add the parent folder to the breadcrumb
					if(count($crumbs)>0)
						foreach($crumbs as $crumb)
							$this->Html->addCrumb( __($crumb['id']===0?'main menu':$crumb['name']), ['controller' => 'PartnerPages', 'action' => 'navigate', $crumb['id']]);
					//endif;

						$this->Html->addCrumb( h($firstpage->title), ['controller' => 'PartnerPages', 'action' => 'view', $firstpage->id]);

					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
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
					<?= $this->Html->link($menu->name, ['controller' => 'PartnerPages', 'action' => 'navigate', $menu->id],['class'=>'btn btn-lg'.($menu->id==$menuid?' active':''),'role'=>'button']) ?>					 
			  
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
				<?= $this->Html->link(__($parentmenu->name), ['controller' => 'PartnerPages', 'action' => 'navigate',$parentmenu->id],['class'=>'btn btn-lg'.($parentmenu->id==$menuid?' active':''),'role'=>'button']) ?>			  
			</div>
			
			<?php
				
			}
			
			?>
			
			<div class="btn-group pull-right">
				<?= $this->Html->link(__('main menu'), ['controller' => 'PartnerPages', 'action' => 'index'],['class'=>'btn btn-lg'.(0==$menuid?' active':''),'role'=>'button']) ?>			  
			</div>
				
		</div>


		
	</div>

</div> <!--row-table-title-->

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<?php
if($pages->count()>0) :
?>

<ul class="nav nav-tabs">
	
	<?php				
		foreach ($pages as $page):	
	?>
			
  <li role="presentation" <?=$firstpage->id==$page->id?'class="active"':''?>><!-- we only need class="active" on the 'current' page-->
  	<?= $this->Html->link(h($page->title), ['controller'=>'PartnerPages','action' => 'view', $page->id]); ?>
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
