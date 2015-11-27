<?php
	echo
	'<div class="row checkbox_group">';

	echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('First name').
		'</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('chk_first_name' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'chk_first_name']).
				'<label class="onoffswitch-label" for="chk_first_name">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';

        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('E-mail address').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('chk_email' ,['value'=>'Y', 'checked'=>($landingPage->chk_email=='Y' ? true : false), 'class'=>'onoffswitch-checkbox', 'id'=>'chk_email']).
				'<label class="onoffswitch-label" for="chk_email">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
	echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Last name').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('chk_last_name' ,['value'=>'Y', 'checked'=>($landingPage->chk_last_name=='Y' ? true : false), 'class'=>'onoffswitch-checkbox', 'id'=>'chk_last_name']).
				'<label class="onoffswitch-label" for="chk_last_name">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
		
	echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Phone number').
		'</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('chk_phone' ,['value'=>'Y', 'checked'=>($landingPage->chk_phone=='Y' ? true : false), 'class'=>'onoffswitch-checkbox', 'id'=>'chk_phone']).
				'<label class="onoffswitch-label" for="chk_phone">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
	echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Company').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('chk_company' ,['value'=>'Y', 'checked'=>($landingPage->chk_company=='Y' ? true : false), 'class'=>'onoffswitch-checkbox', 'id'=>'chk_company']).
				'<label class="onoffswitch-label" for="chk_company">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
		
	echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Fax number').
		'</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('chk_fax' ,['value'=>'Y', 'checked'=>($landingPage->chk_fax=='Y' ? true : false), 'class'=>'onoffswitch-checkbox', 'id'=>'chk_fax']).
				'<label class="onoffswitch-label" for="chk_fax">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Job title').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('chk_job_title' ,['value'=>'Y', 'checked'=>($landingPage->chk_job_title=='Y' ? true : false), 'class'=>'onoffswitch-checkbox', 'id'=>'chk_job_title']).
				'<label class="onoffswitch-label" for="chk_job_title">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
		
	echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Message').
		'</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('chk_message' ,['value'=>'Y', 'checked'=>($landingPage->chk_message=='Y' ? true : false), 'class'=>'onoffswitch-checkbox', 'id'=>'chk_message']).
				'<label class="onoffswitch-label" for="chk_message">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';	
	echo
	'</div>';
        

?>