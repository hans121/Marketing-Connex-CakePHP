	
	<?php // Get the current status and set the checkboxes accordingly
	
		if(isset($campaign->html) && $campaign->html == 'Y'){ 
			$htmlchk	=	true;
		} else {
			$htmlchk	=	false;
		};

		if(isset($campaign->mobile_delivery) && $campaign->mobile_delivery == 'Y'){ 
			$mobilechk	=	true;
		} else {
			$mobilechk	=	false;
		};

		if(isset($campaign->include_landing_page) && $campaign->include_landing_page == 'Y'){ 
			$landingchk	=	true;
		} else {
			$landingchk	=	false;
		};
	
	?>



<?php
	echo
	'<div class="checkbox_group checkboxes-inline">';

	echo

		
			'<div class="row input--field input--field_false">'.
			
				'<div class="col-md-4"><label>'.__('HTML Email').'</label></div>'.
				
				'<div class="col-md-3">'.
					
							$this->Form->checkbox('html' ,['id'=>'html','checked'=>$htmlchk, 'data-size' => 'mini', 'hiddenField'=>false]).
				'</div>'.
				'<div class="col-md-6">'.
				

            '</div>'.
			'</div>';



	echo

		
			'<div class="row input--field input--field_false">'.
			
				'<div class="col-md-4"><label>'.__('Include landing page').'</label></div>'.
				
				'<div class="col-md-3">'.
					
							$this->Form->checkbox('include_landing_page' ,['value'=>'Y', 'id'=>'include_landing_page','checked'=>$landingchk, 'data-size' => 'mini', 'hiddenField'=>false]).
				'</div>'.
				'<div class="col-md-6">'.
				

			'</div>'.
			'</div>';
		
	echo
	'</div>';
?>

<script>
$("[name='include_landing_page']").bootstrapSwitch();
$("[name='html']").bootstrapSwitch();

</script>