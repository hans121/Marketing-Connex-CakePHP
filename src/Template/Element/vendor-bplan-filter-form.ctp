<div class="col-sm-12 filter-form panel-collapse collapse in" id="filterCollapse">

	<?= $this->Form->create(); ?>

	<div class="row filters">
		<div class="col-md-2">

			<?=$this->Form->input('id',['value' => $filters['id'],'placeholder' => 'ID','class' => 'form-control','label' => '','type'=> 'text']);?>
		</div>
		<div class="col-md-2">

			<?php 
			echo $this->Form->input('partner_id', ['options' => $partners,'data-live-search' => true,'empty'=>'All Partners','label' => '','value' => $filters['partner_id']]); ?>
		</div>
		<div class="col-md-2">

			<?php echo $this->Form->input('financialquarter_id', ['options' => $financialquarters,'empty'=>'All Quarters','label' => '','value' => $filters['financialquarter_id']]); ?>
		</div>
		<div class="col-md-2">

			<?php echo $this->Form->input('campaign_id', ['options' => $campaigns,'empty'=>'All Campaigns','label' => '','value' => $filters['campaign_id']]); ?> </div>
			<div class="col-md-2">
				<?php

				echo $this->Form->input('status', ['options' => $stoptions,'empty'=>'All Statuses','label' => '','value' => $filters['status']]);
				?>
			</div>
			<div class="col-md-2">

				<div class="input-group-btn">
					<?= $this->Form->button('Filter',['class'=> 'btn btn-search btn-default']); ?>   
				</div>

			</div>
		</div>

		<?= $this->Form->end(); ?>
<hr>
	</div>

