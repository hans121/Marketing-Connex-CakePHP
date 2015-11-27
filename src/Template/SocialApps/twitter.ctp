<?php 
if(isset($this->request->query['denied'])) {
	echo $this->Html->link(
    'Please try again.',
     ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'twitterInitialize'],['class'=>'btn btn-lg']
);
}
 ?>
