<?php

namespace WABVAP;

use WABVAP\Auth;
use WABVAP\Endpoints;
use WABVAP\Settings;
use WABVAP\Page;

class Base
{

    public function __construct()
    {
        // Call Hooks
        $this->wp_hooks();
    }

    public function wp_hooks()
    {
        // Activation hook.
        register_activation_hook(WABVAP_PLUGIN_FILE, [$this, 'activate']);

        // Deactivation hook.
        register_deactivation_hook(WABVAP_PLUGIN_FILE, [$this, 'deactivate']);

        add_action('plugins_loaded', [$this, 'load_classes']);
    }

    public function activate()
    {
        // Set Plugin Version in db
        add_option(WABVAP_OPTION_NAME . '_version', WABVAP_VER, '', false);

        // Set default settings
        $settings = new Settings;
        $settings->set($settings->default_values());
    }

    public function deactivate()
    {
        $option_name = 'test_project_option';

        // Delete plugin option & version field.
        delete_option($option_name);
        delete_option($option_name . '_version');
    }

    public function load_classes()
    {
        new Auth();
        new Endpoints();

        if (is_admin()) {
            new Page();
        }
    }
}
