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
                                    <i class="icon ion-funnel"></i>
                                </div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('Leads'); ?></h2>
                                <h3 class="card--subtitle">Inactive Marketing Leads <?= $this->Html->link(__('view active'), ['action' => 'index']); ?></h3>
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
                                        <li><?= $this->Html->link(__('Add Lead'), ['action' => 'add']); ?></li>
                                        <li><?= $this->Html->link(($salesforce_isauth?__('SalesForce Connected'):__('Connect to SalesForce')), ['controller'=>'ExternalApps','action'=>'salesforceInitialize'],['disabled'=>($salesforce_isauth?'true':'false')]); ?></li>
                                    </ul>
                                </div>                            </div>
                            </div>
                        </div>   
                    </div>
                    <div class="card-content">

                        <div class="row">
                            <div class="col-md-12">
                                <p>Here is a breakdown of your inactive marketing leads, highlighting which partners are working on these and when they were assigned.
                                </p>
                                <hr>
                            </div>
                        </div>

                        <!-- content below this line -->

                        <div class="vendorManagers index">

                            <?= $this->Form->create(null,['url'=>['controller'=>'Leads','action'=>'inactive'],'type'=>'post']); ?>
                            <div class="row table-title">
                                <div class="col-lg-3"><?=$this->Form->select('status', [''=>'Status (Assigned / Unassigned)','1'=>'Assigned','0'=>'Unassigned'],['default'=>'','class'=>'form-control']);?></div><div class="col-lg-4"><div class="input-group"><?= $this->Form->input('name', ['label'=>false,'placeholder'=>'Partner Name','class'=>'form-control']);?> <span class="input-group-btn"><?= $this->Form->button('<i class="icon ion-chevron-right"></i>',['class'=> 'btn btn-search btn-primary']); ?></span></div></div>
                            </div>
                            <hr>
                            <?= $this->Form->end(); ?>

                            <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

                            <div class="row table-th hidden-xs">
                                <div class="col-lg-2">
                                    <?= $this->Paginator->sort('company','Company'); ?>
                                </div>  
                                <div class="col-lg-2">
                                    <?= $this->Paginator->sort('first_name','Name'); ?>
                                </div>
                                <div class="col-lg-3">
                                    <?= $this->Paginator->sort('email','Email'); ?>
                                </div>
                                <div class="col-lg-1 text-center">
                                    <?= $this->Paginator->sort('created_on','Date Added'); ?>
                                </div>
                                <div class="col-lg-1 text-center">
                                    <?= $this->Paginator->sort('assigned_on','Assigned'); ?>
                                </div>
                                 <div class="col-lg-1 text-center">
                                    <?= $this->Paginator->sort('response','Response'); ?>
                                </div>
                                <div class="col-lg-2">
                                </div>

                            </div> <!-- /.row -->

                            <?php 
                            $j =0;
                            $auth =   $this->Session->read('Auth');
                            $auth_vendor_primary   =   $auth['User']['primary_manager'];
                            foreach ($leads as $lead): 
                                $j++;
                            ?>
                            <!-- Start loop -->
                            <div class="row inner hidden-xs">
                                <div class="col-lg-2">
                                    <?= $lead->company; ?>
                                </div>  
                                <div class="col-lg-2">
                                    <?= $lead->first_name . ' ' . $lead->last_name; ?>
                                </div>
                                <div class="col-lg-3">
                                    <?= $lead->email; ?>
                                </div>
                                <div class="col-lg-1 text-center">
                                    <?php
                                    $date_added = strtotime($lead->created_on);
                                    $days_date_added = round((time() - $date_added) / 86400);
                                    if($days_date_added < 5)
$color = 'green'; //new
elseif($days_date_added < 15)
$color = 'orange'; //middle
else
$color = 'red'; //old
?>
<?= '<span style="color:'.$color.'">'.date('d/m/Y',$date_added).'</span>'; ?>
</div>
<div class="col-lg-1 text-center">
    <?php
    $date_assigned = $lead->assigned_on; 
    if($lead->assigned=='1')
        echo date('d/m/Y',strtotime($date_assigned));
    else
        echo 'unassigned'; 
    ?>
</div>
<div class="col-lg-1 text-center">
    <?php
    if($lead->response)
        echo $lead->response;
    else
        echo 'unresponded'; 
        
    if($lead->response=='accepted')
    {
    	if($lead->response_status)
    		echo '|'.$lead->response_status;
    }
    ?>
</div>
<div class="col-lg-2">
    <div class="dropdown pull-right">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Manage
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
             <li><?= $this->Html->link('<i class="icon ion-eye"></i> '.__('View'), ['action' => 'view', $lead->id], ['escape' => false]); ?></li>
            <li><?= $lead->response=='rejected' || $lead->response=='' || ($lead->response=='accepted' && $lead->response_status=='qualifiedout')?$this->Html->link('<i class="icon ion-edit"></i> '.__('Edit'), ['action' => 'edit', $lead->id], ['escape' => false]):''; ?></li>

            <li><?= $this->Form->postLink('<i class="icon ion-trash-a"></i> '.__('Delete'), ['action' => 'delete', $lead->id], ['escape' => false], ['confirm' => __('Are you sure you want to delete lead?')]); ?></li>
        </ul>
    </div>



</div>  
</div> <!--row-->

<!-- For mobile view only -->
<div class="row inner visible-xs">

    <div class="col-xs-12 text-center">

        <a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">

            <h3><?= $lead->first_name. ' ' . $lead->last_name; ?></h3>

        </a>

    </div> <!--col-->

    <div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

        <div class="row inner">
            <div class="col-xs-5">
                <?= __('Company')?>
            </div>
            <div class="col-xs-7">
                <?= $lead->company; ?>
            </div>
        </div>

        <div class="row inner">
            <div class="col-xs-5">
                <?= __('Email')?>
            </div>
            <div class="col-xs-7">
                <?= $lead->email; ?>
            </div>
        </div>

        <div class="row inner">
            <div class="col-xs-5">
                <?= __('Date Added')?>
            </div>
            <div class="col-xs-7">
                <?php
                $date_added = strtotime($lead->created_on);
                $days_date_added = round((time() - $date_added) / 86400);
                if($days_date_added < 5)
$color = 'green'; //new
elseif($days_date_added < 15)
$color = 'orange'; //middle
else
$color = 'red'; //old
?>
<?= '<span style="color:'.$color.'">'.date('d/m/Y',$date_added).'</span>'; ?>
</div>
</div>
<div class="row inner">
    <div class="col-xs-5">
        <?= __('Assigned')?>
    </div>
    <div class="col-xs-7">
        <?php
        $date_assigned = $lead->partner_lead->created_on; 
        if($date_assigned)
            echo date('d/m/Y',strtotime($date_assigned));
        else
            echo 'unassigned'; 
        ?>
    </div>
</div>
<div class="row inner">
    <div class="col-xs-5">
        <?= __('Response')?>
    </div>
    <div class="col-xs-7">
	    <?php
	    if($lead->response)
	        echo $lead->response;
	    else
	        echo 'unresponded'; 
	    ?>
    </div>
</div>
<div class="row inner">
    <div class="col-xs-12">
        <div class="dropdown pull-right">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Manage
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $lead->id]); ?></li>
                <li><?= $this->Html->link(__('View'), ['action' => 'view', $lead->id]); ?></li>
                <li><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $lead->id], ['confirm' => __('Are you sure you want to delete lead?')]); ?></li>
            </ul>
        </div>
    </div>
</div>

</div> <!-- /.collapse -->

</div> <!-- /.row -->

<?php endforeach; ?>

<?php echo $this->element('paginator'); ?>

</div><!--row table-th-->

</div> <!-- index?-->


<!-- /content below this line -->


<div class="card-footer">
    <div class="row">
        <div class="col-md-6">
            <!-- breadcrumb -->
            <ol class="breadcrumb">
                <li>               
                    <?php
                    $this->Html->addCrumb('Leads', ['controller' => 'leads', 'action' => 'index']);
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
                <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-primary pull-right']); ?>           </div>

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->
