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

if($stage == 'gettable'){

  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['year'])) ||
      (!isset($_POST['table']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $year = mysqli_real_escape_string($conn, $_POST['year']);
  $table = mysqli_real_escape_string($conn, $_POST['table']);
  $vrow = mysqli_real_escape_string($conn, $_POST['vrow']);

  if($table == 'deviceday'){
    $columData = array();
    $strSQL = "SELECT * FROM nis_neo_deviceday WHERE ndw_uid = '$uid' AND YEAR(ndw_ddate) = '$year' ORDER BY ndw_ddate, ndw_neo_serial DESC LIMIT $vrow";
    $resultHosphistory = mysqli_query($conn, $strSQL);
    if(($resultHosphistory) && (mysqli_num_rows($resultHosphistory) > 0)){
      while ($row = mysqli_fetch_array($resultHosphistory)) {
        $buf = array();
        foreach ($row as $key => $value) {
            if(!is_int($key)){
              $buf[$key] = $value;
            }
        }
        $columData[] = $buf;
      }

      if(sizeof($columData) != 0){
        foreach ($columData as $rowData) {
          ?>
          <tr>
            <td><?php echo $rowData['ndw_neo_serial']; ?></td>
            <td><?php echo $rowData['ndw_ddate']; ?></td>
            <td><?php echo $rowData['ndw_cath']; ?></td>
            <td><?php echo $rowData['ndw_vent']; ?></td>
            <td><?php echo $rowData['ndw_bw']; ?></td>
            <td><?php echo $rowData['ndw_bwcat']; ?></td>
            <td>
              <button type="button" class="btn btn-sm btn-icon" name="button" onclick="setLocalData('<?php echo $rowData['ndw_id'];?>', '<?php echo $rowData['ndw_neo_serial'];?>')"><i class="fas fa-pencil-alt text-dark"></i></button>
              <button type="button" class="btn btn-sm btn-icon" name="button" onclick="neonate.delDevicewelling('<?php echo $rowData['ndw_id'];?>')"><i class="fas fa-trash text-danger"></i></button>
            </td>
          </tr>
          <?php
        }
      }
    }
  }else if($table == 'dai'){
    $columData = array();
    $strSQL = "SELECT * FROM nis_neo_dai WHERE nai_uid = '$uid' AND YEAR(nai_doe) = '$year' ORDER BY nai_doe, nai_neo_serial DESC LIMIT $vrow";
    $resultHosphistory = mysqli_query($conn, $strSQL);
    if(($resultHosphistory) && (mysqli_num_rows($resultHosphistory) > 0)){
      while ($row = mysqli_fetch_array($resultHosphistory)) {
        $buf = array();
        foreach ($row as $key => $value) {
            if(!is_int($key)){
              $buf[$key] = $value;
            }
        }
        $columData[] = $buf;
      }

      if(sizeof($columData) != 0){
        foreach ($columData as $rowData) {
          ?>
          <tr>
            <td>
              <button type="button" class="btn btn-sm btn-icon" name="button" onclick="setLocalData2('<?php echo $rowData['nai_id'];?>', '<?php echo $rowData['nai_neo_serial'];?>')"><i class="fas fa-pencil-alt text-dark"></i></button>
              <button type="button" class="btn btn-sm btn-icon" name="button" onclick="neonate.delDeviceinfection('<?php echo $rowData['nai_id'];?>')"><i class="fas fa-trash text-danger"></i></button>
            </td>
            <td><?php echo $rowData['nai_neo_serial']; ?></td>
            <td><?php echo $rowData['nai_doe']; ?></td>
            <td><?php echo $rowData['nai_site']; ?></td>
            <td><?php echo $rowData['nai_bw']; ?></td>
            <td><?php echo $rowData['nai_bwcat']; ?></td>
            <td><?php echo $rowData['nai_pathogen']; ?></td>
          </tr>
          <?php
        }
      }
    }
  }

  mysqli_close($conn);
  die();
}

?>
