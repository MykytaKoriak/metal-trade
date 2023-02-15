<?php

/*
Widget Name: Banner Widget
Description: Banner Widget
Author: Mykyta Koriak
Author URI: https://github.com/MykytaKoriak
Widget URI: https://github.com/MykytaKoriak/metal-trade
*/

use function Roots\bundle;

class ServicesWidget extends SiteOrigin_Widget
{

    function __construct()
    {
        // Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        // Call the parent constructor with the required arguments.
        parent::__construct(
        // The unique id for your widget.
            'mk-services-widget',

            // The name of the widget for display purposes.
            __('Віджет блоку послуг', 'hello-world-widget-text-domain'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Віджет блоку послуг', 'hello-world-widget-text-domain'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'a_repeater' => array(
                    'type' => 'repeater',
                    'label' => __('Послуги', 'widget-form-fields-text-domain'),
                    'item_name' => __('Послуга', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Назва послуги.', 'hello-world-widget-text-domain'),
                            'default' => 'Lorem ipsum!',
                        ),
                        'subtitle' => array(
                            'type' => 'text',
                            'label' => __('Короткий опис послуги.', 'hello-world-widget-text-domain'),
                            'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
                        ),
                        'background' => array(
                            'type' => 'media',
                            'label' => __('Виберіть зображення фону', 'widget-form-fields-text-domain'),
                            'choose' => __('Виберіть зображення', 'widget-form-fields-text-domain'),
                            'update' => __('Задати зображення', 'widget-form-fields-text-domain'),
                            'library' => 'image',
                            'fallback' => false
                        )
                    )
                )
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
            'services' => []
        ];
        foreach ($instance['a_repeater'] as $item) {
            $data['services'][] = [
                'title' => $item['title'],
                'subtitle' => $item['subtitle'],
                'background' => wp_get_attachment_url($item['background']),
            ];
        }
        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/services.blade.php", $data);
    }
}

siteorigin_widget_register('mk-services-widget', __FILE__, 'ServicesWidget');
