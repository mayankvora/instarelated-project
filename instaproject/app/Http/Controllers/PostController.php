<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\register_user as user_r;
use App\authentication_user as auth_r;
use App\addpost_user as addpost_r;
use App\post_content as post_content;
use App\user_followers as followers_r;
use App\user_following as following_r;
use App\post_comment as comment_r;
use App\post_comment_replay as comment_replay;
use App\post_like as like_r;
use App\post_dislike as dislike_r;
use DB;
use Session;
use Auth;

class PostController extends Controller
{
    public function login()
    {
    	return view('login');
    }
    public function register()
    {
    	return view('register');
    }
    public function homescreen()
    {
    	return view('homescreen');
    }

     public function dashboard()
      {
         $user = Session::get('tbl_user');
          if($user){
              $get_user = user_r::where(['user_id' => $user])->first();
              if(!is_null($get_user)){
              	$get_following_user = following_r::where(['user_id' => $get_user->user_id,'is_deleted' => 0])->count();
              	$get_followers_user = followers_r::where(['user_id' => $get_user->user_id,'is_deleted' => 0])->count();
                          
              	# $get_followings = following_r::where(['user_id' => $user])->count();
              	 return view('dashboard',['get_user' => $get_user]);
               # return view('dashboard',['user_fullname'=>$get_user->user_fullname,'user_email'=>$get_user->user_email,'user_profile'=>$get_user->user_profile, 'get_following_user'=> $get_following_user,'get_followers_user'=> $get_followers_user]);*/
                 # return view('dashboard',['user_id'=>$get_followings->user_id]);

              }else{
                return view('login');
              }
             
          }
          else{
            return view('login');
          }
             
      }
      public function logout(Request $request) {
            Auth::logout();
            Session::flush();
            return redirect('login');
      }

    public function login_redirect(Request $request)
    {
        $user_email = $request->input('user_email');
        $user_password = $request->input('user_password');
        $get_user = user_r::where(['user_email' => $user_email])->first();
        if(!is_null($get_user))
        { 
        	if ($get_user->user_password == $user_password) {
                $request->session()->put('tbl_user', $get_user->user_id);
                if ($request->session()->has('tbl_user')) {
                   echo json_encode(array('redirect' => "dashboard"));
                  // return redirect('dashboard');
                }else{
                  header ("Location: dashboard");
                }
            // }
             
			}else{
			return 1;
			}
    
		}else 
		{
		return 0;
		}
    }

     public function user_registration(Request $request)
    { 
    	
    	$flag = true;
      $user_fullname = $request->user_fullname;
    	$user_email = $request->user_email;
    	$user_mobile_no = $request->user_mobile_no;
    	$user_password = $request->user_password;

       
        $get_package = user_r::where(['user_email' => $user_email])->first();
        if (!is_null($get_package)) {
                return 0;
        }else{
           	$insert_data = [];
	    	$insert_data = [
	    		'user_fullname' => $user_fullname,
	    		'user_email' => $user_email,
	    		'user_mobile_no' => $user_mobile_no,
	    		'user_password' => $user_password,	
	    	];
	    	$insert_user = user_r::create($insert_data);
	    	 # return redirect('login');
                if ($insert_user) {
                  #    $flag = false;
                  # echo json_encode(array('redirect' => "login"));
                  return 1;
                } 
            }
        if ($flag) { 
           return 1;
        }else{
            return 0;
        }
    }

    public function fetch_userprofile(Request $request)
    {
      $user_id = $request->user_id;
      $output = '';
      $get_profile = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
      if (!is_null($get_profile)) {
      	 	$img=asset('public/storage/upload/'.$get_profile->user_profile);
           $get_followers_user = followers_r::where(['user_id' => $get_profile->user_id,'is_deleted' => 0])->count();
            $get_following_user = following_r::where(['user_id' => $get_profile->user_id,'is_deleted' => 0])->count();
			$output .= '
      <div>
        <div class="w3-container">
            <h4><strong>'.$get_profile->user_fullname.'</strong></h4>
	          <img src="'.$img.'" class="w3-circle" width="100px" height="100px" style=" text-align:center; border-radius:50%; object-fit:contain;" alt="Avatar"/></td>
	           </div></div>
	       
	        	<hr>
	        	<td data-toggle="modal" class="following" data-target="#following_data" style="cursor:pointer;font-size:15px;"> <strong>Following : </strong>'.$get_following_user.' <table id="get_following" hidden>  
              </table></td>
              <tr>
            <td data-toggle="modal" class="follow" data-target="#followers_data" style="cursor:pointer;font-size:15px;">  <strong> Followers : </strong> '.$get_followers_user.' <table id="get_followers" hidden>  
              </table></td></td>
            </tr>
	        	</tr>
	        	';
              
	        /*$get_followers_user = followers_r::where(['user_id' => $get_profile->user_id,'is_deleted' => 0])->count();
	            $output .= '
	        	<tr>
	        	<td data-toggle="modal" class="following" data-target="#followers_data" style="cursor:pointer;">  <strong> Followers : </strong> '.$get_followers_user.' <table id="get_following">  
              </table></td></td>
	        	</tr>
	        	';*/
      	}
      	echo json_encode($output);
    }
    
    public function getuser_post(Request $request)
    {
      $user_id = $request->user_id;
      $output = '';
      $get_profile = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
      if (!is_null($get_profile)) {
      	 
          $get_user_post = addpost_r::where(['user_id' => $get_profile->user_id])->get();
              $post_data = [];
              $output = '';
              foreach ($get_user_post as $key => $value) {  
              $get_post_content = post_content::where(['post_id' => $value->post_id])->get();                 
                foreach ($get_post_content as $key => $get_post) {
                  $get_like = like_r::where(['post_id' => $value->post_id,'is_deleted' => 0])->count();
                  $getpost_comment = comment_r::where(['user_id' => $value->user_id])->count();
                  $img=asset('public/storage/addpost/'.$get_post->content_name);
              		$output .= '
                   <div class="w3-container w3-card w3-white w3-round w3-margin"><br>  
  		             '.$value->post_name.' <br>
                   '.$value->post_description.'<hr>

  		              <img src="'.$img.'"  style="width:100%; object-fit:contain;" class="w3-margin-bottom"/><br>
                    <button type="button" style="pading:5px;" name="like" class="w3-button w3-theme-d1 w3-margin-bottom "><i class="fa fa-thumbs-up"></i> LIKE   '.$get_like.'</button>

                    <button type="button" style="pading:5px;" name="comment" class="w3-button w3-theme-d1 w3-margin-bottom " data-toggle="modal" data-target="#"><i class="fa fa-comment"></i> Comment  '.$getpost_comment.'</button> 
                    </div>';
  		                    # print_r($get_like);die();
               
                }   
              }   
              echo json_encode($output);
      }
    }
    
    public function adduser_post(Request $request)
    {
    	$user_id =$request->user_id;
	   	$post_name = $request->post_name;
	   	$post_description = $request->post_description;
	   	$latitude = $request->latitude;
	   	$longitude = $request->longitude;
			  
	   	$addpost_data = [];
	   	$addpost_data = [
        'user_id' => $user_id,
	   		'post_name' => $post_name,
	   		'post_description' => $post_description,
	   		'latitude' => $latitude,
	   		'longitude' => $longitude,
	   	];
	   	$add_post = addpost_r::create($addpost_data);
	   	if ($add_post) {
	   		$get_post = addpost_r::where(['post_id' => $add_post->post_id])->first();
  	   		if (!is_null($get_post)) {
              $insert_data= [];
              $newfile = $request->hasfile('content_name');
              if($newfile){
                $files=$request->file('content_name');
                if($files){
                  foreach($files as $file){
                      // $name=$file->getClientOriginalName();
                      $extention=$file->getClientOriginalExtension();
                      $filename=rand().'-'.date('mdYHis').'.'.$extention;
                      $file->storeAs('public/Addpost',$filename);
                      $pack_data = array(
                        'content_name' => $filename,
                        'post_id'  => $get_post->post_id

                       );
                       $insert_data[] = $pack_data; 
                      # $image[]=$name;
                  }
                   # print_r($insert_data);die();
                    $data = post_content::insert($insert_data); 
                    if ($data) {
                      return 1;
                    }
                 # }
              }
              
             
  	   		}else{
  	   		
  	   		}	  
    }
    return 1;
    }

}

   public function edit_profile(Request $request)
    {

        $user_id = $request->input('user_id');
        $edit_profile = user_r::where(['user_id' => $user_id])->first();
         # $edit_profile = crud::find($user_id);
        $output = array(
             # 'user_id' => $edit_profile->user_id,
           'user_id' => $edit_profile->user_id,
            'user_fullname'    =>  $edit_profile->user_fullname,
            'user_email'     =>  $edit_profile->user_email,
            'user_mobile_no'     =>  $edit_profile->user_mobile_no,
            'user_password'     =>  $edit_profile->user_password,
            'user_profile'     =>  asset('public/storage/upload/'.$edit_profile->user_profile) 
        );
        echo json_encode($output);
    }

    
     public function update_profile(Request $request)
    {

        $user_id = $request->input('user_id');
        $upadate_data = [];

        $cruds = user_r::where(['user_id' => $user_id])->first();

        if(!is_null($cruds)){

            $user_fullname = $request->user_fullname;
            $user_email = $request->user_email;
            $user_mobile_no = $request->user_mobile_no;
            $user_password = $request->user_password;


            $upadate_data = [
                'user_fullname' => $user_fullname,
                'user_email' => $user_email,
                'user_mobile_no' => $user_mobile_no,
                'user_password' => $user_password,

            ];
            if ($request->hasfile('user_profile')) {
                $file=$request->file('user_profile');
                $extention=$file->getClientOriginalExtension();
                $filename=time().'.'.$extention;

                $image = $file->storeAs('public/upload',$filename); 
                $cruds->image=$filename;
                $upadate_data['user_profile'] = $filename;
              }

            $update_id = user_r::where(['user_id' => $user_id])->update($upadate_data);
            if($update_id){
                echo 0;
            }else{
                echo 1;
            }
        }
        // return $cruds;
        // return view('insert')->with('crud',$cruds);
    }
    
  public function getuser_feed(Request $request)
  {
    $user_id = $request->user_id;
    // print_r($user_id);die();

    $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
    if (!is_null($get_user)) {
      $post_ids = [];
      $all_data = [];
      $user_lat = $get_user->latitude;
      $user_long = $get_user->longitude;
      if (($user_lat != null && $user_lat != "") && ($user_long != null && $user_long !="")){

        $near_post = addpost_r::select("*", DB::raw("6371 * acos(cos(radians(" . $user_lat . ")) * cos(radians(latitude)) * cos(radians(longitude) - radians(" . $user_long . ")) + sin(radians(" .$user_lat. ")) * sin(radians(latitude))) AS distance"));
          $near_post = $near_post->having('distance', '<', 10); 
          $near_post = $near_post->get();
          if (count($near_post)>0) {
            foreach ($near_post as $near_post_key => $near_post_value) {
              $get_post = addpost_r::where(['post_id' => $near_post_value->post_id,'is_deleted' => 0])->first();

              if (!is_null($get_post)) {
                $post_ids[] = $get_post->post_id;
              }
            }
          }
      }

      $getuser_following = following_r::where(['user_id' => $get_user->user_id])->get();
      $output  = '';
      if (count($getuser_following)>0) {
          foreach ($getuser_following as $following_key => $following_value) {
            $getuser_data = user_r::where(['user_id' => $following_value->followings_id])->first();
          
            // print_r($getuser_data);die();
            if (!is_null($getuser_data)) {
              $getuser_post = addpost_r::where(['user_id' => $getuser_data->user_id,'is_deleted' => 0])->get();
              if (count($getuser_post)>0) {
                foreach ($getuser_post as $getuser_post_key => $getuser_post_value) {
                  $post_ids[] = $getuser_post_value->post_id;
                // print_r($post_ids);die();  
                }
              }
             }
          }
      }

      $getall_post = addpost_r::whereIn('post_id' , $post_ids)->whereNotIn('user_id',[ $get_user->user_id])->where(['is_deleted' => 0])->get();
      // print_r($getall_post);die();
      $output = '';
        
      if (count($getall_post)>0) {

              $post_data = [];
              $output = '';
              foreach ($getall_post as $key => $value) {  
              $get_post_content = post_content::where(['post_id' => $value->post_id])->get();                 
                  foreach ($get_post_content as $key => $get_post) {
                    $getpost_like = like_r::where(['post_id' =>$get_post->post_id,'is_deleted' => 0])->count();
                    $getpost_comment = comment_r::where(['post_id' =>$get_post->post_id,'is_deleted' => 0])->count();

                    $user_id_data = user_r::where(['user_id' =>$value->user_id])->first();

                    $Profile_img=asset('public/storage/upload/'.$user_id_data->user_profile);

                    $img=asset('public/storage/addpost/'.$get_post->content_name);
                    $output .= '
                      <div class="w3-container w3-card w3-white w3-round w3-margin"><br>                                         
                        <img href="" src="'.$Profile_img.'" class="w3-left w3-circle w3-margin-right" style="width:60px;height:60px;object-fit:contain;"/> <h4>'.$user_id_data->user_fullname.'</h4><br><hr>  
                        '.$value->post_name.'<br>
                        '.$value->post_description.'    
                        <img  src="'.$img.'" style="width:100%; object-fit:contain;" class="w3-margin-bottom">
                        <button type="button" style="pading:5px;" name="like" class="w3-button w3-theme-d1 w3-margin-bottom like" data-post_id='.$get_post->post_id.'><i class="fa fa-thumbs-up"></i> LIKE   '.$getpost_like.'</button>

                        <button type="button" style="pading:5px;" name="comment" class="w3-button w3-theme-d1 w3-margin-bottom comment" data-post_id='.$get_post->post_id.' data-toggle="modal" data-target="#comment_data"><i class="fa fa-comment"></i> Comment  '.$getpost_comment.'</button>  
                      
                          <form id="add_comment" hidden>
                          <input type="text" name="comment_description" class="form-control" placeholder="Enter Comment Description..">
                          <input type="hidden" name="user_id" class="form-control" placeholder="Enter Comment Description.."" value=""><br>

                            <input type="submit" name="Comment" id="Comment" class="btn btn-info" value="Comment" />  
                        </form></div>
                      ';
                
                  }  

                 /* <form id="add_comment" hidden>
                        '.csrf_field().'
                        <input type="text" name="comment_description" class="form-control" placeholder="Enter Comment Description..">
                        <input type="hidden" name="user_id" class="form-control" placeholder="Enter Comment Description.. value='.$user_id.'">

                          <input type="submit" name="Comment" id="Comment" class="btn btn-info" value="Comment" />  
                        </form></div>*/

                  /* $output .='
                    <div class="w3-container w3-card w3-white w3-round w3-margin"><br> 
                   <form id="form1" hidden>
                        <input type="text"  name="comment_description" class="form-control" placeholder="Enter Comment Description..">
                        <button type="button" id="submit">Submit</button>
                    </form></div>'; */

              }  
              echo json_encode($output);
            }
           

     
    }else{
      return 0;
    }
  
  }

  
   public function search_user(Request $request)
    {
       $user_id = $request->user_id;
       $user_fullname = $request->user_fullname;
       if ($user_fullname == "") {
            return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter User name"]);      
        } 
    
      $get_search_user = user_r::where('user_fullname', 'like', "%$user_fullname%")->whereNotIn('user_id',[$user_id])->get(); 
       
      if (count($get_search_user)>0) {

        $get_data = '';
        foreach ($get_search_user as $key => $value) {
       
            $get_following_user = following_r::where(['user_id' => $user_id,'followings_id' => $value->user_id])->first();
            if (!is_null($get_following_user)) {
                  $Profile_img=asset('public/storage/upload/'.$value->user_profile);
                  $get_data .= '
                   <tr>
                    <td><img  src="'.$Profile_img.'" width="30px" height="30px" style="border-radius:50%;border: 2px solid red; object-fit:contain;"/>
                      &nbsp;&nbsp;'.$value->user_fullname.'</td>
                  <td><button type="button" style="margin:5px;" name="following" class="btn btn-info following" data-user_id='.$value->user_id.' data-toggle="modal" data-target="#edit_cat_modal">Following</button></td>&nbsp;
                  </tr><hr>';
              }else{
                  $Profile_img=asset('public/storage/upload/'.$value->user_profile);
                  $get_data .= '
                  <tr>
                  <td><img  src="'.$Profile_img.'" width="30px" height="30px" style="border-radius:50%;border: 2px solid red; object-fit:contain;"/>
                  &nbsp;&nbsp;'.$value->user_fullname.'</td>
                  <td><button type="button" style="margin:5px" name="followers" class="btn btn-info followers" data-user_id='.$value->user_id.' data-toggle="modal" data-target="#edit_cat_modal">Follow</button>
                  </tr>';
              }
  
            }

          echo $get_data;
      }else{
        return response()->json(["status" => false, "responseCode" => 401, "message" => "Record not found"]);
      }  
    }

  public function user_like(Request $request)
  {
      $user_id = $request->user_id;
      $post_id = $request->post_id;

      $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
      if (!is_null($get_user)) {
        $get_post = addpost_r::where(['post_id'=>$post_id])->first();
        if (!is_null($get_post)) {

          $delete_like = like_r::where(['user_id' => $user_id,'post_id'=>$post_id])->first();
          if (!is_null($delete_like)) {
              $delete_like->delete();   
        }else{
  
            $like_data = [];
            $like_data = [
              'user_id' => $user_id,
              'post_id' => $post_id
            ];

            $insert_like = like_r::create($like_data);
            if ($insert_like) {
             /* $get_like = like_r::where(['like_id' => $insert_like->like_id])->first();
              if (!is_null($get_like)) {*/
                // echo "Like successfully";
                  return 1;     
              // }
            }
          }         
        }
      }
  }

  
  public function following_user(Request $request)
    {
      $user_id = $request->user_id;
      $followings_id = $request->followings_id;
      $get_following_data = user_r::where(['user_id' => $followings_id,'is_deleted' => 0])->first(); 
      // print_r($get_following_data);die();
      if (!is_null($get_following_data)) {
            $user_following = following_r::where(['user_id' => $user_id,'followings_id' => $followings_id,'is_deleted' => 0])->first();
            if (is_null($user_following)) {
            // }
            $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first(); 
            if (!is_null($get_user)) {
                  $following_data = [];
                  $following_data = [
                    'user_id' => $user_id,
                    'followings_id' => $followings_id
                  ];
                  $insert_following = following_r::create($following_data);
                  if ($insert_following) {

                    $follow_data = [];
                    $follow_data = [
                      'user_id' => $followings_id,
                      'followers_id' => $user_id
                    ];
                    $insert_followers = followers_r::create($follow_data);
                      if ($insert_followers ) {
                    return 1;
 
                      }   
                  }
           }
         }
      }
      
    }
         
    public function post_comment(Request $request)
    {
      $user_id = $request->user_id;
      $comment_description = $request->comment_description;
      $post_id = $request->post_id;

        $comment_data = [];
        $comment_data = [
          'comment_description' => $comment_description,
          'user_id' => $user_id,
          'post_id' => $post_id
          // 'parentuser_id' => $parentuser_id
        ];
        $insert_comment =comment_r::create($comment_data);
        if ($insert_comment) {
          echo 1;
       }else{
        echo 0;
       }   
    }   
        
    public function get_comment(Request $request)
    {
      $user_id = $request->user_id;
      $post_id = $request->post_id;
      $get_comment = comment_r::where(['post_id' => $post_id])->get();
      $output = '';
      if (count($get_comment)>0) {
          foreach ($get_comment as $get_comment_key => $get_comment_value) {
          $get_user = user_r::where(['user_id' => $get_comment_value->user_id,'is_deleted' => 0])->first();
            if (!is_null($get_user)) {
              $get_post = addpost_r::where(['post_id' => $get_comment_value->post_id])->first();
                if (!is_null($get_user)) {

              // foreach ($get_comment as $get_comment_key => $get_comment_value) {
              $get_replay_comment =  comment_replay::where(['comment_id' => $get_comment_value->comment_id])->get();
                foreach ($get_replay_comment as $get_replay_comment_key => $get_replay_comment_value) {
                 /* $output.= '
                  <tr>
                    <tr><td>'.$get_comment_value->replay_description = $get_replay_comment.'</tr></td>

                  </tr>
                ';*/
                }

                 // <tr><td>'.$get_replay_comment_value->replay_description .'</tr></td>
                $Profile_image=asset('public/storage/upload/'.$get_user->user_profile);
                $Profile_image_data=asset('public/storage/upload/'.$get_comment_value->user_profile);

                
               $output .='
                 <tr>  
                 <td><img  src="'.$Profile_image.'" width="30px" height="30px" style="margin:5px; border-radius:50%;border: 2px solid red; object-fit:contain;"/>
                        &nbsp;<strong>'.$get_user->user_fullname.':</strong>
                '.$get_comment_value->comment_description.'&nbsp;&nbsp;&nbsp;
                <tr><td style="text-align:right"><img  src="'.$Profile_image_data.'" width="30px" height="30px" style="margin:5px; border-radius:50%;border: 2px solid red; object-fit:contain;"/>'.$get_replay_comment_value->replay_description .'</tr></td>
                  <td><button type="button" name="replay" class="btn btn-info replay" data-comment_id='.$get_comment_value->comment_id.' data-user_id='.$get_comment_value->user_id.' data-toggle="modal" data-target="#replay_modal">replay</button> 
                   </tr>
               ';
              // }
             }
              
          }
        
        }
        echo json_encode($output);
      //   $data = [];
      // $data['list'] = $output;
      // echo json_encode($data);
      }  


    }  
    public function post_comment_replay(Request $request)
    {
      $comment_id = $request->comment_id;
      // print_r($comment_id);die();
      $user_id = $request->user_id;
      $replay_description = $request->replay_description;
      

        // $replay_data = [];
        $replay_data = [
          'replay_description' => $replay_description,
          'comment_id' => $comment_id,
          'user_id' => $user_id
          
          // 'parentuser_id' => $parentuser_id
        ];
        $comment_replay =comment_replay::create($replay_data);
        if ($comment_replay) {
          return 1;
       }else{
        return 0;
       }   
    }   

    
  public function get_following(Request $request)
  {
    $user_id = $request->user_id;
    $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
    if (!is_null($get_user)) {
      $get_following = following_r::where(['user_id' => $get_user->user_id,'is_deleted' => 0])->get();
      $output = '';
      foreach ($get_following as $get_following_key => $get_following_value) {
        $get_user_data = user_r::where(['user_id' => $get_following_value->followings_id,'is_deleted' => 0])->orderBy('user_id','ASC')->get();
        
        foreach ($get_user_data as $key => $value) {
          $Profile_image=asset('public/storage/upload/'.$value->user_profile);
          $output.= '
            <tr>
              <td><img  src="'.$Profile_image.'" width="40px" height="40px" style="margin:5px; border-radius:50%;border: 2px solid red; object-fit:contain;"/>&nbsp;&nbsp;
              <td><h4>'.$value->user_fullname.'</h4></td>
            </tr>
          '; 
      }
    }
        echo json_encode($output); 
    }
  }
  
  public function get_followers(Request $request)
  {
    $user_id = $request->user_id;
    $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
    if (!is_null($get_user)) {
      $get_followers = followers_r::where(['user_id' => $get_user->user_id,'is_deleted' => 0])->get();
       $output = '';
      foreach ($get_followers as $get_followerskey => $get_followers_value) {
        $get_user_data = user_r::where(['user_id' => $get_followers_value->followers_id,'is_deleted' => 0])->orderBy('user_id','ASC')->get();
        foreach ($get_user_data as $key => $value) {
         $Profile_image=asset('public/storage/upload/'.$value->user_profile);
         $output.= '
            <tr>
              <td><img  src="'.$Profile_image.'" width="40px" height="40px" style="margin:5px; border-radius:50%;border: 2px solid red; object-fit:contain;"/>&nbsp;&nbsp;
            <td><h4>'.$value->user_fullname.'</h4></td>
            </tr>
          '; 
      }
    } 
      echo json_encode($output); 
    }
  }
    
}
