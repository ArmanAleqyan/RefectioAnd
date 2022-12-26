<?php

namespace App\Http\Controllers\Api\SearchProizvoditel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{



    public function AllCountry(){
        $country = DB::table('country')->get('nicename');

        return response()->json([
           'status' => true,
           'data'  => $country
        ],200);
    }


    public function GetCountry(){
        $county = DB::table('users')->where('made_in', '!=', null)->distinct()->get('made_in');

        $city = DB::table('city_of_sales_manufacturers')->OrderBy('city_id' , 'ASC')->distinct()->get(['city_name', 'city_id']);



        return response()->json([
            'status'=> true,
            'city_of_sales' => $city,
            'country' =>  $county
        ],200);
    }

    /**
     * @OA\Post(
     * path="api/searchProizvoditel",
     * summary="searchProizvoditel",
     * description="searchProizvoditel",
     * operationId="searchProizvoditel",
     * tags={"Search"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="company_name", type="string", format="name", example="Lait Kuxni"),
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

     public function searchProizvoditel(Request $request){

         $search_user = User::with('user_category_product','city_of_sales_manufacturer','user_product_limit1','user_product_limit1.product_image')->where('company_name','like', '%'.$request->company_name.'%')->orderBY('id','DESC')->get();

         if(!$search_user->isEmpty()){
             return response()->json([
                 'status' => true,
                 'data' => [
                     'user' => $search_user,

                 ],
             ], 200);
         }else{
             return response()->json([
                 'status' => false,
                 'data' => [
                     'message' => 'no user'
                 ],
             ], 422);
         }
     }






    /**
     * @OA\Post(
     * path="api/filterProizvoditel",
     * summary="filterProizvoditel",
     * description="filterProizvoditel",
     * operationId="filterProizvoditel",
     * tags={"Search"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *          @OA\Property(property="meshok", type="string", format="meshok", example="1 OR 2 OR 3 OR 4"),
     *       @OA\Property(property="category_name", type="string", format="name", example="kuxni"),
     *      @OA\Property(property="city_name", type="string", format="name", example="Moskva^sankt peterburg"),
     *     @OA\Property(property="made_in", type="string", format="name", example="Russia"),
     *     @OA\Property(property="show_room", type="string", format="name", example="Да, Нет"),
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

     public function filterProizvoditel(Request $request){
         $database = User::with('user_category_product','city_of_sales_manufacturer','user_product_limit1','user_product_limit1.product_image');

         if (isset($request->category_name)) {
             $explode = explode(',' ,$request->category_name);
             $database->whereHas('user_category_product',
             function($query) use($explode){
                 $query->whereIn('category_name', [$explode]);
             });
         }
         if(isset($request->city_name)){
             $city_name = $request->city_name;
                $asd = explode('^', $city_name);
             $database->whereHas('city_of_sales_manufacturer',
                 function($query )use($asd) {
                 $query->whereIn('city_name', [$asd]);
             });
         }

         if(isset($request->made_in)){
             $explode_madeIN = explode(',',$request->made_in);
             $database->wherein('made_in', $explode_madeIN);
         }

         if($request->show_room){
             $database->where('show_room', $request->show_room);
         }

         if(isset($request->bag)){
             $expolede_bag = explode(',', $request->bag);
             $database->whereIn('bag', $expolede_bag);
         }

         if(isset($request->meshok)){
             $expolede_bag2 = explode(',', $request->meshok);
             $database->wherein('meshok', $expolede_bag2);
         }


          $asd =  $database->get();

         if(!$asd->isEmpty()){
             return response()->json([
                 'status' => true,
                 'data' => [
                     'user' => $asd,

                 ],
             ], 200);
         }else{
             return response()->json([
                 'status' => false,
                 'data' => [
                     'message' => 'no user'
                 ],
             ], 422);
         }





     }


}
