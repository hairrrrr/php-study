<?php

use \Illuminate\Support\Arr;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\TrashController;
use App\Models\Note;
use Illuminate\Support\Facades\Route;


Route::view('/', 'about');


Route::controller(NoteController::class)->group(function(){
    Route::get('/notes', 'index');
    
    Route::post('/notes', 'store');
    
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

    Route::post("/notes/{note}/duplicate", 'duplicate')
        ->middleware(['auth'])
        ->can('edit', 'note');
});

Route::controller(TrashController::class)->group(function(){
    Route::get('/trash', 'index');
    
    Route::get("/trash/{id}/edit", 'edit')
        ->middleware(['auth'])
        ->can('trash', 'id');

    Route::patch('/trash/{id}', 'update')
        ->middleware(['auth'])
        ->can('trash', 'id');
    
    Route::delete('/trash/{id}', 'destory')
        ->middleware(['auth'])
        ->can('trash', 'id');
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


