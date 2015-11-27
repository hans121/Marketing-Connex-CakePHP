<?php
	
	$admn = $this->Session->read('Auth');
	
	if(isset($admn['User']['logo_url'])){
	    $vlogo      =    $this->Html->image($admn['User']['logo_url'],['height'=>60,'width'=>100,'class'=>'left']);
	    $viewhtml   =   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
	}

	if(isset($admn['User']['company_name'])){
	    $vName      =    $admn['User']['company_name'];
	    $viewhtml   =   str_replace('[*!VENDORNAME!*]',$vName, $viewhtml);
	}

	
	if(isset($bannerbgfilename)&& $bannerbgfilename != null && is_file(WWW_ROOT  .'img' . DS . 'tmppreview' . DS .'bgimages'.DS.$bannerbgfilename)){
	    $bannerbgimage   =   $this->Html->image('tmppreview' . DS .'bgimages'.DS.$bannerbgfilename,['alt'=>'Banner','height'=>'auto','width'=>'auto',]);
	    $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
	    
	}elseif(true == $editflag && true== $editbannerimg){
	    $bannerbgimage   =   $this->Html->image('emailtemplates' . DS .'bgimages'.DS.$bannerbgfilename,['alt'=>'Banner','height'=>'auto','width'=>'auto',]);
	    $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
	}
	if(isset($ctatempfilename) && $ctatempfilename != null && is_file(WWW_ROOT  .'img' . DS . 'tmppreview' . DS .'ctaimages'.DS.$ctatempfilename)){
	    
	    $ctabgimage   =   $this->Html->image('tmppreview' . DS .'ctaimages'.DS.$ctatempfilename,['alt'=>'CTA Image','height'=>'auto','width'=>'auto',]);
	    $viewhtml   =   str_replace('[*!CTAIMAGE!*]',$ctabgimage, $viewhtml);
	    
	} elseif(true == $editflag && true== $editctaimg){
	    $ctabgimage   =   $this->Html->image('emailtemplates' . DS .'ctaimages'.DS.$ctatempfilename,['alt'=>'CTA Image','height'=>'auto','width'=>'auto',]);
	    $viewhtml   =   str_replace('[*!CTAIMAGE!*]',$ctabgimage, $viewhtml);
	}
	
	echo $viewhtml;
	
?>