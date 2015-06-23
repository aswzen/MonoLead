<?php

class Handler extends Controller {
	
    public static $_LOGIN_STATUS = 0;
    public static $_LOGIN_USER_NAME = '-';
    public static $_LOGIN_USER_ID = '-';
    public static $_LOGIN_USER_EMAIL = '-';
    public static $_LOGIN_ACT_NAME = 'login';
    public static $_LOGIN_ACT_LABEL = 'Login';
    public static $_CONTROLLER_NAME = 'None';
    public static $_ACTION_NAME = 'None';
    public static $_IS_ADMIN = false;
    public static $_IS_MANAGER = false;

    public static $_SITE_NAME = '';
    public static $_ADDITIONAL_FOOTER = '';
    public static $_IS_MAINTENANCE = 'No';
    public static $_DF = 'Y-m-d H:i:s';
    public static $_CONFIG = null;
    
    function __construct() 
    {

        $this->helperLoader('Session');

    	self::$_CONTROLLER_NAME = ucfirst($this->getController());
    	self::$_ACTION_NAME = ucfirst($this->getAction());
        $ls = Session::r('LOGIN_STATUS');

		if($this->getController() == 'login' || $this->getAction() == 'login'){
			if(!empty($ls)){
	        	$this->redirect('main/');
	        }
		} else {
	        if(!empty($ls)){
	        	self::$_LOGIN_STATUS = 1;
	        	self::$_LOGIN_USER_NAME = Session::r('USER_NAME');
	        	self::$_LOGIN_USER_ID = Session::r('USER_ID');
	        	self::$_LOGIN_USER_EMAIL = Session::r('USER_EMAIL');
	        	self::$_LOGIN_ACT_NAME = 'logout';
	        	self::$_LOGIN_ACT_LABEL = 'Logout';
	        	
                if(Session::r('USER_GROUP') == 'ADM'){
                    self::$_IS_ADMIN = true;
                }

	        	if(Session::r('USER_GROUP') == 'MAN'){
	        		self::$_IS_MANAGER = true;
	        	}

	        } else {
	        	$this->redirect('login/');
	        }
		}

     	self::$_CONFIG = $this->loadModel('ConfigModel');
        $_CONFIG_DATA = self::$_CONFIG->loadConfig();

    	self::$_SITE_NAME = $_CONFIG_DATA['site_name'];
    	self::$_ADDITIONAL_FOOTER = $_CONFIG_DATA['additional_footer'];
        self::$_IS_MAINTENANCE = $_CONFIG_DATA['maintenance_mode'];
    	self::$_DF = $_CONFIG_DATA['datetime_format'];
  
    }
    
}

?>
