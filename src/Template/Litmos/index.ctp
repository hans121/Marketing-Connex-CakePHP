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
                                <div class="section__circle-container__circle mdl-color--primary"></div>
                            </div>
                            <div class="card--info">
                                <h2 class="card--title">Training Portal</h2>
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

<div class="campaigns index">
			

	
  <?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>
	
 	<div class="row">
 		<div class="col-md-12">
			<div id="please_wait">
				<h4 id=""><i class="fa fa-spinner fa-spin"></i> Please wait...</h4>
			</div>
			<div id="gotoLitmos" style="display:none">
				<a href="<?php echo $loginKey; ?>" target="_blank" id="clicked"><button type="button" class="btn btn-primary text-center">Go to training dashboard</button></a>
			</div>
		</div>	
	</div>
</div><!-- /.container -->
<script>
	$(function(){
		
		var userLitmosID = "<?php echo $userLitmosID;?>";
		$.post("<?php echo $this->Url->build([ "controller" => "Litmos","action" => "index"]);?>",{'userLitmosID':userLitmosID},function(data){
			if(!data.loginKey) {
				window.location.reload();
			}else {
				//window.location.href = data.loginKey;
				$('#please_wait').slideUp();
				$('#gotoLitmos').slideDown();
				$('#clicked')[0].click();
				
			}
		},'json');
	});
</script>
<!-- content below this line -->
</div>
<div class="card-footer">
	<div class="row">
		<div class="col-md-6">
			<!-- breadcrumb -->
			<ol class="breadcrumb">
				<li>               
<?php
					$this->Html->addCrumb('Litmos', ['controller' => 'Litmos', 'action' => 'index']);
					echo $this->Html->getCrumbs(' / ', [
					    'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
					    'url' => ['controller' => 'Vendors', 'action' => 'index'],
					    'escape' => false
					]);
				?>
					</li>
				</ol>
			</div>
			<div class="col-md-6">
  <?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-primary pull-right']); ?> 			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<!-- /Card -->

