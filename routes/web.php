<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Auth\Logout;
use App\Livewire\Userslist;

Route::get('/', function () {
    return redirect()->to('/login');
});

Route::group(['middleware'=>'guest'], function(){
    Route::get('/register', Register::class)->name('register');
    Route::get('/login', Login::class)->name('login');
});

Route::group(['middleware'=>'auth'], function(){
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/users', Userslist::class)->name('get.users');
    Route::get('/all/users', [Userslist::class, 'userList'])->name('all.users');
    Route::get('/logout', Logout::class)->name('logout');
});
