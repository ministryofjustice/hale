<?php
/**
 * Hale Theme Customizer
 *
 * @package   Hale
 * @copyright Ministry of Justice
 * @version   1.0 Oct 2020
 */

/**
 * Export theme color branding class
 */
require get_template_directory() . '/inc/colour-branding-export.php';

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hale_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'hale_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'hale_customize_partial_blogdescription',
			)
		);
	}

	/*
	* ------------------------------------------------------------
	* SECTION: Header
	* ------------------------------------------------------------
	*/
	$wp_customize->add_section(
		'section_header',
		array(
			'title'       => esc_html__( 'Header', 'hale' ),
			'description' => esc_attr__( 'Customise your header display', 'hale' ),
			'priority'    => 10,
		)
	);

	/*
	* -----------------------------------------------------------
	* SHOW / HIDE Search
	* -----------------------------------------------------------
	*/
	$wp_customize->add_setting(
		'show_search',
		array(
			'default'           => 'yes',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'show_search',
		array(
			'label'       => esc_html__( 'Show Search Box?', 'hale' ),
			'description' => esc_html__( 'Would you like to show a search box in the top right of your site?', 'hale' ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'hale' ),
				'no'  => esc_html__( 'No', 'hale' ),
			),
		)
	);

	/*
	* -----------------------------------------------------------
	* SHOW / HIDE Main Menu
	* -----------------------------------------------------------
	*/
	$wp_customize->add_setting(
		'show_header_menu',
		array(
			'default'           => 'yes',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'show_header_menu',
		array(
			'label'       => esc_html__( 'Show Menu?', 'hale' ),
			'description' => esc_html__( 'Would you like to show the main menu in the header?', 'hale' ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'hale' ),
				'no'  => esc_html__( 'No', 'hale' ),
			),
		)
	);

	/*
	* -----------------------------------------------------------
	* Activate Main Menu More Button
	* -----------------------------------------------------------
	*/
	$wp_customize->add_setting(
		'show_header_menu_more_button',
		array(
			'default'           => 'yes',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'show_header_menu_more_button',
		array(
			'label'       => esc_html__( 'Overflow menu hidden in "More" button', 'hale' ),
			'description' => esc_html__( 'Do you want items which do not fit in the main menu to be accessed via a More button?', 'hale' ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'active_callback' => function () use ( $wp_customize ) {
				return (
					( $wp_customize->get_setting('show_header_menu')->value() === 'yes' )
				);
			},
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'hale' ),
				'no'  => esc_html__( 'No', 'hale' ),
			),
		)
	);

	/*
	* -----------------------------------------------------------
	* SHOW / HIDE Breadcrumb
	* -----------------------------------------------------------
	*/
	$wp_customize->add_setting(
		'show_breadcrumb',
		array(
			'default'           => 'yes',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'show_breadcrumb',
		array(
			'label'       => esc_html__( 'Show Breadcrumbs or side navigation?', 'hale' ),
			'description' => esc_html__( 'What combination of breadcrumbs/sidebar do you want', 'hale' ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Breadcrumbs', 'hale' ),
				'side1' => esc_html__( 'Sidebar 1 (Breadcrumb code)', 'hale' ),
				'side2' => esc_html__( 'Sidebar 2 (WP code)', 'hale' ),
				'side3' => esc_html__( 'Sidebar 3 (More base-level code)', 'hale' ),
				'side4' => esc_html__( 'Sidebar 4 (Navbar)', 'hale' ),
				'no'  => esc_html__( 'Nothing', 'hale' ),
			),
		)
	);

	/*
	* -----------------------------------------------------------
	* Chapter types
	* -----------------------------------------------------------
	*/
	$wp_customize->add_setting(
		'chapter_style',
		array(
			'default'           => 'top',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'chapter_style',
		array(
			'label'       => esc_html__( 'Top or side chapter styles', 'hale' ),
			'description' => esc_html__( 'Side chapter headings are hidden on mobile', 'hale' ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'choices'     => array(
				'top' => esc_html__( 'Top', 'hale' ),
				'side'  => esc_html__( 'Side', 'hale' ),
			),
		)
	);

	/*
	 * -----------------------------------------------------------
	 * SHOW / HIDE Quick Exit Button
	 * -----------------------------------------------------------
	 */
	$wp_customize->add_setting(
		'show_quick_exit',
		array(
			'default'           => 'no',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'show_quick_exit',
		array(
			'label'       => esc_html__( 'Show Quick Exit Button?', 'hale' ),
			'description' => esc_html__( 'Would you like to have a quick exit button in the header?', 'hale' ),
			'section'     => 'section_header',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'hale' ),
				'no'  => esc_html__( 'No', 'hale' ),
			),
		)
	);

	/*
		Show/Hide Site Name or Logo
	*/
	$wp_customize->add_setting(
		'logo_configuration',
		array(
			'default'           => 'both',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'logo_configuration',
		array(
			'label'       => esc_html__( 'Show Logo and Site Name?', 'hale' ),
			'description' => esc_html__( 'Would you like to show a logo and/or the site name in the header?', 'hale' ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'choices'     => array(
				'both' => esc_html__( 'Logo and site name', 'hale' ),
				'logo' => esc_html__( 'Logo only', 'hale' ),
				'name' => esc_html__( 'Site name only', 'hale' ),
				'no'  => esc_html__( 'Neither', 'hale' ),
			),
		)
	);

	/*
	* Logo/Sitename Has Link?
	*/
	$wp_customize->add_setting(
		'logo_has_link',
		array(
			'default'           => 'yes',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'logo_has_link',
		array(
			'label'       => esc_html__( 'Logo/Site Name Link?', 'hale' ),
			'description' => esc_html__( 'Would you like the site name and/or logo to be a link? You can set a custom link or the default link is to the homepage.', 'hale' ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'active_callback' => function () use ( $wp_customize ) {
				return 'no' !== $wp_customize->get_setting( 'logo_configuration' )->value();
			},
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'hale' ),
				'no'  => esc_html__( 'No', 'hale' ),
			),
		)
	);

	/*
	* Logo/Site name custom link
	*/
	$wp_customize->add_setting(
		'logo_custom_link',
		array(
			'sanitize_callback' => 'hale_sanitize_nohtml',
		)
	);

	$wp_customize->add_control(
		'logo_custom_link',
		array(
			'label'           => esc_html__( 'Logo/Site Name custom link', 'hale' ),
			'description' => esc_html__( 'Link defaults to homepage if it is not set', 'hale' ),
			'section'         => 'title_tagline',
			'type'            => 'text',
			'active_callback' => function () use ( $wp_customize ) {
				return (
					( $wp_customize->get_setting('logo_has_link')->value() === 'yes' ) &&
					( $wp_customize->get_setting('logo_configuration')->value() !== 'no' )
				);
			},
		)
	);

	/*
	* Crown Copyright
	*/
	$wp_customize->add_setting(
		'crown_copyright',
		array(
			'default'           => 'yes',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);

	$wp_customize->add_control(
	'crown_copyright',
	array(
		'label'       => esc_html__( 'Copyright', 'hale' ),
		'description' => esc_html__( 'Is the content Crown Copyright', 'hale' ),
		'section'     => 'title_tagline',
		'type'        => 'radio',
		'choices'     => array(
			'yes'   => esc_html__( 'Yes', 'hale' ),
			'no' => esc_html__( 'No', 'hale' ),
		),
	)
);

	/*
	* Show Organisation Name? (if not Crown Copyright and no text in logo)
	*/
	$wp_customize->add_setting(
		'org_name_checkbox',
		array(
			'default'           => 'no',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'org_name_checkbox',
		array(
			'label'       => esc_html__( 'Do you wish to add an organisation name to the logo and copyright?', 'hale' ),
			'description' => esc_html__( 'This is used if your oganisation name should be different from the site title. It is also picked up for the copyright statement in your footer.', 'hale' ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'active_callback' => function () use ( $wp_customize ) {
				return (
					( $wp_customize->get_setting('crown_copyright')->value() === 'no' ) ||
					( $wp_customize->get_setting('logo_configuration')->value() === 'both' ) ||
					( $wp_customize->get_setting('logo_configuration')->value() === 'name' )
				);
			},
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'hale' ),
				'no'  => esc_html__( 'No', 'hale' ),
			),
		)
	);

	$wp_customize->add_setting(
		'org_name_field',
		array(
			'sanitize_callback' => 'hale_sanitize_nohtml',
		)
	);

	$wp_customize->add_control(
		'org_name_field',
		array(
			'label'           => esc_html__( 'Enter Organisation name', 'hale' ),
			'section'         => 'title_tagline',
			'type'            => 'text',
			'active_callback' => function () use ( $wp_customize ) {
				return (
					( $wp_customize->get_setting( 'org_name_checkbox' )->value() === 'yes' ) && (
						( $wp_customize->get_setting('crown_copyright')->value() === 'no' ) ||
						( $wp_customize->get_setting('logo_configuration')->value() === 'both' ) ||
						( $wp_customize->get_setting('logo_configuration')->value() === 'name' )
					)
				);
			},
		)
	);

	$wp_customize->add_setting(
		'include_licence',
		array(
			'default'           => 'yes',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'include_licence',
		array(
			'label'       => esc_html__( 'OGL Licence', 'hale' ),
			'description' => esc_html__( 'Is the content published under an Open Government Licence', 'hale' ),
			'section'     => 'title_tagline',
			'type'        => 'radio',
			'choices'     => array(
				'yes'     => esc_html__( 'Yes (show OGL link in footer)', 'hale' ),
				'no'      => esc_html__( 'No', 'hale' ),
			),
		)
	);

	$wp_customize->add_setting('copyright_img', array(
		'sanitize_callback' => 'hale_sanitize_image'
	));

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize,
		'copyright_img_control',
		array(
			'label'       => esc_html__( 'Footer Copyright Image?', 'hale' ),
			'description' => esc_html__( 'Select a copyright image for the footer', 'hale' ),
			'settings'  => 'copyright_img',
			'section'   => 'title_tagline'
		)
	));

	$wp_customize->add_setting(
		'copyright_additional_text',
		array(
			'sanitize_callback' => 'wp_kses_post',
			'transport'   => 'refresh'
		)
	);

	$wp_customize->add_control(
		'copyright_additional_text',
		array(
			'label'           => esc_html__( 'Copyright Additional Text', 'hale' ),
			'description' => esc_html__( 'This text is shown next to copyright. It can include links.', 'hale' ),
			'section'         => 'title_tagline',
			'type'            => 'textarea',
			'active_callback' => function () use ( $wp_customize ) {
				return 'no' === $wp_customize->get_setting( 'crown_copyright' )->value();
			},
		)
	);

	/*
	* -----------------------------------------------------------
	* Theme colour chooser
	* -----------------------------------------------------------
	*/
	if( current_user_can('administrator') ) {

		$wp_customize->add_panel(
			"colour_section",
			array(
				'title' =>  __("Custom colours", 'hale'),
				'description' => "",
				'priority' => "52"
			)
		);

		$wp_customize->add_section(
			"main_colour_options",
			array(
				'title' =>  __("Main colour options", 'hale'),
				'description' => __("Activate, import and export custom colour schemes","hale"),
				'panel' => 'colour_section',
			)
		);

		$wp_customize->add_setting(
			'gds_style_tickbox',
			array(
				'default' => '',
				'sanitize_callback' => 'hale_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'gds_style_tickbox',
			array(
				'label' => esc_html__('Use Government Colours', 'hale'),
				'section' => 'main_colour_options',
				'type' => 'checkbox',
				'settings' => 'gds_style_tickbox',
			)
		);

		$wp_customize->add_setting(
			'colour_picker_tickbox',
			array(
				'default' => '',
				'sanitize_callback' => 'hale_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'colour_picker_tickbox',
			array(
				'label' => __('Pick custom colours with a colour picker', 'hale'),
				'description' => __('Save and refresh this option to reload controls', 'hale'),
				'section' => 'main_colour_options',
				'type' => 'checkbox',
				'settings' => 'colour_picker_tickbox',
				'active_callback' => function () use ($wp_customize) {
					return (
					($wp_customize->get_setting('gds_style_tickbox')->value() == 0)
					);
				},
			)
		);

		$wp_customize->add_setting(
			'colour_bar',
			array(
				'default' => '#1D70B8',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);
		$wp_customize->add_control(
			'colour_bar',
			array(
				'label' => esc_html__('Departmental or brand colour', 'hale'),
				'description' => esc_html__('Beneath the black header is a bar that can be a brand colour (#FFFFFF for none)', 'hale'),
				'section' => 'main_colour_options',
				'type' => 'color',
				'active_callback' => function () use ($wp_customize) {
					return (
					($wp_customize->get_setting('gds_style_tickbox')->value() == 1)
					);
				},
			)
		);

		$wp_customize->add_setting('customizer_setting_json', array(
			'transport' => 'refresh'
		));

		$wp_customize->add_control(new WP_Customize_Upload_Control($wp_customize,
			'customizer_setting_json',
			array(
				'label' => __('Import JSON file', 'hale'),
				'section' => 'main_colour_options',
				'mime_type' => 'application/json',
				'settings' => 'customizer_setting_json',
				'active_callback' => function () use ($wp_customize) {
					return (
					($wp_customize->get_setting('gds_style_tickbox')->value() == 0)
					);
				},
			)
		));

		// Export controls
		$wp_customize->add_setting('customizer_export_json', array(
			'default' => '',
			'type' => 'none'
		));

		// Title and description are handled in the Hale_Export_Color_Brand_Control class
		$wp_customize->add_control(new Hale_Export_Color_Brand_Control($wp_customize,
			'customizer_export_json',
			array(
				'section' => 'main_colour_options',
				'settings' => 'customizer_export_json',
				'active_callback' => function () use ($wp_customize) {
					return (
					($wp_customize->get_setting('gds_style_tickbox')->value() == 0)
					);
				},
			)
		));

		$wp_customize->add_setting(
			'logo_focus_invert_tickbox',
			array(
				'default' => 'yes',
				'sanitize_callback' => 'hale_sanitize_checkbox',
			)
		);

		$wp_customize->add_control(
			'logo_focus_invert_tickbox',
			array(
				'label' => esc_html__('Invert logo on focus', 'hale'),
				'description' => esc_html__('This will depend on the focus colour. The logo might not contrast well with the focus colour so it might need to be inverted for correct colour contrast.', 'hale'),
				'section' => 'main_colour_options',
				'type' => 'checkbox',
				'settings' => 'logo_focus_invert_tickbox',
				'active_callback' => function () use ($wp_customize) {
					return (
					($wp_customize->get_setting('gds_style_tickbox')->value() == 0)
					);
				},
			)
		);

		$show_colours = function () use ($wp_customize) {
			return (
				(
					$wp_customize->get_setting('gds_style_tickbox')->value() == 0
					&&
					!$wp_customize->get_setting('customizer_setting_json')->value()
				)
			);
		};

		$colour_sections_array = hale_get_colours($sections = true);

		for ($s = 0; $s < count($colour_sections_array); $s++) {

			$wp_customize->add_section(
				"colour_section_".$colour_sections_array[$s]["id"],
				array(
					'title' =>  __($colour_sections_array[$s]["section_name"], 'hale'),
					'description' => __($colour_sections_array[$s]["description"], 'hale'),
					'panel' => 'colour_section',
				)
			);

			$colour_array = $colour_sections_array[$s]["colours"];
			for ($i = 0; $i < count($colour_array); $i++) {
				$colour_id = hale_get_colour_id($colour_array[$i]);
				$colour_default = hale_get_colour_default($colour_array[$i]);
				$colour_desig = hale_get_colour_designation($colour_array[$i]);
				$colour_hint = hale_get_colour_hint($colour_array[$i]);
				$colour_options = hale_get_colour_options($colour_array[$i]);

				$wp_customize->add_setting(
					$colour_id,
					array(
						'default' => $colour_default,
						'sanitize_callback' => $colour_options == "text" ? 'hale_sanitize_nohtml' : 'sanitize_hex_color',
					)
				);
				$wp_customize->add_control(
					$colour_id,
					array(
						'label' => esc_html__($colour_desig, 'hale'),
						'description' => esc_html__($colour_hint, 'hale'),
						'section' => "colour_section_".$colour_sections_array[$s]["id"],
						'type' => $colour_options == "text" ? 'text' : ($wp_customize->get_setting('colour_picker_tickbox')->value() == 1 ? 'color' : 'text') ,
						'active_callback' => $show_colours,
					)
				);
			}
		}

	}

	/*
	* ------------------------------------------------------------
	* SECTION: Links
	* ------------------------------------------------------------
	*/
	$wp_customize->add_section(
		'section_links',
		array(
			'title'       => esc_html__( 'Links', 'hale' ),
			'description' => esc_attr__( 'Customise your site\'s link options', 'hale' ),
			'priority'    => 30,
		)
	);

	/*
	* Display Featured image on post / page?
	*/
	$wp_customize->add_setting(
		'link_new_tab_text',
		array(
			'default'           => '',
			'sanitize_callback' => 'hale_sanitize_nohtml',
		)
	);

	$wp_customize->add_control(
		'link_new_tab_text',
		array(
			'label'       => esc_html__( 'Link suffix', 'hale' ),
			'description' => esc_html__( 'What text should be added to the link if it opens in a new tab', 'hale' ),
			'section'     => 'section_links',
			'priority'    => '100',
			'type'        => 'text',
		)
	);



	/*
	* ------------------------------------------------------------
	* SECTION: Layout
	* ------------------------------------------------------------
	*/
	$wp_customize->add_section(
		'section_layout',
		array(
			'title'       => esc_html__( 'Layout', 'hale' ),
			'description' => esc_attr__( 'Customise your site layout', 'hale' ),
			'priority'    => 30,
		)
	);

	/*
	* Display Featured image on post / page?
	*/
	$wp_customize->add_setting(
		'featured_img_display',
		array(
			'default'           => 'true',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);

	$wp_customize->add_control(
		'featured_img_display',
		array(
			'label'       => esc_html__( 'Display Featured Image on posts / pages single view', 'hale' ),
			'description' => esc_html__( 'Featured images are really useful for search results and listing pages. Sometimes its handy to have them for this, but you don\'t want the image to show on the individual page. If thats the case, turn them off here.', 'hale' ),
			'section'     => 'section_layout',
			'priority'    => '100',
			'type'        => 'radio',
			'choices'     => array(
				'true'  => esc_html__( 'Yes', 'hale' ),
				'false' => esc_html__( 'No', 'hale' ),
			),
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_fimage_display',
		// $args
		array(
			'default'           => 'top',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);

	$wp_customize->add_control(
	// $id
		'blog_fimage_display',
		// $args
		array(
			'settings'    => 'blog_fimage_display',
			'section'     => 'section_layout',
			'priority'    => '110',
			'type'        => 'radio',
			'label'       => esc_html__( 'Featured images display', 'hale' ),
			'description' => esc_html__( 'Show Featured Image at top of individual posts, or to the side. (If Display Featured Image above is set to no, this setting is ignored)', 'hale' ),
			'choices'     => array(
				'top'   => esc_html__( 'Top of post', 'hale' ),
				'left'  => esc_html__( 'Floated left', 'hale' ),
				'right' => esc_html__( 'Floated right', 'hale' ),
			),
		)
	);
}

add_action( 'customize_register', 'hale_customize_register' );

/**
 * Settings to customise blog pages.
 *
 * @param array $wp_customize all the saved settings for the theme customiser.
 */
function hale_add_blog_settings( $wp_customize ) {

	$wp_customize->add_section(
		'blog_panel',
		array(
			'title'          => esc_html__( 'Blog Settings', 'hale' ),
			'description'    => esc_html__( 'Extra settings for the Blog page', 'hale' ),
			'capability'     => 'edit_theme_options',
			'theme-supports' => '',
			'priority'       => '150',
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_sidebar',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);

	$wp_customize->add_control(
	// $id
		'blog_sidebar',
		// $args
		array(
			'settings'    => 'blog_sidebar',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Display Sidebar', 'hale' ),
			'description' => esc_html__( 'Choose whether or not to display the sidebar on the blog page', 'hale' ),
			'choices'     => array(
				'true'  => esc_html__( 'Sidebar', 'hale' ),
				'false' => esc_html__( 'No Sidebar', 'hale' ),
			),
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_author_display',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);

	$wp_customize->add_control(
	// $id
		'blog_author_display',
		// $args
		array(
			'settings'    => 'blog_author_display',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Show Author Name on Blog Posts?', 'hale' ),
			'description' => esc_html__( 'Choose whether or not to display the authors name (and link) on the blog page', 'hale' ),
			'choices'     => array(
				'true'  => esc_html__( 'Show author', 'hale' ),
				'false' => esc_html__( 'Dont show author', 'hale' ),
			),
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_date_display',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);

	$wp_customize->add_control(
	// $id
		'blog_date_display',
		// $args
		array(
			'settings'    => 'blog_date_display',
			'section'     => 'blog_panel',
			'type'        => 'radio',
			'label'       => esc_html__( 'Show Post Date on Blog Posts?', 'hale' ),
			'description' => esc_html__( 'Choose whether or not to display the date a post was made on the blog page', 'hale' ),
			'choices'     => array(
				'true'  => esc_html__( 'Show date', 'hale' ),
				'false' => esc_html__( 'Dont show date', 'hale' ),
			),
		)
	);

	$wp_customize->add_setting(
	// $id
		'blog_fallback',
		// $args
		array(
			'default'           => '',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'hale_sanitize_image',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Media_Control(
			$wp_customize,
			'blog_fallback',
			array(
				'settings'    => 'blog_fallback',
				'mime_type'   => 'image',
				'section'     => 'blog_panel',
				'label'       => esc_html__( 'Blog Fallback Image', 'hale' ),
				'description' => esc_html__( 'Select a fallback image if the blog post does not have a featured image. Leave blank if no fallback wanted', 'hale' ),
			)
		)
	);

	$wp_customize->remove_control( 'custom_css' );
}

add_action( 'customize_register', 'hale_add_blog_settings' );

/**
 * Clean the date output up.
 *
 * @param datetime $input raw date.
 *
 * @return string.
 */
function hale_sanitize_date( $input ) {
	$date = new DateTime( $input );

	return $date->format( 'd-m-Y' );
}

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function hale_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function hale_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hale_customize_preview_js() {
	wp_enqueue_script( 'hale-customizer', get_template_directory_uri() . '/js/customizer.js', array(
		'jquery',
		'customize-preview'
	), '20151215', true );
}

add_action( 'customize_preview_init', 'hale_customize_preview_js' );


add_action( 'customize_register', 'hale_add_typography_settings' );

function hale_add_typography_settings( $wp_customize )
{
	$wp_customize->add_section(
		'typography_panel',
		array(
			'title' => esc_html__('Typography', 'hale'),
			'description' => esc_html__('Typography settings', 'hale'),
			'capability' => 'edit_theme_options',
			'theme-supports' => '',
			'priority' => '151',
		)
	);


	$wp_customize->add_setting(
	// $id
		'primary_font',
		// $args
		array(
			'default'           => 'true',
			'type'              => 'theme_mod',
			'capability'        => 'edit_theme_options',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);


	$wp_customize->add_control(
	// $id
		'primary_font',
		// $args
		array(
			'settings'    => 'primary_font',
			'section'     => 'typography_panel',
			'type'        => 'select',
			'label'       => esc_html__( 'Primary Font', 'hale' ),
			'description' => esc_html__( 'Main font used on headings and text', 'hale' ),
			'choices'     => array(
				'frutiger'  => esc_html__( 'Frutiger', 'hale' ),
				'pt-sans' => esc_html__( 'PT Sans', 'hale' ),
			),
		)
	);


}


add_action( 'customize_register', 'hale_add_blocks_settings' );

function hale_add_blocks_settings( $wp_customize )
{

	if( current_user_can('administrator') ) {

		$wp_customize->add_panel(
			'blocks_panel',
			array(
				'title' => esc_html__('CPTs and Blocks', 'hale'),
				'description' => esc_html__('CPTs and Blocks settings', 'hale'),
				'capability' => 'edit_theme_options',
				'theme-supports' => '',
				'priority' => '151',
			)
		);

		/* Blocks Settings */

		$wp_customize->add_section(
			'blocks_settings',
			array(
				'title' => esc_html__('Blocks', 'hale'),
				'description' => esc_html__('Blocks settings', 'hale'),
				'capability' => 'edit_theme_options',
				'theme-supports' => '',
				'priority' => '160',
				'panel' => 'blocks_panel'
			)
		);

		/*
		*  Restrict Blocks Settings
		*/
		$wp_customize->add_setting(
			'restrict_blocks',
			array(
				'default' => 1,
			)
		);

	$wp_customize->add_control(
			'restrict_blocks',
			array(
				'label' => esc_html__('Restrict Blocks', 'hale'),
				'description' => esc_html__('Hides some core Wordpress blocks that are not currently compatible with Hale theme', 'hale'),
				'section' => 'blocks_settings',
				'priority' => '100',
				'type' => 'radio',
				'choices' => array(
					1 => esc_html__('On', 'hale'),
					0 => esc_html__('Off', 'hale'),
				),
			)
		);

		/* Documents CPT Settings */

		$wp_customize->add_section(
			'documents_cpt_settings',
			array(
				'title' => esc_html__('Documents', 'hale'),
				'description' => esc_html__('Document CPT settings', 'hale'),
				'capability' => 'edit_theme_options',
				'theme-supports' => '',
				'priority' => '160',
				'panel' => 'blocks_panel'
			)
		);

		$wp_customize->add_setting(
			'cpt_documents_activated',
			array(
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'cpt_documents_activated',
			array(
				'label' => esc_html__('Documents', 'hale'),
				'section' => 'documents_cpt_settings',
				'priority' => '100',
				'type' => 'radio',
				'choices' => array(
					1 => esc_html__('On', 'hale'),
					0 => esc_html__('Off', 'hale'),
				),
			)
		);

		$wp_customize->add_setting(
			'tax_document_category_activated',
			array(
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'tax_document_category_activated',
			array(
				'label' => esc_html__('Document Category Taxonomy', 'hale'),
				'section' => 'documents_cpt_settings',
				'priority' => '100',
				'type' => 'radio',
				'choices' => array(
					1 => esc_html__('On', 'hale'),
					0 => esc_html__('Off', 'hale'),
				),
				'active_callback' => function () use ($wp_customize) {
					return (
					($wp_customize->get_setting('cpt_documents_activated')->value() == true)
					);
				},
			)
		);

		$wp_customize->add_setting(
			'tax_document_type_activated',
			array(
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'tax_document_type_activated',
			array(
				'label' => esc_html__('Document Type Taxonomy', 'hale'),
				'section' => 'documents_cpt_settings',
				'priority' => '100',
				'type' => 'radio',
				'choices' => array(
					1 => esc_html__('On', 'hale'),
					0 => esc_html__('Off', 'hale'),
				),
				'active_callback' => function () use ($wp_customize) {
					return (
					($wp_customize->get_setting('cpt_documents_activated')->value() == true)
					);
				},
			)
		);

		$wp_customize->add_setting(
			'tax_document_location_activated',
			array(
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'tax_document_location_activated',
			array(
				'label' => esc_html__('Document Location Taxonomy', 'hale'),
				'section' => 'documents_cpt_settings',
				'priority' => '100',
				'type' => 'radio',
				'choices' => array(
					1 => esc_html__('On', 'hale'),
					0 => esc_html__('Off', 'hale'),
				),
				'active_callback' => function () use ($wp_customize) {
					return (
					($wp_customize->get_setting('cpt_documents_activated')->value() == true)
					);
				},
			)
		);
		/* News CPT Settings */

		$wp_customize->add_section(
			'news_cpt_settings',
			array(
				'title' => esc_html__('News Stories', 'hale'),
				'description' => esc_html__('News Stories CPT settings', 'hale'),
				'capability' => 'edit_theme_options',
				'theme-supports' => '',
				'priority' => '160',
				'panel' => 'blocks_panel'
			)
		);

		$wp_customize->add_setting(
			'cpt_news_activated',
			array(
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'cpt_news_activated',
			array(
				'label' => esc_html__('News Stories', 'hale'),
				'section' => 'news_cpt_settings',
				'priority' => '100',
				'type' => 'radio',
				'choices' => array(
					1 => esc_html__('On', 'hale'),
					0 => esc_html__('Off', 'hale'),
				),
			)
		);


		/* Decision CPT Settings */

		$wp_customize->add_section(
			'decision_cpt_settings',
			array(
				'title' => esc_html__('Decision Archive', 'hale'),
				'description' => esc_html__('Decision CPT settings', 'hale'),
				'capability' => 'edit_theme_options',
				'theme-supports' => '',
				'priority' => '160',
				'panel' => 'blocks_panel'
			)
		);

		$wp_customize->add_setting(
			'cpt_decision_activated',
			array(
				'default' => 0,
			)
		);

		$wp_customize->add_control(
			'cpt_decision_activated',
			array(
				'label' => esc_html__('Decision', 'hale'),
				'section' => 'decision_cpt_settings',
				'priority' => '100',
				'type' => 'radio',
				'choices' => array(
					1 => esc_html__('On', 'hale'),
					0 => esc_html__('Off', 'hale'),
				),
			)
		);
	}

	/*
	* ------------------------------------------------------------
	* SECTION: Deprecated switches
	* ------------------------------------------------------------
	*/
	$wp_customize->add_section(
		'deprecated_controls',
		array(
			'title'       => esc_html__( 'Deprecated controls', 'hale' ),
			'description' => esc_attr__( 'Turn on and off deprecated support - preferably off', 'hale' ),
			'priority'    => 100,
		)
	);

	/*
	* -----------------------------------------------------------
	* Paragraph Widths Support
	* -----------------------------------------------------------
	*/
	$wp_customize->add_setting(
		'deprecated_paragraph_widths',
		array(
			'default'           => 'no',
			'sanitize_callback' => 'hale_sanitize_select',
		)
	);
	$wp_customize->add_control(
		'deprecated_paragraph_widths',
		array(
			'label'       => esc_html__( 'Disable the new narrow paragraphs for this site', 'hale' ),
			'section'     => 'deprecated_controls',
			'type'        => 'radio',
			'choices'     => array(
				'yes' => esc_html__( 'Yes', 'hale' ),
				'no'  => esc_html__( 'No', 'hale' ),
			),
		)
	);
}
