<?php

namespace App\Http\Controllers\Api\UpdateProfile;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserUpdatePhoneCode;
use App\Models\city_of_sales_manufacturer;
use App\Models\user_category_product;
use App\Models\user_pracient_for_designer;
use Illuminate\Http\Request;
use App\Http\Requests\UpdatePasswordUserRequest;
use GreenSMS\GreenSMS;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UpdateProfileDizainerController extends Controller
{


    /**
     * @OA\Post(
     * path="api/ValidateOldNumberDesigner",
     * summary="ValidateOldNumberDesigner",
     * description="ValidateOldNumberDesigner",
     * operationId="ValidateOldNumberDesigner",
     * tags={"UpdateProfileDesigner"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="phone_code", type="text", format="text", example="+374"),
     *       @OA\Property(property="phone", type="text", format="text", example="93073584"),
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
        public function ValidateOldNumberDesigner(Request $request){
        $data = $request->all();
        if($request->phone_code = null ){
            return response()->json([
                'status' => false,
                'message' => [
                    'phone_code required'
                ],
            ], 422);
        }
        if($request->phone = null){
            return response()->json([
                'status' => false,
                'message' => [
                    'phone required'
                ],
            ], 422);
        }

            $rules=array(
                'phone'  =>"required",
                'phone_code' =>"required",
            );
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return $validator->errors();
            }

        $get_user = User::where($data)->get();


        if($get_user->isEMpty()){
            return response()->json([
                'status' => false,
                'message' => [
                    'wrong phone number'
                ],
            ], 422);
        }else{
            return response()->json([
                'status' => true,
                'message' => [
                    'number true'
                ],
            ], 200);
        }
    }

    /**
     * @OA\Post(
     * path="api/newnumberDesigner",
     * summary="newnumberDesigner",
     * description="newnumberDesigner",
     * operationId="newnumberDesigner",
     * tags={"UpdateProfileDesigner"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="phone_code", type="text", format="text", example="+374"),
     *       @OA\Property(property="phone", type="text", format="text", example="93073584"),
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


    public function newnumberDesigner(Request $request){
//        if($request->phone_code == null){
//            return response()->json([
//                'status' => false,
//                'message' => [
//                    'phone_code required'
//                ],
//            ], 422);
//        }


        if($request->phone == null){
            return response()->json([
                'status' => false,
                'message' => [
                    'phone required'
                ],
            ], 422);
        }

        $rules=array(
            'phone'  =>"required",
//            'phone_code' =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }


        $user_id = auth()->user()->id;
        $data =  $request->all();


        $get_user = User::where($data)->get();

        if(!$get_user->isEMpty()){
            return response()->json([
                'status' => false,
                'message' => [
                    'number already exists'
                ],
            ], 422);
        }

               $asd = $request->phone;
               $sendcallnumber =   preg_replace('/[^0-9]/', '', $asd);
              $client = new GreenSMS(['user' => 'EugRom1980','pass' => 'Jvcr052006']);
              $response = $client->call->send(['to' => $sendcallnumber]);


        $createTable = UserUpdatePhoneCode::create([
            'user_id' => $user_id,
          //  'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'code' => $response->code
        ]);

        if($createTable){
            return response()->json([
                'status' => true,
                'message' => [
                    'code send your phone number'
                ],
            ], 200);
        }
    }


    /**
     * @OA\Post(
     * path="api/updatePhoneNumberDesigner",
     * summary="updatePhoneNumberDesigner",
     * description="updatePhoneNumberDesigner",
     * operationId="updatePhoneNumberDesigner",
     * tags={"UpdateProfileDesigner"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="code", type="text", format="text", example="7374"),
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


    public function updatePhoneNumberDesigner(Request $request){
        $user_id = auth()->user()->id;

        $rules=array(
            'code'  =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }

        $get_phon_code_table = UserUpdatePhoneCode::where([
            'user_id' => $user_id,
            'code' => $request->code
        ])->get();

        if($get_phon_code_table->isEmpty()){
            return response()->json([
                'status' => false,
                'message' => [
                    'wrong verification code'
                ],
            ], 422);
        }
        if(!$get_phon_code_table->isEmpty()){
            $updated = User::where('id', $user_id)->update([
              //  'phone_code' =>  $get_phon_code_table[0]['phone_code'],
                'phone' => $get_phon_code_table[0]['phone'],
                'login' => $get_phon_code_table[0]['phone']
            ]);

            $delete_test_table = UserUpdatePhoneCode::where('user_id',$user_id)->delete();

            if($updated && $delete_test_table){
                return response()->json([
                    'status' => true,
                    'data' => [
                        'user' =>  auth()->user()
                    ],
                ], 200);
            }
        }
    }


    /**
     * @OA\Post(
     * path="api/UpdateProfileNameSurnameDesigner",
     * summary="UpdateProfileNameSurnameDesigner",
     * description="UpdateProfileNameSurnameDesigner",
     * operationId="UpdateProfileNameSurnameDesigner",
     * tags={"UpdateProfileDesigner"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="name", type="text", format="text", example="user"),
     *      @OA\Property(property="surname", type="text", format="text", example="useryan"),
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


    public function UpdateProfileNameSurnameDesigner(Request $request){
        $rules=array(
            'name'  =>"required",
            'surname' =>"required",
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }

        if(isset($request->name)){
            $update = User::where('id', auth()->user()->id)->update([
                'name' => $request->name
            ]);
        }if(isset($request->surname)){
            $update = User::where('id', auth()->user()->id)->update([
                'surname' => $request->surname
            ]);
        }

        if($update){
            return response()->json([
                'status' => true,
                'data' => [
                    'user' =>  auth()->user()
                ],
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'data' => [
                //     'user' =>  auth()->user()
                ],
            ], 422);
        }
    }


    /**
     * @OA\Post(
     * path="api/UpdateProfileDiplomDesigner",
     * summary="UpdateProfileDiplomDesigner",
     * description="UpdateProfileDiplomDesigner",
     * operationId="UpdateProfileDiplomDesigner",
     * tags={"UpdateProfileDesigner"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="diplom_photo", type="file", format="text", example="photo.png"),
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

    public function UpdateProfileDiplomDesigner(Request $request){





        $rules=array(
            'diplom_photo'  =>"required",

        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }


        $DiplomPhoto = $request->file('diplom_photo');


        if ($DiplomPhoto) {
            $destinationPath = 'uploads';
            $originalFile = time() . $DiplomPhoto->getClientOriginalName();
            $DiplomPhoto->storeas($destinationPath, $originalFile);
            $DiplomPhoto = $originalFile;
        }else{
            $DiplomPhoto = NULL;
        }
          if($DiplomPhoto != null){
              $update_diplom = User::where('id', auth()->user()->id)->update([
                  'diplom_photo' => $DiplomPhoto
              ]);
              if($update_diplom){
                  return response()->json([
                      'status' => true,
                      'data' => [
                          'user' =>  auth()->user()
                      ],
                  ], 200);
              }
          }
    }

}
