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
                                    <i class="icon ion-compose"></i></div>
                                </div>
                                <div class="card--info">
                                    <h2 class="card--title"><?= __('Campaigns List')?></h2>
                                    <h3 class="card--subtitle">Campaign overview section</h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="card--actions">
                                    <?= $this->Html->link(__('Add new'), ['controller' => 'Campaigns', 'action' => 'add'], ['class' => 'btn btn-primary pull-right']); ?>
                                </div>
                            </div>
                        </div>   
                    </div>
                    <div class="card-content">
                        <div class="container--fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>Campaign Overview</h4>
                                    <p>Breakdown of all campaigns to date, showcasing their status, how many partners have applied for the campaign, how many approved, how many have executed and the results seen to date.
                                    </p>
                                    <hr>
                                </div>
                            </div>
                            <!-- content below this line -->


                            <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<?php // Does the user need to upgrade their package?  If so, display an appropriate message.

if(isset($prompt_upgrade) && $prompt_upgrade > 0):

    ?>

<div class="row table-title">

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <script>$(".alert").alert()</script>

        <div class="alert alert-warning fade in" role="alert">
            <button type="button" class="close" data-dismiss="alert">
                <span aria-hidden="true">×</span>
                <span class="sr-only">Close</span>
            </button>
            <h4>Time to consider an upgrade?</h4>
            <p>
                <?= $this->Number->toPercentage($send_details['usage_perc']).__(' of your allowed send limit for the financial quarter has been allocated. Please upgrade your package to increase your allowance')?>
            </p>
            <p>
                <?= $this->Html->link(__('Upgrade'), ['controller' => 'Vendors','action' => 'sendUpgrade'],['class' => 'btn btn-default']); ?>
            </p>
        </div>  

    </div>

</div> <!--row-table-title-->

<?php

endif;

?>

<!-- Are there any groups? -->
<?php
if(count($campaigns)>0)
{
    ?>

    <div class="row table-th hidden-xs">    

        <div class="clearfix"></div>
        <div class="col-lg-2 col-md-3 col-sm-5 col-xs-3"><?= $this->Paginator->sort('name') ?></div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-2"><?= $this->Paginator->sort('financialquarter_id','Quarter') ?></div>
        <div class="col-lg-1 hidden-md hidden-sm col-xs-1"><?= $this->Paginator->sort('campaign_type','Type') ?></div>
        <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 table-th_sm"><?= __('Plans approved (total)') ?></div>
        <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 table-th_sm"><?= __('Plans approved (partners)') ?></div>
        <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 table-th_sm"><?= __('Campaigns active') ?></div>
        <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 table-th_sm"><?= __('Campaigns not started') ?></div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 table-th_sm"><?= __('Deals registered') ?></div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-xs-4"></div>

    </div> <!--row-table-th-->

    <!-- Start loop -->

    <?php 
    $j =0;
    foreach ($campaigns as $campaign):
        $j++;
    ?>

    <div class="row inner hidden-xs">

        <div class="col-lg-2 col-md-3 col-sm-5 col-xs-3">
            <?= h($campaign->name) ?>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-3 col-xs-2">
            <?= $campaign->has('financialquarter') ? $this->Html->link($campaign->financialquarter->quartertitle, ['controller' => 'Financialquarters', 'action' => 'view', $campaign->financialquarter->id]) : '' ?>
        </div>
        <div class="col-lg-1 hidden-md hidden-sm col-xs-1">
            <?php
            if($campaign->campaign_type == 'e-mail'){ ?>
            <i class="fa fa-at"></i> <?= __('E-mail') ?>
            <?php
        } else if ($campaign->campaign_type == 'Royal Mail'){ ?>
        <i class="fa fa-envelope-o"></i> <?= __('Postal') ?>
        <?php
    } else if ($campaign->campaign_type == 'leaflet'){ ?>
    <i class="fa fa-copy"></i> <?= __('Leaflet') ?>
    <?php
} else { ?>
<?= h($campaign->campaign_type) ?>
<?php
}
?>
</div>

<?php
$bp_approved = 0;
$partners_bp_approved = array();
foreach($campaign->businesplan_campaigns as $bp_c)
    if($bp_c->businesplan->status=='Approved') {
        $bp_approved++;
        $partners_bp_approved[$bp_c->businesplan->partner_id]='';
    }
    ?>

    <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-center">
        <?=$bp_approved?>
    </div>
    <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-center">
        <?=count($partners_bp_approved)?>
    </div>

    <?php
    $partners_c_active = array();
    $partners_c_pending = array();
    foreach($campaign->partner_campaigns as $p_c)
        if($p_c->status=='A')
            $partners_c_active[$p_c->partner_id] = '';
        else
            $partners_c_pending[$p_c->partner_id] = '';
        ?>

        <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-center">
            <?=count($partners_c_active)?>
        </div>
        <div class="col-lg-1 col-md-1 hidden-sm col-xs-1 text-center">
            <?=count($partners_c_pending)?>
        </div>

        <?php
        $deals_cnt = 0;
        foreach($campaign->campaign_partner_mailinglists as $c_p_ml)
            foreach($c_p_ml->campaign_partner_mailinglist_deals as $c_p_ml_d)
                $deals_cnt++;
            ?>

            <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1 text-center">
                <?=$deals_cnt?>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">

                <div class="dropdown pull-right">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Manage
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu pull-left" aria-labelledby="dropdownMenu1">
                        <li><?= $this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['controller'=>'Campaigns','action' => 'edit', $campaign->id], ['escape' => false]); ?></li>
                        <li><?= $this->Html->link('<i class="icon ion-gear-b"></i> '.__('Manage'), ['controller'=>'Campaigns','action' => 'view', $campaign->id], ['escape' => false, 'title' => 'Export dashboard data']); ?></li>
                        <li> <?= $this->Form->postLink('<i class="icon ion-trash-a"></i> '.__('Delete'), ['action' => 'delete', $campaign->id], ['escape' => false, 'title' => 'Export dashboard data'], ['confirm' => __('Are you sure you want to delete?', $campaign->id)]); ?></li>
                    </ul>
                </div>



            </div>

        </div> <!--row-->


        <div class="row inner visible-xs">

            <div class="col-xs-12 text-center">

                <a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">

                    <h3><?= h($campaign->name) ?></h3>

                </a>

            </div> <!--col-->


            <div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

                <div class="row inner">

                    <div class="col-xs-6">
                        <?= __('Financial Quarter')?>
                    </div>

                    <div class="col-xs-6">
                        <?= $campaign->has('financialquarter') ? $this->Html->link($campaign->financialquarter->quartertitle, ['controller' => 'Financialquarters', 'action' => 'view', $campaign->financialquarter->id]) : '' ?>
                    </div>

                </div>

                <div class="row inner">

                    <div class="col-xs-6">
                        <?= __('Campaign Type')?>
                    </div>

                    <div class="col-xs-6">
                        <?php
                        if($campaign->campaign_type == 'e-mail'){ ?>
                        <i class="fa fa-at"></i> <?= __('E-mail') ?>
                        <?php
                    } else if ($campaign->campaign_type == 'Royal Mail'){ ?>
                    <i class="fa fa-envelope-o"></i> <?= __('Postal') ?>
                    <?php
                } else if ($campaign->campaign_type == 'leaflet'){ ?>
                <i class="fa fa-copy"></i> <?= __('Leaflet') ?>
                <?php
            } else { ?>
            <?= h($campaign->campaign_type) ?>
            <?php
        }
        ?>
    </div>

</div>

<div class="row inner">

    <div class="col-xs-6">
        <?= __('Campaign Plans approved (total)') ?>
    </div>

    <div class="col-xs-6">
        <?=$bp_approved?>
    </div>

</div>

<div class="row inner">

    <div class="col-xs-6">
        <?= __('Campaign Plans approved (partners)') ?>
    </div>

    <div class="col-xs-6">
        <?=count($partners_bp_approved)?>
    </div>

</div>

<div class="row inner">

    <div class="col-xs-6">
        <?= __('Campaign active (partners)') ?>
    </div>

    <div class="col-xs-6">
        <?=count($partners_c_active)?>
    </div>

</div>

<div class="row inner">

    <div class="col-xs-6">
        <?= __('Campaign not started (partners)') ?>
    </div>

    <div class="col-xs-6">
        <?=count($partners_c_pending)?>
    </div>

</div>

<div class="row inner">

    <div class="col-xs-6">
        <?= __('Deals registered') ?>
    </div>

    <div class="col-xs-6">
        <?=$deals_cnt?>
    </div>

</div>

<div class="row inner">

    <div class="col-xs-12">

        <div class="btn-group pull-right">
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $campaign->id], ['confirm' => __('Are you sure you want to delete?', $campaign->id),'class' => 'btn btn-danger pull-right']); ?>
            <?= $this->Html->link(__('Edit'), ['controller'=>'Campaigns','action' => 'edit', $campaign->id],['class' => 'btn pull-right']); ?>
            <?= $this->Html->link(__('View'), ['controller'=>'Campaigns','action' => 'view', $campaign->id],['class' => 'btn pull-right']); ?>                                       
        </div>

    </div>

</div>

</div>

</div> <!--row-->


<!-- End loop -->


<?php

endforeach;

} else {

    ?>

    <div class="row inner withtop">

        <div class="col-sm-12 text-center">
            <?=  __('No Campaigns found') ?>
        </div>

    </div> <!--/.row.inner-->

    <?php

}

?>

<?php echo $this->element('paginator'); ?>




</div>
</div><!-- /container-fluid -->
<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               
                    <?php
                    $this->Html->addCrumb('Campaigns', ['controller' => 'Campaigns', 'action' => 'index']);
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
                <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-primary btn-cancel']); ?>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->