<?php
include "../conf.inc.php";
include "../connect.inc.php";
include "../function.inc.php";

// $strSQL = "SELECT * FROM nis_neo_deviceday WHERE ndw_losa IS NULL LIMIT 50";
$strSQL = "SELECT * FROM nis_neo_deviceday WHERE ndw_losa IS NULL";
$result = mysqli_query($conn, $strSQL);
if($result){
  while($row = mysqli_fetch_array($result)){
    $endDate = $row['ndw_ddate'];
    $record_id = $row['ndw_id'];
    $serial = $row['ndw_neo_serial'];
    $strSQL = "SELECT neo_admission FROM nis_neonate_patient WHERE neo_serial = '$serial' LIMIT 1";
    $result2 =  mysqli_query($conn, $strSQL);
    if(($result2) && (mysqli_num_rows($result2) > 0)){
      $data2 = mysqli_fetch_assoc($result2);
      $admitDate = $data2['neo_admission'];

      $dateDiff = calculateDate($admitDate, $endDate);

      // echo "Serial : ". $serial . " -> " .$dateDiff." days<br>";

      $strSQL = "UPDATE nis_neo_deviceday SET ndw_losa = '$dateDiff' WHERE ndw_id = '$record_id'";
                mysqli_query($conn, $strSQL);
    }
  }
}

function calculateDate($start, $end){
  $date1 = date_create($start);
  $date2 = date_create($end);
  $diff=date_diff($date1,$date2);
  return $diff->format("%a");
}
?>
