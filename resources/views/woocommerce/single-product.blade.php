@php
  defined('ABSPATH') || exit();

  /** @var WC_Product $product */
  $product = wc_get_product(get_the_ID());
  if (! $product) return;

  // Images
  $attachment_ids = $product->get_gallery_image_ids();
  $main_id = $product->get_image_id();
  if ($main_id) { array_unshift($attachment_ids, $main_id); $attachment_ids = array_unique($attachment_ids); }

  // Rating
  $average = floatval($product->get_average_rating());
  $review_count = intval($product->get_review_count());
  $rating_html = wc_get_rating_html($average);

  // Price
  $price_html = $product->get_price_html();

  // Description capture
  $desc = apply_filters('the_content', $product->get_description());

  // Specs/at = ob_get_clean();

    $attributes = $product->get_attributes();
// Optional delivery info via ACF field or term meta (fallback text)
  $delivery_text = apply_filters('woocommerce_short_description', $product->get_short_description());
  if (!$delivery_text) {
    $delivery_text = __('Доставляємо по Україні: Нова Пошта, кур\'єр, самовивіз.', 'sage');
  }

  $form_id = get_field("contact_form_id", get_the_ID());
  $buy_buttons = get_field("buy_button_list", get_the_ID());

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

<div class="woo-product" data-component="woo-product">
  <div class="wp-card">
    <div class="wp-card__body">
      <div class="wp-grid">

        <!-- Left: Gallery + short lists -->
        <div class="wp-gallery">
          <div class="wp-thumbs" role="list">
            @foreach($attachment_ids as $idx => $att_id)
              @php
                $thumb = wp_get_attachment_image($att_id, 'woocommerce_gallery_thumbnail', false, ['alt' => get_post_meta($att_id, '_wp_attachment_image_alt', true)]);
              @endphp
              <button class="wp-thumb {{ $idx === 0 ? 'is-active' : '' }}" role="listitem"
                      data-image="#img-{{ $idx }}">{!! $thumb !!}</button>
            @endforeach
          </div>

          <div class="wp-image">
            {{--            TODO: ПЕРЕДЕЛАТЬ НА DIV с бекграундом и убрать абсолюты --}}
            @foreach($attachment_ids as $idx => $att_id)
              {!! wp_get_attachment_image($att_id, array( 400, 400 ), false, [
                    'id' => 'img-'.$idx,
                    'class' => 'wp-image__item '.($idx === 0 ? 'is-active' : ''),
                    'alt' => get_post_meta($att_id, '_wp_attachment_image_alt', true)
              ]) !!}
            @endforeach
          </div>
        </div>

        <!-- Right: Product info -->
        <div class="wp-info">
          <h1 class="wp-title">{!! $product->get_name() !!}</h1>

          {{--          <div class="wp-rating" aria-label="{{ sprintf(__('Рейтинг: %s з 5', 'sage'), $average) }}">--}}
          {{--            <span class="wp-stars" aria-hidden="true">{!! $rating_html !!}</span>--}}
          {{--            <a href="#reviews" class="wp-reviews">{{ $review_count }} {{ _n('відгук', 'відгуків', $review_count, 'sage') }}</a>--}}
          {{--          </div>--}}

          <div class="wp-price">{!! wp_kses_post($price_html) !!}</div>

          {{-- Variants (chips generated from selects via JS) --}}
          @if($product->is_type('variable'))
            <div class="wp-variant">
              <div class="wp-variant__label">{{ __('Варіанти', 'sage') }}</div>
              <div class="wp-variant__grid" data-build-from-selects="true"></div>
            </div>
          @endif

          <div class="wp-actions">
            <div class="wp-woo-form" style="
                    display: flex;
                    flex-direction: column;">
              {{-- WooCommerce add to cart (simple/variable/grouped are handled automatically) --}}
              {{--              @php woocommerce_template_single_add_to_cart(); @endphp--}}
              @foreach($buy_buttons as $button)
                <a href="{{ $button['market_product_link'] }}" class="wp-btn" style="background-color: {{ $button['button_color'] }};
                    color: {{ $button['text_color'] }};
                    display: flex;
                    align-items: center;
                    justify-content: center;"
                   data-action="quote">
                  <img src="{{ $button['market_image']['url'] }} }}" alt="{{$button['button_text']}}"
                       style="height: 30px; width: 30px; margin-right: 5px">
                  {{ __($button['button_text'], 'sage') }}</a>

              @endforeach
            </div>
            <button type="button" id="order_calculation_form" class="wp-btn"
                    data-action="quote">{{ __('Замовити розрахунок', 'sage') }}</button>
          </div>

          <div class="wp-badges">
            <div class="wp-badge">
              <span class="wp-icon" aria-hidden="true">🚚</span>
              <span>{{ __('Доставка по всій Україні', 'sage') }}</span>
            </div>
          </div>

          <div class="wp-tabs" role="tablist">
            <button class="wp-tab" role="tab" aria-controls="tab-desc"
                    aria-selected="false">{{ __('Опис', 'sage') }}</button>
            <button class="wp-tab is-active" role="tab" aria-controls="tab-specs"
                    aria-selected="true">{{ __('Характеристики', 'sage') }}</button>
            <button class="wp-tab" role="tab" aria-controls="tab-delivery"
                    aria-selected="false">{{ __('Доставка', 'sage') }}</button>
          </div>
          <div class="wp-tabpanes">
            <div id="tab-desc" class="wp-pane" role="tabpanel">
              {!! $desc !!}
            </div>
            <div id="tab-specs" class="wp-pane is-active" role="tabpanel">
              @foreach($attributes as $attr)
                @if(method_exists($attr,'is_visible') ? $attr->is_visible() : true)
                  <p>{{ wc_attribute_label($attr->get_name()) }}
                    : {!! wc_implode_text_attributes($attr->get_options()) !!}</p>
                @endif
              @endforeach
            </div>
            <div id="tab-delivery" class="wp-pane" role="tabpanel">
              <p>{!! $delivery_text !!}</p>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="wc-popup-form">
    {{--    <pre>--}}
    @php
      $form = get_field("contact_form", get_the_ID());
  //    var_dump($form);
        $form_html = do_shortcode($form);
        echo $form_html;
  //      var_dump($form_html)

    @endphp
    {{--    </pre>--}}
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


{{--@push('styles')--}}
{{--  --}}{{-- Ensure your asset pipeline enqueues the component stylesheet --}}
{{--  --}}{{-- <link rel="stylesheet" href="@asset('styles/woo-product.css')"> --}}
{{--@endpush--}}

{{--@push('scripts')--}}
{{--  --}}{{-- jQuery should be available in WordPress; enqueue if not. --}}
{{--  --}}{{-- <script src="@asset('scripts/woo-product.js')" defer></script> --}}
{{--@endpush--}}
