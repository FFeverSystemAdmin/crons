<?php
    
    include realpath(__DIR__."/../DAO/userDAO.php");

    class UserService{
        

        private $userDAO;

        function __construct(){
            $this->userDAO = new UserDAO();
        }

        function getUserById($id){
            return $this->userDAO->getUserById($id);
        }

        function getAllUser(){
            return $this->userDAO->getAllUser();
        }
    }
    

?>