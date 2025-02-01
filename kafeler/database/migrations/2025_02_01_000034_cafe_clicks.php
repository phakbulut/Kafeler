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
        Schema::create('cafe_clicks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
            $table->string('slug'); 
            $table->year('year'); 
            $table->tinyInteger('month'); 
            $table->integer('click_count')->default(0); 
            $table->timestamps();

            // Benzersiz indeks: Aynı yıl ve ayda birden fazla kayıt olmasın
            $table->unique(['user_id', 'slug', 'year', 'month']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cafe_clicks');
    }
};
