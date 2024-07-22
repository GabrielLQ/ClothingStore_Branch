<?php
include_once "00.Connection.php";
class ClothingStore_Branch_PATCH extends ClothingStore_Branch{
	public function UpdateBranch_NameBranch($Id_,$NameBranch_){
		$Queried = '
			UPDATE `Branch` SET 
				`NameBranch` = ?
			WHERE Id = ? 
		';

		try{
			
			$this->conn->beginTransaction();
			$qUpdateBranch = $this->conn->prepare($Queried);

			$qUpdateBranch -> bindParam(1,$NameBranch_ , PDO::PARAM_STR);
			$qUpdateBranch -> bindParam(2,$Id_,PDO::PARAM_INT);

			if($qUpdateBranch -> execute()){
				$VerifiedQuery = 'SELECT Id , NameBranch FROM Branch WHERE Id = ?';
				$VerifiedStatement -> bindParam(1,$Id_,PDO::PARAM_INT);
				$VerifiedStatement -> execute();
				$VerifiedUpdateBranch = $VerifiedStatement -> fetch(PDO::FETCH_ASSOC); 
				echo json_encode([
					'Status_'=> 'Datos Actualizados',
					'data' => [
						'Id' => $VerifiedUpdateBranch['Id'],
						'NameBranch' => $VerifiedUpdateBranch['NameBranch']
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

	public function UpdateBranch_Street($Id_,$Street_){
		$Queried = '
			UPDATE `Branch` SET 
				`Street` = ?
			WHERE Id = ? 
		';

		try{
			
			$this->conn->beginTransaction();
			$qUpdateBranch = $this->conn->prepare($Queried);

			$qUpdateBranch -> bindParam(1,$Street_ , PDO::PARAM_STR);
			$qUpdateBranch -> bindParam(2,$Id_,PDO::PARAM_INT);

			if($qUpdateBranch -> execute()){
				$VerifiedQuery = 'SELECT Id , Street FROM Branch WHERE Id = ?';
				$VerifiedStatement -> bindParam(1,$Id_,PDO::PARAM_INT);
				$VerifiedStatement -> execute();
				$VerifiedUpdateBranch = $VerifiedStatement -> fetch(PDO::FETCH_ASSOC); 
				echo json_encode([
					'Status_'=> 'Datos Actualizados',
					'data' => [
						'Id' => $VerifiedUpdateBranch['Id'],
						'Street' => $VerifiedUpdateBranch['Street']
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

	public function UpdateBranch_Description($Id_ , $Description_){
				$Queried = '
			UPDATE `Branch` SET 
				`Description` = ?
			WHERE Id = ? 
		';

		try{
			
			$this->conn->beginTransaction();
			$qUpdateBranch = $this->conn->prepare($Queried);

			$qUpdateBranch -> bindParam(1,$Description_ , PDO::PARAM_STR);
			$qUpdateBranch -> bindParam(2,$Id_,PDO::PARAM_INT);

			if($qUpdateBranch -> execute()){
				$VerifiedQuery = 'SELECT Id , Description FROM Branch WHERE Id = ?';
				$VerifiedStatement -> bindParam(1,$Id_,PDO::PARAM_INT);
				$VerifiedStatement -> execute();
				$VerifiedUpdateBranch = $VerifiedStatement -> fetch(PDO::FETCH_ASSOC); 
				echo json_encode([
					'Status_'=> 'Datos Actualizados',
					'data' => [
						'Id' => $VerifiedUpdateBranch['Id'],
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