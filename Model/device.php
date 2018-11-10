<?php
class Device{
    private $deviceId;
    private $timeStamp;
    private $lastPacketTimeStamp;
    private $simPhoneNumber;
    
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
}

?>