<?php
class http_get_helper {
	static function get_day()
	{
		global $wp_query;
		
		$day = isset($wp_query->query_vars['thc-date']) ? $wp_query->query_vars['thc-date'] : date('Y-m-d');
		
		return $day;
	}
	
	static function get_countryIso()
	{
		global $wp_query;
		
		$countryIso = isset($wp_query->query_vars['thc-country']) ? $wp_query->query_vars['thc-country'] : null;
		
		return $countryIso;
	}	
	
	static function get_month()
	{
		$output = array();

		$query_string = $_SERVER['QUERY_STRING'];
		parse_str($query_string, $output);

		if(isset($output['thc-month']))
		{
			return str_replace(array('+', '-'), '', filter_var($output['thc-month'], FILTER_SANITIZE_NUMBER_INT));
		}

		return null;
	}
} 
?>