<script type="text/javascript">
    $(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append(
    '<div class="row input--field">'+
	'    <div class="col-md-3">'+
	'		<label><?= __('Resource title')?></label>'+
	'	</div>'+
	'    <div class="col-md-9" id="input--field">'+
	'		<input type="text" class="form-control" name="resource['+x+'][title]">'+
	'	</div>'+
	'</div>'+
 
    '<div class="row input--field">'+
    
	'<div class="col-md-4">'+
	'    <label><?= __('Browse resource')?></label>'+
	'</div>'+
	
	'<div class="resource-selector">'+
	
	'	<div class="file-wrapper">'+
	'        <div class="col-md-5">'+
	
	'	    	<div class="input file">'+
	'			    <input type="file" class="form-control" name="resource['+x+'][file]">'+
	'	    	</div>'+
	'        </div>'+
	'        <div class="col-md-3">'+
	'	    	<span class="btn btn-default btn-sm pull-right button">Update</span>'+
	'	    </div>'+
	'    </div>'+
	    
	'</div>'+
	'</div>'
			);
           
           	$('.file-wrapper input[type=file]').bind('change focus click', SITE.fileInputs);
     }

    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>


<div class="input_fields_wrap">


<div class="resource-container">

<div class="row input--field">
    <div class="col-md-3">
		<label><?= __('Resource title')?></label>
	</div>
    <div class="col-md-9" id="input--field">
		<input type="text" class="form-control" name="resource[0][title]">
	</div>
</div>

<div class="row input--field">

	<div class="col-md-4">
	    <label><?= __('Browse resource')?></label>
	</div>
	
	<div class="resource-selector">
	
		<div class="file-wrapper">
	        <div class="col-md-5">
	
		    	<div class="input file">
				    <input type="file" class="form-control" name="resource[0][file]">
		    	</div>
	        </div>
	        <div class="col-md-3">
		    	<span class="btn btn-default btn-sm pull-right button">Update</span>
		    </div>
	    </div>
	    
	</div>

</div>
</div>
</div>

<button class="btn btn-primary pull-left add_field_button">
	<?= __('Add another')?>
</button>

<div class="clearfix"></div>
