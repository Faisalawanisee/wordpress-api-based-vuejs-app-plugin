<?php

namespace WABVAP;

class Settings
{

	public function __construct()
	{
	}

	public static function default_values()
	{
		return [
			'numrows' => 5,
			'humandate' => true,
			'emails'    => [get_option('admin_email')],
		];
	}

	public function set($values)
	{
		return update_option(WABVAP_OPTION_NAME, $values);
	}

	public function get($type = 'all')
	{
		$option = get_option(WABVAP_OPTION_NAME);

		return $option;
	}
}
