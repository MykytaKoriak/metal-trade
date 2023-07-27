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
            __('Віджет сторінки контактів', 'mk-metal-trade'),

            // The $widget_options array, which is passed through to WP_Widget.
            // It has a couple of extras like the optional help URL, which should link to your sites help or support page.
            array(
                'description' => __('Віджет сторінки контактів', 'mk-metal-trade'),
                'help' => 'https://github.com/MykytaKoriak/metal-trade',
            ),

            // The $control_options array, which is passed through to WP_Widget
            array(),

            // The $form_options array, which describes the form fields used to configure SiteOrigin widgets. We'll explain these in more detail later.
            array(
                'map_api_key' => array(
                    'type' => 'text',
                    'label' => __('Google Map API Key', 'mk-metal-trade'),
                ),
                'title_marker' => array(
                    'type' => 'text',
                    'label' => __('Заголовок маркеру', 'mk-metal-trade'),
                ),
                'content_marker' => array(
                    'type' => 'tinymce',
                    'label' => __('Введіть тест який буде відображатись над маркером', 'mk-metal-trade'),
                    'default' => 'МК Метал Трейд',
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
                'title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для блоку контактів.', 'mk-metal-trade'),
                    'default' => 'Hello world!',
                ),
                'contact_blocks' => array(
                    'type' => 'repeater',
                    'label' => __('Контактна інформація', 'mk-metal-trade'),
                    'item_name' => __('Блок контактної інформації', 'siteorigin-widgets'),
                    'item_label' => array(
                        'selector' => "[id*='repeat_text']",
                        'update_event' => 'change',
                        'value_method' => 'val'
                    ),
                    'fields' => array(
                        'type_block' => array(
                            'type' => 'radio',
                            'label' => __('Тип блоку', 'mk-metal-trade'),
                            'default' => 'other',
                            'options' => array(
                                'phone' => __('Номер телефону', 'mk-metal-trade'),
                                'email' => __('Поштова адреса', 'mk-metal-trade'),
                                'address' => __('Фізична адреса', 'mk-metal-trade'),
                                'other' => __('Інше', 'mk-metal-trade')
                            )
                        ),
                        'title' => array(
                            'type' => 'text',
                            'label' => __('Заголовок блоку.', 'mk-metal-trade'),
                            'default' => 'Lorem ipsum!',
                        ),
                        'info_1' => array(
                            'type' => 'text',
                            'label' => __('Інформація блоку.', 'mk-metal-trade'),
                            'default' => 'Lorem ipsum!',
                        ),
                        'info_2' => array(
                            'type' => 'text',
                            'label' => __('Інформація блоку.', 'mk-metal-trade'),
                            'default' => 'Lorem ipsum!',
                        ),
                    )
                ),
                'join_title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для підблоку соціальних мереж.', 'mk-metal-trade'),
                    'default' => 'Hello world!',
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
                            'default' => 'http://www.example.com',
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
                'button_text' => array(
                    'type' => 'text',
                    'label' => __('Текст на кнопці.', 'mk-metal-trade'),
                    'default' => 'Hello world!',
                ),
                'popup_title' => array(
                    'type' => 'text',
                    'label' => __('Заголовок для вспливаючого вікна.', 'mk-metal-trade'),
                    'default' => 'Hello world!',
                ),
                'popup_form' => array(
                    'type' => 'text',
                    'label' => __('Shortcode для форми.', 'mk-metal-trade'),
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
        $GMAP = [
            'key' => $instance['map_api_key'],
            'title' => $instance['title_marker'],
            'content' => $instance['content_marker'],
        ];
        $data = [
            'map' => [
                'key' => $instance['map_api_key'],
                'title' => $instance['title_marker'],
                'content' => $instance['content_marker'],
            ],
            'title' => $instance['title'],
            'contact_blocks' => $instance['contact_blocks'],
            'join_title' => $instance['join_title'],
            'button_text' => $instance['button_text'],
            'popup_title' => $instance['popup_title'],
            'popup_form' => $instance['popup_form'],
            'social_list' => []
        ];
        foreach ($instance['social_list'] as $item) {
            if (strpos($item['social'], "post: ") !== false) {
                $post_id = str_replace("post: ", "", $item['social']);
                $data['social_list'][] = [
                    'icon' => wp_get_attachment_url($item['icon']),
                    'url' => get_permalink(intval($post_id))
                ];
            } else {
                $data['social_list'][] = [
                    'icon' => wp_get_attachment_url($item['icon']),
                    'url' => $item['social']
                ];
            }
        }

        ?>
        <script>
            window.GOOGLE_MAPS_JS_API_KEY = '<?php echo $GMAP['key']?>';
            window.google_maps_marker = {
                title: '<?php echo $GMAP['title']?>',
                content: '<?php echo str_replace(array("\n", "\r"), '', $GMAP['content'])?>'};
        </script>
        <?php

        echo Roots\view(dirname(__FILE__) . "/../../resources/views/widgets/contact-page.blade.php", $data);
    }
}

siteorigin_widget_register('mk-contact-page-widget', __FILE__, 'ContactPageWidget');
