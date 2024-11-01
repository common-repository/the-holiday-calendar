<?php
class thc_api_client
{
    static function get_available_countries()
	{
		$url = 'http://' . thc_constants::WEBSITE_URL . '/api/v1/country';

        $result = wp_remote_get($url, array('timeout' => 30, 'headers' => 'Accept: application/json'));

        $countries = self::convert_json_to_plugin_countries($result['body']);

        return $countries;
    }    

	static function convert_json_to_plugin_countries($json_string)
	{
		$plugin_countries = array();
		$json_countries = json_decode($json_string);

		if(count($json_countries) > 0)
		{
			foreach($json_countries as $json_country)
			{
				$plugin_countries[] = thc_plugin_country::create_from_object( $json_country );
			}
		}

		return $plugin_countries;
	}
}
?>