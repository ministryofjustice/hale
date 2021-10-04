<?php
// Register News Post Type
function hale_register_news_post_type()
{

    $labels = array(
        'name' => _x('News', 'Post Type General Name', 'hale'),
        'singular_name' => _x('News story', 'Post Type Singular Name', 'hale'),
        'menu_name' => __('News', 'hale'),
        'name_admin_bar' => __('News story', 'hale'),
        'archives' => __('News story Archives', 'hale'),
        'attributes' => __('News story Attributes', 'hale'),
        'parent_item_colon' => __('Parent News story:', 'hale'),
        'all_items' => __('All News stories', 'hale'),
        'add_new_item' => __('Add New News story', 'hale'),
        'add_new' => __('Add New', 'hale'),
        'new_item' => __('New News story', 'hale'),
        'edit_item' => __('Edit News story', 'hale'),
        'update_item' => __('Update News story', 'hale'),
        'view_item' => __('View News story', 'hale'),
        'view_items' => __('View News stories', 'hale'),
        'search_items' => __('Search News stories', 'hale'),
        'not_found' => __('Not found', 'hale'),
        'not_found_in_trash' => __('Not found in Trash', 'hale'),
        'featured_image' => __('Featured Image', 'hale'),
        'set_featured_image' => __('Set featured image', 'hale'),
        'remove_featured_image' => __('Remove featured image', 'hale'),
        'use_featured_image' => __('Use as featured image', 'hale'),
        'insert_into_item' => __('Insert into news', 'hale'),
        'uploaded_to_this_item' => __('Uploaded to this News story', 'hale'),
        'items_list' => __('News stories list', 'hale'),
        'items_list_navigation' => __('News stories list navigation', 'hale'),
        'filter_items_list' => __('Filter News stories list', 'hale'),
    );
    $args = array(
        'label' => __('News story', 'hale'),
        'description' => __('Contains details of News stories', 'hale'),
        'labels' => $labels,
        'supports' => array('title', 'editor', 'thumbnail'),
        'taxonomies' => array('category', 'post_tag'),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-media-document',
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'show_in_rest' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'page',
        'rewrite' => array(
            'slug' => 'news',
            'with_front' => false
        ),
    );

    //Check if post type is deactived
    $deactivate_news = get_theme_mod('deactivate_cpt_news', "yes");
    if ($deactivate_news == "no") {
        register_post_type('news', $args);
    }

}

add_action('init', 'hale_register_news_post_type', 0);

function hale_news_archive_query($query)
{

    if ($query->is_main_query() && !is_admin()) {

        if (is_post_type_archive('news')) {
            if (array_key_exists('subtopic', $query->query) && is_numeric($query->query['subtopic'])) {
                unset($query->query['cat']);

                $query->set('category__in', $query->query['subtopic']);
            }
        }
        if ($query->is_tag || $query->is_category) {
            $query->set('post_type', 'news');
        }
    }
    return;
}

add_action('pre_get_posts', 'hale_news_archive_query');

function hale_news_add_query_vars_filter($vars)
{
    $vars[] = "subtopic";
    return $vars;
}

add_filter('query_vars', 'hale_news_add_query_vars_filter');
