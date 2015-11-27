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
                                    <h2 class="card--title"><?= __('Change Password'); ?></h2>
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
<div class="users form">

    <?php echo $this->Form->create($user,['url' => array('controller' => 'Users', 'action' => 'changepassword'),'class'=>'validatedForm']) ?>

    <fieldset>


        <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>


        <!-- form input content -->
        <div class="row input--field">
            <div class="col-md-3">
                <label>New Password</label>
            </div>
            <div class="col-md-6" id="input--field">
                <?php echo $this->Form->input('password', array(
                'div'=>false, 'label'=>false, 'class' => 'form-control', 'value'=>'')); ?>
            </div>

        </div>
        <!-- form input content -->
        <!-- form input content -->
        <div class="row input--field">
            <div class="col-md-3">
                <label>Confirm Password</label>
            </div>
            <div class="col-md-6" id="input--field">
                <?php echo $this->Form->input('conf_password', array(
                'div'=>false, 'label'=>false, 'class' => 'form-control', 'type'=>'password')); ?>
            </div>

        </div>
        <!-- form input content -->




    </fieldset>


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
            <?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>                 
            <?= $this->Form->button(__('Submit'),['class'=> 'btn btn-primary']); ?>
            <?php echo $this->Form->end(); ?>

        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<!-- /Card -->