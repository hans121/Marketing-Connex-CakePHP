<?php 
$this->layout = 'admin--ui';
?>

<?php
// echo $this->Url->build([ "controller" => "PartnerCampaignEmailSettings","action" => "ajaxpreviewlpg"],true);
?>
<script type="text/javascript">

function ajxfltr() {
  var id = $("#campaign").val();
  var dataString = 'campaign_id='+id;
  $.ajax ({
    type: "POST",
    url: "<?php echo $this->Url->build([ "controller" => "PartnerCampaigns","action" => "ajaxcampaigndetails"],true);?>",
    data: dataString,
    cache: false,
    success: function(html)
    {
      $('#ajax-list').html(html);
    }
  });
}
function viewlpg(){
  var id = $("#campaign").val();
  var dataString = 'campaign_id='+id;
  $.ajax ({
    type: "POST",
    url: "<?php echo $this->Url->build([ "controller" => "PartnerCampaignEmailSettings","action" => "ajaxpreviewlpg"],true);?>",
    data: dataString,
    cache: false,
    success: function(html)
    {
      iframe = document.getElementById('prvlpg');
      iframe.contentWindow.document.open()
      iframe.contentWindow.document.write(html);
    }
  });
}
function viewemail(){
  var id = $("#campaign").val();
  var dataString = 'campaign_id='+id;
  $.ajax ({
    type: "POST",
    url: "<?php echo $this->Url->build([ "controller" => "PartnerCampaignEmailSettings","action" => "ajaxpreviewemail"],true);?>",
    data: dataString,
    cache: false,
    success: function(html)
    {
      iframe = document.getElementById('prvem');
      iframe.contentWindow.document.open()
      iframe.contentWindow.document.write(html);
    }
  });
}
function movemailinglist(){
  var id = $("#campaign").val();
  var relocurl    =   '<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "index/"],true);?>/'+id
  window.location.replace(relocurl);
}
$(document).ready(function() {
  $('#campaign').change(function() {
    ajxfltr() ;
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
                  <i class="icon ion-document"></i></div>
                </div>
                <div class="card--info">
                  <h2 class="card--title"><?= __('My Campaigns'); ?></h2>
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
                      <li><?= $this->Html->link(__('Mailing list'), '#',['onclick'=>'movemailinglist();']); ?></li>
                      <li><?= $this->Html->link(__('Preview landing page'), '#',['data-toggle'=>'modal', 'data-target'=>'#LMpreviewModal','onclick'=>'viewlpg();']); ?></li>
                      <li><?= $this->Html->link(__('Preview email'), '#',['data-toggle'=>'modal', 'data-target'=>'#EMpreviewModal','onclick'=>'viewemail();']); ?></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>   
          </div>


          <div class="card-content">
<!--
<div class="row">
<div class="col-md-12">
<h4><?= h($page->title) ?></h4>
<p></p>
<hr>
</div>
</div>
-->
<!-- content below this line -->

<div class="campaigns index">

  <div class="row table-title partner-table-title">

    <div class="partner-sub-menu clearfix">

      <!-- form input content -->
      <div class="row input--field">
        <div class="col-md-3">
          <label>Campaigns</label>
        </div>
        <div class="col-md-6" id="input--field">
          <?php echo $this->Form->input('campaign', array(
          'div'=>false, 'label'=>false, 'options' => $my_camp_list,'data-live-search' => true, 'class' => 'form-control')); ?>
        </div>

      </div>
      <!-- form input content -->

    </div>

  </div> <!--row-table-title-->



  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

  <div id="ajax-list">
    <?//php echo $this->element('my-campaign-ajax-list'); ?>
  </div>


</div> <!-- /#content -->

<script type="text/javascript">
ajxfltr();
</script>


<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-8">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               

        </li>
      </ol>
    </div>
    <div class="col-md-4 text-right">
      <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>         


    </div>
  </div>
</div>
</div>
</div>
</div>
</div>
<!-- /Card -->




<!-- Modal -->
<div class="modal fade" id="LMpreviewModal" tabindex="-1" role="dialog" aria-labelledby="LMpreviewModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Landing page preview</h4>
      </div>
      <div class="modal-body">
        <div class="intrinsic-container intrinsic-container-4x3">
          <iframe src="#" id="prvlpg" allowfullscreen>
            <!-- Dynamically populate this area with the email or landing page content, via the ID -->
          </iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="EMpreviewModal" tabindex="-1" role="dialog" aria-labelledby="EMpreviewModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">E-mail preview</h4>
      </div>
      <div class="modal-body">
        <div class="intrinsic-container intrinsic-container-4x3">
          <iframe src="#" id="prvem" allowfullscreen>
            <!-- Dynamically populate this area with the email or landing page content, via the ID -->
          </iframe>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
