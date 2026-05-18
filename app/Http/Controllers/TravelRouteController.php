<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TravelRoute; // Model isminin doğruluğundan emin ol

class TravelRouteController extends Controller
{
    // Mevcut index metodun (Kullanıcı rotalarını çeker)
    public function index($userId)
    {
        $routes = TravelRoute::where('user_id', $userId)->get();
        return response()->json($routes);
    }

    // Mevcut store metodun (Yeni rota kaydeder)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'title' => 'required|string',
            'city' => 'required|string',
            'start_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $route = TravelRoute::create($validated);
        return response()->json($route, 201);
    }

    // --- YENİ EKLEDİĞİMİZ SİLME METODU ---
    public function destroy($id)
    {
        // 1. Veritabanında bu ID'ye sahip rotayı ara
        $route = TravelRoute::find($id);

        // 2. Eğer rota bulunamazsa 404 hatası dön
        if (!$route) {
            return response()->json([
                'status' => 'error',
                'message' => 'Rota bulunamadı.'
            ], 404);
        }

        // 3. Rota bulunduysa silme işlemini yap
        $route->delete();

        // 4. Başarılı mesajı dön
        return response()->json([
            'status' => 'success',
            'message' => 'Rota başarıyla silindi.'
        ], 200);
    }
}