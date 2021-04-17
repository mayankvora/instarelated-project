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
  <h2 style="text-align: center;">Login</h2>
    <div id="successmessage" style="text-align: center;margin:10px; " class="text-success"></div>
    <div id="errormessage" style="text-align: center;" class="text-danger"></div>
    <div id="Semail" style="text-align: center;" class="text-danger"></div>
<form id="image_form" method="post"  enctype="multipart/form-data">
  <div class="imgcontainer">
  </div>
  @csrf
  <div class="container">
    <div>
      <label for="uname"><b>Email</b></label>
      <input type="text" placeholder="Enter Emali" name="user_email" id="user_email" >
    </div>

        <span id="Semail" class="text-danger"></span>
    <div> 
      <label for="psw"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="user_password" id="user_password">
    </div>
        <span id="Spassword" class="text-danger"></span>

        <!-- <span class="">Create an Account? <a href="#">Register now..</a></span><br> -->
        <p style="">Create an account ? <a href="{{url('register')}}" style="color:dodgerblue">Register Now...</a></p>

      <input type="submit" name="add"  class="w3-button w3-theme"  value="Login" id="submit"> 
    <!-- <input type="submit" class="w3-button w3-theme" value="Login"> -->
    <br>
    
     </div>
  </div>
</form>

  <script>
  
$(document).ready(function(event){

});


  $('#image_form').submit(function(event){
  event.preventDefault();

    user_email = $("#user_email").val();
    user_password = $("#user_password").val();
   /* if (user_email == "") {
      $('#Semail').text("Feild is required...");
      return false;
    }*/
    $.ajax({
        type:"post",
        // data:{"user_email":user_email, "user_password":user_password, },
         data:new FormData(this),
        
         contentType:false,
         processData:false,
        url:"{{url('login_redirect')}}",
        success:function(data){ 
          // alert(data);
          // location.reload();
            if (typeof data !== 'object') {
                data = JSON.parse(data);
            }
            if (data.redirect) 
            {
                window.location.replace(data.redirect);
            } 
            else 
            {
              if(data==0) {
                $('#errormessage').html(data).fadeIn('slow');
                $('#errormessage').html("Invalid Email Address").fadeIn('slow') //also show a success message 
                $('#errormessage').delay(2000).fadeOut('slow');
              }
              else{
                $('#errormessage').html(data).fadeIn('slow');
                $('#errormessage').html("Invalid user_emailer Password").fadeIn('slow') //also show a success message 
                $('#errormessage').delay(2000).fadeOut('slow');
              }
             
              // $("#success").html('<p style="color:red;">' + data.error + '</p>');
          }
        }
    });
});

  

</script>

</body>
</html>
