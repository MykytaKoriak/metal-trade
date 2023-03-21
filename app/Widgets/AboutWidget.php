<?php

/*
Widget Name: About Company Widget
Description: About Company Widget
Author: Mykyta Koriak
Author URI: https://github.com/MykytaKoriak
Widget URI: https://github.com/MykytaKoriak/metal-trade
*/

use function Roots\bundle;

class AboutWidget extends SiteOrigin_Widget
{

    function __construct()
    {
        // Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        // Call the parent constructor with the required arguments.
        parent::__construct(
        // The unique id for your widget.
            'mk-about-widget',

            // The name of the widget for display purposes.
            __('Віджет "Про компанію"', 'hello-world-widget-text-domain'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Віджет "Про компанію', 'hello-world-widget-text-domain'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'background' => array(
                    'type' => 'media',
                    'label' => __('Виберіть зображення фону', 'mk-metal-trade'),
                    'choose' => __('Виберіть зображення', 'mk-metal-trade'),
                    'update' => __('Задати зображення', 'mk-metal-trade'),
                    'library' => 'image',
                    'fallback' => false
                ),
                'text' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для блоку.', 'hello-world-widget-text-domain'),
                    'default' => 'Hello world!',
                ),
                'content' => array(
                    'type' => 'tinymce',
                    'label' => __('Введіть тест про компанію', 'mk-metal-trade'),
                    'default' => 'Ми - це ті, про кого ви думаєте, коли хочете, щоб це було зроблено правильно!',
                    'rows' => 10,
                    'default_editor' => 'html',
                    'button_filters' => array(
                        'mce_buttons' => array($this, 'filter_mce_buttons'),
                        'mce_buttons_2' => array($this, 'filter_mce_buttons_2'),
                        'mce_buttons_3' => array($this, 'filter_mce_buttons_3'),
                        'mce_buttons_4' => array($this, 'filter_mce_buttons_5'),
                        'quicktags_settings' => array($this, 'filter_quicktags_settings'),
                    ),
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
            'title' => $instance['text'],
            'content' => $instance['content'],
            'background' => wp_get_attachment_image_url($instance['background'], "large"),
            'background_height' => 0
        ];

        $background_data = wp_get_attachment_image_src($instance['background'], "large");
        if (isset($background_data[2])) {
            $data['background_height'] = $background_data[2];
        } else {
            $data['background_height'] = 500;
        }
        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/about.blade.php", $data);
    }
}

siteorigin_widget_register('mk-about-widget', __FILE__, 'AboutWidget');
