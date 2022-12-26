<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminUpdatePasswordRequest;
use Illuminate\Support\Facades\Hash;

class AdminLoginController extends Controller
{

    public function AdminLoginView(){
        return view('AdminView.LoginAdmin');
    }


     public function AdminLogin(AdminLoginRequest $request){
         $user = User::where('login', '=' , $request->login)->get();
         if($user->isEmpty()){
             return redirect()->route('AdminLoginView')->with('login', 'неверный логин');
         }
         if(!$user->isEmpty()){
             $user_dataa = $request->only(['login', 'password']);
             if (Auth::attempt($user_dataa)){
                 if(Auth()->user()->role_id !=1){
                     auth()->logout();
                     return view('AdminView.LoginAdmin');
                 }
                 return redirect()->route('AdminHome');
             }else{
                 return redirect()->route('AdminLoginView')->with('password', 'неверный пароль');
             }
         }
     }

     public function AdminLogout(){
        auth()->logout();

        return redirect()->route('AdminLoginView');
     }


     public function settingView(){
        return view('AdminView.AdminSettings');
     }

     public function updatePassword(AdminUpdatePasswordRequest $request){


        $user = User::where('id', auth()->user()->id)->first();
         $hash_check =  Hash::check($request->oldpassword, $user->password);


        if($hash_check == true){
            $updated_password =  User::where('id', auth()->user()->id)->update([
                'password' =>  Hash::make($request->newpassword)
            ]);
            return redirect()->back()->with('succses','succses');
         }else{
            return redirect()->back()->with('nopassword','nopassword');
        }


     }
}
