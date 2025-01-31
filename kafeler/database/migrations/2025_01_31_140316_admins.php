<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash; 
use App\Models\Admin;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });


        // default admin koyuyorum admine genelde register sayfası yapmayı tercih etmiyorum
        Admin::create([
            'name' => 'İbrahim Akbulut',
            'email' => 'ibrahimAkbulut@cafeler.test', 
            'password' => Hash::make('cafeler.2025'), 
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
};
