<?php

class Task extends Controller {
	
	function index()
	{
        $template = $this->loadView('task_view');

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

        $_USER = $this->loadModel('UserModel');
        $_USER_DATA = $_USER->getAllUsers();
        $resultUser = array();
        foreach ($_USER_DATA as $key => $value) {
            array_push($resultUser, array(
                'text' => $value['fullname'], 
                'id' => $value['id'],
                'icon' => 'icon-user'
            ));
        }
        $template->set('_USER_DATA',json_encode($resultUser));

        $_PROJECT = $this->loadModel('ProjectModel');
        $_PROJECT_DATA = $_PROJECT->getAllProjects();
        $resultProject = array();
        foreach ($_PROJECT_DATA as $key => $value) {
            array_push($resultProject, array(
                'text' => $value['name'], 
                'id' => $value['id'],
                'icon' => 'icon-box'
            ));
        }
        $template->set('_PROJECT_DATA',json_encode($resultProject));

        $template->render();
	}

    function go_insert_task()
    {
       
        $_TASK = $this->loadModel('TaskModel');

        $_start_date = date('Y-m-d H:i:s',strtotime($_POST['record']['start_date']." ".$_POST['record']['start_time']));
        $_end_date = date('Y-m-d H:i:s',strtotime($_POST['record']['end_date']." ".$_POST['record']['end_time']));
        
        $id = $this->getRN('TASK');

        $arrayTaskHeader = array(
            "id" => $id,
            "name" => $_POST['record']['name'],
            "description" => $_POST['record']['description'],
            "project_id" => $_POST['record']['project_id']['id'],
            "status_id" => $_POST['record']['status_id']['id'],
            "progress" => $_POST['record']['progress'],
            "priority" => $_POST['record']['priority']['text'],
            "start_date" => $_start_date,
            "end_date" => $_end_date,
            "user_id" => Session::r('USER_ID')
        );

        $_TASK->saveTask($arrayTaskHeader);
        

        $_TASKER = $this->loadModel('TaskerModel');
        if(isset($_POST['record']['assigned'])){
            foreach ($_POST['record']['assigned'] as $key => $value) {
                $arrayTaskAssigned = array(
                    "id" => '',
                    "user_id" => $value['id'],
                    "task_id" => $id
                );
                $_TASKER->saveTasker($arrayTaskAssigned);
            }
        }

        die();
    }

    function go_edit_task()
    {
       
        $_TASK = $this->loadModel('TaskModel');

        $_start_date = date('Y-m-d H:i:s',strtotime($_POST['record']['start_date']." ".$_POST['record']['start_time']));
        $_end_date = date('Y-m-d H:i:s',strtotime($_POST['record']['end_date']." ".$_POST['record']['end_time']));
        
        $id =$_POST['record']['id'];

        $arrayTaskHeader = array(
            "id" => $id,
            "name" => $_POST['record']['name'],
            "description" => $_POST['record']['description'],
            "project_id" => $_POST['record']['project_id']['id'],
            "status_id" => $_POST['record']['status_id']['id'],
            "progress" => $_POST['record']['progress'],
            "priority" => $_POST['record']['priority']['text'],
            "start_date" => $_start_date,
            "end_date" => $_end_date,
            "user_id" => Session::r('USER_ID')
        );

        $_TASK->updateTask($arrayTaskHeader);
        
        $_TASKER = $this->loadModel('TaskerModel');
        $_TASKER->deleteTaskerByTask($id);

        if(isset($_POST['record']['assigned'])){
            foreach ($_POST['record']['assigned'] as $key => $value) {
                $arrayTaskAssigned = array(
                    "id" => '',
                    "user_id" => $value['id'],
                    "task_id" => $id
                );
                $_TASKER->saveTasker($arrayTaskAssigned);
            }
        }

        die();
    }

    function get_task_list()
    {
        $_ACT = $this->loadModel('ActivityModel');
        $_TASK = $this->loadModel('TaskModel');
        $_TASKER = $this->loadModel('TaskerModel');

        $_DATA = $_TASK->getAllTasks($_POST);

        $result['status'] = 'success';
        $result['total'] = count($_DATA);
        $result['records'] = array();
        foreach ($_DATA as $key => $value) {

            $_DATA_TASKER = $_TASKER->getTaskUser($value['id']);
            
            $_DATA_ACT_TOTAL = $_ACT->getActivityByTask($value['id']);
            $_DATA_ACT_LAST = $_ACT->getLastActivityByTask($value['id']);

            $userList = array();
            foreach ($_DATA_TASKER as $keyTkr => $valueTkr) {
                array_push($userList, $valueTkr->user['nickname']);
            }

            $userLast = '';
            foreach ($_DATA_ACT_LAST as $keyTkr2 => $valueTkr2) {
                $userLast = $valueTkr2->user['nickname'];
            }

            array_push($result['records'], array(
                'id' => $value['id'], 
                'priority' => $value['priority'], 
                'name' => $value['name'], 
                'status_id' => $value['status_id'],
                'status_name' => $value->status['name'],
                'status_icon' => $value->status['icon'],
                'project_name' => $value->project['name'],
                'progress' => $value['progress'].'%',
                'description' => substr($value['description'],0,100),
                'start_date' => date(Handler::$_DF,strtotime($value['start_date'])),
                'end_date' => date(Handler::$_DF,strtotime($value['end_date'])),
                'assigned_to' => implode(', ', $userList),
                'last_comment' => $userLast,
                'total_comment' => count($_DATA_ACT_TOTAL)
            ));
        }
        echo json_encode($result);
        die();
    }

	function get_task($id = null)
	{
        $_TASK = $this->loadModel('TaskModel');
        $_TASK_DATA = $_TASK->getTask($id);

        $_TASKER = $this->loadModel('TaskerModel');
        $_DATA_TASKER = $_TASKER->getTaskUser($_TASK_DATA['id']);

        $userList = array();
        foreach ($_DATA_TASKER as $keyTkr => $valueTkr) {
            array_push($userList, array(
                'text' => $valueTkr->user['fullname'],
                'id' => $valueTkr->user['id']
            ));
        }

        $result['status'] = 'success';
        $result['record'] = array(
            'id' => $_TASK_DATA['id'], 
            'priority' => $_TASK_DATA['priority'], 
            'name' => $_TASK_DATA['name'], 
            'status_id' => $_TASK_DATA['status_id'],
            'status_name' => $_TASK_DATA->status['name'],
            'project_id' => $_TASK_DATA->project['id'],
            'project_name' => $_TASK_DATA->project['name'],
            'progress' => $_TASK_DATA['progress'],
            'description' => $_TASK_DATA['description'],
            'start_date' => date('d-m-Y',strtotime($_TASK_DATA['start_date'])),
            'end_date' => date('d-m-Y',strtotime($_TASK_DATA['end_date'])),
            'start_time' => date('H:i',strtotime($_TASK_DATA['start_date'])),
            'end_time' => date('H:i',strtotime($_TASK_DATA['end_date'])),
            'assigned' => $userList
        );
        echo json_encode($result);
        die();
	}

    function delete_task()
    {
        $_TASKER = $this->loadModel('TaskerModel');
        $_TASKER->deleteTaskerByTask($_POST['id']);
       
        $_TASK = $this->loadModel('TaskModel');
        $_TASK->deleteTask($_POST['id']);

        die();
    }

    function preview($id = null)
    {
        if($id == null){
            die('Missing parameter');
        }
       
        $template = $this->loadView('preview_task_view');

        $_ACT = $this->loadModel('ActivityModel');
        $_ACT_DATA = $_ACT->getActivityByTask($id);

        $_TASK = $this->loadModel('TaskModel');
        $_TASK_DATA = $_TASK->getTask($id);

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
        $template->set('_AJAX',false);
        $template->render();

    }

    function update_description()
    {
       
        $_TASK = $this->loadModel('TaskModel');

        $task_id =$_POST['task_id'];
        $user_id =$_POST['user_id'];
        $description =$_POST['description'];

        if($user_id == Session::r('USER_ID')){
            $arrayTaskHeader = array(
                "id" => $task_id,
                "description" => $this->escapeString($description)
            );
            $_TASK->updateDescription($arrayTaskHeader);
        } else {
            echo 'Not authorized';
        }
        
        die();

    }
}

?>
