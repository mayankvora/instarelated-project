<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
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

class AddpostController extends Controller
{
    public function register_user(Request $request)
    {
    	$user_fullname = $request->user_fullname;
    	$user_email = $request->user_email;
    	$user_mobile_no	 = $request->user_mobile_no	;
    	$user_password = $request->user_password;
    	// $user_profile = $request->user_profile;
    	$device_type = $request->device_type;
      $device_token = $request->device_token;
      $latitude = $request->latitude;
      $longitude = $request->longitude;



    	if ($user_fullname == "") {
             return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter user name"]);      
        }
        if ($user_email == "") {
             return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter email address"]);      
        }
        if ($user_mobile_no == "") {
             return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter mobile no."]);      
        }
        if ($user_password == "") {
             return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter password"]);      
        } 
     /*    if ($latitude == "") {
             return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter latitude"]);      
        }                  
         if ($longitude == "") {
             return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter longitude"]);      
        } */
        if ($device_type == "") {
             return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter device type in ios or android"]);      
        } 
        if ($device_type == "ios" || $device_type == "android") {
  
        $user_login = user_r::where(['user_email' => $user_email])->first();
        if (!is_null($user_login)) {
           	return response()->json(["status" => false, "responseCode" => 201, "message" => "User already register"]);
        }else{
      		$insert_data = [
      		'user_fullname' => $user_fullname,
      		'user_email' => $user_email,
      		'user_mobile_no' => $user_mobile_no,
      		'user_password' => $user_password,
          'latitude' => $latitude,
          'longitude' => $longitude,
      		'device_type' => $device_type,
          'device_token' => $device_token
      		];

        /*	if ($request->hasfile('user_profile')) {
	            $file=$request->file('user_profile');
	            $extention=$file->getClientOriginalExtension();
	            $filename=time().'.'.$extention;
	            $image = $file->storeAs('public/upload',$filename); 
	            $insert_data['user_profile'] = $filename;
            }*/

        	
	    	$insert_user = user_r::create($insert_data);
	    	if ($insert_user) {
	    		$get_user = user_r::where(['user_id' => $insert_user->user_id,'is_deleted' => 0])->first();
	    		if (!is_null($get_user)) {
	    				$unique_token = $this->getSecureKey();
	    				$insert_login = [];
	    				$insert_login = [
	    					'user_id' => $insert_user->user_id,
	    					'unique_token' => $unique_token,
	    				];

	    				$insert_auth = auth_r::create($insert_login);
	    				if ($insert_auth) {
	    					$get_user->user_fullname = ($get_user->user_fullname == null) ? '' : $get_user->user_fullname;
			                $get_user->user_email = ($get_user->user_email == null) ? '' : $get_user->user_email;
			                $get_user->user_mobile_no = ($get_user->user_mobile_no == null) ? '' : $get_user->user_mobile_no;
			                $get_user->latitude = ($get_user->latitude == null) ? '' : $get_user->latitude;
                      $get_user->longitude = ($get_user->longitude == null) ? '' : $get_user->longitude;                      
			                $get_user->user_profile = ($get_user->user_profile == null) ? '' : $get_user->user_profile;
			                $get_user->device_token = ($get_user->device_token == null) ? '' : $get_user->device_token;
			                $get_user->device_type = ($get_user->device_type == null) ? '' : $get_user->device_type;
                      $get_user->unique_token = ($unique_token == null) ? '' : $unique_token;

			                unset($get_user->updated_at,$get_user->deleted_at,$get_user->is_deleted,$get_user->user_password);

		                return response()->json(["status" => true, "responseCode" => 200, "message" => "user registration successfully", "data" => $get_user]);
				    	}else{
		               		return response()->json(["status" => false, "responseCode" => 401, "message" => "Unique token not genrated "]); 
	    				}
	    			}else{
	    				 return response()->json(["status" => false, "responseCode" => 401, "message" => "Record not found "]);
	    			}	
	    	}else{
	    		return response()->json(["status" => false, "responseCode" => 401, "message" => "User not register"]);
	    	} 
    }
  }else{
    return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter device type in ios or android"]); 
  }
	
    }

    

   public function login_user(Request $request)
   {
    	$user_email = $request->user_email;
    	$user_password = $request->user_password;
        if ($user_email == "") {
             return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter email address"]);      
        }
        if ($user_password == "") {
             return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter password"]);      
        }  

        $get_user_login = user_r::where(['user_email' => $user_email,'is_deleted' => 0])->first();

        if (!is_null($get_user_login)) {   
          if ($get_user_login->user_password == $user_password) {
          	$unique_token = $this->getSecureKey();
          	$auth_data = [
          		'unique_token' => $unique_token
          	];

          	$update_auth = auth_r::where(['user_id' =>  $get_user_login->user_id,'is_deleted' => 0])->update($auth_data);
          	if ($update_auth) {
  	        	$get_user_login->user_fullname = ($get_user_login->user_fullname == null) ? '' : $get_user_login->user_fullname;
  	            $get_user_login->user_email = ($get_user_login->user_email == null) ? '' : $get_user_login->user_email;
  	            $get_user_login->user_mobile_no = ($get_user_login->user_mobile_no == null) ? '' : $get_user_login->user_mobile_no;
  	            // $get_user_login->user_password = ($get_user_login->user_password == null) ? '' : $get_user_login->user_password;
  	            $get_user_login->user_profile = ($get_user_login->user_profile == null) ? '' : $get_user_login->user_profile;
  	            $get_user_login->device_token = ($get_user_login->device_token == null) ? '' : $get_user_login->device_token;
  	            $get_user_login->device_type = ($get_user_login->device_type == null) ? '' : $get_user_login->device_type;
  	           	$get_user_login->unique_token = ($unique_token == null) ? '' : $unique_token;


  	            unset($get_user_login->updated_at,$get_user_login->deleted_at,$get_user_login->is_deleted, $get_user_login->user_password);
  	       		return response()->json(["status" => true, "responseCode" => 200, "message" => "User login successfully", "data" => $get_user_login]);
          	}else{
          		return response()->json(["status" => false, "responseCode" => 401, "message" => "Somthing went wrong"]);
          	} 
          }else{
            return response()->json(["status" => false, "responseCode" => 401, "message" => "User not exists"]);
          } 
    		}else{
    			return response()->json(["status" => false, "responseCode" => 401, "message" => " email not exists"]);
    		}    
   	}

   public function add_post(Request $request)
   {
      $user_id =$request->header('userid');
	   	$post_name = $request->post_name;
	   	$post_description = $request->post_description;
	   	$latitude = $request->latitude;
	   	$longitude = $request->longitude;

	   	// if ($post_name == "") {
     //        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter post name"]);      
     //    }
     //    if ($post_description == "") {
     //        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter password"]);      
     //    } 
      if ($latitude == "") {
          return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter latitude"]);      
      }
      if ($longitude == "") {
          return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter longitude"]);      
      }  

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
                      $filename=rand().'.'.date('mdYHis').'-'.$extention;
                      $file->storeAs('public/Addpost',$filename);
                      $pack_data = array(
                        'content_name' => $filename,
                        'post_id'  => $get_post->post_id

                       );
                       $insert_data[] = $pack_data; 
                      // $image[]=$name;
                  }
                   // print_r($insert_data);die();
                    $data = post_content::insert($insert_data); 
                    /*if ($data) {
                      
                    }*/
                }
              }else{
                return response()->json(["status" => false, "responseCode" => 401, "message" => "Please select image.. "]);
              }
              
              $get_post_content = post_content::where(['post_id' => $add_post->post_id])->get();
              $content_data = []; 
              if (count($get_post_content)>0) {
                foreach ($get_post_content as $get_content_key => $get_content_value) {
                  if ($get_content_value->content_name != null && $get_content_value->content_name != "" ) {
                     $get_content_value->content_name  = asset('public/storage/Addpost').'/'.$get_content_value->content_name;
                    
                  }else{
                    $get_content_value->content_name = "";
                  }
                  unset($get_content_value->created_at,$get_content_value->updated_at,$get_content_value->deleted_at,$get_content_value->is_deleted);
                  $content_data [] = $get_content_value;
                }
              }
            }
            $get_post->content = $content_data;   
            $get_post->post_name = ($get_post->post_name == null) ? '' : $get_post->post_name;
            $get_post->post_description = ($get_post->post_description == null) ? '' : $get_post->post_description;
            $get_post->latitude = ($get_post->latitude == null) ? '' : $get_post->latitude;
            $get_post->longitude = ($get_post->longitude == null) ? '' : $get_post->longitude;

            unset($get_post->updated_at,$get_post->deleted_at,$get_post->is_deleted);
            return response()->json(["status" => true, "responseCode" => 200, "message" => " Post Added Successfully  ", "data" => $get_post]);
  	   		}else{
  	   			return response()->json(["status" => false, "responseCode" => 401, "message" => " Somthing went to wrong "]);
  	   		}	  
        // }
	   	// }else{
	   	// 	return response()->json(["status" => false, "responseCode" => 401, "message" => "Sorry Somthing went to wrong "]);
	   	// }
           // }
  }

  public function getuser_feed(Request $request)
  {
    $user_id = $request->header('userid');  

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
                // print_r($post_ids);die();
              }
            }
          }
      }

      $getuser_following = following_r::where(['user_id' => $get_user->user_id])->get();

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

      $getall_post = addpost_r::whereIn('post_id' , $post_ids)->where(['is_deleted' => 0])->get();
      // print_r($getall_post);die();
      if (count($getall_post)>0) {


        foreach ($getall_post as $getall_post_key => $getall_post_value) {
            $get_user_data = user_r::where(['user_id' => $getall_post_value->user_id,'is_deleted' => 0])->first();
            if (!is_null($get_user_data)) {
            $getall_post_value->user_name = $get_user_data->user_fullname;
            if ($get_user_data->user_profile != null && $get_user_data->user_profile != "") {
              $getall_post_value->User_Profile = asset('public/storage/upload/').'/'.$get_user_data->user_profile;
            }else{
              $getall_post_value->User_Profile = "";
            }
          }
  
          $get_post_content = post_content::where(['post_id' => $getall_post_value->post_id])->get();
          $content_data = []; 
          if (count($get_post_content)>0) {
            foreach ($get_post_content as $get_content_key => $get_content_value) {
              if ($get_content_value->content_name != null && $get_content_value->content_name != "" ) {
                 $get_content_value->content_name  = asset('public/storage/Addpost').'/'.$get_content_value->content_name;
                
              }else{
                $get_content_value->content_name = "";
              }
              unset($get_content_value->created_at,$get_content_value->updated_at,$get_content_value->deleted_at,$get_content_value->is_deleted);
              $content_data [] = $get_content_value;
            }
          }

          $getpost_like = like_r::where(['post_id' =>$getall_post_value->post_id,'is_deleted' => 0])->count();
           $getall_post_value->like = $getpost_like;
          $getall_post_value->post_name = ($getall_post_value->post_name == null) ? '' : $getall_post_value->post_name;
          $getall_post_value->post_description = ($getall_post_value->post_description == null) ? '' : $getall_post_value->post_description;
          $getall_post_value->location = ($getall_post_value->location == null) ? '' : $getall_post_value->location; 
          $getall_post_value->latitude = ($getall_post_value->latitude == null) ? '' : $getall_post_value->latitude;  
          $getall_post_value->longitude = ($getall_post_value->longitude == null) ? '' : $getall_post_value->longitude;
          $getall_post_value->content = $content_data;
          unset($getall_post_value->created_at,$getall_post_value->updated_at,$getall_post_value->deleted_at,$getall_post_value->is_deleted);
          $all_data[] = $getall_post_value;
        }
      }
      return response()->json(["status" => true, "responseCode" => 200, "message" => "user feet get successfully ","data" => $all_data]);       
     
    }else{
        return response()->json(["status" => false, "responseCode" => 201, "message" => "User not exists"]); 

    }
  
  }
    
    public function get_profile_data(Request $request)
    {
      $user_id = $request->header('userid');
      $get_profile = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
      if (!is_null($get_profile)) {
        $get_following_user = following_r::where(['user_id' => $get_profile->user_id,'is_deleted' => 0])->count();
            $get_profile->Following = $get_following_user;

          $get_followers_user = followers_r::where(['user_id' => $get_profile->user_id,'is_deleted' => 0])->count();
            $get_profile->Followers = $get_followers_user;

          $get_user_post = addpost_r::where(['user_id' => $get_profile->user_id])->get();
                            $new_data = [];
              foreach ($get_user_post as $key => $value) {  
              $get_post_content = post_content::where(['post_id' => $value->post_id])->get();     $post_data = [];
            
                foreach ($get_post_content as $key => $get_post) {
                    if ($get_post->content_name !=null && $get_post->content_name !="") {
                      $get_post->content_name  = asset('public/storage/Addpost').'/'.$get_post->content_name;
                    }else{
                      $get_post->content_name = "";
                    }
                    $post_data [] = $get_post;
                    // $value->content = $post_data;   

                    $get_like = like_r::where(['post_id' => $get_post->post_id])->count();
                    unset($get_post->updated_at,$get_post->created_at,$get_post->deleted_at);

                }
               $value->like = $get_like;
               $value->content = $post_data;   
               $value->post_name = ($value->post_name == null) ? '' : $value->post_name;
               $value->post_description = ($value->post_description == null) ? '' : $value->post_description;
               $value->latitude  = ($value->latitude   == null) ? '' : $value->latitude  ;
               $value->longitude   = ($value->longitude  == null) ? '' : $value->longitude ;

              unset($value->updated_at,$value->created_at,$value->deleted_at,$value->is_deleted);
              $new_data[] = $value;
              }   
                     

            $get_profile->post = $new_data;
                // $get_profile->data = $post_data;

            $get_profile->user_fullname = ($get_profile->user_fullname == null) ? '' : $get_profile->user_fullname;
            $get_profile->user_email = ($get_profile->user_email == null) ? '' : $get_profile->user_email;
            $get_profile->user_mobile_no = ($get_profile->user_mobile_no == null) ? '' : $get_profile->user_mobile_no;
            // $get_profile->Following = ($get_following_user) ? '' :$get_following_user;
            $get_profile->user_profile = ($get_profile->user_profile == null) ? '' : asset('public/storage/upload').'/'.$get_profile->user_profile;

            unset($get_profile->updated_at,$get_profile->created_at,$get_profile->deleted_at,$get_profile->is_deleted,$get_profile->latitude,$get_profile->longitude,$get_profile->device_token,$get_profile->device_type,$get_profile->user_badge,$get_profile->user_password);

          $get_all_data = $get_profile;
               
          return response()->json(["Status"=>true,"responseCode"=>200, "message"=>"Profile data selected successfully", "data" => $get_all_data]);   
      }else{
          return response()->json(["Status"=>false,"responseCode"=>204, "message"=>"Somthing went to wrong"]);
      }
    }

    
    public function search_user(Request $request)
    {
       $user_id = $request->header('userid');
       $user_fullname = $request->user_fullname;
       if ($user_fullname == "") {
            return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter User name"]);      
        } 
    
      $get_search_user = user_r::where('user_fullname', 'like', "%$user_fullname%")->whereNotIn('user_id',[$user_id])->get(); 
       
      if (count($get_search_user)>0) {

        $get_data = [];
        foreach ($get_search_user as $key => $value) {
       
            $get_following_user = following_r::where(['user_id' => $user_id,'followings_id' => $value->user_id])->first();
            if (!is_null($get_following_user)) {
                $user_data['following'] = true;
            }else{
                $user_data['following']= false;
            }

              $get_followers_user = followers_r::where(['user_id' => $user_id,'followers_id' => $value->user_id])->first();
              if (!is_null($get_followers_user)) {
                  $user_data['follower'] = true;
              }else{
                  $user_data['follower']= false;
              }
              
              $user_data['user_id'] = $value->user_id;
              $user_data['user_fullname'] = ($value->user_fullname == null) ? '' : $value->user_fullname;
            
              $user_data['user_profile'] = ($value->user_profile == null) ? '' : asset('public/storage/upload').'/'.$value->user_profile;

           
              $get_data[] = $user_data;
        }
          return response()->json(["status" => true, "responseCode" => 200, "message" => "Post list selected successfully", "data" => $get_data]);
      }else{
        return response()->json(["status" => false, "responseCode" => 401, "message" => "Record not found"]);
      }  
    }

    public function following_user(Request $request)
    {
      $user_id = $request->header('userid');
      $followings_id = $request->followings_id;
      if ($followings_id == "") {
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter Following id"]); 
      }
      $get_following_data = user_r::where(['user_id' => $followings_id,'is_deleted' => 0])->first(); 
      // print_r($get_following_data);die();
      if (!is_null($get_following_data)) {
          $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first(); 
          if (!is_null($get_user)) {
          
            $user_following = following_r::where(['user_id' => $user_id,'followings_id' => $followings_id,'is_deleted' => 0])->first();

            if ($user_id == $followings_id) {
               return response()->json(["status" => false, "responseCode" => 201, "message" => "Same user not follow"]);

            }else{
                if (!is_null($user_following)) {
                  return response()->json(["status" => false, "responseCode" => 201, "message" => "You are allready Follow this user"]);
                }else{
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
                        return response()->json(["status" => true, "responseCode" => 200, "message" => "User follow successfully."]);
                        
                      }else{
                        return response()->json(["status" => false, "responseCode" => 201, "message" => "Somthing went to wrong"]); 
                      }
                    return response()->json(["status" => true, "responseCode" => 200, "message" => "User follow successfully."]);
                      
                  }else{
                      return response()->json(["status" => false, "responseCode" => 201, "message" => "Somthing went to wrong"]); 
                  } 
              }
            
           }
         }else{
            return response()->json(["status" => false, "responseCode" => 201, "message" => "User Not exists"]); 
           } 
  
      }else{
        return response()->json(["status" => false, "responseCode" => 201, "message" => "User Not exists"]); 
      }
      
    }
    
    public function followers_user(Request $request)
    {
      $user_id = $request->header('userid');
      $followers_id  = $request->followers_id ;
      if ($followers_id  == "") {
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter followers id"]); 
      }
      $get_following_data = user_r::where(['user_id' => $followers_id ,'is_deleted' => 0])->first(); 
      
      if (!is_null($get_following_data)) {
          $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first(); 
          if (!is_null($get_user)) {
          
            // print_r($user_following);die();

            if ($user_id == $followers_id ) {
               return response()->json(["status" => false, "responseCode" => 201, "message" => "Same user not follow"]);

            }else{

                $user_following = following_r::where(['user_id' => $user_id,'followings_id' => $followers_id, 'is_deleted' => 0])->first();
                if (!is_null($user_following)) {
                  return response()->json(["status" => false, "responseCode" => 201, "message" => "following"]);
                }else{
                $get_follow = followers_r::where(['user_id' => $user_id,'followers_id' => $followers_id, 'is_deleted' => 0])->first();
                if (!is_null($get_follow)) {
                  return response()->json(["status" => false, "responseCode" => 201, "message" => "You are allready Follow this user"]);
                }else{
                    $follow_data = [];
                    $follow_data = [
                    'user_id' => $user_id,
                    'followers_id' => $followers_id
                    ];
                    $insert_followers = followers_r::create($follow_data);
                    if ($insert_followers) {
                      
                      return response()->json(["status" => true, "responseCode" => 200, "message" => "User follow successfully."]);
                        
                    }else{
                        return response()->json(["status" => false, "responseCode" => 201, "message" => "Somthing went to wrong"]); 
                    } 
                }   
              }
            
           }
         }else{
            return response()->json(["status" => false, "responseCode" => 201, "message" => "User Not exists"]); 
           } 
  
      }else{
        return response()->json(["status" => false, "responseCode" => 201, "message" => "User Not exists"]); 
      }
      
    }

    public function user_comment(Request $request)
    {
      $user_id = $request->header('userid');
      $comment_description = $request->comment_description;
      $post_id = $request->post_id;
      $parentuser_id = $request->parentuser_id;
      if ($comment_description == "") {
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter comment description id"]); 
      }
      if ($post_id == "") {
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter post id"]); 
      }

      $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first(); 
      if (!is_null($get_user)) {
          $get_post = addpost_r::where(['post_id'=>$post_id])->first();
          if (!is_null($get_post)) {
      
              $comment_data = [];
              $comment_data = [
                'comment_description' => $comment_description,
                'user_id' => $user_id,
                'post_id' => $post_id,
                // 'parentuser_id' => $parentuser_id
              ];
              $insert_comment =comment_r::create($comment_data);
              if ($insert_comment) {
                $get_comment_user = comment_r::where(['comment_id' => $insert_comment->comment_id])->first();
                if (!is_null($get_comment_user)) {

                  $get_comment_user->comment_description = ($get_comment_user->comment_description == null) ? '' : $get_comment_user->comment_description;

                  unset($get_comment_user->updated_at,$get_comment_user->created_at,$get_comment_user->deleted_at);
                  return response()->json(["status" => true, "responseCode" => 200, "message" => "Comment successfully ","data" => $get_comment_user]); 
                  
                }else{
                  return response()->json(["status" => false, "responseCode" => 201, "message" => "User Not exists"]); 
                }
              }else{
                return response()->json(["status" => false, "responseCode" => 201, "message" => "User Not exists"]); 
              }

            }else{
                return response()->json(["status" => false, "responseCode" => 201, "message" => "This post not exists"]); 
            }
        }else{
          return response()->json(["status" => false, "responseCode" => 201, "message" => "User Not exists"]); 
        }
    }
    
  public function replay_comment(Request $request)
  {
      $user_id = $request->header('userid');
      $comment_id = $request->comment_id;
      $replay_description = $request->replay_description;
      if ($comment_id == "") {
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter post id"]); 
      }
      if ($replay_description == "") {
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter replay description"]); 
      }

      $get_post = addpost_r::where(['user_id'=>$user_id])->first();
      if (!is_null($get_post)) {
        $get_comment = comment_r::where(['comment_id' => $comment_id])->first();
        if (!is_null($get_comment)) {
            $replay_data = [];
            $replay_data = [
              'replay_description' => $replay_description,
              'comment_id' => $get_comment->comment_id,
              // 'post_id' => $post_id,
              'user_id' => $user_id
            ];

            $insert_comment_replay = comment_replay::create($replay_data);
            if ($insert_comment_replay) {
            return response()->json(["status" => false, "responseCode" => 201, "message" => "Comment replay successfully"]); 

            }else{
            return response()->json(["status" => false, "responseCode" => 201, "message" => "Comment Not insert"]); 

            }

        }else{
            return response()->json(["status" => false, "responseCode" => 201, "message" => "Comment id Not exists"]); 
        }
      }else{
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Post not exists"]); 

      } 
  }
  
  public function user_like(Request $request)
  {
      $user_id = $request->header('userid');
      $post_id = $request->post_id;

      if ($post_id == "") {
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter post id"]); 
      }
      $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
      if (!is_null($get_user)) {
        $get_post = addpost_r::where(['post_id'=>$post_id])->first();
        if (!is_null($get_post)) {

          $delete_like = like_r::where(['user_id' => $user_id,'post_id'=>$post_id])->first();
          if (!is_null($delete_like)) {
              $delete_like->delete();
                $delete_like->is_like = false;
                // $get_like->is_dislike= false;
                unset($delete_like->updated_at,$delete_like->created_at,$delete_like->deleted_at,$delete_like->is_deleted,$delete_like->user_id,$delete_like->like_id,$delete_like->post_id);
              return response()->json(["status" => true, "responseCode" => 200, "message" => " User dislike successfully ","data" => $delete_like]);    
        }else{
  
            $like_data = [];
            $like_data = [
              'user_id' => $user_id,
              'post_id' => $post_id
            ];

            $insert_like = like_r::create($like_data);
            if ($insert_like) {
              $get_like = like_r::where(['like_id' => $insert_like->like_id])->first();
              if (!is_null($get_like)) {

                  $get_like->is_like = true;
                  $get_like->user_id = ($get_like->user_id == null) ? '' : $get_like->user_id;
                  $get_like->post_id = ($get_like->post_id == null) ? '' : $get_like->post_id;

                  unset($get_like->updated_at,$get_like->created_at,$get_like->deleted_at,$get_like->is_deleted,$get_like->user_id,$get_like->like_id,$get_like->post_id);
                  return response()->json(["status" => true, "responseCode" => 200, "message" => "Like successfully ","data" => $get_like]);       
              }else{
                // $get_like->is_like= false;
                return response()->json(["status" => false, "responseCode" => 201, "message" => "Somthing went wrong"]); 
              }
            }else{
              
               return response()->json(["status" => false, "responseCode" => 201, "message" => "Like not added"]); 
            }
          }
         
        }else{
          return response()->json(["status" => false, "responseCode" => 201, "message" => "Post not exists"]); 
        }

      }else{
        return response()->json(["status" => false, "responseCode" => 201, "message" => "User not exists"]); 
      }
  }

  public function getusercomment_replay(Request $request)
  {
    $user_id = $request->header('userid');
    $post_id = $request->post_id;
    if ($post_id == "") {
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Please enter post id"]); 
      
    }
    $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
    if (!is_null($get_user)) {
      /*$post_ids = [];
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
                // print_r($post_ids);die();
              }
            }
          }
      }*/

     /* $getuser_following = following_r::where(['user_id' => $get_user->user_id])->get();

      if (count($getuser_following)>0) {
          foreach ($getuser_following as $following_key => $following_value) {
            $getuser_data = user_r::where(['user_id' => $following_value->followings_id])->first();
            // print_r($getuser_data);die();
            if (!is_null($getuser_data)) {
              $getuser_post = addpost_r::where(['user_id' => $getuser_data->user_id,'is_deleted'  => 0])->get();
              if (count($getuser_post)>0) {
                foreach ($getuser_post as $getuser_post_key => $getuser_post_value) {
                  $post_ids[] = $getuser_post_value->post_id;
                  // 
                }
              }
             }
          }
      }*/

      $get_post = addpost_r::where(['post_id' => $post_id,'is_deleted' => 0])->first();
      if (!is_null($get_post)) {
      $getall_post = addpost_r::where(['post_id' => $post_id,'is_deleted' => 0])->get();
      // print_r($getall_post);die();
      if (count($getall_post)>0) {
        foreach ($getall_post as $getall_post_key => $getall_post_value) {
          $get_post_content = post_content::where(['post_id' => $getall_post_value->post_id])->get();
          $content_data = []; 
          if (count($get_post_content)>0) {
            foreach ($get_post_content as $get_content_key => $get_content_value) {
              if ($get_content_value->content_name != null && $get_content_value->content_name != "" ) {
                 $get_content_value->content_name  = asset('public/storage/Addpost').'/'.$get_content_value->content_name;
                
              }else{
                $get_content_value->content_name = "";
              }
              unset($get_content_value->created_at,$get_content_value->updated_at,$get_content_value->deleted_at,$get_content_value->is_deleted);
              $content_data [] = $get_content_value;
            }
          }

          $getpost_like = like_r::where(['post_id' =>$getall_post_value->post_id,'is_deleted' => 0])->count();

          $get_comment = comment_r::where(['post_id' => $getall_post_value->post_id])->get();
            if (count($get_comment)>0) {
              foreach ($get_comment as $get_comment_key => $get_comment_value) {
              $get_replay_comment =  comment_replay::where(['comment_id' => $get_comment_value->comment_id])->get();
                foreach ($get_replay_comment as $get_replay_comment_key => $get_replay_comment_value) {
                  unset($get_replay_comment_value->is_deleted,$get_replay_comment_value->deleted_at,$get_replay_comment_value->updated_at,$get_replay_comment_value->created_at);
                }
                $get_comment_value->comment_replay = ($get_replay_comment == null) ? '' : $get_replay_comment;
                unset($get_comment_value->is_deleted,$get_comment_value->deleted_at,$get_comment_value->updated_at,$get_comment_value->created_at);

              }
            }
          $getall_post_value->like = $getpost_like;
          $getall_post_value->comment= ($get_comment == null) ? '' : $get_comment;
          $getall_post_value->post_name = ($getall_post_value->post_name == null) ? '' : $getall_post_value->post_name;
          $getall_post_value->post_description = ($getall_post_value->post_description == null) ? '' : $getall_post_value->post_description;
          $getall_post_value->latitude = ($getall_post_value->latitude == null) ? '' : $getall_post_value->latitude;
          $getall_post_value->longitude = ($getall_post_value->longitude == null) ? '' : $getall_post_value->longitude;
          $getall_post_value->content = $content_data;
          unset($getall_post_value->created_at,$getall_post_value->updated_at,$getall_post_value->deleted_at,$getall_post_value->is_deleted);
          $all_data[] = $getall_post_value;
        }
      }
      return response()->json(["status" => true, "responseCode" => 200, "message" => "user feet get successfully ","data" => $all_data]);
      }else{
        return response()->json(["status" => false, "responseCode" => 201, "message" => "Post not exists"]); 

      }       
     
    }else{
        return response()->json(["status" => false, "responseCode" => 201, "message" => "User not exists"]); 

    }
  
  }
  public function get_following(Request $request)
  {
    $user_id = $request->header('userid');
    $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
    if (!is_null($get_user)) {
      $get_following = following_r::where(['user_id' => $get_user->user_id,'is_deleted' => 0])->get();
       $data = [];
      foreach ($get_following as $get_following_key => $get_following_value) {
        $get_user_data = user_r::where(['user_id' => $get_following_value->followings_id,'is_deleted' => 0])->orderBy('user_id','ASC')->get();
        foreach ($get_user_data as $key => $value) {
          $value->user_fullname = ($value->user_fullname == null) ? '' : $value->user_fullname;
          $value->user_email = ($value->user_email == null) ? '' : $value->user_email;

          $value->user_mobile_no = ($value->user_mobile_no == null) ? '' : $value->user_mobile_no;
          $value->user_password = ($value->user_password == null) ? '' : $value->user_password;
          $value->user_profile = ($value->user_profile == null) ? '' :asset('public/storage/upload/').'/  '.$value->user_profile;
          $value->latitude = ($value->latitude == null) ? '' : $value->latitude;
          $value->longitude = ($value->longitude == null) ? '' : $value->longitude;
          $value->device_token = ($value->device_token == null) ? '' : $value->device_token;
          $value->device_type = ($value->device_type == null) ? '' : $value->device_type;
          unset($value->created_at,$value->updated_at,$value->deleted_at,$value->is_deleted);
          $data [] = $value;
      }
    }
      return response()->json(["status" => true, "responseCode" => 200, "message" => " Following user get successfully ","data" => $data]);

         // print_r($get_user_data);die(); 
      
     
    }
  }
  
  public function get_followers(Request $request)
  {
    $user_id = $request->header('userid');
    $get_user = user_r::where(['user_id' => $user_id,'is_deleted' => 0])->first();
    if (!is_null($get_user)) {
      $get_followers = followers_r::where(['user_id' => $get_user->user_id,'is_deleted' => 0])->get();
       $data = [];
      foreach ($get_followers as $get_followerskey => $get_followers_value) {
        $get_user_data = user_r::where(['user_id' => $get_followers_value->followers_id,'is_deleted' => 0])->orderBy('user_id','ASC')->get();
        foreach ($get_user_data as $key => $value) {
          $value->user_fullname = ($value->user_fullname == null) ? '' : $value->user_fullname;
          $value->user_email = ($value->user_email == null) ? '' : $value->user_email;

          $value->user_mobile_no = ($value->user_mobile_no == null) ? '' : $value->user_mobile_no;
          $value->user_password = ($value->user_password == null) ? '' : $value->user_password;
          $value->user_profile = ($value->user_profile == null) ? '' :asset('public/storage/upload/').'/  '.$value->user_profile;
          $value->latitude = ($value->latitude == null) ? '' : $value->latitude;
          $value->longitude = ($value->longitude == null) ? '' : $value->longitude;
          $value->device_token = ($value->device_token == null) ? '' : $value->device_token;
          $value->device_type = ($value->device_type == null) ? '' : $value->device_type;
          unset($value->created_at,$value->updated_at,$value->deleted_at,$value->is_deleted,$value->user_badge);
          $data [] = $value;
      }
    }
      return response()->json(["status" => true, "responseCode" => 200, "message" => " Follow user get successfully ","data" => $data]);

         // print_r($get_user_data);die(); 
      
     
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
  

}

