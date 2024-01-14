<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

   public function up() {
    Schema::create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('name');
        $table->string('award');
        $table->string('category');
        $table->string('event_location');
        $table->boolean('attendance_status')->default(false);
        $table->boolean('guest')->default(false);
        $table->string('physical_condition')->nullable();
        $table->string('pdf_invitation')->nullable();
        $table->string('CURP', 18);
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
