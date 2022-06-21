<?php

namespace WABVAP;


class Page
{

	public function __construct()
	{
		if (is_admin()) {
			$this->wp_hooks();
		}
	}

	public function wp_hooks()
	{
		add_action('admin_menu', [$this, 'admin_menu']);
		add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
	}

	public function admin_menu()
	{
		$capability = 'manage_options';

		$this->hook = add_menu_page(
			esc_html__('WABVAP', 'wordpress-api-based-vuejs-app-plugin'),
			esc_html__('WABVAP', 'wordpress-api-based-vuejs-app-plugin'),
			$capability,
			'WABVAP',
			[$this, 'html'],
			'dashicons-heart'
		);
	}

	public function html()
	{
?>
		<h1>
			<?php _e("fay is here", 'wordpress-api-based-vuejs-app-plugin'); ?>
		</h1>
<?php
		echo '<div class="wrap" id="WABVAP-PAGE"></div>';
	}

	public function enqueue_styles()
	{
	}

	public function enqueue_scripts()
	{

		wp_enqueue_script(
			'wabvap_script',
			WABVAP_URL . '/src/assets/bundle.js',
			array(),
			WABVAP_DEV_MODE ? time() : WABVAP_VER,
			true
		);

		wp_enqueue_style(
			'main-style',
			WABVAP_URL . '/src/assets/style.css',
			array(),
			WABVAP_DEV_MODE ? time() : WABVAP_VER,
		);

		// wp_enqueue_script('wp-mail-smtp-vue-script', WABVAP_URL . '/vue/js/wizard.min.js', ['wp-mail-smtp-vue-vendors'], WABVAP_VER, true);

		wp_localize_script(
			'wabvap_script',
			'wabvap_vue',
			[
				// 'ajax_url' => admin_url('admin-ajax.php'),
				'nonce' => wp_create_nonce('wp_rest'),
				'endpoints' => [
					'data_url' => home_url('wp-json/wabvap/data'),
					'setting_url' => home_url('wp-json/wabvap/settings'),
				]
			]
		);
	}
}
