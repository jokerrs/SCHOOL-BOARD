<?php
/**
 * School board app
 */

define('RUN', 1);

define('MINIMUM_PHP', '7.2.19');

version_compare(PHP_VERSION, MINIMUM_PHP, '<') and die('Please update your PHP version on '. MINIMUM_PHP .' or higher ');

define('BASE', __DIR__);

if(!is_dir('includes')){
    require BASE . '/installation/index.php';
    die();
}

$RequiredFiles = array(
    '/includes/defines.php',        // Database configuration
    '/includes/connection.php',     // Database connection
    '/class/Students.php',          // Class Students
    '/class/School.php',            // Class School
    '/class/Fetcher.php'            // Class Fetcher
);

foreach ($RequiredFiles as $file) {
    $path = BASE . $file;
    file_exists($path) ? require $path : die('Error! Please Download Full Project');

}

if( isset($_GET['student']) && is_numeric($_GET['student']) ){

    $StudentId = $_GET['student'];

    $GetStudentData = new Fetcher($conn);
    print $GetStudentData->getStudentResult($StudentId);
    die();
}
http_response_code(403);
die();

