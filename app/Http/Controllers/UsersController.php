
<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    public function signUp(Request $date){
        $validate = Validator::make($date->all(),
            [
                "name" => 'required',
                "surname" => 'required',
                "login" => 'required',
                "password" => 'required|min:6',
            ]);
        if($validate->fails())
        {
            return respons()->json(
                [
                    "message"=>$validate->errors(),
                ]
            );
        }
        User::create($date->all());
        return respons()->json("Good")
    }

    function signIn(Request$call){

        $validate=Validator::make($call->all(),
            [
                "login"=>'required',
                "password"=>'required',
            ]);

        if($validate->fails())
        {
            return respons()->json([
                "message"=>$validate->error(),
            ]);
        }

        $user = User::where("login",$call->login)->first();

        if($user)
        {
            if($call->password&&$user->password)
            {
                $user->api_token=Str::random(50);
                $user->save();
                return respons()->json([
                    "api_token"=>$user->api_token,
                ]);
            }
        }
return respons()->json([
            "message"=>"you are not registered!"
        ]);
    }
public function exit(Request exit){
        $user=User::where("login", exit->login)->first();
        if($user->api_token!=null)
        {
            $user->api_token=null;
        }
    }

    public function reset_password(Request$reset){
        $validator=Validator::make($reset->all(),[
            "login"=>"required",
        ]);

        $user=User::where("login",$reset->login)->first();

        if($user){
            $new_password=Validator::make($reset->all(),[
                "password"=>"required|min:6",
            ]);
            $user->password=$new_password->password;
            $user->save();
        }
    }
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}