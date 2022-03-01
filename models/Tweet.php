<?php 

    require_once("models/Model.php");

    class Tweet extends Model{

        public function __construct(){
            $this->getConnection();
        }
        
        // get all the tweets of this id
        public function getTweets($id_user){
            $req = $this->db->prepare('SELECT * FROM tweets WHERE id_user = ?');
            $req->execute([$id_user]);
            return $req;
        }

        
    }