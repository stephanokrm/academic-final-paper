<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityStudentTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('activity_student', function(Blueprint $table) {
            $table->double('grade')->nullable();
            $table->boolean('done');
            $table->boolean('returned');
            $table->integer('activity_id')->unsigned();
            $table->foreign('activity_id')->references('id')->on('activities');
            $table->index('activity_id');
            $table->integer('student_id')->unsigned();
            $table->foreign('student_id')->references('id')->on('students');
            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('activity_student');
    }

}
