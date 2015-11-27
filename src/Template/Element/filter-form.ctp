<div class="col-md-12 hidden-xs filter-form">

	<?= $this->Form->create(); ?>

		<div class="input-group input text">
		
			
			<?=$this->Form->input('keyword',['value' => $keyword,'placeholder' => 'Filter','class' => 'form-control','label' => '','type'=> 'text']);?>
			<span class="input-group-btn">
			
				<?= $this->Form->button('<i class="icon ion-chevron-right"></i>',['class'=> 'btn btn-search btn-primary']); ?>   
			                        
			</span>
			
		</div>

	<?= $this->Form->end(); ?>
	
</div>
