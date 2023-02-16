<?php

/*
Widget Name: Banner Widget
Description: Banner Widget
Author: Mykyta Koriak
Author URI: https://github.com/MykytaKoriak
Widget URI: https://github.com/MykytaKoriak/metal-trade
*/

use function Roots\bundle;

class FooterWidget extends SiteOrigin_Widget
{

    function __construct()
    {
        // Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        // Call the parent constructor with the required arguments.
        parent::__construct(
        // The unique id for your widget.
            'mk-footer-widget',

            // The name of the widget for display purposes.
            __('Віджет футера', 'hello-world-widget-text-domain'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Віджет футера', 'hello-world-widget-text-domain'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для футера.', 'hello-world-widget-text-domain'),
                    'default' => 'Hello world!',
                ),
                'sitemap_title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для карти сайту.', 'hello-world-widget-text-domain'),
                    'default' => 'Hello world!',
                ),
                'sitemap' => array(
                    'type' => 'repeater',
                    'label' => __('Карта сайту', 'widget-form-fields-text-domain'),
                    'item_name' => __('Посилання', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Назва сторінки.', 'hello-world-widget-text-domain'),
                            'default' => 'Lorem ipsum!',
                        ),
                        'link' => array(
                            'type' => 'link',
                            'label' => __('Посилання на сторінку', 'hello-world-widget-text-domain'),
                            'default' => 'http://www.example.com',
                        ),
                    )
                ),
                'phone_list' => array(
                    'type' => 'repeater',
                    'label' => __('Список номерів телефонів', 'widget-form-fields-text-domain'),
                    'item_name' => __('Номер телефону', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'phone' => array(
                            'type' => 'text',
                            'label' => __('Номер телефону', 'hello-world-widget-text-domain'),
                            'default' => '+380957777777',
                        ),
                    )
                ),
                'email_list' => array(
                    'type' => 'repeater',
                    'label' => __('Список електронних пошт', 'widget-form-fields-text-domain'),
                    'item_name' => __('Електронна пошта', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'email' => array(
                            'type' => 'text',
                            'label' => __('Електронна пошта', 'hello-world-widget-text-domain'),
                            'default' => 'example@example.com',
                        ),
                    )
                ),
                'social_title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для підблоку соціальних мереж.', 'hello-world-widget-text-domain'),
                    'default' => 'Hello world!',
                ),
                'social_list' => array(
                    'type' => 'repeater',
                    'label' => __('Список соціальних мереж', 'widget-form-fields-text-domain'),
                    'item_name' => __('Соціальна мережа', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'social' => array(
                            'type' => 'link',
                            'label' => __('Соціальна мережа', 'hello-world-widget-text-domain'),
                            'default' => 'http://www.example.com',
                        ),
                        'text' => array(
                            'type' => 'text',
                            'label' => __('Назва соціальної мережі.', 'hello-world-widget-text-domain'),
                            'default' => 'LINKEGRAM',
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
        $data = [
            'title' => $instance['title'],
            'sitemap_title' => $instance['sitemap_title'],
            'sitemap' => [],
            'phone_list' => $instance['phone_list'],
            'email_list' => $instance['email_list'],
            'social_title' => $instance['social_title'],
            'social_list' => [],
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
                    'text' =>$item['text'],
                    'social' => get_permalink(intval($post_id))
                ];
            } else{
                $data['social_list'][] = [
                    'text' =>$item['text'],
                    'social' => $item['social']
                ];
            }
        }
        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/footer.blade.php", $data);
    }
}

siteorigin_widget_register('mk-footer-widget', __FILE__, 'FooterWidget');
