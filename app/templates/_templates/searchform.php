<form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
  <div class="searchform-wrapper">
    <div class="input-group">
      <label class="hide" for="s"><?php _e('Search for:', 'roots'); ?></label>
      <input type="search" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" class="search-field" placeholder="<?php _e('Search...', 'mboy'); ?>">
      <button type="submit" class="search-submit"><?php _e('Go', 'mboy'); ?></button>
    </div>
  </div>
</form>
