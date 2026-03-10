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
        Schema::create('workdays', function (Blueprint $table) {
            $table->id();

            //foreign key for the barber
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('day');
            $table->boolean('is_open')->default(true);
            $table->time('start_time')->default('10:00:00');
            $table->time('end_time')->default('20:00:00');
            $table->timestamps();
            //this is for not having cloned appointments for the barbers
            $table->unique(['user_id', 'day']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workdays');
    }
};
