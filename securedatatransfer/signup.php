<!DOCTYPE html>
<html>
<head>
    <title>My Chat</title>
</head>
<style type="text/css">

    @font-face{
        font-family: headFont;
        src: url(ui/fonts/Summer-Vibes-OTF.otf);
    }

    @font-face{
        font-family: myFont;
        src: url(ui/fonts/OpenSans-Regular.ttf);
    }
    #wrapper{
        max-width:900px;
        min-height:500px;
        margin: auto;
        color:grey;
        font-size: 14px;
    }
    
    form{
        margin: auto;
        padding: 10px;
        width: 100%;
        max-width: 400px;
    }

    input[type=text],[type=password],[type=submit]{

        padding: 10px;
        margin: 10px;
        width: 98%;
        border-radius: 5px;
        border: solid 1px grey;
    }

    input[type=button]{
        width: 108%;
        cursor: pointer;
        background-color: #2b5488;
        color: white;
    }

    input[type=radio]{
        transform: scale(1.2);
        cursor: pointer;
    }

    #header{
        background-color:#485b6c;
        font-size: 43\px;
        text-align:center;
        font-family:headFont;
        width: 100%;
        color: white;
    }

    #error{
        text-align: center;
        padding:0.5em;
        background-color:#ecaf91;
        color:white; 
        display:none;
    }
</style>
<body>
    <div id="wrapper">
        <div id="header">
            MyChat
            <div style="font-size: 25px;font-family: myFont;">Sign Up</div>
        </div>
        <div id="error">Some text</div>
        <form id="myform">
            <input type="text" name="username" placeholder="Username"><br>
            <input type="text" name="email" placeholder="Email"><br>
            <div style="padding:10px;">
                <br>Gender:<br>
                <input type="radio" value="Male" name="gender_male">Male<br>
                <input type="radio" value="Female" name="gender_female">Female<br>
            </div> 
            <input type="password" name="password" placeholder="Password"><br>
            <input type="password" name="password2" placeholder="Retype Password"><br>
            <input type="button" value="Sign Up" id="signup_button"><br>

            <br>
            <a href="login.php" style="display: block;text-align: center;text-decoration: none;">
                Already have a Account? Login here
        </form>
    </div>
</body>
</html>

<script type="text/javascript">
	function _(element) {

		return document.getElementById(element);

	}
    var signup_button=_("signup_button");
	signup_button.addEventListener("click",Collectdata);

	function Collectdata(){

        signup_button.disabled = true;
        signup_button.value = "Loading please wait....";

		var myform = _("myform");
		var inputs = myform.getElementsByTagName("INPUT");
		var data =  {};
		for (var i = inputs.length - 1; i>=0;i--){
			var key=inputs[i].name;
			switch(key){
				case "username":
				    data.username=inputs[i].value;
				    break;
				case "email":
				    data.email=inputs[i].value;
				    break;
				case "gender_male":
                case "gender_female":
				    if(inputs[i].checked){
				    	data.gender=inputs[i].value;
				    }
				    break;
				case "password":
				    data.password=inputs[i].value;
				    break;
				case "password2":
				    data.password2=inputs[i].value;
				    break;
			}
		}

		send_data(data,"signup");
        
		
	}
	function send_data(data,type){
		var xml = new XMLHttpRequest();
		xml.onload=function(){
			if(xml.readyState == 4 || xml.status == 200){
				handle_result(xml.responseText);
                signup_button.disabled = false;
                signup_button.value = "SignUp";
			}
		}
		data.data_type=type;
		var data_string=JSON.stringify(data);
	    xml.open("POST","api.php",true);
  	    xml.send(data_string);
		
	}

    function handle_result(result){

        console.log(result);
        var data = JSON.parse(result);
        if(data.data_type == "info"){

            window.location = "index.php";
        }else{
            var error = _("error");
            error.innerHTML = data.message;
            error.style.display = "block";
        }
    }
</script>