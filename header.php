<?php 

	include  realpath($base."Service/cronService.php");
	include realpath($base."Service/deviceService.php");
	include realpath($base."Service/userService.php");
    require_once  realpath($base."Core/database.php");
    require_once  realpath($base."Model/converter.php");
    require_once  realpath($base.'Model/mailer.php');
    require_once  realpath($base.'Model/cron.php');
    require_once  realpath($base.'Model/excel.php');
    require_once  realpath($base.'Model/filehandling.php');
    require_once  realpath($base.'Model/address.php');