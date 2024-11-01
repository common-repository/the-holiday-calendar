<?php
	class thc_plugin_country
	{
        public $name;
        public $iso;
			
		public function __construct( $name, $iso )
		{
			$this->name = $name;
			$this->iso = $iso;
		}

		public static function create_from_object( $object )
		{
			return new self( $object->Name, $object->Iso );
		}
    }	
?>