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
            $(wrapper).append('<div class="resource-container">		<label><?= __('External URL text')?></label>		<input type="text" name="form_external['+x+'][text]"/>	<label><?= __('External URL link')?></label>	<input type="text" name="form_external['+x+'][url]"/>	<a href="#" class="btn pull-left remove_field"><?= __('Remove')?></a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

	function checkurl() {
		var originalvalue = document.getElementByName('form_external').value;
		var value = originalvalue.toLowerCase();
		if (value && value.substr(0, 7) !== 'http://' && value.substr(0, 8) !== 'https://') {
			// then prefix with http://
			document.getElementByName('form_external').value = 'http://' + value;
		}               
	}

</script>

<div class="input_fields_wrap">
	
	<h4>
		Add external links to the landing page
	</h4>
  <?php
	  if(isset($externalurls)):
	  $i=0;
	  foreach($externalurls as $xt):
	      if(!isset($xt->text)){
	          $xt->text =   '';
	      }
	      if(!isset($xt->url)){
	          $xt->url =   '';
	      }
	        //print_r($xt);exit;
  ?>
  <div class="resource-container"><label><?= __('External URL text')?></label><input type="text" name="form_external[<?=$i?>][text]" value="<?=$xt->text ?>"><label><?= __('External URL link')?></label><input type="text" name="form_external[<?=$i?>][url]" value="<?=$xt->url ?>">
  <?php if($i > 0){?>
      <a href="#" class="btn pull-left remove_field">Remove</a>
  <?php } ?>
  </div>
  <?php
  $i++;
  endforeach;
  else: ?>
  <div class="resource-container"><label><?= __('External URL text')?></label><input type="text" name="form_external[0][text]"><label><?= __('External URL link')?></label><input type="text" name="form_external[0][url]"></div>
  <?php endif; ?>
</div>

<button class="btn btn-primary pull-left add_field_button">
	<?= __('Add another')?>
</button>

<div class="clearfix"></div>
