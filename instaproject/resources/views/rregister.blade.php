
<!DOCTYPE html>
<html>
<head>
<!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
<!-- Add icon library -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style type="text/css">


body{  
   font-family: Calibri, Helvetica, sans-serif;  
  /*background-color: skyblue;*/
  /*border: 1px solid black;*/
    background-size:cover; 
  background-attachment: fixed;
  margin: 30px;

}

.input-container {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  width: 90%;
  margin:10px;
  margin-left:17px;
  color: black;
}

.icon {
  padding: 15px;
 
  background: dodgerblue;
  color: white;
  /*min-width: 30px;*/
  width: 15%;
  text-align: center;
  border-radius: 5px 5px; 

}

.input-field {
  width: 100%;
  padding: 20px;
  outline: none;

}

.input-field:focus {
  border: 2px solid black;
}

/* Set a style for the submit button */
.btn {
  background-color: dodgerblue;
  color: white;
  padding: 10px;
  border: none;
  cursor: pointer;
  width: 90%;
  margin:15px;
  margin-left:17px;
  opacity: 0.9;
  border-radius: 5px; 
  /*font-family: 'BebasNeueRegular','Arial Narrow',Arial,sans-serif;*/
  font-size: 24px;
  padding: 10px;

}

.btn:hover {
  opacity: 1;
}

input[type=text], 
input[type=password],
input[type=number],input[type=email], textarea  {  
  width:100%;  
  padding:10px; 
  border-radius: 5px; 
  /*margin: 5px 0 22px 0;  
  display: inline-block;  
  border: 1px solid black;  
  background:white;*/
} 

input[type=radio]{
  margin-top:15px;
  width:30px;
}
.xyz{
  margin-top:10px;
}

input[type=text]:focus, 
input[type=password]:focus,
input[type=number]:focus,input[type=email]:focus,
textarea:focus { 

  background-color:;  
  outline: none;  
  /*vertical-align: : center;*/
} 

form{
  border: 1px solid black;
  border-radius: 5px;
  background-color:black;
  /*margin-right: 10px;*/
  /*margin-bottom: 50px;*/
  /*margin:120px;*/
  /*border:1px solid black;*/
}
h1{

  color: white;
}
/*
/*#Sname{
  color: red;
  /*display: none;*/
  margin:10px;
  margin-left:20px;
}

#Sname{
  color: red;
  /*/*display: none;*/
  
}

 .text-danger1{
    color: red;
    margin-left:20px;
    display: block;
    /*margin-left:-25px;*/
  }


  .text-danger{
    /*font-size:10px;*/
    margin: 10px;
    /*padding: 10px;*/
    font-weight:600; 
  }

  .alert-success{
    display: none;
  }
  .alert-danger{
    display: none;
  }
  .btn1{
    margin-left:20px;
  }
</style>
<body>
    <form action="" id="image_form" name="form" method="post" style="max-width:350px; margin:auto" enctype="multipart/form-data">
       {{ csrf_field() }}
        <center><h1><b>Registration </b></h1></center>

        <div class="input-container">
          <i class="fa fa-user icon"></i>
            <input calss="input-field" onkeypress ="getLocation()" type="text" name="user_fullname" placeholder= "Enter User Name" id="user_fullname">
        </div>
         <span id="Sname" class="text-danger1"></span>

        <div class="input-container">
          <i class="fa fa-envelope icon"></i>
          <input  type="text"  class="input-field" placeholder="Enter Emali address" name="user_email" id="user_email" />  
        </div>
          <span id="Semail" class="text-danger1"></span>
        <div class="input-container">
          <i class="fa fa-phone icon" aria-hidden="true"></i>
          <input type="text" name="user_mobile_no" onkeyup ="charAlert()" placeholder="Enter Mobile No." size="10"/ id="user_mobile_no" >
        </div>
          <span id="Smobile" class="text-danger1"></span>

        <div class="input-container">
          <i class="fa fa-key icon"></i>
          <input class="input-field" type="password" placeholder="Enter Password" name="user_password" id="user_password">
        </div>
          <span id="Spassword" class="text-danger1"></span>
            <!-- <div id="Spassword">***Please Enter Valid password...</div> -->
       <!--  <button onclick="getLocation()" id="location" class="btn1" name="location">Current Location</button> -->
        <p id="latitude" name="latitude"></p>
        <p id="longitude" name="longitude"></p>

          <span id="Slocation" class="text-danger1"></span>


        <input type="submit" name="add" class="btn" value="submit" id="submit"> 
        <div id="successmessage" class="alert alert-success"></div>
        <div id="errormessage" class="alert alert-danger"></div>

        <script type="text/javascript">
          
       
        </script>
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
       $('#Sname').text("** Please Enter Valid User Name... ")
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
               $("#errormessage").html("You are already <strong>Register!</strong>").slideDown();
              $("#image_form").trigger("reset")
               setTimeout(function () { 
              $('#errormessage').alert('close'); 
               }, 2000); 
            }else{ 
              window.location.href = "login";
              $("#successmessage").html("User Registration <strong>Successfully!</strong>").slideDown();
              $("#image_form").trigger("reset")
               setTimeout(function () { 
              $('#successmessage').alert('close'); 
               }, 2000);  
            }
          // }
      
         }
        });

   
});

   


</script>

</body>
</html>


