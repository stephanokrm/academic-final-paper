<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarEmailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('calendar_email', function(Blueprint $table) {
            $table->integer('calendar_id')->unsigned();
            $table->foreign('calendar_id')->references('id')->on('calendars')->onDelete('cascade');
            $table->index('calendar_id');
            $table->integer('email_id')->unsigned();
            $table->foreign('email_id')->references('id')->on('emails')->onDelete('cascade');
            $table->index('email_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('calendar_email');
    }

}
