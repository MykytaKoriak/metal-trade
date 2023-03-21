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
            __('Віджет футера', 'mk-metal-trade'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Віджет футера', 'mk-metal-trade'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'use_default' => array(
                    'type' => 'checkbox',
                    'label' => __('Використовувати глобальні значення', 'mk-metal-trade'),
                    'default' => false
                ),
                'title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для футера.', 'mk-metal-trade'),
                    'default' => '',
                ),
                'sitemap_title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для карти сайту.', 'mk-metal-trade'),
                    'default' => '',
                ),
                'sitemap' => array(
                    'type' => 'repeater',
                    'label' => __('Карта сайту', 'mk-metal-trade'),
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
                'email_list' => array(
                    'type' => 'repeater',
                    'label' => __('Список електронних пошт', 'mk-metal-trade'),
                    'item_name' => __('Електронна пошта', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'email' => array(
                            'type' => 'text',
                            'label' => __('Електронна пошта', 'mk-metal-trade'),
                            'default' => '',
                        ),
                    )
                ),
                'social_title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для підблоку соціальних мереж.', 'mk-metal-trade'),
                    'default' => '',
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
                        'text' => array(
                            'type' => 'text',
                            'label' => __('Назва соціальної мережі.', 'mk-metal-trade'),
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

        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/footer.blade.php", $data);
    }

    private function processing_data($instance)
    {
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
            if (strpos($item['link'], "post: ") !== false) {
                $post_id = str_replace("post: ", "", $item['link']);
                $data['sitemap'][] = [
                    'title' => $item['title'],
                    'link' => get_permalink(intval($post_id))
                ];
            } else {
                $data['sitemap'][] = [
                    'title' => $item['title'],
                    'link' => $item['link']
                ];
            }
        }

        foreach ($instance['social_list'] as $item) {
            if (strpos($item['social'], "post: ") !== false) {
                $post_id = str_replace("post: ", "", $item['social']);
                $data['social_list'][] = [
                    'text' => $item['text'],
                    'social' => get_permalink(intval($post_id))
                ];
            } else {
                $data['social_list'][] = [
                    'text' => $item['text'],
                    'social' => $item['social']
                ];
            }
        }
        return $data;
    }

    private function load_default_data()
    {
        $global_data = get_field("footer_general_data", "option");
        $data = [
            'title' => $global_data['footer_title'],
            'sitemap_title' => $global_data['sitemap_title'],
            'sitemap' => [],
            'phone_list' => $global_data['phone_list'],
            'email_list' => $global_data['email_list'],
            'social_title' => $global_data['social_title'],
            'social_list' => $global_data['social_networks'],
        ];
        foreach ($global_data['sitemap'] as $item) {
            $data['sitemap'][] = [
                'title' => $item['link_name'],
                'link' => $item['link']
            ];
        }
//        foreach ($global_data['phone_list'] as $item) {
//            $data['phone_list'][] = [
//                'phone' => $item['phone'],
//            ];
//        }
//        foreach ($global_data['email_list'] as $item) {
//            $data['email_list'][] = [
//                'email' => $item['email'],
//            ];
//        }
        foreach ($global_data['social_networks'] as $item) {
            $data['social_list'][] = [
                'text' => $item['text'],
                'social' => $item['social']
            ];
        }
        return $data;
    }
}

siteorigin_widget_register('mk-footer-widget', __FILE__, 'FooterWidget');
