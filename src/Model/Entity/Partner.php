<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Partner Entity.
 */
class Partner extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'vendor_id' => true,
		'company_name' => true,
		'logo_url' => true,
		'logo_path' => true,
		'email' => true,
		'phone' => true,
		'fax' => true,
		'website' => true,
		'twitter' => true,
		'facebook' => true,
		'linkedin' => true,
		'twitter_oauth_token' => true,
		'twitter_oauth_token_secret' => true,
		'linkedin_oauth_token' => true,
		'linkedin_oauth_token_expiry' => true,
		'no_employees' => true,
		'no_offices' => true,
		'total_a_revenue' => true,
		'address' => true,
		'country' => true,
		'city' => true,
		'state' => true,
		'postal_code' => true,
        'partner_group_id'  =>  true,
		'vendor_manager_id' => true,
		'vendor' => true,
		'businesplans' => true,
		'partner_managers' => true,
        'partner_groups' => true,
        'vendor_managers' => true,
        'users' => true,
		'fb_longlived_access_token' =>true	
	];

}
