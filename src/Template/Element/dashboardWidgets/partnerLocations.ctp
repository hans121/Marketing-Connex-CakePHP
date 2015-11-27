<!-- parter performance -->



<?php 
$this->layout = 'admin--ui';
?>




<script type="text/javascript">

function initialize() {
    var map;
    var myOptions = {
        zoom: 2,
        scrollwheel: false,
        center: new google.maps.LatLng(50.507351, 0),
        mapTypeId: 'terrain',
        styles: [{"elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"color":"#f5f5f2"},{"visibility":"on"}]},{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi.attraction","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","stylers":[{"visibility":"off"}]},{"featureType":"poi.school","stylers":[{"visibility":"off"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#ffffff"},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"visibility":"simplified"},{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"color":"#ffffff"},{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#71c8d4"}]},{"featureType":"landscape","stylers":[{"color":"#e5e8e7"}]},{"featureType":"poi.park","stylers":[{"color":"#8ba129"}]},{"featureType":"road","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.sports_complex","elementType":"geometry","stylers":[{"color":"#c7c7c7"},{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#a0d3d3"}]},{"featureType":"poi.park","stylers":[{"color":"#91b65d"}]},{"featureType":"poi.park","stylers":[{"gamma":1.51}]},{"featureType":"road.local","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"poi.government","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","stylers":[{"visibility":"simplified"}]},{"featureType":"road"},{"featureType":"road"},{},{"featureType":"road.highway"}]
    };
    map = new google.maps.Map($('#partner-map')[0], myOptions);
    
 

    <?php 
    $addresses = '';
    foreach($partners_territory as $row)
        $addresses[] = array('country'=>$row->country,'state'=>$row->state,'count'=>$row->count);
    $addresses = json_encode($addresses);
    ?>
    var addresses = <?=$addresses?>;
    for (var x=0; x < addresses.length; x++)
        setmarker(map,addresses[x]);


}


function setmarker(map,address) {
    $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+escape(address['state']+', '+address['country'])+'&sensor=false', null, function (data) {
        var p = data.results[0].geometry.location;
        var latlng = new google.maps.LatLng(p.lat, p.lng);
        new google.maps.Marker ({
            position: latlng,
            map: map,
            icon: 'http://chart.apis.google.com/chart?chst=d_map_pin_letter&chld='+address['count']+'|FFA32F|000000',
            title: address['state'] + ', ' + address['country'],
        });
    }); 
}



google.maps.event.addDomListener(window, 'load', initialize);
</script>
<!-- Card -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card--header">
                    <button type="button" class="close pull-right" data-toggle="collapse" data-target="#collapsePartnerLocations"><i class="icon icon--small ion-minus-circled"></i></button>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="card--icon">
                                <div class="bubble">
                                    <i class="icon ion-location"></i></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title"><?= __('Partner locations'); ?></h2>
                                <h3 class="card--subtitle"></h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">
                                <?= $this->Html->link(__('View all'), ['controller' => 'Vendors','action' => 'Partners'], ['class' => 'btn btn-primary pull-right']); ?>
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="collapse in" id="collapsePartnerLocations">

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

<div class="row charts">

    <div class="col-xs-12">


<!--
        <div class="row">
            <div class="col-xs-12">
                <div id="partner-map" class="map-canvas"></div>
            </div>

        </div>
-->
        <!-- Are there any campaigns? -->
        <?php
        if($partners_territory->count()>0) {
            ?>

            <div class="row table-th hidden-xs">

                <div class="clearfix"></div>

                <div class="col-sm-4">
                    <?= __('Country') ?>
                </div>

                <div class="col-sm-3">
                    <?= __('County/State') ?>
                </div>

                <div class="col-sm-2 text-center">
                    <?= __('Number of partners') ?>
                </div>

                <div class="col-sm-3">
                </div>

            </div> <!--/.row.table-th -->

            <!-- Start loop -->
            <?php
            $l =0;
            foreach ($partners_territory as $row):
                $l++;
            ?>

            <div class="row inner hidden-xs">

                <div class="col-sm-4">
                    <?= $row->country ?>
                </div>

                <div class="col-sm-3">
                    <?= $row->state ?>
                </div>

                <div class="col-sm-2 text-center">
                    <?= $row->count ?>
                </div>

                <div class="col-sm-3">

                    <div class="btn-group pull-right">
                        <?= $this->Html->link('Details',['controller'=>'Vendors','action'=>'partnersbyterritory/'.urlencode(strtolower($row->country)).'/'.urlencode(strtolower($row->state))],['class'=>'btn btn-default'])?>
                    </div>

                </div>

            </div> <!--/.row.inner-->

            <div class="row inner visible-xs"   >

                <div class="col-xs-12 text-center">

                    <a data-toggle="collapse" data-parent="#accordion" href="#basic2-<?= $l ?>">
                        <h3><?= $row->state ?>, <?= $row->country ?></h3>
                    </a>

                </div> <!-- /.col -->

                <div class="col-xs-12 panel-collapse collapse" id="basic2-<?= $l ?>">

                    <div class="row inner">

                        <div class="col-xs-5">
                            <?= 'Number of partners'?>
                        </div>
                        <div class="col-xs-7">
                            <?= $row->count ?>
                        </div>

                        <div class="col-xs-12">

                            <div class="btn-group pull-right">
                                <?= $this->Html->link('Details',['controller'=>'Vendors','action'=>'viewPartner/5'],['class'=>'btn btn-default'])?>
                            </div>

                        </div>

                    </div> <!--collapseOne-->

                </div> <!--row-->

            </div> <!-- /.row.inner -->

            <?php

            endforeach;

        } else {

            ?>

            <div class="row inner withtop">

                <div class="col-sm-12 text-center">
                    <?=  __('No partners found') ?>
                </div>

            </div> <!--/.row.inner-->

            <?php

        }

        ?>

        <!-- End loop -->

    </div> <!-- /.col -->

</div> <!-- /.row -->


</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Card -->


