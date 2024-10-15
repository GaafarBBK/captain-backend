<?php

use App\Models\Workout;
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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Workout::class);
            $table->string('name');
            $table->string('description');
            $table->string('target_muscle');
            $table->string('equipment');
            
            $table->integer('sets');
            $table->integer('reps');

            $table->enum('status', ['Pending','Completed']);
            $table->boolean('isPublic')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
