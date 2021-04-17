@extends('header')



@section('content')

<style type="text/css">
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
    <div  id="getuser_post">
    
    </div>
    

@endsection

@section('script')

<script type="text/javascript">
  $(document).ready(function(){
    get_post();
    // get_post();
});

 function get_post()
 {
  var user_id = "{{$user_id}}";
  // alert(user_id);
  $.ajax({
   url:"{{url('get_post')}}",
   method:"GET",
   data:{user_id:user_id},
   success:function(data)
   {
      var json_obj = $.parseJSON(data);
      $('#getuser_post').html(json_obj)
   }
  })
 }

 // Like code
  $(document).on('click', '.like', function(){

        if ($(this).hasClass("active")) {
          $(this).removeClass("active");
        }else {
          $(".active").removeClass("active");
          $(this).addClass('active');
        }
        // $(this).toggleClass('active'); 
        var user_id = "{{$user_id}}"; 
        var post_id = $(this).data('post_id');
        $.ajax({  
          url :"{{url('user_like')}}",  
          type:"get",  
          data:{user_id:user_id,post_id:post_id},  
          success:function(data){  
            // location.reload();  
              // $('.like').css('background','blue');          
          get_post();
                     
          },  
        });  
  });


 </script>
@endsection
