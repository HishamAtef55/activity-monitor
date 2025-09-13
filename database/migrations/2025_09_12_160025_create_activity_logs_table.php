<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->bigIncrements('id')->primary();
            $table->nullableUlidMorphs('model', 'model');
            $table->string('action')->nullable();
            $table->foreignIdFor(User::class)->constrained('users')->onDelete('cascade');           
            $table->string('ip_address');
            $table->string('user_agent')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */

    public function down()
    {
        Schema::dropIfExists('activity_logs');
    }
};
