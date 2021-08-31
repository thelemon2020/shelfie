<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReleaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releases', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('artist');
            $table->string('title');
            $table->string('release_year');
            $table->string('thumbnail');
            $table->string('full_image');
            $table->integer('shelf_order')->nullable();
            $table->unsignedBigInteger('genre_id');
            $table->dateTime('last_played_at')->nullable();
            $table->unsignedBigInteger('times_played')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('release');
    }
}
