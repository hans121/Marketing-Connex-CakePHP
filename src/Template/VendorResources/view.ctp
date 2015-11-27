<div class="folders view">

	<div class="row table-title">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<h2><?= __('Resource'); ?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Resources', ['controller'=>'VendorResources', 'action'=>'index']);
					$this->Html->addCrumb('view', ['controller' => 'VendorResources', 'action' => 'view', $resource->id]);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Admins', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
		</div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
	    <?= $this->Html->link(__('Add resource'), ['action' => 'add', $resource->folder->id],['class'=>'btn btn-lg pull-right']); ?>
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
			<?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $resource->folder->id, $resource->id], ['confirm' => __('Are you sure you want to delete?', $resource->id),'class' => 'btn btn-danger pull-right']); ?>
			<?= $this->Html->link(__('Edit'), ['action' => 'edit', $resource->folder->id, $resource->id],['class' => 'btn pull-right']); ?>
			<?= $this->Form->postLink(__('Download'), ['action' => 'downloadfile', $resource->id], ['class' => 'btn pull-right']); ?>
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
    	<?= __('File type') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($resource->type) ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('File size') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h(round($resource->size/1000) .'KB') ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Folder path') ?>
    </dt>
		<dd class="col-lg-5 col-md-5 col-sm-5 col-xs-8">
      <i class="fa fa-folder-open-o"></i>          
			<?= $resource->has('folder') ? $this->Html->link($resource->folder->name, ['controller' => 'Folders', 'action' => 'view', $resource->folder->id]) : '' ?>
		</dd>
		<dd class="col-lg-3 col-md-3 col-sm-3 hidden-xs">
			<?= $resource->has('folder') ? $this->Html->link(__('Edit'), ['controller' => 'VendorFolders', 'action' => 'edit', $resource->folder->id],['class'=>'btn pull-right']) : '' ?>
			<?= $resource->has('folder') ? $this->Html->link(__('View'), ['controller' => 'VendorFolders', 'action' => 'view', $resource->folder->id],['class'=>'btn pull-right']) : '' ?>
		</dd>
	</div>

	<div class="row inner">   
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Folder description') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($resource->description) ?>
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
    	<?= __('User Role') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= h($resource->user_role) ?>
		</dd>
	</div>

	<div class="row inner">
    <dt class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
    	<?= __('Vendor') ?>
    </dt>
		<dd class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?= $resource->has('vendor') ? $this->Html->link($resource->vendor->company_name, ['controller' => 'Vendors', 'action' => 'view', $resource->vendor->id]) : '' ?>
		</dd>
	</div>

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
