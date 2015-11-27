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
                                    <i class="icon ion-funnel"></i></div>
                                </div>
                                <div class="card--info">
                                    <h2 class="card--title"><?= __('Add Lead')?></h2>
                                    <h3 class="card--subtitle">Manually Input New Lead Details</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="card--actions">
<!--
<div class="dropdown pull-right">
<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
Menu
<span class="caret"></span>
</button>
<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
<li><?= $this->Html->link(__('Add Lead'), ['action' => 'add']); ?></li>
<li><?= $this->Html->link(($salesforce_isauth?__('SalesForce Connected'):__('Connect to SalesForce')), ['controller'=>'ExternalApps','action'=>'salesforceInitialize'],['disabled'=>($salesforce_isauth?'true':'false')]); ?></li>
</ul>
</div> -->
</div>
</div>
</div>   
</div>
<div class="card-content">
    <div class="container--fluid">
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

<?= $this->Form->create($lead,['class'=>'validatedForm','type'=>'file']); ?>

<fieldset>

    <?php
    $auth = $this->Session->read('Auth');
    echo $this->Form->hidden('vendor_id', ['value' => $auth['User']['vendor_id']]);
    ?>

    <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>First Name</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('first_name', array(
            'div'=>false, 'label'=>false, 'placeholder' => 'first name', 'class' => 'form-control')); ?>
        </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>Last Name</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('last_name', array(
            'div'=>false, 'label'=>false, 'placeholder' => 'last name', 'class' => 'form-control')); ?>
        </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>Company</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('company', array(
            'div'=>false, 'label'=>false, 'placeholder' => 'company', 'class' => 'form-control')); ?>
        </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>Position</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('position', array(
            'div'=>false, 'label'=>false, 'placeholder' => 'position', 'class' => 'form-control')); ?>
        </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>Telephone</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('phone', array(
            'div'=>false, 'label'=>false, 'placeholder' => 'telephone', 'class' => 'form-control')); ?>
        </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>Email</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('email', array(
            'div'=>false, 'label'=>false, 'placeholder' => 'john@example.com', 'class' => 'form-control','type'=>'email')); ?>
        </div>

    </div>
    <!-- form input content -->


    <div class="row">
        <div class="col-md-12">
            <h4><?= __('Assign Lead')?></h4>
            <p>Choose the partner you wish to assign this lead to, set an SLA time period for accepting / rejecting the lead and any comments.
            </p>
            <hr>
        </div>
    </div>

    <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>Assigned partner</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('partner_id', array(
            'div'=>false, 'label'=>false, 'class' => 'form-control', 'options' => $partners,'data-live-search' => true)); ?>
        </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>Lead response (days)</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('response_time', array(
            'div'=>false, 'label'=>false, 'class' => 'form-control','value'=>30,'type'=>'number')); ?>
        </div>

    </div>
    <!-- form input content -->
    <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>Comments</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('note', array(
            'div'=>false, 'label'=>false, 'class' => 'form-control','type'=>'textarea')); ?>
        </div>

    </div>
    <!-- form input content -->


</fieldset>


<!-- /content below this line -->

</div></div><!-- /container-fluid -->

<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               
                    <?php
                    $this->Html->addCrumb('Leads', ['controller' => 'leads', 'action' => 'index']);
                    $this->Html->addCrumb('add', ['action' => 'add']);
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
                <?= $this->Form->button(__('Submit'),['class'=> 'pull-right btn btn-primary']); ?>

                <?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'pull-right btn btn-cancel btn-default']); ?>  
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->
<?= $this->Form->end(); ?>
