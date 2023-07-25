<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our theme. We will simply require it into the script here so that we
| don't have to worry about manually loading any of our classes later on.
|
*/

if (!file_exists($composer = __DIR__ . '/vendor/autoload.php')) {
    wp_die(__('Error locating autoloader. Please run <code>composer install</code>.', 'sage'));
}

require $composer;

/*
|--------------------------------------------------------------------------
| Register The Bootloader
|--------------------------------------------------------------------------
|
| The first thing we will do is schedule a new Acorn application container
| to boot when WordPress is finished loading the theme. The application
| serves as the "glue" for all the components of Laravel and is
| the IoC container for the system binding all of the various parts.
|
*/

if (!function_exists('\Roots\bootloader')) {
    wp_die(
        __('You need to install Acorn to use this theme.', 'sage'),
        '',
        [
            'link_url' => 'https://roots.io/acorn/docs/installation/',
            'link_text' => __('Acorn Docs: Installation', 'sage'),
        ]
    );
}

\Roots\bootloader()->boot();

/*
|--------------------------------------------------------------------------
| Register Sage Theme Files
|--------------------------------------------------------------------------
|
| Out of the box, Sage ships with categorically named theme files
| containing common functionality and setup to be bootstrapped with your
| theme. Simply add (or remove) files from the array below to change what
| is registered alongside Sage.
|
*/

collect(['setup', 'filters'])
    ->each(function ($file) {
        if (!locate_template($file = "app/{$file}.php", true, true)) {
            wp_die(
            /* translators: %s is replaced with the relative file path */
                sprintf(__('Error locating <code>%s</code> for inclusion.', 'sage'), $file)
            );
        }
    });

function metal_trade_widget_collection($folders)
{
    $folders[] = dirname(__FILE__) . '/app/Widgets/'; // important: Slash on end string is required.
    return $folders;
}

add_filter('siteorigin_widgets_widget_folders', 'metal_trade_widget_collection');


function asset_name($type, $start, $ext)
{
    $dir = dirname(__FILE__) . '/public/' . $type;
    $files = glob($dir . '/*.' . $ext);
    $suffixLength = -7 - strlen($ext) - 1;
    foreach ($files as $file) {
        $name = substr($file, strlen($dir) + 1, $suffixLength);
        if ($name === $start) {
            return $file;
        }
    }
    throw new Exception('file not found');
}


function mk_metaltrade_dependencies()
{
    if (!class_exists("SiteOrigin_Widget"))
        echo '<div class="error"><p>' . __('Warning: The theme needs plugins Page Builder від SiteOrigin and SiteOrigin Widgets Bundle', 'mk-metal-traide') . '</p></div>';
}

add_action('admin_notices', 'mk_metaltrade_dependencies');

function mkmetal_add_meta_tags()
{
    if (function_exists("get_field")) {
        global $wp;
        $current_url = home_url(add_query_arg(array(), $wp->request));

        if (get_field("meta_description")) {
            echo "<meta name=\"description\" content=\"" . get_field("meta_description") . "\">";
            echo "<meta property=\"og:description\" content=\"" . get_field("meta_description") . "\" />";
        } elseif (false) {
            echo "<meta name=\"description\" content=\"" . get_field("meta_description", '') . "\">";
            echo "<meta property=\"og:description\" content=\"" . get_field("meta_description", '') . "\" />";
        }
        if (get_field("meta_keywords")) {
            echo "<meta name=\"keywords\" content=\"" . get_field("meta_keywords") . "\">";
        } elseif (false) {
            echo "<meta name=\"keywords\" content=\"" . get_field("meta_keywords") . "\">";
        }
        if (get_field("meta_og_image")) {
            echo "<meta property=\"og:image\" content=\"" . get_field("meta_og_image") . "\" />";
        }  elseif (false) {
            echo "<meta property=\"og:image\" content=\"" . get_field("meta_og_image") . "\" />";
        }
        echo "<meta property=\"og:title\" content=\"" . get_the_title() . "\" />";
        echo "<meta property=\"og:url\" content=\"" . $current_url . "\" />";
    }
}

add_action('wp_head', 'mkmetal_add_meta_tags');


function close_standard_search( $query, $error = true) {
    if (is_search() && !is_admin()) {
        $query->is_search       = false;
        $query->query_vars['s'] = false;
    }
}

add_action('parse_query', 'close_standard_search');