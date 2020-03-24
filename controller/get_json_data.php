<?php
include "../conf.inc.php";
include "../connect.inc.php";
include "../function.inc.php";

$return = array();
if(
    (!isset($_GET['session']))
){
    mysqli_close($conn);
    die();
}

$session = mysqli_real_escape_string($conn, $_GET['session']);

$strSQL = "SELECT JSON_DATA FROM nis_neo_chart_data WHERE SESS_ID = '$session'";
$result = mysqli_query($conn, $strSQL);
if(($result) && (mysqli_num_rows($result) > 0)){
  $data = mysqli_fetch_assoc($result);
  echo $data['JSON_DATA'];
}
mysqli_close($conn);
die();

?>
