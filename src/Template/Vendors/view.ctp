<div class="vendors view">
  
	<h2><?= __('Vendor'); ?></h2>
	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
    
	<dl>
		<dt><?= __('Id'); ?></dt>
		<dd>
			<?= h($vendor->id); ?>
			&nbsp;
		</dd>
		<dt><?= __('Company Name'); ?></dt>
		<dd>
			<?= h($vendor->company_name); ?>
			&nbsp;
		</dd>
		<dt><?= __('Logo Url'); ?></dt>
		<dd>
			<?= h($vendor->logo_url); ?>
			&nbsp;
		</dd>
		<dt><?= __('Subscription Expiry Date'); ?></dt>
		<dd>
			<?= h($vendor->subscription_expiry_date); ?>
			&nbsp;
		</dd>
		<dt><?= __('Phone'); ?></dt>
		<dd>
			<?= h($vendor->phone); ?>
			&nbsp;
		</dd>
		<dt><?= __('Fax'); ?></dt>
		<dd>
			<?= h($vendor->fax); ?>
			&nbsp;
		</dd>
		<dt><?= __('Website'); ?></dt>
		<dd>
			<?= h($vendor->website); ?>
			&nbsp;
		</dd>
		<dt><?= __('Address'); ?></dt>
		<dd>
			<?= h($vendor->address); ?>
			&nbsp;
		</dd>
		<dt><?= __('Country'); ?></dt>
		<dd>
			<?= h($vendor->country); ?>
			&nbsp;
		</dd>
		<dt><?= __('City'); ?></dt>
		<dd>
			<?= h($vendor->city); ?>
			&nbsp;
		</dd>
		<dt><?= __('County/State'); ?></dt>
		<dd>
			<?= h($vendor->state); ?>
			&nbsp;
		</dd>
		<dt><?= __('Postalcode'); ?></dt>
		<dd>
			<?= h($vendor->postalcode); ?>
			&nbsp;
		</dd>
		<dt><?= __('Subscription Package'); ?></dt>
		<dd>
			<?= h($vendor->subscription_package_id); ?>
			&nbsp;
		</dd>
		<dt><?= __('Status'); ?></dt>
		<dd>
			<?= h($vendor->status); ?>
			&nbsp;
		</dd>
		<dt><?= __('No Emails'); ?></dt>
		<dd>
			<?= h($vendor->no_emails); ?>
			&nbsp;
		</dd>
		<dt><?= __('No Partners'); ?></dt>
		<dd>
			<?= h($vendor->no_partners); ?>
			&nbsp;
		</dd>
		<dt><?= __('Coupon Id'); ?></dt>
		<dd>
			<?= h($vendor->coupon_id); ?>
			&nbsp;
		</dd>
		<dt><?= __('Language'); ?></dt>
		<dd>
			<?= h($vendor->language); ?>
			&nbsp;
		</dd>
		<dt><?= __('Subscription Type'); ?></dt>
		<dd>
			<?= h($vendor->subscription_type); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?= __('Actions'); ?></h3>
	<ul>
		<li><?= $this->Html->link(__('Edit Vendor'), ['action' => 'edit', $vendor->id]); ?> </li>
		<li><?= $this->Form->postLink(__('Delete Vendor'), ['action' => 'delete', $vendor->id], ['confirm' => __('Are you sure you want to delete # %s?', $vendor->id)]); ?> </li>
		<li><?= $this->Html->link(__('List Vendors'), ['action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Vendor'), ['action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Coupons'), ['controller' => 'Coupons', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Coupon'), ['controller' => 'Coupons', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List Partners'), ['controller' => 'Partners', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Partner'), ['controller' => 'Partners', 'action' => 'add']); ?> </li>
		<li><?= $this->Html->link(__('List VendorManagers'), ['controller' => 'VendorManagers', 'action' => 'index']); ?> </li>
		<li><?= $this->Html->link(__('New Vendor Manager'), ['controller' => 'VendorManagers', 'action' => 'add']); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?= __('Related Coupons'); ?></h3>
	<?php if (!empty($vendor->coupons)): ?>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?= __('Id'); ?></th>
			<th><?= __('Title'); ?></th>
			<th><?= __('Type'); ?></th>
			<th><?= __('Discount'); ?></th>
			<th><?= __('Vendor Id'); ?></th>
			<th><?= __('Expiry Date'); ?></th>
			<th><?= __('Created On'); ?></th>
			<th><?= __('Modified On'); ?></th>
			<th><?= __('Status'); ?></th>
			<th class="actions"><?= __('Actions'); ?></th>
		</tr>
		<?php foreach ($vendor->coupons as $coupons): ?>
		<tr>
			<td><?= h($coupons->id) ?></td>
			<td><?= h($coupons->title) ?></td>
			<td><?= h($coupons->type) ?></td>
			<td><?= h($coupons->discount) ?></td>
			<td><?= h($coupons->vendor_id) ?></td>
			<td><?= h($coupons->expiry_date) ?></td>
			<td><?= h($coupons->created_on) ?></td>
			<td><?= h($coupons->modified_on) ?></td>
			<td><?= h($coupons->status) ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'Coupons', 'action' => 'view', $coupons->id]); ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'Coupons', 'action' => 'edit', $coupons->id]); ?>
				<?= $this->Form->postLink(__('Delete'), ['controller' => 'Coupons', 'action' => 'delete', $coupons->id], ['confirm' => __('Are you sure you want to delete # %s?', $coupons->id)]); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
	<div class="actions">
		<ul>
			<li><?= $this->Html->link(__('New Coupon'), ['controller' => 'Coupons', 'action' => 'add']); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?= __('Related Partners'); ?></h3>
	<?php if (!empty($vendor->partners)): ?>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?= __('Id'); ?></th>
			<th><?= __('Vendor Id'); ?></th>
			<th><?= __('Company Name'); ?></th>
			<th><?= __('Logo Url'); ?></th>
			<th><?= __('Email Domain'); ?></th>
			<th><?= __('Phone'); ?></th>
			<th><?= __('Fax'); ?></th>
			<th><?= __('Website'); ?></th>
			<th><?= __('No Employees'); ?></th>
			<th><?= __('No Offices'); ?></th>
			<th><?= __('Total A Revenue'); ?></th>
			<th><?= __('Address'); ?></th>
			<th><?= __('Country'); ?></th>
			<th><?= __('City'); ?></th>
			<th><?= __('State'); ?></th>
			<th><?= __('Postal Code'); ?></th>
			<th><?= __('Vendor Manager'); ?></th>
			<th class="actions"><?= __('Actions'); ?></th>
		</tr>
		<?php foreach ($vendor->partners as $partners): ?>
		<tr>
			<td><?= h($partners->id) ?></td>
			<td><?= h($partners->vendor_id) ?></td>
			<td><?= h($partners->company_name) ?></td>
			<td><?= h($partners->logo_url) ?></td>
			<td><?= h($partners->email_domain) ?></td>
			<td><?= h($partners->phone) ?></td>
			<td><?= h($partners->fax) ?></td>
			<td><?= h($partners->website) ?></td>
			<td><?= h($partners->no_employees) ?></td>
			<td><?= h($partners->no_offices) ?></td>
			<td><?= h($partners->total_a_revenue) ?></td>
			<td><?= h($partners->address) ?></td>
			<td><?= h($partners->country) ?></td>
			<td><?= h($partners->city) ?></td>
			<td><?= h($partners->state) ?></td>
			<td><?= h($partners->postal_code) ?></td>
			<td><?= h($partners->vendor_manager) ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'Partners', 'action' => 'view', $partners->id]); ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'Partners', 'action' => 'edit', $partners->id]); ?>
				<?= $this->Form->postLink(__('Delete'), ['controller' => 'Partners', 'action' => 'delete', $partners->id], ['confirm' => __('Are you sure you want to delete # %s?', $partners->id)]); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
	<div class="actions">
		<ul>
			<li><?= $this->Html->link(__('New Partner'), ['controller' => 'Partners', 'action' => 'add']); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?= __('Related VendorManagers'); ?></h3>
	<?php if (!empty($vendor->vendor_managers)): ?>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?= __('Id'); ?></th>
			<th><?= __('Vendor Id'); ?></th>
			<th><?= __('User Id'); ?></th>
			<th><?= __('Primary Manager'); ?></th>
			<th><?= __('Created On'); ?></th>
			<th><?= __('Modified On'); ?></th>
			<th><?= __('Status'); ?></th>
			<th class="actions"><?= __('Actions'); ?></th>
		</tr>
		<?php foreach ($vendor->vendor_managers as $vendorManagers): ?>
		<tr>
			<td><?= h($vendorManagers->id) ?></td>
			<td><?= h($vendorManagers->vendor_id) ?></td>
			<td><?= h($vendorManagers->user_id) ?></td>
			<td><?= h($vendorManagers->primary_manager) ?></td>
			<td><?= h($vendorManagers->created_on) ?></td>
			<td><?= h($vendorManagers->modified_on) ?></td>
			<td><?= h($vendorManagers->status) ?></td>
			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'VendorManagers', 'action' => 'view', $vendorManagers->id]); ?>
				<?= $this->Html->link(__('Edit'), ['controller' => 'VendorManagers', 'action' => 'edit', $vendorManagers->id]); ?>
				<?= $this->Form->postLink(__('Delete'), ['controller' => 'VendorManagers', 'action' => 'delete', $vendorManagers->id], ['confirm' => __('Are you sure you want to delete # %s?', $vendorManagers->id)]); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endif; ?>
	<div class="actions">
		<ul>
			<li><?= $this->Html->link(__('New Vendor Manager'), ['controller' => 'VendorManagers', 'action' => 'add']); ?> </li>
		</ul>
	</div>
</div>
