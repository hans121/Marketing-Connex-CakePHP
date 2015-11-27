<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LandingPage Entity.
 */
class LandingPage extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'campaign_id' => true,
		'vendor_id' => true,
		'master_template_id' => true,
		'banner_bg_image' => true,
		'banner_text' => true,
		'heading' => true,
		'body_text' => true,
		'form_heading' => true,
		'chk_first_name' => true,
		'chk_last_name' => true,
		'chk_email' => true,
		'chk_phone' => true,
		'chk_fax' => true,
		'chk_company' => true,
		'chk_job_title' => true,
		'chk_message' => true,
		'chk_frm_submission' => true,
		'downloadable_item' => true,
		'external_links' => true,
		'footer_text' => true,
		'created_on' => true,
		'modified_on' => true,
		'status' => true,
		'master_template' => true,
		'landing_forms' => true,
	];

}
