<?php
	echo
	'<div class="row checkbox_group">';

	echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('IT Consulting').
		'</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('itconsulting' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'itconsulting']).
				'<label class="onoffswitch-label" for="itconsulting">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';


	echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Software Development').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('softwaredev' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'softwaredev']).
				'<label class="onoffswitch-label" for="softwaredev">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
		
	echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Telecoms').
		'</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('telecom' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'telecom']).
				'<label class="onoffswitch-label" for="telecom">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('VOIP').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('voip' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'voip']).
				'<label class="onoffswitch-label" for="voip">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Internet services').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('internet' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'internet']).
				'<label class="onoffswitch-label" for="internet">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Professional services').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('professional' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'professional']).
				'<label class="onoffswitch-label" for="professional">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Apps hosting').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('appshost' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'appshost']).
				'<label class="onoffswitch-label" for="appshost">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Storage').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('storagex' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'storage']).
				'<label class="onoffswitch-label" for="storage">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
      
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Custom systems').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('customsystem' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'customsystem']).
				'<label class="onoffswitch-label" for="customsystem">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Wireless').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('wireless' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'wireless']).
				'<label class="onoffswitch-label" for="wireless">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Cloud').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('cloud' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'cloud']).
				'<label class="onoffswitch-label" for="cloud">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Service provider').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('serviceprovider' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'serviceprovider']).
				'<label class="onoffswitch-label" for="serviceprovider">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
        echo
		'<label class="col-md-4 col-xs-6 control-label">'
			.__('Disaster recovery / business continuity').
		'</label>'.
	    '<div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('disaster' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'disaster']).
				'<label class="onoffswitch-label" for="disaster">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
		
	echo
	'</div>';
?>