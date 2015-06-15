<?php

class Taskboard extends Controller {
	
	function index()
	{
        $template = $this->loadView('taskboard_view');

     	$_PROJECT = $this->loadModel('ProjectModel');
     	$_TASK = $this->loadModel('TaskModel');

       	$_PROJECT_DATA = $_PROJECT->getAllProjectsByUser(Handler::$_LOGIN_USER_ID);

        $result = array();

        $result[0] = array(
            'id' => 'ALL',
            'text' => 'All Project',  
            'img' => 'icon-box',
            'selected' => true,
            'type' => 'allproject',
            'link' => '/showall'
        );

        $index = 1;
        foreach ($_PROJECT_DATA as $key => $value) {

        	$_TASK_DATA = $_TASK->getTaskByProjectAndUser($value['id'],Handler::$_LOGIN_USER_ID);
 
        	$resultTask = array();
    	 	foreach ($_TASK_DATA as $key2 => $value2) {
	            array_push($resultTask, array(
	                'text' => $value2['name'], 
	                'id' => $value2['id'],
	                'img' => 'icon-task',
                    'type' => 'task',
            		'link' => '/task/'.$value2['id']
	            ));
	        }

            $result[$index] = array(
                'id' => $value['id'],
                'text' => $value['name'], 
                'count' => count($resultTask), 
                'nodes' => $resultTask, 
                'img' => 'icon-box',
                'expanded' => true,
                'group' => false,
                'type' => 'project',
        		'link' => '/project/'.$value['id']
            );
            $index++;
        }

        $template->set('_PROJECT_DATA',json_encode($result,true));
        $template->render();
	}
    
    function showall()
    {
        $template = $this->loadView('taskboard_showall');

    	$_PROJECT = $this->loadModel('ProjectModel');
    	$_TASK = $this->loadModel('TaskModel');

        $_PROJECT_DATA = $_PROJECT->getAllProjectsByUser(Handler::$_LOGIN_USER_ID);
        $dataProject = array();
        $dataTask = array();
        $index = 0;
        if($_POST['type'] == 'ALL'){
            foreach ($_PROJECT_DATA as $key2 => $value2) {
                $dataTask[$index] = array();
                $_TASK_DATA = $_TASK->getTaskByProjectAndUser($value2['id'],Handler::$_LOGIN_USER_ID);
                foreach ($_TASK_DATA as $key3 => $value3) {
                    array_push($dataTask[$index], $value3);
                }
                array_push($dataProject, $value2);
                $index++;
            } 
        } else {
            foreach ($_PROJECT_DATA as $key2 => $value2) {
            	$dataTask[$index] = array();
    	        $_TASK_DATA = $_TASK->getTaskByProjectAndUser($value2['id'],Handler::$_LOGIN_USER_ID,'NC');
        		foreach ($_TASK_DATA as $key3 => $value3) {
    		       	array_push($dataTask[$index], $value3);
        		}
            	array_push($dataProject, $value2);
            	$index++;
            }
        }

        $template->set('_LT', $_POST['type']);
        $template->set('_PROJECT_DATA', $dataProject);
        $template->set('_TASK_DATA', $dataTask);
        $template->render();
    }

    function project($project_id = null)
    { 
        $template = $this->loadView('preview_project');

        $_STATUS = $this->loadModel('StatusModel');
        $_PROJECT = $this->loadModel('ProjectModel');
        $_TASK = $this->loadModel('TaskModel');

        $_STATUS_DATA = $_STATUS->getAllStatuses();
        $_PROJECT_DATA = $_PROJECT->getProject($project_id);
        $_TASK_DATA = $_TASK->getTaskByProjectAndUser($project_id,Handler::$_LOGIN_USER_ID);

        $template->set('_STATUS_DATA', $_STATUS_DATA);
        $template->set('_PROJECT_DATA', $_PROJECT_DATA);
        $template->set('_TASK_DATA', $_TASK_DATA);
        $template->render();
    }

    function task($task_id = null)
    {
        if($task_id == null){
            die('Missing parameter');
        }
       
        $template = $this->loadView('preview_task_view');

        $_ACT = $this->loadModel('ActivityModel');
        $_ACT_DATA = $_ACT->getActivityByTask($task_id);

        $_TASK = $this->loadModel('TaskModel');
        $_TASK_DATA = $_TASK->getTask($task_id);

        $_TASKER = $this->loadModel('TaskerModel');
        $_TASKER_DATA = $_TASKER->getTaskUser($_TASK_DATA['id']);

        $_STATUS = $this->loadModel('StatusModel');
        $_STATUS_DATA = $_STATUS->getAllStatuses();
        $resultStatus = array();
        foreach ($_STATUS_DATA as $key => $value) {
            array_push($resultStatus, array(
                'text' => $value['name'], 
                'id' => $value['id'],
                'icon' => $value['icon']
            ));
        }

        $template->set('_STATUS_DATA',json_encode($resultStatus));
        $template->set('_TASKER_DATA',$_TASKER_DATA);
        $template->set('_TASK_DATA',$_TASK_DATA);
        $template->set('_ACT_DATA',$_ACT_DATA);
        $template->set('_AJAX',true);
        $template->render();
    }
}

?>
