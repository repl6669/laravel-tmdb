<?php

use Astrotomic\Tmdb\Models\MovieGenre;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

<<<<<<< HEAD
return new class extends Migration
=======
return new class extends Migration
>>>>>>> main
{
    public function up(): void
    {
        Schema::connection(MovieGenre::connection())->create(MovieGenre::table(), static function (Blueprint $table): void {
            $table->bigInteger('id')->unsigned()->primary();

            $table->json('name');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::connection(MovieGenre::connection())->dropIfExists(MovieGenre::table());
    }
};
