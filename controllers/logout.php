<?php
$SESSION = [];
session_destroy();

header('Location: index.php');
?>