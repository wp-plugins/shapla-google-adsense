<?php

class Shapla_Google_Adsense_Public {


	// our main function to return the ad codes
	// remember: other functions below use this function, too!
	public function shapla_return_adsense( $ad_type = '728x90' ) {
		// the default ad codes - don't forget to change the values!
		$default_ad_codes = array(
			'300x250' => '<img src="http://dummyimage.com/300x250" />',
			'728x90'  => '<img src="http://dummyimage.com/728x90" />'
		);
		if( is_single() ) {
			global $post;
			$user_id = $post->post_author;
			$ad_code = get_user_meta( $user_id, 'adsense_' . $ad_type, true );
		} else {
			$ad_code = $default_ad_codes[$ad_type];
		}
		
		if($ad_code != '') {
			// we'll return the ad code within a div which has a class for the ad type, just in case
			return '<div class="adsense_' . $ad_type . '">' . $ad_code . '</div>';
		} else {
			return false;
		}
	}

	// the function to insert the ads automatically after the "n"th paragraph in a post
	// the following code is borrowed from Internoetics, then edited:
	// http://www.internoetics.com/2010/02/08/adsense-code-within-content/
	public function auto_insert_adsense($post_content) {
	   if ( !is_single() ) return $post_content;
	   // display after the "n"th paragraph
	   $afterParagraph = get_user_meta( get_current_user_id(), 'afterparagraph', true);
	   $adsense_ad_size = get_user_meta( get_current_user_id(), 'adsense_ad_size', true);
	   
	   if ($afterParagraph >= 1) {
	   		$afterParagraph = $afterParagraph;
	   } else {
	   		$afterParagraph = 1;
	   }

	   if ( $adsense_ad_size == 'vertical' ) {
	   		$ad_size = '300x250';
	   } elseif($adsense_ad_size == 'horizontal'){
	   		$ad_size = '728x90';
	   }else {
	   		$ad_size = '728x90';
	   }

	   $adsense = $this->shapla_return_adsense( $ad_size );
	   preg_match_all( '/<\/p>/', $post_content, $matches, PREG_OFFSET_CAPTURE );
	   $insert_at = $matches[0][$afterParagraph - 1][1];
	   return substr( $post_content, 0, $insert_at) . $adsense . substr( $post_content, $insert_at, strlen( $post_content ) );
	}

	public function shapla_gad_enqueue_scripts(){
		wp_enqueue_style( 'shapla-adsense', plugin_dir_url( __FILE__ ) .'style.css');
	}

}
