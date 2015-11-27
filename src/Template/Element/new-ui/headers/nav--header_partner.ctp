<!-- partner nav layout -->
<div class="mdl-layout__drawer">

    <?php
    $admn = $this->Session->read('Auth');
    switch ($admn['User']['role']) {        

        case 'partner':
        ?>
        <?php if(isset($admn['User']['logo_url'])) { ?>
        <h2 class="navbar-brand">
            <?= $this->Html->image($admn['User']['logo_url'].'?rnd='.rand(),['title'=>($admn['User']['company_name']).' ('.($admn['User']['first_name']).' '.($admn['User']['last_name']).')','alt'=>($admn['User']['company_name']),'width'=>'301','height'=>'76','class'=>'img-responsive','url' => ['controller' => 'Partners', 'action' => 'index']])?>
        </h2>
        <?php } else { ?>
        <h2 class="navbar-brand-logo">
            <?= $this->Html->image('logos/logo-marketing-connex.png', [ 'title'=>'MarketingConneX', 'alt'=>'MarketingConneX','width'=>'400','height'=>'150','class'=>'img-responsive','url' => ['controller' => 'Partners', 'action' => 'index']]);?>                       
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
        <li class="mdl-navigation__link"><?= $this->Html->link(__('Home'), ['controller' => 'Partners', 'action' => 'index']); ?></li>
        <!-- campaigns -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Campaigns'), ['controller' => 'PartnerCampaigns', 'action' => 'mycampaignslist']); ?>  
        </li>

        <!-- /campaigns -->
        <li class="mdl-navigation-sub__link">
        <?= $this->element('new-ui/headers/nav--header-sub_campaigns'); ?>
        </li>

        <!-- leads -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Leads'), ['controller' => 'PartnerLeads', 'action' => 'index']); ?>
        </li>
        <!-- /leads -->
        <!-- managers -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Managers'), ['controller' => 'PartnerManagers', 'action' => 'index']); ?>
        </li>
        <!-- /managers -->
        <!-- /partners -->
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Profile'), ['controller' => 'Partners', 'action' => 'view']); ?>
        </li>
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Resources'), ['controller' => 'PartnerResources', 'action' => 'index']); ?>
        </li>
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Communications'), ['controller' => 'PartnerPages', 'action' => 'index']); ?>
        </li>
        <li class="mdl-navigation__link">
            <?= $this->Html->link(__('Lists'), ['controller' => 'PartnerMailinglistGroups', 'action' => 'index']); ?>
        </li>
    </nav>
</div>

