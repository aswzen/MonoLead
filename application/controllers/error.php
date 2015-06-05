<?php

class Error extends Controller {
	
	function index()
	{
		$this->error404();
	}
	
	function error404()
	{
        $template = $this->loadView('error');
        $template->render();;
	}
    
}

?>
