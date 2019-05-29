<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />

        <title><?php echo Handler::$_CONTROLLER_NAME; ?> :: <?php echo Handler::$_SITE_NAME;?></title>
        <meta name="description" content="MonoLead is a web based project management system">
        <meta name="author" content="Agus Sigit Wisnubroto">

        <link rel="shortcut icon" href="<?php echo STATIC_DIR; ?>favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo STATIC_DIR; ?>favicon.ico" type="image/x-icon">

        <link rel="stylesheet" href="<?php echo STATIC_DIR; ?>css/w2ui.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo STATIC_DIR; ?>css/style.css" type="text/css" media="screen" />
        <link rel="stylesheet" class="icons-lib" href="<?php echo STATIC_DIR; ?>css/icon.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?php echo STATIC_DIR; ?>css/jquery.te.css" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo STATIC_DIR; ?>js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_DIR; ?>js/jquery.te.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_DIR; ?>js/w2ui.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_DIR; ?>js/notify.min.js"></script>
        <script type="text/javascript" src="<?php echo STATIC_DIR; ?>js/init.js"></script>
    </head>
    <body>

    <div id="layout" style="width: 100%; height: 100%;">
        <div id="header">
            <div style="background: url(<?php echo STATIC_DIR; ?>images/logo.png) no-repeat;width:25px;height:25px;float:left"></div>
            <div style="font-size:20px;float:left">
                <?php echo Handler::$_SITE_NAME;?>
            </div>
        </div>
