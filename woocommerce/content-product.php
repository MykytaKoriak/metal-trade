<?php
use Roots\view;

defined('ABSPATH') || exit;

// Woo шлёт глобальный $product и контекст цикла
echo view('woocommerce.partials.product-card', [
    // можно дополнительно пробросить данные
])->render();
