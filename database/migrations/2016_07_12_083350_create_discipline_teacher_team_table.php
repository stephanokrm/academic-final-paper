<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisciplineTeacherTeamTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('discipline_teacher_team', function(Blueprint $table)
		{
			$table->integer('discipline_id')->unsigned();
			$table->foreign('discipline_id')->references('id')->on('disciplines');
			$table->index('discipline_id');
			$table->integer('team_id')->unsigned();
			$table->foreign('team_id')->references('id')->on('teams');
			$table->index('team_id');
			$table->integer('teacher_id')->unsigned();
			$table->foreign('teacher_id')->references('id')->on('teachers');
			$table->index('teacher_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('teacher_team');
	}

}
