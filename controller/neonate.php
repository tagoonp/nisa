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

if($stage == 'deleteDeviceOtherinfection'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['rid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);

  $strSQL = "DELETE FROM nis_neo_otherinfect WHERE ID = '$rid' AND neo_other_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);
  if($result){ echo "Y"; }else{ echo $strSQL;}
  mysqli_close($conn);
  die();
}

if($stage == 'deleteDeviceinfection'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['rid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);

  $strSQL = "DELETE FROM nis_neo_dai WHERE nai_id = '$rid' AND nai_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);
  if($result){ echo "Y"; }else{ echo $strSQL;}
  mysqli_close($conn);
  die();
}

if($stage == 'deleteDevicewelling'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['rid']))
  ){
    echo "string";
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);

  $strSQL = "DELETE FROM nis_neo_deviceday WHERE ndw_id = '$rid' AND ndw_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);
  if($result){ echo "Y"; }else{ echo $strSQL;}
  mysqli_close($conn);
  die();
}

if($stage == 'saveDeviceOtherInfection'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['serial'])) ||
      (!isset($_POST['rid'])) ||
      (!isset($_POST['ddate'])) ||
      (!isset($_POST['los'])) ||
      (!isset($_POST['site'])) ||
      (!isset($_POST['pathogen']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);
  $serial = mysqli_real_escape_string($conn, $_POST['serial']);
  $ddate = mysqli_real_escape_string($conn, $_POST['ddate']);
  $los = mysqli_real_escape_string($conn, $_POST['los']);
  $site = mysqli_real_escape_string($conn, $_POST['site']);
  $pathogen = mysqli_real_escape_string($conn, $_POST['pathogen']);

  $strSQL = "INSERT INTO nis_neo_otherinfect
              (
                serial_no, site, doe, loe, pathogen, neo_other_uid
              )
              VALUES
              (
                '$serial', '$site', '$ddate', '$los', '$pathogen', '$uid'
              )
            ";
  $resultInsert = mysqli_query($conn, $strSQL);
  if($resultInsert){ echo "Y"; }
}

if($stage == 'saveDeviceInfection'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['serial'])) ||
      (!isset($_POST['rid'])) ||
      (!isset($_POST['ddate'])) ||
      (!isset($_POST['los'])) ||
      (!isset($_POST['site'])) ||
      (!isset($_POST['pathogen']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);
  $serial = mysqli_real_escape_string($conn, $_POST['serial']);
  $ddate = mysqli_real_escape_string($conn, $_POST['ddate']);
  $los = mysqli_real_escape_string($conn, $_POST['los']);
  $site = mysqli_real_escape_string($conn, $_POST['site']);
  $pathogen = mysqli_real_escape_string($conn, $_POST['pathogen']);

  // Check Monthly
  $b = explode('-', $ddate);
  $month = intval($b[1]);
  if(($month > 0) && ($month <= 2)){ $bimonth = 1; }
  else if(($month > 2) && ($month <= 4)){ $bimonth = 2; }
  else if(($month > 4) && ($month <= 6)){ $bimonth = 3; }
  else if(($month > 6) && ($month <= 8)){ $bimonth = 4; }
  else if(($month > 8) && ($month <= 10)){ $bimonth = 5; }
  else if(($month > 10) && ($month <= 12)){ $bimonth = 6; }

  if(($month > 0) && ($month <= 3)){ $quarter = 1; }
  else if(($month > 3) && ($month <= 6)){ $quarter = 2; }
  else if(($month > 6) && ($month <= 9)){ $quarter = 3; }
  else if(($month > 7) && ($month <= 12)){ $quarter = 4; }

  if(($month > 0) && ($month <= 4)){ $trimester = 1; }
  else if(($month > 4) && ($month <= 8)){ $trimester = 2; }
  else if(($month > 8) && ($month <= 12)){ $trimester = 3; }

  if(($month > 0) && ($month <= 6)){ $semiannual = 1; }
  else if(($month > 6) && ($month <= 12)){ $semiannual = 2; }

  $annual = $b[0];

  // Check bw
  $bw = 0;
  $bw_cat = 0;

  $strSQL = "SELECT * FROM nis_neonate_patient WHERE neo_serial = '$serial' AND neo_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);

  if(($result) && (mysqli_num_rows($result) > 0)){
    $data = mysqli_fetch_assoc($result);
    $bw = $data['neo_bw'];
    $bw_cat = $data['neo_bw_cat'];
  }


  $strSQL = "INSERT INTO nis_neo_dai
              (
                nai_doe, nai_site, nai_bw, nai_bwcat, nai_los,
                nai_pathogen, nai_monthly, nai_bimonth, nai_quarter, nai_trimeater,
                nai_semiannual, nai_annual, nai_udatetime, nai_neo_serial, nai_uid
              )
              VALUES
              (
                '$ddate', '$site', '$bw', '$bw_cat', '$los',
                '$pathogen', '$month', '$bimonth', '$quarter', '$trimester',
                '$semiannual', '$annual', '$sysdatetime', '$serial', '$uid'
              )
            ";
  $resultInsert = mysqli_query($conn, $strSQL);
  if($resultInsert){ echo "Y"; }

}

if($stage == 'saveDeviceIndwelling'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['serial'])) ||
      (!isset($_POST['rid'])) ||
      (!isset($_POST['ddate'])) ||
      (!isset($_POST['los'])) ||
      (!isset($_POST['cath'])) ||
      (!isset($_POST['vent']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);
  $serial = mysqli_real_escape_string($conn, $_POST['serial']);
  $ddate = mysqli_real_escape_string($conn, $_POST['ddate']);
  $los = mysqli_real_escape_string($conn, $_POST['los']);
  $cath = mysqli_real_escape_string($conn, $_POST['cath']);
  $vent = mysqli_real_escape_string($conn, $_POST['vent']);

  // Check Monthly
  $b = explode('-', $ddate);
  $month = intval($b[1]);
  if(($month > 0) && ($month <= 2)){ $bimonth = 1; }
  else if(($month > 2) && ($month <= 4)){ $bimonth = 2; }
  else if(($month > 4) && ($month <= 6)){ $bimonth = 3; }
  else if(($month > 6) && ($month <= 8)){ $bimonth = 4; }
  else if(($month > 8) && ($month <= 10)){ $bimonth = 5; }
  else if(($month > 10) && ($month <= 12)){ $bimonth = 6; }

  if(($month > 0) && ($month <= 3)){ $quarter = 1; }
  else if(($month > 3) && ($month <= 6)){ $quarter = 2; }
  else if(($month > 6) && ($month <= 9)){ $quarter = 3; }
  else if(($month > 7) && ($month <= 12)){ $quarter = 4; }

  if(($month > 0) && ($month <= 4)){ $trimester = 1; }
  else if(($month > 4) && ($month <= 8)){ $trimester = 2; }
  else if(($month > 8) && ($month <= 12)){ $trimester = 3; }

  if(($month > 0) && ($month <= 6)){ $semiannual = 1; }
  else if(($month > 6) && ($month <= 12)){ $semiannual = 2; }

  $annual = $b[0];

  // Check bw
  $bw = 0;
  $bw_cat = 0;

  // $strSQL = "SELECT * FROM nis_neonate_patient WHERE neo_id = '$id' AND neo_serial = '$serial' AND neo_uid = '$uid'";
  $strSQL = "SELECT * FROM nis_neonate_patient WHERE neo_serial = '$serial' AND neo_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);

  if(($result) && (mysqli_num_rows($result) > 0)){
    $data = mysqli_fetch_assoc($result);
    $bw = $data['neo_bw'];
    $bw_cat = $data['neo_bw_cat'];
  }

  if($rid != ''){
    $strSQL = "UPDATE nis_neo_deviceday
               SET
                ndw_ddate = '$ddate',
                ndw_losa = '$los',
                ndw_bw = '$bw',
                ndw_bwcat = '$bw_cat',
                ndw_cath = '$cath',
                ndw_vent = '$vent',
                ndw_monthly = '$month',
                ndw_bimonth = '$bimonth',
                ndw_quarter = '$quarter',
                ndw_trimeater = '$trimester',
                ndw_semiannual = '$semiannual',
                ndw_annual = '$annual',
                ndw_udatetime = '$sysdatetime'
              WHERE
                ndw_id = '$rid' AND ndw_neo_serial = '$serial' AND ndw_uid = '$uid'
              ";
    $resultUpdate = mysqli_query($conn, $strSQL);
    if($resultUpdate){ echo "Y"; }
  }else{
    $strSQL = "INSERT INTO nis_neo_deviceday
                (
                  ndw_ddate, ndw_losa, ndw_bw, ndw_bwcat, ndw_cath,
                  ndw_vent, ndw_monthly, ndw_bimonth, ndw_quarter, ndw_trimeater,
                  ndw_semiannual, ndw_annual, ndw_udatetime, ndw_neo_serial, ndw_uid
                )
                VALUES
                (
                  '$ddate', '$los', '$bw', '$bw_cat', '$cath',
                  '$vent', '$month', '$bimonth', '$quarter', '$trimester',
                  '$semiannual', '$annual', '$sysdatetime', '$serial', '$uid'
                )
              ";
    $resultInsert = mysqli_query($conn, $strSQL);
    if($resultInsert){ echo "Y"; }
  }

  mysqli_close($conn);
  die();

}

if($stage == 'updateDeviceOtherInfection'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['serial'])) ||
      (!isset($_POST['rid'])) ||
      (!isset($_POST['ddate'])) ||
      (!isset($_POST['los'])) ||
      (!isset($_POST['site'])) ||
      (!isset($_POST['pathogen']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);
  $serial = mysqli_real_escape_string($conn, $_POST['serial']);
  $ddate = mysqli_real_escape_string($conn, $_POST['ddate']);
  $los = mysqli_real_escape_string($conn, $_POST['los']);
  $site = mysqli_real_escape_string($conn, $_POST['site']);
  $pathogen = mysqli_real_escape_string($conn, $_POST['pathogen']);

  if($rid != ''){
    $strSQL = "UPDATE nis_neo_otherinfect
               SET
                doe = '$ddate',
                loe = '$los',
                site = '$site',
                pathogen = '$pathogen'
              WHERE
                ID = '$rid' AND serial_no = '$serial' AND neo_other_uid = '$uid'
              ";
    $resultUpdate = mysqli_query($conn, $strSQL);
    if($resultUpdate){ echo "Y"; }
  }

  mysqli_close($conn);
  die();
}

if($stage == 'updateDeviceInfection'){

    if(
        (!isset($_POST['uid'])) ||
        (!isset($_POST['serial'])) ||
        (!isset($_POST['rid'])) ||
        (!isset($_POST['ddate'])) ||
        (!isset($_POST['los'])) ||
        (!isset($_POST['site'])) ||
        (!isset($_POST['pathogen']))
    ){
        mysqli_close($conn);
        die();
    }

    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $rid = mysqli_real_escape_string($conn, $_POST['rid']);
    $serial = mysqli_real_escape_string($conn, $_POST['serial']);
    $ddate = mysqli_real_escape_string($conn, $_POST['ddate']);
    $los = mysqli_real_escape_string($conn, $_POST['los']);
    $site = mysqli_real_escape_string($conn, $_POST['site']);
    $pathogen = mysqli_real_escape_string($conn, $_POST['pathogen']);

    // Check Monthly
    $b = explode('-', $ddate);
    $month = intval($b[1]);
    if(($month > 0) && ($month <= 2)){ $bimonth = 1; }
    else if(($month > 2) && ($month <= 4)){ $bimonth = 2; }
    else if(($month > 4) && ($month <= 6)){ $bimonth = 3; }
    else if(($month > 6) && ($month <= 8)){ $bimonth = 4; }
    else if(($month > 8) && ($month <= 10)){ $bimonth = 5; }
    else if(($month > 10) && ($month <= 12)){ $bimonth = 6; }

    if(($month > 0) && ($month <= 3)){ $quarter = 1; }
    else if(($month > 3) && ($month <= 6)){ $quarter = 2; }
    else if(($month > 6) && ($month <= 9)){ $quarter = 3; }
    else if(($month > 7) && ($month <= 12)){ $quarter = 4; }

    if(($month > 0) && ($month <= 4)){ $trimester = 1; }
    else if(($month > 4) && ($month <= 8)){ $trimester = 2; }
    else if(($month > 8) && ($month <= 12)){ $trimester = 3; }

    if(($month > 0) && ($month <= 6)){ $semiannual = 1; }
    else if(($month > 6) && ($month <= 12)){ $semiannual = 2; }

    $annual = $b[0];

    // Check bw
    $bw = 0;
    $bw_cat = 0;

    $strSQL = "SELECT * FROM nis_neonate_patient WHERE neo_serial = '$serial' AND neo_uid = '$uid'";
    $result = mysqli_query($conn, $strSQL);

    if(($result) && (mysqli_num_rows($result) > 0)){
      $data = mysqli_fetch_assoc($result);
      $bw = $data['neo_bw'];
      $bw_cat = $data['neo_bw_cat'];
    }

    if($rid != ''){
      $strSQL = "UPDATE nis_neo_dai
                 SET
                  nai_doe = '$ddate',
                  nai_los = '$los',
                  nai_bw = '$bw',
                  nai_bwcat = '$bw_cat',
                  nai_site = '$site',
                  nai_monthly = '$month',
                  nai_bimonth = '$bimonth',
                  nai_quarter = '$quarter',
                  nai_trimeater = '$trimester',
                  nai_semiannual = '$semiannual',
                  nai_annual = '$annual',
                  nai_udatetime = '$sysdatetime'
                WHERE
                  nai_id = '$rid' AND nai_neo_serial = '$serial' AND nai_uid = '$uid'
                ";
      $resultUpdate = mysqli_query($conn, $strSQL);
      if($resultUpdate){ echo "Y"; }
    }

    mysqli_close($conn);
    die();
}

if($stage == 'updateDeviceIndwelling'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['serial'])) ||
      (!isset($_POST['rid'])) ||
      (!isset($_POST['ddate'])) ||
      (!isset($_POST['los'])) ||
      (!isset($_POST['cath'])) ||
      (!isset($_POST['vent']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);
  $serial = mysqli_real_escape_string($conn, $_POST['serial']);
  $ddate = mysqli_real_escape_string($conn, $_POST['ddate']);
  $los = mysqli_real_escape_string($conn, $_POST['los']);
  $cath = mysqli_real_escape_string($conn, $_POST['cath']);
  $vent = mysqli_real_escape_string($conn, $_POST['vent']);

  // Check Monthly
  $b = explode('-', $ddate);
  $month = intval($b[1]);
  if(($month > 0) && ($month <= 2)){ $bimonth = 1; }
  else if(($month > 2) && ($month <= 4)){ $bimonth = 2; }
  else if(($month > 4) && ($month <= 6)){ $bimonth = 3; }
  else if(($month > 6) && ($month <= 8)){ $bimonth = 4; }
  else if(($month > 8) && ($month <= 10)){ $bimonth = 5; }
  else if(($month > 10) && ($month <= 12)){ $bimonth = 6; }

  if(($month > 0) && ($month <= 3)){ $quarter = 1; }
  else if(($month > 3) && ($month <= 6)){ $quarter = 2; }
  else if(($month > 6) && ($month <= 9)){ $quarter = 3; }
  else if(($month > 7) && ($month <= 12)){ $quarter = 4; }

  if(($month > 0) && ($month <= 4)){ $trimester = 1; }
  else if(($month > 4) && ($month <= 8)){ $trimester = 2; }
  else if(($month > 8) && ($month <= 12)){ $trimester = 3; }

  if(($month > 0) && ($month <= 6)){ $semiannual = 1; }
  else if(($month > 6) && ($month <= 12)){ $semiannual = 2; }

  $annual = $b[0];

  // Check bw
  $bw = 0;
  $bw_cat = 0;

  // $strSQL = "SELECT * FROM nis_neonate_patient WHERE neo_id = '$id' AND neo_serial = '$serial' AND neo_uid = '$uid'";
  $strSQL = "SELECT * FROM nis_neonate_patient WHERE neo_serial = '$serial' AND neo_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);

  if(($result) && (mysqli_num_rows($result) > 0)){
    $data = mysqli_fetch_assoc($result);
    $bw = $data['neo_bw'];
    $bw_cat = $data['neo_bw_cat'];
  }

  if($rid != ''){
    $strSQL = "UPDATE nis_neo_deviceday
               SET
                ndw_ddate = '$ddate',
                ndw_losa = '$los',
                ndw_bw = '$bw',
                ndw_bwcat = '$bw_cat',
                ndw_cath = '$cath',
                ndw_vent = '$vent',
                ndw_monthly = '$month',
                ndw_bimonth = '$bimonth',
                ndw_quarter = '$quarter',
                ndw_trimeater = '$trimester',
                ndw_semiannual = '$semiannual',
                ndw_annual = '$annual',
                ndw_udatetime = '$sysdatetime'
              WHERE
                ndw_id = '$rid' AND ndw_neo_serial = '$serial' AND ndw_uid = '$uid'
              ";
    $resultUpdate = mysqli_query($conn, $strSQL);
    if($resultUpdate){ echo "Y"; }
  }else{
    $strSQL = "INSERT INTO nis_neo_deviceday
                (
                  ndw_ddate, ndw_losa, ndw_bw, ndw_bwcat, ndw_cath,
                  ndw_vent, ndw_monthly, ndw_bimonth, ndw_quarter, ndw_trimeater,
                  ndw_semiannual, ndw_annual, ndw_udatetime, ndw_neo_serial, ndw_uid
                )
                VALUES
                (
                  '$ddate', '$los', '$bw', '$bw_cat', '$cath',
                  '$vent', '$month', '$bimonth', '$quarter', '$trimester',
                  '$semiannual', '$annual', '$sysdatetime', '$serial', '$uid'
                )
              ";
    $resultInsert = mysqli_query($conn, $strSQL);
    if($resultInsert){ echo "Y"; }
  }

  mysqli_close($conn);
  die();

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

if($stage == 'info2_byid'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['rid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);

  $strSQL = "SELECT * FROM nis_neonate_patient a LEFT JOIN nis_neo_dai b ON a.neo_serial = b.nai_neo_serial
            WHERE a.neo_uid = '$uid' AND b.nai_id = '$rid'";
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

if($stage == 'info3_byid'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['rid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);

  $strSQL = "SELECT * FROM nis_neonate_patient a LEFT JOIN nis_neo_otherinfect b ON a.neo_serial = b.serial_no
            WHERE a.neo_uid = '$uid' AND b.ID = '$rid'";
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

if($stage == 'info_byid'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['rid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $rid = mysqli_real_escape_string($conn, $_POST['rid']);

  $strSQL = "SELECT * FROM nis_neonate_patient a LEFT JOIN nis_neo_deviceday b ON a.neo_serial = b.ndw_neo_serial
            WHERE a.neo_uid = '$uid' AND b.ndw_id = '$rid'";
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

    // $strSQL = "SELECT * FROM nis_neo_deviceday WHERE ndw_uid = '$uid' AND ndw_neo_serial = '$serial'";
    // $resultCheck = mysqli_query($conn, $strSQL);
    // if(($resultCheck) && (mysqli_num_rows($resultCheck) > 0)){
    //
    // }else{
    //   while ($row = mysqli_fetch_array($result)) {
    //     $buf = array();
    //     foreach ($row as $key => $value) {
    //         if(!is_int($key)){
    //           $buf[$key] = $value;
    //         }
    //     }
    //     $return[] = $buf;
    //     echo json_encode($return);
    //   }
    // }

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
