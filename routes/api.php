<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan; // <-- Burayı ekledik, yoksa temizleme rotası patlar!
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\TravelRouteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- 1. KİMLİK DOĞRULAMA (Auth) ---
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// --- 2. OTELLER ---
Route::get('/hotels', [HotelController::class, 'index']);

// --- 3. SEYAHAT ROTALARI (Kişiye Özel) ---
Route::post('/travel-routes', [TravelRouteController::class, 'store']);
Route::get('/travel-routes/{userId}', [TravelRouteController::class, 'index']);
Route::delete('/travel-routes/{id}', [TravelRouteController::class, 'destroy']);

// --- 4. SİSTEM TEST VE YARDIMCI ROTALAR ---
Route::get('/merhaba', function () {
    return response()->json([
        'mesaj' => 'Selam Berke! Sistem tıkır tıkır çalışıyor.',
        'proje' => 'Seyahat Planlama Uygulaması',
        'durum' => 'Bağlantı Başarılı'
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Sunucu önbelleğini sıfırlamak için kullandığımız rota
Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear'); // Rota önbelleğini de temizleyelim ki POST hatası kalmasın
    return "Sunucu önbelleği başarıyla temizlendi!";
});