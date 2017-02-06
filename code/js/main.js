$(document).ready(function(){

    // create click event listener for all <li> tags inside the <ul class="menu" id="menu">
    // notice how were using css selectors to grab objects from the html
    $(".menu li").click(function(e){

        var pageTarget = $(this).attr("pagetarget");
        console.log("pageTarget: " + pageTarget);

        // make all pages display-none
        $("#page-content > div").css("display", "none");

        // make the page were targeting display-block
        // here we are building a css selector
        $("#" + pageTarget).css("display", "block");

    });

});