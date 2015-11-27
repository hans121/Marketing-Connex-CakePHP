<?php
	echo
	'<div class="row checkbox_group">';

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Resource Library
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('resource_library' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'resource_library']).
				'<label class="onoffswitch-label" for="resource_library">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			MDF
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('MDF' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'MDF']).
				'<label class="onoffswitch-label" for="MDF">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Portal CMS
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('portal_cms' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'portal_cms']).
				'<label class="onoffswitch-label" for="portal_cms">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Joint Business
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('joint_business' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'joint_business']).
				'<label class="onoffswitch-label" for="joint_business">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';		

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Lead Distribution
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('lead_distribution' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'lead_distribution']).
				'<label class="onoffswitch-label" for="lead_distribution">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
		

		
	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Deal Registration
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('deal_registration' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'deal_registration']).
				'<label class="onoffswitch-label" for="deal_registration">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Partner Recruitment
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('partner_recruit' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'partner_recruit']).
				'<label class="onoffswitch-label" for="partner_recruit">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Training
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('training' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'training']).
				'<label class="onoffswitch-label" for="training">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Social Media
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('Socialmedia' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'Socialmedia']).
				'<label class="onoffswitch-label" for="Socialmedia">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
		
	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Multi-Lingual
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('multilingual' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'multilingual']).
				'<label class="onoffswitch-label" for="multilingual">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Partner Incentive
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('partner_incentive' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'partner_incentive']).
				'<label class="onoffswitch-label" for="partner_incentive">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';

	echo
		'<label class="col-md-4 col-xs-6 control-label">
			Partner App
		</label>
	    <div class="col-md-2 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('partner_app' ,['value'=>'Y', 'class'=>'onoffswitch-checkbox', 'id'=>'partner_app']).
				'<label class="onoffswitch-label" for="partner_app">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
		
	echo
	'</div>';
?>