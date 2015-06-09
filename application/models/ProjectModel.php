<?php

class ProjectModel extends Model {
	
    public function getAllProjects($param = null)
    {
        if(!empty($param['sort'])){
            if($param['sort'][0]['field'] == 'status_name'){
               $param['sort'][0]['field'] = 'status_id';
            }
            $result = $this->notorm()->project()->order($param['sort'][0]['field']." ".$param['sort'][0]['direction']);   
        } else {
            $result = $this->notorm()->project();   
        }
        return $result;
    }
    
    public function getProject($id = null)
    {
        $result = $this->notorm()->project[$id];
        return $result;
    }

    public function saveProject($array = null)
    {
        if(empty($array['id'])){
            $this->notorm()->project()->insert($array);
        } else {
            $result = $this->notorm()->project[$array['id']];
            $result->update($array);
        }
    }

    public function addProject($array = null)
    {
        $this->notorm()->project()->insert($array);
    }

    public function deleteProject($id = null)
    {
        $result = $this->notorm()->project[$id];
        $result->delete();
    }
    
    public function getAllProjectsByUser($user_id = null)
    {
        $result = $this->notorm()->tasker()->where( array("user_id" => $user_id) ) ;
        $listProjectId = array();
        $listProject = array();
        foreach ($result as $key => $value) {
            $result2 = $this->notorm()->project()->where( array("project_id" => $value->task['project_id']) ) ;
            if(!in_array($value->task['project_id'], $listProjectId)){
                array_push($listProjectId, $value->task['project_id']);
                array_push($listProject, $value->task->project);
            }
        
        }

        return $listProject;
    }
    
}

?>
