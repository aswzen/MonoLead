<?php

class Ticket extends Controller {
	function index()
	{
        $template = $this->loadView('ticket_view');
        $template->render();
	}
}