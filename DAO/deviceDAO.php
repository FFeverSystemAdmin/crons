<?php
    
    
    include realpath(__DIR__."/../Model/device.php");

    class DeviceDAO{

        function getAllDevicesList(){
            $sql = "Select dd.`deviceID`,dd.`deviceCreatedFor`,dd.`deviceVehiclePlateNumber`,ud.`accountHolderEmail` 
            from `vts_application`.`devicedetails` as dd INNER JOIN `vts_application`.`userdetails`  as ud on ud.`accountName` = dd.`deviceCreatedFor`
            where ud.`accountRoleId` in(1,2) AND ud.`accountActiveStatus` = 'Active' AND dd.`deviceCreatedFor` not in('BikeBot')
            group by dd.`deviceCreatedFor`,dd.`deviceID`,ud.`accountHolderEmail` ";
            $dbs= new Database();
            $conn= $dbs->getConnection();
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            // set the resulting array to associative
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);        
            return $stmt;
        }

        function getDistance($deviceId, $fromTime,$toTime){
            $sql = "CALL `vts_listener`.`sp_getDistanceReport`('".$deviceId."','".$fromTime."', '".$toTime."',@distance);";
            $dbs= new Database();
            $conn= $dbs->getConnection();
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $stmt->closeCursor();
            $query ="SELECT @distance As distance";
            $result = $conn->query($query)->fetch(PDO::FETCH_ASSOC);
            if ($result) {
					return $result !== false ? $result['distance'] : null;
				}
                
        }

        function getDistancePlusLatLng($deviceId, $fromTime,$toTime){
            $sql = "CALL `vts_listener`.`sp_getDistanceReport`('".$deviceId."','".$fromTime."', '".$toTime."',@distance,@lat,@lng);";
            $dbs= new Database();
            $conn= $dbs->getConnection();
            $stmt = $conn->prepare($sql); 
            $stmt->execute();
            $stmt->closeCursor();
            $query ="SELECT @distance As distance,@lat as lat,@lng as lng";
            $result = $conn->query($query)->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                    return $result !== false ? $result : null;
                }
                
        }
    }



?>