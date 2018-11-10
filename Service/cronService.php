<?php
	include realpath(__DIR__."/../DAO/cronDAO.php");
	class CronService{
		

		private $cronDAO;
		
		function __construct(){
			$this->cronDAO = new CronDAO();
		}

		function update($cron){
			return $this->cronDAO->update($cron);
		}
	}
?>