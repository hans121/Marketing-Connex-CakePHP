
<!-- Card -->

  <div class="row">
    <div class="col-md-12">
      <div class="card">

        <div class="card--header">

          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="card--icon">
                <div class="bubble">
                  <i class="icon ion-plus"></i></div>
                </div>
                <div class="card--info">
                  <h2 class="card--title"><?= __('Email Statistics')?></h2>
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
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
</p>
<hr>
</div>
</div>
-->
<!-- content below this line -->
<!-- stats -->
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table table--stats">
                                                    <thead>
                                                        <tr>
                                                            <th><?='Opens'?></th>
                                                            <th><?='Clicks'?>
                                                            					
				</th>
                                                            <th><?='Unsubscribed'?>
                                                           
					</th>
                                                           
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><?=$this->Number->toPercentage($campstatics['openperc']);?></td>
                                                            <td><?=$this->Number->toPercentage($campstatics['clickperc']);?></td>
                                                            <td><?=$this->Number->toPercentage($campstatics['unsubperc']);?></td>
                                                           
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- /stats -->



<!-- content below this line -->
</div>

</div>
</div>
</div>
<!-- /Card -->

