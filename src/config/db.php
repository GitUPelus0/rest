<?php
    class db{
        // Properties
        private $dbhost = 'server1.lineadecodigo.net';
        private $dbuser = 'juan.bello';
        private $dbpass = 'Ap@n4lys_&s5679';
        private $dbname = 'lab_rest_classAnalysis';

        // Connect
        public function connect(){
            $mysql_connect_str = "mysql:host=$this->dbhost;dbname=$this->dbname";
            $dbConnection = new PDO($mysql_connect_str, $this->dbuser, $this->dbpass);
            $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbConnection;
        }
    }


