
<?php 

echo $this->Form->input('campaign_id', ['options' => $campaigns,'value'=>$bpcampaigns,'data-live-search' => false,'multiple'=>true]);?>

<?php

/*
echo
	'<div class="row checkbox_group">';
$inc=0;
foreach($campaigns as $id=>$val):
    
    echo
		'<label class="col-md-3 col-xs-6 control-label">'
			.$val.
		'</label>
	    <div class="col-md-3 col-xs-6">'.
			'<div class="onoffswitch">'.
					$this->Form->checkbox('campaign_id[]' ,['value'=>$id, 'class'=>'onoffswitch-checkbox', 'id'=>'campaign_id'.$inc]).
				'<label class="onoffswitch-label" for="campaign_id'.$inc.'">'.
					'<span class="onoffswitch-inner"></span>'.
					'<span class="onoffswitch-switch"></span>'.
				'</label>'.
			'</div>'.
		'</div>';
$inc++;
endforeach;
echo
	'</div>';
	*/
?>