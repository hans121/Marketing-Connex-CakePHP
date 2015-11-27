    
<?php
$this->layout = 'admin--ui-beefree';
$cmp_id = $this->request['pass'][0]; 
$email_id= $this->request['pass'][1]; 
?>  


  
	<div class="connex_override">
		<?= $this->Html->link(__('Save & Exit'), '/campaigns/',['class' => 'pull-left btn btn-cancel exitsave', 'rel' => $last_visited_page]); ?>
		<a id="preview" href="#" class="pull-left btn btn-cancel ">Preview</a>			
	</div>
    <div id="bee-plugin-container"></div>
    <div id="integrator-bottom-bar">
      Select template to load: <input id="choose-template" type="file" />
      Send test e-mail to: <input id="integrator-test-emails" type="text"/>
    </div>

  <script src="/webroot/js/Blob.js"></script>
  <script src="/webroot/js/fileSaver.js"></script>
  <script src="https://eu-bee-resources.s3.amazonaws.com/plugin/BeePlugin.js"></script>

  <script type="text/javascript">

    var request = function(method, url, data, type, callback) {
      var req = new XMLHttpRequest();
      console.log(type);
      req.onreadystatechange = function() {
        if (req.readyState === 4 && req.status === 200) {
          var response = JSON.parse(req.responseText);
          callback(response);
        }
      };

      req.open(method, url, true);
      if (data && type) {
        if(type === 'multipart/form-data') {
          var formData = new FormData();
          for (var key in data) {
            formData.append(key, data[key]);
          }
          data = formData;          
        }
        else {
          req.setRequestHeader('Content-type', type);
        }
      }

      req.send(data);
    };

    var save = function(filename, content) {
      saveAs(
        new Blob([content], {type: 'text/plain;charset=utf-8'}), 
        filename
      ); 
    };

    var specialLinks = [{
        type: 'unsubscribe',
        label: 'SpecialLink.Unsubscribe',
        link: 'http://[unsubscribe]/'
    }, {
        type: 'subscribe',
        label: 'SpecialLink.Subscribe',
        link: 'http://[subscribe]/'
    }];

    var mergeTags = [{
      name: 'tag 1',
      value: '[tag1]'
    }, {
      name: 'tag 2',
      value: '[tag2]'
    }];

    var mergeContents = [{
      name: 'content 1',
      value: '{content1}'
    }, {
      name: 'content 2',
      value: '{content1}'
    }];

    var beeConfig = {
      whitelabel: true,
     // mode: 'full', // 'full|advanced|basic|view',
     //theme: 'classic', //'dark|light|classic',
      showToolbar: true,
      toolbar: ['Save', 'Save As Template', 'Send', 'Preview'],
      
      uid: 'test1-clientside',
      container: 'bee-plugin-container',
      autosave: 15, 
      language: 'en-US',
      specialLinks: specialLinks,
      mergeTags: mergeTags,
      mergeContents: mergeContents,
      onSave: function(jsonFile, htmlFile) { 
	  //  alert (htmlFile);
		request(
			'POST', 
			'<?php echo $this->Url->build([ "controller" => "EmailTemplates","action" => "ajaxSaveEmail",$email_id],true);?>',
	   		  {
	            email: htmlFile,
	            template: jsonFile
	          },
			'multipart/form-data',
			function(retval){
				alert(retval)
			}
		 );
        //save('newsletter.html', htmlFile);
      },
      onSaveAsTemplate: function(jsonFile) { // + thumbnail? 
        save('newsletter-template.json', jsonFile);
      },
      onAutoSave: function(jsonFile) { // + thumbnail? 
        console.log(new Date().toISOString() + ' autosaving...');
        window.localStorage.setItem('newsletter.autosave', jsonFile);
      },
      onSend: function(htmlFile) {
        var emails = document.getElementById('integrator-test-emails').value;
        console.log('sending test email to:', emails);
        request(
          'POST', 
          'https://rsrc.getbee.io/api/messages',
          {
            to: emails,
            subject: 'Test di invio BeePlugin',
            message: htmlFile
          },
          'multipart/form-data');
      },
      onError: function(errorMessage) { 
        console.log('onError ', errorMessage);
      }
    };

    var bee = null;

    var loadTemplate = function(e) {
      var templateFile = e.target.files[0];
      var reader = new FileReader();

      reader.onload = function() {
        var templateString = reader.result;
        var template = JSON.parse(templateString);
        bee.load(template);
      };

      reader.readAsText(templateFile);
    };

    document.getElementById('choose-template').addEventListener('change', loadTemplate, false);

    request(
      'POST', 
      'https://auth.getbee.io/apiauth',
      'grant_type=password&client_id=eZGPgUmwNWOw&client_secret=TrPg5xpTzBBJK4teeWVx0miawf9F3jhoiQ7LIOxSJwvcX6EmlH',
      'application/x-www-form-urlencoded',
      function(token) {
        BeePlugin.create(token, beeConfig, function(beePluginInstance) {
          bee = beePluginInstance;
          request(
            'post', 
            //TEMPLATE TO GET ON LOAD
			'<?php echo $this->Url->build([ "controller" => "EmailTemplates","action" => "ajaxLoadEmail",$email_id],true);?>',
            null,
            null,
            function(template) {
              bee.start(template);
            });
        });
      });
  </script>
  
  
 		  <script type="text/javascript"> 
		    var j$ = jQuery.noConflict();
		
		    j$(document).ready(function() {

			      j$('#use_templates').change(function() {
				      j$('#editorlink').toggle();
				  });


			    j$('#templateselector button').click(function() {
				   templateSelected = j$(this).attr('rel');
				    alert (templateSelected);
		
		          request(
		            'post', 
		            //TEMPLATE TO GET ON LOAD
					'<?php echo $this->Url->build([ "controller" => "EmailTemplates","action" => "ajaxLoadEmail",$email_id],true);?>',
			   		  {
			            data: templateSelected
			          },
		            'multipart/form-data',
		            function(templateSelected) {
		              bee.load(templateSelected);
		            });
				    
			    });
		
			   j$("#preview" ).click(function() {bee.preview()});
			   j$(".exitsave" ).click(function() {
				   bee.save();
					var href = $(this).attr('rel');
			
		             // Delay setting the location for one second
			        setTimeout(function() {window.location = href}, 1000);
			        return false;
				});
		
		        var f=j$("iframe");
		        f.load(function() {
			        //j$(".connex_override" ).hide();
		           // f.contents().find("span.main-logo ").hide();
		        });
		    });        
		</script>


