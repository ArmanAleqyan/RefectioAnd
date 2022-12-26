<?php

namespace App\Http\Controllers\Api\ProizvoditelClass;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\ProductProizvoditel;
use App\Models\ProductImage;
use App\Models\city_of_sales_manufacturer;
use App\Models\user_pracient_for_designer;
use App\Models\user_category_product;
use App\Models\FavoritProizvoditel;
use Illuminate\Support\Facades\Storage;
use Validator;

class ProductProizvoditelController extends Controller
{


    /**
     * @OA\Post(
     * path="api/createnewproductProizvoditel",
     * summary="createnewproductProizvoditel",
     * description="createnewproductProizvoditel",
     * operationId="createnewproductProizvoditel",
     * tags={"AuthProducts"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="category_id", type="string", format="name", example="1"),
     *          @OA\Property(property="category_name", type="string", format="phone", example="Жилая мебель"),
     *        @OA\Property(property="name", type="string", format="phone", example="Furnitur"),
     *       @OA\Property(property="frame", type="string", format="password", example="Корпус"),
     *      @OA\Property(property="facades", type="string", format="password", example="Фасады"),
     *     @OA\Property(property="length", type="string", format="password", example="12"),
     *     @OA\Property(property="height", type="string", format="password", example="12"),
     *      @OA\Property(property="price", type="string", format="password", example="10000"),
     *       @OA\Property(property="tabletop", type="string", format="password", example="Столешница"),
     *       @OA\Property(property="photo[]", type="string", format="string", example="photo"),
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

    public function createnewproductProizvoditel(Request $request){

        $rules=array(
            'category_id' => 'required',
            'category_name' => 'required',
            'name' => 'required',
           // 'frame' => 'required',
           // 'facades' => 'required',
           // 'length' => 'required',
           // 'height' => 'required',
           // 'price' => 'required',
           // 'tabletop' => 'required',
            'photo' => 'required',
        );
        $validator=Validator::make($request->all(),$rules);
        if($validator->fails())
        {
            return $validator->errors();
        }


        $get_product_category = ProductProizvoditel::where([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id
            ])->get();
        if($get_product_category->count() >= 3){
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'you already have 3 products under this category'
                ],
            ], 422);
        }

           $data = $request->all();
           $user_id = auth()->user()->id;


        $photo = $request->photo;


         if($data){
             $create = ProductProizvoditel::create([
                 'user_id' =>  $user_id,
                 'category_id' => $request->category_id,
                 'category_name' => $request->category_name,
                 'name' => $request->name,
                 'frame' => $request->frame,
                 'facades' => $request->facades,
                 'length' => $request->length,
                 'height' => $request->height,
                 'price' => $request->price,
                 'tabletop' => $request->tabletop,
                 'material' =>  $request->material,
                 'inserciones' =>  $request->inserciones,
                 'description' => $request->description,
             ]);

             $get_category =  user_category_product::where('user_id', auth()->user()->id)->where('category_id', $request->category_id)->get();

             if($get_category->isEMpty()){
                 user_category_product::create([
                    'user_id' => auth()->user()->id,
                    'category_id' => $request->category_id,
                    'category_name' => $request->category_name
                 ]);
             }


             if($photo){

                 $time = time();
                 foreach($photo as $item){

                     if ($item) {
                         $destinationPath = 'uploads';
                         $originalFile = $time++. $item->getClientOriginalName();
                         $item->storeas($destinationPath, $originalFile);
                         $item= $originalFile;

                         $create_photo = ProductImage::create([
                             'product_id' => $create['id'],
                             'image' => $item
                         ]);
                     }
                 }

                 if($create_photo){
                     return response()->json([
                         'status' => true,
                         'data' => [
                             'message' => 'createt new product'
                         ],
                     ], 200);
                 }
             }else{
                 return response()->json([
                     'status' => false,
                     'data' => [
                         'message' => 'photo required'
                     ],
                 ], 422);
             }
         }else{
             return response()->json([
                 'status' => false,
                 'data' => [
                     'message' => 'one parametr required'
                 ],
             ], 422);
         }
    }



    /**
     * @OA\Get(
     *      path="/GetAllProduct",
     *      operationId="GetAllProduct",
     *      tags={"AuthProducts"},
     *      summary="Get all products paginate 10",
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
    public function GetAllProduct(){

        $get_product = User::with('user_product_limit1','user_category_product', 'user_product_limit1.product_image')
            ->where('role_id',3)->get();

   
        if(!$get_product->isEmpty()){
            return response()->json([
                'status' => true,
                'data' => [
                    'data' => $get_product
                ],
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'no product'
                ],
            ], 422);
        }
    }


    /**
     * @OA\Post(
     * path="api/deleteAuthUserProduct",
     * summary="deleteAuthUserProduct",
     * description="deleteAuthUserProduct",
     * operationId="deleteAuthUserProduct",
     * tags={"AuthProducts"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="product_id[]", type="string", format="name", example="1"),

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


    public function deleteAuthUserProduct(Request $request){
        foreach ($request->product_id as $item){
            $delete_product = ProductProizvoditel::where('id', $item)->delete();
            $delete_product_image = ProductImage::where('product_id', $item)->get();
            if($delete_product_image){
                foreach ($delete_product_image as $asd){
                    Storage::delete('uploads/'.$asd->image);
                }
            }
            $delete_product_image = ProductImage::where('product_id', $item)->delete();
        }
        return response()->json([
            'status' => true,
            'data' => [
                'message' => 'deleted'
            ],
        ], 200);
    }

    /**
     * @OA\Get(
     *      path="/GetAllProductOneUser",
     *      operationId="GetAllProductOneUser",
     *      tags={"Products"},
     *      summary="Get All ProductO ne User paginate 10",
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

        public function GetAllProductOneUser($limit){
                $user_id = auth()->user()->id;
                $get_product = ProductProizvoditel::with('user_product','product_image')->where('user_id' , $user_id)->limit($limit)->get();

                if(!$get_product->isEmpty()){
                return response()->json([
                    'status' => true,
                    'data' => [
                        'data' => $get_product
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'no product'
                    ],
                ], 422);
            }
        }


    /**
     * @OA\Post(
     * path="api/GetcategoryOneuserprduct",
     * summary="GetcategoryOneuserprduct",
     * description="GetcategoryOneuserprduct",
     * operationId="GetcategoryOneuserprduct",
     * tags={"Products"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="category_name", type="string", format="name", example="Кухни"),
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
    
        public function GetcategoryOneuserprduct(Request $request){
            $user_id = auth()->user()->id;

            $get_product = ProductProizvoditel::with('user_product','product_image')->where('user_id' , $user_id)->where('category_name',$request->category_name)->get();
            if(!$get_product->isEmpty()){
                return response()->json([
                    'status' => true,
                    'data' => [
                        'data' => $get_product
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'no product'
                    ],
                ], 422);
            }
        }

    /**
     * @OA\Get(
     *      path="/getOneProizvoditel/user_id{id}",
     *      operationId="getOneProizvoditel",
     *      tags={"Products"},
     *      summary="Get All ProductO one User ",
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

        public  function getOneProizvoditel($id){
            
            $get_product = ProductProizvoditel::with('product_image')->where('user_id' , $id)->get();
            $get_user = User::where('id',$id)->get();
            $get_user_city = city_of_sales_manufacturer::where('user_id', $id)->get();
            $get_user_pracient = user_pracient_for_designer::where('user_id',$id)->get();

          //  $get_user_product_category = user_category_product::where('user_id',$id)->get();
            $get_user_product_category = ProductProizvoditel::where('user_id',$id)->OrderBy('category_id', 'ASC')->distinct()->get(['category_id', 'category_name']);

            if(auth()->guard('api')->user()){
                $Favorit_button = FavoritProizvoditel::where('user_id', auth()->guard('api')->user()->id)->where('proizvoditel_id', $id)->get();
                if($Favorit_button->isEMpty()){
                    $Favorit_button =  true;
                }else{
                    $Favorit_button = false;
                }
            }else{
                $Favorit_button = 'No Show Sirt Levon jan';
            }


            if(!$get_product->isEmpty()){
                return response()->json([
                    'status' => true,
                    'data' => [
                       'Favorit_button' =>$Favorit_button,
                        'user' => $get_user,
                        'user_bonus_for_designer' => $get_user_pracient,
                        'user_category_for_product' => $get_user_product_category,
                        'city_for_sales_user' => $get_user_city,
                        'products' => $get_product
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'no product'
                    ],
                ], 422);
            }
        }


    /**
     * @OA\Post(
     * path="api/filtergetOneProizvoditel",
     * summary="filtergetOneProizvoditel",
     * description="filtergetOneProizvoditel",
     * operationId="filtergetOneProizvoditel",
     * tags={"Products"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="category_name", type="string", format="name", example="Кухни"),
     *     @OA\Property(property="user_id", type="string", format="name", example="2"),
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
        public function filtergetOneProizvoditel(Request $request){
            $user_id = $request->user_id;
            $category_name = $request->category_name;

            $get_user = User::where('id',$user_id)->get();
            $get_user_city = city_of_sales_manufacturer::where('user_id', $user_id)->get();
            $get_user_pracient = user_pracient_for_designer::where('user_id',$user_id)->get();
        //    $get_user_product_category = user_category_product::where('user_id',$user_id)->get();
            $get_user_product_category = ProductProizvoditel::where('user_id',$user_id)->OrderBy('category_id', 'ASC')->distinct()->get(['category_id', 'category_name']);
            $get_product = ProductProizvoditel::with('product_image')->where('user_id',$user_id)->where('category_name', $category_name)->get();
            
            if(!$get_product->isEmpty()){
                return response()->json([
                    'status' => true,
                    'data' => [
                        'user' => $get_user,
                        'user_bonus_for_designer' => $get_user_pracient,
                        'user_category_for_product' => $get_user_product_category,
                        'city_for_sales_user' => $get_user_city,
                        'products' => $get_product
                    ],
                ], 200);
            }else{
                return response()->json([
                    'status' => false,
                    'data' => [
                        'message' => 'no product'
                    ],
                ], 422);
            }
        }



}
