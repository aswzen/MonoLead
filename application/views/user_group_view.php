<?php include('header.php'); ?>
	
    <div id="content">
	 	<?php if(Handler::$_IS_ADMIN){  ?>
		<div id="user_group_grid" style="width: 100%; height: 100%;"></div>
	 	<?php } else { echo '<div style="padding:10px">Not authorized.</div>'; }  ?>
	</div>

	<?php $FNAME[0] = 'ADD'; $FNAME[1] = 'EDIT'; for($i = 0; $i <= 1; $i++){ ?>
	<div id="FORM_<?php echo $FNAME[$i]; ?>_USER" style="display:none"></div>
	<?php } ?>

<?php include('footer.php'); ?>
<script type="text/javascript" src="<?php echo STATIC_DIR; ?>js/jquery.ajaxfileupload.js"></script>
<script type="text/javascript">

	$(function () {
        $('#user_group_grid').w2grid({ 
	        name: 'user_group_grid', 
	        url: '<?php echo BASE_URL; ?>usergroup/get_user_group_list',
	        method: 'POST',
	        recid:'id',
	       	header:'User Groups',
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
		            { type: 'button',  id: 'add_user_group',  caption: 'Add', img: 'icon-add', hint: 'Add new user group' },
		            { type: 'button',  id: 'edit_user_group',  caption: 'Edit', img: 'icon-pencil', hint: 'Edit' },
		            { type: 'button',  id: 'delete_user_group',  caption: 'Delete', img: 'icon-cancel', hint: 'Delete' }
		        ],
		        onClick: function (target, data) {
		        	var selected = w2ui['user_group_grid'].get(w2ui['user_group_grid'].getSelection()[0]);
		        	if(target == 'add_user_group'){
		        		addUserGroup();
		        	}
		        	if(target == 'edit_user_group'){
		        		if(selected == null){
						    showMessage('Please select an user group.','error') ;
		        		} else {
		        			editUserGroup(selected.id);
		        		}
		        	}
		        	if(target == 'delete_user_group'){
		        		if(selected == null){
						    showMessage('Please select an user group.','error') ;
		        		} else {
		        			w2confirm('Are you sure to delete this user group?', function (btn) { 
		        				if(btn == 'Yes'){
		        					deleteUserGroup(selected.id);
		        				}
		        			});
		        		}
		        	}
		        }
		    },	   
	        columns: [                
	            { field: 'id', caption: 'ID', size: '30px', resizable: true, sortable:true},
	            { field: 'groupcode', caption: 'Group Code', size: '80px', resizable: true,sortable:true },
	            { field: 'usergroup', caption: 'Name', size: '300px', resizable: true,sortable:true },
	            { field: 'badge',style:'text-align:center', caption: 'Badge', size: '150px', resizable: true} ,
	            { field: 'icon', style:'text-align:center',caption: '', size: '25px', resizable: true,sortable:true ,
	                render: function (record, index, column_index) {
	                    var html = '<div style=";float:left;width:17px;height:17px;margin:0px 2px 0px 2px;line-height:20px" class="'+record.icon+'"></div>';
	                    return html;
	                }
                }
	        ]
	    });    

	});
		
	function addUserGroup(){

    	if (!w2ui.new_user_group_form) {
	        $('#FORM_ADD_PROJECT').w2form({
	            name: 'new_user_group_form',
	            style: 'border: 0px; background-color: transparent;',
	            formHTML: $('#FORM_ADD_PROJECT').html() ,
		        url: '<?php echo BASE_URL; ?>usergroup/go_insert_user_group',
	            fields: [
	        		{ 
					    name     : 'groupcode',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:100px"',       
					        caption : 'Code' 
					    } 
					},
	        		{ 
					    name     : 'usergroup',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px"',       
					        caption : 'Name' 
					    } 
					},
	        		{ 
					    name     : 'badge',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:120px"',
					        caption : 'Badge' 
					    } 
					},
	        		{ 
					    name     : 'icon',      
					    type     : 'file',       
					    options  : {
					    	max  	 : 1,
						    onAdd: (event) => {
								var name = event.file.name;
								if(name.endsWith(".jpg") || name.endsWith(".bmp") || name.endsWith(".png") || name.endsWith(".gif") ){} else {
									alert('File type should be jpg,bmp,png or gif');
									event.preventDefault()
								}
							}
					    },     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px"',   
					        caption : 'Icon' 
					    },
					},
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
				    showMessage('User group succesfully submitted.','success') ;
				    w2ui['user_group_grid'].reload();
			    } 
	        });
        }
	    $().w2popup('open', {
	        title   : 'New User Group',
	        body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
	        style   : 'padding: 15px 0px 0px 0px',
	        width   : 500,
	        height  : 280, 
	        modal     : true,
	        showMax : false,img: 'icon-add',
	        onToggle: function (event) {
	            $(w2ui.new_user_group_form.box).hide();
	            event.onComplete = function () {
	                $(w2ui.new_user_group_form.box).show();
	                w2ui.new_user_group_form.resize();
	            }
	        },
	        onOpen: function (event) {
	            event.onComplete = function () {
	                $('#w2ui-popup #form').w2render('new_user_group_form');
	            }
	        }
	    });
	}

	function editUserGroup(id){
		var getUrl = '<?php echo BASE_URL; ?>usergroup/get_user_group/'+id;
		var saveUrl = '<?php echo BASE_URL; ?>usergroup/go_edit_user_group/'+id;
    	if (!w2ui.edit_user_group_form) {
	        $('#FORM_EDIT_PROJECT').w2form({
	            name: 'edit_user_group_form',
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
					    name     : 'groupcode',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:100px"',       
					        caption : 'Code' 
					    } 
					},
	        		{ 
					    name     : 'usergroup',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px"',       
					        caption : 'Name' 
					    } 
					},
	        		{ 
					    name     : 'badge',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:120px"',       
					        caption : 'Badge' 
					    } 
					},
					{ 
					    name     : 'icon',      
					    type     : 'file',       
					    options  : {
					    	max  	 : 1,
						    onAdd: (event) => {
								var name = event.file.name;
								if(name.endsWith(".jpg") || name.endsWith(".bmp") || name.endsWith(".png") || name.endsWith(".gif") ){} else {
									alert('File type should be jpg,bmp,png or gif');
									event.preventDefault()
								}
							}
					    },         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px"',   
					        caption : 'Icon: (leave it<br> blank to ignore)<br>' 
					    },
					},
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
				    showMessage('User group succesfully updated.','success') ;
				    w2ui['user_group_grid'].reload();
			    } 
	        });
        }
	    $().w2popup('open', {
	        title   : 'Edit User Group',
	        body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
	        style   : 'padding: 15px 0px 0px 0px',
	        width   : 500,
	        height  : 500, 
	        showMax : false, 
	        modal     : true,
	        onClose : function (event) {
		        w2ui.edit_user_group_form.destroy();
		    },
	        onOpen: function (event) {
	            event.onComplete = function () {
	                $('#w2ui-popup #form').w2render('edit_user_group_form');
	            }
	        }
	    });

	}

	function deleteUserGroup(id){
		$.ajax({
	        url: '<?php echo BASE_URL; ?>usergroup/delete_user_group',
	        type: 'POST',
	        data: { 
	          id : id
	        },
	        }).success(function(data){
			    showMessage('User group succesfully deleted.','success') ;
			    w2ui['user_group_grid'].reload();
	    });
	}

</script>