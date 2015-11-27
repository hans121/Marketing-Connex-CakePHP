<?php
	$i=0;
	$sub_packages   = array();
	foreach ($packages as $package): 
    if($i < 4)
      $sub_packages[$i]   =   $package;
    $i++;
	endforeach;
    	echo $this->Html->css('style.min.css', ['block' => true]);
?>


    <header class="pricing--page_header">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <h1><?= __('Ready to turn your partners into profit?')?></h1>
                    <h2><?= __('Feature rich, with simple pricing. It&#39;s Channel Management made easy')?></h2>
					<?= $this->Html->link(__('Book a demo'),['controller' => 'Contact','action' => 'index','request' => 'demo'],['escape' => false, 'title' => 'Book a demo','class'=>'btn btn--default']);?>
                </div>
            </div>
        </div>
    </header>
    <section class="pricing--table">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-md-4 price--col_smb">
                    <div class="price--col">
                        <!-- price header-->
                        <div class="price--header">
                            <div class="price--header_body">
                                <h2 class="package--title">SMB</h2>
                                <h2 class="package--price">$58.00 /mo<br>per partner</h2>
        	            <?= $this->Html->link(__('Request <strong>Free</strong> Trial'), ['controller'=>'Vendors','action' => 'buypackage',4],['class' => 'btn btn--price', 'escape' => false]); ?>
                            </div>
                            <div class="price--header_footer">
                                <h3><strong>SMB</strong> includes the below features</h3>
                            </div>
                        </div>
                        <!-- /price header-->
                        <!-- price features -->
                        <div class="price--features">
                            <div class="price--features_row">
                                <h2>Initial setup Fee</h2>
                                <p>$1,250.00</p>
                            </div>
                            <div class="price--features_row">
                                <h2>Features</h2>
                                <ul>
                                    <li>1 GB Storage <i class="icon ion-ios-information-outline" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"></i></li>
                                    <li>25 partners <i class="icon ion-ios-information-outline" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"></i></li>
                                    <li>2,250 emails <i class="icon ion-ios-information-outline" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"></i></li>
                                </ul>
                            </div>
                            <div class="price--features_row">
                                <ul>
                                    <li>Content Management</li>
                                    <li>Campaign planning</li>
                                    <li>Resource library</li>
                                    <li>Deal registration</li>
                                    <li>Drag & Drop HTML Builder</li>
                                    <li>Image Library powered by Getty</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- price footer -->
                    <div class="price--footer">
                        <h2>Go Annual & Save</h2>
                        <h4>$1,450</h4>
        	            <?= $this->Html->link(__('Request <strong>Free</strong> Trial'), ['controller'=>'Vendors','action' => 'buypackage',4],['class' => 'btn btn--price', 'escape' => false]); ?>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4  price--col_mid">
                    <div class="price--col">
                        <!-- price header-->
                        <div class="price--header">
                            <div class="price--header_body">
                                <h2 class="package--title">Mid Market</h2>
                                <h2 class="package--price">$52.00 /mo<br>per partner</h2>
	        	            <?= $this->Html->link(__('Get Started today'), ['controller'=>'Vendors','action' => 'buypackage',3],['class' => 'btn btn--price']); ?>
                            </div>
                            <div class="price--header_footer">
                                <h3><strong>Mid</strong> includes all of <strong>SMB</strong> plus</h3>
                            </div>
                        </div>
                        <!-- /price header-->
                        <!-- price features -->
                        <div class="price--features">
                            <div class="price--features_row">
                                <h2>Initial setup Fee</h2>
                                <p>$1,500.00</p>
                            </div>
                            <div class="price--features_row">
                                <h2>Features</h2>
                                <ul>
                                    <li>2.5 GB Storage <i class="icon ion-ios-information-outline" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"></i></li>
                                    <li>75 partners <i class="icon ion-ios-information-outline" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"></i></li>
                                    <li>3,000 emails <i class="icon ion-ios-information-outline" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"></i></li>
                                </ul>
                            </div>
                            <div class="price--features_row">
                                <ul>
                                    <li>Lead Management</li>
                                    <li>Multi-Currency</li>
                                    <li>Multi Lingual</li>
                                    <li>M.D.F &amp; Co-Funding</li>
                                    <li>Partner App</li>
                                    <li>Social Media</li>
                                    <li>SalesForce Integration</li>
                                    <li>Communication Module</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- price footer -->
                    <div class="price--footer">
                        <h2>Go Annual & Save</h2>
                        <h4>$3,900</h4>
        	            <?= $this->Html->link(__('Get Started today'), ['controller'=>'Vendors','action' => 'buypackage',3],['class' => 'btn btn--price']); ?>
                    </div>
                </div>
                <div class="col-sm-4 col-md-4  price--col_ent">
                    <div class="price--col">
                        <!-- price header-->
                        <div class="price--header">
                            <div class="price--header_body">
                                <h2 class="package--title">Enterprise</h2>
                                <h2 class="package--price">$42.00 /mo<br>per partner</h2>
		        	            <?= $this->Html->link(__('Get Started today'), ['controller'=>'Vendors','action' => 'buypackage',2],['class' => 'btn btn--price']); ?>
                            </div>
                            <div class="price--header_footer">
                                <h3><strong>Enterprise</strong> includes <strong>Mid</strong> plus</h3>
                            </div>
                        </div>
                        <!-- /price header-->
                        <!-- price features -->
                        <div class="price--features">
                            <div class="price--features_row">
                                <h2>Initial setup Fee</h2>
                                <p>$2,000.00</p>
                            </div>
                            <div class="price--features_row">
                                <h2>Features</h2>
                                <ul>
                                    <li>5 GB Storage <i class="icon ion-ios-information-outline" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"></i></li>
                                    <li>175 partners <i class="icon ion-ios-information-outline" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"></i></li>
                                    <li>3,750 emails <i class="icon ion-ios-information-outline" data-toggle="tooltip" data-placement="bottom" title="Tooltip on bottom"></i></li>
                                </ul>
                            </div>
                            <div class="price--features_row">
                                <ul>
                                    <li>Partner incentive programme</li>
                                    <li>Partner recruitment</li>
                                    <li>Partner Training</li>
                                    <li>Direct Mail Platform</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- price footer -->
                    <div class="price--footer">
                        <h2>Go Annual & Save</h2>
                        <h4>$7,375</h4>
        	            <?= $this->Html->link(__('Get Started today'), ['controller'=>'Vendors','action' => 'buypackage',2],['class' => 'btn btn--price']); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="pricing--terms">
                        <p><?= __('Our pricing is simple and modular, with special programs for those that are launching or in an early growth stage and complete packages for the more robust channels. In addition to our core functionality, our ecosystem of solutions providers connects to your existing applications, like CRM, eLearning and Marketing Automation Systems.</p>')?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="pricing--page_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1><?= __('Not sure what&#39;s best for you?</h1>')?>
                    <h2><?= __('Talk to our friendly team for advice</h2>')?>
					<?= $this->Html->link(__('Get in contact'),['controller' => 'Contact','action' => 'index'],['escape' => false, 'title' => 'Get in contact','class'=>'btn btn--secondary']);?>
                </div>
            </div>
        </div>
    </footer>

