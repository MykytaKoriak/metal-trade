<?php

/*
Widget Name: Banner Widget
Description: Banner Widget
Author: Mykyta Koriak
Author URI: https://github.com/MykytaKoriak
Widget URI: https://github.com/MykytaKoriak/metal-trade
*/

use function Roots\bundle;

class ContactPageWidget extends SiteOrigin_Widget
{

    function __construct()
    {
        // Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        // Call the parent constructor with the required arguments.
        parent::__construct(
        // The unique id for your widget.
            'mk-contact-page-widget',

            // The name of the widget for display purposes.
            __('Віджет сторінки контактів', 'hello-world-widget-text-domain'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Віджет сторінки контактів', 'hello-world-widget-text-domain'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'map' => array(
                    'type' => 'text',
                    'label' => __('Shortcode для мапи.', 'hello-world-widget-text-domain'),
                    'default' => '[]',
                ),
                'title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для блоку контактів.', 'hello-world-widget-text-domain'),
                    'default' => 'Hello world!',
                ),
                'contact_blocks' => array(
                    'type' => 'repeater',
                    'label' => __('Контактна інформація', 'widget-form-fields-text-domain'),
                    'item_name' => __('Блок контактної інформації', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Заголовок блоку.', 'hello-world-widget-text-domain'),
                            'default' => 'Lorem ipsum!',
                        ),
                        'info_1' => array(
                            'type' => 'text',
                            'label' => __('Інформація блоку.', 'hello-world-widget-text-domain'),
                            'default' => 'Lorem ipsum!',
                        ),
                        'info_2' => array(
                            'type' => 'text',
                            'label' => __('Інформація блоку.', 'hello-world-widget-text-domain'),
                            'default' => 'Lorem ipsum!',
                        ),
                    )
                ),
                'join_title' => array(
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
                        'icon' => array(
                            'type' => 'media',
                            'label' => __('Виберіть значок соціальної мережі', 'widget-form-fields-text-domain'),
                            'choose' => __('Виберіть значок соціальної мережі', 'widget-form-fields-text-domain'),
                            'update' => __('Задати Виберіть значок соціальної мережі', 'widget-form-fields-text-domain'),
                            'library' => 'image',
                            'fallback' => false
                        )
                    )
                ),
                'button_text' => array(
                    'type' => 'text',
                    'label' => __('Текст на кнопці.', 'hello-world-widget-text-domain'),
                    'default' => 'Hello world!',
                ),
                'popup_title' => array(
                    'type' => 'Заголовок для вспливаючого вікна',
                    'label' => __('Заголовок для блоку контактів.', 'hello-world-widget-text-domain'),
                    'default' => 'Hello world!',
                ),
                'popup_form' => array(
                    'type' => 'text',
                    'label' => __('Shortcode для форми.', 'hello-world-widget-text-domain'),
                    'default' => '[]',
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
            'map' => $instance['map'],
            'title' => $instance['title'],
            'contact_blocks' => $instance['contact_blocks'],
            'join_title' => $instance['join_title'],
            'button_text' => $instance['button_text'],
            'popup_title' => $instance['popup_title'],
            'popup_form' => $instance['popup_form'],
            'social_list' => []
        ];
        foreach ($instance['social_list'] as $item) {
            $data['social_list'][] = [
                'url' => $item['social'],
                'icon' => wp_get_attachment_url($item['icon']),
            ];
        }

        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/contact-page.blade.php", $data);
    }
}

siteorigin_widget_register('mk-contact-page-widget', __FILE__, 'ContactPageWidget');
