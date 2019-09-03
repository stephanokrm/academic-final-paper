<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('events', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('event')->unique();
            $table->integer('calendar_id')->unsigned();
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('cascade');
            $table->index('calendar_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('events');
    }

}
