<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {   
        Schema::create('genres', function (Blueprint $table) {
            $table->id();
            $table->string('genre');
            $table->timestamps();
        });

        Schema::create('directors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('budgets', function (Blueprint $table) {
            $table->id();
            $table->decimal('budget', 10, 2);
            $table->timestamps();
        });

        Schema::create('box_offices', function (Blueprint $table) {
            $table->id();
            $table->decimal('revenue', 10, 2);
            $table->timestamps();
        });

        Schema::create('actors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nationality')->nullable();
            $table->timestamps();
        });

        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');

            $table->foreignId('director_id')
            ->constrained('directors')
            ->onDelete('cascade');

            $table->foreignId('budget_id')
            ->constrained('budgets')
            ->onDelete('cascade');

            $table->foreignId('box_office_id')
            ->constrained('box_offices')
            ->onDelete('cascade');

            $table->date('release_year')->nullable();

            $table->timestamps();
        });

        Schema::create('genre_movie', function (Blueprint $table) {
            $table->id();

            $table->foreignId('movie_id')
            ->constrained('movies')
            ->onDelete('cascade');

            $table->foreignId('genre_id')
            ->constrained('genres')
            ->onDelete('cascade');
            
            $table->timestamps();
        });

        Schema::create('cast_movie', function (Blueprint $table) {
            $table->id();

            $table->foreignId('actor_id')
            ->constrained('actors')
            ->onDelete('cascade');

            $table->foreignId('movie_id')
            ->constrained('movies')
            ->onDelete('cascade');

            $table->string('role')->nullable();
            $table->string('character_name');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genres');
        Schema::dropIfExists('directors');
        Schema::dropIfExists('budgets');
        Schema::dropIfExists('box_offices');
        Schema::dropIfExists('actors');
        Schema::dropIfExists('casts');
        Schema::dropIfExists('movies');
        Schema::dropIfExists('movie_genres');
        Schema::dropIfExists('movie_casts');
    }
};
