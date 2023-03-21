<?php

/*
Widget Name: Banner Widget
Description: Banner Widget
Author: Mykyta Koriak
Author URI: https://github.com/MykytaKoriak
Widget URI: https://github.com/MykytaKoriak/metal-trade
*/

use function Roots\bundle;

class HeaderMenuWidget extends SiteOrigin_Widget
{

    function __construct()
    {
        // Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        // Call the parent constructor with the required arguments.
        parent::__construct(
        // The unique id for your widget.
            'mk-header-menu-widget',

            // The name of the widget for display purposes.
            __('Шапка сайту з меню', 'mk-metal-trade'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Шапка сайту з меню', 'mk-metal-trade'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'use_default' => array(
                    'type' => 'checkbox',
                    'label' => __( 'Використовувати глобальні значення', 'mk-metal-trade' ),
                    'default' => false
                ),
                'logo' => array(
                    'type' => 'media',
                    'label' => __('Виберіть зображення логотипу', 'mk-metal-trade'),
                    'choose' => __('Виберіть зображення', 'mk-metal-trade'),
                    'update' => __('Задати зображення', 'mk-metal-trade'),
                    'library' => 'image',
                    'fallback' => false
                ),
                'dark_logo' => array(
                    'type' => 'media',
                    'label' => __('Виберіть зображення темного логотипу', 'mk-metal-trade'),
                    'choose' => __('Виберіть зображення', 'mk-metal-trade'),
                    'update' => __('Задати зображення', 'mk-metal-trade'),
                    'library' => 'image',
                    'fallback' => false
                ),
                'sitemap' => array(
                    'type' => 'repeater',
                    'label' => __('Меню', 'mk-metal-trade'),
                    'item_name' => __('Посилання', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Назва сторінки.', 'mk-metal-trade'),
                            'default' => '',
                        ),
                        'link' => array(
                            'type' => 'link',
                            'label' => __('Посилання на сторінку', 'mk-metal-trade'),
                            'default' => '',
                        ),
                    )
                ),
                'social_list' => array(
                    'type' => 'repeater',
                    'label' => __('Список соціальних мереж', 'mk-metal-trade'),
                    'item_name' => __('Соціальна мережа', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'social' => array(
                            'type' => 'link',
                            'label' => __('Соціальна мережа', 'mk-metal-trade'),
                            'default' => '',
                        ),
                        'icon' => array(
                            'type' => 'media',
                            'label' => __('Виберіть значок соціальної мережі', 'mk-metal-trade'),
                            'choose' => __('Виберіть значок соціальної мережі', 'mk-metal-trade'),
                            'update' => __('Задати Виберіть значок соціальної мережі', 'mk-metal-trade'),
                            'library' => 'image',
                            'fallback' => false
                        )
                    )
                ),
                'phone_list' => array(
                    'type' => 'repeater',
                    'label' => __('Список номерів телефонів', 'mk-metal-trade'),
                    'item_name' => __('Номер телефону', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'phone' => array(
                            'type' => 'text',
                            'label' => __('Номер телефону', 'mk-metal-trade'),
                            'default' => '',
                        ),
                    )
                ),
            ),

            // The $base_folder path string.
            plugin_dir_path(__FILE__)
        );
    }

    function get_html_content($instance, $args, $template_vars, $css_name)
    {
        if (isset($instance['is_preview'])) {
            bundle('app')->enqueue();
        }

        if (!$instance['use_default']) {
            $data = $this->processing_data($instance);
        } else {
            $data = $this->load_default_data();
        }

        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/header-menu.blade.php", $data);
    }

    private function processing_data($instance){
        $data = [
            'sitemap' => [],
            'social_list' => [],
            'phone_list' => $instance['phone_list'],
            'logo' => wp_get_attachment_url($instance['logo']),
            'dark_logo' => wp_get_attachment_url($instance['dark_logo']),
        ];

        foreach ($instance['sitemap'] as $item) {
            if(strpos($item['link'], "post: ") !== false){
                $post_id = str_replace("post: ", "", $item['link']);
                $data['sitemap'][] = [
                    'title' =>$item['title'],
                    'link' => get_permalink(intval($post_id))
                ];
            } else{
                $data['sitemap'][] = [
                    'title' =>$item['title'],
                    'link' => $item['link']
                ];
            }
        }

        foreach ($instance['social_list'] as $item) {
            if(strpos($item['social'], "post: ") !== false){
                $post_id = str_replace("post: ", "", $item['social']);
                $data['social_list'][] = [
                    'icon' => wp_get_attachment_url($item['icon']),
                    'url' => get_permalink(intval($post_id))
                ];
            } else{
                $data['social_list'][] = [
                    'icon' => wp_get_attachment_url($item['icon']),
                    'url' => $item['social']
                ];
            }
        }
        return $data;
    }


    private function load_default_data(){
        $global_data = get_field("header_general_data", "option");

        $data = [
            'sitemap' => [],
            'social_list' => [],
            'phone_list' => $global_data['phone_numbers'],
            'logo' => $global_data['light_logo'],
            'dark_logo' => $global_data['dark_logo'],
        ];

        foreach ($global_data['menu_links'] as $item) {
            $data['sitemap'][] = [
                'title' =>$item['link_name'],
                'link' => $item['link']
            ];
        }

        foreach ($global_data['social_network'] as $item) {
            $data['social_list'][] = [
                'icon' => $item['social_icon'],
                'url' => $item['social_url']
            ];
        }
        return $data;
    }

}

siteorigin_widget_register('mk-header-menu-widget', __FILE__, 'HeaderMenuWidget');
