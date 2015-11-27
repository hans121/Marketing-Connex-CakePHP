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
                  <h2 class="card--title"><?= __('Campaign'); ?></h2>
                  <h3 class="card--subtitle"><?= $this->Html->link(__('See all'), ['controller' => 'PartnerCampaigns','action' => 'availablecampaigns']); ?> all Campaigns</h3>
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

<div class="Campaigns view">


  
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

  <div class="row inner header-row">
    <dt class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?= h($campaign->name); ?>
    </dt>
  </div>
  
  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Assigned Financial Quarter'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= $campaign->financialquarter->quartertitle ?>
    </dd>
  </div>

  <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Campaign Type'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($campaign->campaign_type) ?>
    </dd>
  </div>

  <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Target Market'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($campaign->target_market) ?>
    </dd>
  </div>

  <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Example Subject line for partners'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($campaign->subject_line) ?>
    </dd>
  </div>
  <!--
  <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= __('Available To'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
    
      <?php
        if($campaign->available_to == 'password'){ ?>
          <i class="fa fa-lock"></i> <?= __('Only those with a password'); ?> <?php
        } else if ($campaign->available_to == 'all'){ ?>
        <i class="fa fa-unlock"></i></span> <?= __('All'); ?> <?php
        } else { ?>
        <i class="fa fa-trophy"></i> <?= __('Top 100 only'); ?> <?php
        }
      ?>
    
    </dd>
  </div>
  -->
  <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= __('Sales Value'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <?= h($campaign->sales_value) ?>
    </dd>
  </div>
  
  </div> <!-- /.row -->


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
            $this->Html->addCrumb('view', ['controller' => 'PartnerCampaigns', 'action' => 'viewCampaign', $campaign->id]);
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
        <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>         


      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->

