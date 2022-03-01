<?php 

    abstract class Model{

        private $host = "localhost";
        private $db_name = "twitter_clone";
        private $username = "root";
        private $password ="root";

        // Propriété qui contiendra l'instance de la connexion
        protected $db;

        /**
         * Fonction d'initialisation de la base de données
         * @return void
         */
        public function getConnection(){
            // On supprime la connexion précédente
            $this->db = null;

            // On essaie de se connecter à la base
            try{
                $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
               
            }catch(PDOException $exception){
                echo "Erreur de connexion : " . $exception->getMessage();
            }
        }  

    }