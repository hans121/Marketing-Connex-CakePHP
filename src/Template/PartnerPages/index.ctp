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
                  <h2 class="card--title"><?= __('Communications'); ?></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
     <?php       
      
      if($menus->count()) {
        
        foreach($menus as $menu) :
      
      ?>
      
      <li>       
          <?= $this->Html->link($menu->name, ['controller' => 'PartnerPages', 'action' => 'navigate', $menu->id]) ?> </li>        
        
      </div>
      
      <?php
        
        endforeach;
      
      }
      
      ?>
      
      <!-- Are there any pages in the root menu folder? -->
        
      <?php
      
      if($parentmenu->parent_id!=0) {
            
      ?>
      
      <li>
        <?= $this->Html->link(__($parentmenu->name), ['controller' => 'PartnerPages', 'action' => 'navigate',$parentmenu->id]) ?>        
      </li>
      
      <?php
        
      }
      
      ?>
      
      <li>
        <?= $this->Html->link(__('main menu'), ['controller' => 'PartnerPages', 'action' => 'index']) ?>       
      </li>
  </ul>
</div>


     
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


<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-9">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
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
          </li>
        </ol>
      </div>
      <div class="col-md-3 text-right">
        <?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>         


      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->

