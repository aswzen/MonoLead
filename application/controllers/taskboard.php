<?php

class Taskboard extends Controller {
	
	function index()
	{
        $template = $this->loadView('taskboard_view');

     	$_PROJECT = $this->loadModel('ProjectModel');
     	$_TASK = $this->loadModel('TaskModel');

        // $_PROJECT_DATA = $_PROJECT->getAllProjects();
       	$_PROJECT_DATA = $_PROJECT->getAllProjectsByUser(Handler::$_LOGIN_USER_ID);

        $result = array();

        $result[0] = array(
            'id' => 'ALL',
            'text' => 'All Project',  
            'img' => 'icon-box',
            'selected' => true,
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
        foreach ($_PROJECT_DATA as $key2 => $value2) {
        	$dataTask[$index] = array();
	        $_TASK_DATA = $_TASK->getTaskByProjectAndUser($value2['id'],Handler::$_LOGIN_USER_ID);
    		foreach ($_TASK_DATA as $key3 => $value3) {
		       	array_push($dataTask[$index], $value3);
    		}
        	array_push($dataProject, $value2);
        	$index++;
        }

        $template->set('_PROJECT_DATA', $dataProject);
        $template->set('_TASK_DATA', $dataTask);
        $template->render();
    }

    function project($project_id = null)
    {
    	die($project_id);
    }

    function task($task_id = null)
    {
    	die($task_id);
    }
}

?>
