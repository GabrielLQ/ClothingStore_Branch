<?php
include_once "00.Connection.php";
class ClothingStore_Branch_GET extends ClothingStore_Branch {
	public function ViewBranches(){
		$Queried = 'SELECT * FROM branch';
		try {

				$qRead_ = $this->conn->prepare($Queried);
				
				if($qRead_ -> execute()){

					$rRead_ = $qRead_->fetchAll(PDO::FETCH_ASSOC);
					$sRead_ = @intval(count($rRead_));
						
					http_response_code(200);
					header('Content-Type: application/json; charset="utf-8"');
					echo json_encode( array('data' => $sRead_ === 0 ? array() : $rRead_ ));	
				}

				else{
					http_response_code(500);
					die(json_encode(array('message' -> $qRead_ -> getMessage() )));	
				}

			} catch(PDOException $errorQuery){

				http_response_code(500);
				die(json_encode(array('msg'=> $errorQuery->getMessage() )));

			} catch(Exception $errorSQL) {

        		http_response_code(500);
        		die(json_encode(array( 'error' => $errorSQL->getMessage() )));
			}

	}

	public function ViewBranchId($Id_) {
    	$Queried = 'SELECT * FROM branch WHERE Id = ?';
    
	    try {
	        $qRead_ = $this->conn->prepare($Queried);
	        $qRead_->bindParam(1, $Id_, PDO::PARAM_INT);
	        
	        if ($qRead_->execute()) {
	            $rRead_ = $qRead_->fetchAll(PDO::FETCH_ASSOC);
	            
	            if (empty($rRead_)) {
	                http_response_code(404);
	                header('Content-Type: application/json; charset="utf-8"');
	                echo json_encode(array('message' => 'No existen registros'));
	            } else {
	                http_response_code(200);
	                header('Content-Type: application/json; charset="utf-8"');
	                echo json_encode(array('data' => $rRead_));
	            }
	        } else {
	            http_response_code(500);
	            echo json_encode(array('message' => 'Error al ejecutar la consulta'));
	        }
	        
	    } catch(PDOException $errorQuery) {
	        http_response_code(500);
	        echo json_encode(array('message' => $errorQuery->getMessage()));
	    } catch(Exception $errorSQL) {
	        http_response_code(500);
	        echo json_encode(array('error' => $errorSQL->getMessage()));
	    }
	}
}
?>