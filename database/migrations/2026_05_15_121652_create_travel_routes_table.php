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
        Schema::create('travel_routes', function (Blueprint $table) {
            $table->id();
            // Bu satır rotayı kullanıcıya bağlar (Kişiye özel olmasını sağlar)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title');          // Rota Adı
            $table->string('city');           // Gidilecek Şehir
            $table->date('start_date');       // Başlangıç Tarihi
            $table->text('description')->nullable(); // Plan Notları
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_routes');
    }
};