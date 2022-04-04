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
        // get all the tweets containing the string
        public function getTweetContentQuery($string){
            $string = "%".$string."%";
            $req = $this->db->prepare('SELECT * FROM tweets WHERE content LIKE ?');
            $req->execute([$string]);
            return $req;
        }
        //get all the tweets quoted from this tweet
        public function getQuotedFromTweet($id_tweet){
            $req = $this->db->prepare('SELECT * FROM tweets WHERE quoted_id = ?');
            $req->execute([$id_tweet]);
            return $req;
        }
        //get all the comments from this tweet
        public function getCommentsOfTweet($id_tweet){
            $req = $this->db->prepare('SELECT * FROM tweets WHERE commentof_id = ?');
            $req->execute([$id_tweet]);
            return $req;
        }
        // get a tweet
        public function getTweet($id_tweet){
            $req = $this->db->prepare('SELECT * FROM tweets WHERE id = ?');
            $req->execute([$id_tweet]);
            return $req;
        }


        // set new tweet
        public function newTweet($id_user,$content,$img){
            $req = $this->db->prepare('INSERT INTO tweets(id_user,content,img,quote,quoted_id,comment,commentof_id,date_hour_creation) VALUES(?,?,?,false,0,false,0,NOW())');
            $req->execute([$id_user,$content,$img]);
            $reqId = $this->db->query('SELECT LAST_INSERT_ID() AS NewID');
            return $reqId;
        }
        //set new quote
        public function newQuotedTweet($id_user,$content,$img,$quoted_id){
            $req = $this->db->prepare('INSERT INTO tweets(id_user,content,img,quote,quoted_id,comment,commentof_id,date_hour_creation) VALUES(?,?,?,true,?,false,0,NOW())');
            $req->execute([$id_user,$content,$img,$quoted_id]);
            $reqId = $this->db->query('SELECT LAST_INSERT_ID() AS NewID');
            return $reqId;
        }
        //set new comment
        public function newComment($id_user,$content,$img,$commented_id){
            $req = $this->db->prepare('INSERT INTO tweets(id_user,content,img,quote,quoted_id,comment,commentof_id,date_hour_creation) VALUES(?,?,?,false,0,true,?,NOW())');
            $req->execute([$id_user,$content,$img,$commented_id]);
            $reqId = $this->db->query('SELECT LAST_INSERT_ID() AS NewID');
            return $reqId;
        }


        // get all the tweets of the followed people
        public function getFollowedTweets($id_user){
            $req = $this->db->prepare('SELECT *, tweets.date_hour_creation as date_order  FROM `follows` INNER JOIN `tweets` ON follows.id_followed = tweets.id_user WHERE follows.id_follower = ?');
            $req->execute([$id_user]);
            return $req;
        }
         // get all comments of a tweet
         public function getTweetComments($id_tweet){
            $req = $this->db->prepare('SELECT * FROM tweets WHERE commentof_id = ?');
            $req->execute([$id_tweet]);
            return $req;
        }

        //delete tweet
        public function deleteTweet($id){
            $req = $this->db->prepare('DELETE FROM tweets WHERE id = ?');
            $req2 = $this->db->prepare('DELETE FROM likes WHERE id_tweet = ? ');
            $req3 = $this->db->prepare('DELETE FROM retweets WHERE id_original_tweet = ? ');
            $req->execute([$id]);
            $req2->execute([$id]);
            $req3->execute([$id]);
            $reqComments = $this->db->prepare('SELECT * FROM tweets WHERE commentof_id = ?');
            $reqComments->execute([$id]);
            $reqMentions = $this->db->prepare('DELETE FROM mentions WHERE id_tweet = ?');
            $reqMentions->execute([$id]);
            foreach($reqComments as $com){
                $this->deleteTweet($com['id']);
            }
            $reqQuotes = $this->db->prepare('SELECT * FROM tweets WHERE quoted_id = ?');
            $reqQuotes->execute([$id]);
            foreach($reqQuotes as $quotes){
                $this->deleteTweet($quotes['id']);
            }
            
            return $req;
        }
      
    

        
    }