<?php
    
    
    include realpath(__DIR__."/../Model/device.php");

    class DeviceDAO{

        private $conn;
        function __construct(){
            $dbs= new Database();
            $this->conn= $dbs->getConnection();
        }
        function getAllDevicesList(){
            $sql = "Select dd.`deviceID`,dd.`deviceCreatedFor`,dd.`deviceVehiclePlateNumber`,ud.`accountHolderEmail` 
            from `vts_application`.`devicedetails` as dd INNER JOIN `vts_application`.`userdetails`  as ud on ud.`accountName` = dd.`deviceCreatedFor`
            where ud.`accountRoleId` in(1,2) AND ud.`accountActiveStatus` = 'Active' AND dd.`deviceCreatedFor` not in('BikeBot')
            group by dd.`deviceCreatedFor`,dd.`deviceID`,ud.`accountHolderEmail` ";
            $stmt = $this->conn->prepare($sql); 
            $stmt->execute();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);        
            return $stmt;
        }

        function getDistance($deviceId, $fromTime,$toTime){
            $sql = "CALL `vts_listener`.`sp_getDistanceReport`('".$deviceId."','".$fromTime."', '".$toTime."',@distance);";
            $stmt = $this->conn->prepare($sql); 
            $stmt->execute();
            $stmt->closeCursor();
            $query ="SELECT @distance As distance";
            $result = $this->conn->query($query)->fetch(PDO::FETCH_ASSOC);
            if ($result) {
				return $result !== false ? $result['distance'] : null;
			}
                
        }

        function getDistancePlusLatLng($deviceId, $fromTime,$toTime){
            $sql = "CALL `vts_listener`.`sp_getDistanceReport`('".$deviceId."','".$fromTime."', '".$toTime."',@distance,@lat,@lng);";
            $stmt = $this->conn->prepare($sql); 
            $stmt->execute();
            $stmt->closeCursor();
            $query ="SELECT @distance As distance,@lat as lat,@lng as lng";
            $result = $this->conn->query($query)->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                    return $result !== false ? $result : null;
            }
                
        }

        function getDeviceListByUser($accountName){
            $sql = "SELECT deviceID deviceId,deviceSIMPhoneNumber simPhoneNumber,deviceVehiclePlateNumber FROM `vts_application`.`devicedetails` where deviceCreatedFor ='".$accountName."'";
            $stmt = $this->conn->prepare($sql); 
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);        
            $result = array();
            foreach ($stmt->fetchAll() as $key => $value) {
                array_push($result, Converter::toObject($value, new Device()));
            }
            return $result;   
        }
    }



?>