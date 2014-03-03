<?php
$options = get_option( 'mb_theme_options' );
$phone = $options['phone'];
?>
<header class="banner content row" role="banner">
  <a class="brand" href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a>
  <nav class="nav-main" role="navigation">
    <?php get_template_part('templates/searchform'); ?>
    <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'menu' ));
      endif;
    ?>
  </nav>
</header>