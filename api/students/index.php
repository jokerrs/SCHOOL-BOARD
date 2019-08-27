<?php
define('API', 1);
file_exists('../../includes/defines.php')? require '../../includes/defines.php': die('Error! Please Download Full Project');

$GetStudentData = new Fetcher($conn);
$StudentId = $_GET['student'];
if(!is_numeric($StudentId)){
    http_response_code(403);
    die();
}

print $GetStudentData->getStudentApiResult($_GET['student']);
