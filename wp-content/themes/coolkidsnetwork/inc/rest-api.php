<?php

// Include Random User Generator
function cool_kids_network_random_user() {
    $response = wp_remote_get ( 'https://randomuser.me/api/' );
    $body     = json_decode ( wp_remote_retrieve_body ( $response ), true );
    return $body[ 'results' ][ 0 ];
}

add_action ( 'rest_api_init', function () {
    register_rest_route ( 'cool-kids-network/v1', '/signup', array (
        'methods'  => 'POST',
        'callback' => 'cool_kids_network_handle_signup',
    ) );
    register_rest_route ( 'cool-kids-network/v1', '/set-role', array (
        'methods'  => 'POST',
        'callback' => 'set_user_role',
//        'permission_callback' => 'is_user_allowed',
    ) );
} );

function set_user_role(WP_REST_Request $request) {
    $email    = sanitize_email (
            $request->get_param ( 'email' )
    );
    $new_role = sanitize_text_field ( $request->get_param ( 'new_role' ) );

    $user = get_user_by ( 'email', $email );
    if( $user ) {
        $wp_user = new WP_User ( $user->ID );
        $wp_user->set_role ( $new_role );
        return new WP_REST_Response ( [ 'success' => true, 'message' => 'User role Changed.' ], 200 );
    } else {
        return new WP_Error ( 'user_not_found', 'User not found', array ( 'status' => 404 ) );
    }
}

//function is_user_allowed() {
//    $current_user = wp_get_current_user ();
//    if( $current_user->exists () ) {
//        $roles             = $current_user->roles;
//        $current_user_role = ! empty ( $roles ) ? $roles[ 0 ] : 'No role assigned';
//    } else {
//        $current_user_role = "";
//    }
//    if( $current_user_role == "administrator" ) {
//        return true;
//    } else {
//        return false;
//    }
//}
// Handle user signup
function cool_kids_network_handle_signup($request) {
    global $wpdb;
    $email            = sanitize_email ( $request[ 'email' ] );
    $existing_wp_user = $wpdb->get_var ( $wpdb->prepare ( "SELECT user_email FROM {$wpdb->prefix}users WHERE user_email = %s", $email ) );
    if( $existing_wp_user ) {
        return new WP_REST_Response ( [ 'success' => false, 'message' => 'Email already registered.' ], 200 );
    }
    $random_user = cool_kids_network_random_user ();
    $first_name  = sanitize_text_field ( $random_user[ 'name' ][ 'first' ] );
    $last_name   = sanitize_text_field ( $random_user[ 'name' ][ 'last' ] );
    $country     = sanitize_text_field ( $random_user[ 'location' ][ 'country' ] );

    $username = sanitize_user ( $first_name . $last_name );
    $password = wp_generate_password ();
    $user_id  = wp_create_user ( $username, $password, $email );

    if( is_wp_error ( $user_id ) ) {
        return new WP_REST_Response ( [ 'success' => false, 'message' => 'User registration failed.' ], 400 );
    }
    $user = new WP_User ( $user_id );
    $user->set_role ( 'cool_kid' );
    wp_update_user ( array ( 'ID' => $user->ID, 'first_name' => $first_name ) );
    wp_update_user ( array ( 'ID' => $user->ID, 'last_name' => $last_name ) );
    update_user_meta ( $user->ID, 'country', sanitize_text_field ( $country ) );
    wp_set_current_user ( $user->ID, $email );
    wp_set_auth_cookie ( $user->ID );
    do_action ( 'wp_login', $email );
    header ( "Location: " . $_SERVER[ 'PHP_SELF' ] );
    return new WP_REST_Response ( [ 'success' => true, 'message' => 'User registered successfully.' ], 200 );
}
