<?php

class ActivityModel extends Model {
	
    public function getAllActivities($param = null)
    {
        $result = $this->notorm()->activity()->order("input_date DESC");   
        return $result;
    }

    public function getAllActivitiesLimit($limit = 10, $user_id = null, $type = 'not')
    {
        if($user_id == null){
            $result = $this->notorm()->activity()->order("input_date DESC")->limit($limit);   
        } else {
            if($type == 'not'){
                $result = $this->notorm()->activity()->where( array("not user_id" => $user_id) )->order("input_date DESC")->limit($limit); 
            } else {
                $result = $this->notorm()->activity()->where( array("user_id" => $user_id) )->order("input_date DESC")->limit($limit); 
            }
        }
        return $result;
    }

    public function getActivity($id = 0)
    {
        $result = $this->notorm()->activity[$id];
        return $result;
    }
    
    public function getActivityByTask($task_id = null)
    {
        $result = $this->notorm()->activity()->where( array("task_id" => $task_id) )->order("input_date DESC") ;
        return $result;
    }
    
    public function updateActivity($array = null)
    {
        $result = $this->notorm()->activity[$array['id']];
        $result->update($array);
    }

    public function saveActivity($array = null)
    {
        $this->notorm()->activity()->insert($array);
    }    

    public function deleteActivity($id = null)
    {
        $result = $this->notorm()->activity[$id];
        $result->delete();
    }

    public function getLastActivityByTask($task_id = null)
    {
        $result = $this->notorm()->activity()->where( array("task_id" => $task_id) )->order("input_date DESC")->limit(1) ;
        return $result;
    }

}

?>
