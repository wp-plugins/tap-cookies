(function ( $ ) {
	"use strict";

	$(function () {

    $("#tap-cookies-add-cookie-row").on("click", function(e){
      e.preventDefault();
      var row_id = $("#tap-cookies-table tr:last").attr("id");
      row_id++;
      var pattern = /(\[\d\])/g;
      var row = "<tr id='"+row_id+"'>"+$("#tap-cookies-table tr:last").html()+"</tr>";
      row = row.replace(pattern, "["+row_id+"]");
      $("#tap-cookies-table").append(row);
      return false;
    });

    $(".tap-cookies-remove-cookie-row").on("click", function(e){
      e.preventDefault();
      $(this).parent().parent().remove();
      return false;
    })

	});

}(jQuery));