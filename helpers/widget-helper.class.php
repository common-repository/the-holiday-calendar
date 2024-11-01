<?php
class thc_widget_helper
{
    static function get_selected_country($allowUserToChangeCountry, $defaultCountry)
    {
        $defaultCountry = $defaultCountry ?? thc_constants::DEFAULT_COUNTRY;
        
        if(!$allowUserToChangeCountry)
		{	
            return $defaultCountry;
        }

        if(thc_settings_helper::get_no_cookie_mode())
        {
            return http_get_helper::get_countryIso() ?? $defaultCountry;
        }

        if (isset($_SESSION[thc_constants::SELECTED_COUNTRY_ID])) {
            return $_SESSION[thc_constants::SELECTED_COUNTRY_ID];
        }

        return $defaultCountry;
    }
}
?>