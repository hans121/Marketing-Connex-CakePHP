<?php echo $this->Flash->render(); echo $this->Flash->render('auth');;
$this->assign('title', $landingPage->heading);
echo $this->Form->create($landingForm,array('id' => 'landingForm'));
//$frmstr =   '<form method="post" action="url">';
$frmstr = '<div id="resource-form">';
$frmstr .=  $this->Form->input('landing_page_id', ['type' => 'hidden','value'=>$landingPage->id]);
if($landingPage->chk_first_name ==   'Y'){
    $frmstr .=  $this->Form->input('first_name');
}
if($landingPage->chk_last_name ==   'Y'){
    $frmstr .=  $this->Form->input('last_name');
}
if($landingPage->chk_email ==   'Y'){
    $frmstr .=  $this->Form->input('email_address');
}
if($landingPage->chk_phone ==   'Y'){
    $frmstr .=  $this->Form->input('phone');
}
if($landingPage->chk_fax ==   'Y'){
    $frmstr .=  $this->Form->input('fax',['label'=>'Fax Number']);
}
if($landingPage->chk_company ==   'Y'){
    $frmstr .=  $this->Form->input('company');
}
if($landingPage->chk_job_title ==   'Y'){
    $frmstr .=  $this->Form->input('job_title');
}
if($landingPage->chk_message ==   'Y'){
    $frmstr .=  $this->Form->input('message');
}
$frmstr .=  $this->Form->button(__('Submit'));
$frmstr .= '</div>';
$frmstr .=  $this->Form->end(); 
if($landingPage->chk_frm_submission !=   'Y' && is_file(WWW_ROOT  .'files' . DS .'landingpages'.DS.$landingPage->downloadable_item))
{
			$frmstr .= '<div id="resource-link">';
		  $frmstr .=  $this->Form->postLink(__('Download Resource'), ['action' => 'downloadfile', $landingPage->id],['class' => 'download-button']);
			$frmstr .= '</div>';
}

echo $this->Form->hidden('vendor_name',['value'=>$vendor_name]);
echo $this->Form->hidden('campaign_desc',['value'=>$campaign_desc]);

$viewhtml   =   str_replace('[*!FRMFIELDS!*]',$frmstr, $viewhtml);
if(isset($landingPage->banner_text)&& trim($landingPage->banner_text !='')){
    $btext   =   $landingPage->banner_text;
}else{
    $btext   =   __('');
}
$viewhtml   =   str_replace('[*!BANNERTEXT!*]',$btext, $viewhtml);
if(isset($landingPage->banner_bg_image)&& is_file(WWW_ROOT  .'img' . DS . 'landingpages' . DS .'bgimages'.DS.$landingPage->banner_bg_image)){
    $bannerbgimage   =   $this->Html->image('landingpages' . DS .'bgimages' . DS . $landingPage->banner_bg_image,['alt'=>$btext]);
    $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
} else {
	$viewhtml   =   str_replace('[*!BANNERIMAGE!*]','', $viewhtml);
}
    if(isset($landingPage['vendor']['logo_url'])){
      $plogo      =    $this->Html->image($landingPage['vendor']['logo_url'],['height'=>60,'width'=>100,'class'=>'right']);
      $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
    }


$vlogo  =    $this->Html->image($landingPage['vendor']->logo_url,['height'=>60,'width'=>'100']);
$viewhtml   =   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
echo $viewhtml;