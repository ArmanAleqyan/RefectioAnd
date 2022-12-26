<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\updatepasswordforgot;
use GreenSMS\GreenSMS;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordApiController extends Controller
{
    /**
     * @OA\Post(
     * path="api/sendcodeforphone",
     * summary="sendcodeforphone",
     * description="sendcodeforphone",
     * operationId="sendcodeforphone",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(

     *       @OA\Property(property="phone", type="string", format="text", example="+37493073584"),
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

    public function sendcodeforphone(Request $request){
        $phone =  $request->phone;

        $get_user = User::where('phone', $phone)->get();

        if($get_user->isEmpty()){
            return response()->json([
                'status'=>false,
                'message' => [
                    'number does not exist'
                ],
            ],422);

        }

        if($get_user[0]->updated_at  >=  Carbon::now()->subMinutes(1)){
            return response()->json([
                'status'=>false,
                'data' => [
                    '1 minute ago'
                ],
            ],422);
        }


        if(isset($get_user)){

            $now = Carbon::now();
            $Given_time = $now->toDateTimeString();
            $now_completion_time = Carbon::now()->addMinute();
            $completion_time = $now_completion_time->toDateTimeString();


             $sendcallnumber =   preg_replace('/[^0-9]/', '', $get_user[0]->login);

              $client = new GreenSMS(['user' => 'EugRom1980','pass' => 'Jvcr052006']);
              $response = $client->call->send(['to' => $sendcallnumber]);


            $updateVeryfiCode = User::where('id', $get_user[0]->id)->update([
                'forgot_password_code' => $response->code,
                'updated_at' => Carbon::now(),
            ]);
            if($updateVeryfiCode){
                return response()->json([
                    'status'=>true,
                    'data' => [
                        'message' => 'code send to your phone number',
                        'Given_time' => $Given_time,
                        'completion_time' => $completion_time
                    ],
                ],200);
            }
        }
    }


    /**
     * @OA\Post(
     * path="api/resetpasswordcode",
     * summary="resetpasswordcode",
     * description="resetpasswordcode",
     * operationId="resetpasswordcode",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="phone", type="string", format="text", example="+37493073584"),
     *     @OA\Property(property="forgot_password_code", type="string", format="text", example="7894"),
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

    public function resetpasswordcode(Request $request){
        $data = $request->all();

       $get_user = User::where($data)->get();


       if($get_user->isEmpty()){
           return response()->json([
               'status'=>false,
               'message' => [
                   'message' => 'does not code',
               ],
           ],422);
       }else{
           return response()->json([
               'status'=>true,
               'message' => [
                   'message' => 'code succsesfuly',
               ],
           ],200);
       }
    }

    /**
     * @OA\Post(
     * path="api/updatepasswordforgot",
     * summary="updatepasswordforgot",
     * description="updatepasswordforgot",
     * operationId="updatepasswordforgot",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(

     *       @OA\Property(property="phone", type="string", format="text", example="93073584"),
     *     @OA\Property(property="forgot_password_code", type="string", format="text", example="7894"),
     *      @OA\Property(property="password", type="string", format="password", example="11111111"),
     *      @OA\Property(property="password_confirmation", type="string", format="password", example="11111111"),
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


    public function updatepasswordforgot(updatepasswordforgot $request){


        $data = $request->all();

        $update_password = User::where([ 'phone' => $data['phone'], 'forgot_password_code' => $data['forgot_password_code']])->update([
            'password' => Hash::make($request->password),
            'forgot_password_code' => NULL
        ]);

        if($update_password == 0){
            return response()->json([
                'success'=>false,
                'message' => [
                    'message' => 'Yan tur axper',
                ],
            ],200);
        }

        if($update_password){
            return response()->json([
                'success'=>true,
                'message' => [
                    'message' => 'password updated',
                ],
            ],200);
        }

    }



}
