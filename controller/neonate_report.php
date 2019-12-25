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

  if($period == 'Quarter'){

    for ($i=0; $i < $round ; $i++) {
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
            <tr>
              <td rowspan="25" style="vertical-align: top;">2012</td>
              <td rowspan="6" style="vertical-align: top;">1st</td>
              <td> < 751 gms. </td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>751-1000 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>1001-1500 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>1501-2500 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td> >2500 gms </td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>Total</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td rowspan="6" style="vertical-align: top;">2nd</td>
              <td> < 751 gms. </td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>

            <tr>
              <td>751-1000 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>a</td>
            </tr>
            <tr>
              <td>1001-1500 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>a</td>
            </tr>
            <tr>
              <td>1501-2500 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>a</td>
            </tr>
            <tr>
              <td> >2500 gms </td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>a</td>
            </tr>
            <tr>
              <td>Total</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
              <td>a</td>
            </tr>

            <tr>
              <td rowspan="6" style="vertical-align: top;">3rd</td>
              <td> < 751 gms. </td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>751-1000 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>1001-1500 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>1501-2500 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td> >2500 gms </td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>Total</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>

            <tr>
              <td rowspan="6" style="vertical-align: top;">4th</td>
              <td> < 751 gms. </td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>751-1000 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>1001-1500 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>1501-2500 gms</td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td> >2500 gms </td>
              <td>v</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>
            <tr>
              <td>Total</td>
              <td>d</td>
              <td>f</td>
              <td>h</td>
              <td>j</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
              <td>k</td>
            </tr>

            <tr>
              <td colspan="2" style="font-weight: bold;">GRAND TOTAL</td>
              <td style="font-weight: bold;">d</td>
              <td style="font-weight: bold;">f</td>
              <td style="font-weight: bold;">h</td>
              <td style="font-weight: bold;">j</td>
              <td style="font-weight: bold;">k</td>
              <td style="font-weight: bold;">k</td>
              <td style="font-weight: bold;">k</td>
              <td style="font-weight: bold;">k</td>
            </tr>

          </tbody>
        </table>
      <?php
    }

  }
  ?>

  <?php
  mysqli_close($conn);
  die();
}

?>
