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
use Crypt;
use Session;
use Auth;

class InstaController extends Controller
{
    public function login()
    {
    	return view('login');
    } 
    public function register()
    {
    	return view('register');
    }
    public function following($user_id)
    {
    	return view('following',['user_id' => $user_id]);
    }
    public function followers($user_id)
    {
      return view('followers',['user_id' => $user_id]);
    }
    public function profile($user_id)
    {
      return view('profile',['user_id' => $user_id]);
    }
    public function getuser_profile($user_id,$newuser_id)
    {
      return view('getuser_profile',['user_id' => $user_id,'newuser_id' => $newuser_id]);
    }
    

    
     public function homescreen()
      {
         $user = Session::get('tbl_user');
          if($user){
              $get_user = user_r::where(['user_id' => $user])->first();
              if(!is_null($get_user)){
              	$get_following_user = following_r::where(['user_id' => $get_user->user_id,'is_deleted' => 0])->count();
              	$get_followers_user = followers_r::where(['user_id' => $get_user->user_id,'is_deleted' => 0])->count();
                          
              	# $get_followings = following_r::where(['user_id' => $user])->count();
              	 // return view('dashboard',['get_user' => $get_user]);
               return view('homescreen',['get_user' => $get_user,'get_following_user'=> $get_following_user,'get_followers_user'=> $get_followers_user]);
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
          $decrypt_password = Crypt::decrypt($get_user->user_password); 
        	if ($decrypt_password == $user_password) {
                $request->session()->put('tbl_user', $get_user->user_id);
                if ($request->session()->has('tbl_user')) {
                   echo json_encode(array('redirect' => "homescreen"));
                  // return redirect('homescreen');
                 }
                // }else{
                //   header ("Location: homescreen");
                // }
               
    			}else{
    			return 1;
    			}   
    		}else{
      		return 0;
      	}
    }

     public function user_registration(Request $request)
    { 
    	
    	$flag = true;
      $user_fullname = $request->user_fullname;
    	$user_email = $request->user_email;
    	$user_mobile_no = $request->user_mobile_no;
    	$user_password = Crypt::encrypt($request->user_password);
      $latitude = $request->latitude;
      $longitude = $request->longitude;


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
          'latitude' => $latitude,
          'longitude'	=> $longitude
	    	];
	    	$insert_user = user_r::create($insert_data);
	    	 # return redirect('login');
              if ($insert_user) {
              $unique_token = $this->getSecureKey();
              $insert_login = [];
              $insert_login = [
                'user_id' => $insert_user->user_id,
                'unique_token' => $unique_token,
              ];

              $insert_auth = auth_r::create($insert_login);
                return 1;
              } 
          }
        if ($flag) { 
           return 1;
        }else{
            return 0;
        }
    }

    public function user_comment($post_id,$user_id)
    {
      $get_user = user_r::get();
      $user_post = addpost_r::where(['post_id' => $post_id])->first();
      $userpost_content = post_content::where(['post_id' => $post_id])->get();
      $comments = comment_r::where(['post_id' => $post_id])->orderBy('comment_id','DESC')->get();
          $comment_replay = comment_replay::orderBy('replay_id','DESC')->get();

          return view('user_comment_data',['post_id' => $post_id,'user_id'=>$user_id,'comments' => $comments,'comment_replay' => $comment_replay,'get_user' => $get_user,'userpost_content' => $userpost_content,'user_post' => $user_post]);
        
    }

    public function image($user_id)
    {
      return view('image',['user_id' => $user_id]);
    }

    public function get_post(Request $request)
    {
      $user_id = $request->user_id;
      $output = '';
      $get_profile = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
      if (!is_null($get_profile)) {
         
          $get_user_post = addpost_r::where(['user_id' => $get_profile->user_id])->orderBy('post_id','DESC')->get();
              $post_data = [];
              $output = '';
              foreach ($get_user_post as $key => $value) {  
              $get_post_content = post_content::where(['post_id' => $value->post_id])->get();                 
                foreach ($get_post_content as $key => $get_post) {
                  $get_like = like_r::where(['post_id' => $value->post_id,'is_deleted' => 0])->count();
                  $getpost_comment = comment_r::where(['post_id' => $value->post_id])->count();

                      $get_post_like = like_r::where(['user_id' => $user_id,'post_id' => $get_post->post_id])->get();
                    // print_r($get_post_like);die();
                    if (count($get_post_like)>0) { 
                     $new_button = '
                     <button type="button" style="pading:5px;background:#4d636f" name="like" class="like active" data-post_id='.$get_post->post_id.'><i class="fa fa-thumbs-up"></i> LIKE   '.$get_like.'</button>
                     ';
                    }else{
                      $new_button ='<button type="button" style="pading:5px;background:red" name="like" class="like active" data-post_id='.$get_post->post_id.'><i class="fa fa-thumbs-up"></i> LIKE   '.$get_like.'</button>';
                    }
                  $img=asset('public/storage/addpost/'.$get_post->content_name);
                  $output .= '
                   <div class="w3-container w3-card w3-white w3-round w3-margin"><br>  
                   
                    <img src="'.$img.'"  style="width:100%; height:300px; object-fit:contain;" class="w3-margin-bottom" id="post"/><br>
                    <p>'.$value->post_name.' </p>
                    </p>'.$value->post_description.'</p>
                    
                    '.$new_button.'
                    <a href ="../user_comment/'.$get_post->post_id.'/'.$user_id.'"><button type="button" style="pading:5px;" name="comment" class="comment" data-toggle="modal" data-target="#"><i class="fa fa-comment"></i> Comment  '.$getpost_comment.'</button></a> 
                    </div>';
                          # print_r($get_like);die();
               
                }   
              }   
              echo json_encode($output);
              // <button type="button" style="pading:5px;" name="like" class="w3-button w3-theme-d1 w3-margin-bottom like"><i class="fa fa-thumbs-up"></i> LIKE   '.$get_like.'</button>
      }
    }

    public function fetch_userprofile(Request $request)
    {
      $user_id = $request->user_id;
      // $user_fullname = $request->user_fullname;
      $output = '';
      $getuser_profile = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
      // $user_profile=asset('public/storage/upload/'.$getuser_profile->user_profile);
      if (!is_null($getuser_profile)) {
      	 	// $profile_img=asset('public/storage/upload/'.$getuser_profile->user_profile);
           $get_followers_user = followers_r::where(['user_id' => $getuser_profile->user_id,'is_deleted' => 0])->count();
            $get_following_user = following_r::where(['user_id' => $getuser_profile->user_id,'is_deleted' => 0])->count();
            $post_count = addpost_r::where(['user_id' => $user_id])->count();

              if($getuser_profile->user_profile == "" || $getuser_profile->user_profile == null){
                $profile_img = 'https://www.w3schools.com//w3images/avatar3.png';
              }else{
                $profile_img=asset('public/storage/upload/'.$getuser_profile->user_profile);
              }
        			$output .= '
                <div class="w3-container">                  
        	          <img src="'.$profile_img.'" class="w3-circle" width="100px" height="100px" style=" text-align:center; float:left; border-radius:50%;" alt="Avatar"/>
                  <div><h4 >'.$getuser_profile->user_fullname.'</h4></div>
                  <div class="profile_div">
                    <a style="text-decoration:none" href ="../following/'.$user_id.'"><p class = "profile_css"> Following </p></a>
                    <a style="text-decoration:none" href ="../followers/'.$user_id.'"><p class = "profile_css""> Followers </p></a> 
                    <a style="text-decoration:none" href ="#profile"><p class = "profile_css1"> Post </p></a> <br>
                    <b><p class = "profile_css2">'.$get_following_user .'</p> <p class = "profile_css">'.$get_followers_user .'</p>
                      <p class = "profile_css3">'.$post_count.'</p></b>
                  </div>
        	       </div>
        	        	</tr>
  	        	';             
      	}
          echo json_encode($output);
       /* <p class="profile_data1">user name</p> <h4 class="profile_data">'.$getuser_profile->user_fullname.'</h4><br>
                  <p class="profile_data1">Email</p> <h4 class="profile_data">'.$get_profile->user_email.'</h4><br>
                  <p class="profile_data1">Mobile No.</p> <h4 class="profile_data">'.$get_profile->user_mobile_no.'</h4><br>
                  <p class="profile_data1">Password</p> <h4 class="profile_data">'.$get_profile->user_password.'</h4>*/
      /* $return_arr = array('user_fullname'=>$get_profile->user_fullname,'user_email'=>$get_profile->user_email,'user_profile' => $user_profile,'get_following_user' => $get_following_user,'get_followers_user' => $get_followers_user);
            return response()->json($return_arr);*/
    }

    

    public function getalluser_profile(Request $request)
    {
      $user_id = $request->user_id;
      // print($user_id);die();
      // $user_fullname = $request->user_fullname;
      $output = '';
      $getuser_profile = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
      // $user_profile=asset('public/storage/upload/'.$getuser_profile->user_profile);
      if (!is_null($getuser_profile)) {
          // $profile_img=asset('public/storage/upload/'.$getuser_profile->user_profile);
           $get_followers_user = followers_r::where(['user_id' => $getuser_profile->user_id,'is_deleted' => 0])->count();
            $get_following_user = following_r::where(['user_id' => $getuser_profile->user_id,'is_deleted' => 0])->count();
            $post_count = addpost_r::where(['user_id' => $user_id])->count();

              if($getuser_profile->user_profile == "" || $getuser_profile->user_profile == null){
                $profile_img = 'https://www.w3schools.com//w3images/avatar3.png';
              }else{
                $profile_img=asset('public/storage/upload/'.$getuser_profile->user_profile);
              }
              $output .= '
                <div class="w3-container">                  
                    <img src="'.$profile_img.'" class="w3-circle" width="100px" height="100px" style=" text-align:center; float:left; border-radius:50%;" alt="Avatar"/>
                  <div><h4 >'.$getuser_profile->user_fullname.'</h4></div>
                  <div class="profile_div">
                    <a style="text-decoration:none" href ="../following/'.$user_id.'"><p class = "profile_css"> Following </p></a>
                    <a style="text-decoration:none" href ="../followers/'.$user_id.'"><p class = "profile_css""> Followers </p></a> 
                    <a style="text-decoration:none" href ="#profile"><p class = "profile_css1"> Post </p></a> <br>
                    <b><p class = "profile_css2">'.$get_following_user .'</p> <p class = "profile_css">'.$get_followers_user .'</p>
                      <p class = "profile_css3">'.$post_count.'</p></b>
                  </div>
                 </div>
                    </tr>
              ';             
        }
          echo json_encode($output);
       /* <p class="profile_data1">user name</p> <h4 class="profile_data">'.$getuser_profile->user_fullname.'</h4><br>
                  <p class="profile_data1">Email</p> <h4 class="profile_data">'.$get_profile->user_email.'</h4><br>
                  <p class="profile_data1">Mobile No.</p> <h4 class="profile_data">'.$get_profile->user_mobile_no.'</h4><br>
                  <p class="profile_data1">Password</p> <h4 class="profile_data">'.$get_profile->user_password.'</h4>*/
      /* $return_arr = array('user_fullname'=>$get_profile->user_fullname,'user_email'=>$get_profile->user_email,'user_profile' => $user_profile,'get_following_user' => $get_following_user,'get_followers_user' => $get_followers_user);
            return response()->json($return_arr);*/
    }
    
    public function getuser_post(Request $request)
    {
      $user_id = $request->user_id;
      $output = '';
      $get_profile = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
      if (!is_null($get_profile)) {
      	 
          $get_user_post = addpost_r::where(['user_id' => $get_profile->user_id])->orderBy('post_id','DESC')->get();  
              $data = [];
              $output = '';
              foreach ($get_user_post as $key => $value) {  
              $get_post_content = post_content::where(['post_id' => $value->post_id])->get();                 
                foreach ($get_post_content as $key => $get_post) {
                  $get_like = like_r::where(['post_id' => $value->post_id,'is_deleted' => 0])->count();
                  $getpost_comment = comment_r::where(['user_id' => $value->user_id])->count();
                  $img=asset('public/storage/addpost/'.$get_post->content_name);
                  // 
                  $data [] = $img;
              		/*$output .= '  
                  <div class="w3-col m12 ">
                   <div class="w3-container w3-card w3-white w3-round w3-margin "><br> 

  		             '.$value->post_name.' <br>
                   '.$value->post_description.'<hr>

  		              <img src="'.$img.'"  style="width:100%; object-fit:contain;" class="w3-margin-bottom"/><br>
                    <button type="button" style="pading:5px;" name="like" class="w3-button w3-theme-d1 w3-margin-bottom "><i class="fa fa-thumbs-up"></i> LIKE   '.$get_like.'</button>
                    <button type="button" style="pading:5px;" name="comment" class="w3-button w3-theme-d1 w3-margin-bottom " data-toggle="modal" data-target="#"><i class="fa fa-comment"></i> Comment  '.$getpost_comment.'</button> 
                    </div></div>';*/

               
            

                }   
              }   
              // $return_arr = array('img' => $img);
            return response()->json($data);
              // echo json_encode($output);
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
         if($edit_profile->user_profile == "" || $edit_profile->user_profile == null){
                $profile_img = 'https://www.w3schools.com//w3images/avatar3.png';
              }else{
                $profile_img= asset('public/storage/upload/'.$edit_profile->user_profile);
              }

        $output = array(
             # 'user_id' => $edit_profile->user_id,
           'user_id' => $edit_profile->user_id,
            'user_fullname'    =>  $edit_profile->user_fullname,
            'user_email'     =>  $edit_profile->user_email,
            'user_mobile_no'     =>  $edit_profile->user_mobile_no,
            'user_password'     =>  Crypt::decrypt($edit_profile->user_password),
            'user_profile'     =>  $profile_img
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
            $user_password = Crypt::encrypt($request->user_password);


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

      $getall_post = addpost_r::whereIn('post_id' , $post_ids)->whereNotIn('user_id',[ $get_user->user_id])->where(['is_deleted' => 0])->orderBy('post_id','DESC')->get();
      // print_r($getall_post);die();
      $output = '';
        
      if (count($getall_post)>0) {

              $post_data = [];
              $output = '';
              foreach ($getall_post as $key => $value) {  
              $get_post_content = post_content::where(['post_id' => $value->post_id])->get();

              // print_r($get_content);die(); 
                  foreach ($get_post_content as $key => $get_post) {

                    // print_r($get_post_like);die();
                    $getpost_like = like_r::where(['post_id' =>$get_post->post_id,'is_deleted' => 0])->count();
                    $getpost_comment = comment_r::where(['post_id' =>$get_post->post_id,'is_deleted' => 0])->count();

                    $user_id_data = user_r::where(['user_id' =>$value->user_id])->first();

                    
                    if($user_id_data->user_profile == "" || $user_id_data->user_profile == null){
                      $Profile_img = 'https://www.w3schools.com//w3images/avatar3.png';
                    }else{
                      $Profile_img=asset('public/storage/upload/'.$user_id_data->user_profile);
                    } 

                     $get_post_like = like_r::where(['user_id' => $user_id,'post_id' => $get_post->post_id])->get();
                    // print_r($get_post_like);die();
                    if (count($get_post_like)>0) { 
                     $new_button = '
                     <button type="button" style="pading:5px;background:#4d636f" name="like" class="like active" data-post_id='.$get_post->post_id.'><i class="fa fa-thumbs-up"></i> LIKE   '.$getpost_like.'</button>
                     ';
                    }else{
                      $new_button ='<button type="button" style="pading:5px;background:red" name="like" class="like active" data-post_id='.$get_post->post_id.'><i class="fa fa-thumbs-up"></i> LIKE   '.$getpost_like.'</button>';
                    }

                $get_content = post_content::where(['post_id' => $post_ids])->count();
                if($get_content){
                  $img=asset('public/storage/addpost/'.$get_post->content_name);

                  $imagedata = '<a href ="getuser_profile/'.$value->user_id.'/'.$user_id.'"><img src="'.$Profile_img.'" class="w3-left w3-circle w3-margin-right" style="width:60px;height:60px;"/></a> <h4>'.$user_id_data->user_fullname.'</h4><br> ';
                }
                    $output .= '
                      <div class="w3-container w3-card w3-white w3-round w3-margin"><br>                                         
                        '.$imagedata.'
                          
                        <hr class="w3-clear">
                        <img src="'.$img.'" style="width:100%;height:300px;object-fit:contain;" alt="Northern Lights" class="w3-margin-bottom">
                        <p>'.$value->post_name.'</p>
                        <p> '.$value->post_description.'</p>  
                         '.$new_button.'
                        <a href ="user_comment/'.$get_post->post_id.'/'.$user_id.'"><button type="button" style="pading:5px;" name="comment" class=" comment"><i class="fa fa-comment"></i> Comment '.$getpost_comment.'</button> </a> 
                        </div>
                      ';
                
                  }  
                  // w3-button w3-theme-d1 w3-margin-bottom
                  /*<img  src="'.$img.'" style="width:100%; object-fit:contain;height:300px;" class="w3-margin-bottom">*/
              }  
              // $array = ['img' => $img,'new_data' =>$Profile_img ];
              // return response()->json($data);
              echo json_encode($output);
            }    
        }   
  }
  // <button type="button" style="pading:5px;" name="like" class="like active" data-post_id='.$get_post->post_id.'><i class="fa fa-thumbs-up"></i> LIKE   '.$getpost_like.'</button>

             
                  

  
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
                  // $Profile_img=asset('public/storage/upload/'.$value->user_profile);
                  if($value->user_profile == "" || $value->user_profile == null){
                   $Profile_image = 'https://www.w3schools.com//w3images/avatar3.png';
                    // $Profile_image = 'https://www.w3schools.com/w3images/avatar3.png';
                  }else{
                    $Profile_image=asset('public/storage/upload/'.$value->user_profile);
                  }
                    
                  $get_data .= '
                   <tr>
                    <td><img  src="'.$Profile_image.'" width="30px" height="30px" style="border-radius:50%;"/>
                      &nbsp;&nbsp;'.$value->user_fullname.'</td>
                  <td><button type="button" style="margin:5px;width:100px;" name="following" class="w3-button w3-theme following" data-user_id='.$value->user_id.' data-toggle="modal" data-target="#edit_cat_modal">Following</button></td>&nbsp;
                  </tr><hr>';
              }else{
                  if($value->user_profile == "" || $value->user_profile == null){
                      $Profile_image = 'https://www.w3schools.com//w3images/avatar3.png';
                    }else{
                      $Profile_image=asset('public/storage/upload/'.$value->user_profile);
                    }
                  // $Profile_image=asset('public/storage/upload/'.$value->user_profile);
                  $get_data .= '
                  <tr>
                  <td><img  src="'.$Profile_image.'" width="30px" height="30px" style="border-radius:50%;"/>
                  &nbsp;&nbsp;'.$value->user_fullname.'</td>
                  <td><button type="button" style="margin:5px;width:100px;" name="followers" class="w3-button w3-theme followers" data-user_id='.$value->user_id.' data-toggle="modal" data-target="#edit_cat_modal">Follow</button>
                  </tr>';
              }
            
            }

          echo $get_data;
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
  
  /*public function user_dislike(Request $request)
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
          }      
        }
      }
  }
*/
  
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
          return 1;
       }else{
        return 0;
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
    // print_r($user_id);die();
    $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
    if (!is_null($get_user)) {
      $get_following = following_r::where(['user_id' => $get_user->user_id,'is_deleted' => 0])->get();
      $output = '';
      $data = [];
      foreach ($get_following as $get_following_key => $get_following_value) {
        $get_user_data = user_r::where(['user_id' => $get_following_value->followings_id,'is_deleted' => 0])->orderBy('user_id','ASC')->get();
        
        foreach ($get_user_data as $key => $value) {
          // $Profile_image=asset('public/storage/upload/'.$value->user_profile);
          if($value->user_profile == "" || $value->user_profile == null){
            $Profile_image = 'https://www.w3schools.com//w3images/avatar3.png';
          }else{
            $Profile_image=asset('public/storage/upload/'.$value->user_profile);
          }
          $output.= '
            <tr>
              <td><img  src="'.$Profile_image.'" width="40px" height="40px" style="margin:5px; border-radius:50%;"/>&nbsp;&nbsp;
              <td><h4>'.$value->user_fullname.'</h4></td>
              
            </tr>
          '; 
          // $data[] = $value;
      }
    }
        echo json_encode($output); 
    // return view('following',['data' => $data]);

    }
  }

  // <td><button type="button" name="replay" class="w3-button w3-theme unfollow" data-following_id='.$get_following_value->following_id.' data-toggle="modal" data-target="#replay_modal">Unfollow</button> </td>
  
  // public function user_unfollow(Request $request)
  // {
  //   $following_id = $request->following_id;
  //   $delete_folloings = following_r::where(['following_id' => $following_id,'is_deleted' => 0])->first();
  //   if (!is_null($delete_folloings)) {
  //     $delete_folloings->delete();
  //   }
  // }
  
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
         // $Profile_image=asset('public/storage/upload/'.$value->user_profile);

          if($value->user_profile == "" || $value->user_profile == null){
            $Profile_image = 'https://www.w3schools.com//w3images/avatar3.png';
          }else{
            $Profile_image=asset('public/storage/upload/'.$value->user_profile);
          }

         $output.= '
            <tr>
              <td><img  src="'.$Profile_image.'" width="40px" height="40px" style="margin:5px; border-radius:50%; "/>&nbsp;&nbsp;
            <td><h4>'.$value->user_fullname.'</h4></td>

            </tr>
          '; 
      }
    } 
      echo json_encode($output); 
    }
  }

  public function getSecureKey() {
       $string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $stamp = time();
       $secure_key = $pre = $post = '';
       for ($p = 0; $p <= 10; $p++) {
           $pre .= substr($string, rand(0, strlen($string) - 1), 1);
       }

       for ($i = 0; $i < strlen($stamp); $i++) {
           $key = substr($string, substr($stamp, $i, 1), 1);
           $secure_key .= (rand(0, 1) == 0 ? $key : (rand(0, 1) == 1 ? strtoupper($key) : rand(0, 9)));
       }

       for ($p = 0; $p <= 10; $p++) {
           $post .= substr($string, rand(0, strlen($string) - 1), 1);
       }

       return $stamp.$pre . '-' . $secure_key . $post;
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
  
    
}
