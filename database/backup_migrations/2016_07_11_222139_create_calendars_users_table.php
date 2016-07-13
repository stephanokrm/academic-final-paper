<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarsUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('calendarios_usuarios', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer("calendar_id");
            $table->foreign('calendar_id')->references('id')->on('calendarios');
            $table->index('calendar_id');

            $table->integer("user_id");
            $table->foreign('user_id')->references('id_usuario')->on('usuario');
            $table->index('user_id');

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
		Schema::drop('calendarios_usuarios');
	}

}
