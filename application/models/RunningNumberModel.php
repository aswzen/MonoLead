<?php

class RunningNumberModel extends Model {
	
    public function generateRunningNumber($code = null)
    {
        $result = $this->notorm()->runningnumber()->where( array("numbercode" => $code) );
        foreach ($result as $value) {
            return $value;
        }
    }

    public function updateRunningNumber($array = null)
    {
        $result = $this->notorm()->runningnumber()->where( array("numbercode" => $array['numbercode']) );
        $result->update($array);
    }
}

?>
