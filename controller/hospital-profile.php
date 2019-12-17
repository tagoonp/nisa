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

if($stage == 'delete_ward'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['wid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $wid = mysqli_real_escape_string($conn, $_POST['wid']);

  $strSQL = "DELETE FROM nis_ward WHERE ID = '$wid' AND ward_uid = '$uid' ";
  $result = mysqli_query($conn, $strSQL);
  if($result){
    echo "Y";
  }
  mysqli_close($conn);
  die();
}

if($stage == 'get_ward'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['code']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $code = mysqli_real_escape_string($conn, $_POST['code']);

  $strSQL = "SELECT * FROM nis_ward WHERE code = '$code' AND ward_uid = '$uid' LIMIT 1";
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

if($stage == 'set_ward'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['code'])) ||
      (!isset($_POST['name'])) ||
      (!isset($_POST['phone'])) ||
      (!isset($_POST['wtype']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $code = mysqli_real_escape_string($conn, $_POST['code']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $phone = mysqli_real_escape_string($conn, $_POST['phone']);
  $wtype = mysqli_real_escape_string($conn, $_POST['wtype']);

  $buti = 0;
  $bbsi = 0;
  $dvae = 0;

  $strSQL = "SELECT * FROM nis_wardtype WHERE subtype = '$wtype' LIMIT 1";
  $resultW = mysqli_query($conn, $strSQL);
  if(($resultW) && (mysqli_num_rows($resultW) > 0)){
    $data = mysqli_fetch_assoc($resultW);
    $buti = $data['bUTI'];
    $bbsi = $data['bBSI'];
    $dvae = $data['bVAE'];
  }

  $strSQL = "SELECT * FROM nis_ward WHERE code = '$code' AND ward_uid = '$uid' LIMIT 1";
  $result = mysqli_query($conn, $strSQL);

  if(($result) && (mysqli_num_rows($result) > 0)){ // Have old valud
    $strSQL = "UPDATE nis_ward
               SET
                ward_name = '$name',
                tel = '$phone',
                ward_type = '$wtype',
                bUTI = '$buti',
                bBSI = '$bbsi',
                bVAE = '$dvae'
               WHERE
                code = '$code' AND ward_uid = '$uid'
              ";
    $resultUpdate = mysqli_query($conn, $strSQL);
    if($resultUpdate){
      echo "Y";
    }
  }else{
    $strSQL = "INSERT INTO nis_ward (code, ward_name, tel, ward_type, bUTI, bBSI, bVAE, ward_uid)
               VALUES ('$code', '$name', '$phone', '$wtype', '$buti', '$bbsi', '$dvae', '$uid')";
    $resultInsert = mysqli_query($conn, $strSQL);
    if($resultInsert){
      echo "Y";
    }
  }

  mysqli_close($conn);
  die();
}

if($stage == 'set_surgeon_still'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['sid'])) ||
      (!isset($_POST['to']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $sid = mysqli_real_escape_string($conn, $_POST['sid']);
  $to = mysqli_real_escape_string($conn, $_POST['to']);

  $strSQL = "UPDATE nis_surgeon SET sur_stillfunction = '$to' WHERE ID = '$sid' AND sur_uid = '$uid' ";
  $result = mysqli_query($conn, $strSQL);
  if($result){
    echo "Y";
  }
  mysqli_close($conn);
  die();
}

if($stage == 'delete_surgeon'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['sid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $sid = mysqli_real_escape_string($conn, $_POST['sid']);

  $strSQL = "DELETE FROM nis_surgeon WHERE ID = '$sid' AND sur_uid = '$uid' ";
  $result = mysqli_query($conn, $strSQL);
  if($result){
    echo "Y";
  }
  mysqli_close($conn);
  die();
}

if($stage == 'set_surgeon'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['code'])) ||
      (!isset($_POST['name'])) ||
      (!isset($_POST['still']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $code = mysqli_real_escape_string($conn, $_POST['code']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $still = mysqli_real_escape_string($conn, $_POST['still']);

  $strSQL = "SELECT * FROM nis_surgeon WHERE sur_id = '$code' AND sur_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);
  if(($result) && (mysqli_num_rows($result) > 0)){ // Have old valud
    $data = mysqli_fetch_assoc($result);
    if($data['sur_delete'] == 1){
      $strSQL = "UPDATE nis_surgeon
                 SET
                  sur_name = '$name',
                  sur_stillfunction = '$still',
                  sur_delete = '0'
                 WHERE
                  sur_id = '$code' AND sur_uid = '$uid'
                ";
      $resultUpdate = mysqli_query($conn, $strSQL);
      if($resultUpdate){
        echo "Y";
      }
    }else{
      $strSQL = "UPDATE nis_surgeon
                 SET
                  sur_name = '$name',
                  sur_stillfunction = '$still'
                 WHERE
                  sur_id = '$code' AND sur_uid = '$uid'
                ";
      $resultUpdate = mysqli_query($conn, $strSQL);
      if($resultUpdate){
        echo "Y";
      }
    }

  }else{
    $strSQL = "INSERT INTO nis_surgeon (sur_id, sur_name, sur_stillfunction, sur_regdatetime, sur_uid) VALUES ('$code', '$name', '$still', '$sysdatetime', '$uid')";
    $resultInsert = mysqli_query($conn, $strSQL);
    if($resultInsert){
      echo "Y";
    }
  }

  mysqli_close($conn);
  die();
}

if($stage == 'get_surgeon'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['sid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $sid = mysqli_real_escape_string($conn, $_POST['sid']);

  $strSQL = "SELECT * FROM nis_surgeon WHERE sur_id = '$sid' AND sur_uid = '$uid' AND sur_delete = '0'";
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

if($stage == 'delete_nicu'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['nicu_id']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $nicu_id = mysqli_real_escape_string($conn, $_POST['nicu_id']);

  $strSQL = "DELETE FROM nis_hospital_profile WHERE hos_id = '$nicu_id' AND hos_uid = '$uid'";
  $result = mysqli_query($conn, $strSQL);
  if($result){
    echo "Y";
  }

  mysqli_close($conn);
  die();
}

if($stage == 'nicu'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['nicu']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $nicu = mysqli_real_escape_string($conn, $_POST['nicu']);

  $strSQL = "UPDATE nis_hospital_profile SET hos_use_status = 'N' WHERE hos_uid = '$uid' ";
  $result = mysqli_query($conn, $strSQL);
  if($result){
    $strSQL = "INSERT INTO nis_hospital_profile (hos_udatetime, hos_nicu_level, hos_uid) VALUES ('$sysdatetime', '$nicu', '$uid')";
    $resultInsert = mysqli_query($conn, $strSQL);
    if($resultInsert){
      echo "Y";
    }
  }
  mysqli_close($conn);
  die();
}

if($stage == 'saveFontsize'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['current_fsize']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $current_fsize = mysqli_real_escape_string($conn, $_POST['current_fsize']);

  $strSQL = "UPDATE nis_useraccount SET fontsize = '$current_fsize' WHERE uid = '$uid' ";
  $result = mysqli_query($conn, $strSQL);
  mysqli_close($conn);
  die();
}

if($stage == 'login'){
  if(
      (!isset($_POST['username'])) ||
      (!isset($_POST['password']))
  ){
      mysqli_close($conn);
      die();
  }

  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);
  $password = base64_encode($password);

  $strSQL = "SELECT * FROM nis_useraccount WHERE username = '$username' AND password = '$password' AND delete_status = 'N'";
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




?>
