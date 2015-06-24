<?php if($_LT == 'NC'){
	$s = 'selected';
	$e = '';
} else {
	$s = '';
	$e = 'selected';
} ?>

<table style="width:100%" >
	<div style="float:left">
	<h2>
		MY PROJECT 
	</h2>
	</div>
	<div style="float:right">
		<select id="list_type" style="float:right">
			<option value="ALL" <?php echo $e;?> >All</option>
			<option value="NC" <?php echo $s;?> >Not Complete</option>
		</select>
		<div style="float:right;padding:5px">
			Task Status: 
		</div>
	</div>
	<?php foreach ($_PROJECT_DATA as $key => $value) { ?>
		<tr>
			<td>
				<div style="width:100%;padding:5px" >
					<div class="dialog-header">
						<span class="ticket-lbl" ><b>#<?php echo$value['id']; ?></b></span> 
						<?php echo $value['name'];?>
						<div class="<?php echo $value->status['icon']; ?>" style="width:20px;height:20px;float:right"></div>
						<div style="float:right"><?php echo $value->status['name']; ?></div>
					</div>
					<div class="dialog-content">
						<div style="padding: 3px 0px;font-size:10px">
							Description:
						</div>
						<div class="dialog-content-desc">
							<?php echo $value['description'];?>
						</div>
						<div style="padding: 3px 0px;font-size:10px">
							Tasks:
						</div>
						<?php 
						$pr['High'] = 'red';
						$pr['Medium'] = 'yellow';
						$pr['Low'] = 'LawnGreen';
						$pr['Other'] = 'white';
						foreach ($_TASK_DATA[$key] as $key2 => $value2) { ?>
							<div class="dialog-content-task">
								<span style="float:left;margin-right:5px;" class="ticket-lbl" onClick="openTask('<?php echo $value2['id']; ?>')" ><b>#<?php echo $value2['id']; ?></b></span> 
								<div style="background-color:<?php echo $pr[$value2['priority']];?>;width:10px" title="<?php echo $value2['priority'];?>" class="priority-lbl"></div>
								<div style="float:right" >
									<b>Progress</b><br>
									<?php echo $value2['progress'];?>%
								</div>	
								<div style="float:right;margin-right:10px;">
									<b>Due Date</b><br>
									<?php 
										if( date(Handler::$_DF,strtotime($value2['end_date'])) <= date(Handler::$_DF)){
											echo '<span class="label label-danger">';
										} else {
											echo '<span class="label label-primary">';
										}
									?>
										<?php echo date(Handler::$_DF,strtotime($value2['end_date'])); ?>
									</span>
								</div>	
								<div style="float:right;margin-right:10px;width:130px">
									<b>Status</b><br>
									<div class="<?php echo $value2->status['icon']; ?>" style="width:20px;height:20px;float:left"></div>
									<div style="float:left"><?php echo $value2->status['name']; ?></div>
								</div>
								<div style="float:right;margin-right:10px;font-size:10px">
									updated <?php echo $this->time_elapsed_string($value2['update_date']);?>
								</div>	
								<div style="padding-left:5px;float:left">
									<?php echo $value2['name'];?>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</td>
		</tr>
	<?php }?>
</table>

<script type="text/javascript">
	
	function openTask(id) {
		openInSameTab('<?php echo BASE_URL; ?>task/preview/'+id);
	}

    $('#list_type').on('change', function (e) {
	    $.ajax({
	        url: '<?php echo BASE_URL; ?>taskboard/showall/',
	        type: 'POST',
	        data:{
	            type: $('#list_type').val()
	        },
	        }).success(function(data){
	        w2ui['layout_taskboard'].content('main', data);
	    });
    });
	
</script>