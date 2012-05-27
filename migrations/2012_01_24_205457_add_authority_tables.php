<?php

class Authority_add_authority_tables {

	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('email');
			$table->string('password');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('roles', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Schema::create('role_user', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('role_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
		Schema::drop('roles');
		Schema::drop('role_user');
	}

}