<?php 

    require_once("models/Model.php");

    class LikesManager extends Model{

        public function __construct(){
            $this->getConnection();
        }
        
        // get all Likes of a tweet
        public function getTweetLikes($id_tweet){
            $req = $this->db->prepare('SELECT * FROM likes WHERE id_tweet = ?');
            $req->execute([$id_tweet]);
            return $req;
        }
        public function isLiked($id_user, $id_tweet){
            $req = $this->db->prepare('SELECT * FROM likes WHERE id_user = ? AND id_tweet = ?');
            $req->execute([$id_user,$id_tweet]);
            return $req;
        }
        public function likeTweet($id_user, $id_tweet){
            $req = $this->db->prepare('INSERT INTO likes(id_user,id_tweet,id_comment,id_reply,date_hour_creation) VALUES(?,?,0,0,NOW())');
            $req->execute([$id_user,$id_tweet]);
            return $req;
        }
        public function unlikeTweet($id_user, $id_tweet){
            $req = $this->db->prepare('DELETE FROM likes WHERE id_user = ? AND id_tweet = ?');
            $req->execute([$id_user,$id_tweet]);
            return $req;
        }
        
    }