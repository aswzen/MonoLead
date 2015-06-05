<?php include('header.php'); ?>
	
    	<div id="content">
    		<div class="centered">
			    <div id="login_form" style="width: 400px"></div>
			</div>
    	</div>

	
    	<div id="footer" ><center>MonoLead <?php echo version;?></center></div>
    </div>

	<script type="text/javascript">
	$(function () {

	    var pstyle = 'border: 1px solid #dfdfdf; padding: 5px;';
	    var frontstyle = 'background:  url("<?php echo STATIC_DIR; ?>/images/bgone.png") white;';

	    $('#layout').w2layout({
	        name: 'layout',
	        panels: [
	            { type: 'top', size: 40, style: pstyle, content: $('#header').html() },
	            { type: 'main',style: frontstyle, content: $('#content').html()  },
	            { type: 'bottom', size: 30, style: pstyle, content: $('#footer').html()  }
	        ]
	    });

	    $('#login_form').w2form({ 
	        name   	: 'login_form',
	        url 	: '<?php echo BASE_URL; ?>user/login',
	        method	: 'POST',
	       	header	: 'Login',
	       	msgSaving: 'Submitting...',
	        fields 	: [
	            { 
				    name     : 'username',      
				    type     : 'text',       
				    options  : {},          
				    required : true,         
				    html     : {      
				    	attr	: 'style="font-size:14px;width:220px"',       
				        caption : 'Email'
				    } 
			    },
	            { 
				    name     : 'password',      
				    type     : 'password',       
				    options  : {},          
				    required : true,         
				    html     : {      
				    	attr	: 'style="font-size:14px;width:220px"',       
				        caption : 'Password'
				    } 
			    }
	        ],
	        actions: {
	            "Submit": function () {            		
                	if(this.validate()){
                		this.save();
                	}
	            }
	        },
		    onSave: function(event) {
		    	if(event.xhr['responseText'] == '1'){
		    		w2alert('Login success.');
		    		location.reload();
		    	} else {
		    		w2alert('Wrong username or password.');
		    	}
		    } 
	    });
		
		$(document).keypress(function(e) {
		    if(e.which == 13) {
		    	w2popup.close();
		       	w2ui['login_form'].submit();
		    }
		});
	});
	</script>

	</body>
</html>