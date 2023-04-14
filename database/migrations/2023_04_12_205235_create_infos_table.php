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
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('referral_link')->default('');
            $table->double('Deposit_balance')->default(0);
            $table->double('interest_balance')->default(0);
            $table->double('total_invest')->default(0);
            $table->double('total_deposit')->default(0);
            $table->double('total_withdraw')->default(0);
            $table->double('referral_earning')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('infos');
    }
};
