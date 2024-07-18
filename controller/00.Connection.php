<?php
	class ClothingStore_Branch{
		protected $conn ;

		public function __construct(){
    		#require_once 'index.php';
    		 try {
            	$this->conn = new PDO(DSN_DB, USER_DB, PASSWORD_DB);
            	$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        	} catch (PDOException $e) {
            	echo "Error de conexión: " . $e->getMessage();
        	}
		}
	}
?>