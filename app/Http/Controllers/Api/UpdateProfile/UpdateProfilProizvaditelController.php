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


class UpdateProfilProizvaditelController extends Controller
{



    public function AuthUserProfile(){
        $user = User::with('user_pracient_for_designer','user_category_product','city_of_sales_manufacturer')->where('id', auth()->user()->id)->get();

        return response()->json([
            'status' => true,
            'data' =>  $user

        ], 200);

    }

    /**
     * @OA\Post(
     * path="api/updateProfileCompanyName",
     * summary="updateProfileCompanyName",
     * description="updateProfileCompanyName",
     * operationId="updateProfileCompanyName",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="company_name", type="string", format="name", example="justCOde"),
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


    public function updateProfileCompanyName(Request $request)
    {
        $user_id = auth()->user()->id;
        if (isset($request->company_name)) {
            $update_companyName = User::where('id', $user_id)->update([
                'company_name' => $request->company_name
            ]);

            return response()->json([
                'status' => true,
                'data' => [
                    'user' => auth()->user()
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => [
                    'company_name required'
                ],
            ], 422);
        }
    }

    /**
     * @OA\Post(
     * path="api/updateLogoProizvoditel",
     * summary="updateLogoProizvoditel",
     * description="updateLogoProizvoditel",
     * operationId="updateLogoProizvoditel",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="logo", type="file", format="file", example="photo.png"),
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

    public function updateLogoProizvoditel(Request $request)
    {
        $user_id = auth()->user()->id;
        $logo = $request->file('logo');


        if ($logo == NULL) {
            return response()->json([
                'status' => false,
                'message' => [
                    'logo required'
                ],
            ], 422);
        }

        if ($logo) {
            $destinationPath = 'uploads';
            $originalFile = time() . $logo->getClientOriginalName();
            $logo->storeas($destinationPath, $originalFile);
            $logo = $originalFile;

            $update_companyName = User::where('id', $user_id)->update([
                'logo' => $logo
            ]);

            return response()->json([
                'status' => true,
                'data' => [
                    'user' => auth()->user()
                ],
            ], 200);
        }
    }


    /**
     * @OA\Post(
     * path="api/UpdateWatsapProizvoditel",
     * summary="UpdateWatsapProizvoditel",
     * description="UpdateWatsapProizvoditel",
     * operationId="UpdateWatsapProizvoditel",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="watsap_phone", type="text", format="text", example="+37493073584"),
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

    public function UpdateWatsapProizvoditel(Request $request)
    {
        $user_id = auth()->user()->id;

        if ($request->watsap_phone == null) {
            return response()->json([
                'status' => false,
                'message' => [
                    'watsap_phone required'
                ],
            ], 422);
        }
        if ($request->watsap_phone) {
            $update_companyName = User::where('id', $user_id)->update([
                'watsap_phone' => $request->watsap_phone
            ]);
            return response()->json([
                'status' => true,
                'message' => [
                    'user' => auth()->user(),
                ],
            ], 200);
        }
    }


    /**
     * @OA\Post(
     * path="api/updateSaiteProizvaditel",
     * summary="updateSaiteProizvaditel",
     * description="updateSaiteProizvaditel",
     * operationId="updateSaiteProizvaditel",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="saite", type="url", format="url", example="www.google.com"),
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


    public function updateSaiteProizvaditel(Request $request)
    {
        $user_id = auth()->user()->id;

        if ($request->saite == null) {
            return response()->json([
                'status' => false,
                'message' => [
                    'saite required'
                ],
            ], 422);
        }

        $url = $request->saite;

        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return response()->json([
                'status' => false,
                'message' => [
                    'not as valid url'
                ],
            ], 422);
        }

        if($request->saite){
            $update_companyName = User::where('id', $user_id)->update([
                'saite' => $request->saite
            ]);
            return response()->json([
                'status'=>true,
                'message' => [
                    'user' =>   auth()->user(),
                ],
            ],200);
        }
    }

    /**
     * @OA\Post(
     * path="api/updateManeInProizvoditel",
     * summary="updateManeInProizvoditel",
     * description="updateManeInProizvoditel",
     * operationId="updateManeInProizvoditel",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="made_in", type="text", format="text", example="Armenia"),
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

    public function updateManeInProizvoditel(Request $request){
        $user_id = auth()->user()->id;

        if ($request->made_in == null) {
            return response()->json([
                'status' => false,
                'message' => [
                    'made_in required'
                ],
            ], 422);
        }

        if($request->made_in){
            $update_companyName = User::where('id', $user_id)->update([
                'made_in' => $request->made_in
            ]);
            return response()->json([
                'status'=>true,
                'message' => [
                    'user' =>   auth()->user(),
                ],
            ],200);
        }
    }

    /**
     * @OA\Post(
     * path="api/UpdateTelegramChanel",
     * summary="UpdateTelegramChanel",
     * description="UpdateTelegramChanel",
     * operationId="UpdateTelegramChanel",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="telegram", type="text", format="text", example="telegramchanel"),
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

    public function UpdateTelegramChanel(Request $request){
        $user_id = auth()->user()->id;
        if ($request->telegram == null) {
            return response()->json([
                'status' => false,
                'message' => [
                    'telegram required'
                ],
            ], 422);
        }
        
        if($request->telegram){
            $update_companyName = User::where('id', $user_id)->update([
                'telegram' => $request->telegram
            ]);
            return response()->json([
                'status'=>true,
                'message' => [
                    'user' =>   auth()->user(),
                ],
            ],200);
        }
    }


    /**
     * @OA\Post(
     * path="api/UpdateIndividualNumberProizvoditel",
     * summary="UpdateIndividualNumberProizvoditel",
     * description="UpdateIndividualNumberProizvoditel",
     * operationId="UpdateIndividualNumberProizvoditel",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="individual_number", type="text", format="text", example="4567898132"),
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

    public function UpdateIndividualNumberProizvoditel(Request $request){
        $user_id = auth()->user()->id;

        if ($request->individual_number == null) {
            return response()->json([
                'status' => false,
                'message' => [
                    'individual_number required'
                ],
            ], 422);
        }
        if($request->individual_number){
            $update_companyName = User::where('id', $user_id)->update([
                'individual_number' => $request->individual_number
            ]);
            return response()->json([
                'status'=>true,
                'message' => [
                    'user' =>   auth()->user(),
                ],
            ],200);
        }
    }


    /**
     * @OA\Post(
     * path="api/ValidateOldNumberProizvoditel",
     * summary="ValidateOldNumberProizvoditel",
     * description="ValidateOldNumberProizvoditel",
     * operationId="ValidateOldNumberProizvoditel",
     * tags={"UpdateProfileProizvaditel"},
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
    public function ValidateOldNumberProizvoditel(Request $request){
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
     * path="api/newnumberProizvoditel",
     * summary="newnumberProizvoditel",
     * description="newnumberProizvoditel",
     * operationId="newnumberProizvoditel",
     * tags={"UpdateProfileProizvaditel"},
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

        public function newnumberProizvoditel(Request $request){

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


         $user_id = auth()->user()->id;
         $data =  $request->phone;


         $get_user = User::where('phone', $data)->get();

         if(!$get_user->isEMpty()){
             return response()->json([
                 'status' => false,
                 'message' => [
                     'number already exists'
                 ],
             ], 422);
         }

               $asd = $request->phone;

//             $sendcallnumber =   preg_replace('/[^0-9]/', '', $asd);
//             $client = new GreenSMS(['user' => 'EugRom1980','pass' => 'Jvcr052006']);
//             $response = $client->call->send(['to' => $sendcallnumber]);

             $createTable = UserUpdatePhoneCode::create([
                 'user_id' => $user_id,
//            'phone_code' => $request->phone_code,
                 'phone' => $request->phone,
                 'code' => 1111
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

    public function updateCodeIntestTable(Request $request){
            $user_id = auth()->user()->id;

            $test_table = UserUpdatePhoneCode::where('user_id', $user_id)->get();

                       $asd = $test_table[0]->phone;

               $sendcallnumber =   preg_replace('/[^0-9]/', '', $asd);
              $client = new GreenSMS(['user' => 'EugRom1980','pass' => 'Jvcr052006']);
              $response = $client->call->send(['to' => $sendcallnumber]);

              $updated = UserUpdatePhoneCode::where('user_id', $user_id)->update([
                 'code' => $response->code
              ]);

//        $updated = UserUpdatePhoneCode::where('user_id', $user_id)->update([
//                 'code' => 1111
//              ]);

              if($updated){
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
     * path="api/updatePhoneNumberProizvoditel",
     * summary="updatePhoneNumberProizvoditel",
     * description="updatePhoneNumberProizvoditel",
     * operationId="updatePhoneNumberProizvoditel",
     * tags={"UpdateProfileProizvaditel"},
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


    public function updatePhoneNumberProizvoditel(Request $request){
        $user_id = auth()->user()->id;

        if($request->code == null){
            return response()->json([
                'status' => false,
                'message' => [
                    'code required'
                ],
            ], 422);
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
                //   'phone_code' =>  $get_phon_code_table[0]['phone_code'],
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
     * path="api/updatePasswordUser",
     * summary="updatePasswordUser",
     * description="updatePasswordUser",
     * operationId="updatePasswordUser",
     * tags={"updatePasswordUser"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="old_password", type="text", format="password", example="111111"),
     *  @OA\Property(property="password", type="text", format="password", example="111111"),
     *     @OA\Property(property="password_confirmation", type="text", format="password", example="111111"),
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


    public function updatePasswordUser(UpdatePasswordUserRequest $request){
            $user_id = auth()->user()->id;
            $get_user = User::where('id', $user_id)->first();
            $data = $request->all();

//            $asd = $data['old_password'] == $get_user->test_code;

            $asd = HASH::check($data['old_password'], $get_user->password);



            if($asd == false){
                return response()->json([
                    'status' => false,
                    'data' => [
                     'message' => 'wrong password'
                    ],
                ], 422);
            }
            if($asd == true){
                $update_password = User::where('id', $user_id)->update(['password' => HASH::make($request->password)]);
                if($update_password){
                    return response()->json([
                        'status' => true,
                        'data' => [
                            'message' => 'password updated',
                            'user' => auth()->user()
                        ],
                    ], 200);
                }
            }
    }

    /**
     * @OA\Post(
     * path="api/UpdategorodaProdaji",
     * summary="UpdategorodaProdaji",
     * description="UpdategorodaProdaji",
     * operationId="UpdategorodaProdaji",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="sales_city[]", type="text", format="password", example="1^Москва"),
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



    public  function UpdategorodaProdaji(Request $request){
             $data = $request->all();
             $user_id = auth()->user()->id;

           if($data == []){
               return response()->json([
                   'status' => false,
                   'data' => [
                       'message' => 'required of one parametr',
                   ],
               ], 422);
           }

        $deleet_city = city_of_sales_manufacturer::where('user_id', $user_id)->delete();
           foreach ($data['sales_city'] as $datum){
               $explode = explode(',', $datum);
               foreach ($explode as $asd){
                   $asdew = explode('^', $asd);
                   $create_sales_city = city_of_sales_manufacturer::create([
                       'user_id' => $user_id,
                       'city_id' => $asdew[0],
                       'city_name' => $asdew[1]
                   ]);
               }
           }
           
        if($create_sales_city){
            return response()->json([
                'status' => true,
                'data' => [
                    'user' => auth()->user(),
                ],
            ], 200);
        }
    }


    /**
     * @OA\Post(
     * path="api/UpdateCategoryProizvoditel",
     * summary="UpdateCategoryProizvoditel",
     * description="UpdateCategoryProizvoditel",
     * operationId="UpdateCategoryProizvoditel",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="product_category[]", type="text", format="password", example="1^Жилая мебель"),
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

    public function UpdateCategoryProizvoditel(Request $request){
        $data = $request->all();



        if($data['product_category'][0] == null){
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'required of one parametr',
                ],
            ], 422);
        }

        $delete_data = user_category_product::where('user_id', auth()->user()->id)->delete();
        foreach ($data['product_category'] as $datum) {
            $explode_category = explode(',', $datum);

            foreach ($explode_category as $er ){
                $ex = explode('^', $er);
                $create_user_product_category = user_category_product::create([
                    'user_id' => auth()->user()->id,
                    'category_id' => $ex[0],
                    'category_name' => $ex[1],
                ]);
            }
        }
        if($create_user_product_category){
            return response()->json([
                'status' => true,
                'data' => [
                    'user' => auth()->user(),
                ],
            ], 200);
        }
    }


    /**
     * @OA\Post(
     * path="api/UpdatePracentForDesigner",
     * summary="UpdatePracentForDesigner",
     * description="UpdatePracentForDesigner",
     * operationId="UpdatePracentForDesigner",
     * tags={"UpdateProfileProizvaditel"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="percent_bonus[]", type="text", format="password", example="0^10000^10"),
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


    public function UpdatePracentForDesigner(Request $request){
      $data = $request->all();


        if($data['percent_bonus'][0] == null){
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'required of one parametr',
                ],
            ], 422);
        }


        $deleet_data = user_pracient_for_designer::where('user_id',  auth()->user()->id)->delete();
        foreach ($data['percent_bonus'] as $datum){
            $explode_bonus  = explode(',', $datum);

            foreach ($explode_bonus as $asd){
                $ex = explode('^',$asd);
                $user_pracient_for_designer = user_pracient_for_designer::create([
                    'user_id' => auth()->user()->id,
                    'start_price' => $ex[0],
                    'before_price' => $ex[1],
                    'percent' => $ex[2],
                ]);
            }
        }
        if($user_pracient_for_designer){
                return response()->json([
                    'status' => true,
                    'data' => [
                       // 'user' => auth()->user(),
                    ],
                ], 200);
        }
    }
}
