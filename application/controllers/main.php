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

        /* anything below were about calculation for dashboard summaries */

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

        /* Total Projects Other Status */
        $template->set('_PRO_DATA_X',$px);
        /* Total Projects Completed */
        $template->set('_PRO_DATA_C',$pc);
        /* Total Projects Opened */
        $template->set('_PRO_DATA_O',$po);
        /* Total Projects Existed */
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

        /* Total Task Other Status */
        $template->set('_TASK_DATA_X',$tx);
        /* Total Task Completed */
        $template->set('_TASK_DATA_C',$tc);
        /* Total Task Opened */
        $template->set('_TASK_DATA_O',$to);
        /* Total Task Existed */
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

        /* Total Activities Other Status */
        $template->set('_ACT_DATA_X',$ax);
        /* Total Activities Completed */
        $template->set('_ACT_DATA_C',$ac);
        /* Total Activities Opened */
        $template->set('_ACT_DATA_O',$ao);
        /* Total Activities Existed */
        $template->set('_ACT_DATA_A',count($_ACT_DATA));

        $template->set('_ACT_DATA_OWN',$_ACT_DATA_OWN);
        $template->set('_ACT_DATA_S',$_ACT_DATA_S);
        $template->render();
	}
    
}

?>
