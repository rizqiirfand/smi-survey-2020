<?php

class koneksi{
    private $db_host = 'localhost';
    private $db_name = 'smig_survey';
    private $db_user = 'root';
    private $db_password = '';

    public function get_koneksi() {
        try {
            $db = new PDO('mysql:host='.$this->db_host.';dbname='.$this->db_name, $this->db_user, $this->db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Koneksi database gagal '.$e->getMessage();
			exit;
        }
        return $db; 
    }
}

// $db = "";
// function koneksi() {		
// 	define('db_host', 'localhost');
// 	define('db_user', 'root');
// 	define('db_password', '');
// 	define('db_name', 'smig_survey');

// 	try {
// 		global $db;
// 		$db = new PDO('mysql:host='.db_host.';dbname='.db_name, db_user, db_password);
// 		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// 	} catch (PDOException $e) {
// 		echo "Koneksi database gagal ".$e->getMessage();
// 		exit;
// 	}
// }
?>