var fnc = {
  snap(snap){
    if((snap != '') && (snap.length > 0)){
        return true;
    }else{
        return false;
    }
  },
  gotoUrl(url, target){
    if(target == '_blank'){
      window.open(url, target = target)
    }else{
      window.location = url
    }
  },
  randomString: function(L){
      var s = '';
      var randomchar = function() {
          var n = Math.floor(Math.random() * 62);
          if (n < 10) return n; //1-10
          if (n < 36) return String.fromCharCode(n + 55); //A-Z
          return String.fromCharCode(n + 61); //a-z
      }
      while (s.length < L) s += randomchar();
      return s;
  }
}

function setFontsize(){
  if((current_user != null)){
     var param = {
       uid: current_user
     }
     var jxr = $.post(conf.api + 'authentication?stage=getFontsize', param, function(){})
                .always(function(resp){
                  if((resp != '') && (resp != null)){
                    $('body *').each(function() {
                       $(this).css('font-size', resp + 'px');
                    });

                    $('h1').css('font-size', '38px');
                    $('small').css('font-size', (resp * 0.8) + 'px');
                    $('#chartPreload').css('font-size', '100px');
                  }
                })
  }
}

function changeFontsize(stage){
  var fs = null
  if(stage == 1){
    $('body *').each(function() {
       xsize = parseInt($(this).css('font-size')) + 1;
       xsize = xsize + (xsize * 0.1)
       $(this).css('font-size', xsize);
       fs = xsize
     });
  }else{
    $('body *').each(function() {
       xsize= parseInt($(this).css('font-size')) - 1;
        xsize = xsize - (xsize * 0.1)
       $(this).css('font-size', xsize);
       fs = xsize
     });
  }

  if((current_user != null) && (fs != null)){
     var param = {
       uid: current_user,
       current_fsize: fs
     }
     var jxr = $.post(conf.api + 'authentication?stage=saveFontsize', param, function(){})
  }
}
