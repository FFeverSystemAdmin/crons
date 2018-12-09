<?php
class Device{
    private $deviceId;
    private $timeStamp;
    private $lastPacketTimeStamp;
    private $simPhoneNumber;
    private $distance;
    private $lat;
    private $lng;
    private $deviceVehiclePlateNumber;
    private $lastLocation;
    function __construct(){
    
    }

    function getDeviceId(){
        return $this->deviceId;
    }

    function getTimeStamp(){
        return $this->timeStamp;
    }

    function getSimPhonenumber(){
        return $this->simPhoneNumber;
    }

    function getLastPacketTimeStamp(){
        return $this->lastPacketTimeStamp;
    }

    function setDeviceId($deviceID){
        $this->deviceId= $deviceID;
    }

    function setTimeStamp($timeStamp){
        $this->timeStamp= $timeStamp;
    }

    function setSimPhoneNumber($simPhoneNumber){
        $this->simPhoneNumber = $simPhoneNumber;
    }

    function setDistance($distance){
        $this->distance = $distance;
    }

    function getDistance(){
        return $this->distance;
    }

    function getLat(){
        return $this->lat;
    }

    function getLng(){
        return $this->lng;
    }

    function setLat($lat){
        $this->lat = $lat;
    }

    function setLng($lng){
        $this->lng = $lng;
    }

    function setDeviceVehiclePlateNumber($deviceVehiclePlateNumber){
        $this->deviceVehiclePlateNumber = $deviceVehiclePlateNumber;
    }

    function getDeviceVehiclePlateNumber(){
        return $this->deviceVehiclePlateNumber;
    }

    function setLastLocation($lastLocation){
        $this->lastLocation = $lastLocation;
    }
    function getLastLocation(){
        return $this->lastLocation;
    }
}

?>