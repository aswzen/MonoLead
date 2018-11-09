<?php
class User extends Controller {
   
    function index()
    {
        $template = $this->loadView('user_view');

        $_USERGROUP = $this->loadModel('UserGroupModel');
        $_USERGROUP_DATA = $_USERGROUP->getAllUsergroup();

        $result = array();
        foreach ($_USERGROUP_DATA as $key => $value) {
            array_push($result, array(
                'text' => $value['usergroup'], 
                'id' => $value['id'],
                'icon' => $value['icon']
            ));
        }

        $template->set('_USERGROUP_DATA',json_encode($result));

        $template->render();
    }

    function get_user_list()
    {
        $_USER = $this->loadModel('UserModel');
        $_DATA = $_USER->getAllUsers($_POST);

        $result['status'] = 'success';
        $result['total'] = count($_DATA);
        $result['records'] = array();
        foreach ($_DATA as $key => $value) {
            array_push($result['records'], array(
                'id' => $value['id'], 
                'fullname' => $value['fullname'], 
                'nickname' => $value['nickname'],
                'email' => $value['email'],
                'phone' => $value['phone'],
                'status' => $value['status'],
                'password' => $value['password'],
                'usergroup_id' => $value['usergroup_id'],
                'usergroup_name' => $value->usergroup['usergroup'],
                'usergroup_icon' => $value->usergroup['icon']
            ));
        }
        echo json_encode($result);
        die();
    }

    function get_user($id = null)
    {
       
        $_USER = $this->loadModel('UserModel');
        $_USER_DATA = $_USER->getUser($id);

        $result['status'] = 'success';
        $result['record'] = array(
            'recid' => 1, 
            'id' => $_USER_DATA['id'], 
            'fullname' => $_USER_DATA['fullname'], 
            'nickname' => $_USER_DATA['nickname'], 
            'email' =>$_USER_DATA['email'],
            'phone' => $_USER_DATA['phone'],
            'password' => $_USER_DATA['password'],
            'usergroup_id' => $_USER_DATA['usergroup_id'],
            'status' => $_USER_DATA['status'],
            'address' => $_USER_DATA['address']
        );
        echo json_encode($result);
        die();
    }

    function go_insert_user()
    {
       
        $_USER = $this->loadModel('UserModel');

        $array = array(
            "id" => $this->getRN('USER'),
            "fullname" => $_POST['record']['fullname'],
            "nickname" => $_POST['record']['nickname'],
            "email" => $_POST['record']['email'],
            "phone" => $_POST['record']['phone'],
            "address" => $_POST['record']['address'],
            "status" => $_POST['record']['status']['id'],
            "usergroup_id" => $_POST['record']['usergroup_id']['id'],
            "password" => $_POST['record']['password']
        );

        $_USER->addUser($array);

        die();
    }

    function register()
    {
        $_USER = $this->loadModel('UserModel');

        $array = array(
            "id" => $this->getRN('USER'),
            "fullname" => $_POST['record']['fullname'],
            "nickname" => $_POST['record']['nickname'],
            "email" => $_POST['record']['email'],
            "phone" => '',
            "address" => '',
            "status" => 'Nonactive',
            "usergroup_id" => '4',
            "password" => $_POST['record']['password']
        );

        $_USER->addUser($array);

        die();
    }

    function go_edit_user()
    {
       
        $_USER = $this->loadModel('UserModel');

        $array = array(
            "id" => $_POST['record']['id'],
            "fullname" => $_POST['record']['fullname'],
            "nickname" => $_POST['record']['nickname'],
            "email" => $_POST['record']['email'],
            "phone" => $_POST['record']['phone'],
            "address" => $_POST['record']['address'],
            "status" => $_POST['record']['status']['id'],
            "usergroup_id" => $_POST['record']['usergroup_id']['id'],
            "password" => $_POST['record']['password']
        );

        $_USER->saveUser($array);

        die();
    }

    function delete_user()
    {
        $_USER = $this->loadModel('UserModel');
        $_USER->deleteUser($_POST['id']);

        die();
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
            $target_dir = ROOT_DIR."static/images/profile_pic_url/";
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
            foreach ($_USER_RS as $userData) {
                if($userData["status"] == 'Nonactive'){
                    echo 2;
                    die();
                }
                Session::w('LOGIN_STATUS', '1');
                echo 1;
                Session::w('USER_ID', $userData["id"]);
                Session::w('USER_NAME', $userData["fullname"]);
                Session::w('USER_EMAIL', $userData["email"]);
                Session::w('USER_GROUP', $userData->usergroup["groupcode"]);
            }
        } else {
            echo 0;
        }

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
