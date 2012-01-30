<?php

class Add_Authority_Tables {

	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('email')->unique();
			$table->string('password');
			$table->string('name');
			$table->timestamp('created_at');
			$table->timestamp('updated_at');
		});

		Schema::table('roles', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->string('key')->unique();
		});

		Schema::table('role_lang', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('role_id');
			$table->integer('language_id');
			$table->string('name');
			$table->string('description');
		});

		Schema::table('roles_users', function($table)
		{
			$table->create();
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('role_id');
		});
	}

	public function down()
	{
		Schema::table('users', function($table)
		{
			$table->drop();
		});

		Schema::table('roles', function($table)
		{
			$table->drop();
		});

		Schema::table('roles_users', function($table)
		{
			$table->drop();
		});
	}

}