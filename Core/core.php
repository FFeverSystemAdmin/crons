<?php
    include realpath(__DIR__."/database.php");
    $dbs= new Database();
    $conn= $dbs->getConnection();
?>