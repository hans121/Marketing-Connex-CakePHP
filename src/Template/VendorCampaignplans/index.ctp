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
                  <h2 class="card--title"><?= __('Campaign plans')?></h2>
                  <h3 class="card--subtitle"></h3>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">

<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#filterCollapse" aria-expanded="false" aria-controls="collapseExample">
  <?= __('Show Filters')?>
</button>



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

<script type="text/javascript">
  function ajxfltr(){
      var id = $("#id").val();
      var fqtid = $("#financialquarter-id").val();
      var prtid = $("#partner-id").val();
      var cmpid = $("#campaign-id").val();
      var status = $("#status").val();
      // Returns successful data submission message when the entered information is stored in database.
      var dataString = 'id='+ id + '&financialquarter_id='+ fqtid + '&partner_id='+ prtid + '&campaign_id='+ cmpid+ '&partner_id='+ prtid + '&status='+ status;
      $.ajax ({
            type: "POST",
            url: "<?php echo $this->Url->build([ "controller" => "VendorCampaignplans","action" => "ajaxindex"],true);?>",
            data: dataString,
            cache: false,
            success: function(html)
            {
                  $('#ajaxresults').html(html);

            }
      });
  }
  function ajxdynfltr() {
      var fqtid = $("#financialquarter-id").val();
      var prtid = $("#partner-id").val();
      var cmpid = $("#campaign-id").val();
      var status = $("#status").val();
      var dataString = '&partner_id='+ prtid + '&quarter_id='+ fqtid + '&campaign_id='+ cmpid + '&status='+ status;
      
      $.ajax ({
            type: "POST",
            url: "<?php echo $this->Url->build([ "controller" => "VendorCampaignplans","action" => "ajaxdynamicfilter"],true);?>"+(prtid!=''?'/'+prtid:'')+(fqtid!=''?'/'+fqtid:'')+(cmpid!=''?'/'+cmpid:'')+(status!=''?'/'+status:''),
            data: dataString,
            cache: false,
            success: function(json)
            {
                  var data = $.parseJSON(json);
                  clearOptions('#partner-id' , 'Partner');
                  $.each( data.partners , fillPartners );
                  if($.inArray(prtid , data.partners))
                    $("#partner-id").val(prtid);
                  $('#partner-id').selectpicker('refresh');

                  clearOptions('#financialquarter-id' , 'Quarter');
                  $.each( data.quarters , fillQuarters );
                  if($.inArray(fqtid , data.quarters))
                    $("#financialquarter-id").val(fqtid);
                  $('#financialquarter-id').selectpicker('refresh');

                  clearOptions('#campaign-id' , 'Campaign');
                  $.each( data.campaigns , fillCampaigns );
                  if($.inArray(cmpid , data.campaigns))
                    $("#campaign-id").val(cmpid);
                  $('#campaign-id').selectpicker('refresh');

                  clearOptions('#status' , 'Status');
                  $.each( data.statuses , fillStatuses );
                  if($.inArray(status , data.statuses))
                    $("#status").val(status);
                  $('#status').selectpicker('refresh');

                  ajxfltr();
            }
      });
  }
  function denywithmsg(id) {
      var answer = confirm("Are you sure you want to deny?")
      if(answer)
      {
        var msg = prompt('Please leave a reason:','');
        document.location = '<?php echo $this->Url->build([ "action" => "approveplan"],true);?>/'+id+'/Denied/'+escape(msg);
      }
      return false;
  }
  function clearOptions(select_id , value) {
    $(select_id).empty();
    $(select_id).append(new Option(value,''));
    $(select_id).selectpicker('refresh');
  }
  function fillPartners(i, val) {
    $('#partner-id').append(new Option(val,i));
  }
  function fillQuarters(i, val) {
     $("#financialquarter-id").append(new Option(val,i));
  }
  function fillCampaigns(i, val) {
    $("#campaign-id").append(new Option(val,i));
  }
  function fillStatuses(i, val) {
    $("#status").append(new Option(val,i));
  }
  $(document).ready(function()
  {
      $('#id').change(function() {        
          //ajxdynfltr();
          ajxfltr() ;
      });
      $('#financialquarter-id').change(function() {
          //ajxdynfltr();
          ajxfltr() ;
      });
      $('#campaign-id').change(function() {
          //ajxdynfltr();
          ajxfltr() ;
      });
      $('#partner-id').change(function() {
          //ajxdynfltr();
          ajxfltr() ;
      });
      $('#status').change(function() {
          //ajxdynfltr();
          ajxfltr() ;
      });
      
      ajxfltr() ;
  });
</script>

<div class="businesplans index">
      
  <div class="row index table-title vendor-table-title">
  



    
    <div class="clearfix"></div>
    
    <?php echo $this->element('vendor-bplan-filter-form'); ?>
    
  </div> <!--row-table-title-->
  
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
  
  <div id="ajaxresults">
    <?php echo $this->element('bplan-ajax-list'); ?>
  </div>  
  
      
</div><!-- /.container -->

  <?php echo $this->element('paginator'); ?>


<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
        <?php
          $this->Html->addCrumb('Partners', ['controller' => 'vendors', 'action' => 'partners']);
          $this->Html->addCrumb('Manage Campaign Plans', ['controller' => 'VendorCampaignplans', 'action' => 'index']);
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

