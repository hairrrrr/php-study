<?php

use \Illuminate\Support\Arr;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TrashController;
use App\Models\Note;
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


Route::view('/', 'about');

// Route::get('/trash/{note}/edit', function(Note $note){
//     dd($note);
// });


Route::controller(NoteController::class)->group(function(){
    Route::get('/notes', 'index');
    
    Route::post('/notes', 'store')->middleware(['auth']);
    
    Route::get("/notes/create", 'create')->middleware(['auth']);
    
    Route::patch('/notes/{note}', 'update')
        ->middleware(['auth'])
        ->can('edit', 'note');
    
    Route::delete('/notes/{note}', 'destory')
        ->middleware(['auth'])
        ->can('edit', 'note');
    
    Route::get("/notes/{note}", 'show');
    
    Route::get("/notes/{note}/edit", 'edit')
        ->middleware(['auth'])
        ->can('edit', 'note');
});

Route::controller(TrashController::class)->group(function(){
    Route::get('/trash', 'index');
    
    Route::get("/trash/{id}/edit", 'edit');

    Route::patch('/trash/{id}', 'update');
    
    Route::delete('/trash/{id}', 'destory');

});



Route::controller(RegisterUserController::class)->group(function(){
    Route::get('/register', 'create');
    Route::post('/register', 'store');
});

Route::controller(SessionController::class)->group(function(){
    Route::get('/login', 'create')->name('login');
    Route::post('/login', 'store');
    Route::get('/logout', 'destory');
});

