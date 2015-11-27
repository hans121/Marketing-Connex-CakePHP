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
									<h2 class="card--title"><?= __($group?$group->name:'Mailing list'); ?></h2>
									<h3 class="card--subtitle"></h3>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="card--actions">
									<div class="dropdown pull-right">
										<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
											Manage
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
											<li><?= $this->Html->link(__('Segments'), ['controller'=>'PartnerMailinglistSegments','action' => 'show',$group->id]) ?></li>
											<li><?= $this->Html->link(__('Add Contact'), ['action' => 'add',$group->id]) ?></li>
											<li><?= $this->Html->link(__('Upload Contacts').' <i class="fa fa-cloud-upload"></i>', ['action' => 'addcsv',$group->id],['title' => 'Upload contacts in CSV format', 'escape' => false]) ?></li>
											<li><?= $this->Html->link(__('CSV Template').' <i class="fa fa-cloud-download"></i>', ['action' => 'gettemplate'],['title' => 'Download CSV template', 'escape' => false]) ?></li>
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
<h4>Campaign Options</h4>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
</p>
<hr>
</div>
</div>
-->
<!-- content below this line -->


<script>

function bulkdelete(){
var test = {};           // Object
test['id'] = [];          // Array
$.each($("input[name='bulkid[]']:checked"), function() {
	test['id'].push($(this).val());

// or you can do something to the actual checked checkboxes by working directly with 'this'
// something like $(this).hide() (only something useful, probably) :P
});
$.ajax({
	url: "<?php echo $this->Url->build([ "controller" => "PartnerMailinglists","action" => "bulkdelete"],true);?>",
	type: "POST",
	data: 'ids='+test['id'],
	async: false,
	success: function (msg) {
//alert(msg);
window.location.replace("<?php echo $this->Url->build([ "controller" => "PartnerMailinglists","action" => "index",$campaign->id],true);?>");
}
});
}

</script>



<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<?= $this->Form->create('',['id'=>'frmbulkupt']); ?>
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-12 hidden-xs filter-form">

		<div class="input-group input text">

			<?=$this->Form->input('keyword',['value' => $keyword,'placeholder' => 'Filter','class' => 'form-control','label' => '','type'=> 'text']);?>

			<span class="input-group-btn">
				<?= $this->Form->button('<span class="fa fa-search"></span>',['class'=> 'btn btn-search btn-primary']); ?>   
			</span>

		</div>

	</div>
</div>
<hr>

<div class="row table-th hidden-xs">

	<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

	<div class="clearfix"></div>
	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
	</div>
	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?= $this->Paginator->sort('email','E-mail address'); ?></div>
	<div class="col-lg-2 hidden-md hidden-sm col-xs-2"><?= $this->Paginator->sort('first_name','First') ?></div>
	<div class="col-lg-2 hidden-md hidden-sm  col-xs-2"> <?= $this->Paginator->sort('last_name','Last') ?></div>
	<div class="col-lg-4 col-md-4 col-sm-3 col-xs-4"></div>

</div> <!-- /.row .table-th -->


<div class="row inner header-row hidden-xs">

	<div class="col-md-1 col-sm-1">
		<?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master-top','name'=>'bulk-selector-master-top'])?>
		<label for="bulk-selector-master-top" class="css-checkbox-label"></label>
	</div>

	<div class="col-md-2 col-sm-3">
		<?= __('Bulk actions')?>
	</div>

	<div class="col-md-9 col-sm-8 btn-group">
		<?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-default pull-right','onclick'=>'bulkdelete()', 'title' => 'Delete selection']); ?>
	</div>

</div>

<!-- Start loop -->

<?php
$j =0;
foreach ($PartnerMailinglists as $partnerMailinglist):
	$j++;
?>

<div class="row inner hidden-xs">

	<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
		<?= $this->Form->checkbox('bulkid[]',['class'=>'css-checkbox bulk-selector','value'=>$partnerMailinglist->id,'label'=>false,'id'=>'bulkid-'.$partnerMailinglist->id])?>
		<label for="bulkid-<?=$partnerMailinglist->id?>" name="" class="css-checkbox-label"></label>
	</div>

	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
		<?= h($partnerMailinglist->email); ?>
	</div>

	<div class="col-lg-2 hidden-md hidden-sm col-xs-1">
		<?= h($partnerMailinglist->first_name); ?>
	</div>

	<div class="col-lg-2 hidden-md hidden-sm col-xs-1">
		<?= h($partnerMailinglist->last_name); ?>
	</div>

	<div class="col-lg-4 col-md-5 col-sm-4 col-xs-4">
		<div class="dropdown pull-right">
			<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				Manage
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li><?= $this->Html->link(__('View'), ['action' => 'view', $partnerMailinglist->id]); ?></li>
				<li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerMailinglist->id]); ?></li>

				<li><?= $this->Html->link(__('Delete'), ['action' => 'delete', $partnerMailinglist->id], ['confirm' => __('Are you sure you want to delete?', $partnerMailinglist->id)]); ?>
				</div>


			</div>

		</div> <!--row-->


		<div class="row inner visible-xs">

			<div class="col-xs-12 text-center">

				<a data-toggle="collapse" data-parent="#accordion" href="#basic<?= $j ?>">
					<h3><?= h($partnerMailinglist->email); ?></h3>
				</a>

			</div> <!-- /.col -->

			<div id="basic<?= $j ?>" class="col-xs-12 panel-collapse collapse">

				<div class="row inner">

					<div class="col-xs-12">
						<?= h($partnerMailinglist->first_name.' '.$partnerMailinglist->last_name); ?>
					</div>  

				</div>

				<div class="row inner">

					<div class="col-xs-12">

						<div class="dropdown pull-right">
							<button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
								Manage
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
								<li><?= $this->Html->link(__('View'), ['action' => 'view', $partnerMailinglist->id]); ?></li>
								<li><?= $this->Html->link(__('Edit'), ['action' => 'edit', $partnerMailinglist->id]); ?></li>

								<li><?= $this->Html->link(__('Delete'), ['action' => 'delete', $partnerMailinglist->id], ['confirm' => __('Are you sure you want to delete?', $partnerMailinglist->id)]); ?>
								</div>

							</div>

						</div>

					</div> <!--collapseOne-->

				</div> <!--row-->


			<?php endforeach; ?>

			<div class="row inner header-row hidden-xs">

				<div class="col-md-1 col-sm-1">
					<?= $this->Form->checkbox('chk[]',['class'=>'css-checkbox','label'=>false,'id'=>'bulk-selector-master','name'=>'bulk-selector-master'])?>
					<label for="bulk-selector-master" class="css-checkbox-label"></label>
				</div>

				<div class="col-md-2 col-sm-3">
					<?= __('Bulk actions')?>
				</div>

				<div class="col-md-9 col-sm-8 btn-group">
					<?= $this->Html->link(__('Delete'), '#',['class' => 'btn btn-default pull-right','onclick'=>'bulkdelete()', 'title' => 'Delete selection']); ?>
				</div>

			</div>

			<!-- End loop -->

			<?= $this->Form->end(); ?>

			<?php echo $this->element('paginator'); ?>

			<script type="text/javascript">

			$('#bulk-selector-master').click(function() {
				if ($(this).is(':checked') == true) {
					$('.bulk-selector').prop('checked', true);
					$('#bulk-selector-master-top').prop('checked', true);
				}else{
					$('.bulk-selector').prop('checked', false);
					$('#bulk-selector-master-top').prop('checked', false);
				}
			});
			$('#bulk-selector-master-top').click(function() {
				if ($(this).is(':checked') == true) {
					$('.bulk-selector').prop('checked', true);
					$('#bulk-selector-master').prop('checked', true);
				}else{
					$('.bulk-selector').prop('checked', false);
					$('#bulk-selector-master').prop('checked', false);
				}
			});

			</script>

			<!-- content below this line -->
		</div>
		<div class="card-footer">
			<div class="row">
				<div class="col-md-6">
					<!-- breadcrumb -->
					<ol class="breadcrumb">
						<li>               
							<?php
							$this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglistGroups', 'action' => 'index']);
							$this->Html->addCrumb('list', ['controller' => 'PartnerMailinglists', 'action' => 'show', $group->id]);
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

