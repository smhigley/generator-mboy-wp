<p class="postmeta">
	<?php echo __('Posted by:', 'mboy'); ?>: <?php echo get_the_author(); ?>
  <?php _e('on', 'mboy'); ?> <time class="updated" datetime="<?php echo get_the_time('c'); ?>" pubdate><?php echo get_the_date(); ?></time>.
  <?php
  $tags = get_the_tags();
  if($tags) {
    echo " | " . __('Tagged with:', 'mboy');
    $i = 1;
    foreach ($tags as $tag) {
      if ($i != 1) { echo ','; }
      echo ' <a href="'. get_tag_link($tag->term_id) .'">[' . $tag->name . ']</a>';
      $i++;
    }
  }
  ?>
</p>
