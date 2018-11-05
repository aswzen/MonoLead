	
    	<div id="footer">
    		<div style="background: url(<?php echo STATIC_DIR; ?>images/cplogo.png) no-repeat;width:25px;height:25px;float:left"></div>
    		<div class="footer">MonoLead <?php echo version;?></div>
    		<div class="footer-additional">
    			<?php echo Handler::$_ADDITIONAL_FOOTER;?>
    		</div>
    	</div>
    </div>

	<script type="text/javascript">
	$(function () {
	    tools =  {
            items: [
                { type: 'button',  id: 'main', caption: 'Dashboard', img: 'icon-house' },
                { type: 'break',  id: 'break0' },
                { type: 'button',  id: 'taskboard', caption: 'Taskboard', img: 'icon-taskboard' },
                <?php if(Handler::$_IS_ADMIN||Handler::$_IS_MANAGER) echo "{ type: 'button',  id: 'project', caption: 'Projects', img: 'icon-box' },"; ?>
                { type: 'button',  id: 'ticket', caption: 'Tickets', img: 'icon-ticket' },
                { type: 'break',  id: 'break1' },
                { type: 'button',  id: 'task', caption: 'Tasks', img: 'icon-task' },
                <?php if(Handler::$_IS_ADMIN||Handler::$_IS_MANAGER) echo "{ type: 'button',  id: 'user', caption: 'Users', img: 'icon-group' },"; ?>
                <?php if(Handler::$_IS_ADMIN||Handler::$_IS_MANAGER) echo "{ type: 'button',  id: 'usergroup', caption: 'User Group', img: 'icon-usergroup' },"; ?>
                <?php if(Handler::$_IS_ADMIN||Handler::$_IS_MANAGER) echo "{ type: 'button',  id: 'config', caption: 'Configuration', img: 'icon-config' },"; ?>
               	{ type: 'spacer' },
                { type: 'button',  id: 'user/profile',  caption: '<?php echo Handler::$_LOGIN_USER_NAME; ?>', img: 'icon-info', hint: 'User profile' },
                { type: 'button',  id: 'user/<?php echo Handler::$_LOGIN_ACT_NAME; ?>',  caption: '<?php echo Handler::$_LOGIN_ACT_LABEL; ?>', img: 'icon-user', hint: 'Logout from system' }
            ],
            onClick: function (event) {    	
				var win = window.open('<?php echo BASE_URL; ?>'+event.target, '_self');
				win.focus();
            }
        }

        var pstyle = 'border: 1px solid #dfdfdf; padding: 5px;overflow:hidden';
	    var pstyle2 = 'overflow:hidden;';
	    $('#layout').w2layout({
	        name: 'layout',
	        panels: [
	            { type: 'top', size: 40, style: pstyle, content: $('#header').html() },
	            { type: 'main',style: pstyle2, content: $('#content').html(),toolbar:tools  },
	            { type: 'bottom', size: 25, style: pstyle, content: $('#footer').html()  }
	        ]
	    });
	});
	</script>

	</body>
</html>