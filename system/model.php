<?php

include "notorm/NotORM.php";

class Model {

    private $connection;

    public function __construct()
    {
            global $config;

            $dsn = 'mysql:dbname='.$config['db_name'].';host='.$config['db_host'];
            $user = $config['db_username'];
            $password = $config['db_password'];

            try {
                $ormDriver = new PDO($dsn, $user, $password); 
//                $ormDriver->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
//                $cache = new NotORM_Cache_File("notorm.cache");
            } catch (PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
                die();
            }

            $structure = new NotORM_Structure_Convention(
                $primary = "id", // id_$table
                $foreign = "%s_id", // id_$table
                $table = "%s", // {$table}s
                $prefix = "" // wp_$table
            );
            $this->connection = new NotORM($ormDriver, $structure);

    }

    public function notorm()
    {
        return $this->connection;
    }
            
}
?>
