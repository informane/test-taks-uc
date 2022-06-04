<?php

use App\Models\News;
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

Route::get('/', function () {
    return redirect('/news');
});

Route::controller(\App\Http\Controllers\NewsController::class)->group(
    function (){
        Route::get('/news/{orderBy?}/{dir?}','index');
        Route::get('/news-refresh/{months_number?}','refresh');
        Route::get('/news-edit/{news}','edit')->middleware('auth');
        Route::post('/news-update/{id}','update')->middleware('auth');
    });


Route::get('/dashboard', function () {
    return redirect('/news');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
