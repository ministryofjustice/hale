<?php

/**
 * Registers a banner field for specific post types in the WordPress admin using ACF.
 *
 * This function iterates through all registered post types and adds a custom ACF textarea field
 * for entering banner text if the post type has an enabled banner feature flagged by 'enable_banner_on_single_view' property.
 *
 * It also adds link fields for as many links as are enabed (0-12) as determined by the 'single_view_banner_max_links' property.
 *
 * [Adapted from the summary field code which does a similar thing]
 *
 */
function hale_register_post_type_fields_banner()
{
    // Retrieve all registered post types as objects
    $post_types = get_post_types([], 'objects');

    foreach ($post_types as $key => $post_type) {
        if (isset($post_type->enable_banner_on_single_view) && $post_type->enable_banner_on_single_view == '1') {
            $post_type_name = $post_type->label;
            $post_type_key = $key;

            if (isset($post_type->single_view_banner_max_links)) {
                $number_of_banner_links = $post_type->single_view_banner_max_links;
            } else {
                $number_of_banner_links = 4; //4 seems as good a default as any
            }
            if (isset($post_type->allow_file_download_links)) {
                $allow_file = $post_type->allow_file_download_links;
            } else {
                $allow_file = false;
            }

            $input_width = "80%";
            if (!$allow_file && $number_of_banner_links <= 6) $input_width = 100/$number_of_banner_links . "%"; //up to 6 choices, we lay them out side-by-side,

            acf_add_local_field([
                'key' => $post_type_key . '_show_banner',
                'label' => 'Show Banner',
                'name' => 'show_post_banner',
                'type' => 'true_false',
                'parent' => $post_type_key . '_details',
                'instructions' => "Show a banner on this page which can contain up to $number_of_banner_links links",
                'required' => 0,
                'conditional_logic' => 0,
                'ui' => true,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => false,
            ]);

            // Add the ACF field for the banner text
            acf_add_local_field([
                'key' => $post_type_key . '_banner_text',
                'label' => $post_type_name . ' Banner',
                'name' => 'post_banner_text',
                'type' => 'textarea',
                'parent' => $post_type_key . '_details',
                'instructions' => 'The banner will appear at the top of the page',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => $post_type_key . '_show_banner',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'rows' => '',
                'new_lines' => '',
            ]);

            for ($i=1; $i<=$number_of_banner_links; $i++) {

                if ($allow_file) {
                    acf_add_local_field([
                        'key' => $post_type_key . '_banner_link_type_' . $i,
                        'label' => 'Type of link',
                        'name' => 'post_banner_link_type_'.$i,
                        'type' => 'select',
                        'parent' => $post_type_key . '_details',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => $post_type_key . '_show_banner',
                                    'operator' => '==',
                                    'value' => '1',
                                ),
                            ),
                        ),
                        'toggle'            => false,
                        'choices'           => array(
                            'link'  =>__('Page', 'hale'),
                            'file'    =>__('Document', 'hale'),
                        ),
                        'wrapper' => [
                            'width' => "20%",
                            'class' => '',
                            'id' => '',
                        ],
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                        'allow_null'        => false,
                    ]);
                }

                acf_add_local_field([
                    'key' => $post_type_key . '_banner_link_' . $i,
                    'label' => 'Link ' . $i,
                    'name' => 'post_banner_link_'.$i,
                    'type' => 'link',
                    'parent' => $post_type_key . '_details',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => $post_type_key . '_show_banner',
                                'operator' => '==',
                                'value' => '1',
                            ),
                            array(
                                'field' => $post_type_key . '_banner_link_type_' . $i,
                                'operator' => '==',
                                'value' => 'link',
                            ),
                        ),
                    ),
                    'wrapper' => [
                        'width' => $input_width,
                        'class' => '',
                        'id' => '',
                    ],
                    'default_value' => '',
                    'placeholder' => '',
                    'maxlength' => '',
                ]);

                if ($allow_file) {
                    acf_add_local_field([
                        'key' => $post_type_key . '_banner_file_' . $i,
                        'label' => 'File ' . $i,
                        'name' => 'post_banner_file_'.$i,
                        'type' => 'file',
                        'parent' => $post_type_key . '_details',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => $post_type_key . '_show_banner',
                                    'operator' => '==',
                                    'value' => '1',
                                ),
                                array(
                                    'field' => $post_type_key . '_banner_link_type_' . $i,
                                    'operator' => '==',
                                    'value' => 'file',
                                ),
                            ),
                        ),
                        'wrapper' => [
                            'width' => $input_width,
                            'class' => '',
                            'id' => '',
                        ],
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                    ]);
                }
            }

            // Continue to the next post type
            continue;
        }
    }
}

add_action('acf/init', 'hale_register_post_type_fields_banner');
