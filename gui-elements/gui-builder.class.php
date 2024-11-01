<?php
class thc_gui_builder {
	static function build($displayMode, $includeHolidays, $countryIso, $numberOfHolidays, $firstDayOfWeek, $unique_id, $allowUserToChangeCountry, $show_powered_by)
	{
		$countryIso = strtolower($countryIso);
		$output = '<div class="' . ($displayMode ? 'thc-mode-calendar' : 'thc_mode_list') . '">';

		global $wp_query;
		$yearToShow = $displayMode == 1 && null !== http_get_helper::get_month() ? substr(http_get_helper::get_month(), 0, 4) : date('Y');
		$monthToShow = $displayMode == 1 && null !== http_get_helper::get_month() ? intval(substr(http_get_helper::get_month(), 4, 2)) : date('n');

		$args = array(
				'post_type'  => thc_constants::POSTTYPE,
				'meta_query' => array(
					array(
						'key'     => 'eventDate',
						'value'   => ($yearToShow - ($displayMode == 0 ? 0 : 1)) . '-' . str_pad($monthToShow, 2 , '0', STR_PAD_LEFT) . '-' . ($displayMode == 0 ? date('d') : '01'),
						'compare' => '>=',
					),
				),
				'orderby' => 'eventDate',
				'order' => 'ASC',
				'posts_per_page' => $displayMode == 0 ? $numberOfHolidays : 1000
			);

		$query = new WP_Query( $args );
		$events = array();

		// The Loop
		if ( $query->have_posts() ) {
			$separator = '';
			while ( $query->have_posts() ) {
				$query->the_post();

				$eventDate = get_post_meta( $query->post->ID, 'eventDate', true );
				$eventTime = get_post_meta( $query->post->ID, 'eventTime', true );

				$eventDateEnd = get_post_meta( $query->post->ID, 'eventDateEnd', true);
				$eventTimeEnd = get_post_meta( $query->post->ID, 'eventTimeEnd', true);

				$url = get_permalink();

				if(empty($eventDateEnd))
				{
					$eventDateEnd = $eventDate; //use $eventDate as default for backwards compatibility
				}

				$days_difference = thc_helper::get_difference_in_days($eventDate, $eventDateEnd);

				for($i = 0; $i <= $days_difference; $i++)
				{
					$currentEventDate = date('Y-m-d', strtotime($eventDate. ' + ' . $i . ' days'));

					$event = new thc_event();

					$event->formattedDate = thc_string_helper::format_current_date($eventDate, $eventTime, $eventDateEnd, $eventTimeEnd, $currentEventDate);

					request_helper::set_surpress_title_filter(true);
					$event->title = get_the_title();
					request_helper::set_surpress_title_filter(false);

					if($displayMode == 1)
					{
						$event->title = thc_string_helper::format_current_title($eventDate, $eventTime, $eventDateEnd, $eventTimeEnd, $currentEventDate, $event->title);
					}

					$event->eventDate = $currentEventDate;
					$event->url = $url;
					$event->isExternal = false;

					$events[] = $event;
				}
			}
		}

		/* Restore original Post Data */
		wp_reset_postdata();

		if($displayMode == 0)
		{
			if($includeHolidays)
			{
				$fromDate = $yearToShow . '-' . str_pad($monthToShow, 2 , '0', STR_PAD_LEFT) . '-' . date('d');

				$events = thc_helper::add_remote_events($events, $countryIso, $unique_id, NULL, $fromDate);

				usort($events, array(__CLASS__, 'sortByDate'));
			}

			$events = array_slice($events, 0, $numberOfHolidays);

			$output .= '<div class="thc-list thc-holidays" style="display:table; border-collapse: collapse;">';

			$output .= thc_list::render_list($events, $countryIso);

			$output .= '</div>';
		}
		else
		{
			if($includeHolidays)
			{
				$events = thc_helper::add_remote_events($events, $countryIso, $unique_id);
			}

			$output .= '<div class="thc-calendar widget_calendar">';
			$output .= thc_calendar::draw_calendar($monthToShow,$yearToShow, $firstDayOfWeek == 0, $events, $countryIso);
			$output .= '</div>';
		}

		if($allowUserToChangeCountry)
		{
			$api_countries = thc_api_client::get_available_countries();
			$countries = array();

			foreach($api_countries as $api_country) {
				$countries[$api_country->name] = strtoupper($api_country->iso);
			}
			ksort($countries);
			
			$output .= '<div class="country-selector">';

			if(thc_settings_helper::get_no_cookie_mode())
			{
				$output .= '<form method="get" action="">';
				foreach($_GET as $name => $value) {
					if($name == thc_constants::SELECTED_COUNTRY_ID)
					{
						continue;
					}

					$name = htmlspecialchars($name);
					$value = htmlspecialchars($value);

					$output .= '<input type="hidden" name="'. $name .'" value="'. $value .'">';
				  }
			}
			else
			{
				$output .= '<form method="post" action="' . esc_url( admin_url('admin-post.php') ) . '">';
				$output .= '<input name="action" type="hidden" value="thc_change_holiday_country">';
			}

			$output .= '<label for="country">' . __( 'Holiday country:', 'the-holiday-calendar' ) . '</label>';				
			$output .= '<select name="' . thc_constants::SELECTED_COUNTRY_ID . '" onchange="this.form.submit()">';			
			foreach($countries as $country => $iso) {
				$iso = strtolower($iso);
				$output .= '<option ' . selected($countryIso, $iso, false ) . ' value="' . $iso . '">' . $country . '</option>';
			} 			
			$output .= '</select>';
			$output .= '</form>';	
			$output .= '</div>';	
		}

		if($show_powered_by) {
			$output .= '<div class="thc-widget-footer" style="clear: left;"><span class="thc-powered-by" style="clear: left;">Powered by&nbsp;</span><a href="http://' . thc_constants::WEBSITE_URL . '/" title="The Holiday Calendar - All holidays in one overview" target="_blank">The Holiday Calendar</a></div>';
		}

		$output .= '</div>';

		return $output;
	}

	static function sortByDate($a, $b) {
		return strcasecmp($a->eventDate, $b->eventDate);
	}
}
?>
