<?php 

    require_once("models/Model.php");

    class TweetsManager extends Model{

        public function __construct(){
            $this->getConnection();
        }
        
        // get all the tweets of this id
        public function getTweets($id_user){
            $req = $this->db->prepare('SELECT * FROM tweets WHERE id_user = ?');
            $req->execute([$id_user]);
            return $req;
        }

        public function newTweet($id_user,$content,$img){
            $req = $this->db->prepare('INSERT INTO tweets(id_user,content,img,date_hour_creation) VALUES(?,?,?,NOW())');
            $req->execute([$id_user,$content,$img]);
            return $req;
        }

        // get all the tweets of the followed people
        public function getFollowedTweets($id_user){
            $req = $this->db->prepare('SELECT *, tweets.date_hour_creation as date_order  FROM `follows` INNER JOIN `tweets` ON follows.id_followed = tweets.id_user WHERE follows.id_follower = ?');
            $req->execute([$id_user]);
            return $req;
        }
      
    

        
    }