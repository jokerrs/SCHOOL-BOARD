<?php
function _isRun(){
    if ( !defined('RUN') && !defined('API') ) {
        http_response_code(403);
        die();
    }
}
    _isRun();

    define('DB_NAME','test');           // Database name
    define('DB_HOST', 'localhost');     // Database host
    define('DB_USER', 'root');          // Database username
    define('DB_PASS', 'Nemanjabg44');   // Database password
    define('BASE_DIR', __DIR__.'/../');    // Include base dir

    file_exists(BASE_DIR . 'includes/connection.php')? require BASE_DIR . 'includes/connection.php' : die("Error! Please Download Full Project");
    file_exists(BASE_DIR . 'class/Students.php')? require BASE_DIR . 'class/Students.php' : die("Error! Please Download Full Project");
    file_exists(BASE_DIR . 'class/Fetcher.php')? require BASE_DIR . 'class/Fetcher.php' : die("Error! Please Download Full Project");
