<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_city_id')->references('id')->on('cities')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('to_city_id')->references('id')->on('cities')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('from_airport_id')->references('id')->on('airports')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('to_airport_id')->references('id')->on('airports')->cascadeOnUpdate()->cascadeOnDelete();
            $table->date('date_from');
            $table->time('time_from');
            $table->date('date_to');
            $table->time('time_to');
            $table->time('timeWay');
            $table->float('percentPrice');
            $table->foreignIdFor(\App\Models\Airplane::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('status')->default('готов');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }
};
