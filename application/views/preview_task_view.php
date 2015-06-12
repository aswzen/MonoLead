<?php 
	if($_AJAX != true){
		include('header.php'); 
		echo '<div id="content">';
	}
?>

	<div id="layout_preview_task" style="width: 100%; height: 100%;"></div>
	<div id="task_head" style="display:none">
		<div class="icon-stask" style="width:20px;height:20px;float:left"></div>
		<div style="width:auto;float:left;font-size:18px;padding-left:5px">
			<span class="ticket-lbl"><b>#<?php echo $_TASK_DATA['id']; ?></b></span> - <b><?php echo $_TASK_DATA['name']; ?></b>
		</div>
		<div class="<?php echo $_TASK_DATA->status['icon']; ?>" style="width:20px;height:20px;float:right"></div>
		<div class="label2" style="float:right;padding-right:2px;text-align:right">
			<?php echo $_TASK_DATA->status['name']; ?>
		</div>

		<div style="clear:both;padding-top:10px">
			<table>
				<tr>
					<td>Project</td>
					<td>:</td>
					<td colspan="5">
						<b>#<?php echo $_TASK_DATA->project['id']; ?> - <?php echo $_TASK_DATA->project['name']; ?></b>
					</td>
				</tr>
				<tr>
					<td>Priority</td>
					<td>:</td>
					<td>
						<div style="float:left"><?php echo $_TASK_DATA['priority']; ?></div> 
					</td>
					<td style="width:10px"></td>
					<td>Start Date</td>
					<td>:</td>
					<td>
						<span class="label label-warning"><?php echo date(Handler::$_DF,strtotime($_TASK_DATA['start_date'])); ?></span>
					</td>
				</tr>
				<tr>
					<td>Progress</td>
					<td>:</td>
					<td>
						<div class="progress-box" style="width:200px;overflow:hidden">
							<div class="progress-fill" style="width:<?php echo $_TASK_DATA['progress']*2; ?>px;background-color:hsl(<?php echo $_TASK_DATA['progress']; ?>, 100%, 50%)"></div>
						</div>
						<div style="float:left"><?php echo $_TASK_DATA['progress']; ?>%</div> 
					</td>
					<td style="width:10px"></td>
					<td>End Date</td>
					<td>:</td>
					<td>
						<span class="label label-primary"><?php echo date(Handler::$_DF,strtotime($_TASK_DATA['end_date'])); ?></span>
					</td>
					<td style="width:10px"></td>
					<td>Assigned By</td>
					<td>:</td>
					<td>
						<?php echo $_TASK_DATA->user['fullname']; ?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div id="task_member" style="display:none">
		<?php 
			$allowAdd = array(); 
			foreach ($_TASKER_DATA as $key => $value) {
				array_push($allowAdd, $value->user['id']);
				echo '<div class="icon-user user-project n-button" onClick="userPreview(\''.$value->user['id'].'\')" >'.$value->user['fullname'].'</div>';
			}
		?>
	</div>
	<div id="task_desc" style="display:none">
		<div id="desc_area"><?php echo $_TASK_DATA['description']; ?></div>
	</div>
	<div id="task_activity" style="display:none">
		<table style="width:100%">
		<?php foreach ($_ACT_DATA as $key => $value) { ?>
			<tr>
				<td style="vertical-align:top;width:55px">
					<div style="width:50px;height:50px;float:left;border:1px solid #DFDFDF">
						<img src="<?php echo STATIC_DIR.$value->user['profile_pic_url']; ?>" style="width:100%;height:100%">
					</div>
				</td>
				<td  class="activity-td">
					<div style="border:1px solid #DFDFDF;float:left;width:100%">

						<table style="width:100%">
							<tr>
								<td style="height:20px">
									<div class="margined label label-default" style="float:left" >
										#<?php echo $value['id']; ?>
									</div>
									<div class="icon-user user-project" style="float:left" >
										<?php echo $value->user['fullname']; ?>
										<?php if($value['user_id'] == Handler::$_LOGIN_USER_ID){ ?>
											<a href="#" onClick="editActivity('<?php echo $value['id']; ?>')">[Edit]</a> <a href="#" onClick="deleteActivity('<?php echo $value['id']; ?>')">[Delete]</a>
										<?php } ?>
									</div>
								</td>
								<td rowspan="2" style="width:165px;vertical-align:top">

									<table>
										<tr>
											<td><div class="icon-date icon-enabled" style="float:left;margin:0px"><?php echo date(Handler::$_DF,strtotime($value['input_date'])); ?></div></td>
										</tr>
										<tr>
											<td><div class="<?php echo $value->status['icon']; ?> icon-enabled" style="float:left;margin:0px"><?php echo $value->status['name']; ?></div></td>
										</tr>
										<tr>
											<td>
												<div class="icon-progress icon-enabled" style="float:left;margin:0px">
													<div class="progress-box" style="width:100px;overflow:hidden">
														<div class="progress-fill" style="width:<?php echo $value['progress']; ?>px;background-color:hsl(<?php echo $value['progress']; ?>, 100%, 50%);"></div>
													</div>
													<div style="float:left"><?php echo $value['progress']; ?>%</div> 
												</div>
											</td>
										</tr>
									</table>

								</td>
							</tr>
							<tr>
								<td style="vertical-align:top;background-color: #FAFAFA;vertical-align:top;">
									<div class="icon-comment icon-enabled comment-box" style="float:left;height:100%"><?php echo $value['comment']; ?></div>
								</td>
							</tr>
						</table>
						
					</div>
				</td>
			</tr>
		<?php } ?>
		</table>
	</div>

<?php 
	if($_AJAX != true){ 
		echo '</div>';
		include('footer.php'); 
	}
?>

<script type="text/javascript">
$(function () {

	<?php if($_TASK_DATA->user['id'] == Handler::$_LOGIN_USER_ID){?>
	var descTitle = 'Description <a id="edit_button_owner" href="#" onClick="editDesc()">[Edit]</a>' ;
	<?php } else {?>
	var descTitle = 'Description' ;
	<?php } ?>

    var pstyle = 'border: 1px solid #dfdfdf; padding: 5px;';
    var toolbar_data = {
        items: [
            { type: 'spacer' },
            { type: 'button',  id: 'task_add_progress', caption: 'Add Progress', img: 'icon-add' }
        ],
        onClick: function (event) {
        	if(event.target == 'task_add_progress'){
        		addProgress('<?php echo $_TASK_DATA['id']; ?>');
        	}
        }
    };
    $('#layout_preview_task').w2layout({
        name: 'layout_preview_task',
        panels: [
            { 
            	type: 'top', 
	            size: 105, 
	            resizable: true, 
	            style: 'padding:5px', 
	            content: $('#task_head').html()
        	},
            { 
            	type: 'left',
	            size: 250,  
	            resizable: true, 
            	style: pstyle + 'border-top: 0px;', 
            	content: $('#task_member').html(), 
            	title: 'Member'
            },
            { 
            	type: 'main', 
	            resizable: true, 
	            style: pstyle, 
	            content: $('#task_desc').html(), 
	            title: descTitle
	        },
            { 
            	type: 'bottom', 
	            resizable: true, 
	            size: '65%',  
	            style: pstyle, 
	            content: $('#task_activity').html(), 
	            title: 'Activity',
	            <?php if(in_array(Handler::$_LOGIN_USER_ID, $allowAdd)){echo 'toolbar: toolbar_data';} ?>
	        }
        ]
    });

});

function userPreview(id) {
	openInSameTab('<?php echo BASE_URL; ?>user/preview/'+id);
}

function addProgress(task_id){
	 if (!w2ui.add_task_progress) {
        $().w2form({
            name	: 'add_task_progress',
            style	: 'border: 0px; background-color: transparent;',
	        url 	: '<?php echo BASE_URL; ?>activity/insert_activity/'+task_id,
            fields	: [
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
				    name     : 'message',      
				    type     : 'textarea',       
				    options  : {},          
				    required : true,         
				    html     : {      
				    	attr	: 'style="height:80px;width:320px"',       
				        caption : 'Message'
				    } 
				},
            ],
            record: { 
                progress    : '<?php echo $_TASK_DATA['progress']; ?>',
                status_id    : '<?php echo $_TASK_DATA->status['id']; ?>',
                message    : '-'
            },
            actions: {
                "Save": function () { 
                	var form = this;
                	if(this.validate() == ''){
                		w2confirm('Are you sure post this?', function (btn) { 
	        				if(btn == 'Yes'){
                				form.save();
	        				}
	        			});                		
                	}
                },
                "Reset": function () { this.clear(); },
            },
		    onSave: function(event) {
		        w2popup.close();
			    showMessage('Progress succesfully submitted.','success') ;
			    location.reload();
		    } 
        });
    }
    $().w2popup('open', {
        title   : 'Add Progress',
        body    : '<div id="form_add_task_progress" style="width: 100%; height: 100%;"></div>',
        style   : 'padding: 15px 0px 0px 0px',
        width   : 650,
        height  : 400, 
        modal	: true,
        onClose : function (event) {
	        w2ui.add_task_progress.destroy();
	    },
        onOpen: function (event) {
            event.onComplete = function () {
                $('#w2ui-popup #form_add_task_progress').w2render('add_task_progress');
            }
        }
    });
}

function editProgress(progress_id){

	var getUrl = '<?php echo BASE_URL; ?>activity/get_activity/'+progress_id;
	var saveUrl = '<?php echo BASE_URL; ?>activity/go_edit_activity/';

	 if (!w2ui.edit_task_progress) {
        $().w2form({
            name	: 'edit_task_progress',
            style	: 'border: 0px; background-color: transparent;',
	        recid    : 1,
		    url      : {
		        get  : getUrl,
		        save  : saveUrl
		    },
            fields	: [
            	{ 
				    name     : 'id',      
				    type     : 'int',               				
				    required : true,         
				    html     : {          
				    	attr	: 'style="width:60px" readonly',      
				        caption : 'ID'
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
				    name     : 'message',      
				    type     : 'textarea',       
				    options  : {},          
				    required : true,         
				    html     : {      
				    	attr	: 'style="height:130px;width:400px"',       
				        caption : 'Message',
				        text 	: ' <button class="btn btn-blue" onClick="openEditor()" style="float:right">Editor</button>'
				    } 
				},
            ],
            actions: {
                "Save": function () { 
                	var form = this;
                	if(this.validate() == ''){
                		w2confirm('Are you sure update this?', function (btn) { 
	        				if(btn == 'Yes'){
                				form.save();
	        				}
	        			});                		
                	}
                }
            },
		    onSave: function(event) {
		        w2popup.close();
			    showMessage('Progress succesfully updated.','success') ;
			    location.reload();
		    }
        });
    }
    $().w2popup('open', {
        title   : 'Edit Progress',
        body    : '<div id="form_edit_task_progress" style="width: 100%; height: 100%;text-align:left;"></div>',
        style   : 'padding: 15px 0px 0px 0px',
        width   : 650,
        height  : 400, 
        modal	: true,
        onClose : function (event) {
	        w2ui.edit_task_progress.destroy();
	    },
        onOpen: function (event) {
            event.onComplete = function () {
                $('#w2ui-popup #form_edit_task_progress').w2render('edit_task_progress');
            }
        }
    });
}

function deleteActivity(id) {
	w2confirm('Are you sure delete this?', function (btn) { 
		if(btn == 'Yes'){
			$.ajax({
		        url: '<?php echo BASE_URL; ?>activity/delete_activity/',
		        type: 'POST',
		        data: { 
		          id : id
		        },
		        }).success(function(data){
				    showMessage('Activity succesfully deleted.','success') ;
				    location.reload();
		    });
		}
	});    
}

function editActivity(id) {
	editProgress(id);
}

function openEditor(){
	
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

    $(".editor-area").val(w2ui['edit_task_progress'].record['message']); 
    $(".editor-area").jqte({
        "mywidth":"100%",
        "myheight":"240px",
        blur: function(ss,ccs){ 
    	var message = $('.editor-area').val();
    	w2ui['edit_task_progress'].record['message'] = message;
		w2ui['edit_task_progress'].refresh();
    }});
}

function editDesc() {
	$("#edit_button_owner").text('[Save]');
	$("#edit_button_owner").attr('onClick','saveDesc()');

	$("#desc_area").jqte({
        "mywidth":"100%",
        "myheight":"140px"
    });
}

function saveDesc() {
	$.ajax({
        url: '<?php echo BASE_URL; ?>task/update_description/',
        type: 'POST',
        data: { 
          task_id : '<?php echo $_TASK_DATA['id']; ?>',
          user_id : '<?php echo $_TASK_DATA->user['id']; ?>',
          description : $("#desc_area").val()
        },
        }).success(function(data){
		    showMessage('Description succesfully updated.','success') ;
		    location.reload();
    });
}

</script>
