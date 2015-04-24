<?php

class Shapla_Google_Adsense_Admin {

	/**
	 * Register the stylesheets for the Dashboard.
	 *
	 * @since    1.0.0
	 */
	public function shapla_profile_adsense_show( $user ) {

		$adsense_ad_size = get_user_meta( $user->ID, 'adsense_ad_size', true);

		$html = '<h3>Your Google AdSense Ads</h3>
		<table class="form-table">
			<tr>
				<th><label for="adsense_300x250">AdSense Ad Code for vertical or square or rectangle size</label></th>
				<td><textarea name="adsense_300x250" id="adsense_300x250" rows="5" cols="30">' . get_user_meta( $user->ID, 'adsense_300x250', true) . '</textarea><br>
				<span class="adsense_300x250">Your Google AdSense JavaScript code for (336x280 large rectangle) or (300x250 medium rectangle) or (300x600 half page) or any vertical or square or rectangle size ad size.</span></td>
			</tr>
			<tr>
				<th><label for="adsense_728x90">AdSense Ad Code for any horizontal size</label></th>
				<td><textarea name="adsense_728x90" id="adsense_728x90" rows="5" cols="30">' . get_user_meta( $user->ID, 'adsense_728x90', true) . '</textarea><br>
				<span class="adsense_728x90">Your Google AdSense JavaScript code for (728x90 leaderboard) or (468x60 banner) or any horizontal ad space.</span></td>
			</tr>
			<tr>
				<th><label for="afterparagraph">Display Ad after the "n"th paragraph</label></th>
				<td><input type="number" min="1" max="10" name="afterparagraph" value="' . get_user_meta( $user->ID, 'afterparagraph', true) . '"><br>
				<span class="afterparagraph">Display Ad after the "n"th paragraph of post. By default it will show after first paragraph.</span></td>
			</tr>
			<tr>
				<th><label for="adsense_ad_size">Ad Type</label></th>
				<td><select name="adsense_ad_size">
				    <option value="vertical" '.selected( $adsense_ad_size, 'vertical' ).'>Vertical, square, rectangle</option>
				    <option value="horizontal" '.selected( $adsense_ad_size, 'horizontal' ).'>Horizontal</option>
				</select><br>
				<span class="afterparagraph">Select Ad (type)formats that you want to show inside content at single post page.</span></td>
			</tr>
		</table>';

		echo $html;

	}

	// save the changes above
	public function shapla_profile_adsense_save( $user_id ) {
		if ( !current_user_can( 'edit_user', $user_id ) )
			return false;
		update_user_meta( $user_id, 'adsense_300x250', $_POST['adsense_300x250'] );
		update_user_meta( $user_id, 'adsense_728x90',  $_POST['adsense_728x90']  );
		update_user_meta( $user_id, 'afterparagraph',  $_POST['afterparagraph']  );
		update_user_meta( $user_id, 'adsense_ad_size',  $_POST['adsense_ad_size']  );
	}

}
