<!-- parter performance -->



<?php 
$this->layout = 'admin--ui';
?>

<!-- Google Maps API -->
<?php echo $this->Html->script('https://maps.googleapis.com/maps/api/js?key=AIzaSyBlNRHavddm2klM2rvZG0_TPOChIFY4Vrg&libraries=visualization');?>
<?= $this->fetch('script');?>


    <script>
// Adding 500 Data Points
var map, pointarray, heatmap;

<?php 
$addresses = '';
foreach($partners_territory as $row)
    $addresses[] = array('country'=>$row->country,'state'=>$row->state,'count'=>$row->count);
$addresses = json_encode($addresses);
?>
var taxiData = [];
var addresses = <?=$addresses?>;
var taxi_i = 0;
for (var x=0; x < addresses.length; x++)
{
	var address = addresses[x];
    $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?address='+escape(address['state']+', '+address['country'])+'&sensor=false', null, function (data) {
        var p = data.results[0].geometry.location;
        var latlng = new google.maps.LatLng(p.lat, p.lng);
        taxiData[taxi_i] = latlng;
        taxi_i++;
    });
}

function initialize() {
  var mapOptions = {
    zoom: 2,
    scrollwheel: false,
        center: new google.maps.LatLng(50.507351, 0),
    mapTypeId: google.maps.MapTypeId.TERRAIN
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);

  var pointArray = new google.maps.MVCArray(taxiData);

  heatmap = new google.maps.visualization.HeatmapLayer({
    data: pointArray
  });

  heatmap.setMap(map);
}

function toggleHeatmap() {
  heatmap.setMap(heatmap.getMap() ? null : map);
}

function changeGradient() {
  var gradient = [
    'rgba(0, 255, 255, 0)',
    'rgba(0, 255, 255, 1)',
    'rgba(0, 191, 255, 1)',
    'rgba(0, 127, 255, 1)',
    'rgba(0, 63, 255, 1)',
    'rgba(0, 0, 255, 1)',
    'rgba(0, 0, 223, 1)',
    'rgba(0, 0, 191, 1)',
    'rgba(0, 0, 159, 1)',
    'rgba(0, 0, 127, 1)',
    'rgba(63, 0, 91, 1)',
    'rgba(127, 0, 63, 1)',
    'rgba(191, 0, 31, 1)',
    'rgba(255, 0, 0, 1)'
  ]
  heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
}

function changeRadius() {
  heatmap.set('radius', heatmap.get('radius') ? null : 20);
}

function changeOpacity() {
  heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
<!-- Card -->

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card--header">
                    <button type="button" class="close pull-right" data-toggle="collapse" data-target="#collapseHeatmap"><i class="icon icon--small ion-minus-circled"></i></button>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="card--icon">
                                <div class="bubble">
                                  <i class="icon ion-earth"></i></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title">Partner Heatmaps</h2>
                                <h3 class="card--subtitle">Heatmaps</h3>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <div class="card--actions">
                               
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="collapse in" id="collapseHeatmap">

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

<div class="row">

    <div class="col-xs-12">



       <div id="panel-map">
      <button onclick="toggleHeatmap()" class="btn btn-default">Toggle Heatmap</button>
      <button onclick="changeGradient()" class="btn btn-default">Change gradient</button>
      <button onclick="changeRadius()" class="btn btn-default">Change radius</button>
      <button onclick="changeOpacity()" class="btn btn-default">Change opacity</button>
    </div>
    <div id="map-canvas"></div>

  </div>

        

</div> 


</div>
</div>
</div>
</div>
</div>
</div>
<!-- /Card -->


