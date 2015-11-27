<!-- vendor nav layout -->
<div class="mdl-layout__drawer">
    <?php
    $admn = $this->Session->read('Auth');
    switch ($admn['User']['role']) {        

        case 'vendor':
        ?>
        <?php if(isset($admn['User']['logo_url'])) { ?>
        <h2 class="navbar-brand">
            <?= $this->Html->image($admn['User']['logo_url'].'?rnd='.rand(),['title'=>($admn['User']['company_name']).' ('.($admn['User']['first_name']).' '.($admn['User']['last_name']).')','alt'=>($admn['User']['company_name']),'class'=>'img-responsive','url' => ['controller' => 'Vendors', 'action' => 'index']])?>
        </h2>
        <?php } else { ?>
        <h2 class="navbar-brand-logo">
            <?= $this->Html->image('logos/logo-marketing-connex.png', [ 'alt'=>'Panovus','class'=>'img-responsive','url' => ['controller' => 'Vendors', 'action' => 'index']]);?>                        
        </h2>
        <?php } ?>
        <?php
        break;

        default:
        ?>

        <?php if(isset($admn['User']['logo_url'])) { ?>
        <h2 class="navbar-brand">
            <?= $this->Html->image($admn['User']['logo_url'].'?rnd='.rand(),['title'=>($admn['User']['company_name']).' ('.($admn['User']['first_name']).' '.($admn['User']['last_name']).')','alt'=>($admn['User']['company_name']),'width'=>'301','height'=>'76','class'=>'img-responsive','url' => ['controller' => 'Pages', 'action' => 'index']])?>
        </h2>
        <?php } else { ?>
        <h2 class="navbar-brand-logo">
            <?= $this->Html->image('logos/logo-marketing-connex.png', [ 'alt'=>'Panovus','width'=>'400','height'=>'150','class'=>'img-responsive','url' => ['controller' => 'Pages', 'action' => 'home']]);?>                       
        </h2>
        <?php } ?>

        <?php
        break;
    }
    ?>

    <span class="mdl-layout-title"></span>
    <nav class="mdl-navigation">
        <li class="mdl-navigation__link"><?= $this->Html->link(__('Home'), ['controller' => 'Vendors', 'action' => 'index']); ?></li>
        <!-- campaigns -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Campaigns'), ['controller' => 'Campaigns', 'action' => 'index']); ?> 
        </li>
        <!-- /campaigns -->
                <li class="mdl-navigation__link">
        <?= $this->Html->link(__('Campaign Plans'), ['controller' => 'VendorCampaignplans', 'action' => 'index']); ?>
        </li>
        <!-- leads -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Leads'), ['controller' => 'Leads', 'action' => 'index']); ?>
        </li>
        <!-- /leads -->
        <!-- deals -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Deals'), ['controller' => 'Deals', 'action' => 'index']); ?>
        </li>
        <!-- /deals -->        
        <!-- managers -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Managers'), ['controller' => 'Vendors', 'action' => 'listvendormanagers']); ?>
        </li>
        <!-- /managers -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Partners'), ['controller' => 'Vendors', 'action' => 'partners']); ?> 
        </li>
        <!-- /partners -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Resources'), ['controller' => 'VendorResources', 'action' => 'index']); ?>
        </li>
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Communications'), ['controller' => 'VendorPages', 'action' => 'index']); ?>
        </li>
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Training'), ['controller' => 'Training', 'action' => 'index']); ?>
        </li>
    </nav>
</div>

