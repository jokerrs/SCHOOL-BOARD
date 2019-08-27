<?php

/**
 * if is app not started this will throw a error
 */
    if ( !defined('RUN')) {
        http_response_code(403);
        die();
    }


    define('DB_NAME','test');           // Database name
    define('DB_HOST', 'localhost');     // Database host
    define('DB_USER', 'root');          // Database username
    define('DB_PASS', '***********');   // Database password
