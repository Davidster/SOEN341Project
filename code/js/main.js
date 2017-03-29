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

//Ajax viewGroup Files



  
$('.uploadButton').on('click', function(){
  
let input = $('.fileInput');
input.textContent = $('.uploadButton').value;  
$('.fileUploads').appendChild(input);
let removebutton =document.createElement('Button');
$('.removeButton').appendChild(removeButton);
 removebutton.document

$('.uploadButton').value = ''; });

$('.uploadForm').on('click', function(event){
	if(event.target.tagname == 'Button'){
		$('.removeButton')=event.target.parentNode;
		$('.removeButton').previousSibling($('.fileUploads'));
		$(".fileUploads").removeChild();
		
	}
});
  


//animsition

$(".animsition").animsition({
	inClass: 'fade-in',
	outClass: 'fade-out',
	linkElement: '.animsition-link',
	inDuration: 1500,
	outDuration: 500
});
	
$(".animsitionLogin").animsition({
	inClass: 'fade-in',
    outClass: 'zoom-out-sm',
	linkElement: '.animsition-link',
	inDuration: 1500,
	outDuration: 5000
});

$(".animsitionMyProfile").animsition({
	inClass: 'zoom-in-sm',
    outClass: 'fade-out',
	linkElement: '.animsition-link',
	inDuration: 1500,
	outDuration: 500
});

//sticky

$(".navbar").sticky();

