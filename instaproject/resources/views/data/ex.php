<link href="https://fonts.googleapis.com/css?family=Indie+Flower|Overpass+Mono" rel="stylesheet">

<div id="wrapper">
  <div class="main-content">
    <div class="header">
      <img src="https://i.imgur.com/zqpwkLQ.png" />
    </div>
    <div class="l-part">
      <input type="text" placeholder="Username" class="input-1" />
      <div class="overlap-text">
        <input type="password" placeholder="Password" class="input-2" />
        <a href="#">Forgot?</a>
      </div>
      <input type="button" value="Log in" class="btn" />
    </div>
  </div>
  <div class="sub-content">
    <div class="s-part">
      Don't have an account?<a href="#">Sign up</a>
    </div>
  </div>
</div>




<!-- By Coding Market -->
<div class="youtube">
  <a href="https://www.youtube.com/channel/UCtVM2RthR4aC6o7dzySmExA" target="_blank">by coding market</a>
</div>



<!-- Registration -->


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
    /*margin:10px;*/
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
</style>
<body>
    <form action="" id="image_form" method="post" style="max-width:350px; margin:auto" enctype="multipart/form-data">
       {{ csrf_field() }}
        <center><h1><b>Registration </b></h1></center>

        <div class="input-container">
          <i class="fa fa-user icon"></i>
            <input calss="input-field" type="text" name="user_fullname" placeholder= "Enter User Name" id="user_fullname">
        </div>
         <span id="Sname" class="text-danger1"></span>

        <div class="input-container">
          <i class="fa fa-envelope icon"></i>
          <input  type="text"  class="input-field" placeholder="Enter Emali address" name="user_email" id="user_email" />  
        </div>
          <span id="Semail" class="text-danger1"></span>
        <div class="input-container">
          <i class="fa fa-phone icon" aria-hidden="true"></i>
          <input type="text" name="user_mobile_no" placeholder="Enter Mobile No." size="10"/ id="user_mobile_no" >
        </div>
          <span id="Smobile" class="text-danger1"></span>

        <div class="input-container">
          <i class="fa fa-key icon"></i>
          <input class="input-field" type="password" placeholder="Enter Password" name="user_password" id="user_password">
        </div>
          <span id="Spassword" class="text-danger1"></span>
            <!-- <div id="Spassword">***Please Enter Valid password...</div> -->


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


// function charAlert() {
//       var mobile=document.getElementById('mobile').value;

//       var textField=event.key;
//      var textField = document.form.Mobile_no

//       if(textField.value.length>10){

//          textField.value= textField.value.substring(0,10)
//   // textField.blur()
//   // alert("No more text can be entered");
//       document.getElementById('Smobile').innerHTML="**Mobile No. 10 Digit Allow...";
//         }
//   }

 $(document).ready(function(){
  // fetch_data();
});

$('#image_form').submit(function(event){
  event.preventDefault();
  var name=$('#user_fullname').val();
  var email = $("#user_email").val();
  var mobile= $("#user_mobile_no").val();
  var password = $('#user_password').val();
    // var image = document.getElementById("image").value;

    var UserReg=/^[a-zA-Z .]{2,12}$/;
    var mailReg= /^[a-zA-Z0_9._]{2,}@[a-zA-z]{5,}[.]{1}[a-zA-Z.]{3,6}$/;
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
      /*else{
       $('#Spassword').text("** Password size 6-12 use in Upercase,lowercase,digit Valid...")
        return false;
      }*/
      // var name=$('#name').val();
      // alert(name);
    
        $.ajax({
         url:"{{url('user_registration')}}",
         method:"post",
         data:new FormData(this),
         // data:{},
         contentType:false,
         processData:false,
         success:function(data){
            if (data == 0) {
               $("#errormessage").html("You are allready Register <strong>Successfully!</strong>").slideDown();
              $("#image_form").trigger("reset")
               setTimeout(function () { 
              $('#errormessage').alert('close'); 
               }, 2000); 
            }else{ 
              $("#successmessage").html("Registration Inserted <strong>Successfully!</strong>").slideDown();
              $("#image_form").trigger("reset")
               setTimeout(function () { 
              $('#successmessage').alert('close'); 
               }, 2000);  
            }
      
         }
        });

   
});

   


</script>

</body>
</html>


