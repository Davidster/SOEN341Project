$(document).ready(function(){
	var $j = jQuery.noConflict();

    // create click event listener for all <li> tags inside the <ul class="menu" id="menu">
    // notice how were using css selectors to grab objects from the html
    $j("#menu li").click(function(e){

        var pageTarget = $j(this).attr("pagetarget");
        console.log("pageTarget: " + pageTarget);

        // make all pages display-none
        $j("#page-content > div").css("display", "none");

        // make the page were targeting display-block
        // here we are building a css selector
        $j("#" + pageTarget).css("display", "block");
		
	
	


});



});
	$(".animsition").animsition({
		inClass: 'fade-in-right-sm',
		outClass: 'fade-out-right-sm',
		linkElement: '.animsition-link',
		inDuration: 1000,
		outDuration: 5000
		
		
	});
	
		$(".animsition1").animsition({
		inClass: 'fade-in-right-lg',
		outClass: 'fade-out-right-lg',
		linkElement: '.animsition-link',
		inDuration: 1500,
		outDuration: 500
		
		
	});
	
	$(".navbar").sticky();