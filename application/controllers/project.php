<?php

class Project extends Controller {
	
	function index()
	{
        $template = $this->loadView('project_view');

        $_STATUS = $this->loadModel('StatusModel');
        $_STATUS_DATA = $_STATUS->getAllStatuses();

        $result = array();
        foreach ($_STATUS_DATA as $key => $value) {
            array_push($result, array(
                'text' => $value['name'], 
                'id' => $value['id'],
                'icon' => $value['icon']
            ));
        }

        $template->set('_STATUS_DATA',json_encode($result));
        $template->render();
	}

    function get_project_list()
    {
        $_PROJECT = $this->loadModel('ProjectModel');
        $_DATA = $_PROJECT->getAllProjects($_POST);

        $result['status'] = 'success';
        $result['total'] = count($_DATA);
        $result['records'] = array();
        foreach ($_DATA as $key => $value) {
            array_push($result['records'], array(
                'id' => $value['id'], 
                'name' => $value['name'], 
                'status_id' => $value['status_id'],
                'status_name' => $value->status['name'],
                'status_icon' => $value->status['icon'],
                'description' => $value['description']
            ));
        }
        echo json_encode($result);
        die();
    }

    function get_project($id = null)
    {
       
        $_PROJECT = $this->loadModel('ProjectModel');
        $_PROJECT_DATA = $_PROJECT->getProject($id);

        $result['status'] = 'success';
        $result['record'] = array(
            'recid' => 1, 
            'id' => $_PROJECT_DATA['id'], 
            'name' => $_PROJECT_DATA['name'], 
            'status_id' =>$_PROJECT_DATA['status_id'],
            'status_name' => $_PROJECT_DATA->status['name'],
            'description' => $_PROJECT_DATA['description']
        );
        echo json_encode($result);
        die();
    }

    function go_edit_project()
    {
       
        $_PROJECT = $this->loadModel('ProjectModel');

        $array = array(
            "id" => $_POST['record']['id'],
            "name" => $_POST['record']['name'],
            "description" => $_POST['record']['description'],
            "status_id" => $_POST['record']['status_id']['id']
        );

        $_PROJECT->saveProject($array);

        die();
    }

    function go_insert_project()
    {
       
        $_PROJECT = $this->loadModel('ProjectModel');

        $array = array(
            "id" => $this->getRN('PROJECT'),
            "name" => $_POST['record']['name'],
            "description" => $_POST['record']['description'],
            "status_id" => $_POST['record']['status_id']['id'],
            "created_by" => Session::r('USER_ID')
        );

        $_PROJECT->addProject($array);

        die();
    }

	function delete_project()
    {
        $_TASK = $this->loadModel('TaskModel');
        $_TASK->deleteTaskByProject($_POST['id']);

        $_PROJECT = $this->loadModel('ProjectModel');
        $_PROJECT->deleteProject($_POST['id']);


        die();
	}
    
}

?>
