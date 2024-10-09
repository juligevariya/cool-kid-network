<?php get_header (); ?>
<section class="about-details" id="about">
    <div class="container">
        <h2>About Cool Kids Network</h2>
        <p>Welcome to the Cool Kids Network, where being cool is just the beginning! This is the place where young creators, explorers, and game-changers connect. Whether you're a Cool Kid, a Cooler Kid, or even the Coolest Kid, there's a world of discovery waiting for you!</p>
        <p>As a Cool Kid, you'll get access to a wide range of fun and educational content, and you'll also be able to learn about other cool kids like you from across the network. But if you level up to a Cooler Kid, you'll unlock the inside scoop on the most amazing kids in the community—those who are doing incredible things, from leading teams in games to sharing creative projects. And finally, for the ultimate experience, Coolest Kids get access to everything and everyone. You'll not only know about every awesome kid on the network, but also get exclusive content, sneak peeks, and special opportunities to collaborate with the best of the best.</p>
        <p>No matter where you stand, Cool Kids Network is all about fun, creativity, and growing together. Join the coolest community on the planet and start your journey to being the coolest kid around!</p>
        <h3>Get Ready to Be the Coolest!</h3>
    </div>
</section>
<section class="user-details">
    <div class="container">
        <?php if( ! is_user_logged_in () ) { ?>
            <div id="login-container" class='login-form-section'>
                <h3>Login with E-mail Only</h3>
                <form id="login-form">
                    <label for="login-email">Email:</label>
                    <input type="email" id="login-email" required>
                    <button type="submit" class="btn btn-secondary">Login</button>
                </form>
                <p id="login-error" style="color:red; display:none;"></p>
            </div>
            <div class="signup-link">
                <p>Not Register Yet?  <a id='signup-link' href="javascript:;">Click here...</a></p>
            </div>

            <?php
        } else {
            $current_user = wp_get_current_user ();
            if( $current_user->exists () ) {
                $roles             = $current_user->roles;
                $current_user_role = ! empty ( $roles ) ? $roles[ 0 ] : 'No ro  le assigned';
                $last_name         = get_user_meta ( $current_user->ID, 'last_name', true );
            }
            if( $roles[ 0 ] == "cool_kid" ) {
                $user_role = "Cool Kid";
            } elseif( $roles[ 0 ] == "cooler_kid" ) {
                $user_role = "Cooler Kid";
            } elseif( $roles[ 0 ] == "coolest_kid" ) {
                $user_role = "Coolest Kid";
            }
            ?>
            <h3>Your general information as a Player</h3>
            <div id="character-container" class="character-container">
                <?php if( ! empty ( $current_user->first_name ) ) { ?>
                    <strong>First Name:</strong> <?php echo $current_user->first_name; ?><br>
                <?php } ?>
                <?php if( ! empty ( $last_name ) ) { ?>
                    <strong>Last Name:</strong> <?php echo $last_name; ?><br>
                <?php } ?>
                <?php if( ! empty ( $current_user->country ) ) { ?>
                    <strong>Country:</strong> <?php echo $current_user->country; ?><br>
                <?php } ?>
                <?php if( ! empty ( $current_user->user_email ) ) { ?>
                    <strong>Email:</strong> <?php echo $current_user->user_email; ?><br>
                <?php } ?>
                <?php if( ! empty ( $user_role ) ) { ?>
                    <strong>Role:</strong> <?php echo $user_role; ?><br>
                <?php } ?>
            </div>
            <a href="javascript:;" id="logout-btn" class="btn btn-secondary">Logout</a>
            <?php
        }
        ?>

        <div id='sign-up' class="login-form-section" style="display:none;">
            <h3>Sign Up here with E-mail Only</h3>
            <form id="signup-form">
                <input type="email" id="email" placeholder="Email Address" required>
                <button type="submit" class="btn btn-secondary">Confirm</button>
            </form>
            <p id="signup-message" style="color:red; display:none;"></p>
        </div>
    </div>
</section>
<?php
$current_user = wp_get_current_user ();
if( $current_user->exists () ) {
    $roles             = $current_user->roles;
    $current_user_role = ! empty ( $roles ) ? $roles[ 0 ] : 'No role assigned';
} else {
    $current_user_role = "";
}
$users         = get_users ();
$is_only_admin = count ( $users ) === 1 && in_array ( 'administrator', $users[ 0 ]->roles );
if( ! $is_only_admin ) {
    if( ! empty ( $users ) && $current_user_role != "cool_kid" && is_user_logged_in () ) {
        ?>
        <section class="user-list">
            <div class="container">
                <div class="users-list">
                    <table class="table-section">
                        <thead>
                            <tr>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Country</th>
                                <?php
                                if( $current_user_role == "coolest_kid" || $current_user_role == "administrator" ) {
                                    ?>
                                    <th>Email</th>
                                    <th>Role</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ( $users as $user ) {
                                $user_meta = get_userdata ( $user->ID );
                                $roles     = $user_meta->roles;
                                if( $roles[ 0 ] == "cool_kid" || $roles[ 0 ] == "cooler_kid" || $roles[ 0 ] == "coolest_kid" ) {
                                    if( $roles[ 0 ] == "cool_kid" ) {
                                        $user_role = "Cool Kid";
                                    } elseif( $roles[ 0 ] == "cooler_kid" ) {
                                        $user_role = "Cooler Kid";
                                    } elseif( $roles[ 0 ] == "coolest_kid" ) {
                                        $user_role = "Coolest Kid";
                                    }
                                    ?>
                                    <tr>
                                        <td data-label="First Name"><?php echo $user_meta->first_name; ?></td>
                                        <td data-label="Last Name"><?php echo $user_meta->last_name; ?></td>
                                        <td data-label="Country"><?php echo $user_meta->country; ?></td>
                                        <?php
                                        if( $current_user_role == "coolest_kid" || $current_user_role == "administrator" ) {
                                            ?>
                                            <td data-label="Email"><?php echo $user_meta->user_email; ?></td>
                                            <td data-label="Role"><?php echo $user_role; ?></td>
                                        <?php } ?>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <a href="javascript:;" id="openModalBtn" class="btn btn-secondary">Change User Role</a>
                    <div id="modalForm" style="display: none;">
                        <form method="POST" id="updateRoleForm">
                            <h3>Login with E-mail Only</h3>
                            <form id="login-form">
                                <label for="login-email">Enter email:</label>
                                <input type="email" name="user_email" id="user_email" required>
                                <select name="change_user_role" id="change_user_role">
                                    <option value="cool_kid">Cool Kid</option>
                                    <option value="cooler_kid">Cooler Kid</option>
                                    <option value="coolest_kid">Coolest Kid</option>
                                </select>
                                <button type="submit" name="update_user_role" class="btn btn-secondary" value="Update Role">Update Role</button>
                            </form>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}
?>

<?php get_footer (); ?>