<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Network\Http\Client;

/**
 * Net component
 */
class CampaignemailsComponent extends Component {

    public $components = ['Session','Flash'];

	/**
	* Default configuration.
	*
	* @var array
	*/
	public function MergeFields($emailTemplate, $VendorID=NULL, $PartnerID=NULL) {

		echo $emailTemplate['master_template']->content;
			return $emailTemplate['master_template']->content;									
	    $viewhtml  =   $emailTemplate['master_template']->content;
	    $viewhtml   =   str_replace('[*!SITE_URL!*]',$this->portal_settings['site_url'], $viewhtml); 
	    $viewhtml   =   str_replace('[*!WEBLINK!*]',$this->portal_settings['site_url'].'/Email_Templates/view/'.$emailTemplate->id, $viewhtml); 
	    $viewhtml   =   str_replace('[*!HEADING!*]',$emailTemplate->heading, $viewhtml);
	    $viewhtml   =   str_replace('[*!SUBJECTTEXT!*]',$emailTemplate->subject_text, $viewhtml);
	    if ($emailTemplate->banner_text != '') {
	    $viewhtml   =   str_replace('[*!BANNERTEXT!*]',$emailTemplate->banner_text, $viewhtml);
	    } else {
	    $viewhtml   =   str_replace('[*!BANNERTEXT!*]',' ', $viewhtml);
	    }
	    $viewhtml   =   str_replace('[*!BODYTEXT!*]',$emailTemplate->body_text, $viewhtml);
	    $viewhtml   =   str_replace('[*!FEATUREHEADING!*]',$emailTemplate->features_heading, $viewhtml);
	    $viewhtml   =   str_replace('[*!FEATURES!*]',$emailTemplate->features, $viewhtml);
	    $viewhtml   =   str_replace('[*!CTATEXT!*]','<a href="'.$emailTemplate->cta_url.'">'.$emailTemplate->cta_text.'</a>', $viewhtml);
	    $viewhtml   =   str_replace('[*!VENDORNAME!*]', $emailTemplate['vendor']->company_name, $viewhtml);
	    $viewhtml   =   str_replace('[*!PARTNERNAME!*]',$this->Auth->user('company_name'), $viewhtml);
	
	    
	    if(isset($emailTemplate['vendor']->logo_url)){
	        $vlogo      =    '<img src="'.$emailTemplate['vendor']->logo_url.'" height="60" width="100" class="left"/>';
	        $viewhtml   =   str_replace('[*!VENDORLOGO!*]',$vlogo, $viewhtml);
	    } else {
	        $viewhtml   =   str_replace('[*!VENDORLOGO!*]','<img src="http://placehold.it/100x60" height="60" width="100" class="left"/>', $viewhtml);
	    }
	    
	    
	    if(isset($emailTemplate->banner_bg_image)&& $emailTemplate->banner_bg_image != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'bgimages'.DS.$emailTemplate->banner_bg_image)){
	        $bannerbgimage   =   '<img src="'.$image_url.'emailtemplates' . DS .'bgimages'.DS.$emailTemplate->banner_bg_image.'" alt="Banner" width="auto" height="auto"/>';
	        $viewhtml   =   str_replace('[*!BANNERIMAGE!*]',$bannerbgimage, $viewhtml);
	    } else {
	        $viewhtml   =   str_replace('[*!BANNERIMAGE!*]','<img src="http://placehold.it/100x100" width="auto" height="auto"/>', $viewhtml);
	    }
	    
	    if(isset($emailTemplate->cta_bg_image)&& $emailTemplate->cta_bg_image != null && is_file(WWW_ROOT  .'img' . DS . 'emailtemplates' . DS .'ctaimages'.DS.$emailTemplate->cta_bg_image)){
	        $ctabgimage   =   '<a href="'.$emailTemplate->cta_url.'"><img src="'.$image_url.'emailtemplates' . DS .'ctaimages'.DS.$emailTemplate->cta_bg_image.'" alt="Call to Action"  width="auto" height="auto"/></a>';
	        $viewhtml   =   str_replace('[*!CTAIMAGE!*]',$ctabgimage, $viewhtml);
	    } else {
	        $viewhtml   =   str_replace('[*!CTAIMAGE!*]','<img src="http://placehold.it/100x60" width="auto" height="auto"/>', $viewhtml);
	    }
	    
	    if($partner->logo_url!= ''){
	        $plogo      =    '<img src="'.$partner->logo_url.'" height="60" width="100" class="right"/>';
	        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]',$plogo, $viewhtml);
	    } else {
	        $viewhtml   =   str_replace('[*!PARTNERLOGO!*]','<img src="http://placehold.it/100x60" width="auto" height="auto"/>', $viewhtml);
	    }
	    
	    return $viewhtml;
	}
};