<?php if ($wp_query->max_num_pages > 1): ?>
  <div class="pagination">
    <?php 
      $big = 999999999;
      $current = max(1, get_query_var('paged'));
      $total_pages = $wp_query->max_num_pages;

      $pagination_links = paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => (get_option('permalink_structure')) ? 'page/%#%/' : '?paged=%#%',
        'current'   => $current,
        'total'     => $total_pages,
        'mid_size'  => 1,
        'end_size'  => 1,
        'prev_text' => "<<",
        'next_text' => ">>",
        'type'      => 'array'
      ));

      if (!empty($pagination_links)) {
        foreach ($pagination_links as $link) {
          $link = str_replace('page-numbers current', 'current-page', $link);
          if (strpos($link, 'prev') === false && strpos($link, 'next') === false) {
            $link = str_replace('page-numbers', 'page-link', $link);
          }

          if (strpos($link, 'dots') !== false) {
            echo '<span class="dots">...</span>';
          } else {
            echo $link;
          }
        }
      }
    ?>
  </div>
<?php endif; ?>
