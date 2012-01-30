# Authority (Role Based Access Control)

This is a clone from codeigniter-authority-authorization

Check https://github.com/machuga/codeigniter-authority-authorization for more info.

All credits go to machuga for PHP-izing this awesome library

## NOTE

- This bundle is not (yet) available via artisan.
- And lastly, Unlike the Codeigniter Authorization library, "Users" and "Roles" have "has_and_belongs_to_many" relations.


## Configuration

### Setup the bundle

#### Setting up Laravel

- Enter you Database settings in config/database.php
- Enter a key (minimum length 32 chars) in config/application.php
- Enter a session driver in config/session.php
- Change the value of 'inflection' in config/strings.php to the one below this line

```php
'inflection' => array(

	'user' => 'users',
	'role' => 'roles',

),
```

#### Loading the bundle

In order to use the bundle you have to add it to the `bundles/bundles.php` file.
It should look similar to this:

```
return array(
	'eloquent' => array(
		'location' => 'eloquent'
	),
	'authority' => array(
		'location' => 'authority-laravel',
		'auto' => true
	)
);
```


#### Setting up Eloquent & Migrations

If you already have the Eloquent bundle installed you can skip this step.
To install Eloquent, use the `cd` command to go to your laravel directory, now run the following commands:

`php artisan bundle:install authority`

`php artisan bundle:install eloquent`

`php artisan migrate:install`

`php artisan migrate`


#### Configure Auth config

By default laravels' auth is configured without Eloquent. to enable this, replace the methods in config/auth.php with the ones below.

```php
'user' => function($id)
{
	if (filter_var($id, FILTER_VALIDATE_INT) !== false)
	{
		return User::find($id);
	}
},

'attempt' => function($username, $password)
{
	$user = User::where_username($username)->first();

	if ( ! is_null($user) and Hash::check($password, $user->password))
	{
		return $user;
	}
},
```

### Setup your Models

#### User model (models/user.php)
```PHP
class User extends Eloquent\Model {

	public static $timestamps = true;

	public function roles()
	{
		return $this->has_and_belongs_to_many('Role');
	}

	public static function has_role($key)
	{
		foreach(Auth::user()->roles as $role)
		{
			if($role->key == $key)
			{
				return true;
			}
		}

		return false;
	}

	public static function has_any_role($keys)
	{
		if( ! is_array($keys))
		{
			$keys = func_get_args();
		}

		foreach(Auth::user()->roles as $role)
		{
			if(in_array($role->key, $keys))
			{
				return true;
			}
		}

		return false;
	}
}
```


#### Role model (models/role.php)
```PHP
class Role extends Eloquent\Model {

	public function users()
	{
		return $this->has_and_belongs_to_many('User');
	}

}
```

### Setting up Rules

Modify `bundles/authority/config/authority.php` to your likings, more info on how to do this can be found at https://github.com/machuga/codeigniter-authority-authorization

# Congrats... Done!