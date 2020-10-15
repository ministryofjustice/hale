<?php
class social_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'social_widget',
            __('Social Widget', 'nightingale'),
            array( 'description' => __( 'Widget to show social links', 'nightingale' ), )
        );
    }

    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );

        echo $args['before_widget'];
        if ( ! empty( $title ) )
            echo $args['before_title'] . $title . $args['after_title'];

        if ( ! empty( $instance['facebook_url'] ) ){
            echo '<a href="' . $instance['facebook_url']  . '"><span class="nhsuk-u-visually-hidden">Facebook</span><i class="facebook" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['instagram_url'] ) ){
            echo '<a href="' . $instance['instagram_url']  . '"><span class="nhsuk-u-visually-hidden">Instagram</span><i class="instagram" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['linkedin_url'] ) ){
            echo '<a href="' . $instance['linkedin_url']  . '"><span class="nhsuk-u-visually-hidden">Linkedin</span><i class="linkedin" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['twitter_url'] ) ){
            echo '<a href="' . $instance['twitter_url']  . '"><span class="nhsuk-u-visually-hidden">Twitter</span><i class="twitter" aria-hidden="true"></i></a>';
        }

        if ( ! empty( $instance['youtube_url'] ) ){
            echo '<a href="' . $instance['youtube_url']  . '"><span class="nhsuk-u-visually-hidden">YouTube</span><i class="youtube" aria-hidden="true"></i></a>';
        }

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title = '';
        $facebook_url = '';
        $instagram_url = '';
        $linkedin_url = '';
        $twitter_url = '';
        $youtube_url = '';

        if ( isset( $instance[ 'title' ] ) ) {
            $title = $instance[ 'title' ];
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

        if ( isset( $instance[ 'youtube_url' ] ) ) {
            $youtube_url = $instance[ 'youtube_url' ];
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'facebook_url' ); ?>"><?php _e( 'Facebook Url:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'facebook_url' ); ?>" name="<?php echo $this->get_field_name( 'facebook_url' ); ?>" type="text" value="<?php echo esc_attr( $facebook_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'instagram_url' ); ?>"><?php _e( 'Instagram Url:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'instagram_url' ); ?>" name="<?php echo $this->get_field_name( 'instagram_url' ); ?>" type="text" value="<?php echo esc_attr( $instagram_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'linkedin_url' ); ?>"><?php _e( 'Linkedin Url:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'linkedin_url' ); ?>" name="<?php echo $this->get_field_name( 'linkedin_url' ); ?>" type="text" value="<?php echo esc_attr( $linkedin_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'twitter_url' ); ?>"><?php _e( 'Twitter Url:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'twitter_url' ); ?>" name="<?php echo $this->get_field_name( 'twitter_url' ); ?>" type="text" value="<?php echo esc_attr( $twitter_url ); ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'youtube_url' ); ?>"><?php _e( 'YouTube Url:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'youtube_url' ); ?>" name="<?php echo $this->get_field_name( 'youtube_url' ); ?>" type="text" value="<?php echo esc_attr( $youtube_url ); ?>" />
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['facebook_url'] = ( ! empty( $new_instance['facebook_url'] ) ) ? strip_tags( $new_instance['facebook_url'] ) : '';
        $instance['instagram_url'] = ( ! empty( $new_instance['instagram_url'] ) ) ? strip_tags( $new_instance['instagram_url'] ) : '';
        $instance['linkedin_url'] = ( ! empty( $new_instance['linkedin_url'] ) ) ? strip_tags( $new_instance['linkedin_url'] ) : '';
        $instance['twitter_url'] = ( ! empty( $new_instance['twitter_url'] ) ) ? strip_tags( $new_instance['twitter_url'] ) : '';
        $instance['youtube_url'] = ( ! empty( $new_instance['youtube_url'] ) ) ? strip_tags( $new_instance['youtube_url'] ) : '';
        return $instance;
    }

}


// Register and load the widget
function nightingale_load_widget() {
    register_widget( 'social_widget' );
}
add_action( 'widgets_init', 'nightingale_load_widget' );
