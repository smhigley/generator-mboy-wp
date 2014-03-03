<?php
/**
 * Enable theme features
 */
add_theme_support('root-relative-urls');    // Enable relative URLs
add_theme_support('rewrites');              // Enable URL rewrites
add_theme_support('h5bp-htaccess');         // Enable HTML5 Boilerplate's .htaccess
add_theme_support('nice-search');           // Enable /?s= to /search/ redirect

/**
 * Configuration values
 */
define('POST_EXCERPT_LENGTH', 50);

/**
 * .main classes
 */
function roots_main_class() {

  if( is_front_page() ) {
    $class = "home";
  } elseif ( is_home() || get_post_type() == 'post' || is_search() ) {
    $class = "blog";
  } elseif( !is_page_template() ) {
    $class = "subpage";
  } else {
    $class = "";
  }

  return $class;
}

/**
 * $content_width is a global variable used by WordPress for max image upload sizes
 * and media embeds (in pixels).
 *
 * Example: If the content area is 640px wide, set $content_width = 620; so images and videos will not overflow.
 * Default: 940px is the default Bootstrap container width.
 */
if (!isset($content_width)) { $content_width = 960; }

/**
 * Define helper constants
 */
$get_theme_name = explode('/themes/', get_template_directory());

define('RELATIVE_PLUGIN_PATH',  str_replace(home_url() . '/', '', plugins_url()));
define('RELATIVE_CONTENT_PATH', str_replace(home_url() . '/', '', content_url()));
define('THEME_NAME',            next($get_theme_name));
define('THEME_PATH',            RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME);