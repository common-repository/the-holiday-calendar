<?php
class thc_widget_form {
	static function render_form($instance, $plugin)
	{
		// Check values
		if( $instance) {
			 $title = esc_attr($instance['title']);
		} else {
			 $title = '';
		}

		$api_countries = thc_api_client::get_available_countries();

		$countries = array();

		foreach($api_countries as $api_country) {
			$countries[$api_country->name] = strtoupper($api_country->iso);
		}

		//$countries = array('United States' => 'US', 'India' => 'IN', 'Japan' => 'JP', 'Brazil' => 'BR', 'Russia' => 'RU', 'Germany' => 'DE', 'United Kingdom' => 'GB', 'France' => 'FR', 'Mexico' => 'MX', 'South Korea' => 'KR', 'Australia' => 'AU', 'Ireland' => 'IE', 'Italy' => 'IT');
		$selectedCountry = isset($instance['country2']) ? $instance['country2'] : 'US';

		ksort($countries);

		$showPoweredBy = isset($instance['show_powered_by']) ? $instance['show_powered_by'] : '0';
		$includeThcEvents = isset($instance['includeThcEvents2']) ? $instance['includeThcEvents2'] : '1';
		$allowUserToChangeCountry = isset($instance['allowUserToChangeCountry']) ? $instance['allowUserToChangeCountry'] : '0';
		$displayMode = isset($instance['displayMode']) ? $instance['displayMode'] : '0';
		$firstDayOfWeek = isset($instance['firstDayOfWeek']) ? $instance['firstDayOfWeek'] : '0';
		$numberOfHolidays = isset($instance['numberOfHolidays']) ? $instance['numberOfHolidays'] : '3';

		?>

		<p>
			<label for="<?php echo $plugin->get_field_id('title'); ?>"><?php _e('Widget Title', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $plugin->get_field_id('title'); ?>" name="<?php echo $plugin->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($includeThcEvents, '1'); ?> id="<?php echo $plugin->get_field_id('includeThcEvents2'); ?>" name="<?php echo $plugin->get_field_name('includeThcEvents2'); ?>" value="1" />
			<label for="<?php echo $plugin->get_field_id('includeThcEvents2'); ?>"><?php _e( 'Include holidays (with settings below)', 'the-holiday-calendar' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $plugin->get_field_id('country2'); ?>"><?php _e( 'Country', 'the-holiday-calendar' ); ?></label>
			<select class="widefat" id="<?php echo $plugin->get_field_id('country2'); ?>" name="<?php echo $plugin->get_field_name('country2'); ?>" >
			<?php foreach($countries as $country => $iso) { ?>
			  <option <?php selected( $selectedCountry, $iso ); ?> value="<?php echo $iso; ?>"><?php echo $country; ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($allowUserToChangeCountry, '1'); ?> id="<?php echo $plugin->get_field_id('allowUserToChangeCountry'); ?>" name="<?php echo $plugin->get_field_name('allowUserToChangeCountry'); ?>" value="1" />
			<label for="<?php echo $plugin->get_field_id('allowUserToChangeCountry'); ?>"><?php _e( 'Allow user to change country', 'the-holiday-calendar' ); ?></label>
		</p>
		<p>
			<?php _e( 'Display mode', 'the-holiday-calendar' ); ?>:&nbsp;
			<label><input class="radio" type="radio" <?php checked($displayMode, '0'); ?> id="<?php echo $plugin->get_field_id('displayMode'); ?>" name="<?php echo $plugin->get_field_name('displayMode'); ?>" value="0" />
			<?php _e( 'List', 'the-holiday-calendar' ); ?></label>&nbsp;
			<label><input class="radio" type="radio" <?php checked($displayMode, '1'); ?> id="<?php echo $plugin->get_field_id('displayMode'); ?>" name="<?php echo $plugin->get_field_name('displayMode'); ?>" value="1" />
			<?php _e( 'Calendar', 'the-holiday-calendar' ); ?></label>
		</p>
		<p>
			<?php _e( 'First day of the week', 'the-holiday-calendar' ); ?>:&nbsp;
			<label><input class="radio" type="radio" <?php checked($firstDayOfWeek, '0'); ?> id="<?php echo $plugin->get_field_id('firstDayOfWeek'); ?>" name="<?php echo $plugin->get_field_name('firstDayOfWeek'); ?>" value="0" />
			<?php _e( 'Sun', 'the-holiday-calendar' ); ?></label>&nbsp;
			<label><input class="radio" type="radio" <?php checked($firstDayOfWeek, '1'); ?> id="<?php echo $plugin->get_field_id('firstDayOfWeek'); ?>" name="<?php echo $plugin->get_field_name('firstDayOfWeek'); ?>" value="1" />
			<?php _e( 'Mon', 'the-holiday-calendar' ); ?></label>
		</p>
		<p>
			<label for="<?php echo $plugin->get_field_id('numberOfHolidays'); ?>"><?php _e( 'Number of holidays (in list mode)', 'the-holiday-calendar' ); ?></label>
			<select class="widefat" id="<?php echo $plugin->get_field_id('numberOfHolidays'); ?>" name="<?php echo $plugin->get_field_name('numberOfHolidays'); ?>" >
			<?php for($i = 3; $i <= 5; $i++) { ?>
			  <option <?php selected( $numberOfHolidays, $i ); ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
			<?php } ?>
			</select>
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked($showPoweredBy, '1'); ?> id="<?php echo $plugin->get_field_id('show_powered_by'); ?>" name="<?php echo $plugin->get_field_name('show_powered_by'); ?>" value="1" />
			<label for="<?php echo $plugin->get_field_id('show_powered_by'); ?>"><?php _e( 'Enable "Powered by The Holiday Calendar". Thank you!!!', 'the-holiday-calendar' ); ?></label>
		</p>
		<p style="font-style: italic;"><?php _e( 'Additional settings can be found on the plugin\'s settings page.', 'the-holiday-calendar' ); ?></p>
		<?php $manualUrl = sprintf('<a title="WordPress › The Holiday Calendar « WordPress Plugins" target="_blank" href="https://wordpress.org/plugins/the-holiday-calendar/installation/">%s</a>', __( 'manual', 'the-holiday-calendar' )); ?>
		<p style="font-style: italic;"><?php printf( __( 'New! Short codes are now also supported. Check the %s for more info.', 'the-holiday-calendar' ), $manualUrl); ?> </p>
		<?php
	}
}
?>
