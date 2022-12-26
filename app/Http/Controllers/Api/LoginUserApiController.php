<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginUserRequest;

class LoginUserApiController extends Controller
{


    public function firstLogin(Request $request){
        User::where('id', auth()->user()->id)->update([
            'firstLogin' => 2
        ]);

        return response()->json([
           'status' => true,
           'message' =>  'el karas cuyc chtas  Levon jan'
        ], 200);
    }

    /**
     * @OA\Post(
     * path="api/loginuser",
     * summary="loginuser",
     * description="loginuser",
     * operationId="loginuser",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(

     *       @OA\Property(property="login", type="string", format="text", example="+37493073584"),
     *       @OA\Property(property="password", type="string", format="text", example="11111111"),
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(

     *        )
     *     )
     * )
     */

    public function loginuser(LoginUserRequest $request){

//        return \response()->json([
//           'uxarkact hamar@' =>  $request->login
//        ]);

        $login = $request->all();
        $get_user = User::where('login', $request->login)->first();





     if ($get_user != null){
         if($get_user->phone_veryfi_code !=1){
             return response()->json([
                 'status' => false,
                 'message' =>  'User@   heraxosahamari hastatum chi ancel Levon jan'
             ],422);
         }
         $user = Auth::attempt($login);

         if($user == false){
             return response()->json([
                 'status'=>false,
                 'message' => [
                     'message' => 'wrong password',
                 ],
             ],422);
         }

         if(auth()->user()->active == 1){
             $token = $get_user->createToken('Laravel Password Grant Client')->accessToken;
             return response()->json([
                 'status'=>true,
                 'message' => [
                     'message' => 'lno veryfi user',
                     'role_id' => Auth::user()->role_id,
                     'user' => $get_user,
                     'token' => $token,
                 ],
             ],200);
         }
         if($user){
             $user = Auth::attempt($login);
             $token = $get_user->createToken('Laravel Password Grant Client')->accessToken;
             return response()->json([
                 'status'=>true,
                 'message' => [
                     'message' => 'login succsesfuli',
                     'role_id' => Auth::user()->role_id,
                     'user' => $get_user,
                     'token' => $token,
                 ],
             ],200);
         }
     }else{
         return response()->json([
             'status'=>false,
             'message' => [
                 'message' => 'user does not exist',
             ],
         ],422);
     }
    }

    /**
     * @OA\Post(
     * path="api/UserLogout",
     * summary="UserLogout",
     * description="UserLogout",
     * operationId="UserLogout",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(

     *       @OA\Property(property="null", type="string", format="text", example="null"),
     *
     *
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(

     *        )
     *     )
     * )
     */



    public function UserLogout(){



        auth()->logout();



        return response()->json([
            'status'=>true,
        ],200);
    }

}
