<table style="width:100%">
	<h2>
		Project Member of
	</h2>
	<?php foreach ($_PROJECT_DATA as $key => $value) { ?>
		<tr>
			<td>
				<div style="width:100%;padding:5px" >
					<div class="dialog-header">
						<span class="ticket-lbl"><b>#<?php echo$value['id']; ?></b></span> 
						<?php echo $value['name'];?>
						<div class="<?php echo $value->status['icon']; ?>" style="width:20px;height:20px;float:right"></div>
						<div style="float:right"><?php echo $value->status['name']; ?></div>
					</div>
					<div class="dialog-content">
						<div class="dialog-content-desc">
							<?php echo $value['description'];?>
						</div>
						<?php foreach ($value->tasker() as $key2 => $value2) { ?>
							<div class="dialog-content-task" style="">
								<?php echo $value['description'];?>
							</div>
						<?php } ?>
					</div>
				</div>
			</td>
		</tr>
	<?php }?>
</table>

