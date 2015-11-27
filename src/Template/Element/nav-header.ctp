		<?php // see http://stackoverflow.com/questions/17161982/how-to-add-active-class-in-current-page-in-cakephp for reference
			
			$admn = $this->Session->read('Auth');
		 
			switch ($admn['User']['role']) {
			
		  case 'admin':
		  
			?>
			<div class="visible-xs">
			<ul class="collapse navbar-collapse" id="mobile-actions">
				<li <?php echo (($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='index') )?'class="active"' :'' ?>>
					<?= $this->Html->link(__('Home'), ['controller' => 'admins', 'action' => 'index']); ?>
				</li>
				<li <?php echo (($this->request->params['controller']==='SubscriptionPackages')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='SubscriptionPackages')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='SubscriptionPackages')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='SubscriptionPackages')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
					<?= $this->Html->link(__('Subscription Packages'), ['controller' => 'subscriptionPackages', 'action' => 'index']); ?> 
				</li>
				<li <?php echo (($this->request->params['controller']==='Coupons')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='Coupons')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='Coupons')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='Coupons')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
					<?= $this->Html->link(__('Coupons'), ['controller' => 'Coupons', 'action' => 'index']); ?> 
				</li>
				<li <?php echo (($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='vendors')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='viewVendor')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editVendor')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='addVendorManager')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editVendorManager')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editcard')|| ($this->request->params['controller']==='Invoices') )?'class="active active-alt"' :'' ?>>
					<?= $this->Html->link(__('Vendors'), ['controller' => 'Admins', 'action' => 'vendors']); ?>
					
						<ul class="submenu">
							<li <?php echo (($this->request->params['controller']==='Invoices') )?'class="active"' :'' ?>>
								<?= $this->Html->link(__('Invoices'), ['controller' => 'Invoices', 'action' => 'index']); ?> 
							</li>
						</ul>
					
				</li>	
	            <li <?php echo (($this->request->params['controller']==='Resources')|| ($this->request->params['controller']==='Folders') )?'class="active"' :'' ?>>
	                <?= $this->Html->link(__('Resources'), ['controller' => 'Resources', 'action' => 'index']); ?> 
				</li>
				<li <?php echo (($this->request->params['controller']==='HelpPages') || ($this->request->params['controller']==='HelpMenus') )?'class="active"' :'' ?>>
	    			<?= $this->Html->link(__('Help Pages'), ['controller' => 'HelpPages', 'action' => 'index']); ?> 
				</li>
				<li <?php echo (($this->request->params['controller']==='CMS') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('CMS'), ['controller' => 'cms', 'action' => 'index']); ?> 
				</li>
				<li <?php echo (($this->request->params['controller']==='Users'))?'class="active"' :'' ?>>
					<?= $this->Html->link(__('Users'), ['controller' => 'Users']); ?> 
				</li>
			</ul>
			</div>
			<div class="page-head-container admin-area <?php echo (($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='addVendorManager')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editcard')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editVendorManager')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editVendor')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editCard')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='vendors')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='vendorsbyterritory')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='viewVendor')|| ($this->request->params['controller']==='Invoices') )?'subactive' :'' ?>">	
				<div class="container">
					
					<div class="row visible-xs adminbar">
					
						<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 loginlinks">
							<div class="row">
								
								<?php
									if(isset($admn['User'])) {
									$loginname = '<strong>'.$admn['User']['first_name'].' '.$admn['User']['last_name'].'</strong>';
								?>
									<div class="col-xs-8">
									<?= $this->Html->link($loginname.' <i class="fa fa-wrench"></i>', ['controller' => 'Users', 'action' => 'myaccount'],['escape' => false, 'title' => 'Settings']);?></strong>
									</div>
									<div class="col-xs-4">
									<?= $this->Html->link(__('Sign out').' <i class="fa fa-sign-out"></i>', ['controller' => 'Users', 'action' => 'logout'],['escape' => false, 'title' => 'Sign out', 'class' => 'pull-right']); ?>
									</div>						  
								<?php } else { ?> 
									
									<?= $this->Html->link(__('Sign in').' <i class="fa fa-sign-in"></i>', ['controller' => 'Users', 'action' => 'login'],['escape' => false, 'title' => 'Sign in']); ?>
									
								<?php } ?>
							</div>	
						</div>
						
					</div>
					
					<div class="row">
						<ul class="col-sm-12 actions hidden-xs">
								<li <?php echo (($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='index') )?'class="active"' :'' ?>>
									<?= $this->Html->link(__('Home'), ['controller' => 'admins', 'action' => 'index']); ?>
								</li>
								<li <?php echo (($this->request->params['controller']==='SubscriptionPackages')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='SubscriptionPackages')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='SubscriptionPackages')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='SubscriptionPackages')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
									<?= $this->Html->link(__('Subscription Packages'), ['controller' => 'SubscriptionPackages', 'action' => 'index']); ?> 
								</li>
								<li <?php echo (($this->request->params['controller']==='Coupons')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='Coupons')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='Coupons')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='Coupons')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
									<?= $this->Html->link(__('Coupons'), ['controller' => 'Coupons', 'action' => 'index']); ?> 
								</li>
								<li <?php echo (($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='vendors')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='viewVendor')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editVendor')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='addVendorManager')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editVendorManager')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editcard')|| ($this->request->params['controller']==='Invoices') )?'class="active active-alt"' :'' ?>>
									<?= $this->Html->link(__('Vendors'), ['controller' => 'Admins', 'action' => 'vendors']); ?>
									
										<ul class="submenu">
											<li <?php echo (($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='vendors')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='viewVendor')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editVendor')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='addVendorManager')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editVendorManager')|| ($this->request->params['controller']==='Admins')&& ($this->request->params['action']=='editcard') )?'class="active"' :'' ?>>
												<?= $this->Html->link(__('Vendors'), ['controller' => 'Admins', 'action' => 'vendors']); ?> 
											</li>
											<li <?php echo (($this->request->params['controller']==='Invoices') )?'class="active"' :'' ?>>
												<?= $this->Html->link(__('Invoices'), ['controller' => 'Invoices', 'action' => 'index']); ?> 
											</li>
										</ul>
									
								</li>	
		            			<li <?php echo (($this->request->params['controller']==='Resources')|| ($this->request->params['controller']==='Folders') )?'class="active"' :'' ?>>
		                			<?= $this->Html->link(__('Resources'), ['controller' => 'Resources', 'action' => 'index']); ?> 
								</li>
								<li <?php echo (($this->request->params['controller']==='HelpPages') || ($this->request->params['controller']==='HelpMenus') )?'class="active"' :'' ?>>
		                			<?= $this->Html->link(__('Help Pages'), ['controller' => 'HelpPages', 'action' => 'index']); ?> 
								</li>
								<li <?php echo (($this->request->params['controller']==='CMS') )?'class="active"' :'' ?>>
		                			<?= $this->Html->link(__('CMS'), ['controller' => 'cms', 'action' => 'index']); ?> 
								</li>
								<li <?php echo (($this->request->params['controller']==='Users'))?'class="active"' :'' ?>>
										<?= $this->Html->link(__('Users'), ['controller' => 'Users', 'action' => 'index']); ?> 
								</li>
									
						</ul>
					</div> <!--row-->
				</div> <!--container(class)-->
			</div> <!-- page-head-container -->		
			
			
			<?php
			
		  break;
		      
		  case 'vendor':
		  
			?>
			<div class="visible-xs">
			<ul class="collapse navbar-collapse" id="mobile-actions">
				<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='index') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Home'), ['controller' => 'Vendors', 'action' => 'index']); ?>
				</li>
				<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='profile')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Company Profile'), ['controller' => 'Vendors', 'action' => 'profile']); ?> 
				</li>
				<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='listvendormanagers')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='viewManager')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='addVendorManager')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='editManager') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Managers'), ['controller' => 'Vendors', 'action' => 'listvendormanagers']); ?>
				</li>	
				<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='partners')|| ($this->request->params['controller']==='PartnerGroups')|| ($this->request->params['controller']==='VendorCampaignplans')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='viewPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='addPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='editPartner') )?'class="active-alt"' :'' ?>>
				<?= $this->Html->link(__('Partners'), ['controller' => 'Vendors', 'action' => 'partners']); ?> 
				
				<ul class="submenu">
				<li <?php echo (($this->request->params['controller']==='PartnerGroups')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='PartnerGroups')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='PartnerGroups')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='PartnerGroups')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Partner Groups'), ['controller' => 'PartnerGroups', 'action' => 'index']); ?> 
				</li>
				<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='partners')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='viewPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='addPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='editPartner') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Partners'), ['controller' => 'Vendors', 'action' => 'partners']); ?> 
				</li>
				<li <?php echo (($this->request->params['controller']==='VendorCampaignplans')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='VendorCampaignplans')&& ($this->request->params['action']=='view') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Manage Campaign Plans'), ['controller' => 'VendorCampaignplans', 'action' => 'index']); ?>
				</li> 
				</ul>
				
				</li>
				
				<li <?php echo ($this->request->params['controller']==='Leads')?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Leads'), ['controller' => 'Leads', 'action' => 'index']); ?> 
				</li>
				
				<li <?php echo ($this->request->params['controller']==='LeadDeals')?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Deals'), ['controller' => 'LeadDeals', 'action' => 'index']); ?> 
				</li>
				
				<li <?php echo (($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='edit')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='sendtestemail')|| ($this->request->params['controller']==='EmailTemplates')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='EmailTemplates')&& ($this->request->params['action']=='edit')|| ($this->request->params['controller']==='LandingPages')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='LandingPages')&& ($this->request->params['action']=='edit')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='spamcheck') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Campaigns'), ['controller' => 'Campaigns', 'action' => 'index']); ?> 
				</li>
				
				<li <?php echo ($this->request->params['controller']==='VendorResources'|| ($this->request->params['controller']==='VendorFolders'))?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Resources'), ['controller' => 'VendorResources', 'action' => 'index']); ?>
				</li>
				
				<li <?php echo ($this->request->params['controller']==='VendorPages'|| ($this->request->params['controller']==='VendorMenus'))?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Communications'), ['controller' => 'VendorPages', 'action' => 'index']); ?>
				</li>
				
				</ul>
				
				</li>
			
			</ul>
			</div>
			<div class="page-head-container vendor-area <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='partners')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='viewPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='addPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='editPartner')|| ($this->request->params['controller']==='PartnerGroups')|| ($this->request->params['controller']==='VendorCampaignplans') )?'subactive' :'' ?>">	
				<div class="container">
					
					<div class="row visible-xs adminbar">
					
						<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 loginlinks">
							<div class="row">
								
								<?php
									if(isset($admn['User'])) {
									$loginname = '<strong>'.$admn['User']['first_name'].' '.$admn['User']['last_name'].'</strong>';
								?>
									<div class="col-xs-8">
									<?= $this->Html->link($loginname.' <i class="fa fa-wrench"></i>', ['controller' => 'Users', 'action' => 'myaccount'],['escape' => false, 'title' => 'Settings']);?></strong>
									</div>
									<div class="col-xs-4">
									<?= $this->Html->link(__('Sign out').' <i class="fa fa-sign-out"></i>', ['controller' => 'Users', 'action' => 'logout'],['escape' => false, 'title' => 'Sign out', 'class' => 'pull-right']); ?>
									</div>						  
								<?php } else { ?> 
									
									<?= $this->Html->link(__('Sign in').' <i class="fa fa-sign-in"></i>', ['controller' => 'Users', 'action' => 'login'],['escape' => false, 'title' => 'Sign in']); ?>
									
								<?php } ?>
							</div>	
						</div>
						
					</div>
					
					<div class="row">
						<ul class="col-sm-12 actions hidden-xs">
							<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='index') )?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Home'), ['controller' => 'Vendors', 'action' => 'index']); ?>
							</li>
							<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='profile')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Company Profile'), ['controller' => 'Vendors', 'action' => 'profile']); ?> 
							</li>
							<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='listvendormanagers')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='viewManager')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='addVendorManager')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='editManager') )?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Managers'), ['controller' => 'Vendors', 'action' => 'listvendormanagers']); ?>
							</li>	
							<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='partners')|| ($this->request->params['controller']==='PartnerGroups')|| ($this->request->params['controller']==='VendorCampaignplans')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='viewPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='addPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='editPartner') )?'class="active active-alt"' :'' ?>>
							<?= $this->Html->link(__('Partners'), ['controller' => 'Vendors', 'action' => 'partners']); ?> 
							
							<ul class="submenu">
							<li <?php echo (($this->request->params['controller']==='PartnerGroups')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='PartnerGroups')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='PartnerGroups')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='PartnerGroups')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Partner Groups'), ['controller' => 'PartnerGroups', 'action' => 'index']); ?> 
							</li>
							<li <?php echo (($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='partners')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='viewPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='addPartner')|| ($this->request->params['controller']==='Vendors')&& ($this->request->params['action']=='editPartner') )?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Partners'), ['controller' => 'Vendors', 'action' => 'partners']); ?> 
							</li>
							<li <?php echo (($this->request->params['controller']==='VendorCampaignplans')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='VendorCampaignplans')&& ($this->request->params['action']=='view') )?'class="active"' :'' ?>>
							<?php 
							if($vendor_sbmt_bp > 0) {
							?> 
							<?= $this->Html->link(__('Manage Campaign Plans').' <span class="badge">'.$vendor_sbmt_bp.'</span>', ['controller' => 'VendorCampaignplans', 'action' => 'index'],array('escape' => FALSE)); ?>
							<?php
							} else {
							?>
							<?= $this->Html->link(__('Manage Campaign Plans'), ['controller' => 'VendorCampaignplans', 'action' => 'index']); ?>
							<?php
							}
							?>
							</li>
							</ul>
							
							</li>
							
							<li <?php echo ($this->request->params['controller']==='Leads')?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Leads'), ['controller' => 'Leads', 'action' => 'index']); ?> 
							</li>
							
							<li <?php echo ($this->request->params['controller']==='LeadDeals')?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Deals'), ['controller' => 'LeadDeals', 'action' => 'index']); ?> 
							</li>
							
							<li <?php echo (($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='edit')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='sendtestemail')|| ($this->request->params['controller']==='EmailTemplates')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='EmailTemplates')&& ($this->request->params['action']=='edit')|| ($this->request->params['controller']==='LandingPages')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='LandingPages')&& ($this->request->params['action']=='edit')|| ($this->request->params['controller']==='Campaigns')&& ($this->request->params['action']=='spamcheck') )?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Campaigns'), ['controller' => 'Campaigns', 'action' => 'index']); ?> 
							</li>
							
							<li <?php echo ($this->request->params['controller']==='VendorResources'|| ($this->request->params['controller']==='VendorFolders'))?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Resources'), ['controller' => 'VendorResources', 'action' => 'index']); ?>
							</li>
							
							<li <?php echo ($this->request->params['controller']==='VendorPages'|| ($this->request->params['controller']==='VendorMenus'))?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Communications'), ['controller' => 'VendorPages', 'action' => 'index']); ?>
							</li>
							<li <?php echo ($this->request->params['controller']==='Litmos')?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Training'), ['controller' => 'Litmos', 'action' => 'index']); ?>
							</li>
						</ul>
					</div> <!--row-->
				</div> <!--container(class)-->
			</div> <!-- page-head-container -->			
			
			<?php
			
		  break;
		  
		  case 'partner':
		  
			?>
			<div class="visible-xs">
			<ul class="collapse navbar-collapse" id="mobile-actions">
				
				<li <?php echo (($this->request->params['controller']==='Partners')&& ($this->request->params['action']=='index') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Home'), ['controller' => 'Partners', 'action' => 'index']); ?>
				</li>
				<li <?php echo (($this->request->params['controller']==='Partners')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='Partners')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='Partners')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Profile'), ['controller' => 'Partners', 'action' => 'view']); ?>
				</li>
				<li <?php echo (($this->request->params['controller']==='PartnerManagers')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='PartnerManagers')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='PartnerManagers')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='PartnerManagers')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Managers'), ['controller' => 'PartnerManagers', 'action' => 'index']); ?>
				</li>
				<li <?php echo (($this->request->params['controller']==='PartnerCampaigns')||($this->request->params['controller']==='PartnerCampaignEmailSettings')||($this->request->params['controller']==='Campaignplans')||($this->request->params['controller']==='CampaignPartnerMailinglists') )?'class="active active-alt"' :'' ?>>
				<?= $this->Html->link(__('Campaign Management'), ['controller' => 'PartnerCampaigns', 'action' => 'mycampaignslist']); ?>
				
				<ul class="submenu">
					<li <?php echo (($this->request->params['controller']==='PartnerCampaigns')&& ($this->request->params['action']=='mycampaignslist') )?'class="active"' :'' ?>>
					<?= $this->Html->link(__('My Campaigns'), ['controller' => 'PartnerCampaigns', 'action' => 'mycampaignslist']); ?> 
					                                  
					</li>
					<li <?php echo (($this->request->params['controller']==='PartnerCampaigns')&& ($this->request->params['action']=='availablecampaigns')||($this->request->params['controller']==='PartnerCampaigns')&& ($this->request->params['action']=='viewCampaign') )?'class="active"' :'' ?>>
					<?php
					if($partner_new_campaigns > 0) {
					?> 
					<?= $this->Html->link(__('Available Campaigns').' <span class="badge">'.$partner_new_campaigns.'</span>', ['controller' => 'PartnerCampaigns', 'action' => 'availablecampaigns'],array('escape' => FALSE)); ?>
					<?php
					} else {
					?>
					<?= $this->Html->link(__('Available Campaigns'), ['controller' => 'PartnerCampaigns', 'action' => 'availablecampaigns']); ?>
					<?php
					}
					?>
					</li>
					<li <?php echo (($this->request->params['controller']==='PartnerCampaignEmailSettings')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='PartnerCampaignEmailSettings')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='PartnerCampaignEmailSettings')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='PartnerCampaignEmailSettings')&& ($this->request->params['action']=='edit')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='addcsv')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='unsubscribeme')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='view') )?'class="active"' :'' ?>>
					<?= $this->Html->link(__('Email Management'), ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']); ?> 
					</li>
					<li <?php echo (($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='listdeals')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='viewdeal')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='editdeal')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='registerdeal'))?'class="active"' :'' ?>>
					<?= $this->Html->link(__('Deals'), ['controller' => 'CampaignPartnerMailinglists', 'action' => 'listdeals']); ?> 
					</li>
					<li <?php echo (($this->request->params['controller']==='Campaignplans')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='Campaignplans')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='Campaignplans')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='Campaignplans')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
					<?php 
					$partner_bp_alert = $partner_approved_bp + $partner_denied_bp;
					if($partner_bp_alert > 0) {
					?> 
					<?= $this->Html->link(__('Campaign Plans').' <span class="badge">'.$partner_bp_alert.'</span>', ['controller' => 'Campaignplans', 'action' => 'index'],array('escape' => FALSE)); ?>
					<?php
					} else {
					?>
					<?= $this->Html->link(__('Campaign Plans'), ['controller' => 'Campaignplans', 'action' => 'index']); ?>
					<?php
					}
					?>
					</li>
				
				</ul>
				
				</li>
				
				<li <?php echo ($this->request->params['controller']==='PartnerLeads')?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Leads'), ['controller' => 'PartnerLeads', 'action' => 'index']); ?> 
				</li>
				
				<li <?php echo ($this->request->params['controller']==='PartnerResources')?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Resources'), ['controller' => 'PartnerResources', 'action' => 'index']); ?>
				</li>
				
				<li <?php echo ($this->request->params['controller']==='PartnerPages')?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Communications'), ['controller' => 'PartnerPages', 'action' => 'index']); ?>
				</li>
				
				<li <?php echo ($this->request->params['controller']==='PartnerMailinglists' || $this->request->params['controller']==='PartnerMailinglistGroups' || $this->request->params['controller']==='PartnerMailinglistSegments')?'class="active"' :'' ?>>
				<?= $this->Html->link(__('Lists'), ['controller' => 'PartnerMailinglistGroups', 'action' => 'index']); ?>
				</li>
			
			</ul>
			</div>
			<div class="page-head-container partner-area <?php echo (($this->request->params['controller']==='PartnerCampaigns')||($this->request->params['controller']==='PartnerCampaignEmailSettings')||($this->request->params['controller']==='Campaignplans')||($this->request->params['controller']==='CampaignPartnerMailinglists') )?'subactive' :'' ?>">	
				<div class="container">
					
					<div class="row visible-xs adminbar">
					
						<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 loginlinks">
							<div class="row">
								
								<?php
									if(isset($admn['User'])) {
									$loginname = '<strong>'.$admn['User']['first_name'].' '.$admn['User']['last_name'].'</strong>';
								?>
									<div class="col-xs-8">
									<?= $this->Html->link($loginname.' <i class="fa fa-wrench"></i>', ['controller' => 'Users', 'action' => 'myaccount'],['escape' => false, 'title' => 'Settings']);?></strong>
									</div>
									<div class="col-xs-4">
									<?= $this->Html->link(__('Sign out').' <i class="fa fa-sign-out"></i>', ['controller' => 'Users', 'action' => 'logout'],['escape' => false, 'title' => 'Sign out', 'class' => 'pull-right']); ?>
									</div>						  
								<?php } else { ?> 
									
									<?= $this->Html->link(__('Sign in').' <i class="fa fa-sign-in"></i>', ['controller' => 'Users', 'action' => 'login'],['escape' => false, 'title' => 'Sign in']); ?>
									
								<?php } ?>
							</div>	
						</div>
						
					</div>
					
					<div class="row">
						<ul class="col-sm-12 actions hidden-xs">
							
							<li <?php echo (($this->request->params['controller']==='Partners')&& ($this->request->params['action']=='index') )?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Home'), ['controller' => 'Partners', 'action' => 'index']); ?>
							</li>
							<li <?php echo (($this->request->params['controller']==='Partners')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='Partners')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='Partners')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Profile'), ['controller' => 'Partners', 'action' => 'view']); ?>
							</li>
							<li <?php echo (($this->request->params['controller']==='PartnerManagers')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='PartnerManagers')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='PartnerManagers')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='PartnerManagers')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Managers'), ['controller' => 'PartnerManagers', 'action' => 'index']); ?>
							</li>
							<li <?php echo (($this->request->params['controller']==='PartnerCampaigns')||($this->request->params['controller']==='PartnerCampaignEmailSettings')||($this->request->params['controller']==='Campaignplans')||($this->request->params['controller']==='CampaignPartnerMailinglists') )?'class="active active-alt"' :'' ?>>
							<?= $this->Html->link(__('Campaign Management'), ['controller' => 'PartnerCampaigns', 'action' => 'mycampaignslist']); ?>
							
								<ul class="submenu">
									<li <?php echo (($this->request->params['controller']==='PartnerCampaigns')&& ($this->request->params['action']=='mycampaignslist') )?'class="active"' :'' ?>>
									<?= $this->Html->link(__('My Campaigns'), ['controller' => 'PartnerCampaigns', 'action' => 'mycampaignslist']); ?> 
									                      
									</li>
									<li <?php echo (($this->request->params['controller']==='PartnerCampaigns')&& ($this->request->params['action']=='availablecampaigns')||($this->request->params['controller']==='PartnerCampaigns')&& ($this->request->params['action']=='viewCampaign') )?'class="active"' :'' ?>>
									<?php
									if($partner_new_campaigns > 0) {
									?> 
									<?= $this->Html->link(__('Available Campaigns').' <span class="badge">'.$partner_new_campaigns.'</span>', ['controller' => 'PartnerCampaigns', 'action' => 'availablecampaigns'],array('escape' => FALSE)); ?>
									<?php
									} else {
									?>
									<?= $this->Html->link(__('Available Campaigns'), ['controller' => 'PartnerCampaigns', 'action' => 'availablecampaigns']); ?>
									<?php
									}
									?>
									</li>
									<li <?php echo (($this->request->params['controller']==='PartnerCampaignEmailSettings')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='PartnerCampaignEmailSettings')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='PartnerCampaignEmailSettings')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='PartnerCampaignEmailSettings')&& ($this->request->params['action']=='edit')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='addcsv')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='unsubscribeme')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='view') )?'class="active"' :'' ?>>
									<?= $this->Html->link(__('Email Management'), ['controller' => 'PartnerCampaignEmailSettings', 'action' => 'index']); ?> 
									</li>
									<li <?php echo (($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='listdeals')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='viewdeal')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='editdeal')|| ($this->request->params['controller']==='CampaignPartnerMailinglists')&& ($this->request->params['action']=='registerdeal'))?'class="active"' :'' ?>>
									<?= $this->Html->link(__('Deals'), ['controller' => 'CampaignPartnerMailinglists', 'action' => 'listdeals']); ?> 
									</li>
									<li <?php echo (($this->request->params['controller']==='Campaignplans')&& ($this->request->params['action']=='index')|| ($this->request->params['controller']==='Campaignplans')&& ($this->request->params['action']=='view')|| ($this->request->params['controller']==='Campaignplans')&& ($this->request->params['action']=='add')|| ($this->request->params['controller']==='Campaignplans')&& ($this->request->params['action']=='edit') )?'class="active"' :'' ?>>
									<?php 
									$partner_bp_alert = $partner_approved_bp + $partner_denied_bp;
									if($partner_bp_alert > 0) {
									?> 
									<?= $this->Html->link(__('Campaign Plans').' <span class="badge">'.$partner_bp_alert.'</span>', ['controller' => 'Campaignplans', 'action' => 'index'],array('escape' => FALSE)); ?>
									<?php
									} else {
									?>
									<?= $this->Html->link(__('Campaign Plans'), ['controller' => 'Campaignplans', 'action' => 'index']); ?>
									<?php
									}
									?>
									</li>                    
								</ul>
							
							</li>
							
							<li <?php echo ($this->request->params['controller']==='PartnerLeads')?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Leads'), ['controller' => 'PartnerLeads', 'action' => 'index']); ?> 
							</li>
							
							<li <?php echo ($this->request->params['controller']==='PartnerResources')?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Resources'), ['controller' => 'PartnerResources', 'action' => 'index']); ?>
							</li>
							
							<li <?php echo ($this->request->params['controller']==='PartnerPages')?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Communications'), ['controller' => 'PartnerPages', 'action' => 'index']); ?>
							</li>
							
							<li <?php echo ($this->request->params['controller']==='PartnerMailinglists' || $this->request->params['controller']==='PartnerMailinglistGroups' || $this->request->params['controller']==='PartnerMailinglistSegments')?'class="active"' :'' ?>>
							<?= $this->Html->link(__('Lists'), ['controller' => 'PartnerMailinglistGroups', 'action' => 'index']); ?>
							</li>
							
						</ul>
					</div> <!--row-->
				</div> <!--container(class)-->
			</div> <!-- page-head-container -->			
			
			<?php
			
		  break;
		  
		  default:
		  
		?>
			<div class="visible-xs">
				<ul class="collapse navbar-collapse" id="mobile-actions">
					<li>
						<?= $this->Html->link(__('Home'), '/'); ?>
					</li>
					<li>
						<?= $this->Html->link(__('Vendors'), '/#vendor-features'); ?>
					</li>
					<li>
						<?= $this->Html->link(__('Partners'), '/#partner-features'); ?>
					</li>
					<?php    
						switch ($this->request->params['controller']) {
						case 'SubscriptionPackages':
					?>
						<li class="active">
					<?php
						break;
						default:
					?>
						<li>
					<?php
						}
					?>
						<?= $this->Html->link(__('Pricing'), ['controller' => 'SubscriptionPackages', 'action' => 'packagelist']); ?>
					</li>
					<li <?=($this->request->params['pass'][0]=='why'?'class="active"':'')?>>
						<?= $this->Html->link(__('Why Choose Us?'), ['controller' => 'Pages', 'action' => 'why']); ?>
					</li>
				
					<li <?=($this->request->params['pass'][0]=='contact'?'class="active"':'')?>>
						<?= $this->Html->link(__('Contact Us'), ['controller' => 'Contact', 'action' => 'index']); ?>
					</li>
					
				</ul>
			</div>
			
				<div class="page-head-container partner-area">
					<div class="container">
						
						<div class="row visible-xs">
						
							<div class="col-xl-12 col-md-12 col-sm-12 col-xs-12 loginlinks">
							
									<?php
										if(isset($admn['User'])) {
										$loginname = 'Signed in as <strong>'.$admn['User']['first_name'].' '.$admn['User']['last_name'].'</strong>';
									?>
									
										<?= $this->Html->link($loginname.' <i class="fa fa-wrench"></i>', ['controller' => 'Users', 'action' => 'myaccount'],['escape' => false, 'title' => 'Settings']);?></strong>
										<?= '|' ?>
										<?= $this->Html->link(__('Sign out').' <i class="fa fa-sign-out"></i>', ['controller' => 'Users', 'action' => 'logout'],['escape' => false, 'title' => 'Sign out']); ?>
																  
									<?php } else { ?> 
										
										<?= $this->Html->link(__('Sign in').' <i class="fa fa-sign-in"></i>', ['controller' => 'Users', 'action' => 'login'],['escape' => false, 'title' => 'Sign in']); ?>
										
									<?php } ?>
									
							</div>
							
						</div>
						
						<div class="row">
								
							<ul class="col-sm-9 actions hidden-xs">
							
									<li>
										<?= $this->Html->link(__('Home'), '/'); ?>
									</li>									
									<li>
										<?= $this->Html->link(__('Vendors'), '/#vendor-features', ['id' => 'vendor_link']); ?>
									</li>
									<li>
										<?= $this->Html->link(__('Partners'), '/#partner-features', ['id' => 'partner_link']); ?>
									</li>
									<?php    
										switch ($this->request->params['controller']) {
										case 'SubscriptionPackages':
									?>
										<li class="active">
									<?php
										break;
										default:
									?>
										<li>
									<?php
										}
									?>
										<?= $this->Html->link(__('Pricing'), ['controller' => 'SubscriptionPackages', 'action' => 'packagelist']); ?>
									</li>
									<li <?=($this->request->params['pass'][0]=='why'?'class="active"':'')?>>
										<?= $this->Html->link(__('Why Choose Us?'), ['controller' => 'Pages', 'action' => 'why']); ?>
									</li>									
									<li <?=($this->request->params['pass'][0]=='contact'?'class="active"':'')?>>
										<?= $this->Html->link(__('Contact Us'), ['controller' => 'Contact', 'action' => 'index']); ?>
									</li>
								
							</ul>
							<ul class="nav navbar-nav secondary col-sm-3 hidden-xs" id="scroll-nav">	
								<div class="promo-highlight"><li class="active"><?=$this->Html->link(__('Book a demo'),['controller' => 'Contact','action' => 'index','request' => 'demo'],['escape' => false, 'title' => 'Book a demo']);?></li></div>									
								<li class="active logout-link">
									<?php
										if(isset($admn['User'])) {
										$loginname = 'Signed in as <strong>'.$admn['User']['first_name'].' '.$admn['User']['last_name'].'</strong>';
									?>
									
										<?= $this->Html->link($loginname.' <i class="fa fa-wrench"></i>', ['controller' => 'Users', 'action' => 'myaccount'],['escape' => false, 'title' => 'Settings']);?></strong>
										<?= '|' ?>
										<?= $this->Html->link(__('Sign out').' <i class="fa fa-sign-out"></i>', ['controller' => 'Users', 'action' => 'logout'],['escape' => false, 'title' => 'Sign out']); ?>
																  
									<?php } else { ?> 
										
										<?= $this->Html->link(__('Sign in').' <i class="fa fa-sign-in"></i>', ['controller' => 'Users', 'action' => 'login'],['escape' => false, 'title' => 'Sign in']); ?>
										
									<?php } ?>
								</li>
								
							</ul>
						</div> <!--row-->
					</div> <!--container(class)-->
				</div> <!-- page-head-container -->
			
			<?php
				
		  break;
		  
			}
			
		?>
