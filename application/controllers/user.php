<?php
class User extends Controller {

    function index()
    {
       

    }
    
    function logout()
    {
        Session::destroy();
        $this->redirect('/');
    }
    
    function profile()
    {
        $template = $this->loadView('user_profile');
        
        $_USER = $this->loadModel('UserModel');
        $_TASKER = $this->loadModel('TaskerModel');

        $_USER_RS = $_USER->getUser(Handler::$_LOGIN_USER_ID);
        $_TASKER_RS = $_TASKER->getUserTask(Handler::$_LOGIN_USER_ID);

        $result = array(
            'id' => Handler::$_LOGIN_USER_ID, 
            'fullname' => $_USER_RS['fullname'],
            'nickname' => $_USER_RS['nickname'],
            'email' => $_USER_RS['email'],
            'address' => $_USER_RS['address'],
            'password' => $_USER_RS['password'],
            'phone' => $_USER_RS['phone'],
            'status' => $_USER_RS['status'],
            'other' => $_USER_RS['other'],
            'profile_pic_url' => $_USER_RS['profile_pic_url']
        );

        $resultUserGroup = array(
            'id' => $_USER_RS->usergroup["id"], 
            'usergroup' => $_USER_RS->usergroup["usergroup"],
            'badge' => $_USER_RS->usergroup["badge"],
            'icon' => $_USER_RS->usergroup["icon"]
        );

        $collectorChecker = array();
        $resultProject = array();
        foreach ($_TASKER_RS as $key => $value) {
            if(!in_array($value->task['project_id'], $collectorChecker)){
                array_push($collectorChecker, $value->task['project_id']);
                array_push($resultProject, array(
                    'id' => $value['id'], 
                    'task_name' => $value->task['name'],
                    'project_name' => $value->task->project['name']
                ));
            }
        }

        if(empty( $_USER_RS['profile_pic_url'] )){
             $_USER_RS['profile_pic_url'] = 'images/profile_pic_url/none.jpg';
        }
        
        $template->set('_USER_PROFILE_PIC', $_USER_RS['profile_pic_url']);
        $template->set('_USER_PROJECT',$resultProject);
        $template->set('_USER_GROUP',$resultUserGroup);
        $template->set('_USER_DATA',json_encode($result));
        $template->render();
    }
    
    function go_edit_profile()
    {
       
        $_USER = $this->loadModel('UserModel');

        $array = array(
            'id' =>  $_POST['record']['id'], 
            'fullname' => $_POST['record']['fullname'],
            'nickname' => $_POST['record']['nickname'],
            'email' => $_POST['record']['email'],
            'address' => $_POST['record']['address'],
            'password' => $_POST['record']['password'],
            'phone' => $_POST['record']['phone'],
            'other' => $_POST['record']['other'],
            'profile_pic_url' => $_POST['record']['profile_pic_url']
        );

        $_USER->saveProfile($array);

        die();
    }

    function upload_profile_pic($userid = null)
    {
       
        if($userid == null){
            $userid = Session::r('USER_ID');
        }

        if( !empty( $_FILES['profile_pic_input'] )){

            $file = $_FILES['profile_pic_input'];
            $target_dir = ROOT_DIR."static\images\profile_pic_url\\";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }

            $data = array();
            $file_name_origin = $file['name'];
            $file_name_save = $userid;
            $ext = strtolower(pathinfo($file_name_origin, PATHINFO_EXTENSION));
            $name = $file_name_save.'.'.$ext;

            move_uploaded_file($file["tmp_name"], $target_dir.$name);
            $data['success'] = 'Y';
            $data['fullurl'] = 'images/profile_pic_url/'.$name;
            echo json_encode($data);

        }

        die();
    }

    function login()
    {

        $_USER = $this->loadModel('UserModel');

        $username = $this->escapeString($_POST['record']['username']);
        $password = $this->escapeString($_POST['record']['password']);

        $_USER_RS = $_USER->getUserLogin($username, $password);

        if(count($_USER_RS) == 1){
            echo 1;
            Session::w('LOGIN_STATUS', '1');
            foreach ($_USER_RS as $userData) {
                Session::w('USER_ID', $userData["id"]);
                Session::w('USER_NAME', $userData["fullname"]);
                Session::w('USER_EMAIL', $userData["email"]);
                Session::w('USER_GROUP', $userData->usergroup["groupcode"]);
            }
        } else {
            echo 0;
        }

        //echo Handler::$_LOGIN_STATUS;
        //echo Session::r('LOGIN_STATUS');
       // die();
        // $_DATA = $_USER->getUserLogin(3);
           
        // //THIS IS HOW TO LOOP ALL DATA
        // foreach ($_DATA as $userData) {
        //    echo $userData["fullname"] . " - " . $userData->usergroup["usergroup"] . "<br>";
        // }
        
        // pr($_DATA);

        // echo count($_USER_RS);
        // foreach ($_USER_RS as $userData) {
        //    echo $userData["fullname"] . " - " . $userData->usergroup["usergroup"] . "<br>";
        // }

        // pr($_USER_RS);
        // if(!empty($_USER_RS)){
        //     echo 'tidak kosong';
        // } else {
        //     echo 'kosong';
        // }
    
        //THIS IS HOW TO LOOP ALL DATA
        //foreach ($_USER_RS as $userData) {
        //   echo $userData["fullname"] . " - " . $userData->usergroup["usergroup"] . "<br>";
       //// }
        //echo('masuk');
        //pr($_USER_RS);
       // Session::w('LOGIN_STATUS', '1');
        //$this->redirect('../');
	}
    
    function preview($id = null)
    {
        if($id == null){
            die('Missing parameter');
        }
       
        $template = $this->loadView('preview_user_view');
        $_USER = $this->loadModel('UserModel');
        $_TASKER = $this->loadModel('TaskerModel');

        $_USER_RS = $_USER->getUser($id);
        $_TASKER_RS = $_TASKER->getUserTask($id);

        if(empty($_USER_RS)){
            die('User not found');
        } 

        $result = array(
            'id' => $id, 
            'fullname' => $_USER_RS['fullname'],
            'nickname' => $_USER_RS['nickname'],
            'email' => $_USER_RS['email'],
            'address' => $_USER_RS['address'],
            'password' => $_USER_RS['password'],
            'phone' => $_USER_RS['phone'],
            'status' => $_USER_RS['status'],
            'other' => $_USER_RS['other'],
            'profile_pic_url' => $_USER_RS['profile_pic_url']
        );

        $resultUserGroup = array(
            'id' => $_USER_RS->usergroup["id"], 
            'usergroup' => $_USER_RS->usergroup["usergroup"],
            'badge' => $_USER_RS->usergroup["badge"],
            'icon' => $_USER_RS->usergroup["icon"]
        );

        $collectorChecker = array();
        $resultProject = array();
        foreach ($_TASKER_RS as $key => $value) {
            if(!in_array($value['task_id'], $collectorChecker)){
                array_push($collectorChecker, $value['task_id']);
                array_push($resultProject, array(
                    'id' => $value['id'], 
                    'task_name' => $value->task['name'],
                    'project_name' => $value->task->project['name']
                ));
            }
        }

        if(empty( $_USER_RS['profile_pic_url'] )){
             $_USER_RS['profile_pic_url'] = 'images/profile_pic_url/none.jpg';
        }

        $template->set('_USER_PROFILE_PIC', $_USER_RS['profile_pic_url']);
        $template->set('_USER_PROJECT',$resultProject);
        $template->set('_USER_GROUP',$resultUserGroup);
        $template->set('_USER_DATA',json_encode($result));
        $template->render();

    }
}

?>
