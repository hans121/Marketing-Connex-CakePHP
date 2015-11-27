<?php
	$admn = $this->Session->read('Auth');
//print_r($emailTemplate);
	if(isset($emailTemplate['vendor']->logo_url) ){
	    $vlogo      =    $this->Html->image($emailTemplate['vendor']->logo_url,['height'=>60,'width'=>100,'class'=>'left']);
	    $viewhtml   =   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
	}
	
	if(isset($admn['User']['logo_url'])){
	    $plogo      =    $this->Html->image($admn['User']['logo_url'],['height'=>60,'width'=>100,'class'=>'right']);
	    $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
	}
    $viewhtml   =   str_replace('[*!WEBLINK!*]',$siteURL.'/partner_campaigns/view/'.$emailTemplate['id'].'/'.$admn['User']['partner_id'], $viewhtml); 
	
	if(isset($admn['User']['logo_url'])){
	    $pname      =   $admn['User']['company_name'];
	    $viewhtml   =   str_replace('[*!PARTNERNAME!*]',$pname, $viewhtml);
	}
	

	
	if(isset($emailTemplate->banner_bg_image)&& $emailTemplate->banner_bg_image != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'bgimages'.DS.$emailTemplate->banner_bg_image)){
	    $bannerbgimage   =   $this->Html->image('/img/emailtemplates' . DS .'bgimages'.DS.$emailTemplate->banner_bg_image,['alt'=>'Banner']);
	    $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
	}
	
	if(isset($emailTemplate->cta_bg_image)&& $emailTemplate->cta_bg_image != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'ctaimages'.DS.$emailTemplate->cta_bg_image)){
	    $ctabgimage   =   $this->Html->image('/img/emailtemplates' . DS .'ctaimages'.DS.$emailTemplate->cta_bg_image,['alt'=>'CTA Image']);
	    $viewhtml   =   str_replace('[*!CTAIMAGE!*]',$ctabgimage, $viewhtml);
	}
	
	echo $viewhtml;

?>
