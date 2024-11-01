<?php
class thc_translation_helper {
	static function get_month_name($monthNumber)
	{		
		$monthTranslations = array(__( 'January', 'the-holiday-calendar' ), __( 'February', 'the-holiday-calendar' ), __( 'March', 'the-holiday-calendar' ), __( 'April', 'the-holiday-calendar' ), __( 'May', 'the-holiday-calendar' ), __( 'June', 'the-holiday-calendar' ), __( 'July', 'the-holiday-calendar' ), __( 'August', 'the-holiday-calendar' ), __( 'September', 'the-holiday-calendar' ), __( 'October', 'the-holiday-calendar' ), __( 'November', 'the-holiday-calendar' ), __( 'December', 'the-holiday-calendar' ));
		
		return $monthTranslations[$monthNumber - 1];
	}
	
	static function get_week_names()
	{		
		$weekdayTranslations = array(__( 'Sunday', 'the-holiday-calendar' ), __( 'Monday', 'the-holiday-calendar' ), __( 'Tuesday', 'the-holiday-calendar' ), __( 'Wednesday', 'the-holiday-calendar' ), __( 'Thursday', 'the-holiday-calendar' ), __( 'Friday', 'the-holiday-calendar' ), __( 'Saturday', 'the-holiday-calendar' ));

		return $weekdayTranslations;
	}
	
	static function get_read_more_text($event)
	{
		$read_more_string = null;		

		$read_more_string = __( 'Read more about %1$s on %2$s.', 'the-holiday-calendar' );
		
		$holiday_url = '<a href="' . $event->url . '" target="_blank" title="' . $read_more_string . '">' . $event->title . '</a>';
		$website_url = '<a href="http://' . thc_constants::WEBSITE_URL . '" title="The Holiday Calendar - All holidays in one place!" target="_blank">TheHolidayCalendar.com</a>';
		
		return sprintf('<p>' . $read_more_string . '</p>', $holiday_url, $website_url);
	}
}
?>