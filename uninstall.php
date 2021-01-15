<?php


if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// Clear Database stored data
$books = get_posts(array('post_type' => 'laminin'));

foreach ($books as $book) {
    wp_delete_post($book->ID, true);
}

function lumdelete_all_option(){
	
	$all_options = wp_load_alloptions();
	$my_options  = '';

	foreach ( $all_options as $name => $value ) {
    	if ( stristr( $name, 'laminin' ) ) {
        	$my_options =  $name;
        	delete_option( $my_options );
    	}
	}
}
 
lumdelete_all_option();
// Access the database via SQL
global $wpdb;
$wpdb->query("DELETE FROM wp_posts WHERE post_type = 'laminin'");
$wpdb->query("DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)");
$wpdb->query("DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)");
