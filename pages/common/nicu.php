<?php
include "../../conf.inc.php";
include "../../connect.inc.php";
include "../../function.inc.php";

$return = array();

if(
    (!isset($_GET['uid'])) ||
    (!isset($_GET['role']))
){
    header('Location: ../../');
    mysqli_close($conn);
    die();
}

$uid = mysqli_real_escape_string($conn, $_GET['uid']);
$role = mysqli_real_escape_string($conn, $_GET['role']);


$hospitalChar = false;
$hospData = '';
$strSQL = "SELECT * FROM nis_hospital_profile WHERE hos_uid = '$uid' AND hos_use_status = 'Y'  ORDER BY hos_udatetime LIMIT 1";
$resultHospchar = mysqli_query($conn, $strSQL);
if(($resultHospchar) && (mysqli_num_rows($resultHospchar) > 0)){
  $hospitalChar = true;
  $hospData = mysqli_fetch_assoc($resultHospchar);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>NISA for Common user</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../../node_modules/@fortawesome/fontawesome-free/css/all.css">

  <link rel="stylesheet" href="../../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">

  <!-- Template CSS -->
  <!-- <link rel="stylesheet" href="../../assets/css/style.css"> -->
  <!-- <link rel="stylesheet" href="../../assets/css/components.css"> -->
  <link rel="stylesheet" href="../../assets/custom/css/style.css">

  <style media="screen">
    body{
      background: rgb(47, 47, 47) !important;
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
    }
  </style>
</head>

<body>

  <div class="tools-bar">
    <div class="row">
      <div class="col-12 col-sm-6 text-white">
        Hello, <span class="userFullname text-primary"><i class="fas fa-sync fa-spin text-primary"></i></span>
      </div>
      <div class="col-12 col-sm-6 text-right">
        <button type="button" class="btn btn-sm- btn-primary" name="button" style="font-size: 0.7em;" onclick="changeFontsize(1)"><i class="fas fa-plus text-white"  style="font-size: 0.7em;"></i> Font Size</button>
        <button type="button" class="btn btn-sm- btn-primary" name="button" style="font-size: 0.7em;" onclick="changeFontsize(2)"><i class="fas fa-minus text-white"  style="font-size: 0.7em;"></i> Font Size</button>
      </div>
    </div>
  </div>

  <div id="app">
    <section class="section">
      <div class="container-fluid mt-5 mb-5" style=" ">
        <div class="row">
          <div class="col-12">
            <div class="login-brand">
              <!-- <img src="../../assets/img/stisla-fill.svg" alt="logo" width="100" class="shadow-light rounded-circle"> -->
              <h1 class="text-white">NICU Level</h1>
            </div>
            <div class="row">
              <div class="col-12 mb-3">
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./index?uid=<?php echo $uid;?>&role=<?php echo $role;?>')"><i class="fas fa-home text-white"></i></button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./hospital?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Hospital profile</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./wardcode?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Ward codes</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./surgeoncode?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Surgeon codes</button>
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./nicu?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">NICU Level</button>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <h6 class="text-white">Update NICU Level</h6>
                <div class="card">
                  <div class="card-body">
                    <form class="" onsubmit="return false;">

                      <div class="form-group">
                        <label for="">Choose NICU level: <span class="text-danger">**</span> </label>
                        <select class="form-control c-input" name="txtLevel" id="txtLevel">
                          <option value="">-- Choose level --</option>
                          <option value="1" <?php if($hospitalChar){ if($hospData['hos_nicu_level'] == 1){ echo "selected";} } ?>>Level I</option>
                          <option value="2" <?php if($hospitalChar){ if($hospData['hos_nicu_level'] == 2){ echo "selected";} } ?>>Level II</option>
                          <option value="3" <?php if($hospitalChar){ if($hospData['hos_nicu_level'] == 3){ echo "selected";} } ?>>Level III</option>
                        </select>
                      </div>

                      <div class="row">
                        <div class="col-12 text-center pt-3">
                          <button type="button" class="btn btn-primary" name="button" onclick="hosp_profile.nicu('update')">Update</button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
                <!-- .carc -->
              </div>
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                <h6 class="text-white">Update history</h6>
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive" id="tableZone1">
                      <?php
                      $columData = array();
                      $strSQL = "SELECT * FROM nis_hospital_profile WHERE hos_uid = '$uid' ORDER BY hos_udatetime DESC";
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
                      }
                      ?>
                      <table class="table table-striped table-sm" id="table-1">
                        <thead>
                          <tr>
                            <th class="text-center">

                            </th>
                            <th>Update date - time</th>
                            <th>Level</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if(sizeof($columData) == 0){
                            ?>
                            <tr>
                              <td colspan="4" class="text-center">
                                No history found.
                              </td>
                            </tr>
                            <?php
                          }else{
                            foreach ($columData as $rowData) {
                              ?>
                              <tr>
                                <td>
                                  <button type="button" class="btn btn-danger btn-sm btn-icon" name="button"><i class="fas fa-trash text-white"></i></button>
                                </td>
                                <td><?php echo $rowData['hos_udatetime']; ?></td>
                                <td><?php echo $rowData['hos_nicu_level']; ?></td>
                                <td>
                                  <?php
                                  if($rowData['hos_use_status'] == 'Y'){
                                    echo "Lasted update";
                                  }else{
                                    echo "-";
                                  }
                                  ?>
                                </td>
                              </tr>
                              <?php
                            }
                          }
                          ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <!-- .card -->
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="../../node_modules/jquery/dist/jquery.min.js" ></script>
  <script src="../../node_modules/popper.js/dist/umd/popper.min.js"></script>
  <script src="../../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js" ></script>
  <script src="../../node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js"></script>
  <script src="../../node_modules/moment/min/moment.min.js"></script>
  <script src="../../node_modules/datatables/media/js/jquery.dataTables.min.js"></script>
  <script src="../../node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
  <script src="../../assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="../../assets/js/scripts.js"></script>
  <script src="../../assets/js/custom.js"></script>

  <script src="../../assets/custom/js/config.js"></script>
  <script src="../../assets/custom/js/function.js"></script>
  <script src="../../assets/custom/js/authen.js"></script>
  <script src="../../assets/custom/js/authen-init.js"></script>
  <script src="../../assets/custom/js/hospital-profile.js"></script>

  <script type="text/javascript">
    $(document).ready(function(){
      $('#tableZone1').niceScroll();

      $("#table-1").dataTable({
        "columnDefs": [
          { "sortable": false, "targets": [2,3] }
        ]
      });
    })
  </script>
</body>
</html>
