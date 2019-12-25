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
}else{
  header('Location: neonate?uid='.$uid.'&role='.$role);
  die();
}

$active_tab = 1;
if(isset($_GET['active_tab'])){
  $active_tab = $_GET['active_tab'];
}
$year = $sysdateyear;
if(isset($_GET['year'])){
  $year = mysqli_real_escape_string($conn, $_GET['year']);
}

$vrow = 100;
if(isset($_GET['vrow'])){
  $vrow = mysqli_real_escape_string($conn, $_GET['vrow']);
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
  <link rel="stylesheet" href="../../node_modules/bootstrap-daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../../node_modules/select2/dist/css/select2.min.css">
  <link rel="stylesheet" href="../../node_modules/selectric/public/selectric.css">
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
              <h1 class="text-white">Neonate :: Append data</h1>
            </div>
            <div class="row">
              <div class="col-12 mb-3">
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate?uid=<?php echo $uid;?>&role=<?php echo $role;?>')"><i class="fas fa-home text-white"></i>  Neo main menu</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate-append?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Patient's characteristic</button>
                <button type="button" class="btn btn-primary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate-device?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Device associate</button>
                <button type="button" class="btn btn-secondary btn-icon" name="button" onclick="fnc.gotoUrl('./neonate-other?uid=<?php echo $uid;?>&role=<?php echo $role;?>')">Other infection</button>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-12">
                <div class="card">
                  <div class="card-body">

                    <div class="row">
                      <div class="col-5">
                        <ul class="nav nav-pills mb-4" id="myTab3" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link <?php if($active_tab == 1){ echo "active"; } ?>" id="home-tab3" data-toggle="tab" href="#home3" role="tab" aria-controls="home" aria-selected="true" onclick="setActivetab(1)">Device indwelling</a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link <?php if($active_tab == 2){ echo "active"; } ?>" id="profile-tab3" data-toggle="tab" href="#profile3" role="tab" aria-controls="profile" aria-selected="false"  onclick="setActivetab(2)">Device associate infection</a>
                          </li>
                        </ul>
                      </div>
                      <div class="col-7">
                        <div class="form-group row">
                          <label for="" class="col-2 col-form-label text-left">Rows : </label>
                          <div class="col-4">
                            <select class="form-control c-input" id="txtRowFillter">
                              <option value="100" <?php if($vrow == '100'){echo "selected";} ?>>100</option>
                              <option value="1000" <?php if($vrow == '1000'){echo "selected";} ?>>1000</option>
                              <option value="10000" <?php if($vrow == '10000'){echo "selected";} ?>>10000</option>
                              <option value="all" <?php if($vrow == 'all'){echo "selected";} ?>>All</option>
                            </select>
                          </div>

                          <label for="" class="col-2 col-form-label text-right">Year : </label>
                          <div class="col-4">
                            <select class="form-control c-input" id="txtYearFillter">
                              <?php
                              for ($i=$sysdateyear; $i > ($sysdateyear - 10); $i--) {
                                ?>
                                <option value="<?php echo $i;?>" <?php if($year == $i){echo "selected";} ?>><?php echo $i;?></option>
                                <?php
                              }
                              ?>
                            </select>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div class="tab-content" id="myTabContent2">
                      <div class="tab-pane fade <?php if($active_tab == 1){ echo "show active"; } ?>" id="home3" role="tabpanel" aria-labelledby="home-tab3">
                        <div class="row">
                          <div class="col-12 col-sm-5">
                            <form class="deviceForm1" onsubmit="return false;">
                              <div class="form-group" style="display: none;">
                                <label for="">Record ID.: <span class="text-danger">**</span> </label>
                                <input type="text" class="form-control c-input" name="txtRecord1" id="txtRecord1" readonly>
                              </div>
                              <div class="form-group">
                                <label for="" class="col-form-label">Serial No.: <span class="text-danger">**</span> </label>
                                <input type="text" class="form-control c-input" name="txtSerial1" id="txtSerial1" placeholder="Enter serial no ..." autofocus>
                              </div>
                              <div class="form-group row mb-1">
                                <label for="" class="col-3  col-form-label">HN</label>
                                <div class="col-9">
                                  <!-- <input type="text" class="form-control c-input-2 txtHn" name="txtHn1" id="txtHn1" readonly> -->
                                  <input type="text" class="form-control c-input-2 txtHn"  readonly>
                                </div>
                              </div>

                              <div class="form-group row mb-1">
                                <label for="" class="col-3 pr-0 col-form-label">Gender</label>
                                <div class="col-9">
                                  <input type="text" class="form-control c-input-2 txtGender" name="" value="" placeholder="" readonly>
                                </div>
                              </div>

                              <div class="form-group row mb-1">
                                <label for="" class="col-2 col-form-label">GA</label>
                                <div class="col-4">
                                  <input type="text" class="form-control c-input-2 txtGa" name="" value="" placeholder="" readonly>
                                </div>

                                <label for="" class="col-2 col-form-label">BW</label>
                                <div class="col-4">
                                  <input type="text" class="form-control c-input-2 txtBw" name="" value="" placeholder="" readonly>
                                </div>
                              </div>

                              <div class="form-group row mb-1">
                                <label for="" class="col-4 pr-0 col-form-label">Admission date</label>
                                <div class="col-8">
                                  <input type="text" class="form-control c-input-2 txtAdm" name="" value="" placeholder="" readonly>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="" class="col-4 pr-0 col-form-label">Discharge date</label>
                                <div class="col-8">
                                  <input type="text" class="form-control c-input-2 txtDisc" name="" value="" placeholder="" readonly>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="" class="col-form-label">Date on device: <span class="text-danger">**</span> </label>
                                <input type="text" class="form-control c-input datepicker" name="txtDate1" id="txtDate1" placeholder="" >
                              </div>

                              <div class="form-group row mb-1">
                                <label for="" class="col-4 pr-0 col-form-label pt-0">Length of stay from admission</label>
                                <div class="col-6">
                                  <input type="number" min="0" max="30" class="form-control c-input-2" name="txtLos1" id="txtLos1" placeholder="" readonly>
                                </div>
                                <label for="" class="col-2 pr-0 col-form-label">days.</label>
                              </div>

                              <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Device: <span class="text-danger">**</span> </label>
                                <div class="col-4">
                                  <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" name="txtCath1" id="txtCath1" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description text-dark">Central line</span>
                                  </label>
                                </div>
                                <div class="col-4">
                                  <label class="custom-switch mt-2 pl-0">
                                    <input type="checkbox" name="txtVent1" id="txtVent1" class="custom-switch-input">
                                    <span class="custom-switch-indicator"></span>
                                    <span class="custom-switch-description text-dark">Ventilator</span>
                                  </label>
                                </div>
                              </div>


                              <div class="row">
                                <div class="col-12 text-right pt-3">
                                  <button type="submit" class="btn btn-primary float-left" name="button"><i class="fas fa-plus text-white"></i> Save as new record</button>
                                  <button type="button" class="btn btn-primary" name="button" onclick="neonate.updateDeviceIndwelling()">Update</button>
                                </div>
                              </div>

                            </form>
                          </div>

                          <div class="col-12 col-sm-7">
                            <div class="table-responsive" id="tableZone1">
                              <table class="table table-striped table-sm" id="table-1">
                                <thead>
                                  <tr>
                                    <th class="text-center"></th>
                                    <th>Serial</th>
                                    <th>dDate</th>
                                    <th>Cath</th>
                                    <th>Vent</th>
                                    <th>BW</th>
                                    <th>BW_cat</th>
                                  </tr>
                                </thead>
                                <tbody id="table-1-data">
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane fade <?php if($active_tab == 2){ echo "show active"; } ?>" id="profile3" role="tabpanel" aria-labelledby="profile-tab3">
                        <div class="row">
                          <div class="col-12 col-sm-5">
                            <form class="deviceForm2" onsubmit="return false;">
                              <div class="form-group" style="display: none;">
                                <label for="">Serial No.: <span class="text-danger">**</span> </label>
                                <input type="text" class="form-control c-input" name="txtRecord2" id="txtRecord2" placeholder="Enter serial no ...">
                              </div>
                              <div class="form-group">
                                <label for="">Serial No.: <span class="text-danger">**</span> </label>
                                <input type="text" class="form-control c-input" name="txtSerial2" id="txtSerial2" placeholder="Enter serial no ...">
                              </div>

                              <div class="form-group row mb-1">
                                <label for="" class="col-3  col-form-label">HN</label>
                                <div class="col-9">
                                  <!-- <input type="text" class="form-control c-input-2 txtHn" name="txtHn1" id="txtHn1" readonly> -->
                                  <input type="text" class="form-control c-input-2 txtHn"  readonly>
                                </div>
                              </div>

                              <div class="form-group row mb-1">
                                <label for="" class="col-3 pr-0 col-form-label">Gender</label>
                                <div class="col-9">
                                  <input type="text" class="form-control c-input-2 txtGender" name="" value="" placeholder="" readonly>
                                </div>
                              </div>

                              <div class="form-group row mb-1">
                                <label for="" class="col-2 col-form-label">GA</label>
                                <div class="col-4">
                                  <input type="text" class="form-control c-input-2 txtGa" name="" value="" placeholder="" readonly>
                                </div>

                                <label for="" class="col-2 col-form-label">BW</label>
                                <div class="col-4">
                                  <input type="text" class="form-control c-input-2 txtBw" name="" value="" placeholder="" readonly>
                                </div>
                              </div>

                              <div class="form-group row mb-1">
                                <label for="" class="col-4 pr-0 col-form-label">Admission date</label>
                                <div class="col-8">
                                  <input type="text" class="form-control c-input-2 txtAdm" name="" value="" placeholder="" readonly>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="" class="col-4 pr-0 col-form-label">Discharge date</label>
                                <div class="col-8">
                                  <input type="text" class="form-control c-input-2 txtDisc" name="" value="" placeholder="" readonly>
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="" class="col-form-label">Site of infection: <span class="text-danger">**</span> </label>
                                <select class="form-control c-input" name="txtInfection" id="txtInfection">
                                  <option value="">-- Choose site --</option>
                                  <?php
                                  $strSQL = "SELECT * FROM nis_code_site_dia WHERE 1 ORDER BY site";
                                  $result = mysqli_query($conn, $strSQL);
                                  if(($result) && (mysqli_num_rows($result))){
                                    while ($data = mysqli_fetch_array($result)) {
                                      ?>
                                      <option value="<?php echo $data['site'];?>"><?php echo $data['site'] . " - " .$data['description'];?></option>
                                      <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="" class="col-form-label">Date of event: <span class="text-danger">**</span> </label>
                                <input type="text" class="form-control c-input datepicker" name="txtDate2" id="txtDate2" placeholder="" >
                              </div>

                              <div class="form-group row mb-0">
                                <label for="" class="col-4 col-form-label pt-0">Length from admission to event</label>
                                <div class="col-6">
                                  <input type="number" min="0" max="30" class="form-control c-input-2" name="txtLoe" id="txtLoe" placeholder="" readonly>
                                  <small id="ht2" class="form-text text-danger dn">
                                    Invalid date range. Length from admission to event must be 0 - 30 days
                                  </small>
                                </div>
                                <label for="" class="col-2  col-form-label">Days</label>
                              </div>

                              <div class="form-group">
                                <label for="" class="col-form-label">Pathogen:</label>
                                <select class="form-control select2 c-input" multiple="" id="txtPathogen" style="width: 100%; background: #f0f0f1  !important;">
                                  <option value="">-- Choose pathogen --</option>
                                  <?php
                                  $strSQL = "SELECT * FROM nis_pathogen WHERE 1 ORDER BY pathogenName";
                                  $result = mysqli_query($conn, $strSQL);
                                  if(($result) && (mysqli_num_rows($result))){
                                    while ($data = mysqli_fetch_array($result)) {
                                      ?>
                                      <option value="<?php echo $data['pathogen'];?>"><?php echo $data['pathogenName'];?></option>
                                      <?php
                                    }
                                  }
                                  ?>
                                </select>
                              </div>




                              <div class="row">
                                <div class="col-12 text-right pt-3">
                                  <button type="submit" class="btn btn-primary float-left" name="button"><i class="fas fa-plus text-white"></i> Save as new record</button>
                                  <button type="button" class="btn btn-primary" name="button" onclick="neonate.updateDeviceInfection()">Update <i class="fas fa-chevron-right text-white"></i></button>
                                </div>
                              </div>

                            </form>
                          </div>

                          <div class="col-12 col-sm-7">

                            <div class="table-responsive" id="tableZone1">
                              <?php
                              $columData = array();
                              $strSQL = "SELECT * FROM nis_neo_dai WHERE nai_uid = '$uid' AND YEAR(nai_doe) = '$year' ORDER BY nai_doe, nai_neo_serial ASC";
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
                              <table class="table table-striped table-sm" id="table-2">
                                <thead>
                                  <tr>
                                    <th class="text-center"></th>
                                    <th>Serial</th>
                                    <th>DOE</th>
                                    <th>Site</th>
                                    <th>BW</th>
                                    <th>BW_Cat</th>
                                    <th>Pathogen</th>
                                  </tr>
                                </thead>
                                <tbody id="table-2-data">
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- ... -->
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
  <script src="../../node_modules/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script src="../../node_modules/select2/dist/js/select2.full.min.js"></script>
  <script src="../../node_modules/selectric/public/jquery.selectric.min.js"></script>
  <script src="../../assets/js/stisla.js"></script>

  <!-- Template JS File -->
  <script src="../../assets/js/scripts.js"></script>
  <script src="../../assets/js/custom.js"></script>

  <script src="../../assets/custom/js/config.js"></script>
  <script src="../../assets/custom/js/function.js"></script>
  <script src="../../assets/custom/js/authen.js"></script>
  <script src="../../assets/custom/js/authen-init.js"></script>
  <script src="../../assets/custom/js/neonate.js"></script>

  <script type="text/javascript">

    var active_tab = 1
    $(document).ready(function(){
      $('#tableZone1').niceScroll();

      neonate.loadData('deviceday')
      neonate.loadData('dai')

      // $("#table-1").dataTable({
      //   "columnDefs": [
      //     { "width": "100px", "targets": 0 },
      //     { "sortable": false, "targets": [2,3] }
      //   ]
      // });
      //
      // $("#table-2").dataTable({
      //   "columnDefs": [
      //     { "width": "100px", "targets": 0 },
      //     { "sortable": false, "targets": [2,3] }
      //   ]
      // });

      if(jQuery().daterangepicker){
        if($('.datepicker').length){
          $('.datepicker').daterangepicker({
            locale: {format: 'DD-MMM-YYYY'},
            singleDatePicker: true
          })
        }
      }
    })

    $(function(){

      $('.dataTables_filter input').keyup(function() {

      });

      $('#txtSerial1').keyup(function(){
        neonate.searchPatient($('#txtSerial1').val(), 1)
        var table = $('#table-1').DataTable();
        table.search( this.value ).draw();
        $('#txtRecord1').val('')
      })

      $('#txtSerial2').keyup(function(){
        neonate.searchPatient($('#txtSerial2').val(), 2)
        var table = $('#table-2').DataTable();
        table.search( this.value ).draw();
        $('#txtRecord2').val('')
      })

      $('.deviceForm1').submit(function(){
        neonate.saveDeviceIndwelling()
      })

      $('.deviceForm2').submit(function(){
        neonate.saveDeviceInfection()
      })

      $('#txtDate1').change(function(){
        calculateLoa1()
      })

      $('#txtDate2').change(function(){
        calculateLoa2()
      })

      $('#txtYearFillter').change(function(){
         window.location = 'neonate-device?uid=' + current_user + '&role=' + current_role + '&year=' + $('#txtYearFillter').val() + '&vrow=' + $('#txtRowFillter').val()
      })

      $('#txtRowFillter').change(function(){
         window.location = 'neonate-device?uid=' + current_user + '&role=' + current_role + '&year=' + $('#txtYearFillter').val() + '&vrow=' + $('#txtRowFillter').val()
      })


    })

    function calculateLoa1(){
      var start = serializeDate($('.txtAdm').val())
      var end = serializeDate($('#txtDate1').val())
      var _Diff = calDateDiff(start, end)
      $('#txtLos1').val(_Diff + 1)
    }

    function calculateLoa2(){
      var start = serializeDate($('.txtAdm').val())
      var end = serializeDate($('#txtDate2').val())
      var _Diff = calDateDiff(start, end)
      $('#txtLoe').val(_Diff + 1)
      if(_Diff > 30){
        $('#txtLoe').addClass('is-invalid')
        $('#ht2').removeClass('dn')
      }else{
        $('#txtLoe').removeClass('is-invalid')
        $('#ht2').addClass('dn')
      }
    }

    function setLocalData(id, serial){
      $('#txtSerial1').val(serial)
      $('#txtRecord1').val(id)
      neonate.searchPatient_byid($('#txtRecord1').val())
    }

    function setLocalData2(id, serial){
      $('#txtSerial2').val(serial)
      $('#txtRecord2').val(id)
      neonate.searchPatient_byid2($('#txtRecord2').val())
    }

    function setActivetab(id){
      active_tab = id
    }
  </script>
</body>
</html>
