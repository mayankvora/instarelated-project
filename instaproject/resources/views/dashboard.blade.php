
<!DOCTYPE html>
<html>
<title>Insta project</title>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
  <style>
html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
utline: none;
 /*.like {
      background-color: blue;
      height: 35px;
      width: 120px;
      }

      .like.pressed {
          background-color: red;
      }*/
      #form1{
        display: none;
      }
</style>
<body class="w3-theme-l5">

  <div class="w3-col m12">   
      <div class="w3-row-padding" id="edit_data" style="padding: 10px;" hidden>
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding" >
                 <!-- Edit profile -->
                 <h4 style="text-align: center;">Edit Profile              
                  <button type="button" id="close" class="close" data-dismiss="modal">&times;</button></h4>


               <form method="post" style="padding:10px;" id="update_profile" enctype="multipart/form-data" hidden>
                {{csrf_field()}}
                    <div class="form-group" >
                      <input type="hidden"  name="user_id" class="form-control" placeholder="Enter post name.."  id="user_id" value="{{$get_user->user_id}}">

                      <label for="sel1"><b>User Name</b></label>
                      <input type="text"  name="user_fullname" class="form-control" placeholder="Enter post name.."  id="edit_user_fullname">
                    </div>
                    <div id="Suser_fullname" class="text-danger"></div>


                    <div class="form-group">
                      <input type="hidden" name="user_email" id="edit_user_email" placeholder="Enter post description" class="form-control name_list" readonly/> 
                      
                    </div>
                  
                    <div id="Spackage_desc" class="text-danger"></div>

                    <div class="form-group">
                      <input type="hidden" name="user_mobile_no" id="edit_user_mobile_no" placeholder="Enter post description" class="form-control name_list" /> 
                      
                    </div>
                  
                    <div id="Suser_mobile_no" class="text-danger"></div>
                    
                    <div class="form-group">
                      <input type="hidden" name="user_password" id="edit_user_password" placeholder="Enter post description" class="form-control name_list" /> 
                      
                    </div>
                  
                    <div id="Spackage_desc" class="text-danger"></div>

                    <div class='form-group'> 
                      <td><img src="" class="" width="100px"height="100px" style='text-align:center; object-fit:contain;' name="user_profile" id='show_image'/></td>
                      </div>

                    <div class="form-group" > 
                      <label for="sel1"><b>Edit Profile</b></label>
                      <input type="file" name="user_profile" id="edit_user_profile" />
                    </div>

                    <div id="Spackage_image" class="text-danger"></div>
                  
                    
                     
                    <input type="submit" name="update" id="update" class="btn btn-info" value="update" />  

              </form>
              <div id="success" class="alert-success"></div>
              <div id="error" class=" alert-danger"></div>
            
              </div>
          </div>
        </div>
      </div>
    </div>

<!-- Navbar -->
<div class="w3-top">
 <div class="w3-bar w3-theme-d2 w3-left-align w3-large">
  <a class="w3-bar-item w3-button w3-hide-medium w3-hide-large w3-right w3-padding-large w3-hover-white w3-large w3-theme-d2" href="javascript:void(0);" onclick="openNav()"><i class="fa fa-bars"></i></a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large w3-theme-d4"><i class="fa fa-home w3-margin-right"></i>Logo</a>

   <div class="w3-dropdown-hover">
    <button class="w3-button w3-padding-large" title="Notifications" ><i class="fa fa-user"></i></button>     
    <div class="w3-dropdown-content w3-card-4 w3-bar-block" style="width:300px">
      <a href="{{url('logout')}}" class="w3-bar-item w3-button">Logout</a>
    </div>
  </div>
  
  </div>
 </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-theme-d2 w3-hide w3-hide-large w3-hide-medium w3-large">


  
</div>

<!-- Page Container -->
<div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">    
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white" >
        <div class="w3-container" style="margin: 10px;" id="my_profile">
         <h4 class="w3-center">My Profile </h4>
         <h6 class="w3-center"></h6>
         <p class="w3-center">
         	<center><table id="profile_data" style="text-align:center;">
         	<tr>
         	
         <!-- <hr> -->
           </tr>

         </table></center><br><hr>
        <!-- <table id="get_following" hidden>
                
        </table> -->
          <table id="get_follow" hidden>
                
        </table>
         <!-- <p>Following </p>
         <p>Followers </p> -->
              <center><button type="button" name="edit_profile" id="edit_profile" class="w3-button w3-theme" data-toggle="modal" data-target="#edit_profile_user"><i class="fa fa-pencil" ></i> Edit Profile</button></center>

        </div>
      </div>
      <br>

      <!-- Accordion -->
      <div class="w3-card w3-round" id="">
        <div class="w3-white">
          <button id="my_photos"  class="w3-button w3-block w3-theme-l1 w3-left-align"><i class="fa fa-get_profile fa-fw w3-margin-right"></i> My Photos</button>
          <div id="Demo3" class="w3-hide w3-container">
         <div class="w3-row-padding">
         <br>
         <!-- onclick="myFunction('Demo3')" -->

           

         </div>
          </div>

        </div>      
      </div>
      <br>


      
    
    <!-- End Left Column -->
    </div>


    
    <!-- Middle Column -->
    <div class="w3-col m7">
     
      <div class="w3-row-padding" id="show_post_data">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <button type="button" name="add" id="add_post"  class="w3-button w3-theme" data-toggle="modal" data-target=""><i class="fa fa-pencil"></i> Post</button>

             <form method="post" style="padding:10px;" id="add_post_data" enctype="multipart/form-data" hidden>
                {{csrf_field()}}
                    <div class="form-group" >
                      <input type="hidden"  name="user_id" class="form-control" placeholder="Enter post name.."  id="user_id" value="{{$get_user->user_id}}">

                      <label for="sel1"><b>Post Name</b></label>
                      <input type="text"  name="post_name" class="form-control" placeholder="Enter post name.."  id="post_name">
                    </div>
                    <div id="Spackage_title" class="text-danger"></div>


                    <div class="form-group">
                       <label for="sel1"><b>post Description</b></label>
                      <input type="text" name="post_description" id="post_description" placeholder="Enter post description" class="form-control name_list" /> 
                      
                    </div>
                  
                    <div id="Spackage_desc" class="text-danger"></div>
                     <div class="form-group">

                       <!-- <label for="sel1"><b>post latitude</b></label> -->
                       <button onclick="getLocation()" name="">Current Location</button>
                        <p id="latitude" name="latitude"></p>
                        <p id="longitude" name="longitude"></p>
  
                    </div>
                    <div class="form-group" > 
                      <label for="sel1"><b>Add post</b></label>
                      <input type="file" name="content_name[]" id="content_name" multiple/>
                    </div>

                    <div id="Scontent_name" class="text-danger"></div>
 
                    <input type="submit" name="insert" id="insert" class="btn btn-info" value="insert" />  
              </form>
              <div id="successmessage" class="alert-success"></div>
              <div id="errormessage" class=" alert-danger"></div>
            </div>




            <form class="" id="" action="" align="right" >
              <input type="text" onsearch="" style="" class="form-control" placeholder="Search.." name="search" id="search">
            </form><br>
            <table id="search_data"></table>



              <!-- Edit profile -->


          </div>
        </div>
      </div>

     



    <div id="layoutSidenav_content">
  	<main>
  
		<!-- Insert Post Code -->
    

  <!-- Edit Profile data -->
   <!-- <div id="layoutSidenav_content">
    <main>
  
        <div id="edit_profile_user" class="modal fade" role="dialog">
         <div class="modal-dialog">
          <div class="modal-content">
           <div class="modal-header">
            <h4 class="modal-title" align="center">Edit Profile</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body"> -->
            
             
           

          <!--  <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div>
         </div>
        </div> -->
  </main>
  </div>


  

   <!-- Comment  data -->
  <!--  <div id="layoutSidenav_content">
    <main>
  
        <div id="comment_data" class="modal fade" role="dialog">
         <div class="modal-dialog">
          <div class="modal-content">
           <div class="modal-header">
            <h4 class="modal-title" align="center">Comment</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body">
            <table id="getcomment">
                <tr>
                </tr>
              </table>
              <form method="post" id="add_comment" enctype="multipart/form-data">
                {{csrf_field()}}
                    <div class="form-group" >
                      <input type="hidden"  name="post_id" class="form-control" placeholder="Enter post name.."  id="post_id" value="">
                      <input type="hidden"  name="user_id" class="form-control" placeholder="Enter post name.."  id="user_id" value="{{$get_user->user_id}}">
                      <label for="sel1"><b>Comment Description</b></label>
                      <input type="text"  name="comment_description" class="form-control" placeholder="Enter Comment Description.."  id="comment_description">
                    </div>
                    <div id="Scomment_description" class="text-danger"></div>
                    <input type="submit" name="Comment" id="Comment" class="btn btn-info" value="Comment" />  

              </form>
           </div>
            <div id="success" class="alert-success"></div>
            <div id="error" class=" alert-danger"></div>

           <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div>
         </div>
        </div>
  </main>
  </div>
 -->
  <!-- Replay comment  data -->
   <div id="layoutSidenav_content">
    <main>
  
        <div id="replay_modal" class="modal fade" role="dialog">
         <div class="modal-dialog">
          <div class="modal-content">
           <div class="modal-header">
            <h4 class="modal-title" align="center">Comment</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body">
            <table id="getcomment">
                <tr>
                </tr>
              </table>
              <form method="post" id="repaly_comment" enctype="multipart/form-data">
                {{csrf_field()}}
                    <div class="form-group" >
                      <!-- <input type='hidden' class='form-control' name='post_id' id='edit_cat_id' >   -->
                      <input type="hidden"  name="comment_id" class="form-control" placeholder="Enter post name.."  id="comment_id" value="">
                      <input type="hidden"  name="user_id" class="form-control" placeholder="Enter post name.."  id="user_id" value="{{$get_user->user_id}}">


                      <label for="sel1"><b>Replay Description</b></label>
                      <input type="text"  name="replay_description" class="form-control" placeholder="Enter Replay Description.."  id="replay_description">
                    </div>
                    <div id="Sreplay_description" class="text-danger"></div>
                    <input type="submit" name="Comment" id="Comment" class="btn btn-info" value="Comment" />  
                     <!-- <div id="success" class=" alert-success"></div> -->

              </form>
           </div>
            <div id="comment_success" class="alert-success"></div>
            <div id="comment_error" class=" alert-danger"></div>

           <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div>
         </div>
        </div>
  </main>
  </div>

  

 <!-- Get Following data-->
 
<!--    <div id="layoutSidenav_content">
    <main>
        <div id="following_data" class="modal fade" role="dialog">
         <div class="modal-dialog">
          <div class="modal-content">
           <div class="modal-header">
            <h4 class="modal-title" align="center">Followings</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body">
            
              
           </div>
            <div id="comment_success" class="alert-success"></div>
            <div id="comment_error" class=" alert-danger"></div>

           <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div>
         </div>
        </div>
  </main>
  </div> -->

   <!-- Get Followers data-->
   <!-- <div id="layoutSidenav_content">
    <main>
        <div id="followers_data" class="modal fade" role="dialog">
         <div class="modal-dialog">
          <div class="modal-content">
           <div class="modal-header">
            <h4 class="modal-title" align="center">Followers</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
           </div>
           <div class="modal-body">
            <table id="get_followers">
                <tr>
                </tr>
              </table>
              
           </div>
            <div id="comment_success" class="alert-success"></div>
            <div id="comment_error" class=" alert-danger"></div>

           <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
          </div>
         </div>
        </div>
  </main>
  </div> -->
   <!-- <div class="w3-container w3-card w3-white w3-round w3-margin"><br>   -->
      <div id="feeddata"><br>
        
        <!-- <hr class="w3-clear">  -->
          <!-- <div class="w3-row-padding" style="margin:0 -16px" >
            <div class="w3-half">
            </div>
            <div class="w3-half">
          </div> -->
        </div>
        <div id="getuser_post" hidden>

           </div>
        <form id="add_comment" hidden>
          <input type="text" name="comment_description" class="form-control" placeholder="Enter Comment Description..">
          <input type="hidden" name="user_id" class="form-control" placeholder="Enter Comment Description..">

            <input type="submit" name="Comment" id="Comment" class="btn btn-info" value="Comment" />  
          </form>
        <!-- </div> -->
      </div>
        

    
    </div>
    <div id="form"></div>
      <form id="form1" hidden>
        <input type="text"  name="comment_description" class="form-control" placeholder="Enter Comment Description..">
        <button type="button" id="submit">Submit</button>
      </form>
    </div>
    

      </div>
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>

<script>

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
  /*x.innerHTML = "Latitude: " + position.coords.latitude + 
  "<br>Longitude: " + position.coords.longitude;*/
 // $("#myButton").after('<input type="text" id="textInput" value="">');
  x.innerHTML = "<input type='hidden' name='latitude' value= "+position.coords.latitude+" id='newInputBox'>";
  x1.innerHTML  = "<input type='hidden' name='longitude' value= "+position.coords.longitude+" id='newInputBox'>";

  // x.innerHTML =  position.coords.latitude ;
  // x1.innerHTML = position.coords.longitude;
}

</script>
 
<script>

	$(document).ready(function(){
  fetch_userprofile();
  get_post();
  getuser_feed();
  get_following_data();
  get_followers_data();
  // getcomment();
});

   // image update
   $('#edit_user_profile').on('change',function(ev){
    // console.log('image inside');

     var reader = new FileReader();
     reader.onload = function (ev) {
          $('#show_image').attr('src', ev.target.result);
      }
      reader.readAsDataURL(this.files[0]);
  // }
   });

  $('#add_post').click(function(){
    $("#add_post_data").toggle();
    // $('#update_profile').toggle('hide'); 
    $('#search').toggle(); 
    // $('#search').css('display','none'); 

    $('#search_data').toggle('hide'); 
    $('#update_profile').css('display','none'); 


    // $('#add_post_data')[0].reset();
  });

   $('#edit_profile').click(function(){
    $("#edit_data").toggle();
    $("#update_profile").toggle();
    $('#show_post_data').toggle(); 
    $('#search_data').toggle('hide'); 
    $('#feeddata').css('display','none'); 
    $('#getuser_post').css('display','none'); 
    // $("#getuser_post").toggle('hide');
    $('#my_profile').toggle(); 
    $('#my_photos').toggle(); 




    // $('#add_post_data')[0].reset();
  });
   $('#close').click(function(){
    $("#edit_data").toggle();
    $("#update_profile").toggle();
    $('#show_post_data').toggle(); 
    $('#search_data').toggle('hide'); 
    $('#feeddata').toggle(); 
    $('#my_profile').toggle(); 
    $('#my_photos').toggle(); 

    // $('#add_post_data')[0].reset();
  });

    $('#my_photos').click(function(){
    $("#getuser_post").toggle();
    $("#feeddata").toggle();
    
   
    // $('#add_post_data')[0].reset();
  });
   
   

  


// Fetch Data in index side in table formate
  function fetch_userprofile()
 {
  var user_id = "{{$get_user->user_id}}";
  // alert(user_id);
  $.ajax({
   url:"{{url('fetch_userprofile')}}",
   method:"GET",
   data:{user_id:user_id},
   success:function(data)
   {
     var json_obj = $.parseJSON(data);
          
     $('#profile_data').html(json_obj);

   }
  })
 }
/* $('.replay').click(function(){
    $('#comment_data')[0].reset();
  });*/


// Fetch Data in index side in table formate
  function get_post()
 {
  var user_id = "{{$get_user->user_id}}";
  // alert(user_id);
  $.ajax({
   url:"{{url('getuser_post')}}",
   method:"GET",
   data:{user_id:user_id},
   success:function(data)
   {
      var json_obj = $.parseJSON(data);
      $('#getuser_post').html(json_obj)
   }
  })
 }

  function getuser_feed()
 {
  var user_id = "{{$get_user->user_id}}";
  // alert(user_id);
  $.ajax({
   url:"{{url('getuser_feed')}}",
   method:"GET",
   data:{user_id:user_id},
   success:function(data)
   {
      var json_obj = $.parseJSON(data);
      $('#feeddata').html(json_obj);
   }
  })
 }


 function get_following_data()
 {
  var user_id = "{{$get_user->user_id}}";
  // alert(user_id);
  $.ajax({
   url:"{{url('get_following')}}",
   method:"GET",
   data:{user_id:user_id},
   success:function(data)
   {
     var json_obj = $.parseJSON(data);
          
     $('#get_following').html(json_obj);

   }
  })
 }

 function get_followers_data()
 {
  var user_id = "{{$get_user->user_id}}";
  // alert(user_id);
  $.ajax({
   url:"{{url('get_followers')}}",
   method:"GET",
   data:{user_id:user_id},
   success:function(data)
   {
     var json_obj = $.parseJSON(data);
          
     $('#get_followers').html(json_obj);

   }
  })
 }
 

// Like code
 $(document).on('click', '.like', function(){ 
   
       $(this).css('background-color','red');
       // $(this).text('You like');

        var user_id = "{{$get_user->user_id}}"; 
        var post_id = $(this).data('post_id'); ;
        // alert(post_id);
            $.ajax({  
              url :"{{url('user_like')}}",  
              type:"get",  
              data:{user_id:user_id,post_id:post_id},  
              success:function(data){  
                // location.reload();              
              getuser_feed();
                       
              },  
            });  
      }); 
 /* $(document).on('click', '.like', function(){
          $(this).toggleClass('pressed');
 
      }); */



 $(document).on('click', '.comment', function(){ 
        $("#add_comment").toggle();
        // $("#form1").css('display','block');
        var user_id = "{{$get_user->user_id}}"; 
        var post_id = $(this).data('post_id'); ;
        // alert(post_id);
            $.ajax({  
              url :"{{url('get_comment')}}",  
              type:"get",  
              data:{user_id:user_id,post_id:post_id},  
              success:function(data){  
                 var json_obj = $.parseJSON(data);
                  $('#getcomment').html(json_obj)
                       
              },  
            });  
      });

 // Replay Comment Code

   $(document).on('click', '.replay', function(){ 
       $('#comment_data').modal('hide'); 
      var comment_id = $(this).data('comment_id');
      // var user_id = $(this).data('user_id');         
      // alert(user_id);
      $('#repaly_comment').on('submit', function(event){
          event.preventDefault();
        var replay_description=$('#replay_description').val();
        var user_id = "{{$get_user->user_id}}";
       
        // alert(user_id);
        if (replay_description == "") { 
          $('#Sreplay_description').text("** Enter Comment Replay... ");
          return false;
        }
          var formdata = new FormData(this);
          formdata.append('comment_id',comment_id);
          formdata.append('user_id',user_id);


            $.ajax({  
              url:'{{ url("post_comment_replay") }}',
              method:"post",
              data:formdata,
              // data:{user_id:user_id,comment_description:comment_description,post_id:post_id},
              contentType:false,
              processData:false,
              success:function(data)
              {
                location.reload();
                $('#repaly_comment')[0].reset();
                 if (data==0) {
                    $('#comment_error').html(data).fadeIn('slow');
                  $('#comment_error').html("Somthing went wrong").fadeIn('slow') //also show a success message 
                  $('#comment_error').delay(2000).fadeOut('slow');
                        setTimeout(function () { 
                      $('#replay_modal').modal('hide'); 
                       }, 3000); 

                  }else{
                    $('#comment_success').html(data).fadeIn('slow');
                    $('#comment_success').html("Comment Succsessfully").fadeIn('slow') //also show a comment_success message 
                    $('#comment_success').delay(2000).fadeOut('slow');
                          setTimeout(function () { 
                        $('#replay_modal').modal('hide'); 
                         }, 3000); 
                    }
              }
            })
          
          
     });
  });  


 // Comment insert code
 $(document).on('click', '.comment', function(){ 
   var post_id = $(this).data('post_id');
    $('#add_comment').on('submit', function(event){
        event.preventDefault();
      var comment_description=$('#comment_description').val();
      var user_id = "{{$get_user->user_id}}";
     
      alert(user_id);
      if (comment_description == "") {
        $('#Scomment_description').text("** Enter Comment... ");
        return false;
      }
        var formdata = new FormData(this);
        formdata.append('post_id',post_id);
          $.ajax({
            url:'{{ url("post_comment") }}',
            method:"POST",
            data:formdata,
            // data:{user_id:user_id,comment_description:comment_description,post_id:post_id},
            contentType:false,
            processData:false,
            success:function(data)
            {
              // location.reload();
              $('#add_comment')[0].reset();
               if (data==0) {
                  $('#error').html(data).fadeIn('slow');
                $('#error').html("Somthing went wrong").fadeIn('slow') //also show a success message 
                $('#error').delay(2000).fadeOut('slow');
                      setTimeout(function () { 
                    $('#comment_data').modal('hide'); 
                     }, 3000); 

                }else{
                  $('#success').html(data).fadeIn('slow');
                  $('#success').html("Comment Succsessfully").fadeIn('slow') //also show a comment_success message 
                  $('#success').delay(2000).fadeOut('slow');
                        setTimeout(function () { 
                      $('#comment_data').modal('hide'); 
                       }, 3000); 
                  }
            }
          })   
   });
  });

$(document).on('click', '.following', function(){ 
      // $('#get_following').css('display','block');
        $("#get_following").toggle();
        $('#get_followers').hide();
      }); 

$(document).on('click', '.follow', function(){ 
      // $('#get_following').css('display','block');
        $("#get_followers").toggle();
        $('#get_following').hide();

      }); 

// followers code
$(document).on('click', '.followers', function(){ 
       $(this).text('Following'); 
        var user_id = "{{$get_user->user_id}}"; 
        var followings_id = $(this).data('user_id'); ;
        // alert(followings_id);
            $.ajax({  
              url :"{{url('following_user')}}",  
              type:"get",  
              data:{user_id:user_id,followings_id:followings_id},  
              success:function(data){  
                // alert(data);
                // location.reload();
              // getuser_feed();
              // $('#search_data').html(data);
                       
              },  
            });  
      }); 

 //Search data 
        $('#search').on("keyup",function(event){
          event.preventDefault();
          var user_id = "{{$get_user->user_id}}";
          var user_fullname=$(this).val();

          // alert(search_term);
          $.ajax({
            url:"{{url('search_user')}}",
            method:"GET",
            data:{user_id:user_id,user_fullname:user_fullname},
             // dataType: "json",
            success:function(data){
                // data = JSON.parse(data);
                // for (var crud of data) {
                       // console.log(data);
                //    }
                    /*fetch_userprofile();
                    get_post();
                    getuser_feed();*/
                     $('#search_data').html(data);
            }

          });

        });

// Add POST
$('#add_post_data').on('submit', function(event){
        event.preventDefault();
  		var content_name = $('#content_name').val();
      // alert(content_name);
  		if (content_name == "") {
       	$('#Scontent_name').text("** Please Select Post... ");
       	return false;
  		}

          $.ajax({
            url:'{{ url("adduser_post") }}',
            method:"POST",
            data:new FormData(this),
            // data:{latitude:latitude,longitude:longitude},
            contentType:false,
            processData:false,
            success:function(data)
            {
              // location.reload();
              $('#add_post_data')[0].reset();
               if (data==0) {
                  $('#errormessage').html(data).fadeIn('slow');
                $('#errormessage').html("Somthing went wrong").fadeIn('slow') //also show a success message 
                $('#errormessage').delay(2000).fadeOut('slow');
                      setTimeout(function () { 
                    $('#add_post_data').toggle('hide'); 
                     }, 3000);
                      setTimeout(function () { 
                     $('#search').toggle('show'); 
                     }, 3000); 

                }else{
                     
                $('#successmessage').html(data).fadeIn('slow');
                $('#successmessage').html("Post Succsessfully").fadeIn('slow') //also show a success message 
                $('#successmessage').delay(2000).fadeOut('slow');
                      setTimeout(function () { 
                    $('#add_post_data').toggle('hide'); 
                     }, 3000); 
                      setTimeout(function () { 
                        $('#search').toggle('show'); 
                     }, 3000); 

                }
            }
          })
        
        
   });

// Edit Profile
  $(document).on('click', '#edit_profile', function(){ 
        var user_id = "{{$get_user->user_id}}"; 
        // alert(user_id);
            $.ajax({  
              url :"{{url('edit_profile')}}",  
              type:"GET",  
              data:{user_id:user_id},  
              success:function(data){  
                var json_obj = $.parseJSON(data);
                $('#user_id').val(json_obj.user_id);
                $('#edit_user_fullname').val(json_obj.user_fullname);
                $('#edit_user_email').val(json_obj.user_email);
                $('#edit_user_mobile_no').val(json_obj.user_mobile_no);
                $('#edit_user_password').val(json_obj.user_password);               
                $("#show_image").attr("src", json_obj.user_profile);
                
                       
              },  
            });  
      }); 
  
    //Update  Profile data
    $('#update_profile').submit(function(e){
        e.preventDefault();
        var user_fullname = $('#edit_user_fullname').val();
        var user_mobile_no = $('#edit_user_mobile_no').val();
        if (user_fullname == "") {
          $('#Suser_fullname').text("** Please Enter User Name... ");
          return false;
        } 
        if (user_mobile_no == "") {
          $('#Suser_mobile_no').text("** Please Enter Mobile No... ");
          return false;
        } 

         $.ajax({
         url:"{{url('update_profile')}}",
         method:"POST",
         // type:"PUT",
         data:new FormData(this),
         contentType:false,
         processData:false,
            // success:function(data){ 
             
              success:function(data){
                 // location.reload();
                 fetch_userprofile();
                 $('#update_profile')[0].reset();

                  $('#success').html(data).fadeIn('slow');
                $('#success').html("Profile Updated <strong>Successfully!</strong>").fadeIn('slow') //also show a success message 
                $('#success').delay(2000).fadeOut('slow');
                   setTimeout(function () { 
                    $('#update_profile').toggle(); 
                     }, 2000); 
                      $('#edit_data').toggle(); 
                      $('#show_post_data').toggle(); 
                        $('#feeddata').toggle(); 
                        $('#my_profile').toggle(); 
                        $('#my_photos').toggle(); 
                         
            }  
    
          }); 
          
        // }
      // }
      });





// Accordion
function myFunction(id) {
  var x = document.getElementById(id);
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-theme-d1";
  } else { 
    x.className = x.className.replace("w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-theme-d1", "");
  }
}

  /*function myFunction() {
     var x = document.getElementById("myInput");
     document.getElementById("demo").innerHTML = "You are searching for: " + x.value;
  }
*/

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
  var x = document.getElementById("navDemo");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else { 
    x.className = x.className.replace(" w3-show", "");
  }
}
</script>

<!-- <script src="https://maps.google.com/maps/api/js?key=AIzaSyB4cPjyledQggFtA3aqCY6Zshh6ycAquNQ&libraries=places&callback=initAutocomplete" type="text/javascript"></script> -->

   <!-- <script>
       $(document).ready(function() {
           /* $("#lat_area").addClass("d-none");
            $("#long_area").addClass("d-none");*/
       });
   </script>

   <script>
       google.maps.event.addDomListener(window, 'load', initialize);

       function initialize() {
          /* var options = {
             componentRestrictions: {country: "IN"}
           };*/

           var input = document.getElementById('location');
           var autocomplete = new google.maps.places.Autocomplete(input);
           autocomplete.addListener('place_changed', function() {
               var place = autocomplete.getPlace();
               $('#latitude').val(place.geometry['location'].lat());
               $('#longitude').val(place.geometry['location'].lng());

            // --------- show lat and long ---------------
              /* $("#lat_area").removeClass("d-none");
               $("#long_area").removeClass("d-none");*/
           });
       }
    </script> -->

<!--     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
</body>
</html> 
