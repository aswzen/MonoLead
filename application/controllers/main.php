<?php
class Main extends Controller {

    function index()
    {
        $template = $this->loadView('main_view');
        //echo $this->getRN('PROJECT');
        $template->set('_DATA','');
        $template->render();

	}
    
}

?>
