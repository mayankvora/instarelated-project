
@extends('header')



@section('content')

<style type="text/css">
 /*.like {
      background-color: blue;
      height: 35px;
      width: 120px;
      }*/

     /* .like.pressed {
          background-color: red;
      }*/
     /* .active{
         background:red;
    }*/
 /*.like:active{
     background:red;
 }*/
 .like.active {
  background-color: #4d636f;
  color: white;
}

.like {
  margin: 10px;
  display: inline-block;
  padding: 8px 16px;
  width: 120px;
  height: 40px;
  color: #8c8c8c;
  font-weight: 700;
  background-color: #f4efeb;
  border: none;
  letter-spacing: 2px;
  outline: none;
}

/*.comment.active {
  background-color: #bf9471;
  color: white;
}*/

.comment {
  display: inline-block;
  /*padding: 8px 16px;*/
  width: 140px;
  height: 40px;
  color: white;
  font-weight: 700;
  background-color: #4d636f;
  border: none;
  letter-spacing: 2px;
  outline: none;
}
  @media only screen and (max-width: 780px) {
    .like{
      margin-left: -10px;
    }
  }

</style>
<body class="w3-theme-l5">

<!-- Page Container -->
<!-- <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">     -->
  <!-- The Grid -->
  <div class="w3-row">
    <!-- Left Column -->
    <div class="w3-col m3">
      <!-- Profile -->
      <div class="w3-card w3-round w3-white">
        <div class="w3-container">
         <h4 class="w3-center">My Profile</h4>
         <p class="w3-center">
         	<a href="https://placeholder.com/"> 
            @if($get_user->user_profile)
            <a href="{{url('profile/'.$get_user->user_id)}}"><img src="{{asset('public/storage/upload/'.$get_user->user_profile)}}" class="w3-circle" style="height:106px;width:106px" alt=""></p></a>
            @else
            <a href="{{url('profile/'.$get_user->user_id)}}"><img src="https://www.w3schools.com//w3images/avatar3.png" class="w3-circle" style="height:106px;width:106px" alt=""></p></a>
            <!-- @endelse -->
            @endif

         <hr>
         <h4 class="w3-center">{{$get_user->user_fullname}}</h4>
       
          <div class="w3-row w3-center">
            <div class="w3-col m12">
              <a href="{{url('following/'.$get_user->user_id)}}"><button type="button" class="w3-button w3-theme-d1 w3-margin-bottom" style="width: 100%">Following  {{$get_following_user}}</button></a>
            </div>
          </div>
          <div class="w3-row w3-center">
            <div class="w3-col m12">
              <a href="{{url('followers/'.$get_user->user_id)}}"><button type="button" class="w3-button w3-theme-d1 w3-margin-bottom " style="width: 100%">Followers  {{$get_followers_user}}</button> </a>
            </div>
          </div>
        
         
        </div>
      </div>
      <br>
  </div>

    <div class="w3-col m9"> 
    
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <button type="button" id="add_post"  class="w3-button w3-theme"><i class="fa fa-pencil"></i>  Post</button>

               <form method="post" style="padding:10px;" id="add_post_data" enctype="multipart/form-data" hidden>

                <h4 style="text-align: center;" id="data">Add post <button  type="button" id="close"  class="close" data-dismiss="modal">&times;</button></h4>

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
                       <!-- <button onclick="getLocation()" name="">Current Location</button> -->
                        <p id="latitude" name="latitude"></p>
                        <p id="longitude" name="longitude"></p>

                        <!-- <input type="hidden" id="latitude" value="">
                        <input type="hidden" id="longitude" value=""> -->
  
                    </div>
                    <div class="form-group" > 
                      <label for="sel1"><b>Select Post</b></label><br>
                      <!-- <img src="https://www.w3schools.com//w3images/avatar3.png"  class="w3-circle" style="height:106px;width:106px" alt="" id="show_image"></p></a> -->
                      <input type="file" onclick="getLocation()" name="content_name[]" id="content_name" multiple />
                    </div> 

                    <div id="Scontent_name" class="text-danger"></div>
                    <!-- <input type="hidden" onclick="getLocation()" name="insert"  id="insert" class="w3-button w3-theme" value="insert" />  --> 
                    
                    <input type="submit" name="insert"  id="insert" class="w3-button w3-theme" value="submit" />  
              </form>
              <div id="successmessage" class="alert-success"></div>
              <div id="errormessage" class=" alert-danger"></div>
            </div>

              <form class="" id="" action="" align="" style="padding:15px;">
              <div class="form-group" > 
                      <input type="text" placeholder="Search.." name="search" id="search" class="form-control name_list" /> 
              </div>
              <table id="search_data" style="padding:15px"></table>
            </form><br>
            <!-- </div> -->
          </div>
        </div>
      </div>


      
      <div id="feeddata"><br>
        <div id="get_profile"></div>
        <!-- <img src="" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
        <hr class="w3-clear"> -->
       
        <!-- <button type="button" class="w3-button w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i>  Like</button> 
        <button type="button" class="w3-button w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i>  Comment</button>  -->
      </div>
      
    
    <!-- End Middle Column -->
    </div>
    
      
    </div>
    
  <!-- End Grid -->
  </div>
  
<!-- End Page Container -->
</div>
<br>


 
 @endsection

@section('script')

<script>

   $('#show_image').click(function(){
    $('#content_name').trigger('click');
  });

  $('#content_name').on('change',function(ev){
   var reader = new FileReader();
   reader.onload = function (ev) {
        $('#show_image').attr('src', ev.target.result);
    }
    reader.readAsDataURL(this.files[0]);
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



$(document).ready(function(){
    getuser_feed();
    // get_post();
});

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
      /*for(var index = 0; index < response.length; index++) {
         var src = response[index];
         // alert(src);

         $('#feeddata').append('<div class="w3-container w3-card w3-white w3-round w3-margin"><img src="'+src+'" style="padding:10px;" width="100%;" height="300px"><button type="button" class="w3-button w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i>  Like</button> <button type="button" class="w3-button w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i>  Comment</button></div>');


          // $('#get_profile').append('<div class="w3-container w3-card w3-white w3-round w3-margin"><img src="'+src+'" style="padding:10px;" width="100%;" height="300px">');
         
       }*/
   }
  })
 }


  $('#add_post').click(function(){
    $("#add_post").toggle();
    $("#add_post_data").toggle();
    // $('#update_profile').toggle('hide'); 
    $('#search').toggle(); 
    // $('#search').css('display','none'); 
    $('#search_data').toggle('hide'); 
    $('#update_profile').css('display','none'); 
    $('#add_post_data')[0].reset();
    // $('#Scontent_name').reset();

    // $('#Scontent_name').toggle('show');


  });
  $('#close').click(function(){
    $("#add_post").toggle();
    $("#add_post_data").toggle();
    $('#search').toggle(); 
    location.reload();
  });
  

  // Like code
  $(document).on('click', '.like', function(){

        if ($(this).hasClass("active")) {
          $(this).removeClass("active");
        }else {
          $(".active").removeClass("active");
          $(this).addClass('active');
        }
        // $(this).toggleClass('active'); 
        var user_id = "{{$get_user->user_id}}"; 
        var post_id = $(this).data('post_id');
        $.ajax({  
          url :"{{url('user_like')}}",  
          type:"get",  
          data:{user_id:user_id,post_id:post_id},  
          success:function(data){  
            // location.reload();  
              // $('.like').css('background','blue');          
          getuser_feed();
                     
          },  
        });  
  });


   /* $(document).on('click', '.like', function(){
        // $(this).toggleClass('active'); 
        var user_id = "{{$get_user->user_id}}"; 
        var post_id = $(this).data('post_id');
        $.ajax({  
          url :"{{url('user_dislike')}}",  
          type:"get",  
          data:{user_id:user_id,post_id:post_id},  
          success:function(data){  
            // location.reload();  
              // $('.like').css('background','blue');          
          // getuser_feed();
                     
          },  
        });  
  });*/
  


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

        
// Add POST
$('#add_post_data').on('submit', function(event){
      // getLocation();
        event.preventDefault();
      var content_name = $('#content_name').val();
      // alert(content_name);
      if (content_name == "") {
        $('#Scontent_name').text("** Please Select Post... ");
        return false;
      }

            // function getLocation() {
            //   if (navigator.geolocation) {
            //     navigator.geolocation.getCurrentPosition(showPosition);
            //   } 
            // }

            //  function showPosition(position) {
            //   latitude = position.coords.latitude;
            //   longitude = position.coords.longitude;
            // }
      
            // alert(latitude);
            var formdata = new FormData(this);
           /* formdata.append('latitude',latitude);
            formdata.append('longitude',longitude);*/

          $.ajax({
            url:'{{ url("adduser_post") }}',
            method:"POST",
            data:formdata,
            // data:{latitude:latitude,longitude:longitude},
            contentType:false,
            processData:false,
            success:function(data)
            {
              location.reload();
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

   /*$(document).on('click', '.following', function(){ 
        var user_id = "{{$get_user->user_id}}";
      alert(user_id);

  }); */
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

 @endsection

