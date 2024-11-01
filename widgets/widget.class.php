<?php
class thc_widget {
	static function show($args, $instance) {
		extract( $args );
		// these are the widget options
		$title = apply_filters('widget_title', $instance['title']);

		echo $before_widget;

		// Display the widget
		echo '<div class="widget-text wp_widget_plugin_box">';

		// Check if title is set
		if ( $title ) {
		  echo $before_title . $title . $after_title;
		}
		
		$displayMode = isset($instance['displayMode']) ? $instance['displayMode'] : '0';
		$includeHolidays = !isset($instance['includeThcEvents2']) || $instance['includeThcEvents2'] == '1';	
		$allowUserToChangeCountry = isset($instance['allowUserToChangeCountry']) ? $instance['allowUserToChangeCountry'] : '0';	
		$countryIso = thc_widget_helper::get_selected_country($allowUserToChangeCountry, $instance['country2']);
		$numberOfHolidays = isset($instance['numberOfHolidays']) ? $instance['numberOfHolidays'] : '3';
		$firstDayOfWeek = isset($instance['firstDayOfWeek']) ? $instance['firstDayOfWeek'] : '0';
		$unique_id = $instance['unique_id'];
		$show_powered_by = '1' == $instance['show_powered_by'];

		echo '<div class="thc-widget-content">';

		echo thc_gui_builder::build($displayMode, $includeHolidays, $countryIso, $numberOfHolidays, $firstDayOfWeek, $unique_id, $allowUserToChangeCountry, $show_powered_by);

		echo '</div>';
		echo '</div>';

		echo $after_widget;
	}
}
?>
