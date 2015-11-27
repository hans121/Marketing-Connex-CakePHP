<?php 
$this->layout = 'admin--ui';
?>

<script type="text/javascript">

function exportdata(){
    document.location.href =  "<?php echo $this->Url->build([ "controller" => "Vendors","action" => "exportpartners"],true);?>/"+$('#keyword').val();   
}  
$(document).ready(function(){
    $('#exprtlst').click(function() {
        exportdata();
    });  
});
</script>
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
                                    <i class="icon ion-person-stalker"></i>
                                </div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('Partners')?></h2>
                                <h3 class="card--subtitle"></h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">
                                <div class="dropdown pull-right">
                                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                        Manage
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                        <li><?= $this->Html->link(__('Add Partner'), ['action' => 'addPartner']); ?></li>
                                        <li><?= $this->Html->link(__('Partner Groups'), ['controller' => 'PartnerGroups', 'action' => 'index']); ?></li>
                                        <li><?= $this->Html->link(__('Export'), ['escape' => false, 'title' => 'Export Partners into CSV','id'=>'exprtlst']); ?></li>
                                    </ul>
                                </div>                            </div>
                            </div>
                        </div>   
                    </div>
                    <div class="card-content">
<!--
<div class="row">
<div class="col-md-12">
<h4>Leads Overview</h4>
<p>Status of your active marketing leads, highlighting which partners are working on these leads and when they were assigned.
</p>
<hr>
</div>
</div>
-->
<!-- content below this line -->
<div class="row">

    <?php echo $this->element('filter-form'); ?>

</div>
<hr>

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<!-- Are there any groups? -->
<?php
if(count($partners)>0)
{
    ?>


    <div class="row table-th hidden-xs">

<!--<div class="col-xs-1">
<?= __('Logo')?>
</div>-->
<div class="col-md-3 col-sm-4">
    <?= $this->Paginator->sort('company_name'); ?>
</div>      
<div class="col-md-3 col-sm-4">
    <?= $this->Paginator->sort('country'); ?>
</div>
<div class="col-md-2 hidden-sm">
    <?= $this->Paginator->sort('city'); ?>
</div>
<div class="col-ms-4 col-sm-4">

</div>

</div> <!--row-table-th-->


<!-- Start loop -->

<?php 
$j =0;
foreach ($partners as $partner): 
    $j++;
?>

<div class="row inner hidden-xs">

    <div class="col-md-3 col-sm-4 text-left">
        <?php
        if(trim($partner->logo_url) != '') {
            ?>   
            <?= h($partner->company_name); ?>
            <a data-toggle="popover" data-html="true" data-content='<?= $this->Html->image($partner->logo_url)?>'>
                <i class="fa fa-info-circle"></i>
            </a>
            <?php
        } else {
            ?>
            <?= h($partner->company_name); ?>
            <?php
        }
        ?>
    </div>

    <div class="col-md-3 col-sm-4">
        <?= h($partner->country); ?>
    </div>

    <div class="col-md-2 hidden-sm">
        <?= h($partner->city); ?>
    </div>

    <div class="col-ms-4 col-sm-4">


        <div class="dropdown pull-right">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Manage
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-left" aria-labelledby="dropdownMenu1">
                <li><?= $this->Html->link('<i class="icon ion-eye"></i> '.__('View'), ['action' => 'viewPartner', $partner->id], ['escape' => false]); ?></li>
                <li><?= $this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['action' => 'editPartner', $partner->id], ['escape' => false]); ?></li>
                <li> <?= $this->Form->postLink('<i class="icon ion-trash-a"></i> '.__('Delete'), ['action' => 'deletePartner', $partner->id], ['escape' => false], ['confirm' => __('Are you sure you want to delete ?', $partner->id)]); ?></li>


            </ul>
        </div>


    </div>

</div> <!--row-->


<!-- For mobile view only -->
<div class="row inner visible-xs">

    <div class="col-xs-12 text-center">

        <a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">

            <h3><?= h($partner->company_name); ?></h3>

        </a>

    </div> <!--col-->

    <div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

        <div class="row inner">
            <div class="col-xs-5">
                <?= __('Location')?>
            </div>
            <div class="col-xs-7">
                <?= h($partner->city); ?>, <?= h($partner->country); ?>
            </div>
        </div>

        <div class="row inner">
            <div class="col-xs-5">
                <?= __('No. employees')?>
            </div>
            <div class="col-xs-7">
                <?= $this->Number->currency(h($partner->no_employees),['places'=>0]) ?>
            </div>
        </div>

        <div class="row inner">
            <div class="col-xs-5">
                <?= __('No. offices')?>
            </div>
            <div class="col-xs-7">
                <?= $this->Number->currency(h($partner->no_offices),['places'=>0]) ?>
            </div>
        </div>

        <div class="row inner">
            <div class="col-xs-5">
                <?= __('Total Annual Revenue')?>
            </div>
            <div class="col-xs-7">
                <?= $this->Number->currency(h($partner->total_a_revenue),'USD',['places'=>2]) ?>
            </div>
        </div>

        <div class="row inner">     
            <div class="col-xs-12">
                <div class="btn-group pull-right">
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'deletePartner', $partner->id], ['confirm' => __('Are you sure you want to delete ?', $partner->id),'class' => 'btn  btn-danger pull-right']); ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'editPartner', $partner->id],['class' => 'btn pull-right']); ?>
                    <?= $this->Html->link(__('View'), ['action' => 'viewPartner', $partner->id],['class' => 'btn pull-right']); ?>
                </div>
            </div>
        </div>

    </div> <!-- /.collapse -->

</div> <!-- /.row -->


<!-- End loop -->

<?php

endforeach;

} else {

    ?>

    <div class="row inner withtop">

        <div class="col-sm-12 text-center">
            <?=  __('No partners found') ?>
        </div>

    </div> <!--/.row.inner-->

    <?php

}

?>


<?php echo $this->element('paginator'); ?>

<!-- /content below this line -->

</div><!-- /container-fluid -->

<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               
                    <?php
                    $this->Html->addCrumb('Partners', ['controller' => 'vendors', 'action' => 'partners']);
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

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->