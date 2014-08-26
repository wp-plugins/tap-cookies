var TAP_Cookies = function(){
  var cookie_name = "_tap_cookie";
  var message_title = "Pol&iacute;tica de Cookies";
  var message_text = "Este sitio web utiliza cookies propias y de terceros que nos permiten ofrecer nuestros servicios. Al utilizar nuestros servicios, aceptas el uso que hacemos de las cookies. <a href='http://todoapuestas.org/blog/politica-de-cookies/' rel='nofollow' target='_blank'>M&aacute;s informaci&oacute;n</a>";

  var create_cookie = function(){
    jQuery.cookie(cookie_name, 1, { expires: 365, path: '/' });
  }

  var clear_cookies = function() {
    var all_cookies = document.cookie.split(";");
    console.debug(all_cookies);
    for(var i = 0; i < all_cookies.length; i++){
      jQuery.cookie(all_cookies[i].split("=")[0], null, { expires: -365, path: '/' } );
    }
  }

  return {

    init: function(){
      toastr.options = {
        "closeButton": true,
        "debug": false,
        "positionClass": "toast-bottom-full-width",
        "showDuration": "10000000",
        "hideDuration": "10000000",
        "timeOut": "10000000",
        "extendedTimeOut": "10000000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        onHidden: function() {
          create_cookie();
        }
      };

      var cookie_value = jQuery.cookie(cookie_name);
      if(cookie_value == null || !cookie_value){
        clear_cookies();
      }

      if(cookie_value){
        toastr.clear();
      }else{
        toastr.info(message_text, message_title);
      }
    }

  }

}();

(function ( $ ) {
	"use strict";

	$(function () {

    TAP_Cookies.init();

	});

}(jQuery));