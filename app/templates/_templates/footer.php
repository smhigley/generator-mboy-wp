<footer class="page-footer" role="contentinfo">
  <div class=" content row">
    <nav class="footer-nav" role="navigation">
      <?php
        if (has_nav_menu('footer_navigation')) :
          wp_nav_menu(array('theme_location' => 'footer_navigation', 'menu_class' => 'desktop menu' ));
        endif;
      ?>
    </nav><!-- /.footer-nav -->
    <div class="copyright">
      <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?> Inc. <?php _e('All Rights Reserved', 'mboy'); ?>.</p>
      <a href="http://www.monkee-boy.com" title="austin web design development and marketing" class="siteby">Monkee-Boy Austin Web Design</a>
    </div><!-- /.copyright -->
  </div>
</footer><!-- /.page-footer -->

<?php wp_footer(); ?>
