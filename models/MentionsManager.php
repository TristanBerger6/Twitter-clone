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
        
    }