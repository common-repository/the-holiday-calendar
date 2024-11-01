<?php
class thc_settings_helper
{
	const OPTION_NAME = 'thc_settings';
	const DATE_FORMAT_KEY = 'thc_date_format';
	const HIDE_READMORE_KEY = 'thc_hide_read_more';	
	const SHOW_DATE_IN_TITLE_KEY = 'thc_show_date_in_title';	
	const HIDE_HOLIDAY_EXCERPT_KEY = 'thc_hide_holiday_excerpt';
	const NO_COOKIE_MODE = 'thc_no_cookie_mode';
	const APPLY_HOLIDAY_CALENDAR_THEME = 'thc_apply_holiday_calendar_theme';
	
	static function get_date_format()
	{
		$option = get_option( self::OPTION_NAME );
		
		return $option[self::DATE_FORMAT_KEY];
	}
	
	static function get_hide_readmore()
	{
		$option = get_option( self::OPTION_NAME );
		
		return isset($option[self::HIDE_READMORE_KEY]) ? $option[self::HIDE_READMORE_KEY] : 0;
	}
	
	static function get_show_date_in_title()
	{
		$option = get_option( self::OPTION_NAME );
		
		return isset($option[self::SHOW_DATE_IN_TITLE_KEY]) ? $option[self::SHOW_DATE_IN_TITLE_KEY] : 0;
	}
	
	static function get_hide_holiday_excerpt()
	{
		$option = get_option( self::OPTION_NAME );
		
		return isset($option[self::HIDE_HOLIDAY_EXCERPT_KEY]) ? $option[self::HIDE_HOLIDAY_EXCERPT_KEY] : 0;
	}
	
	static function get_no_cookie_mode()
	{
		$option = get_option( self::OPTION_NAME );
		
		return isset($option[self::NO_COOKIE_MODE]) ? $option[self::NO_COOKIE_MODE] : 0;
	}
	
	static function get_apply_holiday_calendar_theme()
	{
		$option = get_option( self::OPTION_NAME );
		
		return isset($option[self::APPLY_HOLIDAY_CALENDAR_THEME]) ? $option[self::APPLY_HOLIDAY_CALENDAR_THEME] : 0;
	}
}
?>