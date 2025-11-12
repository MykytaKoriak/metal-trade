<?php
namespace App;

if (defined('WC_ABSPATH')) {
    add_action('after_setup_theme', function () {
        add_theme_support('woocommerce');
    });

    /**
     * @param string $template
     * @return string
     */
    function wc_template_loader(String $template)
    {
        if (strpos($template, get_template_directory()) !== false) {
            return locate_template(WC()->template_path() . str_replace(get_template_directory() . '/woocommerce/', '', $template)) ? : $template;
        }

        return strpos($template, WC_ABSPATH) === -1
            ? $template
            : (locate_template(WC()->template_path() . str_replace(WC_ABSPATH . 'templates/', '', $template)) ? : $template);
    }
    add_filter('template_include', __NAMESPACE__ . '\\wc_template_loader', 100, 1);
    add_filter('comments_template', __NAMESPACE__ . '\\wc_template_loader', 100, 1);

    add_filter('wc_get_template_part', function ($template) {
        $theme_template = locate_template(WC()->template_path() . str_replace(WC_ABSPATH . 'templates/', '', $template));

        if ($theme_template) {
            $data = collect(get_body_class())->reduce(function ($data, $class) {
                return apply_filters("sage/template/{$class}/data", $data);
            }, []);

            echo template($theme_template, $data);
            return get_stylesheet_directory() . '/index.php';
        }

        return $template;
    }, PHP_INT_MAX, 1);

    add_action('woocommerce_before_template_part', function ($template_name, $template_path, $located, $args) {
        $theme_template = locate_template(WC()->template_path() . $template_name);

        if ($theme_template) {
            $data = collect(get_body_class())->reduce(function ($data, $class) {
                return apply_filters("sage/template/{$class}/data", $data);
            }, []);

            echo template($theme_template, array_merge(
                compact(explode(' ', 'template_name template_path located args')),
                $data,
                $args
            ));
        }
    }, PHP_INT_MAX, 4);

    add_filter('wc_get_template', function ($template, $template_name, $args) {
        $theme_template = locate_template(WC()->template_path() . $template_name);

        // return theme filename for status screen
        if (is_admin() && ! wp_doing_ajax() && function_exists('get_current_screen') && get_current_screen() && get_current_screen()->id === 'woocommerce_page_wc-status') {
            return $theme_template ? : $template;
        }

        // return empty file, output already rendered by 'woocommerce_before_template_part' hook
        return $theme_template ? get_stylesheet_directory() . '/index.php' : $template;
    }, 100, 3);

    if( function_exists('acf_add_local_field_group') ):

        acf_add_local_field_group(array(
            'key' => 'group_690f397e96cca',
            'title' => 'Product Form',
            'fields' => array(
                array(
                    'key' => 'field_690f397f7dd0e',
                    'label' => 'Форма замовлення',
                    'name' => 'contact_form',
                    'aria-label' => '',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'maxlength' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                ),
                array(
                    'key' => 'field_6912c2c008a12',
                    'label' => 'ID Форми замовлення',
                    'name' => 'contact_form_id',
                    'aria-label' => '',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => '',
                    'min' => '',
                    'max' => '',
                    'placeholder' => '',
                    'step' => '',
                    'prepend' => '',
                    'append' => '',
                ),
                array(
                    'key' => 'field_6912c2ed08a13',
                    'label' => 'Кнопки покупки на маркетплейсах',
                    'name' => 'buy_button_list',
                    'aria-label' => '',
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'layout' => 'row',
                    'pagination' => 0,
                    'min' => 0,
                    'max' => 0,
                    'collapsed' => '',
                    'button_label' => 'Додати рядок',
                    'rows_per_page' => 20,
                    'sub_fields' => array(
                        array(
                            'key' => 'field_6912c31b08a14',
                            'label' => 'Іконка маркетплейсу',
                            'name' => 'market_image',
                            'aria-label' => '',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'return_format' => 'array',
                            'library' => 'all',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                            'preview_size' => 'medium',
                            'parent_repeater' => 'field_6912c2ed08a13',
                        ),
                        array(
                            'key' => 'field_6912c34a08a15',
                            'label' => 'Колір кнопки',
                            'name' => 'button_color',
                            'aria-label' => '',
                            'type' => 'color_picker',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'enable_opacity' => 0,
                            'return_format' => 'string',
                            'parent_repeater' => 'field_6912c2ed08a13',
                        ),
                        array(
                            'key' => 'field_691480da27ac0',
                            'label' => 'Колір тексту',
                            'name' => 'text_color',
                            'aria-label' => '',
                            'type' => 'color_picker',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'enable_opacity' => 0,
                            'return_format' => '',
                            'parent_repeater' => 'field_6912c2ed08a13',
                        ),
                        array(
                            'key' => 'field_6912c37308a16',
                            'label' => 'Текст на кнопці',
                            'name' => 'button_text',
                            'aria-label' => '',
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'maxlength' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'parent_repeater' => 'field_6912c2ed08a13',
                        ),
                        array(
                            'key' => 'field_6912c38908a17',
                            'label' => 'Посилання на товар на маркетплейсі',
                            'name' => 'market_product_link',
                            'aria-label' => '',
                            'type' => 'url',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'parent_repeater' => 'field_6912c2ed08a13',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'product',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
            'show_in_rest' => 0,
        ));

    endif;
}
