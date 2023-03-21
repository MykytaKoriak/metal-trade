<?php

/*
Widget Name: Banner Widget
Description: Banner Widget
Author: Mykyta Koriak
Author URI: https://github.com/MykytaKoriak
Widget URI: https://github.com/MykytaKoriak/metal-trade
*/

use function Roots\bundle;

class SimpleContentWidget extends SiteOrigin_Widget
{

    function __construct()
    {
        // Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        // Call the parent constructor with the required arguments.
        parent::__construct(
        // The unique id for your widget.
            'mk-simple-content-widget',

            // The name of the widget for display purposes.
            __('Віджет головного банеру', 'hello-world-widget-text-domain'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Віджет головного банеру', 'hello-world-widget-text-domain'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'text' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для баннера.', 'hello-world-widget-text-domain'),
                    'default' => 'Hello world!',
                ),
                'background' => array(
                    'type' => 'media',
                    'label' => __('Виберіть зображення фону', 'mk-metal-trade'),
                    'choose' => __('Виберіть зображення', 'mk-metal-trade'),
                    'update' => __('Задати зображення', 'mk-metal-trade'),
                    'library' => 'image',
                    'fallback' => false
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
            'tagline' => $instance['text'],
            'background' => wp_get_attachment_url($instance['background']),
        ];
        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/mk-banner.blade.php", $data);
    }
}

siteorigin_widget_register('mk-simple-content-widget', __FILE__, 'SimpleContentWidget');
