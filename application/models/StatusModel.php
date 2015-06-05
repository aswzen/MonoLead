<?php

class StatusModel extends Model {
	
    public function getAllStatuses()
    {
        $result = $this->notorm()->status();
        return $result;
    }
    
}

?>
