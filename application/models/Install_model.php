<?php
class Install_Model extends CI_Model {

	function __construct($id) {
		parent::__construct();

	}

	public function getPhpOptions() {

		$options = array();

		// Check for magic quotes gpc.
		$option = new stdClass;
		$option->label = "Magic Quotes";
		$option->state = (ini_get('magic_quotes_gpc') == false);
		$option->notice = null;
		$options[] = $option;

		// Check for register globals.
		$option = new stdClass;
		$option->label = "Register Globals";
		$option->state = (ini_get('register_globals') == false);
		$option->notice = null;
		$options[] = $option;

		// Check for zlib support.
		$option = new stdClass;
		$option->label = "ZLIB Compression Support";
		$option->state = extension_loaded('zlib');
		$option->notice = null;
		$options[] = $option;

		// Check for XML support.
		$option = new stdClass;
		$option->label = "XML Support";
		$option->state = extension_loaded('xml');
		$option->notice = null;
		$options[] = $option;

		// Check for a missing native parse_ini_file implementation.
		$option = new stdClass;
		$option->label = "PHP INI";
		$option->state = $this->getIniParserAvailability();
		$option->notice = null;
		$options[] = $option;

		// Check for missing native json_encode / json_decode support.
		$option = new stdClass;
		$option->label = "JSON Support";
		$option->state = function_exists('json_encode') && function_exists('json_decode');
		$option->notice = null;
		$options[] = $option;

		return $options;
	}

	public function getPhpSettings() {
		$settings = array();

		// Check for safe mode.
		$setting = new stdClass;
		$setting->label = "Safe Mode";
		$setting->state = (bool) ini_get('safe_mode');
		$setting->recommended = false;
		$settings[] = $setting;

		// Check for display errors.
		$setting = new stdClass;
		$setting->label = "Display Errors";
		$setting->state = (bool) ini_get('display_errors');
		$setting->recommended = false;
		$settings[] = $setting;

		// Check for file uploads.
		$setting = new stdClass;
		$setting->label = "File Uploads";
		$setting->state = (bool) ini_get('file_uploads');
		$setting->recommended = true;
		$settings[] = $setting;

		// Check for magic quotes runtimes.
		$setting = new stdClass;
		$setting->label = "Magic Quotes Runtime";
		$setting->state = (bool) ini_get('magic_quotes_runtime');
		$setting->recommended = false;
		$settings[] = $setting;

		// Check for output buffering.
		$setting = new stdClass;
		$setting->label = "Output Buffering";
		$setting->state = (bool) ini_get('output_buffering');
		$setting->recommended = false;
		$settings[] = $setting;

		// Check for session auto-start.
		$setting = new stdClass;
		$setting->label = "Session Auto Start";
		$setting->state = (bool) ini_get('session.auto_start');
		$setting->recommended = false;
		$settings[] = $setting;

		// Check for native ZIP support.
		$setting = new stdClass;
		$setting->label = "ZLIB Support Available";
		$setting->state = function_exists('zip_open') && function_exists('zip_read');
		$setting->recommended = true;
		$settings[] = $setting;

		return $settings;
	}
}