<?php
/**
 * Template override: Shop archive with simple filters and pagination
 * Path: yourtheme/woocommerce/archive-product.php
 * All markup is prefixed with `woo-mk-catalog` classes.
 */

if (!defined('ABSPATH')) { exit; }

// Helpers
function woo_mk_catalog_get_price_bounds(){
  global $wpdb;
  $row = $wpdb->get_row("SELECT MIN(CAST(pm.meta_value AS DECIMAL(10,2))) AS minp, MAX(CAST(pm.meta_value AS DECIMAL(10,2))) AS maxp FROM {$wpdb->postmeta} pm INNER JOIN {$wpdb->posts} p ON p.ID=pm.post_id WHERE pm.meta_key='_price' AND p.post_type='product' AND p.post_status='publish'");
  return [ 'min'=>(float)($row->minp ?? 0), 'max'=>(float)($row->maxp ?? 0) ];
}

// Read state
$qs = wp_unslash($_GET);

$cats = [];
if (isset($qs['prod_cat'])) {
  $cats = array_map('intval', (array) $qs['prod_cat']);
} elseif (isset($qs['cat'])) { // старий варіант, на всякий
  $cats = array_map('intval', (array) $qs['cat']);
}

$attrs = [];
foreach (get_taxonomies(['object_type'=>['product'], 'public'=>true], 'names') as $tx){
  if (strpos($tx, 'pa_') === 0 && isset($qs[$tx])) {
    $attrs[$tx] = array_map('intval', (array) $qs[$tx]);
  }
}
$sort = isset($qs['sort']) ? sanitize_text_field($qs['sort']) : 'default';
$price_bounds = woo_mk_catalog_get_price_bounds();
$price_min = isset($qs['price_min']) ? max($price_bounds['min'], (float)$qs['price_min']) : $price_bounds['min'];
$price_max = isset($qs['price_max']) ? min($price_bounds['max'], (float)$qs['price_max']) : $price_bounds['max'];
$paged = max(1, get_query_var('paged') ? (int) get_query_var('paged') : (isset($qs['paged']) ? (int)$qs['paged'] : 1));
$per_page = wc_get_default_products_per_row() * wc_get_default_product_rows_per_page();
if (!$per_page) { $per_page = 12; }

// Build query
$tax_query = ['relation'=>'AND'];
if ($cats) {
  $tax_query[] = [ 'taxonomy'=>'product_cat','field'=>'term_id','terms'=>$cats ];
}
foreach ($attrs as $tx=>$ids) {
  if ($ids) { $tax_query[] = [ 'taxonomy'=>$tx, 'field'=>'term_id', 'terms'=>$ids ]; }
}

$meta_query = [];
if ($price_min || $price_max) {
  $meta_query[] = [ 'key'=>'_price', 'value'=>[$price_min,$price_max], 'compare'=>'BETWEEN', 'type'=>'NUMERIC' ];
}

$orderby = 'menu_order title'; $order='ASC'; $meta_key='';
switch ($sort) {
  case 'price-asc': $orderby='meta_value_num'; $meta_key='_price'; $order='ASC'; break;
  case 'price-desc': $orderby='meta_value_num'; $meta_key='_price'; $order='DESC'; break;
  case 'date-desc': $orderby='date'; $order='DESC'; break;
  case 'popularity': $orderby='meta_value_num'; $meta_key='total_sales'; $order='DESC'; break;
}

$args = [
  'post_type' => 'product',
  'post_status' => 'publish',
  'posts_per_page' => $per_page,
  'paged' => $paged,
  'tax_query' => count($tax_query) > 1 ? $tax_query : [],
  'meta_query' => $meta_query,
  'orderby' => $orderby,
  'order' => $order,
];
if ($meta_key) $args['meta_key'] = $meta_key;

$q = new WP_Query($args);

// Terms for filters
$cat_terms = get_terms(['taxonomy'=>'product_cat','hide_empty'=>true]);
$attr_taxonomies = [];
foreach (get_taxonomies(['object_type'=>['product'], 'public'=>true], 'names') as $tx){
  if (strpos($tx,'pa_')===0) { $attr_taxonomies[$tx] = get_terms(['taxonomy'=>$tx,'hide_empty'=>true]); }
}
?>

@php
  the_widget(
    'HeaderMenuWidget',
    [
      'use_default'      => true,
    ],
    [
      'before_widget' => '<div class="so-widget so-mkmt-grid">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="section-title">',
      'after_title'   => '</h2>',
    ]
  );
@endphp

<div class="woo-mk-catalog" id="woo-mk-catalog-root">
  <header class="woo-mk-catalog__header">
    <h1 class="woo-mk-catalog__title"><?php esc_html_e('Каталог','woo-mk-catalog'); ?></h1>
    <div class="woo-mk-catalog__sort">
      <label for="woo-mk-catalog-sort" class="woo-mk-catalog__sort-label"><?php esc_html_e('Сортувати:', 'woo-mk-catalog'); ?></label>
      <select id="woo-mk-catalog-sort" class="woo-mk-catalog__sort-select" form="woo-mk-catalog-form" name="sort">
        <option value="default" <?php selected($sort,'default'); ?>><?php esc_html_e('За замовчуванням','woo-mk-catalog'); ?></option>
        <option value="price-asc" <?php selected($sort,'price-asc'); ?>><?php esc_html_e('Ціна: зростання','woo-mk-catalog'); ?></option>
        <option value="price-desc" <?php selected($sort,'price-desc'); ?>><?php esc_html_e('Ціна: спадання','woo-mk-catalog'); ?></option>
        <option value="date-desc" <?php selected($sort,'date-desc'); ?>><?php esc_html_e('Новинки','woo-mk-catalog'); ?></option>
        <option value="popularity" <?php selected($sort,'popularity'); ?>><?php esc_html_e('Популярність','woo-mk-catalog'); ?></option>
      </select>
    </div>
  </header>

  <div class="woo-mk-catalog__container">
    <aside class="woo-mk-catalog__filters">
      <form id="woo-mk-catalog-form" class="woo-mk-catalog__filters-form" method="get">
        <section class="woo-mk-catalog__filter-card">
          <h3 class="woo-mk-catalog__filter-title"><?php esc_html_e('Категорії','woo-mk-catalog'); ?></h3>
          <div class="woo-mk-catalog__filter-list">
            <?php foreach ($cat_terms as $t): ?>
            <label class="woo-mk-catalog__checkbox">
              <input type="checkbox" name="prod_cat[]" value="<?php echo esc_attr($t->term_id); ?>" <?php checked(in_array($t->term_id, $cats, true)); ?> />
              <span><?php echo esc_html($t->name); ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </section>

        <section class="woo-mk-catalog__filter-card">
          <h3 class="woo-mk-catalog__filter-title"><?php esc_html_e('Ціна','woo-mk-catalog'); ?></h3>
          <div class="woo-mk-catalog__price">
            <div class="woo-mk-catalog__price-row">
              <span>₴<span id="woo-mk-catalog-price-min-val"><?php echo (int)$price_min; ?></span></span>
              <span>—</span>
              <span>₴<span id="woo-mk-catalog-price-max-val"><?php echo (int)$price_max; ?></span></span>
            </div>
            <div class="woo-mk-catalog__range-rows">
              <input id="woo-mk-catalog-price-min" class="woo-mk-catalog__range" name="price_min" type="range" min="<?php echo (int)$price_bounds['min']; ?>" max="<?php echo (int)$price_bounds['max']; ?>" value="<?php echo (int)$price_min; ?>" step="10" />
              <input id="woo-mk-catalog-price-max" class="woo-mk-catalog__range" name="price_max" type="range" min="<?php echo (int)$price_bounds['min']; ?>" max="<?php echo (int)$price_bounds['max']; ?>" value="<?php echo (int)$price_max; ?>" step="10" />
            </div>
          </div>
        </section>

        <?php foreach ($attr_taxonomies as $tx => $terms): ?>
        <section class="woo-mk-catalog__filter-card">
          <h3 class="woo-mk-catalog__filter-title"><?php echo esc_html(wc_attribute_label($tx)); ?></h3>
          <div class="woo-mk-catalog__filter-list">
              <?php foreach ($terms as $t): ?>
            <label class="woo-mk-catalog__checkbox">
              <input type="checkbox" name="<?php echo esc_attr($tx); ?>[]" value="<?php echo esc_attr($t->term_id); ?>" <?php checked(in_array($t->term_id, $attrs[$tx] ?? [], true)); ?> />
              <span><?php echo esc_html($t->name); ?></span>
            </label>
            <?php endforeach; ?>
          </div>
        </section>
        <?php endforeach; ?>

        <button type="submit" class="woo-mk-catalog__apply" style="display:none"></button>
      </form>
    </aside>

    <section class="woo-mk-catalog__content">
      <div class="woo-mk-catalog__grid" id="woo-mk-catalog-grid">
        <?php if ($q->have_posts()): while ($q->have_posts()): $q->the_post(); $pid=get_the_ID(); $product=wc_get_product($pid); ?>
        <article class="woo-mk-catalog__card">
          <a class="woo-mk-catalog__card-link" href="<?php the_permalink(); ?>">
              <?php echo get_the_post_thumbnail($pid, 'woocommerce_thumbnail', ['class'=>'woo-mk-catalog__card-img', 'alt'=>esc_attr(get_the_title())]); ?>
          </a>
          <div class="woo-mk-catalog__card-body">
            <h3 class="woo-mk-catalog__card-title"><a class="woo-mk-catalog__card-title-link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <div class="woo-mk-catalog__card-price"><?php echo $product ? wp_kses_post($product->get_price_html()) : ''; ?></div>
          </div>
        </article>
        <?php endwhile; else: ?>
        <div class="woo-mk-catalog__empty"><?php esc_html_e('Немає товарів за вашим запитом.','woo-mk-catalog'); ?></div>
        <?php endif; wp_reset_postdata(); ?>
      </div>

      <?php
      // Pagination
      $big = 999999999; // need an unlikely integer
      $links = paginate_links([
        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format' => '?paged=%#%',
        'current' => max(1, $paged),
        'total' => max(1, $q->max_num_pages),
        'type' => 'array',
        'prev_text' => '«',
        'next_text' => '»',
      ]);
      if ($links): ?>
      <div class="woo-mk-catalog__pagination" id="woo-mk-catalog-pagination">
        <nav class="woo-mk-catalog__pager">
            <?php foreach ($links as $lnk):
            // Convert WP classes to our ones
            $is_current = strpos($lnk, 'current') !== false;
            $label = wp_strip_all_tags($lnk);
            $href = '#';
            if (preg_match('/href=\"([^\"]+)\"/', $lnk, $m)) { $href = $m[1]; }
            ?>
          <a class="woo-mk-catalog__page<?php echo $is_current ? ' is-active' : ''; ?>" href="<?php echo esc_url($href); ?>"><?php echo esc_html($label); ?></a>
          <?php endforeach; ?>
        </nav>
      </div>
      <?php endif; ?>
    </section>
  </div>
</div>

@php
  the_widget(
    'FooterWidget',
    [
      'use_default'      => true,
    ],
    [
      'before_widget' => '<div class="so-widget so-mkmt-grid">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="section-title">',
      'after_title'   => '</h2>',
    ]
  );
@endphp
