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
$strSQL = "SELECT * FROM nis_hospchar WHERE hosp_uid = '$uid' AND hosp_deletestatus = '0' AND hosp_status = '1' ORDER BY hosp_udatetime LIMIT 1";
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
  <link rel="stylesheet" href="../../node_modules/sweetalert/dist/sweetalert.css">
  <link rel="stylesheet" href="../../node_modules/preload.js/dist/css/preload.css">
  <link rel="stylesheet" href="../../node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css">

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
        Hello, <span class="userFullname text-warning"><i class="fas fa-sync fa-spin text-primary"></i></span> <a href="Javascript:authen.logout()" class="text-white ml-3"><i class="fas fa-sign-out-alt text-white"></i> Log out</a>
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
              <h1 class="text-white">Hospital profile</h1>
            </div>
            <div class="row">
              <div class="col-12 mb-3">
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./index?uid=<?php echo $uid;?>&role=<?php echo $role;?>')"><i class="fas fa-home text-white"></i></button>
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./hospital?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Hospital profile</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./wardcode?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Ward codes</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./surgeoncode?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Surgeon codes</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./nicu?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">NICU Level</button>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-4">
                <h6 class="text-white">Hospital characteristic</h6>
                <div class="card">
                  <div class="card-body">
                    <form class="" onsubmit="return false;">
                      <div class="form-group">
                        <label for="">Hospital name: <span class="text-danger">**</span> </label>
                        <input type="text" class="form-control c-input" name="txtHname" id="txtHname" value="<?php if($hospitalChar){ echo $hospData['hosp_hospname'];} ?>" placeholder="Hospital name ...">
                      </div>
                      <div class="form-group">
                        <label for="">Address: </label>
                        <input type="text" class="form-control c-input" name="txtAddress" id="txtAddress" value="<?php if($hospitalChar){ echo $hospData['hosp_address'];} ?>" placeholder="Address ...">
                      </div>
                      <div class="row">
                        <div class="form-group col-12 col-sm-6">
                          <label for="">Country: <span class="text-danger">**</span> </label>
                          <select class="form-control c-input" name="txtCountry" id="txtCountry">
                            <option value="">-- Choose country --</option>
                            <?php
                            $strSQL = "SELECT * FROM nis_country WHERE 1 ORDER BY CountryName ASC";
                            $resultCountry = mysqli_query($conn, $strSQL);
                            if($resultCountry){
                              while($rowCountry = mysqli_fetch_array($resultCountry)){
                                ?>
                                <option value="<?php echo $rowCountry['CountryID']; ?>" <?php if($hospitalChar){ if($hospData['hosp_country'] == $rowCountry['CountryID']){ echo "selected";} } ?>><?php echo $rowCountry['CountryName'];?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-12 col-sm-6">
                          <label for="">Bed size: <span class="text-danger">**</span> </label>
                          <input type="number" min="1" max="99999" class="form-control c-input" name="txtBedsize" id="txtBedsize" value="<?php if($hospitalChar){ echo $hospData['hosp_bedsize'];} ?>" placeholder="Enter number of bed ...">
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-12 col-sm-6">
                          <label for="">Facility type: <span class="text-danger">**</span> </label>
                          <select class="form-control c-input" name="txtType" id="txtType">
                            <option value="">-- Choose facility type --</option>
                            <?php
                            $strSQL = "SELECT * FROM nis_code_hosptype WHERE 1 ORDER BY hosptype ASC";
                            $resultHtype = mysqli_query($conn, $strSQL);
                            if($resultHtype){
                              while($rowHtype = mysqli_fetch_array($resultHtype)){
                                ?>
                                <option value="<?php echo $rowHtype['ht_code']; ?>" <?php if($hospitalChar){ if($hospData['hosp_hosptype'] == $rowHtype['ht_code']){ echo "selected";} } ?>><?php echo $rowHtype['hosptype'];?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                        <div class="form-group col-12 col-sm-6">
                          <label for="">Medical school: <span class="text-danger">**</span> </label>
                          <select class="form-control c-input" name="txtSchool" id="txtSchool">
                            <option value="">-- Choose facility type --</option>
                            <?php
                            $strSQL = "SELECT * FROM nis_code_school WHERE 1 ORDER BY school ASC";
                            $resultHschool = mysqli_query($conn, $strSQL);
                            if($resultHschool){
                              while($rowSchool = mysqli_fetch_array($resultHschool)){
                                ?>
                                <option value="<?php echo $rowSchool['sc_code']; ?>" <?php if($hospitalChar){ if($hospData['hosp_school'] == $rowSchool['sc_code']){ echo "selected";} } ?>><?php echo $rowSchool['school'];?></option>
                                <?php
                              }
                            }
                            ?>
                          </select>
                        </div>
                      </div>

                      <div class="row">
                        <div class="form-group col-12 col-sm-6">
                          <label for="">Percentage of ventilator on admission: <span class="text-danger">**</span> </label>
                          <input type="number" min="0" max="100" class="form-control c-input" name="txtPvent" id="txtPvent" value="<?php if($hospitalChar){ echo $hospData['hosp_pvent'];} ?>" placeholder="Enter only number 0 - 100">
                          <small id="passwordHelpBlock" class="form-text text-muted">
                            Enter number 0 - 100
                          </small>
                        </div>
                        <div class="form-group col-12 col-sm-6">
                          <label for="">Percentage of dialysis on admission: <span class="text-danger">**</span> </label>
                          <input type="number" min="0" max="100"  class="form-control c-input" name="txtPdian" id="txtPdian" value="<?php if($hospitalChar){ echo $hospData['hosp_pdian'];} ?>" placeholder="Enter only number 0 - 100">
                          <small id="passwordHelpBlock" class="form-text text-muted">
                            Enter number 0 - 100
                          </small>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-12 text-right pt-3">
                          <button type="button" class="btn btn-primary" name="button" onclick="hosp_profile.saveHospchar()">Record <i class="fas fa-chevron-right text-white"></i></button>
                        </div>
                      </div>

                    </form>
                  </div>
                </div>
                <!-- .carc -->
              </div>
              <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-8">
                <h6 class="text-white">Update history</h6>
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive" id="tableZone1">
                      <?php
                      $columData = array();
                      $strSQL = "SELECT * FROM nis_hospchar a LEFT JOIN nis_code_hosptype b ON a.hosp_hosptype = b.ht_code
                                 LEFT JOIN nis_code_school c ON a.hosp_school = c.sc_code
                                 WHERE a.hosp_uid = '$uid' AND a.hosp_deletestatus = '0' ORDER BY a.hosp_udatetime DESC";
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
                            <th>HUDate</th>
                            <th>Hospital name</th>
                            <th>Bed size</th>
                            <th>HType</th>
                            <th>School</th>
                            <th>pVent</th>
                            <th>pDian</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          if(sizeof($columData) == 0){
                            ?>
                            <tr>
                              <td colspan="7" class="text-center">
                                No history found.
                              </td>
                            </tr>
                            <?php
                          }else{
                            foreach ($columData as $rowData) {
                              ?>
                              <tr>
                                <td>
                                  <?php
                                  if($rowData['hosp_status'] == 0){
                                    ?>
                                    <button type="button" class="btn btn-danger- btn-sm btn-icon" name="button" onclick="hosp_profile.delHospinfo('<?php echo $rowData['hosp_id'];?>')"><i class="fas fa-trash text-danger"></i></button>
                                    <?php
                                  }
                                  ?>
                                </td>
                                <td><?php echo DateEnglish($rowData['hosp_udatetime'], true); ?></td>
                                <td><?php echo $rowData['hosp_hospname']; ?></td>
                                <td><?php echo $rowData['hosp_bedsize']; ?></td>
                                <td><?php echo $rowData['hosptype']; ?></td>
                                <td><?php echo $rowData['school']; ?></td>
                                <td><?php echo $rowData['hosp_pvent']; ?></td>
                                <td><?php echo $rowData['hosp_pdian']; ?></td>
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
  <script src="../../node_modules/sweetalert/dist/sweetalert.min.js"></script>
  <script src="../../node_modules/preload.js/dist/js/preload.js"></script>
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
          { "width": "50px", "targets": 0 },
          { "sortable": false, "targets": [2,3] }
        ]
      });
    })
  </script>
</body>
</html>
