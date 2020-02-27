<?php
include('includes/config.php');

$date_from='08/08/2019';
$date_to='08/09/2019';
$vehicle=1;

$availabilitysql="SELECT * FROM tblbookings WHERE VehicleBooked=:vehicle  AND ((DateFrom>=:date_from AND DateTo<=:date_to) OR (DateFrom<=:date_from AND DateTo>=:date_to) OR (DateFrom<=:date_from AND DateTo>=:date_to) OR (DateFrom<=:date_from  AND DateTo>=:date_to))";
    $availability = $dbh->prepare($availabilitysql);
    $availability->bindParam(':vehicle',$vehicle,PDO::PARAM_STR);
    $availability->bindParam(':date_from',$date_from,PDO::PARAM_STR);
    $availability->bindParam(':date_to',$date_to,PDO::PARAM_STR);
    $availability->execute();
    $avail= $availability->fetch();
 if($avail){
  	
 return true;
  }
 else{

 return false;
 }
    ?>