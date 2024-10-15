<?php

use App\Models\Meals;
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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Meals::class);
            $table->string('name');
            $table->integer('quantity')->nullable();
            $table->integer('portion');
            $table->integer('carbs');
            $table->integer('protein');
            $table->integer('calories');

            $table->boolean('isPublic')->default(false);



            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
