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
									<i class="icon ion-document"></i></div>
								</div>
								<div class="card--info">
									<h2 class="card--title"><?= __('Resource'); ?></h2>
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

						<div class="row">
							<div class="col-md-12">
								<h4><?= h($page->title) ?></h4>

								<hr>
							</div>
						</div>
						<!-- content below this line -->



						<div class="folders view">



							<?php echo $this->Flash->render(); echo $this->Flash->render('auth'); ?>



							<div class="row inner">   
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<?= $page->content ?>
								</div>
							</div>

						</div>

					<!-- content below this line -->
				</div>
				<div class="card-footer">
					<div class="row">
						<div class="col-md-8">
							<!-- breadcrumb -->
							<ol class="breadcrumb">
								<li>               
									<?php
									$this->Html->addCrumb('Communications', ['controller'=>'VendorPages', 'action'=>'index']);
									$this->Html->addCrumb(h($page->title), ['controller' => 'VendorPages', 'action' => 'view', $page->id]);
									echo $this->Html->getCrumbs(' / ', [
										'text' => $this->Html->tag('span',__('',false),['class' => 'fa fa-home']),
										'url' => ['controller' => 'Admins', 'action' => 'index'],
										'escape' => false
										]);
										?>
									</li>
								</ol>
							</div>
							<div class="col-md-4 text-right">
								<?= $this->Html->link(__('Back'), $last_visited_page,['class' => 'btn btn-default btn-cancel']); ?>         


							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /Card -->

