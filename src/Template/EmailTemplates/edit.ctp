<?php 
$this->layout = 'admin--ui';
?>

<style>
    
/*BEE FREE */
      #bee-plugin-container {
        position: relative; 
        display:block;
        height:900px;
      }
      #integrator-bottom-bar {
          display: none !important;
      }
      .top-bar {display: none !important;}

      .connex_override {
          background: #505659;
          height:49px;
          width:400px;
          position: absolute;
          z-index: 1000;
          left:0px;
          top:65px;
      }
      
      #textboxlink {
          display: none;
      }
      
      #profile {
          height:1000px;
      }
      .text--box {
        min-height: 300px;
        font-size: 10px!important;
      }
      .modal {
        top: 10%;
      }
      .modal-backdrop {
  z-index: -1;
  background-color: transparent!important;
}

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
                                <i class="icon ion-compose"></i></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title">Email Setup</h2>
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
                                <h4>Campaign Overview</h4>
                                <p>Breakdown of all campaigns to date, showcasing their status, how many partners have applied for the campaign, how many approved, how many have executed and the results seen to date.
                                </p>
                                <hr>
                            </div>
                        </div>
                    -->
                        <!-- content below this line -->


<div class="row">
    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
        <li id="setuplink" role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Set-up</a></li>
        <li id="textboxlink" role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Use custom code or upload Zip File</a></li>
        </ul>
    </div>
</div>
<div class="row">
    <div class="col-md-2 col-md-offset-10">
                    <div class="onoffswitch pull-right">
                            <?= $this->Form->checkbox('use_templates',['value'=>'Y','class'=>'onoffswitch-checkbox show-hide-toggle', 'id'=>'use_templates', 'checked'=>'checked'])?>
                        <label class="onoffswitch-label" for="use_templates">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                        </label>
                    </div>
                    <p class="control-label pull-right">
                        <?=__('Use a template&nbsp;')?>
                    </p>
    </div>
</div>

<?= $this->Form->create($emailTemplate,['class'=>'validatedForm form-with-preview','type'=>'file','id'=>'frmemailtmplt']); ?>
<?php
echo $this->Form->input('vendor_id', ['type' => 'hidden','value'=>$vid]);
echo $this->Form->input('campaign_id', ['type' => 'hidden','value'=>$cmp_id]);
?>


<div class="row">
  <!-- Tab panes -->
  <div class="tab-content">
    <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

    <div role="tabpanel" class="tab-pane active" id="home">
        
        <div class="row">
            <div class="emailTemplates form col-centered col-sm-12">
            
            
                <fieldset>
            
                    <div id="toggle-width" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">
                    
        
                        
                        <!-- form input content -->
<div class="row input--field">
    <div class="col-md-3">
        <label>Subject Option 1</label>
    </div>
    <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('subject_option1', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'placeholder'=>'Subject Line Option 1')); ?>
    </div>

</div>
<!-- form input content -->
                        <!-- form input content -->
<div class="row input--field">
    <div class="col-md-3">
        <label>Subject Option 2</label>
    </div>
    <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('subject_option2', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'placeholder'=>'Subject Line Option 2')); ?>
    </div>

</div>
<!-- form input content -->
                        <!-- form input content -->
<div class="row input--field">
    <div class="col-md-3">
        <label>Subject Option 3</label>
    </div>
    <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('subject_option3', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control', 'placeholder'=>'Subject Line Option 3')); ?>
    </div>

</div>
<!-- form input content -->
                    
                    </div>
                </fieldset>
        
            </div>
        </div><!-- /.row -->




    </div>
    <div role="tabpanel" class="tab-pane" id="messages">




 
                                <!-- form input content -->
<div class="row input--field">
    <div class="col-md-3">
        <label>Enter custom markup</label>
    </div>
    <div class="col-md-6" id="input--field">
        <?php echo $this->Form->input('custom_template', array(
        'div'=>false, 'label'=>false, 'class' => 'form-control text--box')); ?>
    </div>
    <div class="col-md-3">
      <span data-toggle="modal" data-target="#uploadEmailModal" onclick="" id="uploadEmail" class="btn btn-primary pull-right button"><i class="fa fa-cloud-upload"></i> <?= __('Upload e-mail (Zip)');?></span>
    </div>

</div>
<!-- form input content -->
        <div class="row input--field preview-button">
            <div class="col-md-12">
            <p>Merge Tags: <b>[*!PARTNERLOGO!*]</b> - Include Partner Logo, <b>[*!CTATEXT!*]</b> - Include Link to Landing Page <br />
            To use, please copy and paste the merge tag you need.</p>
            </div>
        </div>
    </div>
    
  </div>

</div>
                    <div class="row submit-bar">
                        <div class="col-md-12">
                            <?//= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'pull-left btn btn-default btn-cancel']); ?>                  
                            <?//php
                                echo $this->Form->hidden('template',['value'=>'Y', 'id'=>'templateflag']);
                            ?>
                            <?//= $this->Form->button(__('Save & Continue'),['class'=> 'pull-right btn btn-primary']); ?>
                        </div>
                    </div>

<?//= $this->Form->end(); ?>

        <?php
            echo $this->Html->script('dropzone'); //include dropzone plugin
        ?>
        
        
        <script>
            
        
            Dropzone.autoDiscover = false;
            $(function(){
                var previewNode = document.querySelector("#template");
                previewNode.id = "";
                var previewTemplate = previewNode.parentNode.innerHTML;
                previewNode.parentNode.removeChild(previewNode);
        
                
                var myDropzone = new Dropzone("#my-dropzone",{
                    paramName: 'importzip',
                    thumbnailWidth: 80,
                    thumbnailHeight: 80,
                    parallelUploads: 20,
                    uploadMultiple: false,
                    previewTemplate: previewTemplate,
                    autoQueue: false, // Make sure the files aren't queued until manually added
                    previewsContainer: "#previews",
                    maxFiles: 1,
                    maxFilesize: 1, // 1Mb
                    acceptedFiles: "application/zip,application/x-zip-compressed,multipart/x-zip,application/x-compressed",
                    
                });
                
                myDropzone.on("addedfile", function(file) {
                    // Hookup the start button
                    myDropzone.processQueue(file);
                    file.previewElement.querySelector(".start").onclick = function() { myDropzone.processFile(file); };
                    
                });
        
                // Update the total progress bar
                myDropzone.on("totaluploadprogress", function(progress) {
                    
                    document.querySelector(".progress .progress-bar").style.width = progress + "%";
                    document.querySelector('.percent').innerHTML =progress;
                });
        
                myDropzone.on("sending", function(file,xhr,formData) {
                    
                });
                // Hide the total progress bar when nothing's uploading anymore
                myDropzone.on("queuecomplete", function(progress) {
                    
                    
                    
                });
                myDropzone.on('success',function(file, responseText){
                    
                    file.previewElement.querySelector(".cancel").setAttribute("disabled", "disabled");
                    file.previewElement.querySelector(".progress").style.display = "none";
                    //  alert(responseText);
                    if(responseText){
                        file.previewElement.querySelector(".myIndicator").setAttribute("class", "text-success");
                        file.previewElement.querySelector(".uploaded").innerHTML='has been uploaded!';
                        
                        window.location.href="<?php echo $this->Url->build([ "controller" => "Campaigns","action" => "view", $cmp_id],true);?>";
                    }else {
                        //window.location.href="<?php echo $this->Url->build([ "controller" => "CampaignPartnerMailinglists","action" => "errordropcsv", $vid],true);?>";
                    }
                    
                });
                
            
            });
        </script>
          <script type="text/javascript"> 
        
            $(document).ready(function() {

                  $('#use_templates').change(function() {
                      if ($(this).val()=="Y") {
                          $('#textboxlink').toggle();
                          $('#templateflag').val("N");
                          $('.submit-bar button').text("Save without template");
                          $(this).val("N");
                          //$('#ajaxpreviewimg').fadeToggle( "slow", "linear" );
                      } else {
                          $('#textboxlink').toggle();
                          $('#templateflag').val("Y");
                          $('.submit-bar button').text("Save and Continue to editor");
                          $(this).val("Y");
                          //$('#ajaxpreviewimg').fadeToggle( "slow", "linear" );
                      }
                  });


            });        
        </script>


          
            







</div>
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
            <div class="col-md-6 submit-bar text-right">
                            <?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>                  
                            <?php
                                echo $this->Form->hidden('template',['value'=>'Y', 'id'=>'templateflag']);
                            ?>
                            <?= $this->Form->button(__('Save & Continue'),['class'=> 'btn btn-primary']); ?>
                            <?= $this->Form->end(); ?>

            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<!-- /Card -->
<!--modal upload e-mail -->
        <div class="modal fade" id="uploadEmailModal" tabindex="-1" role="dialog" aria-labelledby="myUploadModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myUploadModalLabel">Upload e-mail on zip format</h4>
              </div>
              <div class="modal-body">
                 <?= $this->Form->create('',['type'=>'file','class'=>'connexForm','id'=>'my-dropzone']); ?>
                 <?php
                    echo $this->Form->input('vendor_id', ['type' => 'hidden','value'=>$vid]);
                    echo $this->Form->input('campaign_id', ['type' => 'hidden','value'=>$cmp_id]);
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
                                <button data-dz-remove class="btn btn-warning cancel">
                                    <i class="glyphicon glyphicon-ban-circle"></i>
                                    <span>Cancel</span>
                                </button>
                            </div>
                        </div>
                    </div>
                 <?= $this->Form->end(); ?>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div><!--upload modal ends-->

