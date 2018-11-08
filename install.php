<head>
    <title>MonoLead - Setup</title>
</head>
<style type="text/css">
    body{
        font: 14px Tahoma;
    }
    .header,.footer{
        width:600px; 
        margin:0 auto;
        border:1px solid #eee;
        padding:10px;
        background-color: #EAEAEA;
        height: 25px;
    }
    .content{
        width:600px; 
        margin:0 auto;
        border:1px solid #eee;
        padding:10px;
        background-color: #EAEAEA;
        height: auto;
    }
    .info{
        font-size: 10px;
    }
    input{
        padding: .5em .6em;
        display: inline-block;
        border: 1px solid #ccc;
        box-shadow: inset 0 1px 3px #ddd;
        border-radius: 4px;
        vertical-align: middle;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    input[type="submit"]:active{
        background-color: white;
    }
</style>
<body>


    <div class="header">
        <b>MonoLead Setup</b>
    </div>
    <div class="content">
    <?php 
        if(isset($_POST['base_url'])){
            $cf = fopen("application/config/config.php", "w") or die('Cannot write! make sure the CHMOD is 777');
            $txt = "<?php\n\n";
            $txt.= "\$config['base_url'] = '".$_POST['base_url']."';\n\n";
            $txt.= "\$config['default_controller'] = 'main';\n";
            $txt.= "\$config['error_controller'] = 'main';\n\n";
            $txt.= "\$config['db_host'] = '".$_POST['database_host']."';\n";
            $txt.= "\$config['db_name'] = '".$_POST['database_name']."';\n";
            $txt.= "\$config['db_username'] = '".$_POST['database_username']."';\n";
            $txt.= "\$config['db_password'] = '".$_POST['database_password']."';\n\n";
            $txt.= "define('version', 'Alpha 1.0');\n\n";
            $txt.= "?>\n";
            fwrite($cf, $txt);

            error_reporting(0);
            // Create connection
            $conn = mysqli_connect($_POST['database_host'], $_POST['database_username'], $_POST['database_password'],$_POST['database_name']);

            // Check connection
            if (mysqli_connect_error()) {
                die("Connection failed (bacause of server address/database name/database username/database password) please check your database properties: " . mysqli_connect_error().'</br>');
            } else {
                echo "-- Database Server - Connected successfully.</br>";
                echo "-- Database - Connected successfully.</br>";

                $query = file_get_contents('_CREATE.sql');
                $query.= "INSERT INTO `config` (`id`, `site_name`, `maintenance_mode`, `additional_footer`, `datetime_format`) VALUES (1, '".$_POST['site_name']."', 'No', '".$_POST['site_footer']."', '".$_POST['date_format']."');";
                $query.= "INSERT INTO `user` (`id`, `fullname`, `nickname`, `email`, `phone`, `address`, `other`, `status`, `password`, `profile_pic_url`, `usergroup_id`) VALUES ('SR000', 'Administrator', 'Admin', '".$_POST['admin_email']."', '0', '-', '-', 'Active', '".$_POST['admin_password']."', 'images/profile_pic_url/SR000.jpg', 1);";
                if($result = $conn->multi_query($query)){
                    echo "-- Database - Table created.</br>";
                    echo "-- Database - Config created.</br>";
                    echo "-- Database - User Admin created.</br></br>";
                    echo "Setup Success <a href='/index.php''>Click here to proceed</a></br></br>";
                } else {
                    die('1. There was an error running the query [' . $conn->error . ']');
                }               
            }
            die();
        }

    ?>
    <form action="#" method="POST">
        <table style="width:100%">
            <tr>
                <th colspan="3">General</th>
            </tr>
            <tr>
                <td style="width:170px">Base Url</td>
                <td>:</td>
                <td><input type="text" name="base_url" style="width:200px" value="<?php echo preg_replace('/install\.php/','',"http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>"/> <span class="info">*skip it if you don't know</span></td>
            </tr>
            <tr>
                <td>Site Name</td>
                <td>:</td>
                <td><input type="text" name="site_name" style="width:250px" value="MonoLead - Project Management System"/> <span class="info">*will appear on every top page</span></td>
            </tr>
            <tr>
                <td >Site Footer</td>
                <td>:</td>
                <td><input type="text" name="site_footer" style="width:250px" value="(c) MonoLead 2015"/> <span class="info">*will appear on every bottom page</span></td>
            </tr>
            <tr>
                <td >Date Format</td>
                <td>:</td>
                <td><input type="text" name="date_format" style="width:100px" value="d F Y H:i"/> <span class="info">*date time format (based on PHP)</span></td>
            </tr>
            <tr>
                <th colspan="3">Database</th>
            </tr>
            <tr>
                <td>Database Address/Host</td>
                <td>:</td>
                <td><input type="text" name="database_host" style="width:250px" value="localhost"/> <span class="info">*your database address</span></td>
            </tr>
            <tr>
                <td>Database Name</td>
                <td>:</td>
                <td><input type="text" name="database_name" style="width:250px" value="monolead"/> <span class="info">*your database username</span></td>
            </tr>
            <tr>
                <td>Database Username</td>
                <td>:</td>
                <td><input type="text" name="database_username" style="width:250px" value="root"/> <span class="info">*your database name</span></td>
            </tr>
            <tr>
                <td>Database Password</td>
                <td>:</td>
                <td><input type="text" name="database_password" style="width:250px" value=""/> <span class="info">*your database password</span></td>
            </tr>
            <tr>
                <th colspan="3">Administration</th>
            </tr>
            <tr>
                <td>Admin Email</td>
                <td>:</td>
                <td><input type="text" name="admin_email" style="width:250px" value=""/></td>
            </tr>
            <tr>
                <td>Admin Password</td>
                <td>:</td>
                <td><input type="text" name="admin_password" style="width:250px" value=""/></td>
            </tr>
        </table>
    </div>
    <div class="footer">
        <input type="submit" value="Submit Data" style="float:right" onClick="return confirm('Are you sure to submit?')">
    </div>
    </form>
</body>