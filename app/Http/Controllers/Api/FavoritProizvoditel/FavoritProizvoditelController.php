<?php

namespace App\Http\Controllers\Api\FavoritProizvoditel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\FavoritProizvoditel;

class FavoritProizvoditelController extends Controller
{

    /**
     * @OA\Get(
     * path="api/MyFavoritUser",
     * summary="MyFavoritUser",
     * description="MyFavoritUser",
     * operationId="MyFavoritUser",
     * tags={"Favorit"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
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


    public function MyFavoritUser(){

        $favorit = FavoritProizvoditel::with('FavoritUsers','FavoritUsers.user_product_limit1','FavoritUsers.user_category_product', 'FavoritUsers.user_product_limit1.product_image')->where('user_id', auth()->user()->id)->get();


        return response()->json([
            'status' => true,
            'data' => $favorit
        ],200);
    }



    /**
     * @OA\Post(
     * path="api/addtoFavorit",
     * summary="addtoFavorit",
     * description="addtoFavorit",
     * operationId="addtoFavorit",
     * tags={"Favorit"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="user_id", type="string", format="id", example="1"),
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


    public function addtoFavorit(Request $request){

        $user_id = auth()->user()->id;
        $proizvoditel_id = $request->user_id;

        $get_favorit_table = FavoritProizvoditel::where(['user_id' => $user_id, 'proizvoditel_id' => $proizvoditel_id])->get();
        if($get_favorit_table->isEmpty()){
            FavoritProizvoditel::create([
               'user_id' => $user_id,
               'proizvoditel_id' => $proizvoditel_id,
            ]);
            return response()->json([
                'status' => true,
                'data' => [
                    'message' => 'add true'
                ],
            ], 200);

        }else{
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'you have favorit user'
                ],
            ], 422);
        }
    }



    /**
     * @OA\Post(
     * path="api/deleteFavoritProizvoditel",
     * summary="deleteFavoritProizvoditel",
     * description="deleteFavoritProizvoditel",
     * operationId="deleteFavoritProizvoditel",
     * tags={"Favorit"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="user_id", type="string", format="id", example="1"),
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
    public function deleteFavoritProizvoditel(Request $request){
        $user_id = auth()->user()->id;
        $proizvoditel_id = $request->user_id;
        $get_favorit_table = FavoritProizvoditel::where(['user_id' => $user_id, 'proizvoditel_id' => $proizvoditel_id])->get();

        if (!$get_favorit_table->isEmpty()){
            FavoritProizvoditel::where([
                'user_id' => $user_id,
                'proizvoditel_id' => $proizvoditel_id,
            ])->delete();
            return response()->json([
                'status' => true,
                'data' => [
                    'message' => 'deleted'
                ],
            ], 200);
        }else{
            return response()->json([
                'status' => false,
                'data' => [
                    'message' => 'no favorit'
                ],
            ], 422);
        }


    }

}
