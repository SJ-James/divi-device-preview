jQuery(document).ready(function($){

	// Device Toggle

	$(".device-toggle-list .mobile").click(function(){
		$(".device-wrapper").addClass("mobile");
        $(".device-wrapper").removeClass("tablet");
        $(".device-wrapper").removeClass("desktop");
    });

	$(".device-toggle-list .tablet").click(function(){
		$(".device-wrapper").addClass("tablet");
        $(".device-wrapper").removeClass("mobile");
        $(".device-wrapper").removeClass("desktop");
    });

	$(".device-toggle .desktop").click(function(){
		$(".device-wrapper").addClass("desktop");
        $(".device-wrapper").removeClass("tablet");
        $(".device-toggle-list").removeClass("mobile");
    });

});