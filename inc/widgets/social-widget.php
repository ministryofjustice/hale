<?php
class social_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'social_widget',
            __('Social Widget', 'hale'),
            array( 'description' => __( 'Widget to show social links', 'hale' ), )
        );
    }

    public function widget( $args, $instance ) {
        $harmonized_icons = apply_filters( 'widget_title', $instance['harmonized_icons'] );
        if ($harmonized_icons != "harmonized") $harmonized_icons = "unharmonized";

        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        if ( ! empty( $instance['blog_url'] ) ){
            echo '<a class="govuk-footer__link hale-social-link" href="' . $instance['blog_url']  . '"><span class="govuk-visually-hidden">Blog</span><i class="blog-icon ' . $harmonized_icons . '" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['facebook_url'] ) ){
            echo '<a class="govuk-footer__link hale-social-link" href="' . $instance['facebook_url']  . '"><span class="govuk-visually-hidden">Facebook</span><i class="facebook ' . $harmonized_icons . '" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['instagram_url'] ) ){
            echo '<a class="govuk-footer__link hale-social-link" href="' . $instance['instagram_url']  . '"><span class="govuk-visually-hidden">Instagram</span><i class="instagram ' . $harmonized_icons . '" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['linkedin_url'] ) ){
            echo '<a class="govuk-footer__link hale-social-link" href="' . $instance['linkedin_url']  . '"><span class="govuk-visually-hidden">Linkedin</span><i class="linkedin ' . $harmonized_icons . '" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['twitter_url'] ) ){
            echo '<a class="govuk-footer__link hale-social-link" href="' . $instance['twitter_url']  . '"><span class="govuk-visually-hidden">Twitter</span><i class="twitter ' . $harmonized_icons . '" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['vimeo_url'] ) ){
            echo '<a class="govuk-footer__link hale-social-link" href="' . $instance['vimeo_url']  . '"><span class="govuk-visually-hidden">Vimeo</span><i class="vimeo ' . $harmonized_icons . '" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['youtube_url'] ) ){
            echo '<a class="govuk-footer__link hale-social-link" href="' . $instance['youtube_url']  . '"><span class="govuk-visually-hidden">YouTube</span><i class="youtube ' . $harmonized_icons . '" aria-hidden="true"></i></a>';
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = '';
        $harmonized_icons = '';
        $blog_url = '';
        $facebook_url = '';
        $instagram_url = '';
        $linkedin_url = '';
        $twitter_url = '';
        $vimeo_url = '';
        $youtube_url = '';

        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
        }

        if ( isset( $instance[ 'harmonized_icons' ] ) ) {
            $harmonized_icons = $instance[ 'harmonized_icons' ];
        }

        if ( isset( $instance[ 'blog_url' ] ) ) {
            $blog_url = $instance[ 'blog_url' ];
        }

        if ( isset( $instance[ 'facebook_url' ] ) ) {
            $facebook_url = $instance[ 'facebook_url' ];
        }

        if ( isset( $instance[ 'instagram_url' ] ) ) {
            $instagram_url = $instance[ 'instagram_url' ];
        }

        if ( isset( $instance[ 'linkedin_url' ] ) ) {
            $linkedin_url = $instance[ 'linkedin_url' ];
        }

        if ( isset( $instance[ 'twitter_url' ] ) ) {
            $twitter_url = $instance[ 'twitter_url' ];
        }

        if ( isset( $instance[ 'vimeo_url' ] ) ) {
            $vimeo_url = $instance[ 'vimeo_url' ];
        }

        if ( isset( $instance[ 'youtube_url' ] ) ) {
            $youtube_url = $instance[ 'youtube_url' ];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <input type="checkbox" id=<?php echo $this->get_field_id( "harmonized_icons");?> name=<?php echo $this->get_field_name( "harmonized_icons");?> value="harmonized" <?php printf($harmonized_icons == "harmonized" ? "checked" : "");?>>
            <label for=<?php echo $this->get_field_id( "harmonized_icons");?>>Harmonize icons</label><br>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'blog_url' ); ?>"><?php _e( 'Blog URL' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'blog_url' ); ?>" name="<?php echo $this->get_field_name( 'blog_url' ); ?>" type="text" value="<?php echo esc_attr( $blog_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook URL' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" type="text" value="<?php echo esc_attr( $facebook_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'instagram_url' ); ?>"><?php _e( 'Instagram URL' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'instagram_url' ); ?>" name="<?php echo $this->get_field_name( 'instagram_url' ); ?>" type="text" value="<?php echo esc_attr( $instagram_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'linkedin_url' ); ?>"><?php _e( 'LinkedIn URL' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_url' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_url' ); ?>" type="text" value="<?php echo esc_attr( $linkedin_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e( 'Twitter URL' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" type="text" value="<?php echo esc_attr( $twitter_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'vimeo_url' ); ?>"><?php _e( 'Vimeo URL' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'vimeo_url' ); ?>" name="<?php echo $this->get_field_name( 'vimeo_url' ); ?>" type="text" value="<?php echo esc_attr( $vimeo_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'youtube_url' ); ?>"><?php _e( 'YouTube URL' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'youtube_url' ); ?>" name="<?php echo $this->get_field_name( 'youtube_url' ); ?>" type="text" value="<?php echo esc_attr( $youtube_url ); ?>" />
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['harmonized_icons'] = ( ! empty( $new_instance['harmonized_icons'] ) ) ? strip_tags( $new_instance['harmonized_icons']) : '';
        $instance['blog_url'] = ( ! empty( $new_instance['blog_url'] ) ) ? strip_tags( $new_instance['blog_url'] ) : '';
        $instance['facebook_url'] = ( ! empty( $new_instance['facebook_url'] ) ) ? strip_tags( $new_instance['facebook_url'] ) : '';
        $instance['instagram_url'] = ( ! empty( $new_instance['instagram_url'] ) ) ? strip_tags( $new_instance['instagram_url'] ) : '';
        $instance['linkedin_url'] = ( ! empty( $new_instance['linkedin_url'] ) ) ? strip_tags( $new_instance['linkedin_url'] ) : '';
        $instance['twitter_url'] = ( ! empty( $new_instance['twitter_url'] ) ) ? strip_tags( $new_instance['twitter_url'] ) : '';
        $instance['vimeo_url'] = ( ! empty( $new_instance['vimeo_url'] ) ) ? strip_tags( $new_instance['vimeo_url'] ) : '';
        $instance['youtube_url'] = ( ! empty( $new_instance['youtube_url'] ) ) ? strip_tags( $new_instance['youtube_url'] ) : '';
        return $instance;
    }

}


// Register and load the widget
function hale_load_widget() {
    register_widget( 'social_widget' );
}
add_action( 'widgets_init', 'hale_load_widget' );
