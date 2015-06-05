<?php
class Login extends Controller {

    function index()
    {
        $template = $this->loadView('login_form');
        $template->render();
    }
    
}

?>
