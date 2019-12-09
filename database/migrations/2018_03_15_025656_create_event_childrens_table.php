<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventChildrensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_childrens', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('document')->nullable();
            $table->string('local', 255);
            $table->datetime('date_time_start');
            $table->datetime('date_time_end');
            $table->text('description')->nullable();
            $table->boolean('publish')->default(true);
            
            $table->integer('event_id')->unsigned()->nullable();
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');

            $table->integer('speaker_id')->unsigned()->nullable();
            $table->foreign('speaker_id')->references('id')->on('speakers')->onDelete('set null');
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
        Schema::dropIfExists('event_childrens');
    }
}
