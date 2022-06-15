<?php

namespace WABVAP;

class Auth
{

    public function __construct()
    {

        // wp_localize_script('wp-api', 'wpApiSettings', array(
        //     'root' => esc_url_raw(rest_url()),
        //     'nonce' => wp_create_nonce('wp_rest')
        // ));

        // add_action('wp_footer', [$this, 'wp_footer']);
    }

    public function wp_footer()
    {
?>
        <script>
            $.ajax({
                url: wpApiSettings.root + 'wp/v2/posts/1',
                method: 'POST',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', wpApiSettings.nonce);
                },
                data: {
                    'title': 'Hello Moon'
                }
            }).done(function(response) {
                console.log(response);
            });
        </script>
<?php
    }
}
