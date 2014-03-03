<article class="post">
  <header>
    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  </header>

  <?php if(has_post_thumbnail()): ?>
  <div class="featured-thumb">
    <?php the_post_thumbnail('thumbnail'); ?>
  </div>
  <?php endif; ?>

  <div class="entry-summary">
    <?php the_excerpt(); ?>
    <a href="<?php the_permalink(); ?>" title="Read full post" class="more-link"><?php _e('Read more', 'mboy'); ?></a>
  </div>

  <footer>
    <?php get_template_part('templates/entry-meta'); ?>
  </footer>
</article>
