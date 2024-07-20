<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkTimeController;
use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\EmailVerificationNotificationController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\AuthenticatedSessionController;

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

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
    Route::get('/', [WorkTimeController::class, 'index']);
    Route::post('/start-work', [WorkTimeController::class, 'startWork']);
    Route::post('/end-work', [WorkTimeController::class, 'endWork']);
    Route::post('/start-break', [WorkTimeController::class, 'startBreak']);
    Route::post('/end-break', [WorkTimeController::class, 'endBreak']);
    Route::get('/attendance', [WorkTimeController::class, 'attendance']);
    Route::get('/users', [WorkTimeController::class, 'allUsers']);
    Route::get('/user/{id}', [WorkTimeController::class, 'showUser'])->name('users.show');
});

// メール認証リマインダーページ
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// メール認証リンクの確認
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

// メール認証リンクの再送信
Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');


// ユーザー新規登録ページの表示と処理
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware(['guest'])
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware(['guest']);

// ユーザーログインページの表示と処理
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['guest'])
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(['guest']);

// ユーザーログアウト処理
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('logout');
