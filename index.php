<?php 
    session_start();
    $baseURI = '/Twitter_clone/';
    setlocale(LC_TIME,'fr');
    require_once('php/functions.php');
    require_once("php/utils.php");

    try{
        if(isset($_GET['page'])){

            $page = htmlspecialchars($_GET['page']);
            switch($page){
                case 'signin':
                    require_once('controllers/signin.php');
                    break; 
                case 'signup':
                    require_once('controllers/signup.php');
                    break;
                case 'home':
                    require_once('controllers/home.php');
                    break;
                case 'profile':
                    require_once('controllers/profile.php');
                    break;
                case 'follow':
                    require_once('controllers/follow.php');
                    break;
                case 'settings':
                    require_once('controllers/settings.php');
                    break;
                case 'logout':
                    require_once('controllers/logout.php');
                    break;
                case 'status':
                    require_once('controllers/status.php');
                    break;
                case 'notifs':
                    require_once('controllers/notifs.php');
                    break;
                case 'explore':
                    require_once('controllers/explore.php');
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
                    require_once('controllers/handlers/handleFollow.php');
                    break; 
                case 'profile':
                    require_once('controllers/handlers/handleProfile.php');
                    break;
                case 'tweet':
                    require_once('controllers/handlers/handleTweet.php');
                    break;
                case 'delete':
                    require_once('controllers/handlers/handleDelete.php');
                    break;
                case 'like':
                    require_once('controllers/handlers/handleLike.php');
                    break;  
                case 'retweet':
                    require_once('controllers/handlers/handleRetweet.php');
                    break;   
                case 'quote':
                    require_once('controllers/handlers/handleQuote.php');
                    break;  
                case 'comment':
                    require_once('controllers/handlers/handleComment.php');
                    break; 
                case 'mention':
                    require_once('controllers/handlers/handleMention.php');
                    break; 
                default :
                    http_response_code(404);
                    die("Erreur : La page recherchée n'existe pas");
                    break;
                }
            
        }else{
            require_once('controllers/starting.php');
        }
    }catch(Exception $e){
        echo 'Erreur : ' .$e->getMessage();
    }
   
   

  
?>