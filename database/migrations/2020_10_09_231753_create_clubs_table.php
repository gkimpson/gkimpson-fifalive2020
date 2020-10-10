<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->id();
            $table->integer('league_id')->nullable()->unsigned();
            $table->string('name');
            $table->integer('defence')->unsigned();
            $table->integer('midfield')->unsigned();
            $table->integer('attack')->unsigned();
            $table->integer('overall')->unsigned();
            $table->string('logo')->nullable();
            $table->string('alt_logos')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clubs');
    }
}
