<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');              // Otel Adı
            $table->string('city');              // Şehir
            $table->integer('price');            // Gecelik Fiyat
            $table->string('image')->nullable();  // Otel Resim URL (Boş kalabilir)
            $table->text('description')->nullable(); // Açıklama
            $table->integer('stars')->default(3); // Yıldız Sayısı (Varsayılan 3)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};