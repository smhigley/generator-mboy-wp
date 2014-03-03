<?php
/**
 * Register sidebars and widgets
 */
function roots_widgets_init() {
  // Sidebars
  register_sidebar(array(
    'name'          => __('Primary', 'roots'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>',
  ));

  // Widgets
  register_widget('Tabbed_Posts_Widget');
  register_widget('ThemeWidget_Physicians');
}
add_action('widgets_init', 'roots_widgets_init');

/**
 * Example vCard widget
 */
class ThemeWidget_Physicians extends WP_Widget {
  private $fields = array(
    'subtitle'          => 'Subtitle',
  );

  function __construct() {
    $widget_ops = array('classname' => 'widget_mboy_physicians', 'description' => __('Use this widget to add a "Meet the Physicians" callout', 'roots'));

    $this->WP_Widget('widget_mboy_physicians', __('Theme Widget: Physicians', 'roots'), $widget_ops);
    $this->alt_option_name = 'widget_mboy_physicians';

    add_action('save_post', array(&$this, 'flush_widget_cache'));
    add_action('deleted_post', array(&$this, 'flush_widget_cache'));
    add_action('switch_theme', array(&$this, 'flush_widget_cache'));
  }

  function widget($args, $instance) {
    $cache = wp_cache_get('widget_mboy_physicians', 'widget');

    if (!is_array($cache)) {
      $cache = array();
    }

    if (!isset($args['widget_id'])) {
      $args['widget_id'] = null;
    }

    if (isset($cache[$args['widget_id']])) {
      echo $cache[$args['widget_id']];
      return;
    }

    ob_start();
    extract($args, EXTR_SKIP);

    foreach($this->fields as $name => $label) {
      if (!isset($instance[$name])) { $instance[$name] = ''; }
    }

    echo $before_widget;
  ?>
    <div class="callout-text">
      <h3><span><?php _e('Meet', 'mboy'); ?></span> <?php _e('The Physicians', 'mboy'); ?></h3>
      <p><?php echo $instance['subtitle']; ?></p>
    </div>
    <div class="callout-profile">
      <a href="/physicians" title="Go to Physicians page"><?php _e('Read Physician Bios'); ?></a>
      <?php
        //get random physician bio
        $bios = new WP_Query(array(
          'post_type' => 'physician',
          'orderby' => 'rand',
          'posts_per_page' => '1'
        ));
        while ( $bios->have_posts() ) :
          $bios->the_post();
          $pic_src = wp_get_attachment_image_src( get_post_thumbnail_id(), 'medium' );
      ?>
      <div class="profile-pic" style="background-image: url('<?php echo $pic_src[0]; ?>')">
        <div class="overlay"><span><?php the_title(); ?></span></div>
      </div>
      <?php endwhile; ?>
    </div>
  <?php
    echo $after_widget;

    $cache[$args['widget_id']] = ob_get_flush();
    wp_cache_set('widget_mboy_physicians', $cache, 'widget');
  }

  function update($new_instance, $old_instance) {
    $instance = array_map('strip_tags', $new_instance);

    $this->flush_widget_cache();

    $alloptions = wp_cache_get('alloptions', 'options');

    if (isset($alloptions['widget_mboy_physicians'])) {
      delete_option('widget_mboy_physicians');
    }

    return $instance;
  }

  function flush_widget_cache() {
    wp_cache_delete('widget_mboy_physicians', 'widget');
  }

  function form($instance) {
    foreach($this->fields as $name => $label) {
      ${$name} = isset($instance[$name]) ? esc_attr($instance[$name]) : '';
    ?>
    <p>
      <label for="<?php echo esc_attr($this->get_field_id($name)); ?>"><?php _e("{$label}:", 'roots'); ?></label>
      <input class="widefat" id="<?php echo esc_attr($this->get_field_id($name)); ?>" name="<?php echo esc_attr($this->get_field_name($name)); ?>" type="text" value="<?php echo ${$name}; ?>">
    </p>
    <?php
    }
  }
}