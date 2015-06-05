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
    
}

?>
