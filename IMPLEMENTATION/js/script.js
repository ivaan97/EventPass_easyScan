function fktCheckPass(){
	
	var pass1 = document.getElementById("password1").value;
	var pass2 = document.getElementById("password2").value;
	var vorname =	document.getElementById("vorname").value;
	var nachname = document.getElementById("nachname").value;
	var email = document.getElementById("email").value;
	var adminRadio = document.querySelector('#admin').checked;
	var angestellteRadio = document.querySelector('#angestellte').checked;
	var anwenderRadio = document.querySelector('#anwender').checked;
	
	
	if(!vorname){
		alert("Vorname eingeben!");
	}
	
	if(!nachname){
		alert("Nachname eingeben!");
	}
	
	if(!email){
		alert("Email eingeben!");
	}

	if(!pass1){
		alert("Passwort eingeben!");
	}
	
	if(!pass2){
		alert("Passwort bestätigen!");
	}
	
	if (pass1 !== pass2){
		alert("Passwörter stimmen nicht überein!");
	}
	
}



