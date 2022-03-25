<?php 

    require_once("models/Model.php");

    class RetweetsManager extends Model{

        public function __construct(){
            $this->getConnection();
        }
        
 
        public function getRetweetsOfTweet($id_tweet){
            $req = $this->db->prepare('SELECT * FROM retweets WHERE id_original_tweet = ?');
            $req->execute([$id_tweet]);
            return $req;
        }
        public function getUserRetweets($id_user){
            $req = $this->db->prepare('SELECT * FROM retweets WHERE id_user = ?');
            $req->execute([$id_user]);
            return $req;
        }
        public function isRetweeted($id_user,$id_tweet){
            $req = $this->db->prepare('SELECT * FROM retweets WHERE id_user = ? AND id_original_tweet = ?');
            $req->execute([$id_user,$id_tweet]);
            return $req;
        }
        public function retweet($id_user, $id_tweet){
            $req = $this->db->prepare('INSERT INTO retweets(id_user,id_original_tweet,date_hour_creation) VALUES(?,?,NOW())');
            $req->execute([$id_user,$id_tweet]);
            return $req;
        }
        public function unretweet($id_user, $id_tweet){
            $req = $this->db->prepare('DELETE FROM retweets WHERE id_user = ? AND id_original_tweet = ?');
            $req->execute([$id_user,$id_tweet]);
            return $req;
        }
        
    }