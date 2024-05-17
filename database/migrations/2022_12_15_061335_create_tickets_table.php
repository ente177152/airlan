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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('fio');
            $table->date('birthday');
            $table->string('passport')->nullable();
            $table->string('certificate')->nullable();
            $table->foreignIdFor(\App\Models\Flight::class)->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('seat');
            $table->float('price');
            $table->string('status')->default('оформлен');
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
        Schema::dropIfExists('tickets');
    }
};
