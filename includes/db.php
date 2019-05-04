<?php 

ob_start(); 

$db['db_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_pass'] = '';
$db['db_name'] = 'cms';

foreach ($db as $key => $val) {
    define(strtoupper($key), $val);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if (!$connection) {
    exit('Unable to connect to the database (' . mysqli_error($connection) . ')');
}

 ?>