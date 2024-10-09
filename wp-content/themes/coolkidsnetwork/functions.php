<?php

// API Functions to handle new user signup and change user role
function cool_kids_network_setup() {
    include_once 'inc/rest-api.php';

    add_role (
            'cool_kid', 
            'Cool Kid',
            array (
                'read' => true,
            )
    );
    add_role (
            'cooler_kid',
            'Cooler Kid',
            array (
                'read' => true,
            )
    );
    add_role (
            'coolest_kid',
            'Coolest Kid',
            array (
                'read' => true,
            )
    );
}

add_action ( 'after_setup_theme', 'cool_kids_network_setup' );

//Include jQuery and style
function cool_kids_network_enqueue_scripts() {
    wp_enqueue_style ( 'main-style', get_stylesheet_uri () );
    wp_enqueue_script ( 'jquery' );

    wp_enqueue_script ( 'cool-kids-network-js', get_template_directory_uri () . '/js/script.js', array ( 'jquery' ), null, true );
    wp_localize_script ( 'cool-kids-network-js', 'coolKidsData', array (
        'ajax_url'  => admin_url ( 'admin-ajax.php' ),
        'siteUrl'   => site_url (),
        'logoutUrl' => wp_logout_url ( home_url () ),
    ) );
}

add_action ( 'wp_enqueue_scripts', 'cool_kids_network_enqueue_scripts' );
// Hide adminbar 
add_filter ( 'show_admin_bar', '__return_false' );

// Handle login request
add_action ( 'wp_ajax_cool_kids_network_login', 'cool_kids_network_login' );
add_action ( 'wp_ajax_nopriv_cool_kids_network_login', 'cool_kids_network_login' );

function cool_kids_network_login() {
    global $wpdb;

    $email    = sanitize_email ( $_POST[ 'email' ] );
    $user_arr = get_user_by ( 'email', $email );
    $user_id  = $user_arr->ID;
    wp_set_current_user ( $user_id, $email );
    wp_set_auth_cookie ( $user_id );
    do_action ( 'wp_login', $email );

    if( ! $user_arr ) {
        wp_send_json_error ( [ 'message' => 'Invalid email, user not found.' ] );
        wp_die ();
    }
    wp_send_json_success ( [
        'message' => 'Login successful!',
    ] );
    wp_die ();
}

// Hook into the user edit and add actions
add_action ( 'show_user_profile', 'add_country_field' );
add_action ( 'edit_user_profile', 'add_country_field' );

function add_country_field($user) {
    ?>
    <h3><?php _e ( "Additional Information", "my_user_profile" ); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="country"><?php _e ( "Country" ); ?></label></th>
            <td>
                <input type="text" name="country" id="country" value="<?php echo esc_attr ( get_the_author_meta ( 'country', $user->ID ) ); ?>" class="regular-text" />
                <br />
                <span class="description"><?php _e ( "Please enter your country." ); ?></span>
            </td>
        </tr>
    </table>
    <?php
}

// Hook into the user profile update action
add_action ( 'personal_options_update', 'save_country_field' );
add_action ( 'edit_user_profile_update', 'save_country_field' );

function save_country_field($user_id) {
    if( ! current_user_can ( 'edit_user', $user_id ) ) {
        return false;
    }
    if( isset ( $_POST[ 'country' ] ) ) {
        update_user_meta ( $user_id, 'country', sanitize_text_field ( $_POST[ 'country' ] ) );
    }
}
