@extends('header')



@section('content')

<style type="text/css">
	/*.w3-container{
		background-color: black;
	}*/
	#profile{
		/*text-align: center;*/

	}
  .profile_data{
    display: inline;  
   /*margin-left:100px;*/
  }
  .profile_data1{
    display: inline;  
    margin-left: 100px;
  }
	img{
		/*background-color:	;*/
	}
	#edit_profile{
		float:right;
		margin-top: -91px;

	}
  .profile_div{
    margin-left:250px;
    margin-top:28px;
  }
  h4{
    position: absolute;
    margin-top: 105px;
    margin-left: 25px;
    font-size: 18px;
  }
  .profile_css{
    display: inline;
    text-align:center;
    margin-right:50px;
  }
  .profile_css1{
    display: inline; text-align:center;
  }
  .profile_css2{
    display: inline; text-align:center;margin-right:115px;
  }.profile_css3{
    display: inline; text-align:center;margin-left:50px;
  }

	@media only screen and (max-width: 780px) {
		#edit_profile{
			margin-top:10px;
			width: 100%;

		/*float: left;*/
		/*margin-bottom: -90px;*/
		}
    .profile_data1{
    /*margin-left:px;*/
  }
  .w3-circle{
    width:70px;
    height:70px;
    margin-left:-20px;

  }
  
  .profile_css{
    display: inline;
    text-align:center;
    margin-right:12px;
  }
  .profile_css1{
    display: inline;
     text-align:center;
  }
  .profile_css2{
    display: inline;
     text-align:center;
     margin-right:75px;

  }.profile_css3{
    display: inline;
     text-align:center;
     /*margin-left:;*/

  }
  .profile_div{
    margin-left:80px;
    margin-top:10px;
  } 
  #image_css{
    width:98px;
    height:98px;
  }
   h4{
    position: absolute;
    margin-top: 75px;
    margin-left: -10px;
    font-size: 18px;
  }
}

</style>
<!-- <div class="w3-container w3-content" style="max-width:1400px;margin-top:80px">     -->

<!-- <div class="w3-col m12">
      <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding w3-margin">
            	<input type="hidden" name="user_fullname" value=""> -->
            	<table >
                <div id="profile"></div><br>
            		
            		<!-- <tbody id="profile_email"></tbody>
                <p class="w3-center">
            		<img id="user_profile" src="" class="w3-circle w3-center" style="height:106px;width:106px;" alt=""></p> -->
                <!-- <h3 id="profile"></h3> -->

            		<!-- <h4 class="w3-half"> Followings</h4> <h4>followers</h4>
            		
            		<p class="w3-half" id="followings"></p>  <p id="followers"></p> -->
            		

            	</table>

            	 <button type="button" name="edit_profile" id="edit_profile" class="w3-button w3-theme" data-toggle="modal" data-target="#edit_profile_user"><i class="fa fa-pencil" ></i> Edit Profile</button>

            	  <!-- <h4 style="text-align: center;" id="data" hidden>Edit Profile </h4>                -->
                  <!-- <button type="button" hidden id="close" class="close" data-dismiss="modal">&times;</button>  -->


       <h3 style="text-align: center;" id="data" hidden>Edit Profile <button  type="button" id="close"  class="close" data-dismiss="modal">&times;</button></h3>
                  
 				<form method="post" style="padding:10px;" id="update_profile" enctype="multipart/form-data" hidden>
 					
           <h4 hidden style="margin-bottom: -15px;" type="button" id="close"  class="close" data-dismiss="modal">&times;</h4><br>
                {{csrf_field()}}
                    <div class="form-group" >
                      <input type="hidden"  name="user_id" class="form-control" placeholder="Enter post name.."  id="user_id" value="">

                      <label for="sel1"><b>User Name</b></label>
                      <input type="text"  name="user_fullname" class="form-control" placeholder="Enter post name.."  id="edit_user_fullname">
                    </div>
                    <div id="Suser_fullname" class="text-danger"></div>

                    <label for="sel1"><b> Email</b></label>
                    <div class="form-group">
                      <input type="text" name="user_email" id="edit_user_email" placeholder="Enter post description" class="form-control name_list" readonly/> 
                      
                    </div>
                    
                    <div id="Spackage_desc" class="text-danger"></div>

                    <label for="sel1"><b> Mobile No.</b></label>
                    <div class="form-group">
                      <input type="text" name="user_mobile_no" id="edit_user_mobile_no" placeholder="Enter post description" class="form-control name_list" /> 
                      
                    </div>
                  
                    <div id="Suser_mobile_no" class="text-danger"></div>
                    
                    <label for="sel1"><b>Password</b></label>
                    <div class="form-group">
                      <input type="text" name="user_password" id="edit_user_password" placeholder="Enter post description" class="form-control name_list" /> 
                      
                    </div>
                  
                    <div id="Spackage_desc" class="text-danger"></div>

                    <div class='form-group'>
                    <label for="sel1"><b>Edit Profile</b></label><br> 
                      <td><img src="" class="" width="100px" height="100px" style='text-align:center;cursor:pointer;border-radius: 50%;' name="user_profile" id='show_image'/></td>
                      </div>

                     <!--  <input type="file" id="imgupload" style="display:none"/> 
                      <button id="OpenImgUpload">Image Upload</button> -->

                    <div class="form-group" > 
                      <!-- <label for="sel1"><b>Edit Profile</b></label> -->
                      <input type="file" name="user_profile" id="edit_user_profile" style="display:none"//>
                    </div>

                    <div id="Spackage_image" class="text-danger"></div>
                  
                    
                     
                    <input type="submit" name="update" id="update" class="w3-button w3-theme" value="update" />  



              </form>
              <div id="success" class="alert-success"></div>
              <div id="error" class=" alert-danger"></div>
            
              </div>


<!-- 	
              <button type="button" id="add_post"  class="w3-button w3-theme"><i class="fa fa-pencil"></i>  Post</button> -->

      <!--     </div>
      </div>
  </div> -->
</div>
<hr>
 <!-- <table id="getuser_post"> -->
  <!-- <div class="w3-col m12" >
    <div class="w3-row-padding">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white"> -->
            <div class="w3-container w3-padding w3-margin"  id="getuser_post">
               <!--  <button type="button" class="w3-button w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i>  Like</button> 
              <button type="button" class="w3-button w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i>  Comment</button>  -->
            </div>
            
       <!--    </div>
        </div>
      </div>
    </div>
  </div> -->



<!-- 
  <tr>
    <td><img id="user_post" src="" class="w3-circle" style="height:106px;width:106px;object-fit:contain;border:1px solid black" alt=""><br><br>
    </td>
  </tr> -->
    

 <!-- </table> -->

@endsection

@section('script')

<script type="text/javascript">
$(document).ready(function(){
    get_profile();
    get_post();
});

  $('#show_image').click(function(){
    $('#edit_user_profile').trigger('click');
  });


   $('#edit_profile').click(function(){
    $("#edit_data").toggle();
    $("#update_profile").toggle();
    $('#edit_profile').toggle(); 
    $('#profile').toggle(); 
    $('#user_profile').toggle(); 
    // $('#getuser_post').css('display','none'); 
    $('#data').toggle(); 

  });

   $('#close').click(function(){
    $("#update_profile").toggle();
    $("#edit_profile").toggle('hide');
    $("#edit_data").toggle();
    $('#profile').toggle(); 
    $('#user_profile').toggle(); 
    // $('#getuser_post').css('display','none'); 
    $('#data').toggle(); 
  });


  function get_profile() {
    var user_id = "{{$user_id}}";
    // alert(user_id);
    $.ajax({
     url:"{{url('fetch_userprofile')}}",
     method:"GET",
     data:{user_id:user_id},
     success:function(data)
     {
       var json_obj = $.parseJSON(data);
        $('#profile').html(json_obj);
       // var len = response.length;
       
       // $('#user_fullname').text(user_fullname);
       // $("#profile").append(data.user_fullname );
       // $("#followings").append(data.get_following_user );
       // $("#followers").append(data.get_followers_user );
       // $("#user_profile").attr("src", data.user_profile);

  }
  }); 
}


 function get_post()
 {
  var user_id = "{{$user_id}}";
  // alert(user_id);
  $.ajax({
   url:"{{url('getuser_post')}}",
   method:"GET",
   data:{user_id:user_id},
   success:function(response)
   {
     for(var index = 0; index < response.length; index++) {
         var src = response[index];
         // alert(src);

         // Add img element in <div id='preview'>
         $('#getuser_post').append('<a href ="{{url('image/'.$user_id)}}"><img id="image_css" src="'+src+'" style="padding:10px;" width="238px;" height="200px"></a>');

       }
       // var img = data.img;
       // alert(img);
     
   
       // $("#user_post").attr("src", data.data);
     
     /* var json_obj = $.parseJSON(data);
      $('#getuser_post').html(json_obj)*/
   }
  })
 }

    // image update
   $('#edit_user_profile').on('change',function(ev){
     var reader = new FileReader();
     reader.onload = function (ev) {
          $('#show_image').attr('src', ev.target.result);
      }
      reader.readAsDataURL(this.files[0]);
   });

   // Edit Profile
  $(document).on('click', '#edit_profile', function(){ 
        var user_id = "{{$user_id}}"; 
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
            success:function(data){
              location.reload();
              $('#update_profile')[0].reset();
              $('#success').html(data).fadeIn('slow');
              $('#success').html("Profile Updated <strong>Successfully!</strong>").fadeIn('slow') //also show a success message 
              $('#success').delay(2000).fadeOut('slow');
                 setTimeout(function () { 
                  // $('#update_profile').toggle(); 
                   }, 2000); 
                    // $('#edit_data').toggle(); 
                    // $('#show_post_data').toggle(); 
                    //   $('#feeddata').toggle(); 
                    //   $('#my_profile').toggle(); 
                    //   $('#my_photos').toggle();             
          }  
    
          }); 
      });



</script>

@endsection
