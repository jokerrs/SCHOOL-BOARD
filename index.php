<?php
/**
 * This is an test for Quantox
 */

session_start();

define('RUN', 1);

define('MINIMUM_PHP', '7.2.19');

version_compare(PHP_VERSION, MINIMUM_PHP, '<') and die('Please update your PHP version on '. MINIMUM_PHP .' or higher ');

define('BASE', __DIR__);


file_exists(BASE . '/includes/defines.php')? require BASE . '/includes/defines.php' : die("Error! Please Download Full Project");