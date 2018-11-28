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
	            },
			    <?php if(Handler::$_GUEST_REGISTER == 'Yes'){ ?>
	            "Register": function () {            		
                	openRegister();
	            }
			    <?php } ?>
	        },
		    onSave: function(event) {
		    	if(event.xhr['responseText'] == '1'){
		    		w2alert('Login success.');
		    		location.reload();
		    	} else if(event.xhr['responseText'] == '2'){
		    		w2alert('User is not active.');
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

	function openRegister () {
	    if (!w2ui.register_form) {
	        $().w2form({
	            name: 'register_form',
	            style: 'border: 0px; background-color: transparent;',
		        url: '<?php echo BASE_URL; ?>user/register',
	            formHTML: 
	                '<div class="w2ui-page page-0">'+
	                '    <div class="w2ui-field">'+
	                '        <label>Full Name:</label>'+
	                '        <div>'+
	                '           <input name="fullname" type="text" maxlength="100" style="width: 250px"/>'+
	                '        </div>'+
	                '    </div>'+
	                '    <div class="w2ui-field">'+
	                '        <label>Nick Name:</label>'+
	                '        <div>'+
	                '            <input name="nickname" type="text" maxlength="100" style="width: 120px"/>'+
	                '        </div>'+
	                '    </div>'+
	                '    <div class="w2ui-field">'+
	                '        <label>Email:</label>'+
	                '        <div>'+
	                '            <input name="email" type="email" style="width: 150px"/>'+
	                '        </div>'+
	                '    </div>'+
	                '    <div class="w2ui-field">'+
	                '        <label>Password:</label>'+
	                '        <div>'+
	                '            <input name="password" type="password" style="width: 150px"/>'+
	                '        </div>'+
	                '    </div>'+
	                '</div>'+
	                '<div class="w2ui-buttons">'+
	                '    <button class="btn" name="Register">Register</button>'+
	                '</div>',
	            fields: [
	                { field: 'fullname', type: 'text', required: true },
	                { field: 'nickname', type: 'text', required: true },
	                { field: 'email', type: 'email', required: true },
	                { field: 'password', type: 'password', required: true }
	            ],
	            actions: {
	                "Register": function() {  
                		if(this.validate()){
	                		this.save();	                		
	                	}
	                }
	            },
			    onSave: function(event, data) {
			    	if(data.xhr.responseText == "0"){
		    			w2alert('Email already taken');
			    	} else {
				        w2popup.close();
					    showMessage('User succesfully registered. Please contact administrator for activation','success') ;
					    w2ui['task_grid'].reload();
			    	}

			    }
	        });
	    }
	    $().w2popup('open', {
	        title   : 'Register',
	        body    : '<div id="form_register" style="width: 100%; height: 100%;"></div>',
	        style   : 'padding: 15px 0px 0px 0px',
	        width   : 500,
	        height  : 270, 
	        showMax : true,
	        onToggle: function (event) {
	            $(w2ui.register_form.box).hide();
	            event.onComplete = function () {
	                $(w2ui.register_form.box).show();
	                w2ui.register_form.resize();
	            }
	        },
	        onOpen: function (event) {
	            event.onComplete = function () {
	                $('#w2ui-popup #form_register').w2render('register_form');
	            }
	        }
	    });
	}
	</script>

	</body>
</html>