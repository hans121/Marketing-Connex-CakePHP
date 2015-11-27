<?php if($vendor_sbmt_bp > 0){?>
  <li>
    <?= $this->Html->link($vendor_sbmt_bp.__(' new campaign plans submitted'), ['controller' => 'VendorCampaignplans', 'action' => 'index'],['title' => 'View campaign plans']); ?>
  </li>
<?php } ?>
