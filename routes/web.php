<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web'], function () {
    Route::post('/laravel-livewire-forms/file-upload', function () {
        return call_user_func([request()->input('component'), 'fileUpload']);
    })->name('laravel-livewire-forms.file-upload');

    Route::post('/laravel-livewire-forms/rich-text-media', 'RichTextMediaUploadController@upload')->name('laravel-livewire-forms.rich-text-media');
});

Route::get('/form', 'FormController@create')->name('welcome');
Route::post('/form', 'FormController@store')->name('form.store');

Route::section('body')->group(function () {
    Route::livewire('/', 'forms.user-form');
    // Route::livewire('/', 'form-component');
    Route::livewire('/{user}', 'forms.user-form-edit');
});
