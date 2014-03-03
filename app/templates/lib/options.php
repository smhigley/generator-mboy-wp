<?php
/**
 * Custom options
 */

// Register and define the settings
add_action('admin_init', 'mb_admin_init');
//add_action( 'admin_menu', 'mb_add_theme_options' );

function mb_admin_init(){
        register_setting(
        'general',              // settings page
        'mb_options',          // option name
        'mb_validate_options'  // validation callback
    );
        
        //settings field in General Settings for Google Analytics ID
    add_settings_field(
        'mb_google_analytics_id',      // id
        'Google Analytics ID',              // setting title
        'mb_get_analytics_id',    // display callback
        'general',                 // settings page
        'default'                  // settings section
    );

}

/*********************
Google Analytics Code
*********************/
// Display an fill form field
function mb_get_analytics_id() {
    // get option 'boss_email' value from the database
    $options = get_option( 'mb_options');
        $value = $options['mb_google_analytics_id']
    
    // echo the field
    ?>
<input id='mb_google_analytics_id' name='mb_options[mb_google_analytics_id]'
 type='text' value='<?php echo esc_attr( $value ); ?>' /> Google Analytics ID
    <?php
}

// Validate user input and return validated data
function mb_validate_options( $input ) {
    $valid = array();
    $valid['mb_google_analytics_id'] = sanitize_text_field( $input['mb_google_analytics_id'] );
    return $valid;
}

<% if(themeOptions) { %>
/* theme options page */
add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
    register_setting( 'mb_options', 'mb_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
    add_theme_page( __( 'Theme Options', 'roots' ), __( 'Theme Options', 'roots' ), 'manage_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {
    global $select_options, $radio_options;

    if ( ! isset( $_REQUEST['settings-updated'] ) )
        $_REQUEST['settings-updated'] = false;

    ?>
    <div class="wrap">
        <?php screen_icon(); echo "<h2>" . __( ' Theme Options', 'roots' ) . "</h2>"; ?>

        <?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
        <div class="updated fade"><p><strong><?php _e( 'Options saved', 'roots' ); ?></strong></p></div>
        <?php endif; ?>

        <form method="post" action="options.php">
            <?php settings_fields( 'mb_options' ); ?>
            <?php $options = get_option( 'mb_theme_options' ); ?>

            <table class="form-table">

                <?php
                /**
                 * Phone Number
                 */
                ?>
                <tr valign="top"><th scope="row"><?php _e( 'Phone Number', 'roots' ); ?></th>
                    <td>
                        <input id="mb_theme_options[phone]" class="regular-text" type="text" name="mb_theme_options[phone]" value="<?php esc_attr_e( $options['phone'] ); ?>" />
                        <label class="description" for="mb_theme_options[phone]"><?php _e( 'Please enter your phone number (only used on mobile navigation)', 'roots' ); ?></label>
                    </td>
                </tr>

                
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'roots' ); ?>" />
            </p>
        </form>
    </div>

    <?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {
    
    //input filters
    $input['phone'] = wp_kses_post( $input['phone'] );

    return $input;
}
<% } %>