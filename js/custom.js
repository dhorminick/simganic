/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 * 
 */

"use strict";

var message = $('.alert-body').text();
var messageBox = $('.alert-div');
if (message != "" || message != null) {
    setTimeout(hideMsg, 3000);
}
function hideMsg() {
    message = "";
    messageBox.fadeOut(500);
}

$('.submit-newsletter').on('submit', function (event){
        
        event.preventDefault();

        var formValues = $(this).serialize();

        //$("#update-cart-form button").prop('disabled', true);
        //$(".btn-form-cart").prop('disabled', true);

        $.post("_layout/_ajax.php", {add_to_newsletter: formValues}).done(function (data) {
        //Display the returned data in browser
        //var x = document.getElementById("response");
        //x.className = "show";
        //setTimeout(function(){ 
            //x.className = x.className.replace("show", "");
            //$("#update-cart-form button").prop('disabled', false);
            //$(".btn-form-cart").prop('disabled', false);
            //$(".num").load(" .num > *");
            //$(".item-count").load(" .item-count > *");
        //}, 1000);
        setTimeout(function(){ $("#res").load(" #res > *") }, 5000);
        //$(".num_count").load(" .num_count > *"); 
        //$(".num_count_form").load(" .num_count_form > *");                                          
        $("#res").html(data);
        });                            

});
