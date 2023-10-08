/*global $, jQuery, alert*/
$(document).ready(function () {
	
	"use strict";
	
	$("html").niceScroll();
	
    $('.carousel').carousel({
		
        interval: 5000
		
    });
	
	
    // Change Theme Color On Click
	
    var scrollButton = $("#scroll-top");
		
    $(document).scroll(function () {
        if ($(this).scrollTop() >= 700) {
			
            scrollButton.show();
			
		} else {
			
			scrollButton.hide();
			
		}
    });
	
    //Clicking On The Button To Scroll Top
	
    scrollButton.click(function () {
        
        $("html").animate({scrollTop: 0}, 600);
		
    });
});

var color = "red";
function d_name() {
	"use strict";
    var doctor_name = document.getElementById("doctor_name");
    if (color === "red") {
		
        doctor_name.style = "color:#fff";
        color = "green";
		
    } else {
		
        doctor_name.style = "color:#E41B17";
        color = "red";
		
    }
    
}
setInterval(d_name, 1000);

