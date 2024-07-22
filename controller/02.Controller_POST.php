<?php
include_once "00.Connection.php";
class ClothingStore_Branch_POST extends ClothingStore_Branch{
	public function CreateBranch($NameBranch_,$Street_,$Description_){
		$Queried = 'INSERT INTO `Branch`(
			`NameBranch`,
			`Street`,
			`Description`
		) VALUES (?,?,?)';
		
		try{
			$this->conn->beginTransaction();
			$qCreateBranch = $this->conn->prepare($Queried);
			$qCreateBranch -> bindParam(1,$NameBranch_,PDO::PARAM_STR);
			$qCreateBranch -> bindParam(2,$Street_,PDO::PARAM_STR);
			$qCreateBranch -> bindParam(3,$Description_,PDO::PARAM_STR);

			if($qCreateBranch->execute()){

				$qGetLastId = $this->conn->query("SELECT @@identity AS Id")->fetch(PDO::FETCH_ASSOC);
                $lastInsertId = $qGetLastId['Id'];

				echo json_encode([
					'Status' => 'Datos Ingresados',
					'data' => [
						'Id' => $lastInsertId,
						'NameBranch' => $NameBranch_,
						'Street' => $Street_,
						'Description' => $Description_
					]
				]);
				$this->conn->commit();
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