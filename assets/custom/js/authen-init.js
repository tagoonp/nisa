var authen_init = {
  init(){
    if((current_user == null) || (current_role == null)){
      window.localStorage.removeItem(conf.prefix + 'uid')
      window.localStorage.removeItem(conf.prefix + 'role')
      window.location = '../index'
    }

    setFontsize()
  }
}

authen_init.init()
