<?php include('header.php'); ?>
	
    <div id="content">

		<div id="task_grid" style="width: 100%; height: 100%;"></div>
		
	</div>

	<?php $FNAME[0] = 'ADD'; $FNAME[1] = 'EDIT'; for($i = 0; $i <= 1; $i++){ ?>
	<div id="FORM_<?php echo $FNAME[$i]; ?>_TASK" style="display:none"></div>
	<?php } ?>

<?php include('footer.php'); ?>

<script type="text/javascript">

	$(function () {
        $('#task_grid').w2grid({ 
	        name: 'task_grid', 
	        url: '<?php echo BASE_URL; ?>task/get_task_list',
	        method: 'POST',
	        recid:'id',
	       	header:'Tasks',
	        show: {
            	lineNumbers    : true,
	        	header: true,
        		toolbar     : true,
			    toolbarColumns  : false,
			    toolbarSearch   : false
	        },
		    onDblClick: function(event) {
		        previewTask(event.recid);
		    },   
		    toolbar: {
		        items: [
		            { type: 'button',  id: 'preview_task',  caption: 'Preview', img: 'icon-preview', hint: 'Preview task' }, 
		            <?php if(Handler::$_IS_ADMIN||Handler::$_IS_MANAGER) echo "{ type: 'button',  id: 'add_task',  caption: 'Add', img: 'icon-add', hint: 'Add new task' },"; ?>
		            <?php if(Handler::$_IS_ADMIN||Handler::$_IS_MANAGER) echo "{ type: 'button',  id: 'edit_task',  caption: 'Edit', img: 'icon-pencil', hint: 'Edit' },"; ?>
		            <?php if(Handler::$_IS_ADMIN||Handler::$_IS_MANAGER) echo " { type: 'button',  id: 'delete_task',  caption: 'Delete', img: 'icon-cancel', hint: 'Delete' }"; ?>
		        ],
		        onClick: function (target, data) {
		        	var selected = w2ui['task_grid'].get(w2ui['task_grid'].getSelection()[0]);
		        	if(target == 'add_task'){
		        		addTask();
		        	}
		        	if(target == 'edit_task'){
		        		if(selected == null){
						    showMessage('Please select a task.','error') ;
		        		} else {
		        			editTask(selected.id);
		        		}
		        	}
		        	if(target == 'delete_task'){
		        		if(selected == null){
						    showMessage('Please select a task.','error') ;
		        		} else {
		        			w2confirm('Are you sure to delete this task?', function (btn) { 
		        				if(btn == 'Yes'){
		        					deleteTask(selected.id);
		        				}
		        			});
		        		}
		        	}
		        	if(target == 'preview_task'){
		        		if(selected == null){
						    showMessage('Please select a task.','error') ;
		        		} else {
		        			previewTask(selected.id);
		        		}
		        	}
		        }
		    },	   
	        columns: [                
	            { field: 'id', caption: 'ID', size: '50px', resizable: true,sortable:true},
	            { field: 'priority', caption: 'Priority', size: '70px', resizable: true,sortable:true,
	                render: function (record, index, column_index) {
	                	if(record.priority == 'High'){
	                		color = 'background-color:red';
	                	} else if(record.priority == 'Medium'){
	                		color = 'background-color:yellow';
	                	} else if(record.priority == 'Low') {
	                		color = 'background-color:LawnGreen';
	                	} else {
	                		color = '';
	                	}
	                    var html = '<div style="'+color+';float:left;width:10px;height:10px;margin:2px;border:1px solid gray"></div><div class="icon-text-wrap">'+ record.priority+'</div>';
	                    return html;
	                }
                },
	            { field: 'name', caption: 'Name', size: '400px', resizable: true,sortable:true,
	                render: function (record, index, column_index) {
	                	if(record.last_comment != ''){
		                    var html = record.name+'<div class="icon-comment" style="width:auto;height:15px;float:right;padding-left:20px"></div><sup style="float:right">'+ record.last_comment+'</sup>';
	                	} else {
		                    var html = record.name;
	                	}
	                    return html;
	                }
	            },
	            { field: 'total_comment',style:'text-align:center', caption: '<div class="icon-comment" style="width:15px;height:15px;"></div>', size: '25px', resizable: true},
	            { field: 'project_name', caption: 'Project Name', size: '250px', resizable: true,sortable:true },
	            { field: 'status_name', caption: 'Status', size: '80px', resizable: true,sortable:true ,
	                render: function (record, index, column_index) {
	                    var html = '<div style=";float:left;width:17px;height:17px;margin:0px 2px 0px 2px;line-height:20px" class="'+record.status_icon+'"></div><div class="icon-text-wrap">'+ record.status_name+'</div>';
	                    return html;
	                }
                },
	            { field: 'progress', caption: 'Progress', size: '80px', resizable: true,sortable:true,
	                render: function (record, index, column_index) {
	                    var html = '<div style="font-weight:bold;text-align:center">'+ record.progress+'</div>';
	                    return html;
	                }
                },
	            { field: 'start_date', caption: 'Start Date', size: '120px', resizable: true,sortable:true },
	            { field: 'end_date', caption: 'End Date', size: '120px', resizable: true,sortable:true },
	            { field: 'assigned_to', caption: 'Member', size: '350px', resizable: true },
	            { field: 'description', caption: 'Description', size: '300px', resizable: true }
	        ]
	    });    

	});
	
	function addTask(){

    	if (!w2ui.new_task_form) {
	        $('#FORM_ADD_TASK').w2form({
	            name: 'new_task_form',
	            style: 'border: 0px; background-color: transparent;',
	            formHTML: $('#FORM_ADD_TASK').html() ,
		        url: '<?php echo BASE_URL; ?>task/go_insert_task',
	            fields: [
	        		{ 
					    name     : 'project_id',      
					    type     : 'list',     
					    options  : {items: <?php echo $_PROJECT_DATA; ?>},    
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px"',       
					        caption : 'Project' 
					    } 
					},
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
					        caption : 'Description',
				        	text 	: ' <button class="btn btn-blue" onClick="openEditorAdd()" style="float:right">Editor</button>'
					    } 
					},
	                { 
					    name     : 'priority',      
					    type     : 'list',       
					    options  : {
					    	items: [{ id: 1, text: 'High' }, { id: 2, text: 'Medium' }, { id: 3, text: 'Low' }, { id: 4, text: 'Other' }]
					    },        				
					    required : true,         
					    html     : {      
					    	attr	: 'style="width:120px"',       
					        caption : 'Priority'
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
					},
	                { 
					    name     : 'assigned',      
					    type     : 'enum',       
					    options  : {
					    	items: <?php echo $_USER_DATA; ?>,
					    	openOnFocus: true
					    },        				
					    required : true,         
					    html     : {      
					    	attr	: 'style="height:30px;width:400px"',       
					        caption : 'Assigned To'
					    } 
					},
	                { 
					    name     : 'start_date',      
					    type     : 'date',       
					    options  : {format: 'd-m-yyyy'},        				
					    required : true,         
					    html     : {            
					        caption : 'Start Date'
					    } 
					},
	                { 
					    name     : 'start_time',      
					    type     : 'time',       
					    options  : {format: 'h24'},        				
					    required : true,         
					    html     : {            
					        caption : 'Start Time'
					    } 
					},
	                { 
					    name     : 'end_date',      
					    type     : 'date',      
					    options  : {format: 'd-m-yyyy'},   			
					    required : true,         
					    html     : {            
					        caption : 'End Date'
					    } 
					},
	                { 
					    name     : 'end_time',      
					    type     : 'time',       
					    options  : {format: 'h24'},        				
					    required : true,         
					    html     : {            
					        caption : 'End Time'
					    } 
					},
	                { 
					    name     : 'progress',      
					    type     : 'int',       
					    options  : {precision: 0, min: 0, max: 100 },        				
					    required : true,         
					    html     : {          
					    	attr	: 'style="width:50px"',      
					        caption : 'Progress',
					        text 	: '%'
					    } 
					}

	            ],
	            record: { 
	                name    		: 'Untitled Task',
	                description   	: '-',
	                priority   	    : 2,
	                start_time   	: '00:00',
	                end_time   	    : '12:00',
	                progress   	    : '0'
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
				    showMessage('Task succesfully submitted.','success') ;
				    w2ui['task_grid'].reload();
			    } 
	        });
        }
	    $().w2popup('open', {
	        title   : 'New Task',
	        body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
	        style   : 'padding: 15px 0px 0px 0px',
	        width   : 600,
	        height  : 680, 
	        modal   : true,
	        showMax : true,
	        img		: 'icon-add',
	        onOpen: function (event) {
	            event.onComplete = function () {
	                $('#w2ui-popup #form').w2render('new_task_form');
	            }
	        }
	    });
	}

	function editTask(id){

		var getUrl = '<?php echo BASE_URL; ?>task/get_task/'+id;
		var saveUrl = '<?php echo BASE_URL; ?>task/go_edit_task/'+id;

    	if (!w2ui.edit_task_form) {
	        $('#FORM_EDIT_TASK').w2form({
	            name: 'edit_task_form',
	            style: 'border: 0px; background-color: transparent;',
	            formHTML: $('#FORM_EDIT_TASK').html() ,
	            recid    : 1,
			    url      : {
			        get  : getUrl,
			        save  : saveUrl
			    },
	            fields: [
	        		{ 
					    name     : 'id',      
					    type     : 'text',     
					    options  : {},    
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px" readonly',       
					        caption : 'Task ID' 
					    } 
					},
	        		{ 
					    name     : 'project_id',      
					    type     : 'list',     
					    options  : {items: <?php echo $_PROJECT_DATA; ?>},    
					    required : true,         
					    html     : {      
					    	attr	: 'style="font-size:14px;width:250px"',       
					        caption : 'Project' 
					    } 
					},
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
					        caption : 'Description',
				        	text 	: ' <button class="btn btn-blue" onClick="openEditorEdit()" style="float:right">Editor</button>'
					    } 
					},
	                { 
					    name     : 'priority',      
					    type     : 'list',       
					    options  : {
					    	items: [{ id: 'High', text: 'High' }, { id: 'Medium', text: 'Medium' }, { id: 'Low', text: 'Low' }, { id: 'Other', text: 'Other' }]
					    },        				
					    required : true,         
					    html     : {      
					    	attr	: 'style="width:120px"',       
					        caption : 'Priority'
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
					},
	                { 
					    name     : 'assigned',      
					    type     : 'enum',       
					    options  : {
					    	items: <?php echo $_USER_DATA; ?>,
					    	openOnFocus: true
					    },        				
					    required : true,         
					    html     : {      
					    	attr	: 'style="height:30px;width:400px"',       
					        caption : 'Assigned To'
					    } 
					},
	                { 
					    name     : 'start_date',      
					    type     : 'date',       
					    options  : {format: 'd-m-yyyy'},        				
					    required : true,         
					    html     : {            
					        caption : 'Start Date'
					    } 
					},
	                { 
					    name     : 'start_time',      
					    type     : 'time',       
					    options  : {format: 'h24'},        				
					    required : true,         
					    html     : {            
					        caption : 'Start Time'
					    } 
					},
	                { 
					    name     : 'end_date',      
					    type     : 'date',      
					    options  : {format: 'd-m-yyyy'},   			
					    required : true,         
					    html     : {            
					        caption : 'End Date'
					    } 
					},
	                { 
					    name     : 'end_time',      
					    type     : 'time',       
					    options  : {format: 'h24'},        				
					    required : true,         
					    html     : {            
					        caption : 'End Time'
					    } 
					},
	                { 
					    name     : 'progress',      
					    type     : 'int',       
					    options  : {precision: 0, min: 0, max: 100 },        				
					    required : true,         
					    html     : {          
					    	attr	: 'style="width:50px"',      
					        caption : 'Progress',
					        text 	: '%'
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
				    showMessage('Task succesfully submitted.','success') ;
				    w2ui['task_grid'].reload();
			    } 
	        });
        }
	    $().w2popup('open', {
	        title   : 'Edit Task',
	        body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
	        style   : 'padding: 15px 0px 0px 0px',
	        width   : 600,
	        height  : 680, 
	        modal   : true,
	        showMax : true,
	        img		: 'icon-add', 
	        onClose : function (event) {
		        w2ui.edit_task_form.destroy();
		    },
	        onOpen: function (event) {
	            event.onComplete = function () {
	                $('#w2ui-popup #form').w2render('edit_task_form');
	            }
	        }
	    });
	}

	function deleteTask(id){
		$.ajax({
	        url: '<?php echo BASE_URL; ?>task/delete_task',
	        type: 'POST',
	        data: { 
	          id : id
	        },
	        }).success(function(data){
			    showMessage('Task succesfully deleted.','success') ;
			    w2ui['task_grid'].reload();
	    });
	}

	function previewTask(id){
		openInSameTab('<?php echo BASE_URL; ?>task/preview/'+id);
	}

	function openEditorEdit(){
		
		options = {
		    msg          : '<textarea class="editor-area" style="width:96%; height: 96%"></textarea>',
		    title        : w2utils.lang('Confirmation'),
		    width        : 550,       // width of the dialog
		    height       : 520,       // height of the dialog
		    yes_text     : 'Close',     // text for yes button
		    yes_class    : '',        // class for yes button
		    yes_style    : '',        // style for yes button
		    yes_callBack : null,      // callBack for yes button
		    no_text      : 'Discard',      // text for no button
		    no_class     : '',        // class for no button
		    no_style     : 'display:none',        // style for no button
		    no_callBack  : null       
		}
		w2confirm(options);

	    $(".editor-area").val(w2ui['edit_task_form'].record['description']); 
	    $(".editor-area").jqte({
	        "mywidth":"100%",
	        "myheight":"370px",
	        blur: function(ss,ccs){ 
	    	var description = $('.editor-area').val();
	    	w2ui['edit_task_form'].record['description'] = description;
			w2ui['edit_task_form'].refresh();
	    }});
	}

	function openEditorAdd(){
		
		options = {
		    msg          : '<textarea class="editor-area-add" style="width:96%; height: 96%"></textarea>',
		    title        : w2utils.lang('Confirmation'),
		    width        : 550,       // width of the dialog
		    height       : 520,       // height of the dialog
		    yes_text     : 'Close',     // text for yes button
		    yes_class    : '',        // class for yes button
		    yes_style    : '',        // style for yes button
		    yes_callBack : null,      // callBack for yes button
		    no_text      : 'Discard',      // text for no button
		    no_class     : '',        // class for no button
		    no_style     : 'display:none',        // style for no button
		    no_callBack  : null       
		}
		w2confirm(options);

	    $(".editor-area-add").jqte({
	        "mywidth":"100%",
	        "myheight":"370px",
	        blur: function(ss,ccs){ 
	    	var description = $('.editor-area-add').val();
	    	w2ui['new_task_form'].record['description'] = description;
			w2ui['new_task_form'].refresh();
	    }});
	}

</script>