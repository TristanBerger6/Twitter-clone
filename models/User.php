<?php 

    require_once("models/Model.php");

    class User extends Model{

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



        public function updateBio($bio,$id){
            $insert = $this->db->prepare(
                'UPDATE users SET bio = ? WHERE id = ?'
              );
            $insert->execute([$bio,$id]); 
            return $insert;
        }
        public function setAll($name,$username,$mail,$pass){
            $insert = $this->db->prepare(
                'INSERT INTO users(name,username, mail, password, img, imgcover, bio, date_hour_creation) VALUES(?,?,?,?,"default_profile_400x400.png","default_profile_500x200.png","",NOW())'
              );
            $insert->execute([$name,$username,$mail,$pass]); 
            return $insert;
        }
      

        
    }