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

		User::create(array(
			'id' => 1,
			'email' => 'admin@domain.com',
			'password' => Hash::make('admin'),
			'name' => 'Mr. Administrator',
		));

		User::create(array(
			'id' => 2,
			'email' => 'moderator@domain.com',
			'password' => Hash::make('moderator'),
			'name' => 'Mr. Moderator',
		));


		Schema::create('roles', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});

		Role::create(array(
			'id' => 1,
			'name' => 'administrator'
		));

		Role::create(array(
			'id' => 2,
			'name' => 'moderator'
		));

		Schema::create('role_user', function($table)
		{
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('role_id');
			$table->timestamps();
		});

		User::find(1)
			->roles()
			->attach(1);

		User::find(2)
			->roles()
			->attach(2);
	}

	public function down()
	{
		Schema::drop('users');
		Schema::drop('roles');
		Schema::drop('role_user');
	}

}