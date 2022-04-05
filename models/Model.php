<?php 

    abstract class Model{
        // Propriété qui contiendra l'instance de la connexion
        protected $db;

        /**
         * Fonction d'initialisation de la base de données
         * @return void
         */
        public function getConnection($host,$db_name,$username,$password){
            // On supprime la connexion précédente
            $this->db = null;
            // On essaie de se connecter à la base
            try{
                $this->db = new PDO("mysql:host=" . $host . ";dbname=" . $db_name, $username, $password);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
               
            }catch(PDOException $exception){
                echo "Erreur de connexion : " . $exception->getMessage();
            }
        }  

    }