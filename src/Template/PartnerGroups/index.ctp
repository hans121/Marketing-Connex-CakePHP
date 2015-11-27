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
                                    <h2 class="card--title"><?= __('Partner Groups'); ?></h2>
                                    <h3 class="card--subtitle"></h3>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="card--actions">
                                    <?= $this->Html->link(__('Add new'), ['action' => 'add'], ['class'=>'pull-right btn btn-primary']); ?>                            </div>
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

<!-- Are there any groups? -->
<?php
if(count($partnerGroups)>0)
{
    ?>

    <div class="row table-th hidden-xs">    
        <div class="clearfix"></div>    


        <div class="col-xs-8">
            <?= $this->Paginator->sort('name'); ?>
        </div>

        <div class="col-xs-4">

        </div>

    </div> <!--row-table-th-->

    <?php 
    $j =0;
    foreach ($partnerGroups as $partnerGroup): 
        $j++;
    ?>
    <!-- Start loop -->
    <div class="row inner hidden-xs">

        <div class="col-xs-8">
            <?= h($partnerGroup->name); ?>
        </div>


        <div class="col-xs-4">
            <div class="dropdown pull-right">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Manage
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li> <?= $this->Html->link('<i class="icon ion-eye"></i> '.__('View'), ['action' => 'view', $partnerGroup->id], ['escape' => false]); ?> </li>
                    <li> <?= $this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['action' => 'edit', $partnerGroup->id], ['escape' => false]); ?></li>
                    <li><?= $this->Form->postLink('<i class="icon ion-trash-a"></i> '.__('Delete'), ['action' => 'delete', $partnerGroup->id], ['escape' => false], ['confirm' => __('Are you sure you want to delete # %s?', $partnerGroup->id)]); ?></li>
                </ul>
            </div>
        </div>  
    </div> <!--row-->

    <div class="row inner visible-xs">

        <div class="col-xs-12 text-center">

            <a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
                <h3><?= h($partnerGroup->name); ?></h3>
            </a>

        </div> <!--col-->

        <div id="basic<?= $j ?>" class="panel-collapse collapse">

            <div class="col-xs-12"><strong><?= __('ID:')?></strong> <?= $partnerGroup->id; ?></div>

            <div class="col-xs-12"><strong><?= __('Vendor:')?></strong> <?= $this->Html->link($partnerGroup->vendor->company_name, ['controller' => 'Vendors', 'action' => 'view', $partnerGroup->vendor->id]); ?>
            </div>
            <div class="col-xs-12"><strong><?= __('Name:')?></strong><?= h($partnerGroup->name); ?>
            </div>

            <div class="col-xs-12"><strong><?= __('Date Created:')?></strong> <?= h($partnerGroup->created_on); ?></div>

            <div class="col-xs-12"><strong><?= __('Date Modified:')?></strong> <?= h($partnerGroup->modified_on); ?></div>

            <div class="col-xs-12">
                <div class="dropdown pull-right">
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Manage
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li>      <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $partnerGroup->id], ['confirm' => __('Are you sure you want to delete # %s?', $partnerGroup->id)]); ?></li>
                        <li> <?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerGroup->id]); ?></li>
                        <li> <?= $this->Html->link(__('View'), ['action' => 'view', $partnerGroup->id]); ?> </li>
                    </ul>
                </div>




            </div> <!--col-xs-12-->

        </div> <!--collapseOne-->

    </div> <!--row-->

    <?php

    endforeach;

} else {

    ?>

    <div class="row inner withtop">

        <div class="col-sm-12 text-center">
            <?=  __('No Partner Groups found') ?>
        </div>

    </div> <!--/.row.inner-->

    <?php

}

?>

<?php echo $this->element('paginator'); ?>

</div><!--row table-th-->








<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               
                    <?php
                    $this->Html->addCrumb('Partners', ['controller' => 'vendors', 'action' => 'partners']);
                    $this->Html->addCrumb('Partner groups', ['controller' => 'PartnerGroups', 'action' => 'index']);
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
                <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-primary pull-right']); ?> 

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->