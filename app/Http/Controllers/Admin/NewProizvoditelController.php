<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\user_category_product;
use App\Models\user_pracient_for_designer;
use App\Models\city_of_sales_manufacturer;
use App\Models\ProductProizvoditel;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class NewProizvoditelController extends Controller
{
    public function newProizvoditel(){
        $get_Proizvoditel = User::OrderBy('id', 'DESC')->where('role_id', 3)->where('active', 1)->paginate(10);


        return view('AdminView.NewProizvoditel', compact('get_Proizvoditel'));
    }


    public function onepageDesigner($id){

        $get_proizvoditel = User::where('id', $id)->get();
        $get_proizvoditel_category = user_category_product::where('user_id', $id)->get();
        $get_pracient_for_designer = user_pracient_for_designer::where('user_id', $id)->get();
        $get_city_sales = city_of_sales_manufacturer::where('user_id', $id)->get();

        $get_product = ProductProizvoditel::with('product_image_limit1')->where('user_id', $id)->get();

       
        return view('AdminView.OnePageProizvoditel', compact('get_proizvoditel',
            'get_proizvoditel_category','get_pracient_for_designer' ,'get_city_sales','get_product'));
    }

    public function UpdateOneProizvoditel(Request $request){
        $logo = $request->file('logo');
        $extract = $request->file('vipiska');



        $get_user = User::where('id', $request->user_id)->first();

        if ($logo) {
            $destinationPath = 'uploads';
            $originalFile = time() . $logo->getClientOriginalName();
            $logo->storeas($destinationPath, $originalFile);
            $logo = $originalFile;
        }else{
            $logo = $get_user->logo;
        }
        if ($extract) {
            $destinationPath = 'uploads';
            $originalFile = time() . $extract->getClientOriginalName();
            $extract->storeas($destinationPath, $originalFile);
            $extract = $originalFile;
        }else{
            $extract = $get_user->extract;
        }


        $update = User::where('id', $request->user_id) ->update([
           'logo' => $logo,
           'company_name' => $request->name,
           'surname' => $request->surname,
           'meshok' => $request->meshok,
            'phone_code' => $request->phone_code,
            'phone' => $request->phone,
            'individual_number' => $request->individual_number,
            'watsap_phone' => $request->watsap_phone,
            'made_in' => $request->made_in,
            'price_of_metr' => $request->price_of_metr,
            'saite' => $request->saite,
             'extract' => $extract,
        ]);
        if($update){
            return redirect()->back()->with('succses', 'succses');
        }
    }

    public function AllProizvoditel(){
        $get_Proizvoditel = User::OrderBy('id', 'DESC')->where('role_id', 3)->where('active', 2)->paginate(10);
        return view('AdminView.AllProizvoditel' ,compact('get_Proizvoditel'));
    }


    public function OnePageProductUser($id){
       $get_product = ProductProizvoditel::with('product_image')->where('id', $id)->get();



       return view('AdminView.OnePageUserProduct',compact('get_product'));
    }

    public function deleteProductImage($id){
       $delet_image  = ProductImage::with('user_product')->where('id',$id)->delete();

       return redirect()->back()->with('deleted','deleted');
    }

    public function UpdateOneUserProduct(Request $request){



        $logo = $request->file('logo');

        if ($logo) {
            $destinationPath = 'uploads';
            $originalFile = time() . $logo->getClientOriginalName();
            $logo->storeas($destinationPath, $originalFile);
            $logo = $originalFile;
        }

        $image_update = ProductImage::where('id', $request->image_id)->update([
            'image' => $logo
        ]);


       $update_product = ProductProizvoditel::where('id', $request->product_id)->update([
            'category_name' => $request->category_name,
           'name' => $request->name,
           'frame' => $request->frame,
           'facades' => $request->facades,
           'length' => $request->length,
           'height' => $request->height,
           'price' => $request->price,
           'tabletop' => $request->tabletop,
       ]);

       return redirect()->back()->with('succses','succses');
    }


    public function searchProizvoditel(Request $request){
        $search_proizvoditel = User::where('active', 2)->where('role_id', 3)->where('company_name', 'like',  '%' . $request->searchProizvodtel . '%')->paginate(10);
        $search_name = $request->searchProizvodtel;
        $count = $search_proizvoditel->count();

        return view('AdminView.SearchProizvoditel', compact('search_proizvoditel'  , 'search_name','count'));
    }
}
