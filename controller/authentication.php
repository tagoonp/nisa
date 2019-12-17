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

if($stage == 'getFontsize'){
  if(
      (!isset($_POST['uid']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);

  $strSQL = "SELECT fontsize FROM nis_useraccount WHERE uid = '$uid' AND fontsize IS NOT NULL LIMIT 1 ";
  $result = mysqli_query($conn, $strSQL);
  if($result){
    $data = mysqli_fetch_assoc($result);
    echo $data['fontsize'];
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
