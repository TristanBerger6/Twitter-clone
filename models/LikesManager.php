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
        // test if a user liked a tweet
        public function isLiked($id_user, $id_tweet){
            $req = $this->db->prepare('SELECT * FROM likes WHERE id_user = ? AND id_tweet = ?');
            $req->execute([$id_user,$id_tweet]);
            return $req;
        }
        // get all Likes from a user
        public function getUserLikes($id_user){
            $req = $this->db->prepare('SELECT * FROM likes WHERE id_user = ? ');
            $req->execute([$id_user]);
            return $req;
        }
        // get all liked tweet from a user
        public function getUserTweetLikes($id_tweet){
            $req = $this->db->prepare('SELECT * FROM likes WHERE id_tweet = ? ');
            $req->execute([$id_tweet]);
            return $req;
        }
        // like a tweet
        public function likeTweet($id_user, $id_tweet){
            $req = $this->db->prepare('INSERT INTO likes(id_user,id_tweet,date_hour_creation) VALUES(?,?,NOW())');
            $req->execute([$id_user,$id_tweet]);
            return $req;
        }
        // dislike a tweet
        public function unlikeTweet($id_user, $id_tweet){
            $req = $this->db->prepare('DELETE FROM likes WHERE id_user = ? AND id_tweet = ?');
            $req->execute([$id_user,$id_tweet]);
            return $req;
        }
        
    }