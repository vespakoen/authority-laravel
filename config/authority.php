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

	'initialize' => function($account)
	{
		Authority::action_alias('manage', array('create', 'read', 'update', 'delete'));
		Authority::action_alias('moderate', array('update', 'delete'));

		if ( ! $account) return false;

		if($account::has_role('store_owner'))
		{
			Authority::allow('manage', 'Store', function($store) use ($account)
			{
				return DB::table('stores')->where_account_id($account->id)->first();
			}); 
		}

		if($account::has_role('organisation'))
		{
			Authority::allow('manage', 'Organisation', function($organisation) use ($account)
			{
				return DB::table('organisation')->where_account_id($account->id)->first();
			});
		}

		if($account::has_any_role('store_owner', 'manufacturer', 'reseller'))
		{
			// Store_owners, Manufacturers and Resellers can "manage" their account 
			Authority::allow('moderate', 'Account', function ($that_account) use ($account)
			{
				return $that_account->id == $account->id;
			});
		}

		if($account::has_role('superadmin'))
		{
			Authority::allow('manage', 'all'); 
			Authority::deny('delete', 'Account', function ($that_account) use ($account)
			{
				return $that_account->id == $account->id;
			});
		}
	}

);