/**
 * Created by Himius on 02.06.2018.
 */

var $ = require('jquery');
require('bootstrap-sass');

$(document).ready(function(){

    $('.btn-back-action').click(function(){
        if ('referrer' in document) {
            window.location = document.referrer;
            /* OR */
            //location.replace(document.referrer);
        } else {
            window.history.back();
        }
    });

});

require('../css/main.scss');