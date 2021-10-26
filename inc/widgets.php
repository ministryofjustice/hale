<?php
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function hale_widgets_init()
{
    register_sidebar(
        [
            'name'          => esc_html__('News Listing', 'hale'),
            'id'            => 'news-listing',
            'description'   => esc_html__('News Listing area. Displays on top of news listing page', 'hale'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
        ]
    );
    register_sidebar(
        [
            'name'          => esc_html__('Footer area one', 'hale'),
            'id'            => 'footer-area-two',
            'description'   => esc_html__('Footer area widget. Displays on lefthand side when two footer widgets are present.', 'hale'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
        ]
    );
    register_sidebar(
        [
            'name'          => esc_html__('Footer area two', 'hale'),
            'id'            => 'footer-area-one',
            'description'   => esc_html__('Footer area widget. Displays on the righthand side when two footer widgets are present.', 'hale'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
        ]
    );

}

add_action('widgets_init', 'hale_widgets_init');
