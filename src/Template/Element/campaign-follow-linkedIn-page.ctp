<script type="text/javascript">
    $(document).ready(function() {
        var max_fields_linkedln      = 5; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap1"); //Fields wrapper
        var add_button1      = $(".add_linkedInPost_button"); //Add button ID
        var max = [];
        var x = 0; //initlal text box count
        $(add_button1).click(function(e){ //on add input button click
            e.preventDefault();

            if(x < max_fields_linkedln){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div class="resource-container"><a href="#" class="btn pull-right remove_field"><?= __('Remove')?></a><label><?= __("Post Title")?></label><input type="text" name="post-title-'+x+'"><div id="linkedIn_text" class="row"><div class="col-md-12"><?php echo $this->Form->input("linkedln_Post_text", ["type"=>"textarea","id"=>"linkedln_Post_text"]); ?></div><div class="col-md-9">Merge Tag: <span title="Copy this in your text box"><b>[*!LANDINGURL!*]</b></span> <span class="text-muted"><small>This will be replaced with the url of the online version of the email</small></span></div><div id="post_text_counter_'+x+'" class="col-md-3 text-right">138 characters remaining</div></div></div>'); //add input box
                max[x] = 138;
                $('#linkedln_Post_text').attr('id','linkedln_Post_text_'+x);
                $('#linkedln_Post_text_'+x).attr('name','linkedln_Post_text_'+x);
                $('#linkedln_Post_text_'+x).keyup(function() {
                    updateCounter(this,'#post_text_counter_'+x)
                });
                function updateCounter(obj,field) {
                    var emailurltag = '[*!EMAILURL!*]';
                    var txtlen = $(obj).val().length;
                    if($(obj).val().match(/(.*?)\[\*\!EMAILURL\!\*\](.*?)/))
                    {
                        txtlen = txtlen - (emailurltag.length) + <?=strlen($email_url)?>;
                    }

                    if(txtlen > max[x]) {
                        $(obj).val($(obj).val().substr(0, max[x]));
                    }else {
                        $(field).html((max[x] - txtlen) + ' characters remaining');
                    }
                }
            }

        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })

        max[0] = 138;
        $('#linkedln_Post_text_0').keyup(function() {
            updateCounter(this,'#post_text_counter_0')
        });
        function updateCounter(obj,field) {
            var emailurltag = '[*!EMAILURL!*]';
            var txtlen = $(obj).val().length;
            if($(obj).val().match(/(.*?)\[\*\!EMAILURL\!\*\](.*?)/))
            {
                txtlen = txtlen - (emailurltag.length) + <?=strlen($email_url)?>;
            }

            if(txtlen > max[0]) {
                $(obj).val($(obj).val().substr(0, max[0]));
            }else {
                $(field).html((max[0] - txtlen) + ' characters remaining');
            }
        }

    });
</script>

<div class="input_fields_wrap1">
<br>
  <div class="resource-container">

    <label><?= __('Post Title')?></label>
    <input type="text" name="post-title-0">
    <div id="linkedIn_text" class="row">
        <div class="col-md-12"><?php echo $this->Form->input("linkedln_Post_text", ["type"=>"textarea","id"=>"linkedln_Post_text_0"]); ?></div>
        <div class="col-md-9">Merge Tag: <span title="Copy this in your text box"><b>[*!LANDINGURL!*]</b></span> <span class="text-muted"><small>This will be replaced with the url of campaign LandingPage URL</small></span></div>
        <div id='post_text_counter_0' class="col-md-3 text-right">138 characters remaining</div>
    </div>
  </div>

</div>
<button class="btn btn-primary pull-right add_linkedInPost_button">
	<?= __('Add another')?>
</button>

<div class="clearfix"></div>
