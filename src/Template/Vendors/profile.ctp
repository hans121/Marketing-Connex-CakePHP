<?php 
$this->layout = 'admin--ui';
?>
<style>
.modal {
  top: 10%;
}
.modal-backdrop {
  z-index: -1;
  background-color: transparent!important;
}

</style>  

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
                  <i class="icon ion-gear-b"></i></div>
                </div>
                <div class="card--info">
                  <h2 class="card--title"><?= __('Company Profile')?></h2>
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

<div class="vendors--view">



  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

  <div class="row inner header-row ">

    <dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
      <?php
      if(trim($vendor->logo_url) != '') {
        ?>
        <?= h($vendor->company_name); ?> 
        <a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image($vendor->logo_url)?>'>
          <i class="fa fa-info-circle"></i>
        </a>
        <?php
      } else {
        ?>
        <?= h($vendor->company_name); ?>
        <?php
      }
      ?>
    </dt>
    <dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">

      <?= $this->Html->link(__('Edit'), ['controller' => 'Vendors', 'action' => 'edit'],['class' => 'btn btn-default pull-right']); ?>

    </dd>

  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Website'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?php 
      if (h($vendor->website)!='') {
        ?>
        <?= $this->Html->link(h($vendor->website), h($vendor->website), ['target' => '_blank']); ?> <i class="fa fa-external-link"></i>
        <?php
      }
      ?>
    </dd>
  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Address'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($vendor->address); ?>
    </dd>
  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Country'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($vendor->country); ?>
    </dd>
  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('City'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($vendor->city); ?>
    </dd>
  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('County/State'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($vendor->state); ?>
    </dd>
  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Zip / Postalcode'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($vendor->postalcode); ?>
    </dd>
  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Phone'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($vendor->phone); ?>
    </dd>
  </div>  



  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Subscription Package'); ?>
    </dt>
    <dd class="col-lg-5 col-md-5 col-sm-4 col-xs-4">
      <?= h($vendor['subscription_package']->name); ?>
    </dd>
    <dd class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
      <?= $this->Html->link("View details","#",['class'=> 'btn btn-default pull-right','data-toggle' => 'modal','data-target' => '#package-details']); ?>
    </dd>
  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Subscription Payment'); ?>
    </dt>
    <dd class="col-lg-5 col-md-5 col-sm-4 col-xs-4">
      <?php if($vendor->subscription_type == 'monthly'){ ?>
      <?= __('Monthly'); ?> <?php
    } else if ($vendor->subscription_type == 'yearly'){ ?>
    </span> <?= __('Yearly'); ?> <?php
  } ?>
</dd>
<dd class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
  <?= $this->Html->link(__('Edit payment card'), ['controller' => 'Vendors', 'action' => 'editcard',$vendor->id],['escape' => false, 'class'=> 'btn btn-default pull-right']); ?>
</dd>
</div>

<div class="row inner">   
  <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <?= __('Subscription Expiry Date'); ?>
  </dt>
  <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <?= h(date('d/m/Y',strtotime($vendor->subscription_expiry_date))); ?>
  </dd>
</div>

<div class="row inner">
  <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <?= __('Email send limit'); ?>
  </dt>
  <dd class="col-lg-5 col-md-5 col-sm-4 col-xs-4">
    <?php echo $this->Number->precision(h($vendor['subscription_package']->no_emails), 0); ?>
  </dd>
  <dd class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
    <?= $this->Html->link(__('Upgrade'), ['controller' => 'Vendors', 'action' => 'sendUpgrade',$vendor->id],['escape' => false, 'class'=> 'btn btn-default pull-right']); ?>
  </dd>
</div>

<div class="row inner">
  <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <?= __('Maximum number of partners'); ?>
  </dt>
  <dd class="col-lg-5 col-md-5 col-sm-4 col-xs-4">
    <?php echo $this->Number->precision(h($vendor['subscription_package']->no_partners), 0); ?>
  </dd>
  <dd class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
    <?= $this->Html->link(__('Upgrade'), ['controller' => 'Vendors', 'action' => 'suggestUpgrade',$vendor->id],['escape' => false, 'class'=> 'btn btn-default pull-right']); ?>
  </dd>
</div>    

<div class="row inner">
  <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <?= __('Language'); ?>
  </dt>
  <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <?php $flag = strtoupper($vendor->language) ?>
    <?php echo $this->Html->image('flags/flat/24/'.$flag.'.png', [ 'alt'=>'Panovus','width'=>'24','height'=>'24','class'=>'pull-left img-responsive']).' ('.h($vendor->language).')';?>                     
  </dd>
</div>

<div class="row inner">
  <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    <?= __('Status'); ?>
  </dt>
  <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
    <?php if($vendor->status == 'Y'){ ?>
    <i class="fa fa-check"></i> <?= __('Active'); ?> <?php
  } else if ($vendor->status == 'S'){ ?>
  <i class="fa fa-exclamation-triangle"></i> <?= __('Suspended'); ?> <?php
} else if ($vendor->status == 'B'){ ?>
<i class="fa fa-times"></i> <?= __('Blocked'); ?> <?php
} else if ($vendor->status == 'P'){ ?>
<i class="fa fa-circle-o-notch fa-spin"></i> <?= __('Pending'); ?> <?php
} else { ?>
<i class="fa fa-circle-o"></i> <?= __('Inactive'); ?> <?php
}
?>
</dd>
</div>    



<div class="row sub--card_info">
  <div class="col-md-6">
    <h4><?= __('Primary Contact Details'); ?></h4>
  </div>
  <div class="col-md-6 text-right">
    <?= $this->Html->link(__('Add new'), ['controller' => 'Vendors', 'action' => 'addVendorManager'], ['class' => 'btn btn-primary']); ?></div>
  </div>




  <div class="row inner header-row ">

    <dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
      <?= h($user->title.' '.$user->full_name); ?>
    </dt>
    <dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">

      <div class="btn-group pull-right">
        <?= $this->Html->link(__('Edit'), ['controller' => 'Vendors', 'action' => 'editManager', $user->vendor_manager->id,'view'],['class' => 'btn btn-default']); ?>
      </div>

    </dd>

  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Job Title'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($user->job_title); ?>
    </dd>
  </div>    

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Phone'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($user->phone); ?>
    </dd>
  </div>

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Email'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($user->email); ?>
    </dd>
  </div>    

  <div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
      <?= __('Username'); ?>
    </dt>
    <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
      <?= h($user->username); ?>
    </dd>
  </div>


  <div class="row sub--card_info">
    <div class="col-md-6">
      <h4><?= __('Related Managers')?></h4>
    </div>
    <div class="col-md-6 text-right">
      <?= $this->Html->link(__('Add new'), ['action' => 'addVendorManager'],['class'=>'btn btn-primary pull-right']); ?></div>
    </div>



    <?php if (!empty($vendor->vendor_managers)): ?>

    <div class="row table-th hidden-xs">        
      <div class="col-lg-4 col-md-4 col-sm-4">
        <?= __('Name'); ?>
      </div>      
      <div class="col-lg-2 col-md-2 col-sm-2 text-center">
        <?= __('Primary Manager'); ?>
      </div>
      <div class="col-lg-6 col-md-6 col-sm-6">

      </div>
    </div>

    <?php 
    $j=0;
    foreach ($vendor->vendor_managers as $vendorManagers): $j++;
    ?>

    <div class="row inner hidden-xs">

      <div class="col-lg-4 col-md-4 col-sm-4">
        <?= h($vendorManagers['user']->full_name) ?>
      </div>  

      <div class="col-lg-2 col-md-2 col-sm-2 text-center">
        <?php if($vendorManagers->primary_manager == 'Y'){?>
        <span class="fa fa-check"></span> <?php
      } ?>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6">
      <div class="dropdown pull-right">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
          Manage
          <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

          <li>         <?= $this->Html->link('<i class="icon ion-eye"></i> '.__('View'), ['controller' => 'Vendors', 'action' => 'viewManager', $vendorManagers->id], ['escape' => false]);
          if($vendorManagers->primary_manager != 'Y'){
            echo $this->Form->postLink(__('Make Primary'), ['controller' => 'Admins', 'action' => 'changePrimaryVmanager', $vendorManagers->id, $vendor->id], ['confirm' => __('Are you sure you want to change the Primary Vendor Manager?', $vendorManagers->id, $vendor->id)]);?>
            <?php  
          }
          ?></li>
          <li><?= $this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['controller' => 'Vendors', 'action' => 'editManager', $vendorManagers->id], ['escape' => false]);?></li>
        </ul>
      </div>


    </div>

  </div>


  <!-- For mobile view only -->
  <div class="row inner visible-xs">

    <div class="col-xs-12 text-center">

      <a data-toggle="collapse" data-parent="#accordion" href="#vmanagers-<?= $j ?>">

        <h3><?= h($vendorManagers['user']->full_name) ?></h3>

      </a>    

    </div> <!--col-->

    <div id="vmanagers-<?= $j ?>" class="col-xs-12 panel-collapse collapse">

      <div class="row inner">
        <div class="col-xs-6"><?= __('Name'); ?></div>
        <div class="col-xs-6"><?= h($vendorManagers['user']->full_name) ?></div>
      </div>
      <div class="row inner">
        <div class="col-xs-6"><?= __('Primary Manager'); ?></div>
        <div class="col-xs-6">
          <?php if($vendorManagers->primary_manager == 'Y'){?>
          <span class="glyphicon glyphicon-ok"></span> <?php
        } ?>
      </div>
    </div>
    <div class="row inner">
      <div class="col-xs-6"><?= __('Created'); ?></div>
      <div class="col-xs-6"><?= h(date('d/m/Y',strtotime($vendorManagers->created_on))); ?></div>
    </div>
    <div class="row inner">                     
      <div class="col-xs-6"><?= __('Modified'); ?></div>
      <div class="col-xs-6"><?= h(date('d/m/Y',strtotime($vendorManagers->modified_on))); ?></div>
    </div>
    <div class="row inner">
      <div class="col-xs-12">
        <div class="btn-group pull-right">
          <?= $this->Html->link(__('View'), ['controller' => 'Vendors', 'action' => 'viewManager', $vendorManagers->id],['class'=>'btn pull-right']); ?>
          <?= $this->Html->link(__('Edit'), ['controller' => 'Vendors', 'action' => 'editManager', $vendorManagers->id],['class'=>'btn pull-right']);
          if($vendorManagers->primary_manager != 'Y'){
            echo $this->Form->postLink(__('Make Primary'), ['controller' => 'Admins', 'action' => 'changePrimaryVmanager', $vendorManagers->id, $vendor->id],['class'=>'btn pull-right'], ['confirm' => __('Are you sure you want to change the Primary Vendor Manager?', $vendorManagers->id, $vendor->id)]);?>
            <?php  
          }
          ?>
        </div>
      </div>
    </div>

  </div> <!-- /.collapse -->              

</div> <!-- /.row -->


<?php endforeach; ?>

<?php endif; ?>


</div> <!-- /.vendors.view -->      

<!-- Modal -->
<div class="modal fade" id="package-details" tabindex="-1" role="dialog" aria-labelledby="Subscription package details" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <p class="modal-title"><strong><?= __('Subscription package: '); ?><?= h($vendor['subscription_package']->name); ?></strong></p>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-6 col-md-offset-2 col-sm-6 col-sm-offset-2 col-xs-9">
            <p><?= __('Annual price'); ?></p>
          </div>
          <div class="col-md-2 col-sm-2 col-xs-3 text-right">
            <p>
              <?= __('$'); ?>
              <?= $this->Number->precision($vendor['subscription_package']->annual_price, 2); ?>
            </p>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-6 col-md-offset-2 col-sm-6 col-sm-offset-2 col-xs-9">
            <p><?= __('Monthly price'); ?></p>
          </div>
          <div class="col-md-2 col-sm-2 col-xs-3 text-right">
            <p>
              <?= __('$'); ?>
              <?= $this->Number->precision($vendor['subscription_package']->monthly_price, 2); ?>
            </p>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-6 col-md-offset-2 col-sm-6 col-sm-offset-2 col-xs-9">
            <p><?= __('Maximum no. of emails/month'); ?></p>
          </div>
          <div class="col-md-2 col-sm-2 col-xs-3 text-right">
            <p><?= $this->Number->precision($vendor['subscription_package']->no_emails, 0); ?></p>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-6 col-md-offset-2 col-sm-6 col-sm-offset-2 col-xs-9">
            <p><?= __('Maximum no. of partners'); ?></p>
          </div>
          <div class="col-md-2 col-sm-2 col-xs-3 text-right">
            <p><?= $this->Number->precision($vendor['subscription_package']->no_partners, 0); ?></p>
          </div>
          <div class="clearfix"></div>
          <div class="col-md-6 col-md-offset-2 col-sm-6 col-sm-offset-2 col-xs-9">
            <p><?= __('Storage capacity (GB)'); ?></p>
          </div>
          <div class="col-md-2 col-sm-2 col-xs-3 text-right">
            <p><?= $this->Number->precision($vendor['subscription_package']->storage, 0); ?></p>
          </div>
          <div class="clearfix"></div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->          




<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
          <?php
          $this->Html->addCrumb('Company profile', ['controller' => 'vendors', 'action' => 'profile']);
          echo $this->Html->getCrumbs(' / ', [
            'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
            'url' => ['controller' => 'Vendors', 'action' => 'index'],
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

