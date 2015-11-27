<?php // marks up radio buttons in the right way for styling: http://book.cakephp.org/3.0/en/views/helpers/form.html#list-of-templates
	$this->Form->templates([
    'nestingLabel' => '{{input}}<label{{attrs}}>{{text}}</label>',
    'radioWrapper' => '{{input}}{{label}}',
	]);
?>

<script type="text/javascript">
    $(document).ready(function(){
	    $('#financialquarter-id').change(function() {
	      var dataString = 'qtid='+$(this).val()+'&cal=0';
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


<div class="campaigns form col-centered col-lg-10 col-md-10 col-sm-10">

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<?= $this->Form->create($campaign,['class'=>'validatedForm','type'=>'file']); ?>
	
	<h2><?= __('Add Campaign')?></h2>
			<div class="breadcrumbs">
				<?php
					$this->Html->addCrumb('Campaigns', ['controller' => 'Campaigns', 'action' => 'index']);
					$this->Html->addCrumb('add', ['controller' => 'Campaigns', 'action' => 'add']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Vendors', 'action' => 'index'],
					    'escape' => false
					]);
				?>
			</div>
	
	<fieldset>
		<form class="form_subject">
			<label>subject line 1</label><br/>
			<div style="padding: 15px;  margin: 0 -15px 0 -15px;  border: #e2e2e2 solid 1px;  background: #f4f4f4;  -moz-border-radius: 6px;  -webkit-border-radius: 6px;  border-radius: 6px;  position: relative;  zoom: 1;">
			<input autofocus="autofocus" class=" name" id="Name" name="Name" type="text" value="" >
			</div>
			<br/>
			<br/>
			<label>subject line 2</label><br/>
			<div style="padding: 15px;  margin: 0 -15px 0 -15px;  border: #e2e2e2 solid 1px;  background: #f4f4f4;  -moz-border-radius: 6px;  -webkit-border-radius: 6px;  border-radius: 6px;  position: relative;  zoom: 1;">
			<input autofocus="autofocus" class=" name" id="Name" name="Name" type="text" value="" >
			</div><br/>
			<br/>
			<label>subject line 3</label><br/>
			<div style="padding: 15px;  margin: 0 -15px 0 -15px;  border: #e2e2e2 solid 1px;  background: #f4f4f4;  -moz-border-radius: 6px;  -webkit-border-radius: 6px;  border-radius: 6px;  position: relative;  zoom: 1;">
			<input autofocus="autofocus" class=" name" id="Name" name="Name" type="text" value="">
			</div>
			<br/><br/><br/>
			<input type="button" value="Submit ►" style="width:20%; font-size: 20px; font-weight: bolder; color:#fff; border-radius: 6px; background: #b4e391; /* Old browsers */
			background: -moz-linear-gradient(top,  #b4e391 0%, #61c419 50%, #b4e391 100%); /* FF3.6+ */
			background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#b4e391), color-stop(50%,#61c419), color-stop(100%,#b4e391)); /* Chrome,Safari4+ */
			background: -webkit-linear-gradient(top,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* Chrome10+,Safari5.1+ */
			background: -o-linear-gradient(top,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* Opera 11.10+ */
			background: -ms-linear-gradient(top,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* IE10+ */
			background: linear-gradient(to bottom,  #b4e391 0%,#61c419 50%,#b4e391 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b4e391', endColorstr='#b4e391',GradientType=0 ); /* IE6-9 */
			">
		</form>
		
		
	</fieldset>
  
</div>
