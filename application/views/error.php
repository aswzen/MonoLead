<?php include('header.php'); ?>
	
    	<div id="content">
    		<div class="centered-2">
    			<div style="font-size:20px;background-color:white;padding:10px;border:1px solid gray;">
			    Page not found
    			</div>
			</div>
    	</div>

	
    	<div id="footer" ><center>MonoLead <?php echo version;?></center></div>
    </div>

	<script type="text/javascript">
	$(function () {

	    var pstyle = 'border: 1px solid #dfdfdf; padding: 5px;';
	    var frontstyle = 'background:  url("<?php echo STATIC_DIR; ?>/images/bgone.png") white;';

	    $('#layout').w2layout({
	        name: 'layout',
	        panels: [
	            { type: 'main',style: frontstyle, content: $('#content').html()  },
	            { type: 'bottom', size: 30, style: pstyle, content: $('#footer').html()  }
	        ]
	    });

	});
	</script>

	</body>
</html>