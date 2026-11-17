<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::get('/login-as/{role}', function ($role) {
    $user = User::where('role', $role)->first();
    if (!$user) {
        return "User dengan role {$role} tidak ditemukan. Pastikan sudah php artisan db:seed!";
    }
    Auth::login($user);
    return "Berhasil login sebagai: <b>{$user->name}</b> (Role: <b>{$user->role}</b>)";
});

Route::get('/logout-test', function () {
    Auth::logout();
    return "Berhasil Logout!";
});

// Route Khusus Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', fn () => 'Halaman Admin');
});

// Route Khusus Dosen
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen', fn () => 'Dashboard Dosen');
});

// Route Khusus Mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::get('/mahasiswa', fn () => 'Dashboard Mahasiswa');
});

// Route Akses Bersama (Admin & Dosen)
Route::middleware(['auth', 'role:admin,dosen'])->group(function () {
    Route::get('/kelola-materi', fn () => 'Halaman Kelola Materi');
    Route::get('/kelola-nilai', fn () => 'Halaman Kelola Nilai');
});