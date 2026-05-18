<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

// Yeni rota kaydetme (POST isteği)
Route::post('/travel-routes', [TravelRouteController::class, 'store']);

// Kullanıcıya özel rotaları getirme (GET isteği)
Route::get('/travel-routes/{userId}', [TravelRouteController::class, 'index']);

// --- SİLME ROTASI BURAYA EKLENDİ ---
// Angular tarafında servisindeki URL'yi burayla eşitlemelisin.
// Eğer servisinde 'routes/id' yazıyorsa burayı da 'routes/{id}' yap.
Route::delete('/travel-routes/{id}', [TravelRouteController::class, 'destroy']);


// --- 4. SİSTEM TEST VE YARDIMCI ROTALAR ---
Route::get('/merhaba', function () {
    return response()->json([
        'mesaj' => 'Selam Berke! Sistem tıkır tıkır çalışıyor.',
        'proje' => 'Seyahat Planlama Uygulaması',
        'durum' => 'Bağlantı Başarılı'
    ]);
});

// Giriş yapmış kullanıcının bilgilerini getirme
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});