<?= $this->Html->image('emailtemplates/previews/'.$preview_image_name,['alt'=>'email-preview','class'=>'img-responsive'])?>

<div class="row preview-button">
  <div class="col-md-12">
      <span data-toggle="modal" data-target="#EMpreviewModal" onclick="newajaxprvbrowsr();" id="prvbrwsr" class="btn btn-primary pull-right button"><?= __('Preview images in place');?> <i class="fa fa-search"></i></span>

     <?// = $this->Html->link(__('Spam check').' '.$this->Html->tag('span',__('',true),['class' => 'fa fa-shield']), ['controller' => 'Campaigns','action' => 'spamcheck',$emailTemplate->campaign_id],['escape' => false, 'class' => 'btn btn-primary pull-right']); ?>
  </div>
</div>
