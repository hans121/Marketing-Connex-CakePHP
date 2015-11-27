<?php 
$this->layout = 'admin--ui';
?>
<style type="text/css">
.connexForm {margin: 10px auto; padding: 20px 10px 0 10px; border: 2px dashed #FAEBCC; text-align:center; cursor: pointer; background: #FCF8E3;color: #8A6D3B;} 
</style>
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
                  <h2 class="card--title"><?= __('Mailing List')?>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="card--actions">
                            <?= $this->Html->link($this->Html->tag('span',__('',true),['class' => 'fa fa-cloud-download']).' '.__('CSV Template'), ['action' => 'gettemplate'],['title' => 'Download CSV template', 'escape' => false, 'class'=>'btn btn-primary pull-right']) ?>  

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


<?php echo $this->Html->script('dropzone'); //include dropzone plugin ?>
<div class="campaignPartnerMailinglists index">
      

  
        
    <div class="row table-title">
    
      <div class="alert-wrap">
      <div class="alert alert-warning alert-dismissible" role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4><i class="fa fa-exclamation-triangle"></i> <?= __('Warning')?></h4>
          <p><?= __("You must ensure that the people that you upload details for have each given permission to be 'opted in' to your mailing list, and that you have evidence of this on file.")?></p>
      </div>
      </div>
          
    </div> <!-- /.row.table-title -->
  
  
<div class="row">
<div class="col-md-12">
<h4><?= __('Import CSV file'); ?></h4>
<p>Please download our CSV template to be sure your data is arranged in the correct format. After editing, save it as a 'Windows comma separated (.csv)' file to ensure compatibility.</p>
<hr>
</div>
</div>

  <div class="form">

    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
     
     <?= $this->Form->create('',['type'=>'file','class'=>'connexForm','id'=>'my-dropzone']); ?>
  
    
          
      <?php
        $auth =   $this->Session->read('Auth');
        echo $this->Form->hidden('partner_id',['value'=>$auth['User']['partner_id']]);
        echo $this->Form->hidden('vendor_id',['value'=>$auth['User']['vendor_id']]);
        echo $this->Form->hidden('partner_mailinglist_group_id',['value'=>$grp_id]);
        echo $this->Form->input('status',['type'=>'hidden','value'=>'Y']);
      ?>
      
      
      <span class="dz-message"><strong>Drop file here or click to upload.</strong></span>
      <div class="table table-striped" class="files" id="previews">

        <div id="template" class="file-row">
        <!-- This is used as the file preview template -->
          <div>
            <span class="preview"><img data-dz-thumbnail /></span>
          </div>
          <div>
          <p class="myIndicator"><span class="name" data-dz-name></span> (<small class="size" data-dz-size></small>) <span class="uploaded"></span></p>
          <strong class="text-danger" data-dz-errormessage></strong>
        </div>
        <div>
          
          <div class="progress spamchecker">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%" id="progressbar" data-dz-uploadprogress>
              
              <span class="percent">0</span>%
            </div>
          </div>
        </div>
        <div>
          <button type="button" class="btn btn-primary start">
            <i class="fa fa-cloud-upload"></i>
            <span>Upload</span>
          </button>
          <button type="button" class="btn btn-primary cancel">
            <i class="glyphicon glyphicon-ban-circle"></i>
            <span>Cancel</span>
          </button>

        </div>
      </div><!--template-->

    </div><!--previews-->
     
    
    
     
  </div>
  
</div> <!-- /#content -->

<div class="clearfix"></div>

<!-- content below this line -->
</div>
<div class="card-footer">
  <div class="row">
    <div class="col-md-6">
      <!-- breadcrumb -->
      <ol class="breadcrumb">
        <li>               
 <?php
            $this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglists', 'action' => 'index']);
            $this->Html->addCrumb('import', ['controller' => 'PartnerMailinglists', 'action' => 'addcsv']);
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
 <?= $this->Form->end(); ?>
    <?= $this->Html->link(__('Cancel'), ['action'=>'show',$grp_id],['class' => 'btn btn-primary btn-cancel']); ?>    
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>
<!-- /Card -->
<script>
  Dropzone.autoDiscover = false;
  $(function(){
    var previewNode = document.querySelector("#template");
    previewNode.id = "";
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);

    
    var myDropzone = new Dropzone("#my-dropzone",{
      paramName: 'importcsv',
      thumbnailWidth: 80,
      thumbnailHeight: 80,
      parallelUploads: 20,
      uploadMultiple: false,
      previewTemplate: previewTemplate,
      autoQueue: false, // Make sure the files aren't queued until manually added
      previewsContainer: "#previews",
      maxFiles: 1,
      //acceptedFiles: ".csv,text/csv,text/x-csv,application/vnd.ms-excel,'text/x-comma-separated-values'",
      acceptedFiles: ".csv,text/csv,text/x-csv,application/vnd.ms-excel,'text/x-comma-separated-values'"
      
    });
    
    myDropzone.on("addedfile", function(file) {
      // Hookup the start button
      //myDropzone.processQueue(file);
      file.previewElement.querySelector(".start").onclick = function() { myDropzone.processFile(file); };
      file.previewElement.querySelector(".cancel").onclick = function() { myDropzone.removeAllFiles(true); };
      
    });

    // Update the total progress bar
    myDropzone.on("uploadprogress", function(file,progress) {
      console.log(progress);
      document.querySelector(".progress .progress-bar").style.width = progress + "%";
      document.querySelector('.percent').innerHTML =progress;
      
    });

    myDropzone.on("sending", function(file,xhr,formData) {
      //console.log(file);
    });
    // Hide the total progress bar when nothing's uploading anymore
    myDropzone.on("queuecomplete", function(progress) {
      
      
      
    });
    myDropzone.on('success',function(file, responseText){
      
      file.previewElement.querySelector(".start").setAttribute("disabled", "disabled");
      file.previewElement.querySelector(".cancel").setAttribute("disabled", "disabled");
      //file.previewElement.querySelector(".progress").style.display = "none";
      //alert(responseText);
      //console.log(file);
      //alert(responseText);
      if(responseText){
        file.previewElement.querySelector(".myIndicator").setAttribute("class", "text-success");
        file.previewElement.querySelector(".uploaded").innerHTML='has been uploaded. Please wait while we are verifying the email addresses.';
        window.location.href="<?php echo $this->Url->build([ "controller" => "PartnerMailinglists","action" => "review", $grp_id],true);?>";
      }else {
        window.location.href="<?php echo $this->Url->build([ "controller" => "PartnerMailinglists","action" => "errordropcsv", $grp_id],true);?>";
      }
      //$('#my-dropzone').submit();
      
    });
    
  
  });

</script>
