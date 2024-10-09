jQuery(document).ready(function ($) {
// Handle login form submission
    jQuery(document).find('#login-form').on('submit', function (e) {
        e.preventDefault();
        var email = jQuery(document).find('#login-email').val();
        jQuery.ajax({
            url: coolKidsData.ajax_url,
            method: 'POST',
            data: {
                action: 'cool_kids_network_login',
                email: email
            },
            success: function (response) {
                if (response.success) {
                    jQuery(document).find('#login-error').text(response.data.message).show();
                    location.reload();
                } else {
                    jQuery(document).find('#login-error').text(response.data.message).show();
                }
            },
            error: function (xhr, status, error) {
                jQuery('#login-error').text('Something went wrong. Please try again.').show();
            }
        });
    });
//Handle Signup and new user registration
    jQuery(document).find('#signup-link').on('click', function (e) {
        jQuery(document).find('#login-container').remove();
        jQuery(document).find('.signup-link').remove();
        jQuery(document).find('#sign-up').show();
    });
    jQuery(document).find('#signup-form').on('submit', function (e) {
        e.preventDefault();
        var email = jQuery(document).find('#email').val();
        jQuery.ajax({
            url: coolKidsData.siteUrl + '/wp-json/cool-kids-network/v1/signup',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({email: email}),
            success: function (response) {
                jQuery(document).find('#signup-message').text(response.message).show();
                if (response.success === true) {
                    location.reload();
                }
            },
            error: function (response) {
                console.log("IN");
                jQuery(document).find('#signup-message').text(response.message).show();
            }
        });
    });
// Handle User Update
    jQuery(document).find('.users-list #openModalBtn').on('click', function (e) {
        jQuery(document).find('#modalForm').show();
    });
    jQuery(document).find('#updateRoleForm').on('submit', function (e) {
        e.preventDefault();
        var userEmail = jQuery(document).find('#user_email').val();
        var userRole = jQuery(document).find('#change_user_role').val();

        jQuery.ajax({
            url: coolKidsData.siteUrl + '/wp-json/cool-kids-network/v1/set-role',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify({
                email: userEmail,
                new_role: userRole
            }),
            success: function (response) {
                if (response.success) {
                    alert('User role updated successfully!');
                    jQuery(document).find('#modalForm').hide();
                } else {
                    alert('Failed to update user role. Please try again.');
                }
            },
            error: function (xhr, status, error) {
                alert('Error: ' + error);
            }
        });
    });

//    Handle Logout
    jQuery(document).find('#logout-btn').on('click', function (e) {
        e.preventDefault();
        window.location.href = coolKidsData.logoutUrl;
    });

//Smooth Scroll JS
    jQuery('a[href*="#"]').on('click', function (event) {
        if (this.hash !== "") {
            event.preventDefault();
            var hash = this.hash;
            jQuery('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function () {
                window.location.hash = hash;
            });
        }
    });
});