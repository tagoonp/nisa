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
      (!isset($_POST['period'])) ||
      (!isset($_POST['type']))
  ){
      mysqli_close($conn);
      die();
  }

  $uid = mysqli_real_escape_string($conn, $_POST['uid']);
  $start = mysqli_real_escape_string($conn, $_POST['startMonth']);
  $end = mysqli_real_escape_string($conn, $_POST['endMonth']);
  $period = mysqli_real_escape_string($conn, $_POST['period']);
  $rtype = mysqli_real_escape_string($conn, $_POST['type']);

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
          <th style="display: none;">nLCL</th>
          <th>LCL</th>
          <th style="display: none;">nLWL</th>
          <th>LWL</th>
          <th style="display: none;">nUWL</th>
          <th>UWL</th>
          <th style="display: none;">nUCL</th>
          <th>UCL</th>
        </tr>
      </thead>
      <tbody>
  <?php
  if($period == 'Quarter'){
    for ($i=0; $i < $round ; $i++) {
      $total_g1 = 0; $total_g2 = 0; $total_g3 = 0; $total_g4 = 0;
      $cd1 = 0; $cd2 = 0; $cd3 = 0; $cd4 = 0;
      $cad1 = 0; $cad2 = 0; $cad3 = 0; $cad4 = 0;
      $sir1 = 0; $sir2 = 0; $sir3 = 0; $sir4 = 0;
      ?>
      <tr>
        <td rowspan="25" style="vertical-align: top;"><?php echo ($y1 - 1) + 1; ?></td>
        <td rowspan="6" style="vertical-align: top;">1st</td>
        <td> < 751 gms. </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 1, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1; //$buffer_1 = 3; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 1, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; //$buffer_2 = 54; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 1)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad1 += ($buffer_2 * getSIR($conn, 'CLABSI', 1)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>751-1000 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 2, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1;  //$buffer_1 = 2; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 2, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; //$buffer_2 = 93; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 2)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad1 += ($buffer_2 * getSIR($conn, 'CLABSI', 2)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>1001-1500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 3, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 3, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 3)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad1 += ($buffer_2 * getSIR($conn, 'CLABSI', 3)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>1501-2500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 4, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 4, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 4)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad1 += ($buffer_2 * getSIR($conn, 'CLABSI', 4)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td> >2500 gms </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 5, 'quarter', 1, $uid, $start, $end, $y1, $total_g1); echo number_format($buffer_1); $total_g1 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 5, 'quarter', 1, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd1 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 5)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad1 += ($buffer_2 * getSIR($conn, 'CLABSI', 5)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>Total</td>
        <td><?php echo number_format($total_g1); ?></td>
        <td><?php echo number_format($cd1); ?></td>
        <td><?php $buffer_3 = 0; if($cd1 != 0){ $buffer_3 = ($total_g1 * 1000)/$cd1; } echo number_format($buffer_3, 1); ?></td>
        <td><?php $sir1 = 0; if($cad1 != 0){  $sir1= $total_g1/$cad1; } echo number_format($sir1, 1);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g1), 'r2')/2; echo number_format(($buffer_5), 4);?></td>
        <td><?php $buffer_6 = 0; if($cad1 != 0){ $buffer_6 = $buffer_5/$cad1; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($cad1 != 0){ $buffer_6 = $buffer_5/$cad1; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($cad1 != 0){ $buffer_6 = $buffer_5/$cad1; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($cad1 != 0){ $buffer_6 = $buffer_5/$cad1; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td rowspan="6" style="vertical-align: top;">2nd</td>
        <td> < 751 gms. </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 1, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 1, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 1)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad2 += ($buffer_2 * getSIR($conn, 'CLABSI', 1)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>

      <tr>
        <td>751-1000 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 2, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 2, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 2)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad2 += ($buffer_2 * getSIR($conn, 'CLABSI', 2)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>1001-1500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 3, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 3, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 3)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad2 += ($buffer_2 * getSIR($conn, 'CLABSI', 3)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>1501-2500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 4, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 4, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 4)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad2 += ($buffer_2 * getSIR($conn, 'CLABSI', 4)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td> >2500 gms </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 5, 'quarter', 2, $uid, $start, $end, $y1, $total_g2); echo number_format($buffer_1); $total_g2 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 5, 'quarter', 2, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd2 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 5)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad2 += ($buffer_2 * getSIR($conn, 'CLABSI', 5)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>Total</td>
        <td><?php echo number_format($total_g2); ?></td>
        <td><?php echo number_format($cd2); ?></td>
        <td><?php $buffer_3 = 0; if($cd2 != 0){ $buffer_3 = ($total_g2 * 1000)/$cd2; } echo number_format($buffer_3, 1); ?></td>
        <td><?php $sir2 = 0; if($cad2 != 0){  $sir2 = $total_g2/$cad2; } echo number_format($sir2, 1);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g2), 'r2')/2; echo number_format(($buffer_5), 4);?></td>
        <td><?php $buffer_6 = 0; if($cad2 != 0){ $buffer_6 = $buffer_5/$cad2; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g2), 'r1')/2; echo number_format(($buffer_5), 4);?></td>
        <td><?php $buffer_6 = 0; if($cad2 != 0){ $buffer_6 = $buffer_5/$cad2; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g2 + 1), 'r3')/2; echo number_format(($buffer_5), 4);?></td>
        <td><?php $buffer_6 = 0; if($cad2 != 0){ $buffer_6 = $buffer_5/$cad2; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g2 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($cad2 != 0){ $buffer_6 = $buffer_5/$cad2; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>

      <tr>
        <td rowspan="6" style="vertical-align: top;">3rd</td>
        <td> < 751 gms. </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 1, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1;  ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 1, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 1)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad3 += ($buffer_2 * getSIR($conn, 'CLABSI', 1)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>751-1000 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 2, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 2, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 2)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad3 += ($buffer_2 * getSIR($conn, 'CLABSI', 2)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>1001-1500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 3, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 3, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 3)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad3 += ($buffer_2 * getSIR($conn, 'CLABSI', 3)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>1501-2500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 4, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 4, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 4)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad3 += ($buffer_2 * getSIR($conn, 'CLABSI', 4)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td> >2500 gms </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 5, 'quarter', 3, $uid, $start, $end, $y1, $total_g3); echo number_format($buffer_1); $total_g3 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 5, 'quarter', 3, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd3 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 5)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad3 += ($buffer_2 * getSIR($conn, 'CLABSI', 5)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>Total</td>
        <td><?php echo number_format($total_g3); ?></td>
        <td><?php echo number_format($cd3); ?></td>
        <td><?php $buffer_3 = 0; if($cd3 != 0){ $buffer_3 = ($total_g3 * 1000)/$cd3; } echo number_format($buffer_3, 1); ?></td>
        <td><?php $sir3 = 0; if($cad3 != 0){  $sir3= $total_g3/$cad3; } echo number_format($sir3, 1);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g3), 'r2')/2; echo number_format(($buffer_5), 4);?></td>
        <td><?php $buffer_6 = 0; if($cad3 != 0){ $buffer_6 = $buffer_5/$cad3; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g3), 'r1')/2; echo number_format(($buffer_5), 4);?></td>
        <td><?php $buffer_6 = 0; if($cad3 != 0){ $buffer_6 = $buffer_5/$cad3; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g3 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($cad3 != 0){ $buffer_6 = $buffer_5/$cad3; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g3 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($cad3 != 0){ $buffer_6 = $buffer_5/$cad3; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>

      <tr>
        <td rowspan="6" style="vertical-align: top;">4th</td>
        <td> < 751 gms. </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 1, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 1, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 1)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad4 += ($buffer_2 * getSIR($conn, 'CLABSI', 1)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>751-1000 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 2, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 2, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 2)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad4 += ($buffer_2 * getSIR($conn, 'CLABSI', 2)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>1001-1500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 3, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 3, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 3)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad4 += ($buffer_2 * getSIR($conn, 'CLABSI', 3)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>1501-2500 gms</td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 4, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 4, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 4)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad4 += ($buffer_2 * getSIR($conn, 'CLABSI', 4)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td> >2500 gms </td>
        <td><?php $buffer_1 = getData($conn, 'CLABSI', 5, 'quarter', 4, $uid, $start, $end, $y1, $total_g4); echo number_format($buffer_1); $total_g4 += $buffer_1; ?></td>
        <td><?php $buffer_2 = getCatheterday($conn, 'CLABSI', 5, 'quarter', 4, $uid, $start, $end, $y1); echo number_format($buffer_2); $cd4 += $buffer_2; ?></td>
        <td><?php $b3 = 0; if($buffer_2 != 0){ $buffer_3 = ($buffer_1 * 1000)/$buffer_2; echo number_format($buffer_3, 1); $b3 = $buffer_3;}else{echo 0;} ?></td>
        <td><?php $bb4 = ($buffer_2 * getSIR($conn, 'CLABSI', 5)); if($bb4 != 0){ $b4 = $buffer_1/$bb4; }else{ $b4 = 0;} $cad4 += ($buffer_2 * getSIR($conn, 'CLABSI', 5)); echo number_format($b4, 1); ?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r2')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1), 'r1')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($buffer_1 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($bb4 != 0){ $buffer_6 = $buffer_5/$bb4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>
      <tr>
        <td>Total</td>
        <td><?php echo number_format($total_g4); ?></td>
        <td><?php echo number_format($cd4); ?></td>
        <td><?php $buffer_3 = 0; if($cd4 != 0){ $buffer_3 = ($total_g4 * 1000)/$cd4; } echo number_format($buffer_3, 1); ?></td>
        <td><?php $sir4 = 0; if($cad4 != 0){  $sir4 = $total_g1/$cad4; } echo number_format($sir4, 1);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g4), 'r2')/2; echo number_format(($buffer_5), 4);?></td>
        <td><?php $buffer_6 = 0; if($cad4 != 0){ $buffer_6 = $buffer_5/$cad4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g4), 'r1')/2; echo number_format(($buffer_5), 4);?></td>
        <td><?php $buffer_6 = 0; if($cad4 != 0){ $buffer_6 = $buffer_5/$cad4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g4 + 1), 'r3')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($cad4 != 0){ $buffer_6 = $buffer_5/$cad4; }; echo number_format($buffer_6, 2);?></td>
        <td style="display: none;"><?php $buffer_5 = getnLCL($conn, ($total_g4 + 1), 'r4')/2; echo number_format($buffer_5, 4);?></td>
        <td><?php $buffer_6 = 0; if($cad4 != 0){ $buffer_6 = $buffer_5/$cad4; }; echo number_format($buffer_6, 2);?></td>
        <!-- <td>1</td> -->
        <!-- <td>2</td> -->
        <!-- <td>3</td> -->
        <!-- <td>4</td> -->
      </tr>

      <tr>
        <td colspan="2" style="font-weight: bold;">GRAND TOTAL</td>
        <td style="font-weight: bold;"><?php $g_class = $total_g1 + $total_g2 + $total_g3 + $total_g4; echo number_format($g_class); ?></td>
        <td style="font-weight: bold;"><?php $g_cad1 = $cd1 + $cd2 + $cd3 + $cd4; echo number_format($g_cad1); ?></td>
        <td style="font-weight: bold;"><?php $g_rate = 0; if($g_cad1 != 0){ $g_rate = ($g_class * 1000)/$g_cad1; } echo number_format($g_rate, 1); ?></td>
        <td style="font-weight: bold;"><?php $g_cad = $cad1 + $cad2 + $cad3 + $cad4; $g_sir = 0; if($g_cad != 0){ $g_sir = $g_class / $g_cad; } echo number_format($g_sir, 1);?></td>
        <td style="display: none;" style="font-weight: bold;"></td>
        <td style="font-weight: bold;"></td>
        <td style="display: none;" style="font-weight: bold;"></td>
        <td style="font-weight: bold;"></td>
        <td style="display: none;" style="font-weight: bold;"></td>
        <td style="font-weight: bold;"></td>
        <td style="display: none;" style="font-weight: bold;"></td>
        <td style="font-weight: bold;"></td>
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
  // echo number_format($baseVal, 3)."<br>";
  return $baseVal;

  mysqli_close($conn);
  die();
}

function getnLCL($conn, $df, $prop) {
  $strSQL = "SELECT $prop FROM chistable WHERE df = '$df'";
  $result = mysqli_query($conn, $strSQL);
  if(($result) && (mysqli_num_rows($result) > 0)){
    $data = mysqli_fetch_assoc($result);
    return $data[$prop];
  }else{
    return 0;
  }

}
?>
