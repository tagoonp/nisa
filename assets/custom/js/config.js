var conf = {
    domain: 'http://localhost/nisa/',
    api: 'http://localhost/nisa/controller/',
    // domain: 'https://postgraduateforum2020.com/',
    // api: 'https://postgraduateforum2020.com/controller/',
    prefix: 'nsllc_',
    mail_user: 'rmismedpsu@gmail.com',
    mail_key: 'cm1pc21lZHBzdUBnbWFpbC5jb20yMDE5LTEwLTIyIDIxOjU4OjU3MTI0LjEyMi40Mi4yNDU=',
}

var current_user = window.localStorage.getItem(conf.prefix + 'uid')
var current_role = window.localStorage.getItem(conf.prefix + 'role')

// var conf = {
//     domain: 'http://rmis2.medicine.psu.ac.th/rmis5/',
//     api: 'http://rmis2.medicine.psu.ac.th/rmis5/controller/',
//     prefix: 'rmis5_'
// }
