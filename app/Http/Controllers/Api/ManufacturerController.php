<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\City;
use App\Models\product_category;
use App\Models\city_of_sales_manufacturer;
use App\Models\user_category_product;
use App\Models\user_pracient_for_designer;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Requests\ManufacturerRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;

class ManufacturerController extends Controller
{



    public function getregion(){
        $get = DB::table('regions')->get();
        return response()->json([
            'status'=>true,
            'data' => [
                'region' =>  $get
            ],
        ],200);
    }

    public function getCity(Request $request){
        $rules=array(
            'region_id' => 'required',
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }

        $get = DB::table('cities')->where('region_id', $request->region_id)->get();

        return response()->json([
            'status'=>true,
            'data' => [
                'city' =>  $get
            ],
        ],200);
    }


    /**
     * @OA\Get(
     *      path="/getCityApi",
     *      operationId="getCityApi",
     *      tags={"getCityApi"},
     *      summary="Get list of city",
     *      description="Returns list of projects",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function getCityApi(){

        $city = DB::table('cities')->get();

        return response()->json([
            'status'=>true,
            'data' => [
              'city' =>  $city
            ],
        ],200);
    }


    /**
     * @OA\Get(
     *      path="/GetProductCategory",
     *      operationId="GetProductCategory",
     *      tags={"GetProductCategory"},
     *      summary="Get list of city",
     *      description="Returns list of projects",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     */
    public function GetProductCategory(){



        $produc_category = product_category::all();

        return response()->json([
            'status'=>true,
            'data' => [
                'city' =>  $produc_category
            ],
        ],200);
    }


    /**
     * @OA\Post(
     * path="api/RegisterManufacturerUser",
     * summary="RegisterManufacturerUser",
     * description="RegisterManufacturerUser",
     * operationId="RegisterManufacturerUser",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *     @OA\Property(property="telegram", type="string", format="telegram", example="group_name"),
     *       @OA\Property(property="company_name", type="string", format="name", example="justcode"),
     *          @OA\Property(property="phone", type="string", format="phone", example="93457898"),
     *       @OA\Property(property="password", type="string", format="password", example="111111"),
     *      @OA\Property(property="password_confirmation", type="string", format="password", example="111111"),
     *      @OA\Property(property="individual_number", type="text", format="text", example="7896847654321"),
     *      @OA\Property(property="watsap_phone", type="text", format="text", example="+37493073584"),
     *     @OA\Property(property="i_agree", type="string", format="I_agree", example="true"),
     *      @OA\Property(property="role_id", type="string", format="role_id", example="3"),
     *         @OA\Property(property="made_in", type="string", format="made_in", example="Armenia"),
     *          @OA\Property(property="price_of_metr", type="string", format="price_of_metr", example="12"),
     *         @OA\Property(property="saite", type="string", format="saite", example="www.facebook.com"),
     *          @OA\Property(property="show_room", type="string", format="show_room", example="Да . нет. все"),
     *        @OA\Property(property="logo", type="file", format="file", example="photo.png"),
     *      @OA\Property(property="percent_bonus[]", type="text", format="text", example="10000^20000^9"),
     *      @OA\Property(property="sales_city[]", type="text", format="text", example="1^москва"),
     *      @OA\Property(property="product_category[]", type="text", format="text", example="1^зал"),
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


    public  function RegisterManufacturerUser(ManufacturerRequest $request){




                $data = $request->all();

                if($data['i_agree'] != 'true'){
                    return response()->json([
                        'status'=>false,
                        'message' => [
                            'i_agree required true'
                        ],
                    ],422);
                }


//                $get_users = User::where(['company_name' => $data['company_name']])->get();
//
//                if(!$get_users->isEmpty()){
//                    return response()->json([
//                        'status'=>false,
//                        'message' => [
//                            'user exist'
//                        ],
//                    ],422);
//                }

        $logo = $request->file('logo');
        if ($logo) {
            $destinationPath = 'uploads';
            $originalFile = time() . $logo->getClientOriginalName();
            $logo->storeas($destinationPath, $originalFile);
            $logo = $originalFile;
        }else{
            $logo = NULL;
        }

        $user_get = User::where(['phone' => $request->phone])->first();
        if($user_get != null){

            if($user_get->phone_veryfi_code != 1){
                auth::login($user_get);
                $token = $user_get->createToken('Laravel Password Grant Client')->accessToken;
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
    
                $create = User::create([
                  //  'phone_veryfi_code' => 1578,
                    'login' =>$data['phone'],
                    'company_name' => $data['company_name'],
//                    'phone_code' => $data['phone_code'],
                    'phone' => $data['phone'],
                    'role_id' => $data['role_id'],
                    'individual_number' => $data['individual_number'],
                    'watsap_phone' => $data['watsap_phone'],
                    'made_in' => $data['made_in'],
                    'telegram' => $request->telegram,
                    'price_of_metr' => $data['price_of_metr'],
                    'password' => Hash::make($data['password']),
                    'saite' => $request->saite,
                    'show_room' => $request->show_room,
                    'logo' => $logo
                ]);

        $create_id  = $create['id'];


        foreach ($data['percent_bonus'] as $datum){
            $explode_bonus  = explode(',', $datum);
            foreach ($explode_bonus as $bonusss){
               $endEx = explode('^', $bonusss);
                $user_pracient_for_designer = user_pracient_for_designer::create([
                    'user_id' => $create_id,
                    'start_price' => $endEx[0],
                    'before_price' => $endEx[1],
                    'percent' => $endEx[2],
                ]);
            }
        }


     foreach ($data['sales_city'] as $sales_city){
         $explode = explode(',', $sales_city);
         foreach ($explode as $rty){
             $endRty = explode('^', $rty);

             $create_sales_city = city_of_sales_manufacturer::create([
                 'user_id' => $create_id,
                 'city_id' => $endRty[0],
                 'city_name' => $endRty[1]
             ]);

         }

     }




        foreach ($data['product_category'] as $datum) {
            $explode_category = explode(',', $datum);
            foreach ($explode_category  as $lkj){
                $endlkj =    explode('^', $lkj);
                $create_user_product_category = user_category_product::create([
                    'user_id' => $create_id,
                    'category_id' => $endlkj[0],
                    'category_name' => $endlkj[1],
                ]);
            }

          }


            if($create){
                auth::login($create);
                $token = $create->createToken('Laravel Password Grant Client')->accessToken;
                return response()->json([
                    'status'=>true,
                    'data' => [
                        'token' => $token,
                        'user' => $create
                    ],
                ],200);
            }
    }




    /**
     * @OA\Post(
     * path="api/updateveryficode",
     * summary="updateveryficode",
     * description="updateveryficode",
     * operationId="updateveryficode",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(

     *       @OA\Property(property="phone_veryfi_code", type="string", format="text", example="4587"),
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



    public function updateveryficode(Request $request){


        $get_user = User::where(['phone_veryfi_code' => $request->phone_veryfi_code , 'id' => auth()->guard('api')->user()->id])->get();

            if($get_user->isEmpty()){
                return response()->json([
                    'status'=>false,
                    'message' => [
                      'wrong verification code'
                    ],
                ],422);
            }


            if(!$get_user->isEmpty()){
                $update_code = User::where(['phone_veryfi_code' => $request->phone_veryfi_code , 'id' => auth()->guard('api')->user()->id])->update([
                    'phone_veryfi_code' => 1,
                ]);

                if($update_code){
//                   $user_toke = User::where('id' ,auth()->guard('api')->user()->id)->first();
//                    $token = $user_toke->createToken('Laravel Password Grant Client')->accessToken;
                    return response()->json([
                        'status'=>true,
                        'message' => [
                            'message' => 'update code succsesfuli',
                            'user' => $get_user,
                        ],
                    ],200);
                }
            }



    }
}
