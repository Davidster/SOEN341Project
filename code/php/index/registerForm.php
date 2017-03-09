<div id='register-page' style='display: none'>
				<h1>Register Page</h1>
				<form id='createAccount' action='' method='post'>
					<p>Enter your Concordia ID:</p>
					<input type='text' name='id' placeholder='Concordia ID' required/>
					<p>Enter your full name:</p>
					<input type='text' name='fullName' placeholder='Full Name' required/>
					<p>Enter your email:</p>
					<input type='email' name='email' placeholder='Email Address' required/>
					<p>Create a Password:</p>
					<input type='password' name='password' placeholder='Password' required/>
					<p>Confirm Password:</p>
					<input type='password' name='repassword' placeholder='Password' required/>
					<input type='radio' name='accountType' />
					Teacher's Assistant
					</br>
					<input type='radio' name='accountType' />
					Student
					</br></br>	
					<input type='submit' value = 'Submit' name='register'/>
				</form>
			</div>