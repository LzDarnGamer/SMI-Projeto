<!DOCTYPE html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
        <title>User Register</title>
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    </head>
    <body>
      <form 

        action="processRegisterRequest.php"
        name="FormLogin"
        onsubmit="return checkPassword(this)" 
        method="post" >
        <table>
          <tr>
            <td>Name:</td>
            <td><input 
                type="text" 
                name="name" 
                placeholder="Your Name"
                required="true" 
                onblur="nameCheck(this)"> 
			</td>
			<td>
            	<div id="nameCheck"></div>
            </td>
          </tr>
          <tr>
            <td>E-mail:</td>
            <td><input 
                type="email" 
                name="email" 
                placeholder="Your e-mail"
               	required="true" 
                onblur="emailCheck(this)"></td>
			<td>
            	<div id="emailCheck"></div>
            </td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input 
                type="password" 
                name="password"
                id="password"
                required="true"
                placeholder="Password"></td>
          </tr>
		  <tr>
            <td>Re-type Password:</td>
            <td><input 
                type="password" 
                name="repassword"
                id="repassword"
                required="true" 
                placeholder="Confirm Password"></td>
			<td>
            	<div id="passwordCheck"></div>
            </td>
          </tr>
		  <tr>
		  	<td>Image</td>
            <td><img class="captcha-image" style="border: 1px solid black" src="captcha.php" alt="catcha image"></td>
            <td><button class="refresh-captcha" type="button">Refresh</button><td>
          </tr>
          <tr>
          	<td>Captcha</td>
            <td><input id="captcha" type="captcha" name="captcha" placeholder="captcha" required="true"></td>
          </tr>
          <tr>
            <td>
              <input type="submit" value="Register">
            </td>
            <td>
              <input type="reset" value="Reset">
            </td>
          </tr>        
        </table>
            

      </form>

<script>
	document.getElementById('captcha').value = "";
	var refreshButton = document.querySelector(".refresh-captcha");
	refreshButton.onclick = function() {
	  document.querySelector(".captcha-image").src = 'captcha.php?' + Date.now();
	}

	function nameCheck(e){
		if(e.value!=""){
			$.ajax({
	        url: 'checkfunctions.php',
	        type: 'POST',
		    data : {field:"name", value: e.value},
			success: function(data) {
		    	if(data === "true"){
		    		document.getElementById("nameCheck").innerHTML = "Utilizador disponível";
		    		document.getElementById("nameCheck").style.color = 'lime';
		    	}else{
		   			document.getElementById("nameCheck").innerHTML = "Utilizador não disponível";
		    		document.getElementById("nameCheck").style.color = 'red';
		    	}
	        }
	    	})
    	}else{
    		document.getElementById("nameCheck").innerHTML = "";
    	}
	};



    function emailCheck(e){
    	var pattern = /[^@\s]+@[^@\s]+\.[^@\s]+$/
    	if(pattern.test(e.value)){
			$.ajax({
	        url: 'checkfunctions.php',
	        type: 'POST',
		    data : {field:"email", value: e.value},
			success: function(data) {
	        	if(data === "true"){
	        		document.getElementById("emailCheck").innerHTML = "Email disponível";
	        		document.getElementById("emailCheck").style.color = 'lime';
	        	}else{
	       			document.getElementById("emailCheck").innerHTML = "Email não disponível";
	        		document.getElementById("emailCheck").style.color = 'red';
	        	}
	        }
	    	})
		}else{
			document.getElementById("emailCheck").innerHTML = "";
		}
    };

    function checkPassword(form) {
        password1 = form.password.value; 
		password2 = form.repassword.value;
		if(password1 != password2){
			document.getElementById("passwordCheck").innerHTML = "Passwords don't match";
			document.getElementById("passwordCheck").style.color = 'red';
			return false;
		}
		return true;
    }
</script>
    </body>
</html>

