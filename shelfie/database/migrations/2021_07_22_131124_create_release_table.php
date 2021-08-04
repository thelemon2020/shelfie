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
            $table->string('genre');
            $table->string('release_year');
            $table->string('thumbnail');
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
