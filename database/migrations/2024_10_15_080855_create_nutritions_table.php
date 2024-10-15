<?php

use App\Models\Captain;
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
        Schema::create('nutritions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Captain::class);
            $table->foreignIdFor(User::class);
            $table->date('date');

            $table->integer('total_calories');
            $table->integer('total_protein');
            $table->integer('total_carbs');

            $table->string('notes')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutritions');
    }
};
