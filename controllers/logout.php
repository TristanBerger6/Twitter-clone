<?php
$SESSION = [];
session_destroy();

header('Location: '.$baseURI.'');
?>