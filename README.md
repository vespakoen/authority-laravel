# Authority (Role Based Access Control)

This is a clone from codeigniter-authority-authorization

Check https://github.com/machuga/codeigniter-authority-authorization for more info.

All credits go to machuga for PHP-izing this awesome library

## NOTE

- This bundle is not (yet) available via artisan.
- You can use this migration to setup the database tables: https://github.com/Vespakoen/ShopHub/blob/develop/application/migrations/2012_01_24_1327455253_add_authority_tables.php
- And lastly, Unlike the Codeigniter Authorization library, "Users" and "Roles" have "has_and_belongs_to_many" relations.


## Configuration

### Setup your Models

#### User model
```PHP
class User extends Eloquent\Model {

	public static $timestamps = true;

	public $rules = array(
		'email' => 'required|email',
		'password' => 'required',
		'name' => 'required',
	);

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


#### Role model
```PHP
class Role extends Eloquent\Model {

	public function users()
	{
		return $this->has_and_belongs_to_many('User');
	}

}
```


### Add Authority to the Autoloader

open up config/application.php and add Authority to the `bundles` config, it should look similar to this

```
	'bundles' => array(
		'Authority'
	),
```


### Setting up Rules

Modify `bundles/authority/config/authority.php` to your likings


# Done!