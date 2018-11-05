<?php include('header.php'); ?>
	
    <div id="content">
	 	<?php if(Handler::$_IS_ADMIN){  ?>
		<div id="user_grid" style="width: 100%; height: 100%;"></div>
	 	<?php } else { echo '<div style="padding:10px">Not authorized.</div>'; }  ?>
	</div>

	<?php $FNAME[0] = 'ADD'; $FNAME[1] = 'EDIT'; for($i = 0; $i <= 1; $i++){ ?>
	<div id="FORM_<?php echo $FNAME[$i]; ?>_USER" style="display:none"></div>
	<?php } ?>

<?php include('footer.php'); ?>

<script type="text/javascript">

	$(function () {
        $('#user_grid').w2grid({ 
	        name: 'user_grid', 
	        url: '<?php echo BASE_URL; ?>user/get_user_list',
	        method: 'POST',
	        recid:'id',
	       	header:'Users',
        	multiSelect: false, 
	        show: {
            	lineNumbers    : true,
	        	header: true,
        		toolbar     : true,
			    toolbarColumns  : false,
			    toolbarSearch   : false
	        },   
		    toolbar: {
		        items: [
		            { type: 'button',  id: 'add_user',  caption: 'Add', img: 'icon-add', hint: 'Add new user' },
		            { type: 'button',  id: 'edit_user',  caption: 'Edit', img: 'icon-pencil', hint: 'Edit' },
		            { type: 'button',  id: 'delete_user',  caption: 'Delete', img: 'icon-cancel', hint: 'Delete' }
		        ],
		        onClick: function (target, data) {
		        	var selected = w2ui['user_grid'].get(w2ui['user_grid'].getSelection()[0]);
		        	if(target == 'add_user'){
		        		addUser();
		        	}
		        	if(target == 'edit_user'){
		        		if(selected == null){
						    showMessage('Please select a user.','error') ;
		        		} else {
		        			editUser(selected.id);
		        		}
		        	}
		        	if(target == 'delete_user'){
		        		if(selected == null){
						    showMessage('Please select a user.','error') ;
		        		} else {
		        			w2confirm('Are you sure to delete this user?', function (btn) { 
		        				if(btn == 'Yes'){
		        					deleteUser(selected.id);
		        				}
		        			});
		        		}
		        	}
		        }
		    },	   
	        columns: [                
	            { field: 'id', caption: 'ID', size: '50px', resizable: true, sortable:true},
	            { field: 'fullname', caption: 'Full Name', size: '300px', resizable: true,sortable:true },
	            { field: 'nickname', caption: 'Nickname', size: '150px', resizable: true,sortable:true },
	            { field: 'email',style:'text-align:center', caption: 'Email', size: '250px', resizable: true} ,
	            { field: 'password',style:'text-align:center', caption: 'Password', size: '180px', resizable: true} ,
	            { field: 'usergroup_name', caption: 'User Group', size: '150px', resizable: true,sortable:true ,
	                render: function (record, index, column_index) {
	                    var html = '<div style=";float:left;width:17px;height:17px;margin:0px 2px 0px 2px;line-height:20px" class="'+record.usergroup_icon+'"></div><div class="icon-text-wrap">'+ record.usergroup_name+'</div>';
	                    return html;
	                }
                }
	        ]
	    });    

	});
		
	function addUser(){

    	if (!w2ui.new_user_form) {
	        $('#FORM_ADD_PROJECT').w2form({
	            name: 'new_user_form',
	            style: 'border: 0px; background-color: transparent;',
	            formHTML: $('#FORM_ADD_PROJECT').html() ,
		        url: '<?php echo BASE_URL; ?>user/go_insert_user',
	            fields: [
	        		{ 
					    name     : 'fullname',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px"',       
					        caption : 'Full Name' 
					    } 
					},
	        		{ 
					    name     : 'nickname',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:160px"',       
					        caption : 'Nick Name' 
					    } 
					},
	        		{ 
					    name     : 'email',      
					    type     : 'email',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:150px"',       
					        caption : 'Email'
					    } 
					},
	        		{ 
					    name     : 'phone',      
					    type     : 'text',       
					    options  : {},        
					    html     : {      
					    	attr	: 'style="font-size:14px;width:140px"',       
					        caption : 'Phone' 
					    } 
					},
	        		{ 
					    name     : 'address',      
					    type     : 'textarea',       
					    options  : {},          
					    html     : {      
					    	attr	: 'style="font-size:14px;width:280px;height:80px"',       
					        caption : 'Address',
					    	value	:'-'   
					    } 
					},
	        		{ 
					    name     : 'password',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:180px"',       
					        caption : 'Password'  
					    } 
					},
	                { 
					    name     : 'status',      
					    type     : 'list',       
					    options  : {
					    	items: [{ id: 'Active', text: 'Active' }, { id: 'Nonactive', text: 'Non Active' }]
					    },        				
					    required : true,         
					    html     : {      
					    	attr	: 'style="width:120px"',       
					        caption : 'Status'
					    } 
					},
	                { 
					    name     : 'usergroup_id',      
					    type     : 'list',       
					    options  : {items: <?php echo $_USERGROUP_DATA; ?>},  	
					    required : true,         
					    html     : {      
					    	attr	: 'style="width:150px"',       
					        caption : 'Group'
					    } 
					}
	            ],
	            record: {
	            	status: 1
	            },
	            actions: {
	                "Save": function () { 
                		if(this.validate()){
	                		this.save();	                		
	                	}
	                },
	                "Reset": function () { this.clear(); },
	            },
			    onSave: function(event) {
			        w2popup.close();
				    showMessage('Project succesfully submitted.','success') ;
				    w2ui['user_grid'].reload();
			    } 
	        });
        }
	    $().w2popup('open', {
	        title   : 'New User',
	        body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
	        style   : 'padding: 15px 0px 0px 0px',
	        width   : 500,
	        height  : 480, 
	        modal     : true,
	        showMax : false,img: 'icon-add',
	        onToggle: function (event) {
	            $(w2ui.new_user_form.box).hide();
	            event.onComplete = function () {
	                $(w2ui.new_user_form.box).show();
	                w2ui.new_user_form.resize();
	            }
	        },
	        onOpen: function (event) {
	            event.onComplete = function () {
	                $('#w2ui-popup #form').w2render('new_user_form');
	            }
	        }
	    });
	}

	function editUser(id){
		var getUrl = '<?php echo BASE_URL; ?>user/get_user/'+id;
		var saveUrl = '<?php echo BASE_URL; ?>user/go_edit_user/'+id;
    	if (!w2ui.edit_user_form) {
	        $('#FORM_EDIT_PROJECT').w2form({
	            name: 'edit_user_form',
	            style: 'border: 0px; background-color: transparent;',
	            formHTML: $('#FORM_EDIT_PROJECT').html() ,
	            recid    : 1,
			    url      : {
			        get  : getUrl,
			        save  : saveUrl
			    },
	            fields: [
	        		{ 
					    name     : 'id',      
					    type     : 'text',   
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px" readonly',     
					        caption : 'ID' 
					    } 
					},
	        		{ 
					    name     : 'fullname',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px"',       
					        caption : 'Full Name' 
					    } 
					},
	        		{ 
					    name     : 'nickname',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:160px"',       
					        caption : 'Nick Name' 
					    } 
					},
	        		{ 
					    name     : 'email',      
					    type     : 'email',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:150px"',       
					        caption : 'Email'
					    } 
					},
	        		{ 
					    name     : 'phone',      
					    type     : 'text',       
					    options  : {},          
					    html     : {      
					    	attr	: 'style="font-size:14px;width:140px"',       
					        caption : 'Phone' 
					    } 
					},
	        		{ 
					    name     : 'address',      
					    type     : 'textarea',       
					    options  : {},         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:280px;height:80px"',       
					        caption : 'Address',
					    	value	:'-'   
					    } 
					},
	        		{ 
					    name     : 'password',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:180px"',       
					        caption : 'Password'  
					    } 
					},
	                { 
					    name     : 'status',      
					    type     : 'list',       
					    options  : {
					    	items: [{ id: 'Active', text: 'Active' }, { id: 'Nonactive', text: 'Non Active' }]
					    },        				
					    required : true,         
					    html     : {      
					    	attr	: 'style="width:120px"',       
					        caption : 'Status'
					    } 
					},
	                { 
					    name     : 'usergroup_id',      
					    type     : 'list',       
					    options  : {items: <?php echo $_USERGROUP_DATA; ?>},  	
					    required : true,         
					    html     : {      
					    	attr	: 'style="width:150px"',       
					        caption : 'Group'
					    } 
					}
	            ],
	            actions: {
	                "Save": function () { 
	                	if(this.validate()){
	                		this.save();	                		
	                	}
	                },
	                "Reset": function () { this.clear(); },
	            },
			    onSave: function(event) {
			        w2popup.close();
				    showMessage('User succesfully updated.','success') ;
				    w2ui['user_grid'].reload();
			    } 
	        });
        }
	    $().w2popup('open', {
	        title   : 'Edit User',
	        body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
	        style   : 'padding: 15px 0px 0px 0px',
	        width   : 500,
	        height  : 500, 
	        showMax : false, 
	        modal     : true,
	        onClose : function (event) {
		        w2ui.edit_user_form.destroy();
		    },
	        onOpen: function (event) {
	            event.onComplete = function () {
	                $('#w2ui-popup #form').w2render('edit_user_form');
	            }
	        }
	    });

	}

	function deleteUser(id){
		$.ajax({
	        url: '<?php echo BASE_URL; ?>user/delete_user',
	        type: 'POST',
	        data: { 
	          id : id
	        },
	        }).success(function(data){
			    showMessage('User succesfully deleted.','success') ;
			    w2ui['user_grid'].reload();
	    });
	}

</script>