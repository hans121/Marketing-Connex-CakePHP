<?php 
	
$admn = $this->Session->read('Auth');$frmstr='';

if(isset($landingPage)&&!empty($landingPage)){
	
    if(isset($landingPage['vendor']->logo_url) && is_file(WWW_ROOT  .'img' . DS . 'logos' . DS.$landingPage['vendor']->logo_url)){
      $vlogo      =    $this->Html->image('logos' . DS .$landingPage['vendor']->logo_url,['class'=>'left']);
      $viewhtml   =   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
    }
    
    if(isset($admn['User']['logo_url'])){
      $plogo      =    $this->Html->image('logos' . DS .$admn['User']['logo_url'],['class'=>'right']);
      $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
    }
    
    if(isset($landingPage->banner_bg_image)&& $landingPage->banner_bg_image != null && is_file(WWW_ROOT  .'img' . DS . 'landingpages' . DS .'bgimages'.DS.$landingPage->banner_bg_image)){
      $bannerbgimage   =   $this->Html->image('landingpages' . DS .'bgimages'.DS.$landingPage->banner_bg_image,['alt'=>'Banner']);
      $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
    }
    
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
    
		if($landingPage->chk_frm_submission !=   'Y'){
			$frmstr .= '<div id="resource-link" style="display:none;">';
		  $frmstr .=  $this->Form->postLink(__('Download Resource'), ['action' => 'downloadfile', $landingPage->id],['class' => 'download-button']);
			$frmstr .= '</div>';
		} else {
			$frmstr .= '<div id="resource-link">';
		  $frmstr .=  $this->Form->postLink(__('Download Resource'), ['action' => 'downloadfile', $landingPage->id],['class' => 'download-button']);
			$frmstr .= '</div>';
		}
    
    $frmstr .=  $this->Form->button(__('Submit'));
    if($landingPage->chk_frm_submission !=   'Y' && is_file(WWW_ROOT  .'files' . DS .'landingpages'.DS.$landingPage->downloadable_item)){
      $frmstr .=  $this->Form->postLink(__('Download Resource'), ['action' => 'downloadfile', $landingPage->id]);
    }
    
    $viewhtml   =   str_replace('[*!FRMFIELDS!*]',$frmstr, $viewhtml);
}

echo $viewhtml;