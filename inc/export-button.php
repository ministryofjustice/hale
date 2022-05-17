<?php 

// Export button

add_action( 'customize_register', 'hale_export_color_customize_register' );

function hale_export_color_customize_register($wp_customize) {

class Hale_Export_Color_Brand_Control extends WP_Customize_Control {
    
        /**
        * Render the control's content.
        */
        public function render_content() {
        ?>
            <hr />
            <div class="customize-control customize-control-text">
            <label class="customize-control-title">Export site branding</label>
            <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>?action=export_color_branding_json" method="post">
            <button type="submit" class="button">Download</button>
            </form>
            </div>

        <?php
        }
    }
}

add_action( 'admin_post_export_color_branding_json', 'hale_init_file_export' );

function hale_init_file_export(){

    status_header(200);

    $charset = get_option( 'blog_charset' );
    $mod = get_theme_mod('customizer_setting_json');

    header( 'Content-disposition: attachment; filename=' . "pusheen" . '-export.json' );
    header( 'Content-Type: application/json; charset=' . $charset );

    $x = file_get_contents($mod);

    echo $x;

    // Start download
    die();

}

