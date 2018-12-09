<?php 

$base = __DIR__."/" ;
include realpath($base."header.php");
/********* Creating directory *********/
$dirpath = dirname(__FILE__)."/logs/DistanceDailyReport-".date('d-m-Y')."/";
$mode = "0777";
if(!is_dir($dirpath)) mkdir($dirpath, $mode, true);
/********* Created the directory *********/

/********* Creating DeviceService object and fetching all the device list *********/
print_r("Info : Created new entity object\n");
$userList = new UserService();
print_r("Info : Getting all the data from the database\n");
$userArray=$userList->getAllUser();
$deviceService = new DeviceService();
$totime = date('Y-m-d H:i:s');
$fromtime = date('Y-m-d H:i:s', strtotime('-1 days'));
/********* Created DeviceService object and stored all the device list in the $stmt variable*********/
foreach ($userArray as $key => $value) {
    $deviceList = $deviceService->getDeviceListByUser($value->getUserAccountName());
    print_r("User => ".$value->getUserAccountName());
    $dataArray = array();
    foreach ($deviceList as $devicekey => $devicevalue) {
        print_r("\nDeviceId => ".$devicevalue->getDeviceId()."\n");
        $distanceData = $deviceService->getDistancePlusLatLng($devicevalue->getDeviceId(),$fromtime,$totime);
        $devicevalue->setDistance(round((float)$distanceData["distance"],2));
        $devicevalue->setLat((float)$distanceData["lat"]);
        $devicevalue->setLng((float)$distanceData["lng"]);
        if($devicevalue->getDistance()>0)
          $devicevalue->setLastLocation(Address::getAddressByLatLng($devicevalue->getLat().",".$devicevalue->getLng()));
        array_push($dataArray, 
          array(
            $devicevalue->getDeviceVehiclePlateNumber(),
            $fromtime,
            $totime,
            ($devicevalue->getDistance()!=0?$devicevalue->getDistance(): "0"),
            ($devicevalue->getLastLocation()!=null?$devicevalue->getLastLocation(): "N/A"),
            )
        );
    }
    try{
      $filePath = $dirpath."Distance daily Report of ".strtoupper($value->getUserAccountName()).".xlsx";
      $excel = new Excel();
      $excel->styleExcelSheet();
      $excel->insertData($dataArray);
      $excel->saveExcelFile($filePath);
      unset($dataArray);
      $dataArray = array();
          try{
          $mailer = new Mailer($value->getUserAccountEmail());
          // $mailer = new Mailer("r.prateek11@gmail.com");
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
    break;    
  }

$cron = new Cron();
$cronService = new CronService();
$cron->setId(2);
$cron->setStatus("Cron Run Successfully");
if($cronService->update($cron)){
    echo "Cron Status Updated Successfully!!";
    $mailer = new Mailer("team@ffever.in");
    // $mailer = new Mailer("r.prateek11@gmail.com");
    $zipArchive = new ZipArchive();
    $zipFile=dirname(__FILE__)."/logs/DistanceDailyReport-".date('d-m-Y')."/DistanceDailyReport-".date('d-m-Y').".zip";
    if (!$zipArchive->open($zipFile, ZipArchive::CREATE | ZIPARCHIVE::OVERWRITE))
        die("Failed to create archive\n");
    $zipArchive->addGlob("logs/DistanceDailyReport-".date('d-m-Y')."/*.xlsx");
    if (!$zipArchive->status == ZIPARCHIVE::ER_OK)
        echo "Failed to write files to zip\n";
    $zipArchive->close();
    $mailer->addAttachmentFile($zipFile);// Add attachments
    $mailer->addSubject('Daily Distance Report from '.date_format(date_create($fromtime),"Y-m-d").' to '.date_format(date_create($totime),"Y-m-d"));
    $mailer->addBody('Hello Sir,<br/><br/>A computer generated file is attached.<br/><br/><b>Thanks & Regards</b><br>FFever System Admin');
    $mailer->send();
    FileHandling::emptyFolder($base."logs/");
}
else
    echo "Cron Status Updation Failed";