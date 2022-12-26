<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\NewDesignerController;
use App\Http\Controllers\Admin\NewProizvoditelController;
use App\Http\Controllers\Admin\BroneController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/noautoitifacate', function () {
    return response()->json([
        'status'=>false,
        'message' => [
            'Levon jan  Tokeni xndira'
        ],
    ],422);
})->name('noautoitifacate');


Route::prefix('admin')->group(function (){

    Route::middleware(['NoAuthUser'])->group(function () {
        Route::post('AdminLogin', [AdminLoginController::class, 'AdminLogin'])->name('AdminLogin');
        Route::get('AdminLoginView', [AdminLoginController::class, 'AdminLoginView'])->name('AdminLoginView');
    });

    Route::middleware(['AuthUser'])->group(function () {
        Route::get('/AdminHome' , [AdminHomeController::class, 'AdminHome'])->name('AdminHome');
        Route::get('/AdminLogout', [AdminLoginController::class, 'AdminLogout'])->name('AdminLogout');


        Route::get('newDesigner' , [NewDesignerController::class, 'newDesigner' ])->name('newDesigner');
        Route::get('onepageuser/designer_id={id}', [NewDesignerController::class, 'onepageuser'])->name('onepageuser');
        Route::get('activnewuser/user_id{id}', [NewDesignerController::class, 'activnewuser'])->name('activnewuser');
        Route::post('updateUserColumn', [NewDesignerController::class , 'updateUserColumn'])->name('updateUserColumn');

        Route::get('newProizvoditel', [NewProizvoditelController::class , 'newProizvoditel'])->name('newProizvoditel');
        Route::get('onepageDesigner/proizvoditel_id={id}', [NewProizvoditelController::class , 'onepageDesigner'])->name('onepageDesigner');
        Route::post('UpdateOneProizvoditel', [NewProizvoditelController::class,'UpdateOneProizvoditel'])->name('UpdateOneProizvoditel');


        Route::get('AllDesigner' , [NewDesignerController::class, 'AllDesigner'])->name('AllDesigner');
        Route::get('AllProizvoditel', [NewProizvoditelController::class, 'AllProizvoditel'])->name('AllProizvoditel');

        Route::get('OnePageProductUser/product_id={id}', [NewProizvoditelController::class, 'OnePageProductUser'])->name('OnePageProductUser');
        Route::get('deleteProductImage/image_id={id}', [NewProizvoditelController::class, 'deleteProductImage'])->name('deleteProductImage');
        Route::post('UpdateOneUserProduct', [NewProizvoditelController::class, 'UpdateOneUserProduct'])->name('UpdateOneUserProduct');


        Route::get('AllBrone', [BroneController::class, 'AllBrone'])->name('AllBrone');
        Route::get('OnePageBrone/brone_id={id}',[BroneController::class, 'OnePageBrone'])->name('OnePageBrone');


        Route::get('settingView', [AdminLoginController::class, 'settingView'])->name('settingView');
        Route::post('updatePassword', [AdminLoginController::class, 'updatePassword'])->name('updatePassword');

        Route::post('searchProizvoditel', [NewProizvoditelController::class , 'searchProizvoditel'])->name('searchProizvoditel');

        Route::post('searchDesigner' , [NewDesignerController::class, 'searchDesigner'])->name('searchDesigner');
    });



});
