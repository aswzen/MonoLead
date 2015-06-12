<?php
/*
 * PIP v0.5.3
 */

//Start the Session
session_start(); 

// Defines
define('ROOT_DIR', realpath(dirname(__FILE__)) .'/');
define('APP_DIR', ROOT_DIR .'application/');

// FOR INSTALLER
$_CF_FILE = APP_DIR .'config/config.php';
if (!file_exists($_CF_FILE)) {
	echo '<div style="padding:20px;font: 12px Verdana;font-weight:bold">';
	echo 'It Seems you dont set up the MonoLead. Please go here: <a href="install.php">Setup</a>';
	echo '</div>';
	die();
} 
// Includes
require(APP_DIR .'config/config.php');
require(ROOT_DIR .'system/model.php');
require(ROOT_DIR .'system/view.php');
require(ROOT_DIR .'system/controller.php');
require(ROOT_DIR .'system/pip.php');

// Define base URL
global $config;
define('BASE_URL', $config['base_url']);
define('STATIC_DIR', $config['base_url'].'static/');

function pr($var) {
	$template = php_sapi_name() !== 'cli' ? '<pre>%s</pre>' : "\n%s\n";
	printf($template, print_r($var, true));

}

pip();

?>
