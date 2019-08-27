<?php
/**
 * This is a test for Quantox
 */

define('RUN', 1);

define('MINIMUM_PHP', '7.2.19');

version_compare(PHP_VERSION, MINIMUM_PHP, '<') and die('Please update your PHP version on '. MINIMUM_PHP .' or higher ');

define('BASE', __DIR__);


file_exists(BASE . '/includes/defines.php')? require BASE . '/includes/defines.php' : die("Error! Please Download Full Project");
file_exists(BASE . '/includes/connection.php')? require BASE . '/includes/connection.php' : die("Error! Please Download Full Project");
file_exists(BASE . '/class/Students.php')? require BASE . '/class/Students.php' : die("Error! Please Download Full Project");
file_exists(BASE . '/class/Fetcher.php')? require BASE . '/class/Fetcher.php' : die("Error! Please Download Full Project");

$GetStudentData = new Fetcher($conn);
$StudentId = $_GET['student'];
if(!is_numeric($StudentId)){
    http_response_code(403);
    die();
}

print $GetStudentData->getStudentResult($StudentId);
