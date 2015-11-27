<div class="campaigns form col-centered col-lg-10 col-md-10 col-sm-10">

  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
	<div class="row">
	<div class="col-lg-2">
		<h2><?= __('Edit Lead')?></h2>
		<div class="breadcrumbs">
			<?php
				$this->Html->addCrumb('Leads', ['controller' => 'PartnerLeads', 'action' => 'index']);
				$this->Html->addCrumb('edit', ['action' => 'edit',$lead->id]);
				echo $this->Html->getCrumbs(' / ', [
				    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
				    'url' => ['controller' => 'Partners', 'action' => 'index'],
				    'escape' => false
				]);
			?>
		</div>
	</div>
	<?php
	$expiry_time = strtotime($lead->expire_on);
	$expiry = date('d/m/Y',$expiry_time);
	$days_before_expiry = round(($expiry_time - time()) / 86400);
	if($days_before_expiry >= 15)
		$color = 'green'; //new
	elseif($days_before_expiry >= 5)
		$color = 'orange'; //middle
	else
		$color = 'red'; //old
	?>
	<div class="col-lg-3"><h4 class="expiryLabel">| Expires: <span style="color:<?=$color?>"><?=$expiry?></span></h4></div>
	<div class="col-lg-7">
		<div class="pull-right" id="statusBtns">
			<?= $this->Html->link(__('Reject Lead'), ['action'=>'ajaxLeadAction'],['class'=>'btn btn-lg','id'=>'btnReject']); ?> <?= $this->Html->link(__('Accept Lead'), ['action'=>'ajaxLeadAction'],['class'=>'btn btn-lg','id'=>'btnAccept']); ?>
		</div>
	</div>
	
	<div class="col-lg-12">
	<fieldset>
	<?= $this->Form->create($lead,['class'=>'validatedForm','type'=>'file']); ?>
	<?php
	    $auth = $this->Session->read('Auth');
	    echo $this->Form->hidden('partner_id', ['value' => $auth['User']['partner_id']]);
		echo $this->Form->input('first_name',['disabled'=>true]);
		echo $this->Form->input('last_name',['disabled'=>true]);
		echo $this->Form->input('company',['disabled'=>true]);
		echo $this->Form->input('position',['disabled'=>true]);
		echo $this->Form->input('phone',['disabled'=>true]);
		echo $this->Form->input('email',['disabled'=>true]);
	?>
	<?= $this->Form->end(); ?>
	<div class="pull-left"><h4><?= __('Lead Instructions')?></h4></div><div class="pull-right expiryLabel">Lead Expires: <?=$expiry?></div>
	<div class="clearfix"><br /><hr /></div>
	<p>Standard SLA terms: Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	<div class="clearfix"><br /></div>
	<h4><?= __('Instructions / Notes from '.$lead->vendor->company_name)?></h4>
	<hr />
	<p><?=nl2br($lead->note)?></p>
	<div class="clearfix"><br /></div>
	<a name="leadoutcome" />
	<h4><?= __('Outcome of Lead')?></h4>
	<hr />
	<?= $this->Form->create($lead,['class'=>'validatedForm','id'=>'frmLead']); ?>
	<p>
	<?php
		$outcomes = ['converted'=>'Converted to Deal','nurturing'=>'Nurturing','qualifiedout'=>'Qualified Out'];
		echo $this->Form->input('response_status', ['disabled'=>true,'id'=>'responseStatus','label'=>'Outcome','value'=>$lead->response_status,'options' => $outcomes,'data-live-search' => false]);
	?>
	<div id="responseNote">
	<?=$this->Form->input('response_note',['disabled'=>true,'label'=>'Outcome Note']);?>
	</div>
	</p>
	<div id="outcomeBtns">
	<div class="row submit-bar">
		<div class="col-md-12">
			<?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'pull-left btn btn-lg btn-cancel']); ?>					
			<?= $this->Form->button(__('Submit'),['class'=> 'pull-right btn btn-lg','disabled'=>true]); ?>
		</div>
	</div>
	</div>
	<?= $this->Form->end(); ?>	
	<div class="clearfix"><br /></div>	
	<?= $this->Form->create($lead_deal,['class'=>'validatedForm','id'=>'frmRegDeal','type'=>'file']); ?>
	<div id="regForm">
	<a name="registerdeal" />
	<h4><?= __('Register Deal')?></h4>
	<hr />
	<?php
	 	echo $this->Form->hidden('lead_id', ['value' => $lead->id]);
	 	echo $this->Form->hidden('partner_id', ['value' => $lead->partner_id]);
		echo $this->Form->input('partner_manager_id', ['disabled'=>true,'id'=>'partnerManagerSelect','label'=>'Manager Selling','value'=>$lead_deal->partner_manager_id,'options' => $partners,'data-live-search' => true]);
		echo $this->Form->input('product_description',['disabled'=>true]);
		echo $this->Form->input('quantity_sold',['disabled'=>true]);
		echo $this->Form->input('deal_value',['disabled'=>true]);
	?>
	<label>Close Deal</label>
	<div class="onoffswitch">
		<?= $this->Form->checkbox('status' ,['disabled'=>true,'checked'=>($lead_deal['status']=='Y'?'checked':false), 'class'=>'onoffswitch-checkbox', 'id'=>'status', 'name'=>'status', 'value'=>'Y']) ?>
		<label class="onoffswitch-label" for="status">
			<span class="onoffswitch-inner"></span>
			<span class="onoffswitch-switch"></span>
		</label>
	</div>
	<br /><br />	
	<div class="row submit-bar">
		<div class="col-md-12">
			<?= $this->Html->link(__('Cancel'), $last_visited_page,['class' => 'pull-left btn btn-lg btn-cancel']); ?>					
			<?= $this->Form->button(__('Submit'),['class'=> 'pull-right btn btn-lg','disabled'=>true]); ?>
		</div>
	</div>
	
	</div>
	<?= $this->Form->end(); ?>	
	</fieldset>
	</div>
	</div>

  
</div>
<script>

$(document).ready(function(){

	function partnerLeadStatus(status)
	{
		var note = '';
		if(status=='rejected')
			note = prompt('Your message to vendor:');
			
		$.ajax ({
			type: "POST",
			url: "<?php echo $this->Url->build([ "controller" => "PartnerLeads","action" => "ajaxLeadAction", $lead->id],true);?>",
			data: "status="+status+"&note="+note,
			cache: false,
			success: function(resp)
			{
				if(resp=='rejected')
					document.location="<?php echo $this->Url->build([ "controller" => "PartnerLeads","action" => "index"],true);?>";
				else
				{
					clearAllFields();
					document.location="#leadoutcome";
				}
			}
		});
	}
	
	function clearAllFields()
	{
		$('#statusBtns').hide();
		$('#frmLead *').attr('disabled',false);		
		$('#frmLead *').removeClass('disabled');
		$('#frmRegDeal *').attr('disabled',false);
		$('#frmRegDeal *').removeClass('disabled');
		$('.expiryLabel').hide();
	}
	
	$('#btnReject').click(function(){
		partnerLeadStatus('rejected');
		return false;
	});
	
	$('#btnAccept').click(function(){
		partnerLeadStatus('accepted');
		return false;
	});
	
	$('#responseStatus').change(function() {
		var status = this.value;
		var regform = $('#regForm');
		var outcomebtns = $('#outcomeBtns');
		var responsenote = $('#responseNote');
		if(status=='converted')
		{
			regform.show();
			outcomebtns.hide();
			responsenote.hide();
		}
		else if(status=='nurturing')
		{
			regform.hide();
			outcomebtns.show();
			responsenote.show();
		}
		else if(status=='qualifiedout')
		{
			regform.hide();
			outcomebtns.show();
			responsenote.show()
		}
		else
		{
			regform.hide();
			outcomebtns.hide();
			responsenote.hide();
		}
			
	});
	
	<?php if($lead->response!=''): ?>
	clearAllFields();
	<?php endif; ?>
	
	$('#outcomeBtns').hide();
	$('#responseNote').hide();
	$('#responseStatus').change();
});
</script>