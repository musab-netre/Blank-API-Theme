<?php
// Block all frontend access unless it's a REST request or admin
add_action('template_redirect', function () {
    if (
        !is_admin() &&                     // Not admin
        !wp_doing_ajax() &&                // Not AJAX
        !defined('REST_REQUEST')           // Not REST API
    ) {
        wp_die(
            'Frontend access is disabled. This site is API-only.',
            'Access Denied',
            ['response' => 403]
        );
    }
});

// Optional: remove unnecessary header output (cleaner & lighter)
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

// Optional: remove all styles/scripts from frontend
add_action('wp_enqueue_scripts', function () {
    if (!defined('REST_REQUEST')) {
        // Add your dequeue logic here if needed
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('global-styles');
        wp_dequeue_script('jquery');
        wp_dequeue_script('wp-embed');
    }
}, 100);
