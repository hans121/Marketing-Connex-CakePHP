<?php 
$this->layout = 'admin--ui';
$admn = $this->Session->read('Auth');
$my_currency    =   $admn['User']['currency'];
$this->set(compact('my_currency'));
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
                                <div class="section__circle-container__circle mdl-color--primary"></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('View Deal'); ?></h2>
                                <h3 class="card--subtitle">Lead Deal Information</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">

</div>
</div>
</div>   
</div>
<div class="card-content">
    <div class="container--fluid">

        <!-- content below this line -->


<div class="folders view">


	<div class="row">
	    <div class="col-md-12">
	        <h4>Lead Info</h4>
	    </div>
	</div>


    <div class="row inner">

    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        Name
    </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($deal->lead->first_name . ' ' . $deal->lead->last_name) ?>
        </dd>
        
    </div>

    <div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        <?= __('Company'); ?>
    </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $deal->lead->company; ?>
        </dd>
    </div>
    
    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Position'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $deal->lead->position; ?>
        </dd>
    </div>
    
    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Phone'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $deal->lead->phone; ?>
        </dd>
    </div>
    
    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Email'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $deal->lead->email; ?>
        </dd>
    </div>
    
    <!-- Assigned to: -->
            <div class="row">
            <div class="col-md-12">
                <h4>Partner Info</h4>
            </div>
        </div>
    
        
    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Partner'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $deal->partner->company_name; ?>
        </dd>
    </div>
    
    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Partner Manager'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $deal->partner_manager->user->first_name . ' ' . $deal->partner_manager->user->last_name; ?>
        </dd>
    </div>
    
    <!-- Deal Details -->
    <div class="row">
	    <div class="col-md-12">
	        <h4>Deal Info</h4>
	    </div>
	</div>


    <div class="row inner">

    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        Product Description
    </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($deal->product_description) ?>
        </dd>
        
    </div>
    
    <div class="row inner">

    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        Quantity Sold
    </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($deal->quantity_sold) ?>
        </dd>
        
    </div>
    
    <div class="row inner">

    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        Deal Value
    </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $this->Number->currency(round($deal->deal_value),$my_currency,['places'=>0]);?>
        </dd>
        
    </div>
    
    <div class="row inner">

    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        Deal Closed
    </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($deal->status=='Y'?'Yes':'No') ?>
        </dd>
        
    </div>
    
    <div class="row inner">

    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
        Closure Date
    </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?php  
            	if($deal->status=='Y')
            		echo date('d/m/Y',strtotime($deal->closure_date));
            	else
            		echo '------'; 
            ?>
        </dd>
        
    </div>
    
</div>

        <!-- /content below this line -->

    </div></div><!-- /container-fluid -->

    <div class="card-footer">
        <div class="row">
            <div class="col-md-6">
                <!-- breadcrumb -->
                <ol class="breadcrumb">
                    <li>               
<?php
                    $this->Html->addCrumb('Deals', ['controller' => 'deals', 'action' => 'index']);
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
                            <?= $this->Html->link(__('Back'), 'javascript:history.back()',['class'=>'btn btn-primary pull-right']); ?>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<!-- /Card -->
