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
                                <h2 class="card--title"><?= __('Edit Partner Group')?></h2>
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
<?= $this->Form->create($partnerGroup,['class'=>'validatedForm']); ?>
<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
    <fieldset>
        
        <?php
            $auth = $this->Session->read('Auth');
        echo $this->Form->hidden('vendor_id', ['value' => $auth['User']['vendor_id']]);
        echo $this->Form->input('id');
          ?>
        <!-- form input content -->
    <div class="row input--field">
        <div class="col-md-3">
            <label>Name</label>
        </div>
        <div class="col-md-6" id="input--field">
            <?php echo $this->Form->input('name', array(
            'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
        </div>

    </div>
    <!-- form input content -->

    </fieldset>
    
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
            $this->Html->addCrumb('edit', ['controller' => 'PartnerGroups', 'action' => 'edit', $partnerGroup->id]);
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
        <?= $this->Form->button(__('Submit'),['class'=> 'btn btn-primary']); ?>
<?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->