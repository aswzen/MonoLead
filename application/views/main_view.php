<?php include('header.php'); ?>
	
    <div id="content">

    	<div id="layout_dashboard" style="height: 100%; width: 100%;padding:5px;"></div>   
	  
	    <div id="dashboard_left">
	    	KOSONG
	    	<!-- <div style="width:300px;height:200px;border:1px solid gray;margin:5px;padding:5px">
	    		<div style="font-size:21px;font-weight:bold;font-family:Verdana;float:left;border:1px solid gray;width:100%">
	    			Projects
	    		</div>
	    		<div style="font-size:41px;font-weight:bold;font-family:Verdana;float:left;border:1px solid gray;width:100%">
	    			1245
	    		</div>
	    	</div> -->
	    </div>

	    <div id="dashboard_activities">
	    	<?php foreach ($_ACT_DATA as $key => $value) { ?>
	    		<div style="width:100%;float:left;">
					<div style="width:40px;height:40px;float:left;border:1px solid #DFDFDF">
	    				<img src="<?php echo STATIC_DIR.$value->user['profile_pic_url']; ?>" style="width:100%;height:100%">
					</div>
	    			<div class="db-comment-box" style="width:84%;float:left">
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
	    	<?php } ?>
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
		            size: 400, 
		            resizable: true, 
		            style: pstyle2, 
		            title: 'Latest Activity',
		            content: $('#dashboard_activities').html()
	        	},
	         	{ 
	            	type: 'left', 
		            size: 400, 
		            resizable: true, 
		            content: $('#dashboard_left').html()
	        	}
	        ]
	    });

	});

	function openTask(id) {
		openInSameTab('<?php echo BASE_URL; ?>task/preview/'+id);
	}

</script>