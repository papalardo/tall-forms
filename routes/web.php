<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web'], function () {
    Route::post('/laravel-livewire-forms/file-upload', function () {
        return call_user_func([request()->input('component'), 'fileUpload']);
    })->name('laravel-livewire-forms.file-upload');
});

Route::section('body')->group(function () {
    Route::livewire('/', 'forms.user-form');
    // Route::livewire('/', 'form-component');
    Route::livewire('/{user}', 'forms.user-form-edit');
});

// Route::get('/', function () {
//     return view('welcome');
// });
