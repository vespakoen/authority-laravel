<?php
return array(

	/*
	|--------------------------------------------------------------------------
	| Initialize User Permissions Based On Roles
	|--------------------------------------------------------------------------
	|
	| This closure is called by the Authority\Ability class' "initialize" method
	|
	*/

	'initialize' => function($user)
	{
		Authority::action_alias('manage', array('create', 'read', 'update', 'delete'));
		Authority::action_alias('moderate', array('update', 'delete'));

		if ( ! $user) return false;

		if($user::has_role('store_owner'))
		{
			Authority::allow('manage', 'Store', function($store) use ($user)
			{
				return DB::table('stores')->where_user_id($user->id)->first();
			});
		}

		if($user::has_role('organisation'))
		{
			Authority::allow('manage', 'Organisation', function($organisation) use ($user)
			{
				return DB::table('organisation')->where_user_id($user->id)->first();
			});
		}

		if($user::has_any_role('store_owner', 'manufacturer', 'reseller'))
		{
			// Store_owners, Manufacturers and Resellers can "manage" their user
			Authority::allow('moderate', 'User', function ($that_user) use ($user)
			{
				return $that_user->id == $user->id;
			});
		}

		if($user::has_role('superadmin'))
		{
			Authority::allow('manage', 'all');
			Authority::deny('delete', 'User', function ($that_user) use ($user)
			{
				return $that_user->id == $user->id;
			});
		}
	}

);