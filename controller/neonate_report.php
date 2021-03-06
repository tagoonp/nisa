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

if($stage == 'reportCLASBI'){

  if(
      (!isset($_POST['uid'])) ||
      (!isset($_POST['startMonth'])) ||
      (!isset($_POST['endMonth'])) ||
      (!isset($_POST['period']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $start = mysqli_real_escape_string($conn, $_POST['startMonth']);
  $end = mysqli_real_escape_string($conn, $_POST['endMonth']);
  $period = mysqli_real_escape_string($conn, $_POST['period']);

  $y1b = explode('-', $start);
  $y1 = $y1b[0];

  $y2b = explode('-', $end);
  $y2 = $y2b[0];
  $round = 1;

  if($y1 != $y2){
    $round = ($y2 - $y1) + 1;
  }

  ?>
  <table id="tableQuarter" class="table table-bordered table-sm mb-0" border="1">
      <thead>
        <tr style="background: rgb(223, 223, 223);">
          <th>Year</th>
          <th>Quarter</th>
          <th>Birthweight</th>
          <th>CLABSI</th>
          <th>Catheter-days</th>
          <th>Rate</th>
          <th>SIR</th>
          <th>LWL</th>
          <th>CL</th>
          <th>UWL</th>
          <th>UCL</th>
        </tr>
      </thead>
      <tbody>
  <?php
  if($period == 'Quarter'){
    for ($i=0; $i < $round ; $i++) {
      $total_g1 = 0; $total_g2 = 0; $total_g3 = 0; $total_g4 = 0; $total_g5 = 0;
      $cd1 = 0; $cd2 = 0; $cd3 = 0; $cd4 = 0; $cd5 = 0;
      ?>
      <tr>
        <td rowspan="25" style="vertical-align: top;"><?php echo ($y1 - 1) + 1; ?></td>
        <td rowspan="6" style="vertical-align: top;">1st</td>
        <td> < 751 gms. </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 1, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1; $buffer_1 = 3; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 1, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; $buffer_2 = 54; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $b4 = $buffer_1/($buffer_2 * getSIR($conn, 'CLABSI', 1)); echo number_format($b4, 1); ?></td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>751-1000 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 2, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 2, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $b4 = $buffer_2 * getSIR($conn, 'CLABSI', 2); echo $b4; ?></td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>1001-1500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 3, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 3, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $b4 = $buffer_2 * getSIR($conn, 'CLABSI', 3); echo $b4; ?></td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>1501-2500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 4, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 4, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $b4 = $buffer_2 * getSIR($conn, 'CLABSI', 4); echo $b4; ?></td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td> >2500 gms </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 5, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 5, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $b4 = $buffer_2 * getSIR($conn, 'CLABSI', 5); echo $b4; ?></td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>Total</td>
        <td><?php echo number_format($total_g1); ?></td>
        <td><?php echo number_format($cd1); ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td rowspan="6" style="vertical-align: top;">2nd</td>
        <td> < 751 gms. </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 1, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 1, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>

      <tr>
        <td>751-1000 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 2, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 2, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>a</td>
      </tr>
      <tr>
        <td>1001-1500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 3, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 3, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>a</td>
      </tr>
      <tr>
        <td>1501-2500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 4, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 4, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>a</td>
      </tr>
      <tr>
        <td> >2500 gms </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 5, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 5, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>a</td>
      </tr>
      <tr>
        <td>Total</td>
        <td><?php echo number_format($total_g2); ?></td>
        <td><?php echo number_format($cd2); ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td rowspan="6" style="vertical-align: top;">3rd</td>
        <td> < 751 gms. </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 1, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 1, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>751-1000 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 2, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 2, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>1001-1500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 3, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 3, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>1501-2500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 4, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 4, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td> >2500 gms </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 5, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 5, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>Total</td>
        <td><?php echo number_format($total_g3); ?></td>
        <td><?php echo number_format($cd3); ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td rowspan="6" style="vertical-align: top;">4th</td>
        <td> < 751 gms. </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 1, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 1, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>751-1000 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 2, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 2, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>1001-1500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 3, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 3, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>1501-2500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 4, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 4, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td> >2500 gms </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 5, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 5, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td>h</td>
        <td>j</td>
        <td>k</td>
        <td>k</td>
        <td>k</td>
      </tr>
      <tr>
        <td>Total</td>
        <td><?php echo number_format($total_g4); ?></td>
        <td><?php echo number_format($cd4); ?></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td colspan="2" style="font-weight: bold;">GRAND TOTAL</td>
        <td style="font-weight: bold;"><?php echo number_format($total_g1 + $total_g2 + $total_g3 + $total_g4); ?></td>
        <td style="font-weight: bold;"><?php echo number_format($cd1 + $cd2 + $cd3 + $cd4); ?></td>
        <td style="font-weight: bold;">h</td>
        <td style="font-weight: bold;">j</td>
        <td style="font-weight: bold;">k</td>
        <td style="font-weight: bold;">k</td>
        <td style="font-weight: bold;">k</td>
        <td style="font-weight: bold;">k</td>
      </tr>


      <?php
      $y1++;
    }

  }
  ?>
    </tbody>
  </table>
  <?php
  mysqli_close($conn);
  die();
}

function getCatheterday($conn, $site, $bw_cat, $param, $value, $uid, $start, $end, $annual ){
  $start = $start."-01";
  $end = $end."-31";
  $strSQL = "SELECT
              COUNT(*) cn
             FROM nis_neonate_patient a INNER JOIN nis_neo_deviceday c ON a.neo_serial = c.ndw_neo_serial
             WHERE
              a.neo_uid = '$uid'
              AND c.ndw_$param = '$value'
              AND c.ndw_annual = '$annual'
              AND a.neo_serial IN (
                  SELECT
                  a.neo_serial neo_serial
                  FROM nis_neonate_patient a INNER JOIN nis_neo_dai b ON a.neo_serial = b.nai_neo_serial
                  WHERE
                    a.neo_uid = '$uid'
                    AND b.nai_doe BETWEEN '$start' AND '$end'
                    AND b.nai_site = '$site'
                    AND b.nai_bwcat = '$bw_cat'
                    AND b.nai_$param = '$value'
                    GROUP BY a.neo_serial
              )
              ";
   $result = mysqli_query($conn, $strSQL);
   if(($result) && (mysqli_num_rows($result) > 0)){
     $data = mysqli_fetch_assoc($result);
     return $data['cn'];
   }else{
     // echo $strSQL;
     return 0;
   }
   mysqli_close($conn);
   die();
}

function getData($conn, $site, $bw_cat, $param, $value, $uid, $start, $end, $annual, $sum_subgroup){
  $start = $start."-01";
  $end = $end."-31";
  $strSQL = "SELECT
              COUNT(*) cn
             FROM nis_neonate_patient a INNER JOIN nis_neo_dai b ON a.neo_serial = b.nai_neo_serial
             WHERE
              a.neo_uid = '$uid'
              AND b.nai_doe BETWEEN '$start' AND '$end'
              AND b.nai_site = '$site'
              AND b.nai_bwcat = '$bw_cat'
              AND b.nai_annual = '$annual'
              AND b.nai_".$param." = '$value'
              ";
   $result = mysqli_query($conn, $strSQL);
   if(($result) && (mysqli_num_rows($result) > 0)){
     $data = mysqli_fetch_assoc($result);
     return $data['cn'];
   }else{
     return 0;
   }
   mysqli_close($conn);
   die();
}

function getSIR($conn, $site, $bw_cate){
  $strSQL = "SELECT intercept FROM nis_code_site_dia WHERE site = '$site'";
  $resultA = mysqli_query($conn, $strSQL);
  $a = 0;
  if(($resultA) && (mysqli_num_rows($resultA) > 0)){
    $dataA = mysqli_fetch_assoc($resultA);
    $a = $dataA['intercept'];
  }

  $strSQL = "SELECT bBSI FROM nis_code_bwcat WHERE bwcat = '$bw_cate'";
  $resultB = mysqli_query($conn, $strSQL);
  $b = 0;
  if(($resultB) && (mysqli_num_rows($resultB) > 0)){
    $dataA = mysqli_fetch_assoc($resultB);
    $b = $dataA['bBSI'];
  }

  $baseVal = exp($a + $b);
  // echo $a . "<br>";
  // echo $b . "<br>";
  // echo $a + $b . "<br>";
  echo $baseVal."<br>";
  return $baseVal;

  mysqli_close($conn);
  die();
}
?>
