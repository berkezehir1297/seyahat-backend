<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel; // 1. Hotel modelini kullanabilmek için buraya ekledik

class HotelController extends Controller
{
    /**
     * Tüm otelleri listeler.
     * Bu fonksiyon Angular 'seyahat.ts' servisinden gelen isteğe cevap verir.
     */
    public function index()
    {
        // 2. Veritabanındaki tüm otelleri alıyoruz
        $hotels = Hotel::all();

        // 3. Verileri JSON formatında Angular'a gönderiyoruz
        return response()->json($hotels);
    }
}