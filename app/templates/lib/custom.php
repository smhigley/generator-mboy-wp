<?php
/**
 * Custom functions
 */

// search both posts and pages with default wordpress search
function mboy_search_filter( $query ) {
    if ( $query->is_search ) {
        $query->set( 'post_type', array('post','page') );
    }
    return $query;
}
add_filter('pre_get_posts','mboy_search_filter');

<% if(shortcodes) { %>

//fix annoying shortcode/wpautop problems
add_filter('the_content', 'shortcode_empty_paragraph_fix');
function shortcode_empty_paragraph_fix($content) {   
	$array = array (
		'<p>[' => '[', 
		']</p>' => ']', 
		']<br />' => ']'
	);

	$content = strtr($content, $array);
	return $content;
}

//columns
// column group/row: [col-group] [/col-group], no atts
function mb_colgroup_func( $atts, $content = null ) {
	extract( shortcode_atts( array(
	), $atts ) );

  return '<div class="nested row">'. do_shortcode($content) .'</div>';
}
add_shortcode( 'col-group', 'mb_colgroup_func' );

// half columns: [half] [/half]
function mb_halfcol_func( $atts, $content = null ) {
  extract( shortcode_atts( array(
  ), $atts ) );

  return '<div class="half section">'. do_shortcode($content) .'</div>';
}
add_shortcode( 'half', 'mb_halfcol_func' );

//hook shortcodes into tinymce editor
add_action('init', 'add_mb_buttons');
function add_mb_buttons() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'mb_shortcode_plugin');
     add_filter('mce_buttons', 'mb_shortcode_buttons');
   }
}
function mb_shortcode_buttons($buttons) {
   array_push($buttons, "half"); //add more buttons here as an array
   return $buttons;
}
function mb_shortcode_plugin($plugin_array) {
   $plugin_array['mboy'] = get_bloginfo('template_url').'/assets/admin/admincodes.js';
   return $plugin_array;
}


<% } if(customMeta) { %>
/**
	* Metabox code
	*/

add_action( 'admin_init', 'mb_register_meta_boxes' );

$prefix = 'mb_meta_';
global $meta_boxes;
$meta_boxes = array();

//sample metabox:
$meta_boxes[] = array(
	'id' => 'subtitle',
  'title' => 'Page Subtitle',
  'pages' => array( 'page' ),
  'fields' => array(
		array(
			'name' => 'Subtitle (H2)',
      'desc' => 'A short subtitle to appear in the header below the page title',
      'id' => $prefix . 'subtitle',
      'type' => 'textarea'
    ),
  )
);

function mb_register_meta_boxes() {
	global $meta_boxes;

	if ( !class_exists( 'RW_Meta_Box' ) )
	        return;

	foreach ( $meta_boxes as $meta_box ) {
		// Register meta boxes only for some posts/pages
		if ( isset( $meta_box['only_on'] ) && ! mb_check_include( $meta_box['only_on'] ) ) {
			continue;
		}
		new RW_Meta_Box( $meta_box );
	}
}

function mb_check_include( $conditions ) {
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN )
		return false;

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return true;

	if ( isset( $_GET['post'] ) )
		$post_id = $_GET['post'];
	elseif ( isset( $_POST['post_ID'] ) )
		$post_id = $_POST['post_ID'];
	else
		$post_id = false;

	$post_id = (int) $post_id;
	$post = get_post( $post_id );
  $post_type = get_post_type( $post );

	foreach ( $conditions as $cond => $v ) {
		// Catch non-arrays too
		if ( ! is_array( $v ) ) {
			$v = array( $v );
		}

		switch ( $cond ) {
			case 'id':
				if ( in_array( $post_id, $v ) ) {
					return true;
				}
			break;
			case 'parent':
				$post_parent = $post->post_parent;
				if ( in_array( $post_parent, $v ) ) {
					return true;
				}
			break;
			case 'slug':
				$post_slug = $post->post_name;
				if ( in_array( $post_slug, $v ) ) {
					return true;
				}
			break;
			case 'template':
				$template = get_post_meta( $post_id, '_wp_page_template', true );
        // if post type other than page is specified, don't return true
				if ( in_array( $template, $v ) || in_array($post_type, $v)  ) {
					return true;
				}
			break;
		}
	}

	// If no condition matched
	return false;
}
<% } %>