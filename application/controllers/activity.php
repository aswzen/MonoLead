<?php

class Activity extends Controller {

    function insert_activity($task_id = null)
    {
        $_ACT = $this->loadModel('ActivityModel');
        $array = array(
            "id" => '',
            "task_id" => $task_id,
            "comment" => $_POST['record']['message'],
            "visible" => 'Y',
            "progress" => $_POST['record']['progress'],
            "status_id" => $_POST['record']['status_id']['id'],
            "input_date" => date('Y-m-d H:i:s'),
            "user_id" => Session::r('USER_ID')
        );
        $_ACT->saveActivity($array);

        $_TASK = $this->loadModel('TaskModel');
     	$arrayTaskHeader = array(
            "id" => $task_id,
            "status_id" => $_POST['record']['status_id']['id'],
            "progress" => $_POST['record']['progress'],
            "update_date" => date('Y-m-d H:i:s')
        );
        $_TASK->updateTask($arrayTaskHeader);
        
        die();
    }

    function get_activity($activity_id = null)
    {
        $_ACT = $this->loadModel('ActivityModel');
        $_ACT_DATA = $_ACT->getActivity($activity_id);

        $result['status'] = 'success';
        $result['record'] = array(
            'id' => $_ACT_DATA['id'], 
            'progress' => $_ACT_DATA['progress'], 
            'message' => $_ACT_DATA['comment'], 
            'status_id' => $_ACT_DATA['status_id']
        );
        echo json_encode($result);
        die();
    }

    function go_edit_activity()
    {
        $_ACT = $this->loadModel('ActivityModel');
  
        $id = $_POST['record']['id'];

        $arrayActHeader = array(
            "id" => $id,
            "progress" => $_POST['record']['progress'],
            "comment" => $_POST['record']['message'],
            "status_id" => $_POST['record']['status_id']['id']
        );

        $_ACT->updateActivity($arrayActHeader);

        $_ACT_DATA_ONE = $_ACT->getActivity($id);
        $_ACT_DATA_TASK = $_ACT->getLastActivityByTask($_ACT_DATA_ONE['task_id']);

        foreach ($_ACT_DATA_TASK as $key => $value) {
            if($value['id'] == $id){
                $_TASK = $this->loadModel('TaskModel');
                $arrayTaskHeader = array(
                    "id" => $_ACT_DATA_ONE['task_id'],
                    "status_id" => $_POST['record']['status_id']['id'],
                    "progress" => $_POST['record']['progress'],
                    "update_date" => date('Y-m-d H:i:s')
                );
                $_TASK->updateTask($arrayTaskHeader);
            }
        }

        die();
    }

    function delete_activity()
    {
        $_ACT = $this->loadModel('ActivityModel');
        $_TASK = $this->loadModel('TaskModel');
        
        $id = $_POST['id'];

        $_ACT_DATA_ONE = $_ACT->getActivity($id);
        $_IS_LAST_ACTIVITY = $_ACT->getLastActivityByTask($_ACT_DATA_ONE['task_id']);
       
        foreach ($_IS_LAST_ACTIVITY as $key => $value) {
            if($value['id'] == $id){
                $_ACT->deleteActivity($id);

                $_GET_LAST_ACTIVITY = $_ACT->getLastActivityByTask($_ACT_DATA_ONE['task_id']);
                foreach ($_GET_LAST_ACTIVITY as $key2 => $value2) {
                    $arrayTaskHeader = array(
                        "id" => $_ACT_DATA_ONE['task_id'],
                        "status_id" => $value2['status_id'],
                        "progress" => $value2['progress'],
                        "update_date" => date('Y-m-d H:i:s')
                    );
                    $_TASK->updateTask($arrayTaskHeader);
                }
            } else {
                $_ACT->deleteActivity($id);
            }
        }

        die();
    }
}