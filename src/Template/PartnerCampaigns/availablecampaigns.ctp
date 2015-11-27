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
                  <h2 class="card--title"><?= __('Available Campaigns')?></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
                    <?= $this->Html->link(__('Apply'), ['controller'=>'Businessplans','action' => 'add'],['class' => 'btn btn-primary']); ?>
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

<div class="campaigns index">
      

  
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
  <!-- Are there any campaigns to display? -->
  
  <?php
    if($campaigns->count()>0) {
  ?>
    
  <div class="row table-th hidden-xs">  
    
    <div class="clearfix"></div>
  
    <div class="col-lg-3 col-md-5 col-sm-4 col-xs-2"><?= $this->Paginator->sort('name','Campaign Name') ?></div>
    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2"><?= $this->Paginator->sort('financialquarter_id','Financial Quarter') ?></div>
    <div class="hidden-lg hidden-md hidden-sm col-xs-2"><?= $this->Paginator->sort('campaign_type') ?></div>
    <div class="col-lg-3 hidden-md hidden-sm col-xs-1"><?= $this->Paginator->sort('target_market') ?></div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2"><?= $this->Paginator->sort('status') ?></div>
    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"></div>

  </div> <!--row-table-th-->
    
    
  <!-- Start loop -->
  
  <?php 
    $j =0;
    foreach ($campaigns as $campaign):
    $j++;
  ?>
  
  <div class="row inner hidden-xs">
  
    <div class="col-lg-3 col-md-5 col-sm-4 col-xs-2">

      <?= h($campaign->name) ?>
            <?php
        if (!in_array($campaign->id, $myviewedcampaignsarray)) { ?>
        <span class="badge pull-right"><?=__('New')?></span>&nbsp;
      <?php 
        }
      ?>
    </div>
    <div class="col-lg-1 col-md-2 col-sm-2 col-xs-2">
      <?= $campaign->has('financialquarter') ? $campaign->financialquarter->quartertitle : '' ?>
    </div>
    <div class="hidden-lg hidden-md hidden-sm col-xs-2">
      <?php
        if($campaign->campaign_type == 'e-mail'){ ?>
          <i class="fa fa-at"></i> <?= __('E-mail') ?>
      <?php
        } else if ($campaign->campaign_type == 'Royal Mail'){ ?>
        <i class="fa fa-envelope-o"></i> <?= __('Postal') ?>
      <?php
        } else if ($campaign->campaign_type == 'leaflet'){ ?>
        <i class="fa fa-copy"></i> <?= __('Leaflet') ?>
      <?php
        } else { ?>
        <?= h($campaign->campaign_type) ?>
      <?php
        }
      ?>
    </div>
    
    <div class="col-lg-3 hidden-md hidden-sm col-xs-1">
      <?php 
        if (h($campaign->target_market) == 'smb') {
          echo('SMB');
        } else {
          if($campaign->target_market)
            echo (h($campaign->target_market));
        else
          echo '&nbsp;';
        } ?>
        
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
      <?php 
        if (isset($mybpstatus[$campaign->id])) {
          if($mybpstatus[$campaign->id] == 'Draft') {
            echo '<i class="fa fa-pencil"></i> '.$mybpstatus[$campaign->id];
            $bp_edit = $mybpdetails[$campaign->id];
          } else if($mybpstatus[$campaign->id] == 'Denied') {
            echo '<i class="fa fa-times"></i> '.__('Declined');
            $bp_edit = 0;
          } else {
            echo ($mybpstatus[$campaign->id]);
            $bp_edit = 0;
          }
        } else {
          echo '<i class="fa fa-flag"></i> '.__('Available');
            $bp_edit = 0;

        }
      ?>
    </div>

    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">

<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
<?php if($bp_edit == 0){?>
          <li><?= $this->Html->link(__('Apply'), ['controller'=>'Campaignplans','action' => 'add', 0, $campaign->id, $campaign->financialquarter->id]);   $this->request->data['currency_choice']    =  $vendor['currency_choice'];
?></li>
        <?php } else {?>
          <li><?= $this->Html->link(__('Edit application'), ['controller'=>'Campaignplans','action' => 'edit',$bp_edit]); ?></li>
        <?php } ?>
          <li><?= $this->Html->link(__('Details'), ['controller'=>'PartnerCampaigns','action' => 'viewCampaign', $campaign->id]); ?></li>
  </ul>
</div>


      
    </div>
    
  </div> <!--row-->
    
    
    <div class="row inner visible-xs">
    
      <div class="col-xs-12 text-center">
        
        <a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
          
          <h3>
            <?= h($campaign->name) ?>
            <?php
              if (!in_array($campaign->id, $myviewedcampaignsarray)) {
                echo '<span class="badge">'.__("New").'</span>';
              }
            ?>
          </h3>
          
        </a>
        
      </div> <!--col-->

        
      <div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
      
        <div class="row inner">
        
          <div class="col-xs-6">
            <?= __('Financial Quarter')?>
          </div>
          
          <div class="col-xs-6">
            <?= $campaign->has('financialquarter') ? $this->Html->link($campaign->financialquarter->quartertitle, ['controller' => 'Financialquarters', 'action' => 'view', $campaign->financialquarter->id]) : '' ?>
          </div>
        
        </div>
        <div class="row inner">
        
          <div class="col-xs-6">
            <?= __('Campaign Type')?>
          </div>
          
          <div class="col-xs-6">
            <?= h($campaign->campaign_type) ?>
          </div>
        
        </div>
        
        <div class="row inner">
        
          <div class="col-xs-6">
            <?= __('Target Market')?>
          </div>
          
          <div class="col-xs-6">
            <?= h($campaign->target_market) ?>
          </div>
        
        </div> 
        
          <div class="row inner">
        
            <div class="col-xs-6">
              <?= __('Status')?>
            </div>
            
            <div class="col-xs-6">
              <?php 
                if (isset($mybpstatus[$campaign->id])) {
                  echo '<i class="fa fa-pencil"></i> '.$mybpstatus[$campaign->id];
                  if($mybpstatus[$campaign->id] == 'Draft'){
                      $bp_edit = $mybpdetails[$campaign->id];
                  }else{
                      $bp_edit = 0;
                  }
                } else {
                  echo '<i class="fa fa-check"></i> '.__('Available'); $bp_edit  = 0;
                }
              ?>
            </div>
        
        </div>
        
        <div class="row inner">
        
          <div class="col-xs-12">
          
            <div class="btn-group pull-right">
              <?php if($bp_edit == 0){?>
                <?= $this->Html->link(__('Submit Campaign Plan'), ['controller'=>'Campaignplans','action' => 'add'],['class' => 'btn pull-right']); ?>
              <?php }else{?>
                <?= $this->Html->link(__('Submit Campaign Plan'), ['controller'=>'Campaignplans','action' => 'edit',$bp_edit],['class' => 'btn pull-right']); ?>
              <?php } ?>
                  <?= $this->Html->link(__('View'), ['controller'=>'PartnerCampaigns','action' => 'viewCampaign', $campaign->id],['class' => 'btn pull-right']); ?>
            </div>
            
          </div>
          
        </div>
        
      </div>
      
    </div> <!--row-->
  
  
<!-- End loop -->

      
<?php endforeach; ?>


<?php echo $this->element('paginator'); ?>
    
<?php
  
  } else {
  
?>

              <div class="row inner withtop">
                  
                <div class="col-sm-12 text-center">
                  <?=  __('No campaigns available') ?>
                </div>
                
              </div> <!--/.row.inner-->

<?php
  
  }
  
?>

  
</div><!-- /.container -->


<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
<?php
          $this->Html->addCrumb('Campaign Management', ['controller' => 'PartnerCampaigns', 'action' => 'mycampaignslist']);
          $this->Html->addCrumb('Available Campaigns', ['controller' => 'PartnerCampaigns', 'action' => 'availablecampaigns']);
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
        <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-primary btn-cancel']); ?>         

      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->

