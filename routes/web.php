<?php

use Illuminate\Support\Facades\Route;

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


// ログイン画面表示
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login'); 

// ログイン処理
Route::post('login', 'Auth\LoginController@login'); 

// ログアウト処理  
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// ユーザー登録画面表示
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

// ユーザー登録処理
Route::post('register', 'Auth\RegisterController@register');  

// パスワードリセットリクエスト画面表示 
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

// パスワードリセット処理
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email'); 

// パスワードリセット用トークン確認画面表示
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

// パスワードリセット処理
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('products', ProductController::class);

// 商品一覧画面
Route::get('/products', 'ProductController@index')->name('products.index');

// 新規登録画面
Route::get('/products/create', 'ProductController@create')->name('products.create');

Route::get('/', function () {
    return view('welcome');
}); 

Auth::routes();

Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
});