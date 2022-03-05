<?php 

    require_once("models/Model.php");

    class User extends Model{

        public $defaultCover = 'default_cover_500x200.png';
        public $defaultProfile = 'default_profile_400x400.png';

        public function __construct(){
            $this->getConnection();
        }
        
        public function getMail($mail){
            $req = $this->db->prepare('SELECT * FROM users WHERE mail = ?');
            $req->execute([$mail]);
            return $req;
        }
        public function getUsername($username){
            $req = $this->db->prepare('SELECT * FROM users WHERE username = ?');
            $req->execute([$username]);
            return $req;
        }
        public function getMailPass($mail,$pass){
            $req = $this->db->prepare(
                'SELECT * FROM users WHERE mail = ? AND password = ?'
              );
            $req->execute([$mail, $pass]);
            return $req;
        }
        public function getUser($id){
            $req = $this->db->prepare('SELECT * FROM users WHERE id = ?');
            $req->execute([$id]);
            return $req;
        }
        public function getUserCover($id){
            $req = $this->db->prepare('SELECT imgcover FROM users WHERE id = ?');
            $req->execute([$id]);
            return $req;
        }
        public function getUserProfile($id){
            $req = $this->db->prepare('SELECT img FROM users WHERE id = ?');
            $req->execute([$id]);
            return $req;
        }
        public function getUsersFollowers($id){
            $req = $this->db->prepare('SELECT *,users.id AS user_id FROM users LEFT JOIN follows ON follows.id_follower = users.id WHERE id_followed = ?');
            $req->execute([$id]);
            return $req;
        }
        public function getUsersFollowed($id){
            $req = $this->db->prepare('SELECT *,users.id AS user_id FROM users LEFT JOIN follows ON follows.id_followed = users.id WHERE id_follower = ?');
            $req->execute([$id]);
            return $req;
        }



        public function updateBio($bio,$id){
            $insert = $this->db->prepare(
                'UPDATE users SET bio = ? WHERE id = ?'
              );
            $insert->execute([$bio,$id]); 
            return $insert;
        }
        public function updateMail($mail,$id){
            $insert = $this->db->prepare(
                'UPDATE users SET mail = ? WHERE id = ?'
              );
            $insert->execute([$mail,$id]); 
            return $insert;
        }
        public function updateName($name,$id){
            $insert = $this->db->prepare(
                'UPDATE users SET name = ? WHERE id = ?'
              );
            $insert->execute([$name,$id]); 
            return $insert;
        }
        public function updateUsername($username,$id){
            $insert = $this->db->prepare(
                'UPDATE users SET username = ? WHERE id = ?'
              );
            $insert->execute([$username,$id]); 
            return $insert;
        }
        public function updateCover($cover,$id){
            $insert = $this->db->prepare(
                'UPDATE users SET imgcover = ? WHERE id = ?'
              );
            $insert->execute([$cover,$id]); 
            return $insert;
        }
        public function updateProfile($profile,$id){
            $insert = $this->db->prepare(
                'UPDATE users SET img = ? WHERE id = ?'
              );
            $insert->execute([$profile,$id]); 
            return $insert;
        }
        public function updatePass($pass,$id){
            $insert = $this->db->prepare(
                'UPDATE users SET password = ? WHERE id = ?'
              );
            $insert->execute([$pass,$id]); 
            return $insert;
        }



        public function setAll($name,$username,$mail,$pass){
            $insert = $this->db->prepare(
                'INSERT INTO users(name,username, mail, password, img, imgcover, bio, date_hour_creation) VALUES(?,?,?,?,?,?,"",NOW())'
              );
            $insert->execute([$name,$username,$mail,$pass,$this->defaultProfile,$this->defaultCover]); 
            return $insert;
        }
      

        
    }