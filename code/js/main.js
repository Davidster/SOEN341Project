var $j = jQuery.noConflict();

$j(document).ready(function(){

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


    //Ajax viewGroup Files



	  
	$j('.uploadButton').on('click', function(){
	  
	let input = $j('.fileInput');
	input.textContent = $j('.uploadButton').value;  
	$j('.fileUploads').appendChild(input);
	let removebutton =document.createElement('Button');
	$j('.removeButton').appendChild(removeButton);
	 removebutton.document

	$j('.uploadButton').value = ''; });

	$j('.uploadForm').on('click', function(event){
		if(event.target.tagname == 'Button'){
			$j('.removeButton')=event.target.parentNode;
			$j('.removeButton').previousSibling($j('.fileUploads'));
			$j(".fileUploads").removeChild();
			
		}
	});
	  


	//animsition

	$j(".animsition").animsition({
		inClass: 'fade-in',
		outClass: 'fade-out',
		linkElement: '.animsition-link',
		inDuration: 1500,
		outDuration: 500
	});
		
	$j(".animsitionLogin").animsition({
		inClass: 'fade-in',
	    outClass: 'zoom-out-sm',
		linkElement: '.animsition-link',
		inDuration: 1500,
		outDuration: 5000
	});

	$j(".animsitionMyProfile").animsition({
		inClass: 'zoom-in-sm',
	    outClass: 'fade-out',
		linkElement: '.animsition-link',
		inDuration: 1500,
		outDuration: 500
	});

	//sticky

	$j(".navbar").sticky();



});