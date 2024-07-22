<?php
include_once "00.Connection.php";
class ClothingStore_Branch_PUT extends ClothingStore_Branch{
	public function UpdateBranch($Id_,$NameBranch_,$Street_,$Description_){
		$Queried = '
			UPDATE `Branch` SET 
				`NameBranch` = ?,
				`Street` = ? ,
				`Description` = ? 
			WHERE Id = ? 
		';

		try{
			
			$this->conn->beginTransaction();
			$qUpdateBranch = $this->conn->prepare($Queried);

			$qUpdateBranch -> bindParam(1,$NameBranch_ , PDO::PARAM_STR);
			$qUpdateBranch -> bindParam(2,$Street_ , PDO::PARAM_STR);
			$qUpdateBranch -> bindParam(3,$Description_ , PDO::PARAM_STR);
			$qUpdateBranch -> bindParam(4,$Id_,PDO::PARAM_INT);

			if($qUpdateBranch -> execute()){
				$VerifiedQuery = 'SELECT * FROM Branch WHERE Id = ?';
				$VerifiedStatement -> bindParam(1,$Id_,PDO::PARAM_INT);
				$VerifiedStatement -> execute();
				$VerifiedUpdateBranch = $VerifiedStatement -> fetch(PDO::FETCH_ASSOC); 
				echo json_encode([
					'Status_'=> 'Datos Actualizados',
					'data' => [
						'Id' => $VerifiedUpdateBranch['Id'],
						'NameBranch' => $VerifiedUpdateBranch['NameBranch'],
						'Street' => $VerifiedUpdateBranch['Street'],
						'Description' => $VerifiedUpdateBranch['Description']
					] 
				]);
			} else {
				$this->conn->rollBack();
				http_response_code(500);
				echo json_encode(['Status_' => 'Error al actualizar la sucursal']);
			}

		} catch(PDOException $errorQuery){
			$this->conn->RollBack();
			http_response_code(500);
			die(json_encode(array('msg' => $errorQuery->getMessage() )));
		} catch(Exception $errorSQL){
			$this->conn->rollBack();
			http_response_code(500);
			die(json_encode(array('error' => $errorSQL -> getMessage() )));
		}
	}	
}
?>