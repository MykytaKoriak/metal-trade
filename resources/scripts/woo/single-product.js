(function ($) {
  // Scope all behavior to the .woo-product root
  $(function () {
    var $root = $('.woo-product');
    if (!$root.length) return;

    // Thumbnail -> switch main image
    $root.on('click', '.wp-thumb', function () {
      var $btn = $(this);
      var target = $btn.data('image');
      // update selected state
      $btn.addClass('is-active').siblings().removeClass('is-active');
      // show corresponding image
      var $img = $root.find('.wp-image__item');
      $img.removeClass('is-active');
      $root.find(String(target)).addClass('is-active');
    });

    // Variant chips selection
    $root.on('click', '.wp-chip', function () {
      var $chip = $(this);
      $chip.addClass('is-selected').siblings('.wp-chip').removeClass('is-selected');
      // You can emit a custom event if needed
      $root.trigger('wp:variant-change', [$chip.data('value')]);
    });

    // Tabs
    $root.on('click', '.wp-tab', function () {
      var $tab = $(this);
      var panelId = $tab.attr('aria-controls');
      $tab.addClass('is-active').attr('aria-selected', 'true')
        .siblings('.wp-tab').removeClass('is-active').attr('aria-selected', 'false');
      $root.find('.wp-pane').removeClass('is-active');
      $root.find('#' + panelId).addClass('is-active');
    });

    // Action buttons demo handlers (replace with integration)
    $root.on('click', '[data-action=buy]', function () {
      var size = $root.find('.wp-chip.is-selected').data('value');
      console.log('[woo-product] Купити, розмір:', size);
    });
    $root.on('click', '[data-action=quote]', function () {
      var size = $root.find('.wp-chip.is-selected').data('value');
      console.log('[woo-product] Запит розрахунку, розмір:', size);
    });

    // WooCommerce: enhance add-to-cart form inside this block
    var $form = $root.find('form.variations_form, form.cart');
    // Style the primary button if present
    $root.find('.single_add_to_cart_button').addClass('wp-btn wp-btn--primary');

    // Build chips for each attribute select (if present)
    var $grid = $root.find('.wp-variant__grid[data-build-from-selects=true]');
    if ($form.length && $grid.length) {
      $form.find('select[name^="attribute_"]').each(function () {
        var $select = $(this);
        var current = $select.val();
        $select.addClass('is-hidden');

        $select.find('option').each(function () {
          var val = $(this).attr('value');
          var label = $(this).text();
          if (!val) return; // skip placeholder
          var $chip = $('<button/>', {
            type: 'button',
            class: 'wp-chip' + (val === current ? ' is-selected' : ''),
            'data-value': val,
            text: label
          });
          $grid.append($chip);
        });

        // clicking chip selects the option
        $grid.on('click', '.wp-chip', function () {
          var val = $(this).data('value');
          // set and trigger change to refresh variation availability
          $select.val(val).trigger('change');
          $(this).addClass('is-selected').siblings('.wp-chip').removeClass('is-selected');
        });

        // keep chip state in sync when select value changes programmatically
        $select.on('change', function () {
          var v = $select.val();
          $grid.find('.wp-chip').each(function () {
            $(this).toggleClass('is-selected', $(this).data('value') === v);
          });
        });
      });
    }
  });
})(jQuery);

jQuery(function ($) {

  var $popup = $('.wc-popup-form');

  if (!$popup.length) return;

  // чи була успішна відправка форми в цьому попапі
  var successSent = false;

  // На старті переконуємось, що попап закритий
  $popup.removeClass('is-open');

  // Додаємо кнопку-хрестик, якщо її немає в HTML
  if (!$popup.find('.wc-popup-close').length) {
    $popup.find('.wpcf7').prepend(
      '<button type="button" class="wc-popup-close" aria-label="Закрити">&times;</button>'
    );
  }

  // Відкрити попап по кліку на кнопку
  $('#order_calculation_form').on('click', function (e) {
    e.preventDefault();
    $popup.addClass('is-open');
  });

  // Єдина функція закриття попапа
  function closePopup() {
    $popup.removeClass('is-open');

    // Якщо не було успішної відправки — просто чистимо форму
    var form = $popup.find('form')[0];
    if (form && !successSent) {
      form.reset();
    }

    // Прибираємо повідомлення про успіх (якщо було)
    $popup.find('.wc-popup-success').remove();

    // Повертаємо форму, якщо її ховали
    $popup.find('.wpcf7-form').show();

    // Якщо форма була УСПІШНО відправлена — перезавантажуємо сторінку
    if (successSent) {
      successSent = false; // скидаємо прапорець
      window.location.reload();
    }
  }

  // Закриття по хрестику
  $popup.on('click', '.wc-popup-close', function () {
    closePopup();
  });

  // Закриття по кліку на фон (тільки якщо клік саме по overlay, а не по формі)
  $popup.on('click', function (e) {
    if (e.target === this) {
      closePopup();
    }
  });

  // Закриття по Esc
  $(document).on('keyup', function (e) {
    if (e.key === 'Escape' && $popup.hasClass('is-open')) {
      closePopup();
    }
  });

  /**
   * Contact Form 7 – успішна відправка
   * Слухаємо глобальну подію wpcf7mailsent,
   * але реагуємо тільки на форму з ID 533
   */
  document.addEventListener('wpcf7mailsent', function (event) {
    if (event.detail && event.detail.contactFormId == 533) {

      successSent = true;

      var $form = $popup.find('.wpcf7-form');

      // Ховаємо форму всередині попапа
      $form.fadeOut(200, function () {
        // Додаємо повідомлення успіху
        $popup.find('.wpcf7').append(
          '<div class="wc-popup-success">' +
          '<h3>Дякуємо!</h3>' +
          '<p>Ваша заявка успішно відправлена.<br>Очікуйте дзвінка від менеджера найближчим часом.</p>' +
          '</div>'
        );

        $popup.find('.wc-popup-success').hide().fadeIn(300);
      });

      // ⛔ Автоматично попап НЕ закриваємо.
      // Користувач читає повідомлення і сам натискає хрестик
      // або клікає по фону / натискає Esc → тоді спрацьовує closePopup(),
      // який, бачачи successSent === true, зробить reload сторінки.
    }
  }, false);

});
