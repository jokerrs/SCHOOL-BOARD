<?php
if(isset($_POST['dbname'], $_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass'])){
    try {
        $conn = new PDO('mysql:host='.$_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        try{
            $dbname = $_POST['dbname'];
            $dbname = "`".str_replace("`","``",$dbname)."`";
            if(!$conn->exec("CREATE DATABASE IF NOT EXISTS $dbname DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")){
                http_response_code(403);
                die();
            }
            if ( !mkdir('includes', 0777) && !is_dir('includes') ) {
                http_response_code(500);
                die();
            }
            $conn->exec("use $dbname");
            $DB_NAME = $_POST['dbname'];
            $DB_HOST = $_POST['dbhost'];
            $DB_USER = $_POST['dbuser'];
            $DB_PASS = $_POST['dbpass'];
            try{
                $CreatingDefines = fopen('includes/defines.php', 'wb') or (http_response_code(500) and die());
                $CreatingConnection = fopen('includes/connection.php', 'wb') or (http_response_code(500) and die());

                // Global php
                $Global_php = "<?php\n";
                $Global_php .= "\n";
                $Global_php .= "/**\n";
                $Global_php .= "* if is app not started this will throw a error\n";
                $Global_php .= "*/\n";
                $Global_php .= "    if ( !defined('RUN')) {\n";
                $Global_php .= "        http_response_code(403);\n";
                $Global_php .= "        die();\n";
                $Global_php .= "    }\n";
                $Global_php .= "\n";
                $Global_php .= "\n";
                // Configuration php
                $Connection_php = "try {\n";
                $Connection_php .= '    $conn = new PDO(\'mysql:host=\'.DB_HOST.\';dbname=\'.DB_NAME, DB_USER, DB_PASS);'."\n";
                $Connection_php .= '    $conn-> exec(\'set names utf8\');'."\n";
                $Connection_php .= '    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);'."\n";
                $Connection_php .= '} catch (PDOException $e) {'."\n";
                $Connection_php .= '    die(\'Error: \' . $e->getMessage() . \'<br/>\');'."\n";
                $Connection_php .= '}'."\n";


                // Defines php
                $Defines_php = "    define('DB_NAME', '$DB_NAME');           // Database name\n";
                $Defines_php .= "    define('DB_HOST', '$DB_HOST');           // Database host\n";
                $Defines_php .= "    define('DB_USER', '$DB_USER');           // Database username\n";
                $Defines_php .= "    define('DB_PASS', '$DB_PASS');           // Database password\n";
                fwrite($CreatingDefines, $Global_php.$Defines_php) or (http_response_code(500) and die());
                fwrite($CreatingConnection, $Global_php.$Connection_php) or (http_response_code(500) and die());
                chmod('includes/connection.php', 0755);
                chmod('includes/defines.php', 0755);
                chmod('includes/', 0755);
                $DataBaseFile = file_get_contents('installation/test.sql');
                $conn->exec($DataBaseFile);
                http_response_code(200);
            }catch(PDOException $e){
                http_response_code(500);
            }
        } catch(PDOException $e) {
            http_response_code(404);
        }
    } catch (PDOException $e) {
        http_response_code(405);
    }
    die();
}
?>

<!DOCTYPE html>
<html lang="rs">

<head>
    <title>Instalacija</title>
    <link rel="stylesheet" href="installation/css/bootstrap.min.css" />
</head>
<style type="text/css">
    .bar {
        width: 100%;
        height: 20px;
        border: 1px solid #2980b9;
        border-radius: 3px;
        background-image:
                repeating-linear-gradient(
                        -45deg,
                        #2980b9,
                        #2980b9 11px,
                        #eee 10px,
                        #eee 20px /* determines size */
                );
        background-size: 28px 28px;
        animation: move .5s linear infinite;
    }

    @keyframes move {
        0% {
            background-position: 0 0;
        }
        100% {
            background-position: 28px 0;
        }
    }

</style>
<body>
<div class="container">
    <div class="row  pt-5">
        <div class="col-md-3"></div>
        <div class="col-md-6 p-4 alert alert-info">
                <span id="notification">
                </span>
            <form id="installation">
                <div class="form-group">
                    <label for="dbname">DatabaseName</label>
                    <input type="text" class="form-control" id="dbname" name="dbname" placeholder="test">
                </div>
                <div class="form-group">
                    <label for="dbhost">Database Host</label>
                    <input type="text" class="form-control" id="dbhost" name="dbhost" placeholder="localhost">
                </div>
                <div class="form-group">
                    <label for="dbuser">Database Username</label>
                    <input type="text" class="form-control" id="dbuser" name="dbuser" placeholder="test">
                </div>
                <div class="form-group">
                    <label for="dbpass">Database Password</label>
                    <input type="password" class="form-control" name="dbpass" id="dbpass" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
</body>
<script type="application/javascript" src="installation/js/jquery.min.js"></script>
<script type="application/javascript" src="installation/js/bootstrap.min.js"></script>
<script type="application/javascript" src="installation/js/installation.js"></script>

</html>