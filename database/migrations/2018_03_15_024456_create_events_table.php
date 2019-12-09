<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->string('local', 255);
            $table->datetime('date_time_start');
            $table->datetime('date_time_end');
            $table->text('description')->nullable();
            $table->boolean('publish')->default(true);
            
            
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
        Schema::dropIfExists('events');
    }
}
