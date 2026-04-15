<?php
/*
Plugin Name: Network Site Stats
Description: Thống kê các site trong mạng
Version: 1.0
Author: Student
Network: true
*/

if (!defined('ABSPATH')) exit;

add_action('network_admin_menu', 'nss_add_menu');

function nss_add_menu() {
    add_menu_page(
        'Network Site Stats',
        'Site Stats',
        'manage_network',
        'network-site-stats',
        'nss_render_page'
    );
}
function nss_render_page() {
    ?>
    <div class="wrap">
        <h1>Network Site Stats</h1>

        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Site Name</th>
                <th>Post Count</th>
                <th>Latest Post</th>
            </tr>

    <?php
    $sites = get_sites();
    foreach ($sites as $site) {
        switch_to_blog($site->blog_id);
        $post_count = wp_count_posts()->publish;
        $latest_post = get_posts([
            'numberposts' => 1
        ]);
        $latest_date = $latest_post ? $latest_post[0]->post_date : 'N/A';
        echo "<tr>";
        echo "<td>{$site->blog_id}</td>";
        echo "<td>" . get_bloginfo('name') . "</td>";
        echo "<td>{$post_count}</td>";
        echo "<td>{$latest_date}</td>";
        echo "</tr>";
        restore_current_blog();
    }
    ?>
        </table>
    </div>
    <?php
}