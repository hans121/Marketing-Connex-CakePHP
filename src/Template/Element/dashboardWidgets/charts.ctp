<!-- charts -->



<?php 
$this->layout = 'admin--ui';
?>
<!-- Card -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card--header">

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="card--icon">
                                <div class="bubble">
                                <i class="icon ion-pie-graph"></i></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title">Dashboard</h2>
                                <h3 class="card--subtitle"></h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="card-content">
                    <!--
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Campaign Options</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                            </p>
                            <hr>
                        </div>
                    </div>
                -->
                    <!-- content below this line -->

 <!-- chart options -->
                                        <div class="row chart--container">
                                            <div class="col-md-3">
                                                <div id="canvas-holder">
                                                    <h2>Top Deals</h2>
                                                    <canvas id="chart-deals_pie" width="300" height="300" />
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div id="canvas-holder">
                                                    <h2>Highest Performing</h2>
                                                    <canvas id="chart-higestPerforming_doughnut" width="500" height="500" />
                                                </div>
                                            </div>
                                                                                  <div class="col-md-3">
                                                <div id="canvas-holder">
                                                    <h2>Top Campaigns</h2>
                                                    <canvas id="chart-topcampaigns_pie" width="500" height="500" />
                                                </div>
                                            </div>
             
                                        </div>
                                        <!-- /chart options -->


                </div>

            </div>
        </div>
    </div>
</div>
    <!-- /Card -->

<!-- Initialize Charts.js -->
<!-- Initialize Charts.js -->

                   
    <script>


    var dealsData = [
    <?php 
    $c = 100;
    $h = $c-10;
    $i = 0;
    foreach($campaignPartnerMailinglistDeal as $row): 
    ?>
    {
        value: <?=$row->deal_value?>,
        color: "rgba(41, 128, 185, <?=$i>0?'.'.$c:$c?>)",
        highlight: "rgba(41, 128, 185, .<?=$h?>)",
        label: "<?=$row->partner_manager->user->first_name.' '.$row->partner_manager->user->last_name?>"
    },
    <?php
    $c = $c-20;
    $h = $c-10;
    $i++;
    endforeach; 
    ?>
    ];

    //highest performing
    var highestPerforming = [
    <?php 
    $c = 100;
    $h = $c-10;
    $i = 0;
    foreach($partners_registered_highest as $row): 
    ?>
    {
        value: <?=$row['deals_value']?>,
        color: "rgba(41, 128, 185, <?=$i>0?'.'.$c:$c?>)",
        highlight: "rgba(41, 128, 185, .<?=$h?>)",
        label: "<?=$row['partner_name']?>"
    },
    <?php
    $c = $c-20;
    $h = $c-10;
    $i++;
    endforeach; 
    ?>
    ];

    //Top Campaigns
    var topcampaigns = [
    <?php 
    $c = 100;
    $h = $c-10;
    $i = 0;
    foreach($campaignQ as $row): 
    $total_deal = 0;
    $deal_count = 0;
    foreach($row->campaign_partner_mailinglists as $row2) {                 
        if($row2['campaign_partner_mailinglist_deals'][0]['status']=='Y') {
            $total_deal += $row2['campaign_partner_mailinglist_deals'][0]['deal_value'];
            $deal_count++;
        }
    }
    ?>
    {
        value: <?=$total_deal?>,
        color: "rgba(41, 128, 185, <?=$i>0?'.'.$c:$c?>)",
        highlight: "rgba(41, 128, 185, .<?=$h?>)",
        label: "<?=$row->name?>"
    },
    <?php
    $c = $c-20;
    $h = $c-10;
    $i++;
    endforeach; 
    ?>
    ];
  







    window.onload = function() {
        var ctx = document.getElementById("chart-deals_pie").getContext("2d");
        window.myPie = new Chart(ctx).Pie(dealsData, {
            responsive: true
        });

        var ctx1 = document.getElementById("chart-higestPerforming_doughnut").getContext("2d");
        window.myDoughnut = new Chart(ctx1).Doughnut(highestPerforming, {
            responsive: true
        });
        
        var ctx2 = document.getElementById("chart-topcampaigns_pie").getContext("2d");
        window.myPie = new Chart(ctx2).Pie(topcampaigns, {
            responsive: true
        });
              
    };
    </script>
