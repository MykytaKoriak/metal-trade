<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

add_filter('gettext', function ($translation, $text, $domain) {

    // Меняем только в плагине WooCommerce и только нужную строку
    if ($domain === 'woocommerce' && $text === 'Product short description') {
        // Здесь пишем свой текст вместо "Короткий опис товару"
        return 'Тест блоку "Доставка"'; // твой вариант
    }

    return $translation;
}, 10, 3);
