<?php

class Tes extends Controller {
	
	function index()
	{
        $template = $this->loadView('tes');
        $template->render();

	}
    
}

?>
