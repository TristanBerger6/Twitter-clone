<?php 

    require_once("models/Model.php");

    class Follow extends Model{

        public function __construct(){
            $this->getConnection();
        }
        
        // get all the followers of this id
        public function getFollowers($id_followed){
            $req = $this->db->prepare('SELECT * FROM follows WHERE id_followed = ?');
            $req->execute([$id_followed]);
            return $req;
        }

        // get all the person that this id follows
        public function getFollowing($id_follower){
            $req = $this->db->prepare('SELECT * FROM follows WHERE id_follower = ?');
            $req->execute([$id_follower]);
            return $req;
        }
        
    }