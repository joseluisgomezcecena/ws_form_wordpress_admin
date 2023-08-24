<?php
/*
Plugin Name: Boras Simple Visitor Counter
Plugin URI: http://nexussoftwaresolutions.com/freebies/visitor-counter
Description: A simple visitor counter, you can use the [visitor_counter] short code or place the display_visitor_counter() function on the appropriate theme section.
Version: 1.0
Author: Jose Luis Gomez Ceceña
Author URI: http://nexussoftwaresolutions.com/
License: A "Slug" license name e.g. GPL2
*/


// Activation hook to create the database table
function visitor_counter_activate() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'visitor_counter';

    // Check if the table already exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        $charset_collate = $wpdb->get_charset_collate();

        // Define table structure
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
            count int(9) NOT NULL DEFAULT 0,
            PRIMARY KEY (id)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);
    }

    // Set initial total count
    update_option('visitor_counter_total', 0);
}



register_activation_hook(__FILE__, 'visitor_counter_activate'); // Register plugin activation hook



function visitor_counter() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'visitor_counter';
    $current_date = current_time('mysql');

    // Insert a new record for each view
    $wpdb->insert($table_name, array('date' => $current_date, 'count' => 1));

    // Update the total count
    $total_count = $wpdb->get_var("SELECT SUM(count) FROM $table_name");
    update_option('visitor_counter_total', $total_count);
}



// Hook into wp_head to count visits on page load
function count_visitor_on_page_load() {
    if (is_home() || is_front_page()) { // Only count visits on the homepage
        visitor_counter();
    }
}
add_action('wp_head', 'count_visitor_on_page_load');


function display_visitor_counter() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'visitor_counter';
    $visitor_data = $wpdb->get_row("SELECT date, count FROM $table_name ORDER BY date DESC LIMIT 1");

    if ($visitor_data) {
        $individual_count = $visitor_data->count;
        $total_count = get_option('visitor_counter_total', 0);
        $view_date = date('F j, Y', strtotime($visitor_data->date));

        echo "<p class='bsvc'>Individual Views: $individual_count</p>";
        echo "<p class='bsvc'>Total Views: $total_count</p>";
        echo "<p class='bsvc'>Last View Date: $view_date</p>";
    } else {
        echo "<p class='bsvc'>No visitor data available.</p>";
    }
}


// Shortcode handler function
function display_visitor_counter_shortcode() {
    ob_start(); // Start output buffering
    display_visitor_counter(); // Call the display_visitor_counter function
    return ob_get_clean(); // Return the buffered output
}

// Register the shortcode
add_shortcode('visitor_counter', 'display_visitor_counter_shortcode');
