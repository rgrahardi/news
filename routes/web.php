<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BlogController;

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
    return view('welcome');
})->name('landing');

Route::get('/home', function () {
    return view('home');
});

Route::get('/token', function (Request $request) {
    $token = $request->session()->token();

    $token = csrf_token();

    return $token;
});

// route autentikasi
Route::group(['prefix' => '/auth'], function () {
    Route::post('/login', [UserController::class, 'login'])->name('user_login');
    Route::post('/registrasi', [UserController::class, 'store'])->name('user_registrasi');
    Route::post('/logout', function () {
        Auth::logout();
        return redirect(env('FRONTEND'));
    });
    // cek status auth jika nuxt hot reload
    Route::get('/status', [UserController::class, 'status'])->name('user_status');
});

// route superadmin mengelola user
Route::group(['prefix' => '/admin/user', 'middleware' => ['auth:sanctum', 'cek_superadmin']], function () {
    Route::get('/', [UserController::class, 'index'])->name('admin_user');
    Route::get('/show/{id}', [UserController::class, 'show'])->name('admin_user_show');
    Route::post('/store', [UserController::class, 'store'])->name('admin_user_store');
    Route::post('/destroy', [UserController::class, 'destroy'])->name('admin_user_destroy');
});

// route user mengelola profilnya
Route::group(['prefix' => '/user/user', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/show/{id}', [UserController::class, 'show'])->name('user_show');
    Route::post('/store', [UserController::class, 'store'])->name('user_store');
});

// route admin mengelola blog
Route::group(['prefix' => '/admin/blog', 'middleware' => ['auth:sanctum', 'cek_admin']], function () {
    Route::get('/', [BlogController::class, 'index'])->name('admin_blog');
    Route::get('/show/{slug}', [BlogController::class, 'show'])->name('admin_blog_show');
    Route::get('/create', [BlogController::class, 'create'])->name('admin_blog_create');
    Route::post('/store', [BlogController::class, 'store'])->name('admin_blog_store');
    Route::post('/upload', [BlogController::class, 'upload'])->name('admin_blog_upload');
    Route::post('/destroy/{id}', [BlogController::class, 'destroy'])->name('admin_blog_destroy');
});

// route admin mengelola kategori
Route::group(['prefix' => '/admin/kategori', 'middleware' => ['auth:sanctum', 'cek_admin']], function () {
    Route::get('/', [KategoriController::class, 'index'])->name('admin_kategori');
    Route::get('/show/{slug}', [KategoriController::class, 'show'])->name('admin_kategori_show');
    Route::post('/store', [KategoriController::class, 'store'])->name('admin_kategori_store');
    Route::post('/destroy/{id}', [KategoriController::class, 'destroy'])->name('admin_kategori_destroy');
});

// route landing web utama
Route::group(['prefix' => '/landing'], function () {
    Route::get('/', [LandingController::class, 'index'])->name('landing');
    Route::get('/provinsi', [LandingController::class, 'provinsi'])->name('provinsi');
    Route::get('/kota/{provinsi_id}', [LandingController::class, 'kota'])->name('kota');
    Route::get('/kecamatan/{kota_id}', [LandingController::class, 'kecamatan'])->name('kecamatan');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog');
});

// route kirim email
Route::group(['prefix' => '/email'], function () {
    Route::get('/donasi', [DonasiController::class, 'email_donasi'])->name('email_donasi');
});

// route laravel file manager (lfm)
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth:sanctum']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
});

// form kirim ulang email verifikasi
Route::get('/email/verify', function () {
    return view('verify-email');
})->middleware('auth')->name('verification.notice');

// proses email verifikasi
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/verify-success');
})->middleware(['auth', 'signed'])->name('verification.verify');

// post kirim ulang email verifikasi
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return response()->json('Berhasil mengirim email verifikasi');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// halaman sukses kirim ulang email verifikasi
Route::get('/email/kirim-verifikasi', function () {
    $user = auth()->user();
    new Registered($user);
    return 'email terkirim';
});

// tampilan sukses verifikasi akun
Route::get('/verify-success', function () {
    return view('verify-success');
});

// post request lupa password link & token
Route::post('/forget-password', [UserController::class, 'forget_password'])->middleware('guest')->name('password.email');

// laman form reset password dengan token nya
Route::get('/reset-password/{token}', function ($token) {
    return view('reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// post password baru
Route::post('/reset-password', [UserController::class, 'reset_password'])->middleware('guest')->name('password.update');
