<?php
class Main extends Controller {

    function index()
    {
        $template = $this->loadView('main_view');
     	
     	$_ACT = $this->loadModel('ActivityModel');
        $_ACT_DATA = $_ACT->getAllActivities();

        $template->set('_ACT_DATA',$_ACT_DATA);
        $template->render();
	}
    
}

?>
