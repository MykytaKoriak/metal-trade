<?php

/*
Widget Name: Banner Widget
Description: Banner Widget
Author: Mykyta Koriak
Author URI: https://github.com/MykytaKoriak
Widget URI: https://github.com/MykytaKoriak/metal-trade
*/

use function Roots\bundle;

class ContactsWidget extends SiteOrigin_Widget
{

    function __construct()
    {
        // Here you can do any preparation required before calling the parent constructor, such as including additional files or initializing variables.

        // Call the parent constructor with the required arguments.
        parent::__construct(
        // The unique id for your widget.
            'mk-contacts-widget',

            // The name of the widget for display purposes.
            __('Віджет блоку контактів', 'hello-world-widget-text-domain'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Віджет блоку контактів', 'hello-world-widget-text-domain'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для блоку контактів.', 'hello-world-widget-text-domain'),
                    'default' => 'Hello world!',
                ),
                'address_list' => array(
                    'type' => 'repeater',
                    'label' => __('Список адресс', 'widget-form-fields-text-domain'),
                    'item_name' => __('Адресса', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'address' => array(
                            'type' => 'text',
                            'label' => __('Адресса', 'hello-world-widget-text-domain'),
                            'default' => 'Lorem ipsum!',
                        ),
                    )
                ),
                'mobile_form_title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для форми контактів в мобільному розширенні', 'hello-world-widget-text-domain'),
                    'default' => 'Напишіть нам',
                ),'form' => array(
                    'type' => 'text',
                    'label' => __('Shortcode для форми контактів.', 'hello-world-widget-text-domain'),
                    'default' => '[]',
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
                'map' => array(
                    'type' => 'text',
                    'label' => __('Shortcode для мапи.', 'hello-world-widget-text-domain'),
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
            'title' => $instance['title'],
            'form' => $instance['form'],
            'address_list' => $instance['address_list'],
            'email_list' => $instance['email_list'],
            'phone_list' => $instance['phone_list'],
            'social_list' => [],
            'map' => $instance['map'],
        ];
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
        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/contacts.blade.php", $data);
    }
}

siteorigin_widget_register('mk-contacts-widget', __FILE__, 'ContactsWidget');
