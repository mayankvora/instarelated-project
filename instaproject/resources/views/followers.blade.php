
@extends('header')

@section('content')
<style type="text/css">
  /*#get_following{
      position:fixed; ;
      overflow-x: hidden;
    
  }
  #get_followers{

      position: fixed;
      overflow-x: hidden;
    
  }
*/
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  

<div class="w3-row-padding w3-margin">
        <div class="w3-col m12">
          <div class="w3-card w3-round w3-white">
            <div class="w3-container w3-padding">
              <input type="hidden" name="user_id" value="{{$user_id}}">
              <button align="right" style="" type="button" class="w3-button w3-theme follow">Followers</button> &nbsp; 
              <!-- <button type="button"  value="{{$user_id}}" class="w3-button w3-theme following">Followings</button> -->
              

              <!-- <table id=""> -->
                  <div id="get_following"></div>
                   <div id="get_followers"></div>
              <!-- </table> -->
             <!--  <table align="right" style="margin-top:-1100px;">
               
              </table> -->
              
            </div>
          </div>
        </div>
<!-- </div> -->

@endsection


@section('script')
<script type="text/javascript">
$(document).ready(function(){
    // get_following_data();
    get_followers_data();
});

  $(document).on('click', '.following', function(){ 
       document.getElementById("get_following").style.width = "250px";
      document.getElementById("get_followers").style.width = "0";

    var user_id = "{{$user_id}}";
    // alert(user_id);
    $.ajax({
     url:"{{url('get_following')}}",
     method:"GET",
     data:{user_id:user_id},
     success:function(data)
     {
       var json_obj = $.parseJSON(data);
            
       $('#get_following').html(json_obj);
       // $('#get_following').appand("<tr><td>"+data.user_fullname+"</td></tr>");

     }
    })
  }); 

  $(document).on('click', '.follow', function(){ 
    document.getElementById("get_following").style.width = "0";

     document.getElementById("get_followers").style.width = "250px";
   })

  function get_followers_data()
 {
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
  }


</script>


@endsection