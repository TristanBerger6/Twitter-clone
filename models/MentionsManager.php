<?php 

    require_once("models/Model.php");

    class MentionsManager extends Model{

        public function __construct(){
            $this->getConnection();
        }
        
       
        public function setMention($id_from, $id_for,$id_tweet){
            $req = $this->db->prepare('INSERT INTO mentions(mentionfrom_id,mentionfor_id,id_tweet,date_hour_creation) VALUES(?,?,?,NOW())');
            $req->execute([$id_from,$id_for,$id_tweet]);
            return $req;
        }
        // get all the mentions of the user 
        public function getUserMentions($id_for){
            $req = $this->db->prepare('SELECT * FROM mentions WHERE mentionfor_id = ?');
            $req->execute([$id_for]);
            return $req;
        }
        
    }