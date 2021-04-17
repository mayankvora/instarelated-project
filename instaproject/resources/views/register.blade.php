<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
<style>
body {font-family: Arial, Helvetica, sans-serif;}
/*form {border: 3px solid #f1f1f1;}*/

input[type=text], input[type=password] {
  width: 100%;
  padding: 8px 18px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

.w3-theme {
  width: 100%;
}

.w3-theme:hover {
  opacity: 0.8;
}

.cancelbtn {
  width: auto;
  padding: 10px 18px;
  background-color: #f44336;
}

.imgcontainer {
  text-align: center;
  margin: 24px 0 12px 0;
}



.container {
  padding: 16px;
}

span.psw {
  float: right;
  padding-top: 16px;
}
.w3-containe{
  width: 70%;
}

/* Change styles for span and cancel button on extra small screens */
@media screen and (max-width: 300px) {
  span.psw {
     display: block;
     float: none;
  }
  .cancelbtn {
     width: 100%;
  }
}
</style>
</head>
<body>

<div class="w3-container w3-card w3-white w3-round w3-margin" id="main">
  <h2 style="text-align: center;">Registration</h2>
    <div id="successmessage" style="text-align: center;margin:10px; " class="text-success"></div>
    <div id="errormessage" style="text-align: center;" class="text-danger"></div>

<form action="" id="image_form" name="form" method="post" enctype="multipart/form-data">

  {{ csrf_field() }}
  <div class="container">
    <div>
      <label for="uname"><b>User Name</b></label>
      <input type="text" onkeypress ="getLocation()" type="text" name="user_fullname" placeholder= "Enter User Name" id="user_fullname" >
    </div> 
        <span id="Sname" class="text-danger"></span>

    <div>
      <label for="uname"><b>Email</b></label>
      <input type="text" placeholder="Enter Email Address" name="user_email" id="user_email" >
    </div>
        <span id="Semail" class="text-danger"></span>

    <div>
      <label for="uname"><b>Mobile No.</b></label>
      <input type="text" name="user_mobile_no" onkeyup ="charAlert()" placeholder="Enter Mobile No." size="10"/ id="user_mobile_no" >
    </div>
          <span id="Smobile" class="text-danger"></span>

    <div> 
      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="user_password" id="user_password">
    </div>
        <span id="Spassword" class="text-danger"></span><br>
        <p id="latitude" name="latitude"></p>
        <p id="longitude" name="longitude"></p>

      <input type="submit" name="add"  class="w3-button w3-theme"  value="Registration
      " id="submit"> 
    <!-- <input type="submit" class="w3-button w3-theme" value="Login"> -->
    <br>
    
     </div>
  </div>
</form>

  <script>
  

 // var name=document.forms['form']['Name'];
 //    name.addEventListener('textInput',nname_verify);
 //    var nname_error=document.getElementById('Sname');
 //    function nname_verify{
 //      nname_error.style.display="none";
 //    }


function charAlert() {
      var mobile=document.getElementById('user_mobile_no').value;

      var textField=event.key;
     var textField = document.form.user_mobile_no

      if(textField.value.length>10){

         textField.value= textField.value.substring(0,10)
  // textField.blur()
  // alert("No more text can be entered");
      // document.getElementById('Smobile').innerHTML="**Mobile No. 10 Digit Allow...";
        }
  }

 $(document).ready(function(){
  // fetch_data();
});



    var x = document.getElementById("latitude");
    var x1 = document.getElementById("longitude");


    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
      }
    }

    function showPosition(position) {
      x.innerHTML = "<input type='hidden' name='latitude' value= "+position.coords.latitude+" id='newInputBox'>";
      x1.innerHTML  = "<input type='hidden' name='longitude' value= "+position.coords.longitude+" id='newInputBox'>";
    }

$('#image_form').submit(function(event){
  event.preventDefault();
  // getLocation();
  var name=$('#user_fullname').val();
  var email = $("#user_email").val();
  var mobile= $("#user_mobile_no").val();
  var password = $('#user_password').val();
  var location = $('#location').val();
    // var image = document.getElementById("image").value;

    var UserReg=/^[a-zA-Z .]{1,100}$/;
    var mailReg= /^[a-zA-Z0-9._]{2,}@[a-zA-z]{5,}[.]{1}[a-zA-Z.]{3,6}$/;
    var phoneReg=/^[0-9][0-9]{9}$/;
    // var passReg=/^(?=.*[0-9])(?=.*[A-Z])[a-zA-Z0-9]{6,12}$/;


    if (UserReg.test(name)) {
        $('#Sname').text("");

      }
      else{
       $('#Sname').text("** Please Enter User Name... ")
        return false;
      }


      if (mailReg.test(email)) {
        $('#Semail').text("");

      }
      else{
       $('#Semail').text("** Please Enter Valid Email Id ")
        return false;
      }

       if (phoneReg.test(mobile)) {
        $('#Smobile').text("");

      }
      else{
       $('#Smobile').text("** Only Number enter in 10 digit... ")
        return false;
      }
      if (password == "") {
        $('#Spassword').text("** Please enter password")
        return false;
      }
        
       /* function getLocation() {
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
          } 
        }

         function showPosition(position) {
          latitude = position.coords.latitude;
          longitude = position.coords.longitude;  
        }
        // alert(latitude);
  
        alert(latitude);*/
        var formdata = new FormData(this);
        /*formdata.append('latitude',latitude);
        formdata.append('longitude',longitude);*/
        // var formdata = new FormData(this);
        $.ajax({
         url:"{{url('user_registration')}}",
         method:"post",
         data:formdata,
         // data:{},
         contentType:false,
         processData:false,
         success:function(data){
          /* if (typeof data !== 'object') {
                data = JSON.parse(data);
            }
            if (data.redirect) 
            {
                window.location.replace(data.redirect);
            }else{*/
            if (data == 0) {
              $('#errormessage').html(data).fadeIn('slow');
                $('#errormessage').html("You are already registered !!").fadeIn('slow') //also show a success message 
                $('#errormessage').delay(2000).fadeOut('slow');
            }else{ 
              window.location.href = "login";
               $('#successmessage').html(data).fadeIn('slow');
                $('#successmessage').html("Registration Successfully").fadeIn('slow') //also show a success message 
                $('#successmessage').delay(2000).fadeOut('slow'); 
            }
          // }
      
         }
        });

   
});

  

</script>

</body>
</html>
