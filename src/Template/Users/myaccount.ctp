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
                                    <i class="icon ion-gear-b"></i></div>
                                </div>
                                <div class="card--info">
                                    <h2 class="card--title"><?= __('User settings'); ?></h2>
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
<h4>Campaign Overview</h4>
<p>Breakdown of all campaigns to date, showcasing their status, how many partners have applied for the campaign, how many approved, how many have executed and the results seen to date.
</p>
<hr>
</div>
</div>
-->
<!-- content below this line -->
<div class="partners--view">

    
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

    <div class="row inner header-row ">
        <dt class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
            <?= h($user->title) ?> <?= h($user->full_name); ?>
        </dt>
        <dd class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                <?= $this->Html->link(__('Edit'), ['action' => 'editmyaccount'],['class' => 'btn btn-default pull-right']); ?> 
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Username') ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($user->username) ?>
        </dd>
    </div>
    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Job Title') ?>
        </dt>
        <dd class="col-lg-5 col-md-5 col-sm-4 col-xs-6">
          <?= h($user->job_title) ?>
        </dd>
        <dd class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="btn-group pull-right">
                </div>
        </dd>
    </div>
    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Phone') ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($user->phone) ?>
    </div>
    <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= __('Password') ?>
    </dt>
        <dd class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
            <?= __('**********') ?>
        </dd>
        <dd class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <?= $this->Html->link(__('Change Password'), ['action' => 'changepassword'],['class' => 'btn btn-default pull-right']) ?>
        </dd>
    </div>
    
</div>




</div>
<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               

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