<?php

class ConfigModel extends Model {
	
    public function loadConfig()
    {
        $result = $this->notorm()->config[1];
        return $result;
    }
    
    public function saveConfig($array = null)
    {
        $result = $this->notorm()->config[1];
        $result->update($array);
    }

}

?>
