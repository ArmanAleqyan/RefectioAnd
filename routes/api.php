<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DizainerApiController;
use App\Http\Controllers\Api\ManufacturerController;
use App\Http\Controllers\Api\LoginUserApiController;
use App\Http\Controllers\Api\ForgotPasswordApiController;
use App\Http\Controllers\Api\UpdateProfile\UpdateProfilProizvaditelController;
use App\Http\Controllers\Api\UpdateProfile\UpdateProfileDizainerController;
use App\Http\Controllers\Api\ProizvoditelClass\ProductProizvoditelController;
use App\Http\Controllers\Api\SearchProizvoditel\SearchController;
use App\Http\Controllers\Api\FavoritProizvoditel\FavoritProizvoditelController;
use App\Http\Controllers\Api\Book\BookController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('AllCountry' , [SearchController::class, 'AllCountry']);

Route::get('/getCityApi' , [ManufacturerController::class, 'getCityApi']);

Route::get('/getregion', [ManufacturerController::class, 'getregion']);
Route::post('/getCity', [ManufacturerController::class, 'getCity']);

Route::get('GetCountry', [SearchController::class,'GetCountry']);


Route::get('/GetProductCategory', [ManufacturerController::class, 'GetProductCategory']);

Route::post('/DizainerRegister',[DizainerApiController::class, 'DizainerRegister']);
Route::post('/RegisterManufacturerUser' , [ManufacturerController::class, 'RegisterManufacturerUser']);
Route::post('/loginuser', [LoginUserApiController::class, 'loginuser']);
Route::post('/sendcodeforphone', [ForgotPasswordApiController::class, 'sendcodeforphone']);
Route::post('/resetpasswordcode', [ForgotPasswordApiController::class,'resetpasswordcode']);
Route::post('/updatepasswordforgot', [ForgotPasswordApiController::class, 'updatepasswordforgot']);
Route::post('/UserLogout', [LoginUserApiController::class, 'UserLogout']);

Route::get('/GetAllProduct', [ProductProizvoditelController::class, 'GetAllProduct']);
Route::get('/getOneProizvoditel/user_id={id}', [ProductProizvoditelController::class, 'getOneProizvoditel']);
Route::post('/filtergetOneProizvoditel',[ProductProizvoditelController::class, 'filtergetOneProizvoditel']);

Route::post('/filterProizvoditel', [SearchController::class, 'filterProizvoditel']);

Route::post('/searchProizvoditel', [SearchController::class, 'searchProizvoditel']);






Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/GetcategoryOneuserprduct', [ProductProizvoditelController::class, 'GetcategoryOneuserprduct']);
    Route::get('AuthUserProfile', [UpdateProfilProizvaditelController::class,'AuthUserProfile']);
    Route::post('/updateProfileCompanyName',[UpdateProfilProizvaditelController::class, 'updateProfileCompanyName']);
    Route::post('/updateLogoProizvoditel' , [UpdateProfilProizvaditelController::class , 'updateLogoProizvoditel']);
    Route::post('/UpdateWatsapProizvoditel' , [UpdateProfilProizvaditelController::class , 'UpdateWatsapProizvoditel']);
    Route::post('/updateSaiteProizvaditel', [UpdateProfilProizvaditelController::class, 'updateSaiteProizvaditel']);
    Route::post('/updateManeInProizvoditel', [UpdateProfilProizvaditelController::class, 'updateManeInProizvoditel']);
    Route::post('/UpdateIndividualNumberProizvoditel', [UpdateProfilProizvaditelController::class, 'UpdateIndividualNumberProizvoditel']);
    Route::post('/ValidateOldNumberProizvoditel', [UpdateProfilProizvaditelController::class, 'ValidateOldNumberProizvoditel']);
    Route::post('/newnumberProizvoditel', [UpdateProfilProizvaditelController::class, 'newnumberProizvoditel']);
    Route::post('/updatePhoneNumberProizvoditel', [UpdateProfilProizvaditelController::class, 'updatePhoneNumberProizvoditel']);
    Route::post('/updateCodeIntestTable', [UpdateProfilProizvaditelController::class, 'updateCodeIntestTable']);
    Route::post('/updatePasswordUser', [UpdateProfilProizvaditelController::class, 'updatePasswordUser']);
    Route::post('/UpdategorodaProdaji', [UpdateProfilProizvaditelController::class, 'UpdategorodaProdaji']);
    Route::post('/UpdateCategoryProizvoditel', [UpdateProfilProizvaditelController::class, 'UpdateCategoryProizvoditel']);
    Route::post('/UpdatePracentForDesigner', [UpdateProfilProizvaditelController::class, 'UpdatePracentForDesigner']);
    Route::post('/UpdateTelegramChanel', [UpdateProfilProizvaditelController::class, 'UpdateTelegramChanel']);


    Route::post('ValidateOldNumberDesigner' , [UpdateProfileDizainerController::class,'ValidateOldNumberDesigner']);
    Route::post('/newnumberDesigner', [UpdateProfileDizainerController::class, 'newnumberDesigner']);
    Route::post('/updatePhoneNumberDesigner',[UpdateProfileDizainerController::class,'updatePhoneNumberDesigner']);
    Route::post('/UpdateProfileNameSurnameDesigner',[UpdateProfileDizainerController::class,'UpdateProfileNameSurnameDesigner']);
    Route::post('/UpdateProfileDiplomDesigner',[UpdateProfileDizainerController::class,'UpdateProfileDiplomDesigner']);



    Route::post('/createnewproductProizvoditel',[ProductProizvoditelController::class  , 'createnewproductProizvoditel']);
    Route::get('/GetAllProductOneUser/limit={limit}', [ProductProizvoditelController::class, 'GetAllProductOneUser']);
    Route::post('/deleteAuthUserProduct', [ProductProizvoditelController::class , 'deleteAuthUserProduct']);


    Route::post('/sendCallUser',[DizainerApiController::class, 'sendCallUser']);
    Route::post('/updateRegisterNumber', [DizainerApiController::class, 'updateRegisterNumber']);
    Route::post('/updateveryficode',[ManufacturerController::class, 'updateveryficode']);

    Route::post('addtoFavorit', [FavoritProizvoditelController::class, 'addtoFavorit']);
    Route::post('deleteFavoritProizvoditel', [FavoritProizvoditelController::class, 'deleteFavoritProizvoditel']);

    Route::post('/DesignerAddBook', [BookController::class, 'DesignerAddBook']);

    Route::get('GetMyBrone', [BookController::class, 'getMyBrone']);
    Route::get('/getProizvoditelmyBrone', [BookController::class, 'getProizvoditelmyBrone']);

    Route::post('/ProizvoditelUpdatestatus', [BookController::class, 'ProizvoditelUpdatestatus']);
    Route::post('/BroneProizvoditel', [BookController::class, 'BroneProizvoditel']);
    Route::get('/GetProizvoditelVoznograjdenia', [BookController::class,'GetProizvoditelVoznograjdenia']);


    Route::get('/getDizainerForProizvoditelData', [BookController::class,  'getDizainerForProizvoditelData']);
    Route::get('/getDizainerForProizvoditelDataFiltre/{id}', [BookController::class,  'getDizainerForProizvoditelDataFiltre']);

    Route::post('DeleteUserInBrone', [BookController::class, 'DeleteUserInBrone']);
    Route::post('AddUserInBrone', [BookController::class, 'AddUserInBrone']);

    Route::get('MyFavoritUser', [FavoritProizvoditelController::class, 'MyFavoritUser']);

    Route::post('firstLogin', [LoginUserApiController::class, 'firstLogin']);

});

Route::post('CetegoryForBroneProizvoditel', [BookController::class,'CetegoryForBroneProizvoditel']);


