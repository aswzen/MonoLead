<?php

class TaskModel extends Model {
	
    public function getAllTasks($param = null)
    {
         if(!empty($param['sort'])){
            if($param['sort'][0]['field'] == 'status_name'){
               $param['sort'][0]['field'] = 'status_id';
            }
            if($param['sort'][0]['field'] == 'project_name'){
               $param['sort'][0]['field'] = 'project_id';
            }
            $result = $this->notorm()->task()->order($param['sort'][0]['field']." ".$param['sort'][0]['direction']);   
        } else {
            $result = $this->notorm()->task(); 
        }
        return $result;
    }
    
    public function getTask($id = null)
    {
        $result = $this->notorm()->task[$id];
        return $result;
    }

    public function saveTask($array = null)
    {
        $this->notorm()->task()->insert($array);
    }

    public function updateTask($array = null)
    {
        $result = $this->notorm()->task[$array['id']];
        $result->update($array);
    }

    public function deleteTask($id = null)
    {
        $result = $this->notorm()->task[$id];
        $result->delete();
    }

    public function deleteTaskByProject($id = null)
    {

        $result = $this->notorm()->task()->where( array("project_id" => $id) );

        foreach ($result as $key => $value) {
            $result1 = $this->notorm()->tasker()->where( array("task_id" => $value['id']));
            $result1->delete();
        }

        $result->delete();
  
    }

    public function updateDescription($array = null)
    {
        $result = $this->notorm()->task[$array['id']];
        $result->update($array);
    }
}

?>
