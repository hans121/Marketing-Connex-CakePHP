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
								<div class="bubble"><i class="icon ion-compose"></i></div>
							</div>
							<div class="card--info">
								<h2 class="card--title"><?= h($campaign->name) ?></h2>
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
					
					<div class="row">
						<div class="col-md-12">
							<h4>Campaign Settings</h4>
							
							<hr>
						</div>
					</div>
				
					<!-- content below this line -->

					<script type="text/javascript">
					$(document).ready(function()
					{
						$('#financialquarter-id').change(function() {
							var dataString = "qtid="+$(this).val()+"&cal=<?= $campaign->send_limit;?>";
							$.ajax ({
								type: "POST",
								url: "<?php echo $this->Url->build([ "controller" => "Campaigns","action" => "getBalanceAllowance"],true);?>",
								data: dataString,
								cache: false,
								success: function(html)
								{
									$('#ajaxallowance').html(html);
								}
							});
						});

						$('#campaign-type').change(function() {
							var other_cont = $('#campaign_type_other');
							var other = $('#campaign-type-other');
							if(this.value=='other') {
								other_cont.show();
								other.prop('disabled',false);
							}
							else {
								other.prop('disabled',true);
								other_cont.hide();
							}
						});

						if($.inArray($('#campaign-type').val(),['e-mail','Royal Mail','leaflet'])>-1)
							$('#campaign_type_other').hide();
						else
							$('#campaign-type-other').val('<?=$campaign->campaign_type?>');

					});
</script>

<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>

<?= $this->Form->create($campaign,['class'=>'validatedForm','type'=>'file']); ?>
<?php
$auth = $this->Session->read('Auth');
echo $this->Form->hidden('vendor_id', ['value' => $auth['User']['vendor_id']]);
echo $this->Form->hidden('campaign_type', ['value' =>'e-mail']);

?>
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label for="exampleInput">Name</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('name', array(
		'div'=>false, 'label'=>false, 'placeholder' => 'campaign name', 'class' => 'form-control')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label for="exampleInput">Financial Quarter</label>
	</div>
	<div class="col-md-9" id="input--field">
		<?php echo $this->Form->input('financialquarter_id', array(
		'div'=>false, 'label'=>false, 'value'=>$currentquarter->id,'options' => $financialquarters,'data-live-search' => true)); ?>
	</div>
</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label for="exampleInput">Target Market</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('target_market', array(
		'div'=>false, 'label'=>false, 'placeholder' => 'market', 'class' => 'form-control')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
<div class="row input--field">
	<div class="col-md-3">
		<label for="exampleInput">Average Deal Value</label>
	</div>
	<div class="col-md-6" id="input--field">
		<?php echo $this->Form->input('sales_value', array(
		'div'=>false, 'label'=>false, 'placeholder' => 'enter value', 'class' => 'form-control')); ?>
	</div>

</div>
<!-- form input content -->
<!-- form input content -->
	<div id="ajaxallowance"><?php echo $this->element('campaign-ajax-sent');?></div>

	<!-- form input content -->
	<div class="row">
		<div class="col-md-12">
			<h4>Campaign Options</h4>

			<hr>
		</div>
	</div>



	<?php echo $this->element('checkbox-switches-campaign-modules');?>




	<?php 

	echo $this->Form->hidden('status',['value' =>'Y']);
	?>

</fieldset>


<!-- /form input content -->


<!-- content below this line -->
</div>
<div class="card-footer">
	<div class="row">
		<div class="col-md-6">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li>               
					<?php
					$this->Html->addCrumb('Campaigns', ['controller' => 'Campaigns', 'action' => 'index']);
					$this->Html->addCrumb(h($campaign->name), ['controller' => 'Campaigns', 'action' => 'view', $campaign->id]);
					echo $this->Html->getCrumbs(' / ', [
						'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						'url' => ['controller' => 'Vendors', 'action' => 'index'],
						'escape' => false
						]);
						?>
					</li>
				</ol>
			</div>
			<div class="col-md-6">

				<?= $this->Form->button(__('Save'),['class'=> 'btn btn-primary pull-right']); ?>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<!-- /Card -->

