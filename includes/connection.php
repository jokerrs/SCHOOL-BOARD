<?php

/**
 * if is app not started this will throw a error
 */
if ( !defined('RUN')) {
    http_response_code(403);
    die();
}



try {
    $conn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $conn-> exec('set names utf8');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Error: ' . $e->getMessage() . '<br/>');
}