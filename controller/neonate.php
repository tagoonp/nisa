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

if($stage == 'saveDeviceIndwelling'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['serial'])) ||
      (!isset($_POST['ddate'])) ||
      (!isset($_POST['los'])) ||
      (!isset($_POST['cath'])) ||
      (!isset($_POST['vent']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $serial = mysqli_real_escape_string($conn, $_POST['serial']);
  $ddate = mysqli_real_escape_string($conn, $_POST['ddate']);
  $los = mysqli_real_escape_string($conn, $_POST['los']);
  $cath = mysqli_real_escape_string($conn, $_POST['cath']);
  $vent = mysqli_real_escape_string($conn, $_POST['vent']);

  $strSQL = "INSERT INTO nis_deviceday
              (dd_uid, dd_serial_no, dd_ddate, dd_device, dd_duration)
            "
}

if($stage == 'delete_patient'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['neo_id']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $neo_id = mysqli_real_escape_string($conn, $_POST['neo_id']);

  $strSQL = "DELETE FROM nis_neonate_patient WHERE neo_id = '$neo_id' AND neo_uid = '$uid' ";
  $result = mysqli_query($conn, $strSQL);
  if($result){
    echo "Y";
  }
  mysqli_close($conn);
  die();

}

if($stage == 'info'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['serial']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $serial = mysqli_real_escape_string($conn, $_POST['serial']);

  $strSQL = "SELECT * FROM nis_neonate_patient WHERE neo_serial = '$serial' AND neo_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);
  if(($result) && (mysqli_num_rows($result) > 0)){
    while ($row = mysqli_fetch_array($result)) {
      $buf = array();
      foreach ($row as $key => $value) {
          if(!is_int($key)){
            $buf[$key] = $value;
          }
      }
      $return[] = $buf;
      echo json_encode($return);
    }
  }

  mysqli_close($conn);
  die();

}

if($stage == 'savenew'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['serial'])) ||
      (!isset($_POST['hn'])) ||
      (!isset($_POST['gender'])) ||
      (!isset($_POST['ga'])) ||
      (!isset($_POST['bw'])) ||
      (!isset($_POST['adm'])) ||
      (!isset($_POST['disc'])) ||
      (!isset($_POST['die'])) ||
      (!isset($_POST['los']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $serial = mysqli_real_escape_string($conn, $_POST['serial']);
  $hn = mysqli_real_escape_string($conn, $_POST['hn']);
  $gender = mysqli_real_escape_string($conn, $_POST['gender']);
  $ga = mysqli_real_escape_string($conn, $_POST['ga']);
  $bw = mysqli_real_escape_string($conn, $_POST['bw']);
  $adm = mysqli_real_escape_string($conn, $_POST['adm']);
  $disc = mysqli_real_escape_string($conn, $_POST['disc']);
  $die = mysqli_real_escape_string($conn, $_POST['die']);
  $los = mysqli_real_escape_string($conn, $_POST['los']);

  $strSQL = "SELECT * FROM nis_neonate_patient WHERE neo_serial = '$serial' AND neo_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);

  // Check BW
  $bw_cat = 1;
  if($bw <= 750){
    $bw_cat = 1;
  }else if(($bw > 750) && ($bw <= 1000)){
    $bw_cat = 2;
  }else if(($bw > 1000) && ($bw <= 1500)){
    $bw_cat = 3;
  }else if(($bw > 1500) && ($bw <= 2500)){
    $bw_cat = 4;
  }else if($bw > 2500){
    $bw_cat = 5;
  }

  if(($result) && (mysqli_num_rows($result) > 0)){ // Have old valud
    $strSQL = "UPDATE nis_neonate_patient
               SET
                neo_hn = '$hn',
                neo_sex = '$gender',
                neo_ga = '$ga',
                neo_bw = '$bw',
                neo_admission = '$adm',
                neo_discharge = '$disc',
                neo_die = '$die',
                neo_los = '$los',
                neo_bw_cat = '$bw_cat'
               WHERE
                neo_uid = '$uid' AND neo_serial = '$serial'
              ";
    $resultUpdate = mysqli_query($conn, $strSQL);
    if($resultUpdate){
      echo "Y";
    }
  }else{
    // Check seq
    $strSQL = "SELECT MAX(neo_seq) mx FROM nis_neonate_patient WHERE neo_uid = '$uid'";
    $resultC1 = mysqli_query($conn, $strSQL);
    $new_seq = 1;
    if(($resultC1) && (mysqli_num_rows($resultC1) > 0)){
      $date = mysqli_fetch_assoc($resultC1);
      $new_seq = $date['mx'] + 1;
    }

    // Save new data
    $strSQL = "INSERT INTO nis_neonate_patient
              (
                neo_serial, neo_year, neo_seq, neo_hn, neo_sex,
                neo_ga, neo_bw, neo_admission, neo_discharge, neo_die,
                neo_los, neo_bw_cat, neo_uid
              )
              VALUES
              (
                '$serial', '$sysdateyear', '$new_seq', '$hn', '$gender',
                '$ga', '$bw', '$adm', '$disc', '$die',
                '$los', '$bw_cat', '$uid'
              )
              ";

    $resultInsert = mysqli_query($conn, $strSQL);
    if($resultInsert){
      echo "Y";
    }
  }

  mysqli_close($conn);
  die();
}

?>
