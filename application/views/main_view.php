<?php include('header.php'); ?>
	
    <div id="content">

    	<div id="layout_dashboard" style="height: 100%; width: 100%;padding:5px;"></div>   
	  
	    <div id="dashboard_main" style="height: 100%; width: 100%;padding:5px;">
	    	<div style="width:300px;height:auto;margin:5px;padding:5px;float:left">
	    		<div class="dialog-header"  style="font-size:21px;font-weight:bold;font-family:Verdana;float:left;width:100%">
	    			Projects
	    		</div>
	    		<div class="dialog-content"  style="font-size:41px;font-weight:bold;font-family:Verdana;float:left;width:100%">
	    			<table>
	    				<tr>
	    					<td rowspan="4" style="width:100px;text-align:center">
	    						<?php echo $_PRO_DATA; ?>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td style="font-size:12px"> Complete</td>
	    					<td style="font-size:12px">: <?php echo $_PRO_DATA_C; ?></td>
	    				</tr>
	    				<tr>
	    					<td style="font-size:12px"> Open</td>
	    					<td style="font-size:12px">: <?php echo $_PRO_DATA_O; ?></td>
	    				</tr>
	    				<tr>
	    					<td style="font-size:12px"> Other</td>
	    					<td style="font-size:12px">: <?php echo $_PRO_DATA_X; ?></td>
	    				</tr>
	    			</table>
	    			
	    		</div>
	    	</div> 

	    	<div style="width:300px;height:auto;margin:5px;padding:5px;float:left">
	    		<div class="dialog-header"  style="font-size:21px;font-weight:bold;font-family:Verdana;float:left;width:100%">
	    			Tasks
	    		</div>
	    		<div class="dialog-content"  style="font-size:41px;font-weight:bold;font-family:Verdana;float:left;width:100%">
	    			<table>
	    				<tr>
	    					<td rowspan="4" style="width:100px;text-align:center">
	    						<?php echo $_TASK_DATA; ?>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td style="font-size:12px"> Complete</td>
	    					<td style="font-size:12px">: <?php echo $_TASK_DATA_C; ?></td>
	    				</tr>
	    				<tr>
	    					<td style="font-size:12px"> Open</td>
	    					<td style="font-size:12px">: <?php echo $_TASK_DATA_O; ?></td>
	    				</tr>
	    				<tr>
	    					<td style="font-size:12px"> Other</td>
	    					<td style="font-size:12px">: <?php echo $_TASK_DATA_X; ?></td>
	    				</tr>
	    			</table>
	    			
	    		</div>
	    	</div> 

	    	<div style="width:300px;height:auto;margin:5px;padding:5px;float:left">
	    		<div class="dialog-header"  style="font-size:21px;font-weight:bold;font-family:Verdana;float:left;width:100%">
	    			Activities
	    		</div>
	    		<div class="dialog-content"  style="font-size:41px;font-weight:bold;font-family:Verdana;float:left;width:100%">
	    			<table>
	    				<tr>
	    					<td rowspan="4" style="width:100px;text-align:center">
	    						<?php echo $_ACT_DATA_A; ?>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td style="font-size:12px"> Complete</td>
	    					<td style="font-size:12px">: <?php echo $_ACT_DATA_C; ?></td>
	    				</tr>
	    				<tr>
	    					<td style="font-size:12px"> Open</td>
	    					<td style="font-size:12px">: <?php echo $_ACT_DATA_O; ?></td>
	    				</tr>
	    				<tr>
	    					<td style="font-size:12px"> Other</td>
	    					<td style="font-size:12px">: <?php echo $_ACT_DATA_X; ?></td>
	    				</tr>
	    			</table>
	    			
	    		</div>
	    	</div> 

	    </div>

	    <div id="dashboard_activities">
	    	<table>
	    	<?php foreach ($_ACT_DATA_S as $key => $value) { ?>
	    		<tr>
    			<td>
	    		<div style="width:100%;float:left;">
					<div style="width:40px;height:40px;float:left;border:1px solid #DFDFDF">
	    				<img src="<?php echo STATIC_DIR.$value->user['profile_pic_url']; ?>" style="width:100%;height:100%">
					</div>
	    			<div class="db-comment-box" style="width:300px;float:left">
		    			<div class="db-comment-box-point"></div>
		    			<div class="db-comment-box-task">
		    				<a href="#" onClick="openTask('<?php echo $value->task['id']; ?>')">#<?php echo $value->task['id']; ?></a> - 
			    			<?php echo substr(strip_tags($value->task['name']),0,30); ?>
		    			</div>
		    			<div class="db-comment-box-comment">
			    			<?php echo substr(strip_tags($value['comment']),0,100); ?>
		    			</div>
		    			<div class="db-comment-box-id">
		    				#<?php echo $value['id']; ?>
		    			</div>
		    			<div class="db-comment-box-date">
		    				<?php echo $this->time_elapsed_string($value['input_date']); ?> &nbsp;
		    			</div>
		    			<div class="db-comment-box-username">
		    				<?php echo $value->user['nickname']; ?> &nbsp;
		    			</div>
	    			</div>
	    		</div>
    			</td>
	    		</tr>
	    	<?php } ?>
	    	</table>
	    </div>

	    <div id="dashboard_activities_owned">
	    	<table>
	    	<?php foreach ($_ACT_DATA_OWN as $key => $value) { ?>
	    		<tr>
    			<td>
	    		<div style="width:100%;float:left;">
					<div style="width:40px;height:40px;float:left;border:1px solid #DFDFDF">
	    				<img src="<?php echo STATIC_DIR.$value->user['profile_pic_url']; ?>" style="width:100%;height:100%">
					</div>
	    			<div class="db-comment-box" style="width:300px;float:left">
		    			<div class="db-comment-box-point"></div>
		    			<div class="db-comment-box-task">
		    				<a href="#" onClick="openTask('<?php echo $value->task['id']; ?>')">#<?php echo $value->task['id']; ?></a> - 
			    			<?php echo substr(strip_tags($value->task['name']),0,30); ?>
		    			</div>
		    			<div class="db-comment-box-comment">
			    			<?php echo substr(strip_tags($value['comment']),0,100); ?>
		    			</div>
		    			<div class="db-comment-box-id">
		    				#<?php echo $value['id']; ?>
		    			</div>
		    			<div class="db-comment-box-date">
		    				<?php echo $this->time_elapsed_string($value['input_date']); ?> &nbsp;
		    			</div>
		    			<div class="db-comment-box-username">
		    				<?php echo $value->user['nickname']; ?> &nbsp;
		    			</div>
	    			</div>
	    		</div>
    			</td>
	    		</tr>
	    	<?php } ?>
	    	</table>
	    </div>

    </div>

<?php include('footer.php'); ?>

<script>

	$(function () {

	    var pstyle = 'background-color: #F5F6F7; border: 1px solid #dfdfdf; padding: 5px;';
	    var pstyle2 = 'background-color:#E9F0F8; border: 1px solid #dfdfdf; padding: 5px;';
	    $('#layout_dashboard').w2layout({
	        name: 'layout_dashboard',
	        panels: [
	         	{ 
	            	type: 'right', 
		            size: 380, 
		            resizable: true, 
		            style: pstyle2, 
		            title: 'Latest Other Activity',
		            content: $('#dashboard_activities').html()
	        	},
	         	{ 
	            	type: 'left', 
		            size: '38%', 
		            resizable: true, 
		            content: $('#dashboard_main').html()
	        	},
	         	{ 
	            	type: 'main', 
		            resizable: true, 
		            style: pstyle2, 
		            title: 'Your Activity',
		            content: $('#dashboard_activities_owned').html()
	        	},
	        ]
	    });

	});

	function openTask(id) {
		openInSameTab('<?php echo BASE_URL; ?>task/preview/'+id);
	}

</script>