<?php
include "../conf.inc.php";
include "../connect.inc.php";
include "../function.inc.php";



$return = array();

if(
    (!isset($_GET['uid'])) ||
    (!isset($_GET['start'])) ||
    (!isset($_GET['end'])) ||
    (!isset($_GET['dataset']))
){
    mysqli_close($conn);
    die();
}

$uid = mysqli_real_escape_string($conn, $_GET['uid']);
$start = mysqli_real_escape_string($conn, $_GET['start']);
$end = mysqli_real_escape_string($conn, $_GET['end']);
$dataset = mysqli_real_escape_string($conn, $_GET['dataset']);

if($dataset == '1') // Patient{
{
  $strExcelFileName = date('U')."-neo-patient.xls";
  header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
  header("Pragma: no-cache");

  $strSQL = "SELECT neo_serial, neo_hn, neo_sex, neo_ga, neo_bw, neo_admission, neo_discharge, neo_die, neo_los, neo_bw_cat
             FROM nis_neonate_patient
             WHERE
             neo_uid = '$uid'
             AND neo_year >= '$start'
             AND neo_year <= '$end'
            ";
  $result = mysqli_query($conn, $strSQL);
  if(($result) && (mysqli_num_rows($result) > 0)){
    while ($row = mysqli_fetch_array($result)) {
      $buf = array();
      $buf['Serial'] = $row['neo_serial'];
      $buf['HN'] = $row['neo_hn'];
      $buf['Gender'] = $row['neo_sex'];
      $buf['GA'] = $row['neo_ga'];
      $buf['BW'] = $row['neo_bw'];
      $buf['BW_CAT'] = $row['neo_bw_cat'];
      $buf['Admission'] = $row['neo_admission'];
      $buf['Discharge'] = $row['neo_discharge'];
      $buf['Die'] = $row['neo_die'];
      $buf['LOS'] = $row['neo_los'];
      $return[] = $buf;
    }
  }

  echo "<table><thead>";
  echo "<tr>";
  foreach($return[0] as $key => $row){
    echo "<th>".$key."</th>";
  }
  echo "</tr></thead>";

  echo "<tbody>";
  foreach($return as $row){
    echo "<tr>";
    foreach($row as $key => $value){
      echo "<td>".$value."</td>";
    }
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";

  mysqli_close($conn);
  die();
}

if($dataset == '2') // Device indwelling
{
  $strExcelFileName = date('U')."-neo-deviceday.xls";
  header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
  header("Pragma: no-cache");

  $strSQL = "SELECT ndw_neo_serial, ndw_ddate, ndw_cath, ndw_vent, ndw_bw,
              ndw_bwcat, ndw_monthly, ndw_bimonth, ndw_quarter, ndw_trimeater,
              ndw_semiannual, ndw_annual
             FROM nis_neo_deviceday
             WHERE
             ndw_uid = '$uid'
             AND ndw_annual >= '$start'
             AND ndw_annual <= '$end'
             ORDER BY ndw_ddate
            ";
  $result = mysqli_query($conn, $strSQL);
  if(($result) && (mysqli_num_rows($result) > 0)){
    while ($row = mysqli_fetch_array($result)) {
      $buf = array();
      $buf['Serial'] = $row['ndw_neo_serial'];
      $buf['dDate'] = $row['ndw_ddate'];
      $buf['Cath'] = $row['ndw_cath'];
      $buf['Vent'] = $row['ndw_vent'];
      $buf['BW'] = $row['ndw_bw'];
      $buf['BW_CAT'] = $row['ndw_bwcat'];
      $buf['Monthly'] = $row['ndw_monthly'];
      $buf['Bimonth'] = $row['ndw_bimonth'];
      $buf['Quarter'] = $row['ndw_quarter'];
      $buf['Trimeater'] = $row['ndw_trimeater'];
      $buf['Semiannual'] = $row['ndw_semiannual'];
      $buf['Annual'] = $row['ndw_annual'];
      $return[] = $buf;
    }
  }

  echo "<table><thead>";
  echo "<tr>";
  foreach($return[0] as $key => $row){
    echo "<th>".$key."</th>";
  }
  echo "</tr></thead>";

  echo "<tbody>";
  foreach($return as $row){
    echo "<tr>";
    foreach($row as $key => $value){
      echo "<td>".$value."</td>";
    }
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";

  mysqli_close($conn);
  die();
}

if($dataset == '3') // Device associated infection
{
  $strExcelFileName = date('U')."-neo-dai.xls";
  header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
  header("Pragma: no-cache");

  $strSQL = "SELECT nai_neo_serial, nai_doe, nai_site, nai_bw, nai_bwcat, nai_pathogen,
              nai_bwcat, nai_monthly, nai_bimonth, nai_quarter, nai_trimeater,
              nai_semiannual, nai_annual
             FROM nis_neo_dai
             WHERE
             nai_uid = '$uid'
             AND nai_annual >= '$start'
             AND nai_annual <= '$end'
             ORDER BY nai_doe
            ";
  $result = mysqli_query($conn, $strSQL);
  if(($result) && (mysqli_num_rows($result) > 0)){
    while ($row = mysqli_fetch_array($result)) {
      $buf = array();
      $buf['Serial'] = $row['nai_neo_serial'];
      $buf['DOE'] = $row['nai_doe'];
      $buf['Site'] = $row['nai_site'];
      $buf['BW'] = $row['nai_bw'];
      $buf['BW_CAT'] = $row['nai_bwcat'];
      $buf['Pathogen'] = $row['nai_pathogen'];
      $buf['Monthly'] = $row['nai_monthly'];
      $buf['Bimonth'] = $row['nai_bimonth'];
      $buf['Quarter'] = $row['nai_quarter'];
      $buf['Trimeater'] = $row['nai_trimeater'];
      $buf['Semiannual'] = $row['nai_semiannual'];
      $buf['Annual'] = $row['nai_annual'];
      $return[] = $buf;
    }
  }

  echo "<table><thead>";
  echo "<tr>";
  foreach($return[0] as $key => $row){
    echo "<th>".$key."</th>";
  }
  echo "</tr></thead>";

  echo "<tbody>";
  foreach($return as $row){
    echo "<tr>";
    foreach($row as $key => $value){
      echo "<td>".$value."</td>";
    }
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";

  mysqli_close($conn);
  die();
}

if($dataset == '4') // Other infection
{
  $strExcelFileName = date('U')."-neo-other.xls";
  header("Content-Type: application/x-msexcel; name=\"$strExcelFileName\"");
  header("Content-Disposition: inline; filename=\"$strExcelFileName\"");
  header("Pragma: no-cache");

  $strSQL = "SELECT serial_no, doe, site, pathogen
             FROM nis_neo_otherinfect
             WHERE
             neo_other_uid = '$uid'
             AND doe BETWEEN '$start-01-01' AND '$end-12-31'
             ORDER BY doe
            ";
  $result = mysqli_query($conn, $strSQL);
  if(($result) && (mysqli_num_rows($result) > 0)){
    while ($row = mysqli_fetch_array($result)) {
      $buf = array();
      $buf['Serial'] = $row['serial_no'];
      $buf['DOE'] = $row['doe'];
      $buf['Site'] = $row['site'];
      $buf['Pathogen'] = $row['pathogen'];
      $return[] = $buf;
    }
  }
  // echo $strSQL;
  echo "<table><thead>";
  echo "<tr>";
  foreach($return[0] as $key => $row){
    echo "<th>".$key."</th>";
  }
  echo "</tr></thead>";

  echo "<tbody>";
  foreach($return as $row){
    echo "<tr>";
    foreach($row as $key => $value){
      echo "<td>".$value."</td>";
    }
    echo "</tr>";
  }
  echo "</tbody>";
  echo "</table>";

  mysqli_close($conn);
  die();
}


?>
