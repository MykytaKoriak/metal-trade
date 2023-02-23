<?php

// Register Custom Post Type
function product_post_type() {

    $labels = array(
        'name'                  => _x( 'Продукти', 'Post Type General Name', 'metal-trade' ),
        'singular_name'         => _x( 'Продукт', 'Post Type Singular Name', 'metal-trade' ),
        'menu_name'             => __( 'Продукти', 'metal-trade' ),
        'name_admin_bar'        => __( 'Продукт', 'metal-trade' ),
        'archives'              => __( 'Архів продуктів', 'metal-trade' ),
        'attributes'            => __( 'Атрибути продукта', 'metal-trade' ),
        'parent_item_colon'     => __( 'Батьківський продукт', 'metal-trade' ),
        'all_items'             => __( 'Всі продукти', 'metal-trade' ),
        'add_new_item'          => __( 'Додати новий продукт', 'metal-trade' ),
        'add_new'               => __( 'Додати новий', 'metal-trade' ),
        'new_item'              => __( 'Новий продукт', 'metal-trade' ),
        'edit_item'             => __( 'Редагувати продукт', 'metal-trade' ),
        'update_item'           => __( 'Оновити продукт', 'metal-trade' ),
        'view_item'             => __( 'Подивитись продукт', 'metal-trade' ),
        'view_items'            => __( 'Подивитись продукти', 'metal-trade' ),
        'search_items'          => __( 'Знайти продукт', 'metal-trade' ),
        'not_found'             => __( 'Не знайдено', 'metal-trade' ),
        'not_found_in_trash'    => __( 'Не знайдено в видалених', 'metal-trade' ),
        'featured_image'        => __( 'Зображення', 'metal-trade' ),
        'set_featured_image'    => __( 'Задати зображення', 'metal-trade' ),
        'remove_featured_image' => __( 'Видалити зображення', 'metal-trade' ),
        'use_featured_image'    => __( 'Використовувати як стандартне зображення', 'metal-trade' ),
        'insert_into_item'      => __( 'Вставити до продукту', 'metal-trade' ),
        'uploaded_to_this_item' => __( 'Завантажити до цього продукту', 'metal-trade' ),
        'items_list'            => __( 'Список продуктів', 'metal-trade' ),
        'items_list_navigation' => __( 'Навігація по списку продуктів', 'metal-trade' ),
        'filter_items_list'     => __( 'Фільтрація списку продуктів', 'metal-trade' ),
    );
    $args = array(
        'label'                 => __( 'Продукт', 'metal-trade' ),
        'description'           => __( 'Продукт', 'metal-trade' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'custom-fields', 'page-attributes' ),
        'taxonomies'            => array( 'category' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
    );
    register_post_type( 'mk_product', $args );

}
add_action( 'init', 'product_post_type', 0 );
