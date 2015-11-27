<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error;
use Cake\Utility\Debugger;
use Cake\Validation\Validation;

if (!Configure::read('debug')):
	//throw new Error\NotFoundException();
endif;
	$this->assign('title', '10 things your partner marketing solution should be doing for you? | MarketingConneX');
 $this->layout = 'landingpage';
?>



    <!-- jumbotron -->
    <div class="jumbotron">
        <div class="container">
            <h1>10 things your partner marketing solution should be doing for you?</h1>
            <a  target="_blank" class="btn btn-secondary download" href="/campaignfiles/10things.pdf" role="button">Download Free PDF</a>
        </div>
    </div>
    <div class="cta">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2>Ready to turn your partners into profit?</h2>
				<?= $this->Html->link('Learn more',['controller'=>'SubscriptionPackages','action'=>'packagelist/'.$row->id],['class'=>'btn btn-tertiary'])?>
            </div>
        </div>
    </div>
    <!-- /jumbotron -->
    <!-- facts -->
    <section class="facts">
        <div class="container">
            <div class="row">
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span>1</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>Support your entire partner base 24 x 7 / in a single territory or across the globe</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span>2</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>Forecast and monitor partner and campaign performance via easy-to-use dashboards</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span>3</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>See where best deals are being made geographically to open up new opportunities</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span>4</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>Develop partner-ready, co-branded marketing materials and campaigns through a feature rich but easy-to-use and powerful campaign (build and management) tool</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span>5</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>Streamline on-boarding, training, accreditation and partner communications</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span>6</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>Provide a scalable, global solution delivering multi-language / multi-currency options</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span>7</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>Reward high performing / capability partners with intelligence-driven allocation and management of leads and MDF / Co-Op</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span>8</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>8 Provide a mobile application for real-time deal reg on-the-go, and seamless CRM integration to SalesForce and other CRM tools</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span>9</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>Incentivise and motivate partners with managed incentive programmes and partner / sales score and leader boards</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
                <!-- item -->
                <div class="col-sm-6 col-md-6">
                    <div class="media">
                        <div class="media-left">
                            <div class="bubble">
                                <span class="double">10</span>
                            </div>
                        </div>
                        <div class="media-body">
                            <p>Enable partners to take advantage of partner-ready, co- branded direct mail options (local or international)</p>
                        </div>
                    </div>
                </div>
                <!-- /item -->
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 text-center"><a class="btn btn-primary download" href="/campaignfiles/10things.pdf" role="button" target="_blank">Download Free PDF</a></div>
            </div>
        </div>
    </section>
    <!-- /facts -->
