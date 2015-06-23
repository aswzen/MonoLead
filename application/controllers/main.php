<?php
class Main extends Controller {

    function index()
    {
        $template = $this->loadView('main_view');
     	
     	$_ACT = $this->loadModel('ActivityModel');
        $_ACT_DATA = $_ACT->getAllActivities();
        $_ACT_DATA_S = $_ACT->getAllActivitiesLimit(10,Handler::$_LOGIN_USER_ID,'not');
        $_ACT_DATA_OWN = $_ACT->getAllActivitiesLimit(10,Handler::$_LOGIN_USER_ID,'in');

     	$_PRO = $this->loadModel('ProjectModel');
        $_PRO_DATA = $_PRO->getAllProjects();

        $pc = 0;
        $po = 0;
        $px = 0;
        foreach ($_PRO_DATA as $key => $value) {
        	if($value['status_id'] == '5'){
        		$pc++;
        	} else if($value['status_id'] == '1' || $value['status_id'] == '3'){
        		$po++;
        	} else {
        		$px++;
        	}
        }

        $template->set('_PRO_DATA_X',$px);
        $template->set('_PRO_DATA_C',$pc);
        $template->set('_PRO_DATA_O',$po);
        $template->set('_PRO_DATA',count($_PRO_DATA));

     	$_TASK = $this->loadModel('TaskModel');
        $_TASK_DATA = $_TASK->getAllTasks();

        $tc = 0;
        $to = 0;
        $tx = 0;
        foreach ($_TASK_DATA as $key => $value) {
        	if($value['status_id'] == '5'){
        		$tc++;
        	} else if($value['status_id'] == '1' || $value['status_id'] == '3'){
        		$to++;
        	} else {
        		$tx++;
        	}
        }

        $template->set('_TASK_DATA_X',$tx);
        $template->set('_TASK_DATA_C',$tc);
        $template->set('_TASK_DATA_O',$to);
        $template->set('_TASK_DATA',count($_TASK_DATA));

        $ac = 0;
        $ao = 0;
        $ax = 0;
        foreach ($_ACT_DATA as $key => $value) {
        	if($value['status_id'] == '5'){
        		$ac++;
        	} else if($value['status_id'] == '1' || $value['status_id'] == '3'){
        		$ao++;
        	} else {
        		$ax++;
        	}
        }

        $template->set('_ACT_DATA_X',$ax);
        $template->set('_ACT_DATA_C',$ac);
        $template->set('_ACT_DATA_O',$ao);
        $template->set('_ACT_DATA_A',count($_ACT_DATA));

        $template->set('_ACT_DATA_OWN',$_ACT_DATA_OWN);
        $template->set('_ACT_DATA_S',$_ACT_DATA_S);
        $template->render();
	}
    
}

?>
