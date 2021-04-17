@extends('header')



@section('content')

  @foreach($userpost_content as $post)
    <div class="col-md-8 col-md-offset-2">
      <div class="w3-container w3-card w3-white w3-round w3-margin "><br>
        <img src="{{asset('public/storage/addpost/'.$post->content_name)}}" class="" width="100%" height="300px" style='text-align:center;cursor:pointer;object-fit:contain;' name="" id=''/>&nbsp;&nbsp;
        <p>{{$user_post->post_name}}</p>
        <p>{{$user_post->post_description}}</p>

      </div>
    </div>
  @endforeach

<div class="container">
<div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Comment</div>

                <div class="panel-body">
                    <form id="comment-form" method="post" action="" >
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{$user_id}}" >
                        <div class="row" style="padding: 10px;">
                            <div class="form-group">
                                <input type="text"  name="comment_description" class="form-control" placeholder="Enter Comment Description.."  id="comment_description">
                                <!--  <textarea class="form-control" name="comment_description" placeholder="Write something from your heart..!"></textarea> -->
                            </div>
                            <div id="Scomment_description" class="text-danger"></div>
                           
                        </div>
                        <div class="row" style="padding: 0 10px 0 10px;">
                            <div class="form-group">
                                <input type="submit" class="w3-button w3-theme" style="width: 100%" name="submit">
                            </div>
                        </div>
                    </form>
                     <div id="success" class="alert-success"></div>
                     <div id="error" class=" alert-danger"></div>
                       
                </div>  
            </div>
        </div>
    </div>
  </div>
<div class="container">
    <div class="row">
         <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
              <div class="panel-heading">Comments</div>

                <div class="panel-body comment-container" >
                    
                    @foreach($comments as $comment)
                        <div class="well">
                            @foreach($get_user as $user)
                               @if($comment->user_id == $user->user_id)
                              <img src="{{asset('public/storage/upload/'.$user->user_profile)}}" class="" width="45px" height="45px" style='text-align:center;cursor:pointer;border-radius: 50%;' name="user_profile" id='show_image'/>&nbsp;&nbsp;{{$user->user_fullname}}<br>
                              @endif
                            @endforeach

                            <b id="" style="margin-left:50px;"> {{ $comment->comment_description }} </b>&nbsp;&nbsp;
                            <div style="margin-left:70px;">
                                <a style="cursor: pointer;" user_id = "{{$user_id}}" comment_id="{{ $comment->comment_id }}" name_a="" token="{{ csrf_token() }}" class="reply">Reply</a>
                               
                                <div class="reply-form"><br>
                                  <!-- <div class="well"> -->
                                   @foreach($comment_replay as $replay)
                                   @if($comment->comment_id == $replay->comment_id)

                                    @foreach($get_user as $user)
                                      @if($replay->user_id == $user->user_id)
                                        <img src="{{asset('public/storage/upload/'.$user->user_profile)}}" class="" width="44px" height="45px" style='text-align:center;cursor:pointer;border-radius: 50%;' name="user_profile" id='show_image'/>&nbsp;&nbsp;{{$user->user_fullname}}<br>
                                      @endif
                                    @endforeach                                
                                      <div> <b style="margin-left:50px;">{{ $replay->replay_description }}</b> </div>
                                            
                                    
                                        @endif 
                                    @endforeach
                                  <!-- </div> -->
                                </div>
                               
                                
                            </div>
                        </div>
                    @endforeach
                    <!-- <a href=""><div id="showmore">show more</div></a> -->
                </div>
            </div>
        </div>
    </div>  
</div>
<!-- </div> -->
@endsection

@section('script')
<script type="text/javascript">
  

   /*$(document).on('click', '#showmore', function(){ 
    event.preventDefault();
    var post_id = "{{$post_id}}";
    // alert(post_id);
        $.ajax({
            url:"{{url('showmore_comment')}}",
            method:"GET",
            dataType: 'json',
            // data:{post_id:post_id},
            success:function(data){
                var len=data.length
                // alert(len);
                console.log(len);
                    //Perform ANy action after successfuly post data
                      var rows = '';
                for(i=0;i<data.length;i++){
                      rows = rows + 'data[i].url'
                }      
                 $("#reply-form").html(rows);  
             }   

        })
    });*/


$('#comment-form').on('submit', function(event){
        event.preventDefault();
      var comment_description=$('#comment_description').val();
      var user_id = "{{$user_id}}";
      var post_id = "{{$post_id}}";

     
      // alert(post_id);
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
              location.reload();
              $('#comment-form')[0].reset();
               if (data==0) {
                  $('#error').html(data).fadeIn('slow');
                $('#error').html("Somthing went wrong").fadeIn('slow') //also show a success message 
                $('#error').delay(2000).fadeOut('slow');
                      setTimeout(function () { 
                    $('#comment_data').modal('hide'); 
                     }, 3000); 

                }else{
                  $('#success').html(data).fadeIn('slow');
                  $('#success').html("Comment Replay Succsessfully").fadeIn('slow') //also show a comment_success message 
                  $('#success').delay(2000).fadeOut('slow');
                        setTimeout(function () { 
                      $('#comment_data').modal('hide'); 
                       }, 3000); 
                  }
            }
          })   
   });




$(document).ready(function(){
        

        $(".comment-container").delegate(".reply","click",function(){

            var well = $(this).parent().parent();
            var comment_id = $(this).attr("comment_id");
            var user_id = $(this).attr('user_id');
            // alert(comment_id);
            var token = $(this).attr('token');
            var form = '<form method="post" id="reply" action=""><input type="hidden" name="_token" value="'+token+'"><input type="text"   name="replay_description" class="form-control" placeholder="Enter Replay Description.."  id="replay_description"> </div><br>  <div id="Sreplay_description" class="text-danger"></div> <div class="form-group"> <input class="w3-button w3-theme" type="submit"> </div></form><div id="replay_success" class="alert-success"></div><div id="replay_error" class=" alert-danger"></div> ';

            well.find(".reply-form").html(form);


    $('#reply').on('submit', function(event){
        event.preventDefault();
      var replay_description=$('#replay_description').val();
      // var user_id = "{{$user_id}}";
         
      // var post_id = "{{$post_id}}";

     
      // alert(replay_description);
      if (replay_description == "") {
        $('#Sreplay_description').text("** Enter Comment Replay... ");
        return false;
      }
        var formdata = new FormData(this);
        formdata.append('comment_id',comment_id);
        formdata.append('user_id',user_id);

          $.ajax({
            url:'{{ url("post_comment_replay") }}',
            method:"POST",
            data:formdata,
            // data:{user_id:user_id,comment_description:comment_description,post_id:post_id},
            contentType:false,
            processData:false,
            success:function(data)
            {
              location.reload();
              $('#reply')[0].reset();
               if (data==0) {
                  $('#replay_error').html(data).fadeIn('slow');
                $('#replay_error').html("Somthing went wrong").fadeIn('slow') //also show a success message 
                $('#replay_error').delay(2000).fadeOut('slow');
                      setTimeout(function () { 
                    $('#comment_data').modal('hide'); 
                     }, 3000); 

                }else{
                  $('#replay_success').html(data).fadeIn('slow');
                  $('#replay_success').html("Comment Succsessfully").fadeIn('slow') //also show a comment_replay_success message 
                  $('#replay_success').delay(2000).fadeOut('slow');
                        setTimeout(function () { 
                      $('#comment_data').modal('hide'); 
                       }, 3000); 
                  }
            }
          })   
   });


        });






        $(".comment-container").delegate(".delete-comment","click",function(){

            var cdid = $(this).attr("comment-did");
            var token = $(this).attr("token");
            var well = $(this).parent().parent();
            $.ajax({
                    url : "/comments/"+cdid,
                    method : "POST",
                    data : {_method : "delete", _token: token},
                    success:function(response){
                    if (response == 1 || response == 2) {
                        well.hide();
                    }else{
                        alert('Oh ! you can delete only your comment');
                        console.log(response);
                    }
                }
            });

        });

        $(".comment-container").delegate(".reply-to-reply","click",function(){
            var well = $(this).parent().parent();
            var cid = $(this).attr("rid");
            var rname = $(this).attr("rname");
            var token = $(this).attr("token")
            var form = '<form method="post" action="/replies"><input type="hidden" name="_token" value="'+token+'"><input type="hidden" name="comment_id" value="'+ cid +'"><input type="hidden" name="name" value="'+rname+'"><div class="form-group"><textarea class="form-control" name="reply" placeholder="Enter your reply" > </textarea> </div> <div class="form-group"> <input class="btn btn-primary" type="submit"> </div></form>';

            well.find(".reply-to-reply-form").append(form);

        });

        $(".comment-container").delegate(".delete-reply", "click", function(){

            var well = $(this).parent().parent();

            if (confirm("Are you sure you want to delete this..!")) {
                var did = $(this).attr("did");
                    var token = $(this).attr("token");
                    $.ajax({
                        url : "/replies/"+did,
                        method : "POST",
                        data : {_method : "delete", _token: token},
                        success:function(response){
                            if (response == 1) {
                                well.hide();
                                //alert("Your reply is deleted");
                            }else if(response == 2){
                                alert('Oh! You can not delete other people comment');
                            }else{
                                alert('Something wrong in project setup');
                            }
                        }
                    })
            }

            

        });

    }); 

</script>

@endsection