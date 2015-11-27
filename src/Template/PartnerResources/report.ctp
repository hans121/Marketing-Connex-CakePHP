<div class="folders view">

	<?=$this->Form->create($resource)?>

	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Resource'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Resources', ['controller'=>'PartnerResources', 'action'=>'index']);
					$this->Html->addCrumb('report abuse', ['controller'=>'PartnerResources', 'action' => 'report', $resource->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		</div>
		
	</div> <!--row-table-title-->
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="row inner header-row ">
		
		<dt class="col-lg-9 col-md-8 col-sm-6 col-xs-4">
		<?php if(stristr($resource->type, 'image')){ ?>
	    
				<a data-toggle="popover" data-html="true" data-content="<img src='<?=$resource->publicurl?>' />">
					<strong><?= h($resource->name) ?></strong>
					<i class="fa fa-info-circle"></i>
				</a>
	
	    <?php } else { ?>
	
				<strong><?= h($resource->name) ?></strong>
	
	    <?php } ?>  			
		</dt>
		
		<dd class="col-lg-3 col-md-4 col-sm-6 col-xs-8">
		</dd>
		
	</div>

	<?php
		$path = $resource->publicurl;
		$file = basename($path);
	?>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('File name') ?>
    </dt>
		<dd class="col-lg-5 col-md-5 col-sm-5 col-xs-8">
			<?= $this->Html->link($file, $resource->publicurl,['title'=>$resource->publicurl.' - '.__('Opens in a new browser tab or window'), 'target'=>'_blank']) ?>
		</dd>
		<dd class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
			<a class="btn pull-right" id="copy-button" data-clipboard-text="<?= $resource->publicurl ?>"><?=__('Copy URL to clipboard')?> <i class="fa fa-files-o"></i></a>
		</dd>
	</div>

	<div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('User') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $resource->has('user') ? $resource->user->title.' '.$resource->user->first_name.' '.$resource->user->last_name : '' ?>
			&nbsp;
		</dd>
	</div>

	<div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Vendor') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?=$resource->vendor->company_name?>
		</dd>
	</div>

	<div class="row inner">   
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<?=$this->Form->input('message',['type'=>'textarea', 'label'=>'Your Complain'])?>
		</div>
	</div>
	
	<?php  
    	echo $this->element('form-submit-bar'); 
		echo $this->Form->end();
	?>		
</div>

<!-- zeroClipboard copy-to-clipboard plug-in: https://github.com/zeroclipboard/zeroclipboard/blob/master/docs/instructions.md -->
	
<?php echo $this->Html->script('zeroClipboard/ZeroClipboard.js');?>
<?= $this->fetch('script');?>

<script type="text/javascript">
	var clientText = new ZeroClipboard( $('#copy-button'), {
	  moviePath: "<?=$this->Url->build('/js/zeroClipboard/ZeroClipboard.swf', true)?>",
	  debug: true
	});
	
	clientText.on( "ready", function(event) {
	  console.log( 'movie is loaded' );
	
	  clientText.on( "aftercopy", function(event) {
		  $("#copy-button").hide();
	    alert("Copied text to clipboard: " + event.data['text/plain']);
	    
	  });
	  
	});
</script>

<!-- end zeroClipboard -->
