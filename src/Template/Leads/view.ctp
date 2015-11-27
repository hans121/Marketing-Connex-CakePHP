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
                                    <h2 class="card--title"><?= __('View Lead'); ?></h2>
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


<div class="folders view">



    <div class="row inner">

        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            Name
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= h($lead->first_name . ' ' . $lead->last_name) ?>
        </dd>





    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Company'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $lead->company; ?>
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Position'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $lead->position; ?>
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Phone'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $lead->phone; ?>
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Email'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $lead->email; ?>
        </dd>
    </div>
    
    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Partner Response'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?php
			    if($lead->response)
			        echo $lead->response;
			    else
			        echo 'unresponded';
			        
			    if($lead->response=='accepted')
			    {
			    	if($lead->response_status)
			    		echo ' | '.$lead->response_status;
			    }    
		    ?>
        </dd>
    </div>

	<div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Response Note'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
       		<?=($lead->response_note?date('d-m-Y',strtotime($lead->modified_on)).'<br />':'')?>
            <?=$lead->response_note?>
        </dd>
    </div>

    <div class="row">
        <div class="col-md-12">
        	<br />
        	<button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
			  Show Response Note History
			</button>
			<br /><br />
			<div class="collapse" id="collapseExample">
			  <div class="well">
			      <div class="row table-th hidden-xs">
					    <div class="col-md-2">
					      <?= __('Date'); ?>
					    </div>  
					    <div class="col-md-2">
					      <?= __('Response'); ?>
					    </div>
					    <div class="col-md-8">
					      <?= __('Response Note'); ?>
					    </div>
				  </div> <!-- /.row -->
				  <?php
				  foreach($lead->lead_response_notes as $leadnote):
				  ?>
				    <!-- Start loop -->
				    <div class="row inner hidden-xs">
				      <div class="col-lg-2">
				        <?= $leadnote->created_on; ?>
				      </div>  
				      <div class="col-lg-2">
				        <?= $leadnote->response.($leadnote->response_status?' | '.$leadnote->response_status:''); ?>
				      </div>
				      <div class="col-lg-8">
				        <?= $leadnote->response_note; ?>
				      </div>
				    </div> <!--row-->
				   <?php
				   endforeach;
				   ?>
			  </div>
			</div>
        </div>
    </div>

    <!-- Assigned to: -->
    <div class="row">
        <div class="col-md-12">
            <h4>Assigned to</h4>
            <p>Choose the partner you wish to assign this lead to, set an SLA time period for accepting / rejecting the lead and any comments.
            </p>
            <hr>
        </div>
    </div>

	<?php
	if($lead->assigned):
	?>
    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Partner'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $lead->partner->company_name; ?>
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Response Time'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= $lead->response_time; ?> days
        </dd>
    </div>

    <div class="row inner">   
        <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <?= __('Notes'); ?>
        </dt>
        <dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
            <?= nl2br($lead->note); ?>
        </dd>
    </div>
    
	<?php
	else:
	?>
	<div class="row inner">
		<div class="col-lg-12"><h6>Not yet assigned to a partner</h6></div>
	</div>
	<?php
	endif;
	?>
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
                    $this->Html->addCrumb('Leads', ['controller' => 'leads', 'action' => 'index']);
                    if($lead->response=='rejected' || $lead->response=='' || ($lead->response=='accepted' && $lead->response_status=='qualifiedout'))
                    	$this->Html->addCrumb('edit', ['action' => 'edit',$lead->id]);
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
