<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');                        // Nama lembaga
            $table->string('slug')->unique();              // URL-friendly identifier
            $table->string('email')->unique();             // Email lembaga
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('logo_path')->nullable();       // Path logo lembaga
            $table->boolean('is_active')->default(true);  // Aktif/nonaktif oleh super admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};