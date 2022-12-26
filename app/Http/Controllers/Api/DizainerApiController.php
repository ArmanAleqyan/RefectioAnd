<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\DizaunerRequest;
use Illuminate\Support\Facades\Hash;
use GreenSMS\GreenSMS;


class DizainerApiController extends Controller
{

    /**
     * @OA\Post(
     * path="api/DizainerRegister",
     * summary="DizainerRegister",
     * description="DizainerRegister",
     * operationId="DizainerRegister",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="name", type="string", format="name", example="user"),
     *        @OA\Property(property="surname", type="string", format="surname", example="useryan"),
     *        @OA\Property(property="phone", type="string", format="phone", example="93457898"),
     *        @OA\Property(property="phone_code", type="string", format="phone", example="+374"),
     *       @OA\Property(property="password", type="string", format="password", example="111111"),
     *      @OA\Property(property="password_confirmation", type="string", format="password", example="111111"),
     *      @OA\Property(property="diplom_photo", type="file", format="file", example="photo.png"),
     *      @OA\Property(property="selfi_photo", type="file", format="file", example="photo.png"),
     *     @OA\Property(property="i_agree", type="string", format="I_agree", example="true"),
     *      @OA\Property(property="role_id", type="string", format="role_id", example="2"),
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
        public  function  DizainerRegister(DizaunerRequest $request){
            $first_user = User::where(['phone'=> $request->phone])->first();

            if($request->i_agree != 'true'){
                return response()->json([
                    'status'=>false,
                    'message' => [
                        'i_agree required true'
                    ],
                ],422);
            }


            if($first_user != null){

                if($first_user->phone_veryfi_code != 1 ){
                    auth::login($first_user);
                    $token = $first_user->createToken('Laravel Password Grant Client')->accessToken;
                    return \response()->json([
                        'status' => false,
                        'message' => 'user@ chi ancel hamari verifykacia',
                        'token' => $token,
                    ]);
                }

                return response()->json([
                    'status'=>false,
                    'message' => [
                        'phone arledy exist'
                    ],
                ],422);
            }
            $data = $request->all();
            $DiplomPhoto = $request->file('diplom_photo');
            $SelfiPhoto = $request->file('selfi_photo');
            $time = time();
            if ($DiplomPhoto) {
                $destinationPath = 'uploads';
                $originalFile = $time++ . $DiplomPhoto->getClientOriginalName();
                $DiplomPhoto->storeas($destinationPath, $originalFile);
                $DiplomPhoto = $originalFile;
            }else{
                $DiplomPhoto = NULL;
            }
            if($SelfiPhoto){
                $destinationPath = 'uploads';
                $originalFile = $time.$time. $SelfiPhoto->getClientOriginalName();
                $SelfiPhoto->storeas($destinationPath, $originalFile);
                $SelfiPhoto = $originalFile;
            }else{
                $SelfiPhoto = NULL;
            }
            if($DiplomPhoto && $SelfiPhoto){
                $user = User::create([
                    'login' => $data['phone'],
                    'name' => $data['name'],
                    'surname' => $data['surname'],
//                    'phone_code' => $data['phone_code'],
                    'phone' => $data['phone'],
                    'password' => Hash::make($data['password']),
                    'diplom_photo' => $DiplomPhoto,
                    'selfi_photo' => $SelfiPhoto,
                    'role_id' => 2,
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                    'message' => [
                        'error upload photo'
                    ],
                ],422);
            }
             if($user){
                 $login =   Auth::attempt(['login' => $user->login , 'password' => $request->password]);
                  $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                return response()->json([
                    'status'=>true,
                    'data' => [
                    'role_id' => Auth::user()->role_id,
                    'token' => $token,
                    'user' => $user
                    ],
                  ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message' => [
                        'User does not exist'
                    ],
                ],422);
            }
        }
    /**
     * @OA\Post(
     * path="api/sendCallUser",
     * summary="sendCallUser",
     * description="sendCallUser",
     * operationId="sendCallUser",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       @OA\Property(property="NULL", type="string", format="NULL", example="NULL"),
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

        public function sendCallUser(Request $request){
          $user = User::where('id',auth()->guard('api')->user()->id)->get();
          if(auth()->guard('api')->user()->updated_at  >=  Carbon::now()->subMinutes(1) && auth()->guard('api')->user()->phone_veryfi_code > 1){
              return response()->json([
                  'status'=>false,
                  'data' => [
                 '1 minute ago'
                  ],
              ],422);
          }
          if(isset($user)){
              $now = Carbon::now();
              $Given_time = $now->toDateTimeString();
              $now_completion_time = Carbon::now()->addMinute();
              $completion_time = $now_completion_time->toDateTimeString();
              $asd = auth()->guard('api')->user()->login;
              $sendcallnumber =   preg_replace('/[^0-9]/', '', $asd);
              $client = new GreenSMS(['user' => 'EugRom1980','pass' => 'Jvcr052006']);
              $response = $client->call->send(['to' => $sendcallnumber]);

              $updateVeryfiCode = User::where('id', auth()->guard('api')->user()->id)->update([
            'phone_veryfi_code' => $response->code,
              ]);
              if($updateVeryfiCode){
                  return response()->json([
                      'status'=>true,
                      'data' => [
                          'Given_time' => $Given_time,
                          'completion_time' => $completion_time
                      ],
                  ],200);
              }
          }
        }


    /**
     * @OA\Post(
     * path="api/updateRegisterNumber",
     * summary="updateRegisterNumber",
     * description="updateRegisterNumber",
     * operationId="updateRegisterNumber",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"PhoneCode, phone"},
     *       @OA\Property(property="PhoneCode", type="string", format="text", example="+374"),
     *       @OA\Property(property="phone", type="string", format="text", example="93789878"),
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


        public function updateRegisterNumber(Request $request){
            if(isset($request->phone, $request->PhoneCode)){
                $first_user = User::where(['phone_code' => $request->phone_code, 'phone'=> $request->phone])->first();
               if($first_user != null){
                   return response()->json([
                       'status'=>false,
                       'message' => [ 'Phone Alredi Exist'
                       ],
                   ],422);
               }
                $update_phone = User::where('id', auth()->guard('api')->user()->id)->update([
                    'phone_code' => $request->PhoneCode,
                    'phone' => $request->phone,
                    'login' => $request->PhoneCode.$request->phone
                ]);
               if($update_phone){
                   return response()->json([
                       'status'=>true,
                       'data' => [
                           'role_id' => Auth::user()->role_id,
                           'user'  => auth()->guard('api')->user()
                       ],
                   ],200);
               }
            }else{
                return response()->json([
                    'status'=>false,
                    'message' => [ 'required phone AND PhoneCode'
                    ],
                ],422);
            }
        }







}
