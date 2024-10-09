<!DOCTYPE html>
<html <?php language_attributes (); ?>>
    <head>
        <meta charset="<?php bloginfo ( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php wp_head (); ?>
    </head>
    <body <?php body_class (); ?>>
        <header class='main-header'>
            <div class="container">
                <div class="brand-block">
                    <h1 class="brand-logo-title">
                        <img src="<?php echo get_template_directory_uri () . '/assets/img/logo-wpmedia-2017.svg' ?>" alt="WP Media" width="200" height="39">
                    </h1>

                    <h2 class="brand-subtitle">
                        Our Mission?
                        <br class="smart-hidden">Be the Coolest, <span class="rotator">Outplay Every Player</span>!
                    </h2>

                    <p class="brand-link">
                        <a class="btn btn-secondary" href="#about">Learn more about game</a>
                    </p>
                </div>
            </div>
        </header>