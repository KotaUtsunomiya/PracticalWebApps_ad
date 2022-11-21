<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;

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



Route::group(['middleware' => 'auth'], function() {
    // トップページ
    Route::get('/home', [TodoController::class, 'index'])->name('todo.index');
    // todoの登録
    route::post('/create', [TodoController::class, 'create'])->name('todo.create');
    // todoの更新
    Route::post('/update/{id}', [TodoController::class, 'update'])->name('todo.update');
    // todoの削除
    Route::delete('/destroy/{id}', [TodoController::class, 'destroy'])->name('todo.destroy');
    // 検索画面
    Route::get('/todo/find', [TodoController::class, 'find'])->name('todo.find');
    // todo検索
    route::get('/todo/search', [TodoController::class, 'search'])->name('todo.search');
});


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


require __DIR__.'/auth.php';
