<?php 

$type='dev';

if($type == 'dev'){
    $baseURI = '/Twitter_clone/';
    $HOST = "localhost:3307";
    $DB_NAME = "twitter_clone";
    $USERNAME = "root";
    $PASSWORD ="root";
}else if ($type =='prod'){
    $baseURI = '/';
    $HOST = "127.0.0.1";
    $DB_NAME = "vsffcwah_twitter_clone";
    $USERNAME = "vsffcwah_tristan";
    $PASSWORD ="AyAr22!r2Arr!p;A;G";
}




?>