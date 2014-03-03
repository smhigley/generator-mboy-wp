<?php get_template_part('templates/page', 'header'); ?>

<div class="row">
  <section class="blog-content">
    <?php if (!have_posts()) : ?>
      <div class="alert">
        <?php _e('Sorry, no results were found.', 'roots'); ?>
      </div>
      <?php get_search_form(); ?>
    <?php endif; ?>

    <?php while (have_posts()) : the_post(); ?>
      <?php get_template_part('templates/content', get_post_format()); ?>
    <?php endwhile; ?>

    <?php if ($wp_query->max_num_pages > 1) : ?>
    <nav class="post-nav">
      <?php
      //numbered pagination
      $big = 999999999; // need an unlikely integer
      echo paginate_links(array(
        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
        'format' => '?paged=%#%',
        'current' => max( 1, get_query_var('paged') ),
        'total' => $wp_query->max_num_pages,
        'mid_size' => 3,
        'prev_next' => True,
        'prev_text' => '&laquo;',
        'next_text' => '&raquo;',
        'type' => 'list'
      ) ); ?>
    </nav>
  <?php endif; ?>
  </section>
</div>