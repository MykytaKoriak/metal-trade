<?php

/*
Widget Name: Banner Widget
Description: Banner Widget
Author: Mykyta Koriak
Author URI: https://github.com/MykytaKoriak
Widget URI: https://github.com/MykytaKoriak/metal-trade
*/

use function Roots\bundle;

class DetailsWidget extends SiteOrigin_Widget
{

    function __construct()
    {
        // Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        // Call the parent constructor with the required arguments.
        parent::__construct(
        // The unique id for your widget.
            'mk-details-widget',

            // The name of the widget for display purposes.
            __('Віджет детальної інформації', 'hello-world-widget-text-domain'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Віджет детальної інформації', 'hello-world-widget-text-domain'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'details_list' => array(
                    'type' => 'repeater',
                    'label' => __('Список блоків', 'mk-metal-trade'),
                    'item_name' => __('Блок детальної інформації', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Заголовок', 'hello-world-widget-text-domain'),
                            'default' => 'Lorem ipsum!',
                        ),
                        'information' => array(
                            'type' => 'tinymce',
                            'label' => __('Інформація', 'mk-metal-trade'),
                            'default' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.
In sit amet sem ac ligula rutrum auctor.
Nullam fringilla sapien augue, lobortis efficitur neque venenatis vitae.
Mauris commodo accumsan elementum. Donec tortor massa, scelerisque eget consectetur sed,
hendrerit et felis. In vel enim viverra, accumsan purus eu, tempor ipsum. Duis ultricies
vestibulum dui. Sed eget lacus vitae nulla sollicitudin vestibulum id eu lorem.',
                            'rows' => 10,
                            'default_editor' => 'html',
                            'button_filters' => array(
                                'mce_buttons' => array($this, 'filter_mce_buttons'),
                                'mce_buttons_2' => array($this, 'filter_mce_buttons_2'),
                                'mce_buttons_3' => array($this, 'filter_mce_buttons_3'),
                                'mce_buttons_4' => array($this, 'filter_mce_buttons_5'),
                                'quicktags_settings' => array($this, 'filter_quicktags_settings'),
                            ),
                        ),
                        'background' => array(
                            'type' => 'media',
                            'label' => __('Виберіть зображення', 'mk-metal-trade'),
                            'choose' => __('Виберіть зображення', 'mk-metal-trade'),
                            'update' => __('Задати зображення', 'mk-metal-trade'),
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
            'details' => []
        ];
        foreach ($instance['details_list'] as $item) {
            $data['details'][] = [
                'title' => $item['title'],
                'information' => $item['information'],
                'background' => wp_get_attachment_url($item['background']),
            ];
        }
        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/details.blade.php", $data);
    }
}

siteorigin_widget_register('mk-details-widget', __FILE__, 'DetailsWidget');
