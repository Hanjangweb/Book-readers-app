<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\PasswordController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/',[HomeController::class,'index'])->name('home'); 
Route::get('/book/{id}',[HomeController::class,'detail'])->name('book.detail'); 
Route::post('/save-review-book',[HomeController::class,'reviewSave'])->name('book.reviewSave'); 
Route::get('/show-book-review',[HomeController::class,'showReview'])->name('book.showReview');

Route::post('/password-update}', [PasswordController::class, 'updatePassword'])->name('password.update');

Route::group(['prefix'=> 'account'], function () 
{
    Route::group(['middleware' =>'guest'],function(){

        Route::get('register',[AccountController::class,'register'])->name('account.register');
        Route::post('register',[AccountController::class,'processRegister'])->name('account.processRegister');
        Route::get('login',[AccountController::class,'login'])->name('account.login');
        Route::post('authenticate',[AccountController::class,'authenticate'])->name('account.authenticate');
    });
    Route::group(['middleware' =>'auth'],function(){

        Route::get('profile',[AccountController::class,'profile'])->name('account.profile');
        Route::get('logout',[AccountController::class,'logout'])->name('account.logout');
        Route::post('update-profile',[AccountController::class,'updateProfile'])->name('account.updateProfile');
        Route::resource('books', BookController::class,);
        Route::get('reviews',[ReviewController::class,'index'])->name('account.reviews');
        Route::get('myReview',[ReviewController::class,'myReview'])->name('account.myReview');
        Route::get('myReview-delete/{id}',[ReviewController::class,'destroy'])->name('account.destroy');
       
    });
    
});