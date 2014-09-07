<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @param Blueprint $table
	 * @return void
	 */
	public function up()
	{
		Schema::create('students', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email');
			$table->integer('score');
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
		Schema::drop('students');
	}

}
