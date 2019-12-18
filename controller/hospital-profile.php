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

if($stage == 'delete_hospinfo'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['hid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $hid = mysqli_real_escape_string($conn, $_POST['hid']);

  $strSQL = "DELETE FROM nis_hospchar WHERE hosp_id = '$hid' AND hosp_uid = '$uid' ";
  $result = mysqli_query($conn, $strSQL);
  if($result){
    echo "Y";
  }
  mysqli_close($conn);
  die();
}

if($stage == 'set_hospital'){
  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['name'])) ||
      (!isset($_POST['address'])) ||
      (!isset($_POST['country'])) ||
      (!isset($_POST['bedsize'])) ||
      (!isset($_POST['type'])) ||
      (!isset($_POST['school'])) ||
      (!isset($_POST['pvent'])) ||
      (!isset($_POST['pdian']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $name = mysqli_real_escape_string($conn, $_POST['name']);
  $address = mysqli_real_escape_string($conn, $_POST['address']);
  $country = mysqli_real_escape_string($conn, $_POST['country']);
  $bedsize = mysqli_real_escape_string($conn, $_POST['bedsize']);
  $type = mysqli_real_escape_string($conn, $_POST['type']);
  $school = mysqli_real_escape_string($conn, $_POST['school']);
  $pvent = mysqli_real_escape_string($conn, $_POST['pvent']);
  $pdian = mysqli_real_escape_string($conn, $_POST['pdian']);

  $strSQL = "UPDATE nis_hospchar SET hosp_status = '0' WHERE hosp_uid = '$uid'";
  $resultUpdate = mysqli_query($conn, $strSQL);

  if($resultUpdate){

    $strSQL = "SELECT CallingCode FROM nis_country WHERE CountryID = '$country'";
    $resultCountry = mysqli_query($conn, $strSQL);
    $czip = '';
    if($resultCountry){
      $data = mysqli_fetch_assoc($resultCountry);
      $czip = $data['CallingCode'];
    }

    $schUti = 0;
    $schBsi = 0;
    $schVae = 0;
    $strSQL = "SELECT * FROM nis_code_school WHERE sc_code = '$school'";
    $resultSchool = mysqli_query($conn, $strSQL);
    if($resultSchool){
      $data = mysqli_fetch_assoc($resultSchool);
      $schUti = $data['bSchoolUTI'];
      $schBsi = $data['bSchoolBSI'];
      $schVae = $data['bSchoolVAE'];
    }

    $hUti = 0;
    $hBsi = 0;
    $hVae = 0;
    $strSQL = "SELECT * FROM nis_code_hosptype WHERE ht_code = '$type'";
    $resultType = mysqli_query($conn, $strSQL);
    if($resultType){
      $data = mysqli_fetch_assoc($resultType);
      $hUti = $data['bHospTypeUTI'];
      $hBsi = $data['bHospTypeBSI'];
      $hVae = $data['bHospTypeVAE'];
    }

    $strSQL = "INSERT INTO nis_hospchar
              (
                hosp_udatetime, hosp_hospname, hosp_address, hosp_country, hosp_zipcode,
                hosp_bedsize, hosp_hosptype, hosp_school, hosp_pvent, hosp_pdian,
                hosp_bHosTypeUTI, hosp_bHosTypeBSI, hosp_bHosTypeVAE, hosp_bSchoolUTI, hosp_bSchoolBSI,
                hosp_bSchoolVAE, hosp_uid
              )
              VALUES
              (
                '$sysdatetime', '$name', '$address', '$country', '$czip',
                '$bedsize', '$type', '$school', '$pvent', '$pdian',
                '$hUti', '$hBsi', '$hVae', '$schUti', '$schBsi',
                '$schVae', '$uid'
              )
              ";
    $resultInsert = mysqli_query($conn, $strSQL);
    if($resultInsert){
      echo "Y";
    }else{
      echo "N";
    }
  }

  mysqli_close($conn);
  die();
}

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
