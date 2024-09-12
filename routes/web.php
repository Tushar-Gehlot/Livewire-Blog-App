<?php

use App\Livewire\Auth\ChangePassword;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Auth\Logout;
use App\Livewire\Auth\PasswordReset;
use App\Livewire\Auth\PasswordResetRequest;
use App\Livewire\Posts\PostCreate;
use App\Livewire\Posts\PostEdit;
use App\Livewire\Posts\PostIndex;
use App\Livewire\Profile\Profile;
use App\Livewire\UserManagement\Userslist;
use App\Livewire\UserManagement\CreateUser;

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
    Route::get('/logout', Logout::class)->name('logout');
    Route::get('/create-user',CreateUser::class)->name('create.user');
    Route::get('password/reset/{token}/{email}', PasswordReset::class)->name('password.reset');
    Route::get('password/reset', PasswordResetRequest::class)->name('password.request');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/change-password', ChangePassword::class)->name('change-password');
    Route::get('/posts',PostIndex::class)->name('posts.index');
    Route::get('/posts/create', PostCreate::class)->name('post.create');
    Route::get('/posts/edit/{id}', PostEdit::class)->name('post.edit');
});
