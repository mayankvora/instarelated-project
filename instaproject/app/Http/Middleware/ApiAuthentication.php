<?php

namespace App\Http\Middleware;
use App\register_user as user_r;
use App\authentication_user as auth_r;


use Closure;

class ApiAuthentication
{
   
    public function handle($request, Closure $next)
    {


        $token=$request->header('token');
        $userid = $request->header('userid');

        if ($token == "" && $userid == "") {
            return response()->json(["Status"=>false,"responseCode"=>302, "message"=>"Authentication data required."]);
        }else{
            $user_token = auth_r::where(['user_id' => $userid,'unique_token' =>$token])->first();
            if (is_null($user_token)) {

                return response()->json(["Status"=>false,"responseCode"=>302, "message"=>"Authentication faild"]);
                
            }else{
                $get_user = user_r::where(['user_id' => $userid, 'is_deleted' => 0])->first();
                if(is_null($get_user)){
                    return response()->json(["Status"=>false,"responseCode"=>302, "message"=>"User not exists."]);
                }else{

                 return $next($request);
                }
            }
        }
        
    }
}