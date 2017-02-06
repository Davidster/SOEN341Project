console.log("Hello World");

function displayAccountCreation(e){
    if (e.onclick)
        document.getElementById('createAccount').style.display = 'block';
    else
      document.getElementById('createAccount').style.display = 'none';
    }
function displayAccountLogin(e){
    if (e.onclick)
        document.getElementById('login').style.display = 'block';
    else
        document.getElementById('login').style.display = 'none';
    }	
	