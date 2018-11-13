<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
    $base = __DIR__."/" ;
    include realpath($base."Service/deviceService.php");
    include  realpath($base."Service/cronService.php");
    require_once  realpath($base."Core/database.php");
    require_once  realpath($base.'Model/mailer.php');
    require_once  realpath($base.'Model/cron.php');
    require_once  realpath($base.'Model/excel.php');
    require_once  realpath($base.'Model/filehandling.php');
    require_once  realpath($base.'Model/address.php');
    /********* Creating directory *********/
    $dirpath = dirname(__FILE__)."/logs/DistanceDailyReport-".date('d-m-Y')."/";
    $mode = "0777";
    if(!is_dir($dirpath)) mkdir($dirpath, $mode, true);
    /********* Created the directory *********/

    /********* Creating DeviceService object and fetching all the device list *********/
    print_r("Info : Created new entity object\n");
    $data = new DeviceService();
    print_r("Info : Getting all the data from the database\n");
    $stmt=$data->getAllDevice();
    /********* Created DeviceService object and stored all the device list in the $stmt variable*********/
   
    
    $index =2;
    $dataArray = array();
    $initial_owner = "";
    $previous_owner = NULL;
    $temp_owner_name = "";
    $totime = date('Y-m-d H:i:s');
    $fromtime = date('Y-m-d H:i:s', strtotime('-1 days'));
    
    try{
        while($row = $stmt->fetch()){
            extract($row);
            $initial_owner = $deviceCreatedFor;
            if( $previous_owner != $initial_owner && $previous_owner !=NULL){
                $temp_owner_name = $previous_owner;
                $previous_owner = NULL;
            }

            if(($previous_owner == NULL && !empty($dataArray) )){
                //print_r("************************\n");
                //print_r("Info : Create New File with name $temp_owner_name!!\n");
                //print_r("************************\n");
                try{
                $filePath = $dirpath."Distance daily Report of ".strtoupper($temp_owner_name).".xlsx";
                $excel = new Excel();
                $excel->styleExcelSheet();
                $excel->insertData($dataArray);
                $excel->saveExcelFile($filePath);
                //print_r("Created File : Distance weekly Report of ".strtoupper($temp_owner_name).".xlsx\n");
                unset($dataArray);
                $dataArray = array();
                    try{
                    //$mailer = new Mailer($accountHolderEmail);
                    $mailer = new Mailer("r.prateek11@gmail.com");
                    print_r("Info : Initialised attachment!!\n");
                    $mailer->addAttachmentFile($filePath);// Add attachments
                    $mailer->addSubject('Daily Distance Report from '.date_format(date_create($fromtime),"Y-m-d").' to '.date_format(date_create($totime),"Y-m-d"));
                    $mailer->addBody('Hello Sir,<br/><br/>A computer generated file is attached.<br/><br/><b>Thanks & Regards</b><br>FFever System Admin');
                    $mailer->send();    
                    }catch(Exception $e){
                        echo 'Error: ' .$e->getMessage();   
                    }
                }catch(Exception $e){
                echo 'Error: ' .$e->getMessage();
                }
            }
            print_r("Inital Owner :$initial_owner\n");
            print_r("Info: Device Id =>".$deviceID."\n");
            print_r("Info: Vehicle Plate Number =>".$deviceVehiclePlateNumber."\n");
            print_r("Info: User Alloted =>".$deviceCreatedFor."\n");
            print_r("Info: User Email =>".$accountHolderEmail."\n");
            $distanceData = $data->getDistancePlusLatLng($deviceID,$fromtime,$totime);
            $distance =round((float)$distanceData["distance"],2);
            $lat = (float)$distanceData["lat"];
            $lng = (float)$distanceData["lng"];
            $address = Address::getAddressByLatLng($lat.",".$lng);
            print_r("Info: Distance =>".$distance."\n");
            array_push(
            $dataArray,array(
                $deviceVehiclePlateNumber,
                $fromtime,
                $totime,
                ($distance != 0 ? $distance: "0"),
                ($address != null ? $address : "N/A"))
            );
            $previous_owner = $initial_owner;
            print_r("Previous owner :$previous_owner\n");
            print_r("*******************************\n");
        }

                print_r("************************\n");
                print_r("Info : Create New File with name $initial_owner!!\n");
                print_r("************************\n");
                try{
                $filePath = $dirpath."Distance daily Report of ".strtoupper($initial_owner).".xlsx";
                $excel = new Excel();
                $excel->styleExcelSheet();
                $excel->insertData($dataArray);
                $excel->saveExcelFile($filePath);
                print_r("Created File : Distance daily Report of ".strtoupper($initial_owner).".xlsx\n");
                unset($dataArray);
                $dataArray = array();
                    try{
                    //$mailer = new Mailer($accountHolderEmail);
                    $mailer = new Mailer("r.prateek11@gmail.com");
                    print_r("Info : Initialised attachment!!\n");
                    $mailer->addAttachmentFile($filePath);// Add attachments
                    $mailer->addSubject('Daily Distance Report from '.date_format(date_create($fromtime),"Y-m-d").' to '.date_format(date_create($totime),"Y-m-d"));
                    $mailer->addBody('Hello Sir,<br/><br/>A computer generated file is attached.<br/><br/><b>Thanks & Regards</b><br>FFever System Admin');
                    $mailer->send();    
                    }catch(Exception $e){
                    echo 'Error: ' .$e->getMessage();   
                    }
                }catch(Exception $e){
                echo 'Error: ' .$e->getMessage();
                }

        $cron = new Cron();
        $cronService = new CronService();
        $cron->setId(1);
        $cron->setStatus("Cron Run Successfully");
        if($cronService->update($cron)){
            echo "Cron Status Updated Successfully!!";
            FileHandling::emptyFolder($base."logs/");
        }
        else
            echo "Cron Status Updation Failed";
    }catch(Exception $e){
        $cron = new Cron();
        $cronService = new CronService();
        $cron->setId(1);
        $cron->setStatus("Error: ".$e->getMessage());
        $cronService->update($cron);
    }
?>