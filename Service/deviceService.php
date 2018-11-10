<?php
    
    include realpath(__DIR__."/../DAO/deviceDAO.php");

    class DeviceService{
        

        private $deviceDAO;

        function __construct(){
            $this->deviceDAO = new DeviceDAO();
        }

        function getAllDevice(){
            return $this->deviceDAO->getAllDevicesList();
        }

        function getDistance($deviceId,$fromTime,$toTime){
            return $this->deviceDAO->getDistance($deviceId,$fromTime,$toTime);
        }

        function getDistancePlusLatLng($deviceId,$fromTime,$toTime){
            return $this->deviceDAO->getDistancePlusLatLng($deviceId,$fromTime,$toTime);
        }
    }
    

?>