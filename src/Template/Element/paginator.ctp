		
<div class="row">
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<ul class="pagination">
			<?php
			echo $this->Paginator->prev('<i class="icon ion-arrow-left-b"></i> ' . __('prev'), ['escape' => false]);
			echo $this->Paginator->numbers();
			echo $this->Paginator->next(__('next') . ' <i class="icon ion-arrow-right-b"></i>', ['escape' => false]);
			?>
		</ul>
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<p class="pull-right page-total hidden-xs">
			<?= $this->Paginator->counter(); ?>
		</p>
	</div>
</div>