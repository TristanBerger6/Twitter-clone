<?php 

    require_once("models/Model.php");

    class CommentsManager extends Model{

        public function __construct(){
            $this->getConnection();
        }
        
        // get all comments of a tweet
        public function getTweetComments($id_tweet){
            $req = $this->db->prepare('SELECT * FROM comments WHERE id_tweet = ?');
            $req->execute([$id_tweet]);
            return $req;
        }
        
    }