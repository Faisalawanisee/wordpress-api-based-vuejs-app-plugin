<?php

class Wordpress_Api_Based_Vuejs_App_Plugin_i18n {

	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wordpress-api-based-vuejs-app-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
