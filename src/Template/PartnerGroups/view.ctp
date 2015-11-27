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
                                <i class="icon ion-person-stalker"></i></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('Partner Group'); ?></h2>
                                <h3 class="card--subtitle"></h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">
                                <?= $this->Html->link(__('Add new'), ['controller' => 'PartnerGroups','action' => 'add'],['class'=>'btn btn-primary pull-right']); ?>
                            </div>
                        </div>   
                    </div>
                </div>
                    <div class="card-content">
<!--
<div class="row">
<div class="col-md-12">
<h4>Campaign Overview</h4>
<p>Breakdown of all campaigns to date, showcasing their status, how many partners have applied for the campaign, how many approved, how many have executed and the results seen to date.
</p>
<hr>
</div>
</div>
-->

<!-- content below this line -->
 <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  <div class="header--row">
    <div class="row inner">
    
        <dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
            <?= h($partnerGroup->name); ?>
        </dt>
        
        <dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
        <li><?= $this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['action' => 'edit', $partnerGroup->id], ['escape' => false]); ?></li>

    <li><?= $this->Form->postLink('<i class="icon ion-trash-a"></i> '.__('Delete'), ['action' => 'delete', $partnerGroup->id], ['escape' => false], ['confirm' => __('Are you sure you want to delete?', $partnerGroup->id)]); ?></li>
  </ul>
</div>

        </dd>
        
    </div>

    <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= __('Vendor'); ?>
    </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $this->Html->link($partnerGroup['vendor']->company_name, ['controller' => 'Vendors', 'action' => 'view', $partnerGroup->vendor->id]); ?>
        </dd>
    </div>
</div>

<div class="row">
<div class="col-md-12">
<h4><?= __('Related Partners'); ?></h4>

<hr>
</div>
</div>

    <div class="row related">
        <div class="col-lg-9 col-md-8 col-sm-6 col-xs-8">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-4">
            <?= $this->Html->link(__('Add new'), ['controller' => 'Vendors', 'action' => 'addPartner'],['class'=>'btn btn-primary pull-right']); ?>
        </div>  
    </div>

    <?php if ($partnerGroupMembers->count()>0): ?>
        
    
    <div class="row table-th hidden-xs">    
               
        <div class="col-lg-3 col-md-3 col-sm-3">
            <?= __('Company Name'); ?>
        </div>      
        
        <div class="col-lg-2 col-md-2 col-sm-2">
            <?= __('Phone'); ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2">
            <?= __('Website'); ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3">
      <?= __('E-mail'); ?>
        </div>
    </div>
    
    <?php 
    $j = 0;
    foreach ($partnerGroupMembers as $member): $j++;
    $partners = $member->partner;
  ?>

    <div class="row inner hidden-xs">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <?= h($partners->company_name) ?>
        <?php if(trim($partners->logo_url) != ''){ ?>       

                <a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image('logos/'.$partners->logo_url)?>'>
                    <i class="fa fa-info-circle"></i>
                </a>

        <?php } ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
            <?php 
                if (h($partners->website)!='') {
            ?>
            <?= $this->Html->link(h($partners->website), h($partners->website),['target' => '_blank']); ?> <i class="fa fa-external-link"></i>
            <?php
                }
            ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4">
<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><?= $this->Html->link('<i class="icon ion-eye"></i> '.__('View'), ['controller' => 'Vendors', 'action' => 'viewPartner', $partners->id], ['escape' => false]); ?></li>
    <li><?= $this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['controller' => 'Vendors', 'action' => 'editPartner', $partners->id], ['escape' => false]); ?></li>
  </ul>
</div>

        </div>
    </div>

    <!-- For mobile view only -->
    <div class="row inner visible-xs">
    
        <div class="col-xs-12 text-center">
            <a data-toggle="collapse" data-parent="#accordion" href="#coupons-<?=$j?>">
                <h3><?= h($partners->company_name) ?></h3>
            </a>                        
        </div>
                    
        <div id="coupons-<?=$j?>" class="col-xs-12 panel-collapse collapse">
        
            <div class="row inner">
                <div class="col-xs-6">
                    <?= __('logo'); ?>
                </div>
                <div class="col-xs-6">
                <?php if(trim($partners->logo_url) != ''){ ?>       
                        <div class="image-preview">
                            <?= $this->Html->image('logos/'.$partners->logo_url)?>
                        <div><?= $this->Html->image('logos/'.$$partners->logo_url)?></div>
                    </div>
                <?php } ?>
                </div>
            </div>
            
            <div class="row inner">
                <div class="col-xs-6">
                    <?= __('Phone'); ?>
                </div>
                <div class="col-xs-6">
                    <?= h($partners->phone) ?>
                </div>
            </div>
            
            <div class="row inner">
                <div class="col-xs-6">
                    <?= __('Fax'); ?>
                </div>
                <div class="col-xs-6">
                    <?= h($partners->fax) ?>
                </div>
            </div>
            <div class="row inner">
                <div class="col-xs-6">
                    <?= __('Website'); ?>
                </div>
                <div class="col-xs-6">
                    <?= h($partners->website) ?>
                </div>
            </div>
            <div class="row inner">
                <div class="col-xs-6">
                    <?= __('E-mail'); ?>
                </div>
                <div class="col-xs-6">
                    <?= h($partners->email) ?>
                </div>
            </div>
                   
        
        </div> <!-- /.collapse -->              
                
    </div> <!-- /.row -->
    
    
    <?php endforeach; ?>

    <?php else:?>
    
    
    <div class="row inner withtop">
        <div class="col-sm-12 text-center">
            <?= __('No related partners found') ?>
        </div>
    </div>
        
        
    <?php endif;?>
</div>    
<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               
                   <?php
                    $this->Html->addCrumb('Partners', ['controller' => 'vendors', 'action' => 'partners']);
                    $this->Html->addCrumb('Partner groups', ['controller' => 'PartnerGroups', 'action' => 'index']);
                    $this->Html->addCrumb('view', ['controller' => 'PartnerGroups', 'action' => 'view', $partnerGroup->id]);
                    echo $this->Html->getCrumbs(' / ', [
                        'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
                        'url' => ['controller' => 'Vendors', 'action' => 'index'],
                        'escape' => false
                    ]);
                ?>
                    </li>
                </ol>
            </div>
            <div class="col-md-6">
   <?= $this->Html->link(__('Back'), ['action' => 'index'], ['class'=>'pull-right btn btn-primary']); ?>                            </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->