<?php


include realpath(__DIR__."/../Model/cron.php");

class CronDAO{

	  function update($cron){
	 	try{
 			$query= "UPDATE `vts_application`.`tbl_cronsstatus`
				SET
				`col_cronStatus` = :cronsStatus,
				`col_modifyDate` = :crondate
				WHERE `col_id` =:cronId";
			$dbs= new Database();
	        $conn= $dbs->getConnection();
	        $stmt = $conn->prepare($query); 
	        $stmt->execute(["cronsStatus"=>$cron->getStatus(),"crondate"=>date("Y-m-d h:m:s"),"cronId"=>$cron->getId()]);	
			
	        return true;
	 	}catch(Exception $e){
	 		return false;
	 	}
	 }

}



?>