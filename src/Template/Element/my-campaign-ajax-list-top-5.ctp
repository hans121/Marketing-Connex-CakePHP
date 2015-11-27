
<!-- Card -->

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
                  <h2 class="card--title"><?= __('Top 5 deals'); ?> <small><?= $this->Html->link(__('See all'), ['controller' => 'CampaignPartnerMailinglists','action' => 'listdeals']); ?></small></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
                  <?= $this->Html->link(__('Register a deal'), '#',['onclick'=>'movemailinglist();', 'class' => 'btn btn-primary']); ?>
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
<!-- Top 5 deals league table -->

  <div class="row table-th hidden-xs">
    <div class="clearfix"></div>  
    <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
      <?= __('Rank') ?>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3">
      <?= __('Name') ?>
    </div>
    <div class="col-lg-2 hidden-md hidden-sm col-xs-1">
      <?= __('Company name') ?>
    </div>
    <div class="col-lg-1 col-md-2 col-sm-3 col-xs-1 text-center">
      <?= __('Deal value') ?>
    </div>
    <div class="col-lg-2 col-md-2 hidden-sm col-xs-1 text-center">
      <?= __('Closure date') ?>
    </div>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
      <?= __('Status') ?>
    </div>
    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-4">
    </div>

  </div> <!--row-table-th-->
  <!-- Are there any deals? -->
  <?php
  if($campaignPartnerMailinglistDeal->count()>0)
  {
    ?>

    <div class="rosette">    

      <!-- Start loop -->
      <?php
      $j =0;
      foreach ($campaignPartnerMailinglistDeal as $row):
        $j++;
      ?>

      <div class="row inner hidden-xs">

        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center rank-<?= $j ?>">
          <?= $j ?>
        </div>

        <?php
        $email = $row['partner_manager']['user']->email;
        $size = 35;
        $grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default_avtar_url ) . "&s=".$size;


        ?>
        <div class="col-lg-2 col-md-3 col-sm-3 col-xs-3">

          <?= $this->Html->image($grav_url,['class' => 'gravatar', 'width' => '35', 'height' => '35'])?>
          &nbsp;
          <?= $row['partner_manager']['user']->first_name.' '.$row['partner_manager']['user']->last_name ?>
        </div>

        <div class="col-lg-2 hidden-md hidden-sm col-xs-1">
          <?= $row['partner_manager']['partner']->company_name ?>
        </div>

        <div class="col-lg-1 col-md-2 col-sm-3 col-xs-1 text-right">
          <?=$this->Number->currency($row->deal_value, $my_currency);?>
        </div>

        <div class="col-lg-2 col-md-2 hidden-sm col-xs-1 text-center">
          <?= date('d/m/Y',strtotime($row->closure_date)) ?>  
        </div>

        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-1">
          <?php
          if($row->status == 'Y') {
            echo ('<i class="fa fa-gavel"></i>'.' '.__('Closed'));
          } else {
            echo ('<i class="fa fa-bookmark"></i>'.' '.__('Registered'));
          }
          ?>
        </div>

        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4">

          <div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><?= $this->Html->link('View',['controller'=>'CampaignPartnerMailinglists','action'=>'viewdeal',$row->campaign_partner_mailinglist_id,$row->id])?></li>
    <li><?=$this->Html->link('Edit',['controller'=>'CampaignPartnerMailinglists','action'=>'editdeal',$row->campaign_partner_mailinglist_id,$row->id])?></li>
  </ul>
</div>


        </div>

      </div> <!--row-->


      <div class="row inner visible-xs">

        <div class="col-xs-12 text-center">

          <a data-toggle="collapse" data-parent="#accordion" href="#basic-<?=$j?>">

            <h3><?= $j.' - ' ?><?= $row['partner_manager']['user']->first_name.' '.$row['partner_manager']['user']->last_name ?><?php if($j == 1){ echo ' <i class="fa fa-trophy"></i>'; } ?></h3>

          </a>

        </div> <!-- /.col -->

        <div id="basic-<?=$j?>" class="col-xs-12 panel-collapse collapse">

          <div class="row inner">

            <div class="col-xs-5">
              <?='Company name'?>
            </div>

            <div class="col-xs-7">
              <?= $row['partner_manager']['partner']->company_name ?>
            </div>

          </div>

          <div class="row inner">

            <div class="col-xs-5">
              <?='Deal value'?>
            </div>

            <div class="col-xs-7">
              <?=$this->Number->currency($row->deal_value, 'USD');?>
            </div>

          </div>

          <div class="row inner">

            <div class="col-xs-5">
              <?='Deal status'?>
            </div>

            <div class="col-xs-7">
              <?php
              if($row->status == 'Y') {
                echo ('<i class="fa fa-gavel"></i>'.' '.__('Closed'));
              } else {
                echo ('<i class="fa fa-bookmark"></i>'.' '.__('Registered'));
              }
              ?>
            </div>

          </div>

          <div class="row inner">

            <div class="col-xs-12">


          <div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><?= $this->Html->link('View',['controller'=>'CampaignPartnerMailinglists','action'=>'viewdeal',$row->campaign_partner_mailinglist_id,$row->id])?></li>
    <li><?=$this->Html->link('Edit',['controller'=>'CampaignPartnerMailinglists','action'=>'editdeal',$row->campaign_partner_mailinglist_id,$row->id])?></li>
  </ul>
</div>

            </div>

          </div>

        </div> <!--collapseOne-->

      </div> <!--row-->
      <?php endforeach; ?>

    </div>
<?php } else { ?>

    <div class="row inner">

      <div class="col-xs-12 text-center">
        <?= __('No deals have yet been registered for this campaign') ?>
      </div>

    </div>

<?php } ?>
    <!-- End loop -->

    <?php // echo $this->element('paginator'); ?>

<!-- end Top 5 deals league table -->

<!-- content below this line -->
</div>

</div>
<!-- /Card -->

