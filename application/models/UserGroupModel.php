<?php

class UserGroupModel extends Model {
	
    public function getAllUsergroup()
    {
        $result = $this->notorm()->usergroup();
        return $result;
    }
    
}

?>
