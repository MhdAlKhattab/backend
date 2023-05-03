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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('plan_name');
            $table->double('amount');
            $table->double('return_percent');
            $table->double('return_amount');
            $table->string('return_period');
            $table->integer('number_returned')->default(0);
            $table->integer('total_returned');
            $table->string('wallet');
            $table->longText('message')->default('Please Wait For Processing!');
            $table->integer('state')->default(0);
            $table->bigInteger('spending_time')->default(0);
            $table->dateTime('last_update')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
