<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('email', 150)->unique();
            $table->string('image', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->softDeletes();
            $table->timestamps();
            
            $table->integer('administrator_id')->unsigned()->nullable();
            $table->foreign('administrator_id')->references('id')->on('administrators')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sponsors');
    }
}
