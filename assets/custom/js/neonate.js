var neonate = {
  loadData(datagroup){
    if(datagroup == 'deviceday'){
      var param = {
        uid: current_user,
        year: $('#txtYearFillter').val(),
        vrow: $('#txtRowFillter').val(),
        table: datagroup
      }

      var jxr = $.post(conf.api + 'neonate_data?stage=gettable', param, function(){})
                 .always(function(resp){
                   preload.hide()
                   if(resp != 'No data'){
                     $('#table-1-data').html(resp)

                     $("#table-1")
                      .dataTable({
                       "columnDefs": [
                         { "width": "100px", "targets": 0 },
                         { "sortable": false, "targets": [0, 3, 4, 5, 6] },
                       ],
                       "order": [[ 2, "desc" ]],
                       "pageLength": 25
                     });
                     setFontsize()

                     var table = $('#table-1').DataTable();

                     $("#table-1").on( 'page.dt', function () {
                       setFontsize()
                     });

                     $("#table-1").on( 'order.dt', function () {
                       setFontsize()
                     });

                     $("#table-1").on( 'search.dt', function () {
                         setFontsize()
                     });
                   }
                 })
    }else{
      var param = {
        uid: current_user,
        year: $('#txtYearFillter').val(),
        vrow: $('#txtRowFillter').val(),
        table: datagroup
      }

      var jxr = $.post(conf.api + 'neonate_data?stage=gettable', param, function(){})
                 .always(function(resp){
                   preload.hide()
                   if(resp != 'No data'){
                     $('#table-2-data').html(resp)

                     $("#table-2")
                      .dataTable({
                       "columnDefs": [
                         { "width": "100px", "targets": 0 },
                         { "sortable": false, "targets": [0, 3, 4, 5, 6] },
                       ],
                       "order": [[ 2, "desc" ]],
                       "pageLength": 25
                     });
                     setFontsize()

                     var table = $('#table-2').DataTable();

                     $("#table-2").on( 'page.dt', function () {
                       setFontsize()
                     });

                     $("#table-2").on( 'order.dt', function () {
                       setFontsize()
                     });
                   }
                 })
    }
  },
  generateReport(){
    $check = 0
    $('.form-control').removeClass('is-invalid')
    if($('#txtStartmonth').val() == ''){
      $check++; $('#txtStartmonth').addClass('is-invalid')
    }
    if($('#txtStartyear').val() == ''){
      $check++; $('#txtStartyear').addClass('is-invalid')
    }
    if($('#txtEndmonth').val() == ''){
      $check++; $('#txtEndmonth').addClass('is-invalid')
    }
    if($('#txtEndyear').val() == ''){
      $check++; $('#txtEndyear').addClass('is-invalid')
    }
    if($('#txtPeriod').val() == ''){
      $check++; $('#txtPeriod').addClass('is-invalid')
    }
    if($check != 0){
      swal("Warning!", "Please select date interval", "error")
      return ;
    }

    $clabsi = 0
    $pedvae = 0

    if($('#txtSite1').is(":checked")){
      $clabsi = 1;
    }

    if($('#txtSite2').is(":checked")){
      $pedvae = 1;
    }

    if(($clabsi == 0) && ($pedvae == 0)){
      swal("Warning!", "Please select site of infection", "error")
      return ;
    }

    var param = {
      startMonth: $('#txtStartyear').val() + '-' + $('#txtStartmonth').val(),
      endMonth: $('#txtEndyear').val() + '-' + $('#txtEndmonth').val(),
      period: $('#txtPeriod').val(),
      uid: current_user
    }

    preload.show()

    if($clabsi == 1){
      var jxr = $.post(conf.api + 'neonate_report_sir?stage=reportCLASBI', param, function(){})
                 .always(function(resp){
                   preload.hide()
                   if(resp != 'No data'){
                     $('#table-zone').removeClass('dn')
                     $('#tablereportCLASBI').removeClass('dn')
                     $('#tmpDivCLASBI').html(resp)
                     setFontsize()
                   }
                 })
    }

    if($pedvae == 1){

    }


  },
  delDeviceOtherinfection(id){
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      closeOnConfirm: true
    },
    function(){
      preload.show()
      var jxr = $.post(conf.api + 'neonate?stage=deleteDeviceOtherinfection', {uid: current_user, rid: id}, function(){})
                 .always(function(resp){
                   if(resp == 'Y'){
                     setTimeout(()=>{
                       window.location = 'neonate-device?uid=' + current_user + '&role=' + current_role
                     }, 500)
                   }else{
                     preload.hide()
                     swal("Error", "Can not delete record", "error")
                   }
                 })
    });
  },
  delDeviceinfection(id){
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      closeOnConfirm: true
    },
    function(){
      preload.show()
      var jxr = $.post(conf.api + 'neonate?stage=deleteDeviceinfection', {uid: current_user, rid: id}, function(){})
                 .always(function(resp){
                   if(resp == 'Y'){
                     setTimeout(()=>{
                       window.location = 'neonate-device?uid=' + current_user + '&role=' + current_role + '&active_tab=2'
                     }, 500)
                   }else{
                     preload.hide()
                     swal("Error", "Can not delete record", "error")
                   }
                 })
    });
  },
  delDevicewelling(id){
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      closeOnConfirm: true
    },
    function(){
      preload.show()
      var jxr = $.post(conf.api + 'neonate?stage=deleteDevicewelling', {uid: current_user, rid: id}, function(){})
                 .always(function(resp){
                   console.log(resp);
                   if(resp == 'Y'){
                     setTimeout(()=>{
                       window.location = 'neonate-device?uid=' + current_user + '&role=' + current_role + '&active_tab=1'
                     }, 500)
                   }else{
                     preload.hide()
                     swal("Error", "Can not delete record", "error")
                   }
                 })
    });
  },
  updateDeviceOtherInfection(){
    $check = 0
    $('.form-control').removeClass('is-invalid')
    if($('#txtSerial2').val() == ''){
      $check++
      $('#txtSerial2').addClass('is-invalid')
    }

    if($('#txtDate2').val() == ''){
      $check++
      $('#txtDate2').addClass('is-invalid')
    }

    if($('#txtLoe').val() == ''){
      $check++
      $('#txtLoe').addClass('is-invalid')
    }

    if($('#txtRecord2').val() == ''){
      $check++
      $('#txtRecord2').addClass('is-invalid')
      swal("Error", "Please select target record.", "error")
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      rid: $('#txtRecord2').val(),
      serial: $('#txtSerial2').val(),
      ddate: serializeDate($('#txtDate2').val()),
      los: $('#txtLoe').val(),
      site: $('#txtInfection').val(),
      pathogen: $('#txtPathogen').select2("val").join(",")
    }

    preload.show()

    var jxr = $.post(conf.api + 'neonate?stage=updateDeviceOtherInfection', param, function(){})
               .always(function(resp){

                 if(resp == 'Y'){
                   preload.hide()
                   swal({
                     title: "Success",
                     text: "Click OK to reload data.",
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "OK",
                     closeOnConfirm: false },
                   function(){
                     window.location = 'neonate-other?uid=' + current_user + '&role=' + current_role
                   });
                 }else if(resp == 'No data'){
                   preload.hide()
                   swal("Error", "Serial number not found in patient list", "error")
                 }else{
                   preload.hide()
                   swal("Error", "Can not record", "error")
                 }
               })
  },
  updateDeviceInfection(){
    $check = 0
    $('.form-control').removeClass('is-invalid')
    if($('#txtSerial2').val() == ''){
      $check++
      $('#txtSerial2').addClass('is-invalid')
    }

    if($('#txtDate2').val() == ''){
      $check++
      $('#txtDate2').addClass('is-invalid')
    }

    if($('#txtLoe').val() == ''){
      $check++
      $('#txtLoe').addClass('is-invalid')
    }

    if($('#txtRecord2').val() == ''){
      $check++
      $('#txtRecord2').addClass('is-invalid')
      swal("Error", "Please select target record.", "error")
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      rid: $('#txtRecord2').val(),
      serial: $('#txtSerial2').val(),
      ddate: serializeDate($('#txtDate2').val()),
      los: $('#txtLoe').val(),
      site: $('#txtInfection').val(),
      pathogen: $('#txtPathogen').select2("val").join(",")
    }

    preload.show()

    var jxr = $.post(conf.api + 'neonate?stage=updateDeviceInfection', param, function(){})
               .always(function(resp){
                 if(resp == 'Y'){
                   preload.hide()
                   swal({
                     title: "Success",
                     text: "Click OK to reload data.",
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "OK",
                     closeOnConfirm: false },
                   function(){
                     window.location = 'neonate-device?uid=' + current_user + '&role=' + current_role + '&active_tab=2'
                   });
                 }else if(resp == 'No data'){
                   preload.hide()
                   swal("Error", "Serial number not found in patient list", "error")
                 }else{
                   preload.hide()
                   swal("Error", "Can not record", "error")
                 }
               })
  },
  updateDeviceIndwelling(){
    $check = 0
    $('.form-control').removeClass('is-invalid')
    if($('#txtSerial1').val() == ''){
      $check++
      $('#txtSerial1').addClass('is-invalid')
    }

    if($('#txtDate1').val() == ''){
      $check++
      $('#txtDate1').addClass('is-invalid')
    }

    if($('#txtLos1').val() == ''){
      $check++
      $('#txtLos1').addClass('is-invalid')
    }

    if($('#txtRecord1').val() == ''){
      $check++
      $('#txtRecord1').addClass('is-invalid')
      swal("Error", "Please select target record.", "error")
    }

    $cath = 0
    $vent = 0

    if($('#txtCath1').is(":checked")){
      $cath = 1;
    }

    if($('#txtVent1').is(":checked")){
      $vent = 1;
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      rid: $('#txtRecord1').val(),
      serial: $('#txtSerial1').val(),
      ddate: serializeDate($('#txtDate1').val()),
      los: $('#txtLos1').val(),
      cath: $cath,
      vent: $vent
    }

    preload.show()

    var jxr = $.post(conf.api + 'neonate?stage=updateDeviceIndwelling', param, function(){})
               .always(function(resp){
                 console.log(resp);
                 if(resp == 'Y'){
                   preload.hide()
                   swal({
                     title: "Success",
                     text: "Click OK to reload data.",
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "OK",
                     closeOnConfirm: false },
                   function(){
                     window.location = 'neonate-device?uid=' + current_user + '&role=' + current_role + '&active_tab=1'
                   });
                 }else if(resp == 'No data'){
                   preload.hide()
                   swal("Error", "Serial number not found in patient list", "error")
                 }else{
                   preload.hide()
                   swal("Error", "Can not record", "error")
                 }
               })
  },
  saveDeviceOtherInfection(){
    $check = 0
    $('.form-control').removeClass('is-invalid')
    if($('#txtSerial2').val() == ''){
      $check++
      $('#txtSerial2').addClass('is-invalid')
    }

    if($('#txtInfection').val() == ''){
      $check++
      $('#txtInfection').addClass('is-invalid')
    }

    if($('#txtDate2').val() == ''){
      $check++
      $('#txtDate2').addClass('is-invalid')
    }

    if($('#txtLoe').val() == ''){
      $check++
      $('#txtLoe').addClass('is-invalid')
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      rid: $('#txtRecord2').val(),
      serial: $('#txtSerial2').val(),
      ddate: serializeDate($('#txtDate2').val()),
      los: $('#txtLoe').val(),
      site: $('#txtInfection').val(),
      pathogen: $('#txtPathogen').select2("val").join(",")
    }

    preload.show()

    var jxr = $.post(conf.api + 'neonate?stage=saveDeviceOtherInfection', param, function(){})
               .always(function(resp){
                 if(resp == 'Y'){
                   preload.hide()
                   swal({
                     title: "Success",
                     text: "Click OK to reload data.",
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "OK",
                     closeOnConfirm: false },
                   function(){
                     window.location = 'neonate-other?uid=' + current_user + '&role=' + current_role
                   });
                 }else if(resp == 'No data'){
                   preload.hide()
                   swal("Error", "Serial number not found in patient list", "error")
                 }else{
                   preload.hide()
                   swal("Error", "Can not record", "error")
                 }
               })
  },
  saveDeviceInfection(){
    $check = 0
    $('.form-control').removeClass('is-invalid')
    if($('#txtSerial2').val() == ''){
      $check++
      $('#txtSerial2').addClass('is-invalid')
    }

    if($('#txtInfection').val() == ''){
      $check++
      $('#txtInfection').addClass('is-invalid')
    }

    if($('#txtDate2').val() == ''){
      $check++
      $('#txtDate2').addClass('is-invalid')
    }

    if($('#txtLoe').val() == ''){
      $check++
      $('#txtLoe').addClass('is-invalid')
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      rid: $('#txtRecord2').val(),
      serial: $('#txtSerial2').val(),
      ddate: serializeDate($('#txtDate2').val()),
      los: $('#txtLoe').val(),
      site: $('#txtInfection').val(),
      pathogen: $('#txtPathogen').select2("val").join(",")
    }

    preload.show()

    var jxr = $.post(conf.api + 'neonate?stage=saveDeviceInfection', param, function(){})
               .always(function(resp){
                 if(resp == 'Y'){
                   preload.hide()
                   swal({
                     title: "Success",
                     text: "Click OK to reload data.",
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "OK",
                     closeOnConfirm: false },
                   function(){
                     window.location = 'neonate-device?uid=' + current_user + '&role=' + current_role + '&active_tab=2'
                   });
                 }else if(resp == 'No data'){
                   preload.hide()
                   swal("Error", "Serial number not found in patient list", "error")
                 }else{
                   preload.hide()
                   swal("Error", "Can not record", "error")
                 }
               })
  },
  saveDeviceIndwelling(){
    $check = 0
    $('.form-control').removeClass('is-invalid')
    if($('#txtSerial1').val() == ''){
      $check++
      $('#txtSerial1').addClass('is-invalid')
    }

    if($('#txtDate1').val() == ''){
      $check++
      $('#txtDate1').addClass('is-invalid')
    }

    if($('#txtLos1').val() == ''){
      $check++
      $('#txtLos1').addClass('is-invalid')
    }

    $cath = 0
    $vent = 0

    if($('#txtCath1').is(":checked")){
      $cath = 1;
    }

    if($('#txtVent1').is(":checked")){
      $vent = 1;
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      rid: $('#txtRecord1').val(),
      serial: $('#txtSerial1').val(),
      ddate: serializeDate($('#txtDate1').val()),
      los: $('#txtLos1').val(),
      cath: $cath,
      vent: $vent
    }

    preload.show()

    var jxr = $.post(conf.api + 'neonate?stage=saveDeviceIndwelling', param, function(){})
               .always(function(resp){
                 console.log(resp);
                 if(resp == 'Y'){
                   preload.hide()
                   swal({
                     title: "Success",
                     text: "Click OK to reload data.",
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "OK",
                     closeOnConfirm: false },
                   function(){
                     window.location = 'neonate-device?uid=' + current_user + '&role=' + current_role + '&active_tab=1'
                   });
                 }else if(resp == 'No data'){
                   preload.hide()
                   swal("Error", "Serial number not found in patient list", "error")
                 }else{
                   preload.hide()
                   swal("Error", "Can not record", "error")
                 }
               })
  },
  delPatient(id){
    var param = {
      uid: current_user,
      neo_id: id
    }
    swal({
      title: "Are you sure?",
      text: "You will not be able to recover this record!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes, delete it!",
      cancelButtonText: "Cancel",
      closeOnConfirm: true
    },
    function(){
      preload.show()
      var jxr = $.post(conf.api + 'neonate?stage=delete_patient', param, function(){})
                 .always(function(resp){
                   if(resp == 'Y'){
                     setTimeout(()=>{
                       window.location.reload()
                     }, 500)
                   }else{
                     preload.hide()
                     swal("Error", "Can not delete record", "error")
                   }
                 })
    });
  },
  searchPatient_byid2(key){
    var param = {
      uid: current_user,
      rid: key
    }

    var jxr = $.post(conf.api + 'neonate?stage=info2_byid', param , function(){}, 'json')
               .always(function(snap){
                 console.log(snap);
                 if(fnc.snap(snap)){
                   snap.forEach(i=>{
                     $('#txtBw').val(i.neo_bw)
                     $('#txtGender').val(i.neo_sex)
                     $('#txtGa').val(i.neo_ga)
                     $('#txtDie').val(i.neo_die)
                     $('#txtHn').val(i.neo_hn)
                     $('#txtLos').val(i.neo_los)
                     if($('#txtAdm').length){
                         $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(i.neo_admission));
                     }

                     if($('#txtDisc').length){
                         $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(i.neo_discharge));
                     }

                     if($('#txtDate2').length){
                       $('#txtDate2').data('daterangepicker').setStartDate(dateFormat(i.nai_doe));
                     }

                     // $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(i.));
                     $('.txtHn').val(i.neo_hn)
                     $('.txtGender').val(i.neo_sex)
                     $('.txtGa').val(i.neo_ga)
                     $('.txtBw').val(i.neo_bw)
                     $('.txtAdm').val(dateFormat(i.neo_admission))
                     $('.txtDisc').val(dateFormat(i.neo_discharge))
                     $('#txtInfection').val(i.nai_site)

                     if(i.nai_pathogen != ''){
                       $b = i.nai_pathogen.split(",")
                       console.log($b);
                       $('#txtPathogen').val($b)
                       $('#txtPathogen').trigger('change');
                     }


                     if($('#txtLoe').length){
                       calculateLoa2()
                     }
                   })
                 }else{
                   $('#txtBw').val('')
                   $('#txtGender').val('')
                   $('#txtGa').val('')
                   $('#txtDie').val('N')
                   $('#txtHn').val('')
                   $('#txtLos').val('1')
                   if($('#txtDisc').length){
                       $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   if($('#txtDisc').length){
                       $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }

                   if($('#txtDate2').length){
                     $('#txtDate2').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   $('.txtHn').val('')
                   $('.txtGender').val('')
                   $('.txtGa').val('')
                   $('.txtBw').val('')
                   $('.txtAdm').val('')
                   $('.txtDisc').val('')
                   $('#txtLoe').val('')
                   $('#txtInfection').val('')
                   $('#txtPathogen').val(null).trigger('change');
                 }
               })
  },
  searchPatient_byid3(key){
    var param = {
      uid: current_user,
      rid: key
    }

    var jxr = $.post(conf.api + 'neonate?stage=info3_byid', param , function(){}, 'json')
               .always(function(snap){
                 console.log(snap);
                 if(fnc.snap(snap)){
                   snap.forEach(i=>{
                     $('#txtBw').val(i.neo_bw)
                     $('#txtGender').val(i.neo_sex)
                     $('#txtGa').val(i.neo_ga)
                     $('#txtDie').val(i.neo_die)
                     $('#txtHn').val(i.neo_hn)
                     $('#txtLos').val(i.neo_los)
                     if($('#txtAdm').length){
                         $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(i.neo_admission));
                     }

                     if($('#txtDisc').length){
                         $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(i.neo_discharge));
                     }

                     if($('#txtDate2').length){
                       $('#txtDate2').data('daterangepicker').setStartDate(dateFormat(i.doe));
                     }

                     $('.txtHn').val(i.neo_hn)
                     $('.txtGender').val(i.neo_sex)
                     $('.txtGa').val(i.neo_ga)
                     $('.txtBw').val(i.neo_bw)
                     $('.txtAdm').val(dateFormat(i.neo_admission))
                     $('.txtDisc').val(dateFormat(i.neo_discharge))
                     $('#txtInfection').val(i.site)

                     if(i.pathogen != ''){
                       $b = i.pathogen.split(",")
                       $('#txtPathogen').val($b)
                       $('#txtPathogen').trigger('change');
                     }


                     if($('#txtLoe').length){
                       calculateLoa2()
                     }
                   })
                 }else{
                   $('#txtBw').val('')
                   $('#txtGender').val('')
                   $('#txtGa').val('')
                   $('#txtDie').val('N')
                   $('#txtHn').val('')
                   $('#txtLos').val('1')
                   if($('#txtDisc').length){
                       $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   if($('#txtDisc').length){
                       $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }

                   if($('#txtDate2').length){
                     $('#txtDate2').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   $('.txtHn').val('')
                   $('.txtGender').val('')
                   $('.txtGa').val('')
                   $('.txtBw').val('')
                   $('.txtAdm').val('')
                   $('.txtDisc').val('')
                   $('#txtLoe').val('')
                   $('#txtInfection').val('')
                   $('#txtPathogen').val(null).trigger('change');
                 }
               })
  },
  searchPatient_byid(key){
    var param = {
      uid: current_user,
      rid: key
    }

    var jxr = $.post(conf.api + 'neonate?stage=info_byid', param , function(){}, 'json')
               .always(function(snap){
                 if(fnc.snap(snap)){
                   snap.forEach(i=>{
                     $('#txtBw').val(i.neo_bw)
                     $('#txtGender').val(i.neo_sex)
                     $('#txtGa').val(i.neo_ga)
                     $('#txtDie').val(i.neo_die)
                     $('#txtHn').val(i.neo_hn)
                     $('#txtLos').val(i.neo_los)
                     if($('#txtAdm').length){
                         $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(i.neo_admission));
                     }

                     if($('#txtDisc').length){
                         $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(i.neo_discharge));
                     }

                     if($('#txtDate1').length){
                       $('#txtDate1').data('daterangepicker').setStartDate(dateFormat(i.ndw_ddate));
                     }

                     // $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(i.));
                     $('.txtHn').val(i.neo_hn)
                     $('.txtGender').val(i.neo_sex)
                     $('.txtGa').val(i.neo_ga)
                     $('.txtBw').val(i.neo_bw)
                     $('.txtAdm').val(dateFormat(i.neo_admission))
                     $('.txtDisc').val(dateFormat(i.neo_discharge))

                     if(i.ndw_cath == 1){
                       $('#txtCath1').attr('checked', 'checked');
                     }else{
                       $('#txtCath1').attr('checked', false);
                     }

                     if(i.ndw_vent == 1){
                       $('#txtVent1').attr('checked', 'checked');
                     }else{
                       $('#txtVent1').attr('checked', false);
                     }

                     if($('#txtLos1').length){
                       calculateLoa1()
                     }
                   })
                 }else{
                   $('#txtBw').val('')
                   $('#txtGender').val('')
                   $('#txtGa').val('')
                   $('#txtDie').val('N')
                   $('#txtHn').val('')
                   $('#txtLos').val('1')
                   if($('#txtDisc').length){
                       $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   if($('#txtDisc').length){
                       $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }

                   if($('#txtDate1').length){
                     $('#txtDate1').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   $('.txtHn').val('')
                   $('.txtGender').val('')
                   $('.txtGa').val('')
                   $('.txtBw').val('')
                   $('.txtAdm').val('')
                   $('.txtDisc').val('')
                   $('#txtLos1').val('')

                   $('#txtVent1').attr('checked', false);
                   $('#txtCath1').attr('checked', false);
                 }
               })
  },
  searchPatient(key, path){
    var param = {
      uid: current_user,
      serial: key
    }

    var jxr = $.post(conf.api + 'neonate?stage=info', param , function(){}, 'json')
               .always(function(snap){
                 if(fnc.snap(snap)){
                   if(snap.length == 1){
                     snap.forEach(i=>{
                       $('#txtBw').val(i.neo_bw)
                       $('#txtGender').val(i.neo_sex)
                       $('#txtGa').val(i.neo_ga)
                       $('#txtDie').val(i.neo_die)
                       $('#txtHn').val(i.neo_hn)
                       $('#txtLos').val(i.neo_los)
                       if($('#txtAdm').length){
                           $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(i.neo_admission));
                       }

                       if($('#txtDisc').length){
                           $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(i.neo_discharge));
                       }

                       $('.txtHn').val(i.neo_hn)
                       $('.txtGender').val(i.neo_sex)
                       $('.txtGa').val(i.neo_ga)
                       $('.txtBw').val(i.neo_bw)
                       $('.txtAdm').val(dateFormat(i.neo_admission))
                       $('.txtDisc').val(dateFormat(i.neo_discharge))

                       if(path == 1){
                         if($('#txtLos1').length){
                           calculateLoa1()
                         }
                       }else if(path == 2){
                         if($('#txtLoe').length){
                           calculateLoa2()
                         }
                       }else{
                         if($('#txtLoe').length){
                           calculateLoa2()
                         }
                       }
                     })
                   }else{
                     $('#txtBw').val('')
                     $('#txtGender').val('')
                     $('#txtGa').val('')
                     $('#txtDie').val('N')
                     $('#txtHn').val('')
                     $('#txtLos').val('1')
                     if($('#txtDisc').length){
                         $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(getToday()));
                     }
                     if($('#txtDisc').length){
                         $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(getToday()));
                     }
                     if($('#txtDate1').length){
                       $('#txtDate1').data('daterangepicker').setStartDate(dateFormat(getToday()));
                     }
                     if($('#txtDate2').length){
                       $('#txtDate2').data('daterangepicker').setStartDate(dateFormat(getToday()));
                     }

                     $('.txtHn').val('')
                     $('.txtGender').val('')
                     $('.txtGa').val('')
                     $('.txtBw').val('')
                     $('.txtAdm').val('')
                     $('.txtDisc').val('')
                     $('#txtLos1').val('')

                     $('#txtVent1').attr('checked', false);
                     $('#txtCath1').attr('checked', false);

                     $('#txtLoe').val('')
                     $('#txtInfection').val('')
                     $('#txtPathogen').val(null).trigger('change');
                     $('#ht2').addClass('dn')
                   }
                 }else{
                   $('#txtBw').val('')
                   $('#txtGender').val('')
                   $('#txtGa').val('')
                   $('#txtDie').val('N')
                   $('#txtHn').val('')
                   $('#txtLos').val('1')
                   if($('#txtDisc').length){
                       $('#txtAdm').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   if($('#txtDisc').length){
                       $('#txtDisc').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   if($('#txtDate1').length){
                     $('#txtDate1').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }
                   if($('#txtDate2').length){
                     $('#txtDate2').data('daterangepicker').setStartDate(dateFormat(getToday()));
                   }

                   $('.txtHn').val('')
                   $('.txtGender').val('')
                   $('.txtGa').val('')
                   $('.txtBw').val('')
                   $('.txtAdm').val('')
                   $('.txtDisc').val('')
                   $('#txtLos1').val('')

                   $('#txtVent1').attr('checked', false);
                   $('#txtCath1').attr('checked', false);

                   $('#txtLoe').val('')
                   $('#txtInfection').val('')
                   $('#txtPathogen').val(null).trigger('change');
                   $('#ht2').addClass('dn')
                 }
               })
  },
  savePatient(){
    $('.form-control').removeClass('is-invalid')
    $check = 0
    if($('#txtSerial').val() == ''){
      $('#txtSerial').addClass('is-invalid'); $check++
    }

    if($('#txtBw').val() == ''){
      $('#txtBw').addClass('is-invalid'); $check++
    }

    if($('#txtAdm').val() == ''){
      $('#txtAdm').addClass('is-invalid'); $check++
    }

    if($check != 0){
      return ;
    }

    var param = {
      uid: current_user,
      serial: $('#txtSerial').val(),
      hn: $('#txtHn').val(),
      gender: $('#txtGender').val(),
      ga: $('#txtGa').val(),
      bw: $('#txtBw').val(),
      adm: serializeDate($('#txtAdm').val()),
      disc: serializeDate($('#txtDisc').val()),
      die: $('#txtDie').val(),
      los: $('#txtLos').val()
    }

    var jxr = $.post(conf.api + 'neonate?stage=savenew', param , function(){})
               .always(function(resp){
                 if(resp == 'Y'){
                   preload.hide()
                   swal({
                     title: "Success",
                     text: "Click OK to reload data.",
                     type: "success",
                     showCancelButton: false,
                     confirmButtonColor: "#DD6B55",
                     confirmButtonText: "OK",
                     closeOnConfirm: false },
                   function(){
                     window.location.reload()
                   });
                 }else{
                   preload.hide();
                   swal("Error", "Can not record", "error")
                 }
               })
  }
}
