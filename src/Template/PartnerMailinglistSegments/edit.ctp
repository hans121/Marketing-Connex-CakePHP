<div class="partnerMailinglists index">
			
	<div class="row table-title partner-table-title">
	
		<div class="partner-sub-menu clearfix">
		
			<div class="col-md-6 col-sm-4">
				<h2><?= __('Edit segment')?></h2>
				<div class="breadcrumbs"> 
					<?php					
						$this->Html->addCrumb('Mailing List', ['controller' => 'PartnerMailinglistGroups', 'action' => 'index']);					
						$this->Html->addCrumb('list', ['controller' => 'PartnerMailinglists', 'action' => 'show',$id]);
						$this->Html->addCrumb('segments', ['controller' => 'PartnerMailinglistSegments', 'action' => 'show',$id]);
						echo $this->Html->getCrumbs(' / ', [
						    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
						    'url' => ['controller' => 'Partners', 'action' => 'index'],
						    'escape' => false
						]);
					?>
				</div>
			</div>
			
			<div class="col-md-6 col-sm-8">
			</div>
		
		</div>
		
	</div> <!--row-table-title-->
	
	<div class="partnerManagers form col-centered col-lg-10 col-md-10 col-sm-10">
		
	  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	   
		<?= $this->Form->create($partnerMailinglistSegment,['class'=>'validatedForm']); ?>
	    
		<fieldset>
	        
			<?php
				$auth = $this->Session->read('Auth');
				echo $this->Form->hidden('partner_mailinglist_group_id',['value'=>$id]);
				echo $this->Form->input('name',['label'=>'Segment Name']);
			?>    
			
			<div id="logic-container">
			<!--// Start //-->
			<?php
			$andidcnt = 1;
			$oridcnt = 1;
			$maxcnt = $partnerMailinglistSegmentRules->count();
			foreach($partnerMailinglistSegmentRules as $rule):
			
			// contents
			$types = 	'<select name="type['.$oridcnt.']" id="logic-type" onchange="logicConditions('.$oridcnt.')" class="form-control">'.
							'<option value="">Please select rule type</option>'.
							'<option value="first_name" '.($rule->variable=='first_name'?'selected':'').'>First Name</option>'.
							'<option value="last_name" '.($rule->variable=='last_name'?'selected':'').'>Last Name</option>'.
							'<option value="email" '.($rule->variable=='email'?'selected':'').'>Email</option>'.
							'<option value="company" '.($rule->variable=='company'?'selected':'').'>Company</option>'.
							'<option value="industry" '.($rule->variable=='industry'?'selected':'').'>Industry</option>'.
							'<option value="city" '.($rule->variable=='city'?'selected':'').'>City</option>'.
							'<option value="country" '.($rule->variable=='country'?'selected':'').'>Country</option>'.
							'<option value="created_on" '.($rule->variable=='created_on'?'selected':'').'>Date Added</option>'.
							'</select>';
							
			switch($rule->variable)
			{
				case 'first_name':
				case 'last_name':
				case 'company':
				case 'industry':
				
					$conditions =	'<select name="condition['.$oridcnt.']" id="logic-condition" onchange="logicValues('.$oridcnt.')" class="form-control">'.
									'<option value="contains" '.($rule->operand=='contains'?'selected':'').'>contains</option>'.
									'<option value="!contains" '.($rule->operand=='!contains'?'selected':'').'>does not contain</option>'.
									'<option value="provided" '.($rule->operand=='provided'?'selected':'').'>provided</option>'.
									'<option value="!provided" '.($rule->operand=='!provided'?'selected':'').'>is not provided</option>'.
									'<option value="=" '.($rule->operand=='='?'selected':'').'>matches exactly</option>'.
									'<option value="!=" '.($rule->operand=='!='?'selected':'').'>does not match exactly</option>'.
									'<option value="startswith" '.($rule->operand=='startswith'?'selected':'').'>starts with</option>'.
									'<option value="!startswith" '.($rule->operand=='!startswith'?'selected':'').'>does not start with</option>'.
									'<option value="endswith" '.($rule->operand=='endswith'?'selected':'').'>ends with</option>'.
									'<option value="!endswith" '.($rule->operand=='!endswith'?'selected':'').'>does not end with</option>'.
									'</select>';
									
					if($rule->operand=='contains' || $rule->operand=='!contains' || $rule->operand=='=' || $rule->operand=='!=' || $rule->operand=='startswith' || $rule->operand=='!startswith' || $rule->operand=='endswith' || $rule->operand=='!endswith')
						$values = '<input type="text" name="value['.$oridcnt.']" value="'.$rule->value.'" class="form-control" />';
					else
						$values = '<input type="hidden" name="value['.$oridcnt.']" value="'.$rule->value.'" />';
				
				break;
				
				case 'email':
				
					$conditions =	'<select name="condition['.$oridcnt.']" id="logic-condition" onchange="logicValues('.$oridcnt.')" class="form-control">'.
									'<option value="contains" '.($rule->operand=='contains'?'selected':'').'>contains</option>'.
									'<option value="!contains" '.($rule->operand=='!contains'?'selected':'').'>does not contain</option>'.
									'<option value="=" '.($rule->operand=='='?'selected':'').'>matches exactly</option>'.
									'<option value="!=" '.($rule->operand=='!='?'selected':'').'>does not match exactly</option>'.
									'<option value="startswith" '.($rule->operand=='startswith'?'selected':'').'>starts with</option>'.
									'<option value="!startswith" '.($rule->operand=='!startswith'?'selected':'').'>does not start with</option>'.
									'<option value="endswith" '.($rule->operand=='endswith'?'selected':'').'>ends with</option>'.
									'<option value="!endswith" '.($rule->operand=='!endswith'?'selected':'').'>does not end with</option>'.
									'</select>';
									
					$values = '<input type="text" name="value['.$oridcnt.']" value="'.$rule->value.'" class="form-control" />';
				
				break;
				
				case 'created_on':
				
					$conditions =	'<select name="condition['.$oridcnt.']" id="logic-condition" onchange="logicValues('.$oridcnt.')" class="form-control">'.
									'<option value="before" '.($rule->operand=='before'?'selected':'').'>is before</option>'.
									'<option value="after" '.($rule->operand=='after'?'selected':'').'>is after</option>'.
									'<option value="=" '.($rule->operand=='='?'selected':'').'>equals</option>'.
									'<option value="!=" '.($rule->operand=='!='?'selected':'').'>is not equal</option>'.
									'<option value="<=" '.($rule->operand=='<='?'selected':'').'>is on or before</option>'.
									'<option value=">=" '.($rule->operand=='>='?'selected':'').'>is on or after</option>'.
									'<option value="between" '.($rule->operand=='between'?'selected':'').'>is between</option>'.
									'</select>';
									
					if($rule->operand=='before' || $rule->operand=='after' || $rule->operand=='=' || $rule->operand=='!=' || $rule->operand=='<=' || $rule->operand=='>=')
						$values = '<input type="text" name="value['.$oridcnt.']" value="'.$rule->value.'" class="form-control datepicker" />';
					else // is between
					{
						$dates = explode('|',$rule->value);
						$values = '<input type="text" name="value['.$oridcnt.'][1]" value="'.$dates[0].'" class="form-control datepicker" /> <input type="text" name="value['.$oridcnt.'][2]" value="'.$dates[1].'" class="form-control datepicker" />';
					}
				
				break;
				
				case 'city':
				case 'country':
				
					$conditions =	'<select name="condition['.$oridcnt.']" id="logic-condition" onchange="logicValues('.$oridcnt.')" class="form-control">'.
									'<option value="!empty" '.($rule->operand=='!empty'?'selected':'').'>is known</option>'.
									'<option value="empty" '.($rule->operand=='empty'?'selected':'').'>is not known</option>'.
									'<option value="=" '.($rule->operand=='='?'selected':'').'>is in</option>'.
									'<option value="!=" '.($rule->operand=='!='?'selected':'').'>is not in</option>'.
									'</select>';
									
					if($rule->operand=='=' || $rule->operand=='!=')
					{
						$values =	'<select name="value['.$oridcnt.']" id="logic-condition" onchange="logicValues('.$oridcnt.')" class="form-control">';
						
						if($rule->variable=='city')
						foreach($cities as $list)
							$values .=   "<option value=\"{$list->city}\" ".($rule->value==$list->city?'selected':'').">{$list->city}</option>";	
						
						if($rule->variable=='country')
						foreach($countries as $list)
							$values .=   "<option value=\"{$list->country}\" ".($rule->value==$list->country?'selected':'').">{$list->country}</option>";	
						
						$values .=	'</select>';
					}
					else
						$values = '<input type="hidden" name="value['.$oridcnt.']" value="" />';
				
				break;
				
				default:			
					$conditions = 	'<input type="hidden" name="condition['.$oridcnt.']" value="" />';
					$values = '<input type="hidden" name="value['.$oridcnt.']" value="'.$rule->value.'" />';	
			}			
			// end contents
			
			if($rule->logic==''):
			?>
			<div id="logic-frame-<?=$andidcnt?>">
			<div id="logic-<?=$andidcnt?>">
				<input type="hidden" name="logic[<?=$oridcnt?>]" value="" />
			<?php
			elseif($rule->logic=='and'):
			$andidcnt++;
			?>
			</div>			
			<script>
			$('#logic-<?=$andidcnt-1?> .orbtn').last().removeAttr('disabled');
			</script>
			<div class="row"><div class="col-lg-12"><a href="and" onclick="addLogic('and');disable(this);return false;" class="btn btn-sm andbtn" disabled="disabled">AND</a></div></div>
			</div>
			<div id="logic-frame-<?=$andidcnt?>">
			<div class="row"><div class="col-lg-12"><hr /></div></div>
			<div id="logic-<?=$andidcnt?>">
				<input type="hidden" name="logic[<?=$oridcnt?>]" value="and" />
			<?php
			else:
			?>
				<input type="hidden" name="logic[<?=$oridcnt?>]" value="or" />
			<?php
			endif;			
			?>
				<div id="logic-element-<?=$oridcnt?>" onmouseover="showTrash(<?=$oridcnt?>)" onmouseout="hideTrash(<?=$oridcnt?>)" class="row">
					<div class="col-lg-3" id="logic-types-<?=$oridcnt?>"><?=$types?></div>
					<div class="col-lg-3" id="logic-conditions-<?=$oridcnt?>"><?=$conditions?></div>
					<div class="col-lg-4" id="logic-values-<?=$oridcnt?>"><?=$values?></div>
					<div class="col-lg-2 text-right"><a href="or" onclick="addLogic('or',<?=$andidcnt?>);disable(this);return false;" class="btn btn-sm orbtn" disabled="disabled">OR</a><?=($rule->logic?'<a href="remove" onclick="removeLogic('. $oridcnt .','. $andidcnt .');return false;"><span id="logic-delete-'. $oridcnt .'" style="width:30px;visibility:hidden;" class="glyphicon glyphicon-trash"></span></a>':'<span style="width:30px;visibility:hidden;" class="glyphicon glyphicon-trash"></span>')?></div>
				</div>
			<?php
			//if($rule->logic=='and') $andidcnt++;
			$oridcnt++;
			endforeach;
			?>
			</div>
			<div class="row"><div class="col-lg-12"><a href="and" onclick="addLogic('and');disable(this);return false;" class="btn btn-sm andbtn">AND</a></div></div>
			</div>
			<script>
			$('#logic-<?=$andidcnt?> .orbtn').last().removeAttr('disabled');			
			$('#logic-container .andbtn').last().removeAttr('disabled');
			$( ".datepicker" ).datepicker( {dateFormat:"dd/mm/yy"} );
			</script>
			<!--// End //-->			
			</div>
	   
	    <?php echo $this->element('form-submit-bar'); ?>
	    
		</fieldset>
		
	  <?= $this->Form->end(); ?>
	  
	</div>

</div> <!-- /#content -->
<script>
	var andidcnt = <?=$andidcnt?>;
	var oridcnt = <?=$oridcnt?>;
	
	function logicTypes(id)
	{
		var obj = $('#logic-types-'+id);
		var html = 	'<select name="type['+id+']" id="logic-type" onchange="logicConditions('+id+')" class="form-control">'+
				'<option value="">Please select rule type</option>'+
				'<option value="first_name">First Name</option>'+
				'<option value="last_name">Last Name</option>'+
				'<option value="email">Email</option>'+
				'<option value="company">Company</option>'+
				'<option value="industry">Industry</option>'+
				'<option value="city">City</option>'+
				'<option value="country">Country</option>'+
				'<option value="created_on">Date Added</option>'+
				'</select>';
		
		obj.html(html);
	}
	
	function logicConditions(id)
	{
		var refobj = $('#logic-types-'+id+' > #logic-type');
		var obj = $('#logic-conditions-'+id);
		var valobj = $('#logic-values-'+id);
		var html = '';
		
		switch(refobj.val())
		{
			case 'first_name':
			case 'last_name':
			case 'company':
			case 'industry':
			
				html =	'<select name="condition['+id+']" id="logic-condition" onchange="logicValues('+id+')" class="form-control">'+
						'<option value="contains">contains</option>'+
						'<option value="!contains">does not contain</option>'+
						'<option value="provided">provided</option>'+
						'<option value="!provided">is not provided</option>'+
						'<option value="=">matches exactly</option>'+
						'<option value="!=">does not match exactly</option>'+
						'<option value="startswith">starts with</option>'+
						'<option value="!startswith">does not start with</option>'+
						'<option value="endswith">ends with</option>'+
						'<option value="!endswith">does not end with</option>'+
						'</select>';
			
			break;
			
			case 'email':
			
				html =	'<select name="condition['+id+']" id="logic-condition" onchange="logicValues('+id+')" class="form-control">'+
						'<option value="contains">contains</option>'+
						'<option value="!contains">does not contain</option>'+
						'<option value="=">matches exactly</option>'+
						'<option value="!=">does not match exactly</option>'+
						'<option value="startswith">starts with</option>'+
						'<option value="!startswith">does not start with</option>'+
						'<option value="endswith">ends with</option>'+
						'<option value="!endswith">does not end with</option>'+
						'</select>';
			
			break;
			
			case 'created_on':
			
				html =	'<select name="condition['+id+']" id="logic-condition" onchange="logicValues('+id+')" class="form-control">'+
						'<option value="before">is before</option>'+
						'<option value="after">is after</option>'+
						'<option value="=">equals</option>'+
						'<option value="!=">is not equal</option>'+
						'<option value="<=">is on or before</option>'+
						'<option value=">=">is on or after</option>'+
						'<option value="between">is between</option>'+
						'</select>';
			
			break;
			
			case 'city':
			case 'country':
			
				html =	'<select name="condition['+id+']" id="logic-condition" onchange="logicValues('+id+')" class="form-control">'+
						'<option value="!empty">is known</option>'+
						'<option value="empty">is not known</option>'+
						'<option value="=">is in</option>'+
						'<option value="!=">is not in</option>'+
						'</select>';
			
			break;
			
			default:			
				html = '<input type="hidden" name="condition['+id+']" value="" />';
		}
		
		obj.html(html);
		valobj.html(html);
		logicValues(id);
	}
	
	function logicValues(id)
	{
		var refobj1 = $('#logic-types-'+id+' > #logic-type');
		var refobj2 = $('#logic-conditions-'+id+' > #logic-condition');
		var obj = $('#logic-values-'+id);
		var cond = refobj2.val();
		var html = '';
		
		switch(refobj1.val())
		{
			case 'first_name':
			case 'last_name':
			case 'company':
			case 'industry':
			
				if(cond=='contains' || cond=='!contains' || cond=='=' || cond=='!=' || cond=='startswith' || cond=='!startswith' || cond=='endswith' || cond=='!endswith')
					html = '<input type="text" name="value['+id+']" value="" class="form-control" />';
				else
					html = '<input type="hidden" name="value['+id+']" value="" />';
			
			break;
			
			case 'email':
			
				html = '<input type="text" name="value['+id+']" value="" class="form-control" />';
			
			break;
			
			case 'created_on':
			
				if(cond=='before' || cond=='after' || cond=='=' || cond=='!=' || cond=='<=' || cond=='>=')
					html = '<input type="text" name="value['+id+']" value="" class="form-control datepicker" />';
				else
					html = '<input type="text" name="value['+id+'][1]" value="" class="form-control datepicker" /> <input type="text" name="value['+id+'][2]" value="" class="form-control datepicker" />';
			
			break;
			
			case 'city':
				if(cond=='=' || cond=='!=')
				{
					html =	'<select name="value['+id+']" id="logic-condition" onchange="logicValues('+id+')" class="form-control">'+
					<?php
					foreach($cities as $list)
					echo   "'<option value=\"{$list->city}\">{$list->city}</option>'+";	
					?>
							'</select>';
				}
				else
					html = '<input type="hidden" name="value['+id+']" value="" />';
			
			break;
			case 'country':
			
				if(cond=='=' || cond=='!=')
				{
					html =	'<select name="value['+id+']" id="logic-condition" onchange="logicValues('+id+')" class="form-control">'+
					<?php
					foreach($countries as $list)
					echo   "'<option value=\"{$list->country}\">{$list->country}</option>'+";	
					?>
							'</select>';
				}
				else
					html = '<input type="hidden" name="value['+id+']" value="" />';
			
			break;
			
			default:			
				html = '<input type="hidden" name="value['+id+']" value="" />';		
		}
				
		obj.html(html);
		$( ".datepicker" ).datepicker( {dateFormat:"dd/mm/yy"} );
	}
	
	function disable(obj)
	{
		$(obj).attr('disabled','disabled');
	}
	
	function showTrash(id)
	{
		$('#logic-delete-'+id).css('visibility','visible');
	}
	
	function hideTrash(id)
	{
		$('#logic-delete-'+id).css('visibility','hidden');
	}
	
	function removeLogic(id,mainid)
	{
		$('#logic-element-'+id).remove();
		
		$('#logic-'+mainid+' .orbtn').last().removeAttr('disabled');
		
		if($('#logic-'+mainid+' .orbtn').length==0)
		{
			$('#logic-frame-'+mainid).remove();
			$('#logic-container .andbtn').last().removeAttr('disabled');
		}
	}
	
	function addLogic(logic,id)
	{
		var html = '';
		
		switch(logic)
		{
			case 'or':				
				container = $('#logic-'+id);
				
				html = 	'<input type="hidden" name="logic['+ oridcnt +']" value="or" />'+
						'	<div id="logic-element-'+ oridcnt +'" onmouseover="showTrash('+ oridcnt +')" onmouseout="hideTrash('+ oridcnt +')" class="row">'+
						'		<div class="col-lg-3" id="logic-types-'+ oridcnt +'"></div>'+
						'		<div class="col-lg-3" id="logic-conditions-'+ oridcnt +'"></div>'+
						'		<div class="col-lg-4" id="logic-values-'+ oridcnt +'"></div>'+
						'		<div class="col-lg-2 text-right"><a href="or" onclick="addLogic(\'or\','+ id +');disable(this);return false;" class="btn btn-sm orbtn">OR</a><a href="remove" onclick="removeLogic('+ oridcnt +','+ id +');return false;"><span id="logic-delete-'+ oridcnt +'" style="width:30px;visibility:hidden;" class="glyphicon glyphicon-trash"></span></a></div>'+
						'	</div>';
				break;
			default:
				if(logic=='and') andidcnt++;
				
				container = $('#logic-container');
				
				html =	'<div id="logic-frame-'+ andidcnt +'">'+
						(logic=='and'?'<div class="row"><div class="col-lg-12"><hr /></div></div><input type="hidden" name="logic['+ oridcnt +']" value="and" />':'<input type="hidden" name="logic['+ oridcnt +']" value="" />')+
						'<div id="logic-'+ andidcnt +'">'+
						'	<div id="logic-element-'+ oridcnt +'" onmouseover="showTrash('+ oridcnt +')" onmouseout="hideTrash('+ oridcnt +')" class="row">'+
						'		<div class="col-lg-3" id="logic-types-'+ oridcnt +'"></div>'+
						'		<div class="col-lg-3" id="logic-conditions-'+ oridcnt +'"></div>'+
						'		<div class="col-lg-4" id="logic-values-'+ oridcnt +'"></div>'+
						'		<div class="col-lg-2 text-right"><a href="or" onclick="addLogic(\'or\','+ andidcnt +');disable(this);return false;" class="btn btn-sm orbtn">OR</a>'+(logic?'<a href="remove" onclick="removeLogic('+ oridcnt +','+ andidcnt +');return false;"><span id="logic-delete-'+ oridcnt +'" style="width:30px;visibility:hidden;" class="glyphicon glyphicon-trash"></span></a>':'<span style="width:30px;visibility:hidden;" class="glyphicon glyphicon-trash"></span>')+'</div>'+
						'	</div>'+						
						'</div>'+
						'<div class="row"><div class="col-lg-12"><a href="and" onclick="addLogic(\'and\');disable(this);return false;" class="btn btn-sm andbtn">AND</a></div></div>'+
						'</div>';
		}		
		
		container.append( html );
		logicTypes(oridcnt);
		
		oridcnt++;
	}
	
	$(function(){
		if(andidcnt==1 && oridcnt==1)
		addLogic();
	});
</script>