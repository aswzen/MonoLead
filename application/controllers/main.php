<?php
class Main extends Controller {

    function index()
    {
        $template = $this->loadView('main_view');
        $template->set('_DATA','');
        $template->render();
	}
    
}

?>
