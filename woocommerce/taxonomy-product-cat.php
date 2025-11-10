<?php
/**
 * Shop / архив товаров
 */
use Roots\view;

defined('ABSPATH') || exit;

//get_header('shop');

echo view('woocommerce.archive-product', [
    // сюда можно передать свои данные при необходимости
])->render();

//get_footer('shop');
