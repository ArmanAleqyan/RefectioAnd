<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class NewDesignerController extends Controller
{

    public function newDesigner(){

        $get_designer = User::OrderBy('id', 'DESC')->where('active',1)->where('role_id', 2)->paginate(10);

        return view('AdminView.NewDesigner', compact('get_designer'));
            }

            public function onepageuser($id){

        $get_designer = User::where('id', $id)->get();
        return view('AdminView.OneDesignerPage', compact('get_designer'));
    }


    public function activnewuser($id){

        $update = User::where('id', $id)->update([
           'active' => 2
        ]);

        return redirect()->back()->with('ok', 'ok');
    }


    public function updateUserColumn(Request $request){
       $diplom_photo = $request->file('diplom_photo');
       $selfi_photo = $request->file('selfi_photo');
         $get_user = User::where('id', $request->user_id)->first();

        if ($diplom_photo) {
            $destinationPath = 'uploads';
            $originalFile = time() . $diplom_photo->getClientOriginalName();
            $diplom_photo->storeas($destinationPath, $originalFile);
            $diplom_photo = $originalFile;
        }else{
            $diplom_photo = $get_user->diplom_photo;
        }

        if ($selfi_photo) {
            $destinationPath = 'uploads';
            $originalFile = time() . $selfi_photo->getClientOriginalName();
            $selfi_photo->storeas($destinationPath, $originalFile);
            $selfi_photo = $originalFile;
        }else{
            $selfi_photo = $get_user->selfi_photo;
        }


        $update_photo = User::where('id' , $request->user_id)->update([
           'diplom_photo' => $diplom_photo,
            'selfi_photo' => $selfi_photo,
            'name' => $request->name,
            'surname' => $request->surname,
            'phone_code' => $request->phone_code,
            'phone' => $request->phone
        ]);
        return redirect()->back()->with('succses', 'succses');

    }


    public function AllDesigner(){
       $get_designer  =  User::OrderBy('id', 'DESC')->where('active', 2)->where('role_id', 2)->paginate(10);

       return view('AdminView.AllDesigner',compact('get_designer'));

    }

    public function searchDesigner(Request $request){
        $search_designer = User::where(['active'=> 2,'role_id' => 2 ])->where('name', 'like',  '%' . $request->searchDesigner . '%')
            ->OrWhere('surname',  'like',  '%' . $request->searchDesigner . '%')->where(['active'=> 2,'role_id' => 2 ])->paginate(10);
        $search_name = $request->searchDesigner;
        $count = $search_designer->count();


       return view('AdminView.SearchDesigner',compact('search_designer', 'search_name', 'count'));
    }
}
