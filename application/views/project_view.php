<?php include('header.php'); ?>
	
    <div id="content">
		<div id="project_grid" style="width: 100%; height: 100%;"></div>
		
	</div>

	<?php $FNAME[0] = 'ADD'; $FNAME[1] = 'EDIT'; for($i = 0; $i <= 1; $i++){ ?>
	<div id="FORM_<?php echo $FNAME[$i]; ?>_PROJECT" style="display:none"></div>
	<?php } ?>

<?php include('footer.php'); ?>

<script type="text/javascript">

	$(function () {
        $('#project_grid').w2grid({ 
	        name: 'project_grid', 
	        url: '<?php echo BASE_URL; ?>project/get_project_list',
	        method: 'POST',
	        recid:'id',
	       	header:'Projects',
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
		            { type: 'button',  id: 'add_project',  caption: 'Add', img: 'icon-add', hint: 'Add new project' },
		            { type: 'button',  id: 'edit_project',  caption: 'Edit', img: 'icon-pencil', hint: 'Edit' },
		            { type: 'button',  id: 'delete_project',  caption: 'Delete', img: 'icon-cancel', hint: 'Delete' }
		        ],
		        onClick: function (target, data) {
		        	var selected = w2ui['project_grid'].get(w2ui['project_grid'].getSelection()[0]);
		        	if(target == 'add_project'){
		        		addProject();
		        	}
		        	if(target == 'edit_project'){
		        		if(selected == null){
						    showMessage('Please select a project.','error') ;
		        		} else {
		        			editProject(selected.id);
		        		}
		        	}
		        	if(target == 'delete_project'){
		        		if(selected == null){
						    showMessage('Please select a project.','error') ;
		        		} else {
		        			w2confirm('Are you sure to delete this project?', function (btn) { 
		        				if(btn == 'Yes'){
		        					deleteProject(selected.id);
		        				}
		        			});
		        		}
		        	}
		        }
		    },	   
	        columns: [                
	            { field: 'id', caption: 'ID', size: '50px', resizable: true, sortable:true},
	            { field: 'name', caption: 'Name', size: '300px', resizable: true,sortable:true },
	            { field: 'description', caption: 'Description', size: '30%', resizable: true,sortable:true },
	            { field: 'total_task',style:'text-align:center', caption: 'Tasks', size: '50px', resizable: true} ,
	            { field: 'status_name', caption: 'Status', size: '100px', resizable: true,sortable:true ,
	                render: function (record, index, column_index) {
	                    var html = '<div style=";float:left;width:17px;height:17px;margin:0px 2px 0px 2px;line-height:20px" class="'+record.status_icon+'"></div><div class="icon-text-wrap">'+ record.status_name+'</div>';
	                    return html;
	                }
                }
	        ]
	    });    

	});
		
	function addProject(){

    	if (!w2ui.new_project_form) {
	        $('#FORM_ADD_PROJECT').w2form({
	            name: 'new_project_form',
	            style: 'border: 0px; background-color: transparent;',
	            formHTML: $('#FORM_ADD_PROJECT').html() ,
		        url: '<?php echo BASE_URL; ?>project/go_insert_project',
	            fields: [
	        		{ 
					    name     : 'name',      
					    type     : 'text',       
					    options  : {},     
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:320px"',       
					        caption : 'Name',
					    	value	:'Untitled'   
					    } 
					},
	                { 
					    name     : 'description',      
					    type     : 'textarea',       
					    options  : {},          
					    required : true,         
					    html     : {      
					    	attr	: 'style="height:80px;width:320px"',       
					        caption : 'Description'
					    } 
					},
	                { 
					    name     : 'status_id',      
					    type     : 'list',       
					    options  : {items: <?php echo $_STATUS_DATA; ?>},          
					    required : true,         
					    html     : {             
					        caption : 'Status'
					    } 
					}

	            ],
	            record: { 
	                name    		: 'Untitled Project',
	                description   	: '-'
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
				    w2ui['project_grid'].reload();
			    } 
	        });
        }
	    $().w2popup('open', {
	        title   : 'New Project',
	        body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
	        style   : 'padding: 15px 0px 0px 0px',
	        width   : 500,
	        height  : 300, 
	        modal     : true,
	        showMax : false,img: 'icon-add',
	        onToggle: function (event) {
	            $(w2ui.new_project_form.box).hide();
	            event.onComplete = function () {
	                $(w2ui.new_project_form.box).show();
	                w2ui.new_project_form.resize();
	            }
	        },
	        onOpen: function (event) {
	            event.onComplete = function () {
	                $('#w2ui-popup #form').w2render('new_project_form');
	            }
	        }
	    });
	}

	function editProject(id){
		var getUrl = '<?php echo BASE_URL; ?>project/get_project/'+id;
		var saveUrl = '<?php echo BASE_URL; ?>project/go_edit_project/'+id;
    	if (!w2ui.edit_project_form) {
	        $('#FORM_EDIT_PROJECT').w2form({
	            name: 'edit_project_form',
	            style: 'border: 0px; background-color: transparent;',
	            formHTML: $('#FORM_EDIT_PROJECT').html() ,
	            recid    : 1,
			    url      : {
			        get  : getUrl,
			        save  : saveUrl
			    },
	            fields: [
	        		{ 
					    name     : 'name',      
					    type     : 'text',       
					    options  : {},          
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:320px"',       
					        caption : 'Name'
					    } 
					},
	                { 
					    name     : 'description',      
					    type     : 'textarea',       
					    options  : {},          
					    required : true,         
					    html     : {      
					    	attr	: 'style="height:80px;width:320px"',       
					        caption : 'Description'
					    } 
					},
	                { 
					    name     : 'status_id',      
					    type     : 'list',       
					    options  : {items: <?php echo $_STATUS_DATA; ?>},          
					    required : true,         
					    html     : {             
					        caption : 'Status'
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
				    showMessage('Project succesfully updated.','success') ;
				    w2ui['project_grid'].reload();
			    } 
	        });
        }
	    $().w2popup('open', {
	        title   : 'Edit Project',
	        body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
	        style   : 'padding: 15px 0px 0px 0px',
	        width   : 500,
	        height  : 300, 
	        showMax : false, 
	        modal     : true,
	        onClose : function (event) {
		        w2ui.edit_project_form.destroy();
		    },
	        onOpen: function (event) {
	            event.onComplete = function () {
	                $('#w2ui-popup #form').w2render('edit_project_form');
	            }
	        }
	    });

	}

	function deleteProject(id){
		$.ajax({
	        url: '<?php echo BASE_URL; ?>project/delete_project',
	        type: 'POST',
	        data: { 
	          id : id
	        },
	        }).success(function(data){
			    showMessage('Project succesfully deleted.','success') ;
			    w2ui['project_grid'].reload();
	    });
	}

</script>