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
                  <h2 class="card--title"><?= __('Email Management')?></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
                          <?= $this->Html->link(__('Add new'), ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'add'],['class'=>'btn btn-primary','fullBase'=>true]); ?>

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

<?= $this->Flash->render()?>
<div class="partners vendors">

    
    
    
    
</div> <!--row-table-title-->

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
<div class="row table-th hidden-xs">
  
  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-2">
    <?= $this->Paginator->sort('campaign_id','Campaign name') ?>
    <span class="pull-right" style="padding-right:10px;">Email template</span>
  </div>
  <div class="hidden-lg hidden-md hidden-sm col-xs-1">
    <?= $this->Paginator->sort('from_name',"'From' name") ?>
  </div>    
  <div class="hidden-lg hidden-md hidden-sm col-xs-1">
    <?= $this->Paginator->sort('from_email',"'From' email") ?>
  </div>
  <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-right">
    <?= $this->Paginator->sort('campaign_send','Send limit') ?>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    <?= $this->Paginator->sort('status',"Status") ?>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-5 col-xs-3">

  </div>

</div> <!--row-table-th-->
    
    
<!-- Start loop -->

<?php 
  $j =0;
  foreach ($partnerCampaignEmailSettings as $partnerCampaignEmailSetting):
  $j++;

  $spamverified = $partnerCampaignEmailSetting->email_template->spam=='N' && $partnerCampaignEmailSetting->has('email_template');
?>
    
<div class="row inner hidden-xs">

  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-2">
    <?= $partnerCampaignEmailSetting->has('campaign') ? $partnerCampaignEmailSetting->campaign->name : '' ?><?='<span class="badge">'.($spamverified?'Spam verified <i class="fa fa-shield"></i>':'Unverified <i class="fa fa-exclamation-triangle"></i>').'</span>'?>
  </div>
  <div class="hidden-lg hidden-md hidden-sm col-xs-1">
    <?= h($partnerCampaignEmailSetting->from_name) ?>
  </div>    
  <div class="hidden-lg hidden-md hidden-sm col-xs-1">
    <?= h($partnerCampaignEmailSetting->from_email) ?>
  </div>
  <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-right">
    <?= $partnerCampaignEmailSetting->has('campaign') ?  $this->Number->precision($partnerCampaignEmailSetting->campaign->send_limit, 0) : '' ?>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    <?php
      switch($partnerCampaignEmailSetting->status):
        case 'sent':
          echo '<i class="fa fa-inbox"></i> '.__('Sent');
          break;
        case 'draft':
          echo '<i class="fa fa-pencil"></i> '.__('Draft');
          break;
        default:
          echo '<i class="fa fa-clock-o"></i> '.__('Scheduled');
          break;
      endswitch;
    ?>
  </div>
  <div class="col-lg-4 col-md-4 col-sm-5 col-xs-3">

<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><?= $this->Html->link(__('Mailing list'), ['controller'=>'CampaignPartnerMailinglists','action' => 'index', $partnerCampaignEmailSetting->campaign->id],['title' => 'View mailing list']); ?></li>
    <li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partnerCampaignEmailSetting->id], ['confirm' => __('Are you sure you want to delete ?', $partnerCampaignEmailSetting->id), 'disabled'=>($spamverified?false:true)]); ?></li>
    <?php
      if($partnerCampaignEmailSetting->status != 'sent') {
    ?>
      <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerCampaignEmailSetting->id],['disabled'=>($spamverified?false:true)]); ?></li>
    <?php
      }
    ?>
    <li><?= $this->Html->link(__('View'), ['action' => 'view', $partnerCampaignEmailSetting->id],['disabled'=>($spamverified?false:true)]); ?></li>
  </ul>
</div>



  </div>
    
</div> <!--row-->
    
    
<!-- For mobile view only -->
<div class="row inner visible-xs">

  <div class="col-xs-12 text-center">
    
    <a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
      
      <h3><?= $partnerCampaignEmailSetting->has('campaign') ? $partnerCampaignEmailSetting->campaign->name : '' ?></h3>
      
    </a>
    
  </div> <!--col-->

  <div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">
  
    <div class="row inner">
      <div class="col-xs-6">
        <?= __("'From' name")?>
      </div>
      <div class="col-xs-6">
        <?= h($partnerCampaignEmailSetting->from_name) ?>
      </div>
    </div>
    
    <div class="row inner">
      <div class="col-xs-6">
        <?= __("'From' email")?>
      </div>
      <div class="col-xs-6">
        <?= h($partnerCampaignEmailSetting->from_email) ?>
      </div>
    </div>
    
    <div class="row inner">
      <div class="col-xs-6">
        <?= __("'Reply to' email")?>
      </div>
      <div class="col-xs-6">
        <?= h($partnerCampaignEmailSetting->reply_to_email) ?>
      </div>
    </div>
    <div class="row inner">
      <div class="col-xs-6">
        <?= __('Campaign send limit')?>
      </div>
      <div class="col-xs-6">
        <?= $partnerCampaignEmailSetting->has('campaign') ?  $this->Number->precision($partnerCampaignEmailSetting->campaign->send_limit, 0) : '' ?>
      </div>
    </div>
    <div class="row inner">
      <div class="col-xs-6">
        <?= __('Status')?>
      </div>
      <div class="col-xs-6">
        <?php
      switch($partnerCampaignEmailSetting->status):
        case 'sent':
          echo '<i class="fa fa-inbox"></i> '.__('Sent');
          break;
        case 'draft':
          echo '<i class="fa fa-pencil"></i> '.__('Draft');
          break;
        default:
          echo '<i class="fa fa-clock-o"></i> '.__('Scheduled');
          break;
      endswitch;
    ?>
      </div>
    </div>
    <div class="row inner">   
      <div class="col-xs-12">
        <div class="btn-group pull-right">
          <?= $this->Html->link(__('Mailing list'), ['controller'=>'CampaignPartnerMailinglists','action' => 'index', $partnerCampaignEmailSetting->campaign->id],['class' => 'btn pull-right']); ?>
          <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partnerCampaignEmailSetting->id], ['confirm' => __('Are you sure you want to delete ?', $partnerCampaignEmailSetting->id),'class' => 'btn btn-danger pull-right']); ?>
          <?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerCampaignEmailSetting->id],['class' => 'btn pull-right']); ?>
          <?= $this->Html->link(__('View'), ['action' => 'view', $partnerCampaignEmailSetting->id],['class' => 'btn pull-right']); ?>
        </div>
      </div>
    </div>
      
  </div> <!-- /.collapse -->
  
</div> <!-- /.row -->


<!-- End loop -->
      
<?php endforeach; ?>
    
<?php echo $this->element('paginator'); ?>

<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
        <?php
          $this->Html->addCrumb('Email Management', ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']);
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

