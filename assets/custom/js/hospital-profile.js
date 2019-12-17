var hosp_profile = {
  nicu(stage){
    if(stage == 'update'){
      $('.form-control').removeClass('is-invalid')
      if($('#txtLevel').val() == ''){
        $('#txtLevel').addClass('is-invalid')
        return ;
      }

      var param = {
        uid: current_user,
        nicu: $('#txtLevel').val()
      }

      var jxr = $.post(conf.api + )
    }
  }
}
