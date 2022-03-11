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
        public function getTweet($id_tweet){
            $req = $this->db->prepare('SELECT * FROM tweets WHERE id = ?');
            $req->execute([$id_tweet]);
            return $req;
        }

        public function newTweet($id_user,$content,$img){
            $req = $this->db->prepare('INSERT INTO tweets(id_user,content,img,quote,quoted_id,date_hour_creation) VALUES(?,?,?,false,0,NOW())');
            $req->execute([$id_user,$content,$img]);
            return $req;
        }
        public function newQuotedTweet($id_user,$content,$img,$quoted_id){
            $req = $this->db->prepare('INSERT INTO tweets(id_user,content,img,quote,quoted_id,date_hour_creation) VALUES(?,?,?,true,?,NOW())');
            $req->execute([$id_user,$content,$img,$quoted_id]);
            return $req;
        }

        // get all the tweets of the followed people
        public function getFollowedTweets($id_user){
            $req = $this->db->prepare('SELECT *, tweets.date_hour_creation as date_order  FROM `follows` INNER JOIN `tweets` ON follows.id_followed = tweets.id_user WHERE follows.id_follower = ?');
            $req->execute([$id_user]);
            return $req;
        }

        public function deleteTweet($id){
            $req = $this->db->prepare('DELETE FROM tweets WHERE id = ? ');
            $req2 = $this->db->prepare('DELETE FROM likes WHERE id_tweet = ? ');
            $req3 = $this->db->prepare('DELETE FROM retweets WHERE id_original_tweet = ? ');
            $req->execute([$id]);
            $req2->execute([$id]);
            $req3->execute([$id]);
            return $req;
        }
      
    

        
    }