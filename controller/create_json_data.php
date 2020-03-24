<?php
include "../conf.inc.php";
include "../connect.inc.php";
include "../function.inc.php";

$return = array();

if(
    (!isset($_GET['stage']))
){
    mysqli_close($conn);
    die();
}

$stage = mysqli_real_escape_string($conn, $_GET['stage']);

if($stage == 'create'){

  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['vis_session'])) ||
      (!isset($_POST['json_string'])) ||
      (!isset($_POST['graph_type']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $session = mysqli_real_escape_string($conn, $_POST['vis_session']);
  $jstring = mysqli_real_escape_string($conn, $_POST['json_string']);
  $graph_type = mysqli_real_escape_string($conn, $_POST['graph_type']);

  $strSQL = "INSERT INTO nis_neo_chart_data (SESS_ID, UID, JSON_DATA, CHART_GROUP) VALUES ('$session', '$uid', '$jstring', '$graph_type')";
  $result = mysqli_query($conn, $strSQL);
  if($result){

    exec("Rscript create_neonate_chart.r $session $uid");

    echo "Y";
  }else{
    echo "N";
  }

  mysqli_close($conn);
  die();
}

?>
