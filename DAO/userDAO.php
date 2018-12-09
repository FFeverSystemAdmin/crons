<?php 

include realpath(__DIR__."/../Model/user.php");

class UserDAO{

	private $conn;
	function __construct(){
		$dbs= new Database();
        $this->conn= $dbs->getConnection();
	} 
	function getUserById($id){
		var_dump($this);exit();
	}

	function getAllUser(){
		$sql = "SELECT id userAccountId, accountName userAccountName, accountHolderName userAccountHolderName, accountHolderEmail userAccountEmail FROM vts_application.userdetails WHERE accountRoleId <> 1 AND `accountActiveStatus` = 'Active' AND `accountHolderName` NOT LIKE '%test%' AND `accountHolderName` NOT LIKE '%demo%' and accountName not in ('BikeBot')";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);        
        $result = array();
        foreach ($stmt->fetchAll() as $key => $value) {
    		array_push($result, Converter::toObject($value, new User()));
 		}
 		return $result;
	}
}