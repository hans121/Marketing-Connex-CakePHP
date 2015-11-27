<!-- SPECIFIC FOOTER MENU-->

<?php  
	  
	$admn = $this->Session->read('Auth');
	     
	switch ($admn['User']['role']) {
	
	case 'superadmin':
	
?>

		<ul class="col-sm-2 col-sm-offset-2 col-xs-4 pull-left">
	
			<li class="text-left">
				<?= $this->Html->link(__('Home'), ['controller' => 'superadmins', 'action' => 'index'],['title'=>'Dashboard']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Subscription Packages'), ['controller' => 'SubscriptionPackages', 'action' => 'index'],['title'=>'Subscription Packages']); ?> 
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Coupons'), ['controller' => 'Coupons', 'action' => 'index'],['title'=>'Coupons']); ?> 
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Vendors'), ['controller' => 'Admins', 'action' => 'vendors'],['title'=>'Vendors']); ?>
			</li>	
			<li class="text-left">
				<?= $this->Html->link(__('Resources'), ['controller' => 'Resources', 'action' => 'index'],['title'=>'Resources']); ?>
			</li>	
			<li class="text-left">
				<?= $this->Html->link(__('Help Pages'), ['controller' => 'HelpPages', 'action' => 'index'],['title'=>'Help Pages']); ?>
			</li>	
								
		</ul>				
	
<?php
	
	break;
	
	case 'admin':
	
?>

		<ul class="col-sm-2 col-sm-offset-2 col-xs-4 pull-left">
	
			<li class="text-left">
				<?= $this->Html->link(__('Home'), ['controller' => 'admins', 'action' => 'index'],['title'=>'Dashboard']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Subscription Packages'), ['controller' => 'SubscriptionPackages', 'action' => 'index'],['title'=>'Subscription Packages']); ?> 
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Coupons'), ['controller' => 'Coupons', 'action' => 'index'],['title'=>'Coupons']); ?> 
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Vendors'), ['controller' => 'Admins', 'action' => 'vendors'],['title'=>'Vendors']); ?>
			</li>	
			<li class="text-left">
				<?= $this->Html->link(__('Resources'), ['controller' => 'Resources', 'action' => 'index'],['title'=>'Resources']); ?>
			</li>	
			<li class="text-left">
				<?= $this->Html->link(__('Help Pages'), ['controller' => 'HelpPages', 'action' => 'index'],['title'=>'Help Pages']); ?>
			</li>	
								
		</ul>				
	
<?php
	
  break;
      
  case 'vendor':
  
?>
	
		<ul class="col-sm-2 col-sm-offset-2 col-xs-4 pull-left">
	
			<li class="text-left">
				<?= $this->Html->link(__('Home'), ['controller' => 'Vendors', 'action' => 'index'],['title'=>'Dashboard']); ?>
			</li>
      <li class="text-left">
				<?= $this->Html->link(__('Company Profile'), ['controller' => 'Vendors', 'action' => 'profile'],['title'=>'Company Profile']); ?> 
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Managers'), ['controller' => 'Vendors', 'action' => 'listvendormanagers'],['title'=>'Managers']); ?>
			</li>	
			<li class="text-left">
				<?= $this->Html->link(__('Partners'), ['controller' => 'Vendors', 'action' => 'partners'],['title'=>'Partners']); ?>
			</li>
			 <li class="text-left">
				<?= $this->Html->link(__('Campaigns'), ['controller' => 'Campaigns', 'action' => 'index'],['title'=>'Campaigns']); ?> 
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Resources'), ['controller' => 'VendorResources', 'action' => 'index'],['title'=>'Resources']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Pages'), ['controller' => 'VendorPages', 'action' => 'index'],['title'=>'Pages']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Help & Support'), ['controller' => 'Help', 'action' => 'index'],['title'=>'Help & Support']); ?>
			</li>
								
		</ul>				
	
<?php
	
  break;
  
  case 'partner':
  
?>
	
		<ul class="col-sm-2 col-sm-offset-2 col-xs-4 pull-left">
	
			<li class="text-left">
				<?= $this->Html->link(__('Dashboard'), ['controller' => 'Partners', 'action' => 'index'],['title'=>'Dashboard']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Profile'), ['controller' => 'Partners', 'action' => 'view'],['title'=>'Profile']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Managers'), ['controller' => 'PartnerManagers', 'action' => 'index'],['title'=>'Managers']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Campaign Management'), ['controller' => 'PartnerCampaigns', 'action' => 'mycampaignslist'],['title'=>'Campaign Management']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Resources'), ['controller' => 'PartnerResources', 'action' => 'index'],['title'=>'Resources']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Pages'), ['controller' => 'PartnerPages', 'action' => 'index'],['title'=>'Pages']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Help & Support'), ['controller' => 'Help', 'action' => 'index'],['title'=>'Help & Support']); ?>
			</li>
								
		</ul>				
	
<?php
	
  break;
  
  default:
  
?>
	
		<ul class="col-sm-2 col-sm-offset-2 col-xs-4 pull-left">
	
			<li class="text-left">
				<?= $this->Html->link(__('Home'), ['controller' => 'Pages', 'action' => 'home'],['class'=>'claret', 'title'=>'Home']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Why Choose Us?'), ['controller' => 'Pages', 'action' => 'why'],['class'=>'claret', 'title'=>'Why Choose Us?']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Pricing & Plans'), ['controller' => 'SubscriptionPackages', 'action' => 'packagelist'],['class'=>'claret', 'title'=>'Contact Us']); ?>
			</li>
			<li class="text-left">
				<?= $this->Html->link(__('Contact Us'), ['controller' => 'Contact', 'action' => 'index'],['class'=>'claret', 'title'=>'Contact Us']); ?>
			</li>
								
		</ul>				
	
<?php
		
  break;
      
	}

?>
			
			
<ul class="col-lg-2 col-md-2 col-sm-2 col-xs-4 pull-left">
	<li class="text-left">
		<?= $this->Html->link(__('Privacy & Cookies'), ['controller' => 'Pages', 'action' => 'privacy'],['title'=>'Privacy & Cookies']); ?>
	</li>
	<li class="text-left">
		<?= $this->Html->link(__('Terms & Conditions'), ['controller' => 'Pages', 'action' => 'conditions'],['title'=>'Terms & Conditions']); ?>
	</li>
	<li class="text-left">
		<?= $this->Html->link(__('Terms of Use'), ['controller' => 'Pages', 'action' => 'terms'],['title'=>'Terms of Use']); ?>
	</li>
	<!-- Mark asked
	<li class="text-left">
		<?//= $this->Html->link(__('Accessibility'), ['controller' => 'Pages', 'action' => 'accessibility'],['title'=>'Accessibility']); ?>
	</li>
	-->
</ul>




