<?php

use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('users', function ($table) {

			$table->engine = 'InnoDB';

			$table->increments('id')->unsigned();
			$table->boolean('activated')->default(0);
			$table->boolean('disabled')->default(0);
			$table->string('email')->unique()->nullable()->default(null);
			$table->string('name_first', 64);
			$table->string('name_last', 64);
			$table->string('name_nick', 64)->unique()->nullable()->default(null);
			$table->string('id_facebook');
			$table->string('id_google');
			$table->string('id_twitter');
			$table->string('authKey', 255)->nullable()->default(null);
			$table->string('uniqueKey', 255)->unique()->nullable()->default(null);
			$table->string('remember_token', 255)->nullable()->default(null);
			$table->timestamp('activated_at');
			$table->timestamp('lastlogin_at');
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
		//
		Schema::dropIfExists('users');
	}

}

