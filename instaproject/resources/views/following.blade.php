
@extends('header')



@section('content')
<style type="text/css">
  
  /*#get_following{
      position:fixed; 
      overflow-x: hidden;
    
  }
  #get_followers{
      position: fixed;
      overflow-x: hidden;
    
  }*/

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

<div class="w3-row-padding w3-margin">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <button type="button"  value="{{$user_id}}" class="w3-button w3-theme following">Followings</button>&nbsp; 
              <!-- <button align="right" style="" type="button" class="w3-button w3-theme follow">Followers</button>  -->

              <!-- <table id=""> -->
                  <div id="get_following"></div>
                   <div id="get_followers"></div>
              <!-- </table> -->
             <!--  <table align="right" style="margin-top:-1100px;">
               
              </table> -->
              
            </div>
          </div>
        </div>
</div>

@endsection


@section('script')
<script type="text/javascript">
$(document).ready(function(){
    get_following_data();
});

 


  // document.getElementById("").style.width = "0";

 // $(document).on('click', '.following', function(){ 
     document.getElementById("get_following").style.width = "250px";
    document.getElementById("get_followers").style.width = "0";

 function get_following_data() {
  // $('#get_followers').toggle('hide');
  var user_id = "{{$user_id}}";
  // alert(user_id);
  $.ajax({
   url:"{{url('get_following')}}",
   method:"GET",
   data:{user_id:user_id},
   success:function(data)
   {
     var json_obj = $.parseJSON(data);
      // $('#get_following').append(data) 
   
      $('#get_following').html(json_obj);
     // $('#get_following').appand("<tr><td>"+data.user_fullname+"</td></tr>");

   }
  // })
}); 
}
  $(document).on('click', '.following', function(){ 
     document.getElementById("get_following").style.width = "250px";
    document.getElementById("get_followers").style.width = "0";
  })

  $(document).on('click', '.follow', function(){ 
    document.getElementById("get_following").style.width = "0";

     document.getElementById("get_followers").style.width = "250px";

      // $("#get_followers").toggle();
        // $('#get_following').toggle('hide');
  /*function get_following_data()
 {*/
  var user_id = "{{$user_id}}";
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
}); 

 /* $(document).on('click', '.unfollow', function(){ 
   
    var following_id = $(this).data('following_id');
    // alert(following_id);
    if (confirm("Are you sore unfollow this user")) {
    $.ajax({
     url:"{{url('user_unfollow')}}",
     method:"GET",
     data:{following_id:following_id},
     success:function(data)
     {  
        get_following_data();
     }
    })
  }
}); */
  


</script>


@endsection