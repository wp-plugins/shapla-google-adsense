<?php
// and finally, the widget to display the ads on the sidebar
class Shapla_AdSense_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
	 		'shapla_adsense_widget', // base ID of the widget
			'Shapla AdSense Widget', // the name of the widget
			array( 'description' => 'Shapla AdSense Widget Settings' ) // the description for the widget
		);
	}

 	public function form( $instance ) {

		if ( isset( $instance[ 'ad_type' ] ) ) {
			$ad_type = $instance[ 'ad_type' ];
		} else {
			$ad_type = '300x250';
		}

		$ad_script = (isset($instance['ad_script'])) ? $instance['ad_script'] : '';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_type' ); ?>">Ad Type</label> 
			<select class="widefat"  name="<?php echo $this->get_field_name( 'ad_type' ); ?>">
				<option value="vertical" <?php selected( $ad_type, 'vertical' ); ?>>Vertical, square, rectangle</option>
			    <option value="horizontal" <?php selected( $ad_type, 'horizontal' ); ?>>Horizontal</option>
			</select>
			<span class="description">Select ad formats that you want to show at widget. This ad will show only when user visit single page. If you paste AdSense Ad Code for widget, this option will not work.</span>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'ad_script' ); ?>">AdSense Ad Code for widget</label>
			<textarea class="widefat" name="<?php echo $this->get_field_name( 'ad_script' ); ?>" id="<?php echo $this->get_field_id( 'ad_script' ); ?>" rows="10"><?php echo $ad_script; ?></textarea>
			<span class="description">Paste your Google AdSense JavaScript code here for showing at you whole site</span>
		</p>
		<?php 
	}

	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance[ 'ad_type' ] 		= strip_tags( $new_instance[ 'ad_type' ] );
		$instance[ 'ad_script' ] 	=  $new_instance[ 'ad_script' ];
		return $instance;
	}

	public function widget( $args, $instance ) {

		$ad_types = $instance[ 'ad_type' ];
		$ad_script = $instance[ 'ad_script' ];

		if ( $ad_types == 'horizontal') {
			$ad_type = '728x90';
		} elseif ( $ad_types == 'horizontal' ) {
			$ad_type = '300x250';
		} else {
			$ad_type = '300x250';
		}

	    if (!empty($ad_script)) {

	    	$ad_code = $ad_script;

	    } elseif( is_single() ) {

			global $post;
			$user_id = $post->post_author;
			$ad_code = get_user_meta( $user_id, 'adsense_' . $ad_type, true );
	    }
		/* Display the widget title if one was input (before and after defined by themes). */
	    echo $args['before_widget'];
		
		if( isset($ad_code) && $ad_code != '') {
			// we'll return the ad code within a div which has a class for the ad type, just in case
			echo '<div class="adsense_' . $ad_type . '">' . $ad_code . '</div>';
		}

	    echo $args['after_widget'];
	}

}

function myplugin_register_widgets() {
	register_widget( 'Shapla_AdSense_Widget' );
}

add_action( 'widgets_init', 'myplugin_register_widgets' );

?>