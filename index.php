<?php 
    session_start();
    define('ROOT', str_replace('index.php','',$_SERVER['SCRIPT_FILENAME']));
    setlocale(LC_TIME,'fr');
    require_once(ROOT.'php/functions.php');
    // On appelle le modèle et le contrôleur principaux
   
    


    try{
        if(isset($_GET['page'])){

            $page = htmlspecialchars($_GET['page']);
            switch($page){
                case 'signin':
                    require_once(ROOT.'controllers/signin.php');
                    break; 
                case 'signup':
                    require_once(ROOT.'controllers/signup.php');
                    break;
                case 'home':
                    require_once(ROOT.'controllers/home.php');
                    break;
                case 'profile':
                    require_once(ROOT.'controllers/profile.php');
                    break;
                case 'follow':
                    require_once(ROOT.'controllers/follow.php');
                    break;
                case 'settings':
                    require_once(ROOT.'controllers/settings.php');
                    break;
                case 'logout':
                    require_once(ROOT.'controllers/logout.php');
                    break;
                case 'status':
                    require_once(ROOT.'controllers/status.php');
                    break;
                default :
                    http_response_code(404);
                    die("Erreur : La page recherchée n'existe pas");
                    break;

            }
        }else if (isset($_GET['handle'])){
            $handler = htmlspecialchars($_GET['handle']);
            switch($handler){
                case 'follow':
                    require_once(ROOT.'controllers/handlers/handleFollow.php');
                    break; 
                case 'profile':
                    require_once(ROOT.'controllers/handlers/handleProfile.php');
                    break;
                case 'tweet':
                    require_once(ROOT.'controllers/handlers/handleTweet.php');
                    break;
                case 'delete':
                    require_once(ROOT.'controllers/handlers/handleDelete.php');
                    break;
                case 'like':
                    require_once(ROOT.'controllers/handlers/handleLike.php');
                    break;  
                case 'retweet':
                    require_once(ROOT.'controllers/handlers/handleRetweet.php');
                    break;   
                case 'quote':
                    require_once(ROOT.'controllers/handlers/handleQuote.php');
                    break;  
                default :
                    http_response_code(404);
                    die("Erreur : La page recherchée n'existe pas");
                    break;
                }
            
        }else{
            require_once(ROOT.'controllers/starting.php');
        }
    }catch(Exception $e){
        echo 'Erreur : ' .$e->getMessage();
    }
   
   

  
?>