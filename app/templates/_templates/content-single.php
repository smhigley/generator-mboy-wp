<?php while (have_posts()) : the_post(); ?>

  <article class="post">

    <header>
      <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
    </header>

    <?php if(has_post_thumbnail()): ?>
    <div class="featured-thumb">
      <?php the_post_thumbnail(); ?>
    </div>
    <?php endif; ?>

    <div class="entry">
      <?php the_content(); ?>
    </div>

    <footer>
      <?php get_template_part('templates/entry-meta'); ?>
    </footer>
  </article>

  <?php comments_template('/templates/comments.php'); ?>

<?php endwhile; ?>
