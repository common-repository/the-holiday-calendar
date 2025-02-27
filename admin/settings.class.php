<?php
/*
Date format
More info
*/
class thc_settings {

	const SETTINGS_PAGE_SLUG = 'events';
	const SETTINGS_SECTION_NAME = 'thc_settings_section';
	const SETTINGS_GROUP_NAME = 'thc_option_group';

	/**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
		add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'thc_settings_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        $settingsText = __( 'Settings', 'the-holiday-calendar' );

		add_submenu_page(
			'edit.php?post_type=' . thc_constants::POSTTYPE,
			'The Holiday Calendar ' . lcfirst($settingsText),
			ucfirst($settingsText),
			'manage_options',
			self::SETTINGS_PAGE_SLUG,
			array( $this, 'create_admin_page' )
		);
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( thc_settings_helper::OPTION_NAME );
        ?>
        <div class="wrap">
            <h2>The Holiday Calendar Settings</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( self::SETTINGS_GROUP_NAME );
                do_settings_sections( self::SETTINGS_PAGE_SLUG );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function thc_settings_init()
    {
        register_setting(
            self::SETTINGS_GROUP_NAME, // Option group
            thc_settings_helper::OPTION_NAME, // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            self::SETTINGS_SECTION_NAME, // ID
            null, // Title
            array( $this, 'print_section_info' ), // Callback
            self::SETTINGS_PAGE_SLUG // Page
        );

        add_settings_field(
            thc_settings_helper::DATE_FORMAT_KEY, // ID
            __( 'Date format', 'the-holiday-calendar' ), // Title
            array( $this, 'date_format_render' ), // Callback
            self::SETTINGS_PAGE_SLUG, // Page
            self::SETTINGS_SECTION_NAME // Section
        );

        add_settings_field(
            thc_settings_helper::HIDE_READMORE_KEY,
            __( 'Hide read more link', 'the-holiday-calendar' ),
            array( $this, 'read_more_render' ),
            self::SETTINGS_PAGE_SLUG,
            self::SETTINGS_SECTION_NAME
        );

		add_settings_field(
            thc_settings_helper::SHOW_DATE_IN_TITLE_KEY,
            __( 'Show date on event page', 'the-holiday-calendar' ),
            array( $this, 'show_date_in_title_render' ),
            self::SETTINGS_PAGE_SLUG,
            self::SETTINGS_SECTION_NAME
        );

		add_settings_field(
            thc_settings_helper::HIDE_HOLIDAY_EXCERPT_KEY,
            __( 'Hide background information about holidays', 'the-holiday-calendar' ),
            array( $this, 'hide_holiday_excerpt_render' ),
            self::SETTINGS_PAGE_SLUG,
            self::SETTINGS_SECTION_NAME
        );

		add_settings_field(
            thc_settings_helper::NO_COOKIE_MODE,
            __( 'No cookie mode', 'the-holiday-calendar' ),
            array( $this, 'no_cookie_mode_render' ),
            self::SETTINGS_PAGE_SLUG,
            self::SETTINGS_SECTION_NAME
        );

		add_settings_field(
            thc_settings_helper::APPLY_HOLIDAY_CALENDAR_THEME,
            __( 'Apply "The Holiday Calendar" theme', 'the-holiday-calendar' ),
            array( $this, 'apply_holiday_calendar_theme_render' ),
            self::SETTINGS_PAGE_SLUG,
            self::SETTINGS_SECTION_NAME
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();

        if( isset( $input[thc_settings_helper::DATE_FORMAT_KEY] ) )
            $new_input[thc_settings_helper::DATE_FORMAT_KEY] = sanitize_text_field( $input[thc_settings_helper::DATE_FORMAT_KEY] );

        if( isset( $input[thc_settings_helper::HIDE_READMORE_KEY] ) )
            $new_input[thc_settings_helper::HIDE_READMORE_KEY] = sanitize_text_field( $input[thc_settings_helper::HIDE_READMORE_KEY] );

		if( isset( $input[thc_settings_helper::SHOW_DATE_IN_TITLE_KEY] ) )
            $new_input[thc_settings_helper::SHOW_DATE_IN_TITLE_KEY] = sanitize_text_field( $input[thc_settings_helper::SHOW_DATE_IN_TITLE_KEY] );

		if( isset( $input[thc_settings_helper::HIDE_HOLIDAY_EXCERPT_KEY] ) )
            $new_input[thc_settings_helper::HIDE_HOLIDAY_EXCERPT_KEY] = sanitize_text_field( $input[thc_settings_helper::HIDE_HOLIDAY_EXCERPT_KEY] );
            
        if( isset( $input[thc_settings_helper::NO_COOKIE_MODE] ) )
            $new_input[thc_settings_helper::NO_COOKIE_MODE] = sanitize_text_field( $input[thc_settings_helper::NO_COOKIE_MODE] );

        if( isset( $input[thc_settings_helper::APPLY_HOLIDAY_CALENDAR_THEME] ) )
                $new_input[thc_settings_helper::APPLY_HOLIDAY_CALENDAR_THEME] = sanitize_text_field( $input[thc_settings_helper::APPLY_HOLIDAY_CALENDAR_THEME] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        //print 'The following settings apply to all holiday calendars:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function date_format_render()
    {
		$dateFormats = array('dd-mm-yy' => '0', 'dd.mm.yy' => '1', 'dd.mm.yyyy' => '2', 'dd/mm/yy' => '3', 'dd/mm/yyyy' => '4', 'm/d/yyyy' => '5', 'yy/mm/dd' => '6', 'yyyy&#51068; m&#51068; d&#51068;' => '7', 'dd-mm-yyyy' => '8');

        ?>
			<select name='thc_settings[<?php echo thc_settings_helper::DATE_FORMAT_KEY; ?>]'>
				<?php foreach($dateFormats as $dateFormat => $code) { ?>
				  <option <?php selected( $this->options[thc_settings_helper::DATE_FORMAT_KEY], $code ); ?> value="<?php echo $code; ?>"><?php echo $dateFormat; ?></option>
				<?php } ?>
			</select>
		<?php
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function read_more_render()
    {
        ?>
			<input type='checkbox' name='thc_settings[<?php echo thc_settings_helper::HIDE_READMORE_KEY; ?>]' <?php checked(thc_settings_helper::get_hide_readmore(), 1 ); ?> value='1'>
		<?php
    }

	public function show_date_in_title_render()
    {
        ?>
			<input type='checkbox' name='thc_settings[<?php echo thc_settings_helper::SHOW_DATE_IN_TITLE_KEY; ?>]' <?php checked( thc_settings_helper::get_show_date_in_title(), 1 ); ?> value='1'> <?php _e( 'Recommended! (However, some websites made some modifications and may want to disable this.)', 'the-holiday-calendar' ); ?>
		<?php
    }

	public function hide_holiday_excerpt_render()
    {
        ?>
			<input type='checkbox' name='thc_settings[<?php echo thc_settings_helper::HIDE_HOLIDAY_EXCERPT_KEY; ?>]' <?php checked(thc_settings_helper::get_hide_holiday_excerpt(), 1 ); ?> value='1'>
		<?php
    }

	public function no_cookie_mode_render()
    {
        ?>
			<input type='checkbox' name='thc_settings[<?php echo thc_settings_helper::NO_COOKIE_MODE; ?>]' <?php checked(thc_settings_helper::get_no_cookie_mode(), 1 ); ?> value='1'> <?php _e( 'Sometimes needed if cookies are blocked on the server side. Without cookie, visitor preferences are not saved.', 'the-holiday-calendar' ); ?>
		<?php
    }

	public function apply_holiday_calendar_theme_render()
    {
        ?>
			<input type='checkbox' name='thc_settings[<?php echo thc_settings_helper::APPLY_HOLIDAY_CALENDAR_THEME; ?>]' <?php checked(thc_settings_helper::get_apply_holiday_calendar_theme(), 1 ); ?> value='1'> <?php _e( 'Not compatible with all WordPress themes. Always check the result after enabling this. Only visible in calendar mode.', 'the-holiday-calendar' ); ?>
		<?php
    }
}
