<?php
/**
 * Page titles
 */
function roots_title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    } else {
      return __('Latest Posts', 'mboy');
    }
  } elseif (is_archive()) {
    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
    if ($term) {
      return $term->name;
    } elseif (is_post_type_archive()) {
      return get_queried_object()->labels->name;
    } elseif (is_day()) {
      return __('Daily Archives: %s', 'mboy') . get_the_date();
    } elseif (is_month()) {
      return __('Monthly Archives: %s', 'mboy') . get_the_date('F Y');
    } elseif (is_year()) {
      return __('Yearly Archives: %s', 'mboy') . get_the_date('Y');
    } elseif (is_author()) {
      $author = get_queried_object();
      return __('Author Archives: %s', 'mboy') . $author->display_name;
    } else {
      return single_cat_title();
    }
  } elseif (is_search()) {
    return __('Search Results for %s', 'mboy') . get_search_query();
  } elseif (is_404()) {
    return __('Not Found', 'mboy');
  } else {
    return get_the_title();
  }
}
