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
                  <i class="icon ion-plus"></i></div>
                </div>
                <div class="card--info">
                  <h2 class="card--title"><?= __('Leads'); ?></h2>
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
<h4>Campaign Options</h4>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
</p>
<hr>
</div>
</div>
-->
<!-- content below this line -->

<div class="vendorManagers index">


  
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  



<div class="row">
<div class="col-md-12">
    <?= $this->Form->create(null,['url'=>['controller'=>'PartnerLeads','action'=>'index'],'type'=>'post']); ?>

<div class="col-lg-8 col-lg-offset-2"><div class="input-group"><?= $this->Form->input('query', ['label'=>false,'placeholder'=>'Search Leads','class'=>'form-control']);?> <span class="input-group-btn"><?= $this->Form->button('<span class="fa fa-search"></span>',['class'=> 'btn btn-search btn-primary']); ?></span></div></div>
  <?= $this->Form->end(); ?>


</div>
</div>

<hr>
  <div class="row table-th hidden-xs">
    <div class="col-md-2">
      <?= $this->Paginator->sort('company','Company'); ?>
    </div>  
    <div class="col-md-2">
      <?= $this->Paginator->sort('first_name','Name'); ?>
    </div>
    <div class="col-md-2">
      <?= $this->Paginator->sort('email','Email'); ?>
    </div>
    <div class="col-md-1 text-center">
      <?= $this->Paginator->sort('expire_on','Expires'); ?>
    </div>
    <div class="col-md-2 text-center">
      <?= __('Manager Assigned'); ?>
    </div>
    <div class="col-md-2">
    	<?= $this->Paginator->sort('response_status','Response'); ?>
    </div>
    <div class="col-md-1">
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
      <div class="col-lg-2">
        <?= $lead->email; ?>
      </div>
      <div class="col-lg-1 text-center">
        <?php
          $expiry_time = strtotime($lead->expire_on);
          if($expiry_time)
          {
            $expiry = date('d/m/Y',$expiry_time);
            $days_before_expiry = round(($expiry_time - time()) / 86400);
            if($days_before_expiry >= 15)
              $color = 'green'; //new
            elseif($days_before_expiry >= 5)
              $color = 'orange'; //middle
            else
              $color = 'red'; //old
                    
            echo '<span style="color:'.$color.'">'.$expiry.'</span>'; 
          }
          else
            echo '-----';
        ?>
      </div>
      <div class="col-lg-2 text-center">
        <?php
          if($user = $lead->lead_deal->partner_manager->user)
            echo $user['first_name'].' '.$user['last_name'];
          else
            echo '-----------';
        ?>
      </div>
      <div class="col-lg-2">
        <?=($lead->response?$lead->response.($lead->response_status?'|'.$lead->response_status:''):'unresponded')?>
      </div>
      <div class="col-lg-1">

<div class="dropdown pull-right">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    manage
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
    <li><?= $lead->response_status=='converted'?'':$this->Html->link(__('Edit'), ['action' => 'edit',$lead->id]); ?></li>
    <li><?= $this->Html->link(__('View'), ['action' => 'view',$lead->id]); ?></liv>
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
            <?= __('Expires')?>
          </div>
          <div class="col-xs-7">
            <?php
              $expiry_time = strtotime($lead->expire_on);
              if($expiry_time)
              {
                $expiry = date('d/m/Y',$expiry_time);
                $days_before_expiry = round(($expiry_time - time()) / 86400);
                if($days_before_expiry >= 15)
                  $color = 'green'; //new
                elseif($days_before_expiry >= 5)
                  $color = 'orange'; //middle
                else
                  $color = 'red'; //old
                        
                echo '<span style="color:'.$color.'">'.$expiry.'</span>'; 
              }
              else
                echo '-----';
            ?>
          </div>
        </div>
        
        <div class="row inner">
          <div class="col-xs-5">
            <?= __('Manager Assigned')?>
          </div>
          <div class="col-xs-7">
            <?php
              if($user = $lead->lead_deal->partner_manager->user)
                echo $user['first_name'].' '.$user['last_name'];
              else
                echo '-----------';
            ?>
          </div>
        </div>

        <div class="row inner">
          <div class="col-xs-12">
            <div class="btn-group pull-right">
              <?= $this->Html->link(__('Edit'), ['action' => 'edit',$lead->id],['class' => 'btn pull-right']); ?>
              <?= $this->Html->link(__('View'), ['action' => 'view',$lead->id],['class' => 'btn pull-right']); ?>
            </div>
          </div>
        </div>
              
      </div> <!-- /.collapse -->
      
    </div> <!-- /.row -->
      
  <?php endforeach; ?>

  <?php echo $this->element('paginator'); ?>
  
  </div><!--row table-th-->
  


<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
                  <?php
          $this->Html->addCrumb('Leads', ['controller' => 'PartnerLeads', 'action' => 'index']);
          echo $this->Html->getCrumbs(' / ', [
              'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
              'url' => ['controller' => 'Partners', 'action' => 'index'],
              'escape' => false
          ]);
        ?>
          </li>
        </ol>
      </div>
      <div class="col-md-6 text-right">
        <?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>         


      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->

