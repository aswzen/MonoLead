<div style="width:100%;padding:5px" >
	<div class="dialog-header">
		<span class="ticket-lbl" ><b>#<?php echo $_PROJECT_DATA['id']; ?></b></span> 
		<?php echo $_PROJECT_DATA['name'];?>
		<div class="<?php echo $_PROJECT_DATA->status['icon']; ?>" style="width:20px;height:20px;float:right"></div>
		<div style="float:right"><?php echo $_PROJECT_DATA->status['name']; ?></div>
	</div>
	<div class="dialog-content">
		<div style="padding: 3px 0px;font-size:10px">
			Description:
		</div>
		<?php echo $_PROJECT_DATA['description'];?>
	</div>
</div>
<table style="width:100%;height:89%;" >
	<tr style="height:30px">
		<?php foreach ($_STATUS_DATA as $key => $value) {?>
			<td>
				<div class="dialog-header">
					<div class="<?php echo $value['icon']; ?>" style="width:20px;height:20px;float:right"></div>
				<?php echo $value['name'];?>
				</div>
			</td>
		<?php } ?>
	</tr>
	<tr>
	<?php
		$pr['High'] = 'red';
		$pr['Medium'] = 'yellow';
		$pr['Low'] = 'LawnGreen';
		$pr['Other'] = 'white';
		foreach ($_STATUS_DATA as $key => $value) {?>
		<td class="td-view-project" title="<?php echo $value['name'];?>">
			<div>
			<?php foreach ($_TASK_DATA as $key2 => $value2) { ?>
				<?php if($value['id'] == $value2['status_id']) { ?>
					<div class="task-header">
						<div class="task-header-priority" style="background-color:<?php echo $pr[$value2['priority']];?>">&nbsp;</div>
						<div class="ticket-lbl-sml" onClick="openTask('<?php echo $value2['id']; ?>')" >
							<b>#<?php echo $value2['id']; ?></b>
							<div style="float:right;font-size:10px"><?php echo $value2['progress']; ?>%</div>
						</div>
						<div class="task-content" >
							<div style="padding: 3px 0px;font-size:12px">
								<?php echo $value2['name'];?>
							</div>
							<div style="padding: 3px 0px;font-size:10px">
								updated <?php echo $this->time_elapsed_string($value2['update_date']);?>
							</div>
						</div>
					</div>
				<?php } ?>
			<?php } ?>		
			</div>
		</td>
	<?php } ?>
	</tr>
		
</table>