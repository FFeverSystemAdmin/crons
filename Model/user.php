<?php
class User{
    private $userAccountId;
    private $userAccountName;
    private $userAccountHolderName;
    private $userAccountEmail;
    
    function __construct(){
    
    }

    public function getUserAccountId(){
        return $this->userAccountId;
    }

    public function getUserAccountName(){
        return $this->userAccountName;
    }

    public function getUserAccountHolderName(){
        return $this->userAccountHolderName;
    }

    public function getUserAccountEmail(){
        return $this->userAccountEmail;
    }

    public function setUserAccountId($userAccountId){
        $this->userAccountId= $userAccountId;
    }

    public function setUserAccountName($userAccountName){
        $this->userAccountName= $userAccountName;
    }

    public function setUserAccountHolderName($userAccountHolderName){
        $this->userAccountHolderName= $userAccountHolderName;
    }

    public function setUserAccountEmail($userAccountEmail){
        $this->userAccountEmail = $userAccountEmail;
    }

    public function getUser(){
    	return $this;
    }
}

