<?php

namespace App\Http\Controllers\Api\Book;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Models\book;
use App\Models\BookProizvoditel;
use App\Models\OrderSuccses;
use App\Models\user_pracient_for_designer;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    /**
     * @OA\Post(
     * path="api/DeleteUserInBrone",
     * summary="DeleteUserInBrone",
     * description="DeleteUserInBrone",
     * operationId="DeleteUserInBrone",
     * tags={"DesignerBrone"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="books_id", type="string", format="books_id", example="45"),
     *        @OA\Property(property="proizvoditel_id", type="string", format="proizvoditel_id", example="121"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *
     *    description="Wrong credentials response",
     *    @OA\JsonContent(

     *        )
     *     )
     * )
     */



    public function DeleteUserInBrone(Request  $request){
        $book = BookProizvoditel::where('books_id', $request->books_id)->where('proizvoditel_id', $request->proizvoditel_id)->first();

        if($book == null){
            return response()->json([
               'status' => false,
               'message' => 'wrong data'
            ],422);
        }else{
            $book = BookProizvoditel::where('books_id', $request->books_id)->where('proizvoditel_id', $request->proizvoditel_id)->update([
               'status' => false
            ]);
        }
        $count =  BookProizvoditel::where('books_id', $request->books_id)->where('status', false)->count();


//        if($count < 1){
//            $chekbox = false;
//        }else{
//            $chekbox = true;
//        }


        return \response()->json([
           'status' => true,
            'message' => 'proizvoditel deleted',
         //   'chekbox' => $chekbox
        ]);
    }

    /**
     * @OA\Post(
     * path="api/AddUserInBrone",
     * summary="AddUserInBrone",
     * description="AddUserInBrone",
     * operationId="AddUserInBrone",
     * tags={"DesignerBrone"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="books_id", type="string", format="books_id", example="45"),
     *        @OA\Property(property="proizvoditel_id", type="string", format="proizvoditel_id", example="121"),
     *    ),
     * ),
     * @OA\Response(
     *    response=200,
     *
     *    description="Wrong credentials response",
     *    @OA\JsonContent(

     *        )
     *     )
     * )
     */

    public function AddUserInBrone(Request  $request){
        $book = BookProizvoditel::where('books_id', $request->books_id)->where('proizvoditel_id', $request->proizvoditel_id)->first();

        if($book == null){
            return response()->json([
                'status' => false,
                'message' => 'wrong data'
            ],422);
        }else{
            $book = BookProizvoditel::where('books_id', $request->books_id)->where('proizvoditel_id', $request->proizvoditel_id)->update([
                'status' => true
            ]);
        }
        $count =  BookProizvoditel::where('books_id', $request->books_id)->where('status', false)->count();

//        if($count < 1){
//            $chekbox = false;
//        }else{
//            $chekbox = true;
//        }


        return \response()->json([
            'status' => true,
            'message' => 'proizvoditel deleted',
          //  'chekbox' => $chekbox
        ]);
    }

    /**
     * @OA\Post(
     * path="api/DesignerAddBook",
     * summary="DesignerAddBook",
     * description="DesignerAddBook",
     * operationId="DesignerAddBook",
     * tags={"DesignerBrone"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="phone", type="string", format="phone", example="0930735884"),
     *        @OA\Property(property="name", type="string", format="name", example="asfd"),
     *          @OA\Property(property="dubl_phone", type="string", format="phone", example="98769846341"),
     *        @OA\Property(property="dubl_name", type="string", format="phone", example="sghdnlkjsan"),
     *       @OA\Property(property="city", type="string", format="password", example="erevan"),
     *      @OA\Property(property="category_id", type="string", format="password", example="1"),
     *     @OA\Property(property="category_name", type="string", format="password", example="Жилая мебель"),
     *     @OA\Property(property="proizvaditel_info[]", type="string", format="password", example="2^just code^10000"),
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


    public function DesignerAddBook(BookRequest $request){

        $user_id = auth()->user()->id;

        $designer_name = User::where('id', $user_id)->first();

        $create = book::create([
            'user_id' => $user_id,
           'designer_name' => $designer_name->name,
           'designer_surname' => $designer_name->surname,
           'phone' => $request->phone,
            'dubl_phone' => $request->dubl_phone,
            'name' => $request->name,
            'dubl_name' => $request->dubl_name,
            'city' => $request->city,
            'category_id' => $request->category_id,
            'category_name' => $request-> category_name,
            'status' => 1
        ]);

        $proizvaditel_info =  $request->proizvaditel_info;
        foreach ($proizvaditel_info as $item) {
            $explode =  explode(',', $item);

            foreach ($explode as $rty) {
                $sdy = explode('^', $rty);
                $book_create_proizvoditel = BookProizvoditel::create([
                    'user_id' => Auth()->user()->id,
                    'books_id' => $create['id'],
                    'proizvoditel_id' => $sdy[0],
                    'proizvoditel_name' => $sdy[1],
                    'price' => $sdy[2]
                ]);
            }



            }

        if($book_create_proizvoditel){
            return response()->json([
                'status'=>true,
                'message' => [
                    'created'
                ],
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message' => [
                    'no created'
                ],
            ],422);
        }
    }



    /**
     * @OA\Get(
     *      path="/GetMyBrone",
     *      operationId="GetMyBrone",
     *      tags={"DesignerBrone"},
     *      summary="Get list of GetMyBrone",
     *      description="Returns list of GetMyBrone",
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

    public function GetMyBrone(){
        $user_id  = auth()->user()->id;
        $get_book  = book::with('book_proizvoditel','book_proizvoditel.book_proizvoditel_user','book_proizvoditel.book_proizvoditel_user.user_pracient_for_designer')
            ->where('user_id', $user_id)->where('status', 1)->paginate(10);
                    if(!$get_book->isEmpty()){
                        return response()->json([
                            'status'=>true,
                            'data' => [
                                'auth_user' => auth()->user(),
                                'book' => $get_book
                            ],
                        ],200);
                    }else{
                        return response()->json([
                            'status'=>false,
                            'message' => [
                                'no brone'
                            ],
                        ],422);
                    }
    }



    /**
     * @OA\Post(
     * path="api/BroneProizvoditel",
     * summary="BroneProizvoditel",
     * description="BroneProizvoditel",
     * operationId="BroneProizvoditel",
     * tags={"DesignerBrone"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="books_id", type="string", format="id", example="1"),
     *     @OA\Property(property="proizvoditel_id", type="string", format="id", example="2"),
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
    public function BroneProizvoditel(Request $request){


        $user_id = auth()->user()->id;

        $get_books_proizvoditel = BookProizvoditel::where('books_id', $request->books_id)->where('proizvoditel_id' ,$request->proizvoditel_id)
            ->first();


        $get_books = Book::where('id', $request->books_id)->first();
        $get_designer = User::where('id', $get_books['user_id'])->first();



        $get_pracient =  user_pracient_for_designer::where('user_id' , $request->proizvoditel_id)
            ->where('start_price', '>=' , $get_books_proizvoditel['price'])->where('before_price', '<=', $get_books_proizvoditel['price'])->get();
        if(!$get_pracient->isEmpty()){
            $pracient =  $get_pracient[0]['percent'];
        }else{
          $pracient =  11;
        }
        $price_pracient =  $get_books_proizvoditel['price'] * $pracient / 100;


        $create_order = OrderSuccses::create([
            'books_id' => $get_books['id'],
            'designer_id' => $get_books['user_id'],
            'designer_name' =>  $get_designer['name'],
            'designer_surname' => $get_designer['surname'],
            'proizvoditel_id' => $request->proizvoditel_id,
            'category_name' => $get_books['category_name'],
            'city' => $get_books['city'],
            'name' => $get_books['name'],
            'dubl_name' => $get_books['dubl_name'],
            'phone' => $get_books['phone'],
            'dubl_phone' => $get_books['dubl_phone'],
            'price' => $get_books_proizvoditel['price'],
            'price_pracient' => $pracient,
            'pracient_price' =>   $price_pracient,
            'status' => 1
        ]);

        if($create_order){
            $update_books = Book::where('id', $request->books_id)->update(['status' => 2]);

            return response()->json([
                'status'=>true,
                'data' => [
                    'auth_user' => auth()->user(),
                    'book' => 'created'
                ],
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message' => [
                    'no created'
                ],
            ],422);
        }

    }


    /**
     * @OA\Get(
     *      path="/getProizvoditelmyBrone",
     *      operationId="getProizvoditelmyBrone",
     *      tags={"ProizvoditelBrone"},
     *      summary="Get list of GetMyBrone",
     *      description="Returns list of GetMyBrone",
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

    public function getProizvoditelmyBrone(){
       $get_my_brone = Book::with('book_proizvoditel')->whereRelation('book_proizvoditel','user_id', auth()->user()->id)->where('status',1)->get();
        if(!$get_my_brone->isEmpty()){
            return response()->json([
                'status'=>true,
                'data' => [
                    'auth_user' => auth()->user(),
                    'book' => $get_my_brone
                ],
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message' => [
                    'no brone'
                ],
            ],422);
        }
    }


    /**
     * @OA\Get(
     *      path="/GetProizvoditelVoznograjdenia",
     *      operationId="GetProizvoditelVoznograjdenia",
     *      tags={"ProizvoditelBrone"},
     *      summary="Get list of GetMyBrone",
     *      description="Returns list of GetMyBrone",
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


    public function GetProizvoditelVoznograjdenia(){
            $get_my_brone = OrderSuccses::
            where('proizvoditel_id', auth()->user()->id)->get();
            if(!$get_my_brone->isEmpty()){
                return response()->json([
                    'status'=>true,
                    'data' => [
                        'auth_user' => auth()->user(),
                        'Order' => $get_my_brone
                    ],
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message' => [
                        'no brone'
                    ],
                ],422);
            }
        }


    /**
     * @OA\Post(
     * path="api/ProizvoditelUpdatestatus",
     * summary="ProizvoditelUpdatestatus",
     * description="ProizvoditelUpdatestatus",
     * operationId="ProizvoditelUpdatestatus",
     * tags={"ProizvoditelBrone"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="order_id", type="string", format="id", example="1"),
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


        public function ProizvoditelUpdatestatus(Request $request){

            $order_id = $request->order_id;

            $update_order = OrderSuccses::where('id' , $order_id)->update([
                'status' => 2
            ]);

            if($update_order){
                return response()->json([
                    'status'=>true,
                    'data' => [
                        'Order' => 'status = 2',
                        'auth_user' => auth()->user(),
                    ],
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message' => [
                        'no succses'
                    ],
                ],422);
            }

        }


    /**
     * @OA\Get(
     *      path="/getDizainerForProizvoditelData",
     *      operationId="getDizainerForProizvoditelData",
     *      tags={"ProizvoditelBrone"},
     *      summary="Get list of GetMyBrone",
     *      description="Returns list of GetMyBrone",
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

        public function getDizainerForProizvoditelData(){


        $get_order = BookProizvoditel::where('proizvoditel_id', auth()->user()->id)->get();

        if ($get_order->isEMpty()){
            return response()->json([
                'status'=>false,
                'message' => [
                    'no brone'
                ],
            ],422);
        }
        foreach ($get_order as $item){
            $designer_id[] = $item['user_id'];
        }
            $result = array_unique($designer_id);
            foreach ($result as $item) {
                $get_designer_history[] = User::
                whereRelation('book_proizvoditel_user',  'proizvoditel_id' , auth()->user()->id)
                    ->whereRelation('book_proizvoditel_user',  'user_id' ,$item)
                    ->get('name');

                foreach ($get_designer_history as $item){
                    foreach ($item as $user_name){
                   $data[]  =    $user_name;
                    }
                }

            }
            foreach (array_unique($data) as  $name){
                $array[]['name'] =  $name['name'];
            }
            foreach ($result as $item) {
                $get_count_books_model[] = BookProizvoditel::where('user_id' , $item)->where('proizvoditel_id' ,auth()->user()->id)->count();
            }

                $i = 0;
                foreach ($get_count_books_model as $item){
                    $array[$i++]['brone_count'] = $item;
                }
            foreach ($result as $item) {
                $get_count_Moounth_books_models[] = BookProizvoditel::where('user_id' , $item)
                    ->where('proizvoditel_id' ,auth()->user()->id)
                    ->where('created_at', '>=', Carbon::now()->subMonth(3))
                    ->count();
            }
            $i = 0;
            foreach ($get_count_Moounth_books_models as $item){
                $array[$i++]['brone_3_mounth'] =  $item;
            }
            foreach ($result as $item) {
                $get_Order_count[] = OrderSuccses::where('designer_id' , $item)
                    ->where('proizvoditel_id' ,auth()->user()->id)
                    ->count();
            }
            $i = 0;
            foreach ($get_Order_count as $item){
                $array[$i++]['order'] =  $item;
            }
            foreach ($result as $item) {
                $get_Order_sum[] = OrderSuccses::where('designer_id' , $item)
                    ->where('proizvoditel_id' ,auth()->user()->id)
                    ->sum('price');
            }
            $i = 0;
            foreach ($get_Order_sum as $item){
                $array[$i++]['orders_sum'] =  $item;
            }
            foreach ($result as $item) {
                $get_Order_avg[] = OrderSuccses::where('designer_id' , $item)
                    ->where('proizvoditel_id' ,auth()->user()->id)
                    ->avg('price');
            }
            $i = 0;
            foreach ($get_Order_avg as $item){
                $array[$i++]['orders_avg'] =  $item;
            }
            if($array != null){
                return response()->json([
                    'status'=>true,
                    'data' => [
                        'Order' => $array,

                    ],
                ],200);
            }else{
                return response()->json([
                    'status'=>false,
                    'message' => [
                        'no brone'
                    ],
                ],422);
            }
//                ->withCount('book_proizvoditel_user')
//                ->withSum('user_designer_Order', 'price')
//                ->withAvg('user_designer_Order', 'price')
//                ->get();



        }

    /**
     * @OA\Get(
     *      path="/getDizainerForProizvoditelDataFiltre/1 OR 2 OR 3 ... 10",
     *      operationId="getDizainerForProizvoditelDataFiltre",
     *      tags={"ProizvoditelBrone"},
     *      summary="Get list of GetMyBroneFilter",
     *      description="Returns list of GetMyBrone
             1 = sortByDesc('brone_count'),
             2 = sortBy('brone_count'),
             3 = sortByDesc('brone_3_mounth')
             4 = sortBy('brone_3_mounth')
             5 = sortByDesc('order')
             6 =   sortby('order')
             7 = sortByDesc('orders_sum')
             8 = sortby('orders_sum')
             9 = sortByDesc('orders_avg')
             10 = sortby('orders_avg')
     ",
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


    public function getDizainerForProizvoditelDataFiltre($id){

        $get_order = BookProizvoditel::where('proizvoditel_id', auth()->user()->id)->get();

        if ($get_order->isEMpty()){
            return response()->json([
                'status'=>false,
                'message' => [
                    'no brone'
                ],
            ],422);
        }
        foreach ($get_order as $item){
            $designer_id[] = $item['user_id'];
        }
        $result = array_unique($designer_id);
        foreach ($result as $item) {
            $get_designer_history[] = User::
            whereRelation('book_proizvoditel_user',  'proizvoditel_id' , auth()->user()->id)
                ->whereRelation('book_proizvoditel_user',  'user_id' ,$item)
                ->get('name');

            foreach ($get_designer_history as $item){
                foreach ($item as $user_name){
                    $data[]  =    $user_name;
                }
            }

        }
        foreach (array_unique($data) as  $name){
            $array[]['name'] =  $name['name'];
        }
        foreach ($result as $item) {
            $get_count_books_model[] = BookProizvoditel::where('user_id' , $item)->where('proizvoditel_id' ,auth()->user()->id)->count();
        }

        $i = 0;
        foreach ($get_count_books_model as $item){
            $array[$i++]['brone_count'] = $item;
        }
        foreach ($result as $item) {
            $get_count_Moounth_books_models[] = BookProizvoditel::where('user_id' , $item)
                ->where('proizvoditel_id' ,auth()->user()->id)
                ->where('created_at', '>=', Carbon::now()->subMonth(3))
                ->count();
        }
        $i = 0;
        foreach ($get_count_Moounth_books_models as $item){
            $array[$i++]['brone_3_mounth'] =  $item;
        }
        foreach ($result as $item) {
            $get_Order_count[] = OrderSuccses::where('designer_id' , $item)
                ->where('proizvoditel_id' ,auth()->user()->id)
                ->count();
        }
        $i = 0;
        foreach ($get_Order_count as $item){
            $array[$i++]['order'] =  $item;
        }
        foreach ($result as $item) {
            $get_Order_sum[] = OrderSuccses::where('designer_id' , $item)
                ->where('proizvoditel_id' ,auth()->user()->id)
                ->sum('price');
        }
        $i = 0;
        foreach ($get_Order_sum as $item){
            $array[$i++]['orders_sum'] =  $item;
        }
        foreach ($result as $item) {
            $get_Order_avg[] = OrderSuccses::where('designer_id' , $item)
                ->where('proizvoditel_id' ,auth()->user()->id)
                ->avg('price');
        }
        $i = 0;
        foreach ($get_Order_avg as $item){
            $array[$i++]['orders_avg'] =  $item;
        }




           if($id == 1){
               $arr = collect($array)->sortByDesc('brone_count');
           }
           if($id == 2){
               $arr = collect($array)->sortBy('brone_count');
           }

           if($id == 3 ){
               $arr = collect($array)->sortByDesc('brone_3_mounth');
           }
           if($id == 4){
               $arr = collect($array)->sortBy('brone_3_mounth');
           }

           if($id == 5 ){
               $arr = collect($array)->sortByDesc('order');
           }
           if($id == 6){
               $arr = collect($array)->sortBy('order');
           }
           if($id == 7){
                  $arr = collect($array)->sortByDesc('orders_sum');
           }
           if($id == 8){
               $arr = collect($array)->sortBy('orders_sum');
           }
           if($id == 9){
               $arr = collect($array)->sortByDesc('orders_avg');
           }
           if($id == 10){
               $arr = collect($array)->sortBy('orders_avg');
           }


        if($arr != null){
            return response()->json([
                'status'=>true,
                'data' => [
                    'Order' => $arr,

                ],
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message' => [
                    'no brone'
                ],
            ],422);
        }
    }


    /**
     * @OA\Post(
     * path="api/CetegoryForBroneProizvoditel",
     * summary="CetegoryForBroneProizvoditel",
     * description="CetegoryForBroneProizvoditel",
     * operationId="CetegoryForBroneProizvoditel",
     * tags={"ProizvoditelBrone"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"NULL"},
     *       @OA\Property(property="category_id", type="string", format="id", example="1"),
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

    public function CetegoryForBroneProizvoditel(Request $request){
        $category_id = $request->category_id;

        $get = DB::table('user_category_products')->where('category_id', $request->category_id)->get('user_id');


        foreach ($get as $user_id => $value){
        $user[] = User::where('id', $value->user_id)->get(['id','company_name']);
        }


       // dd($user);

        return \response()->json([
           'status' => true,
           'data' => $user
        ],200);



    }






}
