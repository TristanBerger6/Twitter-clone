<?php

$type = 'dev';

if ($type == 'dev') {
    $baseURI = '/';
    $HOST = "localhost:3307";
    $DB_NAME = "twitter_clone";
    $USERNAME = "root";
    $PASSWORD = "root";
} else if ($type == 'prod') {
    $baseURI = '/';
    $HOST = "localhost";
    $DB_NAME = "id22362506_twclone_tb66";
    $USERNAME = "id22362506_twclone_tb66";
    $PASSWORD = "wP2cXq3tMQ@q7TVgdXBK";
}
