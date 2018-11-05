<?php
class UserGroup extends Controller {
   
    function index()
    {
        $template = $this->loadView('user_group_view');

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

    function get_user_group_list()
    {
        $_USERGROUP = $this->loadModel('UserGroupModel');
        $_USERGROUP_DATA = $_USERGROUP->getAllUsergroup($_POST);

        $result['status'] = 'success';
        $result['total'] = count($_USERGROUP_DATA);
        $result['records'] = array();
        foreach ($_USERGROUP_DATA as $key => $value) {
            array_push($result['records'], array(
                'id' => $value['id'], 
                'groupcode' => $value['groupcode'], 
                'usergroup' => $value['usergroup'],
                'badge' => $value['badge'],
                'icon' => $value['icon']
            ));
        }
        echo json_encode($result);
        die();
    }

    function get_user_group($id = null)
    {
        $_USERGROUP = $this->loadModel('UserGroupModel');
        $_USERGROUP_DATA = $_USERGROUP->getUser($id);

        $result['status'] = 'success';
        $result['record'] = array(
            'recid' => 1, 
            'id' => $_USERGROUP_DATA['id'], 
            'groupcode' => $_USERGROUP_DATA['groupcode'], 
            'usergroup' => $_USERGROUP_DATA['usergroup'], 
            'badge' =>$_USERGROUP_DATA['badge'],
            'icon' =>$_USERGROUP_DATA['icon']
        );
        echo json_encode($result);
        die();
    }

    function go_insert_user_group()
    {
       
        $_USERGROUP = $this->loadModel('UserGroupModel');

        $array = array(
            "id" => null,
            "groupcode" => $_POST['record']['groupcode'],
            "usergroup" => $_POST['record']['usergroup'],
            "badge" => $_POST['record']['badge'],
            "icon" => $_POST['record']['icon']
        );

        $_USERGROUP->addUserGroup($array);

        die();
    }

    function go_edit_user_group()
    {
       
        $_USERGROUP = $this->loadModel('UserGroupModel');

        $array = array(
            "id" => $_POST['record']['id'],
            "groupcode" => $_POST['record']['groupcode'],
            "usergroup" => $_POST['record']['usergroup'],
            "badge" => $_POST['record']['badge'],
            "icon" => $_POST['record']['icon']
        );

        $_USERGROUP->saveUserGroup($array);

        die();
    }

    function delete_user_group()
    {
        $_USERGROUP = $this->loadModel('UserGroupModel');
        $_USERGROUP_DATA->deleteUserGroup($_POST['id']);

        die();
    }

}