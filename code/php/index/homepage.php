<?php 
	//session_start();
	if (isset($_SESSION['name'])){
		echo 
		'<div id="home-page" style="display: none">
			<h2>Welcome to your portal!</h2>
				<button class="btn">Change passeword</button>
				</br></br>
				<button class="btn">Personal information</buttom>
		</div>';
	}
	else{
		echo
		'<div id="home-page" style="display: none">
			<h2>Home Page</h2>
		</div>';
	}
?>

