<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Laravel
                </div>

                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://blog.laravel.com">Blog</a>
                    <a href="https://nova.laravel.com">Nova</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>

<!-- if ($request->hasfile('content_name')) {
             
           $allowedfileExtension=['pdf','jpg','png'];
            $files = $request->file('content_name'); 

            foreach ($files as $file) {      

                $extension = $file->getClientOriginalExtension();

                $check = in_array($extension,$allowedfileExtension);

                if($check) {
                    foreach($request->file('content_name') as $mediaFiles) {
                        $media = new post_content();
                        $media_ext = $mediaFiles->getClientOriginalName();
                        $media_no_ext = pathinfo($media_ext, PATHINFO_FILENAME);
                        $mFiles =  $media_no_ext . '-' . rand() . '.' . $extension;
                        $mediaFiles->storeAs('public/Addpost',$mFiles);
                        $media->content_name = $mFiles;
                        $media->post_id = $add_post->post_id;
                        // $media->uploadedBy = Auth::user()->id;
                        $media->save();
                    }
                  }

                  $get_data = addpost_r::where(['post_id' => $add_post->post_id])->get();
                  $i=0;
                  foreach($get_data as $p_cat){
                    $get_data[$i]->data = $this->sub_categories($p_cat->post_id);

                        $p_cat->post_name = ($p_cat->post_name == null) ? '' : $p_cat->post_name;
                        $p_cat->post_description = ($p_cat->post_description == null) ? '' : $p_cat->post_description;
                        $p_cat->latitude = ($p_cat->latitude == null) ? '' : $p_cat->latitude;
                        $p_cat->longitude = ($p_cat->longitude == null) ? '' : $p_cat->longitude;
                      $i++; 
                       unset($p_cat->updated_at,$p_cat->created_at,$p_cat->deleted_at);
                  }                
                  return response()->json(["Status"=>true,"responseCode"=>202, "message"=>"Post Added Successfully", "data" => $get_data]);

              }
            } -->



<!-- public function add_post(Request $request)
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

          if ($request->hasfile('content_name')) {
             
           $allowedfileExtension=['pdf','jpg','png'];
            $files = $request->file('content_name'); 
            $errors = [];

            foreach ($files as $file) {      

                $extension = $file->getClientOriginalExtension();

                $check = in_array($extension,$allowedfileExtension);

                if($check) {
                    foreach($request->file('content_name') as $mediaFiles) {
                        $media = new post_content();
                        $media_ext = $mediaFiles->getClientOriginalName();
                        $media_no_ext = pathinfo($media_ext, PATHINFO_FILENAME);
                        $mFiles =  $media_no_ext . '-' . rand() . '.' . $extension;
                        $mediaFiles->storeAs('public/Addpost',$mFiles);
                        $media->content_name = $mFiles;
                        $media->post_id = $add_post->post_id;
                        // $media->uploadedBy = Auth::user()->id;
                        $media->save();
                    }
                  }

                  $get_data = addpost_r::where(['post_id' => $add_post->post_id])->get();
                  $i=0;
                  foreach($get_data as $p_cat){

                      $get_data[$i]->data = $this->sub_categories($p_cat->post_id);
                      $i++; 
                       unset($p_cat->updated_at,$p_cat->created_at,$p_cat->deleted_at);
                  }
                
                  return response()->json(["Status"=>true,"responseCode"=>202, "message"=>"This Data Selected Successfully", "data" => $get_data]);

/*
                  $get_post->post_name = ($get_post->post_name == null) ? '' : $get_post->post_name;
                  $get_post->post_description = ($get_post->post_description == null) ? '' : $get_post->post_description;
                  $get_post->latitude = ($get_post->latitude == null) ? '' : $get_post->latitude;
                  $get_post->longitude = ($get_post->longitude == null) ? '' : $get_post->longitude;
                  // $get_post->content_name  = asset('public/storage/Addpost').'/'.$get_post->content_name;

                  unset($get_post->updated_at,$get_post->deleted_at,$get_post->is_deleted);
                  return response()->json(["status" => true, "responseCode" => 200, "message" => " Post Added successfully  ", "data" => $get_post]);*/
                // } else {
                //     return response()->json(['invalid_file_format'], 422);
                // }

                // return response()->json(['file_uploaded'], 200);
              }
            }
                 /* $get_post->post_name = ($get_post->post_name == null) ? '' : $get_post->post_name;
                  $get_post->post_description = ($get_post->post_description == null) ? '' : $get_post->post_description;
                  $get_post->latitude = ($get_post->latitude == null) ? '' : $get_post->latitude;
                  $get_post->longitude = ($get_post->longitude == null) ? '' : $get_post->longitude;

                  unset($get_post->updated_at,$get_post->deleted_at,$get_post->is_deleted);
                  return response()->json(["status" => true, "responseCode" => 200, "message" => " Post Added successfully  ", "data" => $get_post]);
           */
            // else{
            //   return response()->json(["status" => false, "responseCode" => 401, "message" => "Please upload image"]);
            // }        
            }else{
                return response()->json(["status" => false, "responseCode" => 401, "message" => " Somthing went to wrong "]);
            }     
        }else{
            return response()->json(["status" => false, "responseCode" => 401, "message" => "Sorry Somthing went to wrong "]);
        }
           // }
   } -->


<!-- 
            $allowedfileExtension=['pdf','jpg','png'];
            $files = $request->file('content_name'); 

              foreach ($files as $file) {      

                $extension = $file->getClientOriginalExtension();

                $check = in_array($extension,$allowedfileExtension);

                if($check) {
                    foreach($request->file('content_name') as $image) {
                        $filename = time().'.'.$extension;
                        $image->storeAs('public/Addpost',$filename);
                         $pack_data = array(
                        'content_name' => $filename,
                        'post_id'  => $add_post->post_id
                       );
                       $insert_data[] = $pack_data;
                
                    }
                $insert_content = post_content::insert($insert_data);

                }
              }
                 
                $/*filename=time().'.'.$extention;
                 $image = $file->storeAs('public/Addpost',$filename); 
                 if ($check) {
                    for($count = 0; $count < count($filename); $count++) { 
                    
                  $pack_data = array(
                        'content_name' => $filename[$count],
                        'post_id'  => $add_post->post_id
                       );
                       $insert_data[] = $pack_data;
                }
                
                $insert_content = post_content::insert($insert_data);
                 }*/
                
               
            

          /*  $images = $request->file('content_name') ;
              $imageName = [];
              foreach ($images as $image) {
                // for ($i=0; $i <count($images) ; $i++) { 
                  # code...
                // }
                $new_name =rand().'.'.$image->getClientOriginalExtension();
                $image->storeAs('public/Addpost',$new_name);
                // $imageName = $imageName.$new_name.',';
                $imageName = [
                  'content_name' => $new_name,
                  'post_id'  => $add_post->post_id
                ];


            }
            print_r($imageName);die();
             // $imagedb[] = $imageName;

           
            $insert_content = post_content::insert($imageName);
            return response()->json($imageName);*/ -->