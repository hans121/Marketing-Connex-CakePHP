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
                  <h2 class="card--title"><?= __('New Campaign Plan');?></h2>
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


            <div class="row">
              <div class="col-md-6">
             

                <?php echo $this->Form->select('financialquarter_id', ['options' => $financialquarters, 'value'=> $fqid ,'data-live-search' => true,'error'=>false], ['class' => 'form-control']);?>

              </div>
              <div class="col-md-6">
                <?php 

                echo $this->Form->select('campaign_id', ['options' => $campaigns,'value'=>$bpcampaigns,'data-live-search' => false,'multiple'=>true], ['class' => 'form-control']);?>
              </div>
            </div>
            <hr>



<script type="text/javascript">
    
  function ajxcampaign(cmpid){
    var dataString = 'qtid='+$('#financialquarter-id').val()+'&cmpid='+cmpid;
    $.ajax ({
          type: "POST",
          url: "<?php echo $this->Url->build([ "controller" => "Businessplans","action" => "getcampaignsofquarter"],true);?>",
          data: dataString,
          cache: false,
          success: function(html)
          {
            $('#campaigngroups').html(html);
            $('#campaigngroups select').selectpicker();   
          }
    });
  }
  function ajaxcalcroi(){
      var selObj = $('#campaigngroups select').val();
      var dataString = 'campaigns='+selObj+'&expresult='+$('#expected-result').val();
      $.ajax ({
          type: "POST",
          url: "<?php echo $this->Url->build([ "controller" => "Businessplans","action" => "getreqamnt"],true);?>",
          data: dataString,
          cache: false,
          success: function(html)
          {
            $('#reqamt').html(html);
          }
      });
  }

  $(document).ready(function() {
    $('#campaigngroups').change(function() {
        ajaxcalcroi();
    });
    $('#expected-result').change(function() {
        ajaxcalcroi();
    });
    $('#financialquarter-id').change(function() {
        ajxcampaign();
    });

      ajxcampaign(<?=$cmpid?>);

  });
</script>

<?= $this->Form->create($businesplan); ?>




            <div class="Campaigns form">

              <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>


              <div class="row">
                <div class="col-md-12">
                  <h4><?= __('Application details')?></h4>

                </div>
              </div>

              <!-- form input content -->
              <div class="row input--field">
                <div class="col-md-3">
                  <label>Company Name</label>
                </div>
                <div class="col-md-5" id="input--field">
                  <?= h($partner->company_name); ?>
                </div>
                <div class="col-md-4 text-right">
                  <?= $this->Html->link(__('Edit'), ['controller'=>'Partners','action' => 'edit', $partner->id,'bplan'],['class' => 'btn btn-default pull-right']); ?> 
                </div>

              </div>
              <!-- form input content -->
    
  <fieldset>
  
    <?php
      $auth =   $this->Session->read('Auth');
      
      echo $this->Form->hidden('partner_id', ['value' => $auth['User']['partner_id']]);
      echo $this->Form->hidden('vendor_id', ['value' => $auth['User']['vendor_id']]);

    ?>



                <!-- form input content -->
                <div class="row input--field">
                  <div class="col-md-3">
                    <label>Business Case</label>
                  </div>
                  <div class="col-md-6" id="input--field">
                    <?php echo $this->Form->input('business_case', array(
                    'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
                  </div>

                </div>
                <!-- form input content -->

                <!-- form input content -->
                <div class="row input--field">
                  <div class="col-md-3">
                    <label>Target Customers</label>
                  </div>
                  <div class="col-md-6" id="input--field">
                    <?php echo $this->Form->input('target_customers', array(
                    'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
                  </div>

                </div>
                <!-- form input content -->

                <div class="row">
                  <div class="col-md-12">
                    <h4><?= __('Additional details')?></h4>

                  </div>
                </div>



                <!-- form input content -->
                <div class="row input--field">
                  <div class="col-md-3">
                    <label>Target Geography</label>
                  </div>
                  <div class="col-md-6" id="input--field">
                    <?php echo $this->Form->input('target_geography', array(
                    'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
                  </div>

                </div>
                <!-- form input content -->
                <!-- form input content -->
                <div class="row input--field">
                  <div class="col-md-3">
                    <label>Expected Result</label>
                  </div>
                  <div class="col-md-6" id="input--field">
                    <?php echo $this->Form->input('expected_result', array(
                    'div'=>false, 'label'=>false, 'class' => 'form-control')); ?>
                  </div>

                </div>
                <!-- form input content -->
                               <!-- form input content -->
                <div class="row input--field">
                  <div class="col-md-3">
                    <label>Status</label>
                  </div>
                  <div class="col-md-6" id="input--field">
                    <?php echo $this->Form->input('status', array(
                    'div'=>false, 'label'=>false, 'class' => 'form-control', 'options'=>['Draft'=>'Draft','Submit'=>'Submit'])); ?>
                  </div>

                </div>
                <!-- form input content -->

    
   
    
  </fieldset>
  

  
</div>


<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
          <?php
            $this->Html->addCrumb('Campaign Plans', ['controller' => 'Businessplans', 'action' => 'index']);
            $this->Html->addCrumb('apply', ['controller' => 'Businessplans', 'action' => 'add']);
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

