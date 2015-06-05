<?php

class Controller {
	
	function __construct() {
		require(APP_DIR .'controllers/handler.php');
		$handler = new Handler(); 
	}

	public function loadModel($name)
	{
		require(APP_DIR .'models/'. strtolower($name) .'.php');

		$model = new $name;
		return $model;
	}
	
	public function loadView($name)
	{
		$view = new View($name);
		return $view;
	}
	
	public function loadPlugin($name)
	{
		require(APP_DIR .'plugins/'. strtolower($name) .'.php');
	}
	
	public function loadHelper($name)
	{
		require(APP_DIR .'helpers/'. strtolower($name) .'.php');
		$helper = new $name();
		return $helper;
	}
	
	public function helperLoader($name)
	{
		require(APP_DIR .'helpers/'. strtolower($name) .'.php');
	}
	
	public function redirect($loc)
	{
		global $config;
		
		header('Location: '. $config['base_url'] . $loc);
	}

	public function getURLSegment()
	{
		$url = '';
	 	$request_url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : '';
		$script_url  = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : '';
		if($request_url != $script_url) $url = trim(preg_replace('/'. str_replace('/', '\/', str_replace('index.php', '', $script_url)) .'/', '', $request_url, 1), '/');
		$segments = explode('/', $url);
		return $segments;
	}

	public function getController()
	{
		$controller = '';
		$segments = $this->getURLSegment();
		if(isset($segments[0]) && $segments[0] != '') $controller = $segments[0];
		return $controller;
	}

	public function getAction()
	{
		$action = '';
		$segments = $this->getURLSegment();
		if(isset($segments[1]) && $segments[1] != '') $action = $segments[1];
		return $action;
	}

	public function escapeString($data) {
        if ( !isset($data) or empty($data) ) return '';
        if ( is_numeric($data) ) return $data;

        $non_displayables = array(
            '/%0[0-8bcef]/',            // url encoded 00-08, 11, 12, 14, 15
            '/%1[0-9a-f]/',             // url encoded 16-31
            '/[\x00-\x08]/',            // 00-08
            '/\x0b/',                   // 11
            '/\x0c/',                   // 12
            '/[\x0e-\x1f]/'             // 14-31
        );
        foreach ( $non_displayables as $regex )
            $data = preg_replace( $regex, '', $data );
        $data = str_replace("'", "''", $data );
        return $data;
    }

    function getRN($code = null)
    {
        $_RN = $this->loadModel('RunningNumberModel');
        $_DATA_RN = $_RN->generateRunningNumber($code);

		$prefix = $_DATA_RN['prefix'];
 		$runningFormat = $_DATA_RN['format'];
 		$lastNumber = $_DATA_RN['lastnumber'];
 		$num_padded = sprintf("%0".strlen($runningFormat)."s", $lastNumber+1);
 		$nextNumber = $prefix.''.$num_padded;

        $array = array(
            "numbercode" => $code,
            "lastnumber" => $lastNumber+1
        );
        
        $_RN->updateRunningNumber($array);

        return $nextNumber;
    }
}

?>