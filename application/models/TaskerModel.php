<?php

class TaskerModel extends Model {
	
    public function getAllTaskers()
    {
        $result = $this->notorm()->tasker();
        return $result;
    }
    
    public function getTasker($id = null)
    {
        $result = $this->notorm()->tasker[$id];
        return $result;
    }

    public function saveTasker($array = null)
    {
        if(empty($array['id'])){
            $this->notorm()->tasker()->insert($array);
        } else {
            $result = $this->notorm()->tasker[$array['id']];
            $result->update($array);
        }
    }

    public function deleteTasker($id = null)
    {
        $result = $this->notorm()->tasker[$id];
        $result->delete();
    }

    public function getUserTask($id = null)
    {
        $result = $this->notorm()->tasker()->where( array("user_id" => $id) );
        return $result;
    }

    public function getTaskUser($id = null)
    {
        $result = $this->notorm()->tasker()->where( array("task_id" => $id) );
        return $result;
    }

    public function deleteTaskerByTask($id = null)
    {
        $result = $this->notorm()->tasker()->where( array("task_id" => $id));
        $result->delete();
    }
}

?>
