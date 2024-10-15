<?php

use App\Models\User;
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
        Schema::create('ath_body_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->enum('gender', ['male','female']);
            $table->integer('age');
            $table->integer('weight');
            $table->integer('height');
            $table->enum('ath_lvl', ['Rookie','Beginner','Intermediate','Advanced']);
            $table->enum('ath_goal', ['Gain Weight','Lose Weight','Get Fitter','Gain More Flexibility','Build Muscle']);
            $table->enum('ath_body', ['Skinny','Athletic','Muscular']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ath_body_infos');
    }
};
