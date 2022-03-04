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
        public function getFollowed($id_follower){
            $req = $this->db->prepare('SELECT * FROM follows WHERE id_follower = ?');
            $req->execute([$id_follower]);
            return $req;
        }
        // Test to see wether a user follows another
        public function isFollowed($id_follower,$id_followed){
            $req = $this->db->prepare('SELECT * FROM follows WHERE id_follower = ? AND id_followed = ?');
            $req->execute([$id_follower,$id_followed]);
            return $req;
        }
        // A user unfollows another
        public function unfollow($id_follower,$id_followed){
            $req = $this->db->prepare('DELETE FROM follows WHERE id_follower = ? AND id_followed = ?');
            $req->execute([$id_follower,$id_followed]);
            return $req;
        }
        // A user follows another
        public function follow($id_follower,$id_followed){
            $req = $this->db->prepare('INSERT INTO follows(id_follower,id_followed,date_hour_creation) VALUES(?,?,NOW())');
            $req->execute([$id_follower,$id_followed]);
            return $req;
        }
        
    }