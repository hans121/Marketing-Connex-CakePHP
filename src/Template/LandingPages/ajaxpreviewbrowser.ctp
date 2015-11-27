<?php
	
	$this->assign('title', $landingPage->heading);
	$admn = $this->Session->read('Auth');
	
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
		$frmstr .= '<div class="input textarea"><label for="message">Message</label>';
	  $frmstr .=  $this->Form->textarea('message');
		$frmstr .= '</div>';
	}
		$frmstr .=  $this->Form->button(__('Send'),['class'=>'btn']);
		$frmstr .= '</div>';
		
	if($landingPage->chk_frm_submission !=   'Y'){
		$frmstr .= '<div id="resource-link" style="display:none;">';
	  $frmstr .=  $this->Form->postLink(__('Download Resource'), ['action' => 'downloadfile', $landingPage->id],['class' => 'download-button']);
		$frmstr .= '</div>';
	} else {
		$frmstr .= '<div id="resource-link">';
	  $frmstr .=  $this->Form->postLink(__('Download Resource'), ['action' => 'downloadfile', $landingPage->id],['class' => 'download-button']);
		$frmstr .= '</div>';
	}
	
	$viewhtml   =   str_replace('[*!FRMFIELDS!*]',$frmstr, $viewhtml);
	
	if(isset($landingPage->banner_text)&& trim($landingPage->banner_text !='')){
    $btext   =   $landingPage->banner_text;
	} else {
    $btext   =   __('Banner Image');
	}
	
	$viewhtml   =   str_replace('[*!BANNERTEXT!*]',$btext, $viewhtml);
	
	if(isset($bannerbgfilename)&& $bannerbgfilename != null && is_file(WWW_ROOT  .'img' . DS . 'tmppreview' . DS .'bgimages'.DS.$bannerbgfilename)) {
	    $bannerbgimage	=   $this->Html->image('tmppreview' . DS .'bgimages'.DS.$bannerbgfilename,['alt'=>'Banner']);
	    $viewhtml   		=   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
	} elseif(true == $editflag && true== $editbannerimg) {
	    $bannerbgimage	=   $this->Html->image('landingpages' . DS .'bgimages'.DS.$bannerbgfilename,['alt'=>'Banner']);
	    $viewhtml   		=   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
	}
	if(isset($bannerbgfilename)&& $bannerbgfilename != null && is_file(WWW_ROOT  .'img' . DS . 'landingpages' . DS .'bgimages'.DS.$bannerbgfilename)) {
	    $bannerbgimage	=   $this->Html->image('landingpages' . DS .'bgimages'.DS.$bannerbgfilename,['alt'=>'Banner']);
	    $viewhtml   		=   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
	}
	if(isset($landingPage['vendor'])) {
	    $vlogo  				=    $this->Html->image('logos' . DS .$landingPage['vendor']->logo_url,['height'=>60,'width'=>100,'class'=>'left']);
	    $viewhtml   		=   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
	} elseif(isset($admn['User']['logo_url'])) {
	    $vlogo      		=    $this->Html->image('logos' . DS .$admn['User']['logo_url'],['height'=>60,'width'=>100,'class'=>'left']);
	    $viewhtml   		=   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
	}
	
	echo $viewhtml;
	
?>