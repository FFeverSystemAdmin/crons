<?php


class Cron{
	private $id;
	private $status;
	private $modifiedDate;

	public function getId(){
		return $this->id;
	}
	public function getStatus(){
		return $this->status;
	}
	public function getModifiedDate(){
		return $this->modifiedDate;
	}
	public function setId($id){
		$this->id=$id;
	}
	public function setStatus($status){
		$this->status=$status;
	}
	public function setModifiedDate($modifiedDate){
		$this->modifiedDate= $modifiedDate;
	}
}

?>