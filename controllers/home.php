<?php 

if (isset($_SESSION['id'])){
    require_once(ROOT.'views/homeView.php');
}else{
    header('Location: index.php');
}
    
