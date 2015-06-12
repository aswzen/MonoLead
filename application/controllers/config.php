<?php
class Config extends Controller {

    function index()
    {
        $template = $this->loadView('config_view');
     	
     	//$_CONFIG = $this->loadModel('ConfigModel');
     	$_CONFIG = Handler::$_CONFIG;
        $_CONFIG_DATA = $_CONFIG->loadConfig();

        $result = array(
            'site_name' => $_CONFIG_DATA['site_name'], 
            'maintenance_mode' => $_CONFIG_DATA['maintenance_mode'], 
            'additional_footer' => $_CONFIG_DATA['additional_footer']
        );

        $template->set('_CONFIG_DATA',json_encode($result));
        $template->render();
	}
    
    function go_edit_config()
    {
       
     	//$_CONFIG = $this->loadModel('ConfigModel');
		$_CONFIG = Handler::$_CONFIG;
		
        $array = array(
            "site_name" => $_POST['record']['site_name'],
            "additional_footer" => $_POST['record']['additional_footer'],
            "maintenance_mode" => $_POST['record']['maintenance_mode']['id'],
            "datetime_format" => $_POST['record']['datetime_format']
        );

        $_CONFIG->saveConfig($array);

        die();
    }

}

?>
