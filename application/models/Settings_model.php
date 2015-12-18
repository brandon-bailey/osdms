<?php
/**
 * Class that handles the settings values
 */
class Settings_Model extends CI_Model {
	public $config = array();
	public $is_loaded = array();
	public $_config_paths = array(APPPATH);

	public function __construct() {
		parent::__construct();
	}
	/*
		*	Load the settings into an array from file
		*
		*/
	public function loadSettings($file = '', $use_sections = FALSE, $fail_gracefully = FALSE) {
		$loaded = FALSE;

		foreach ($this->_config_paths as $path) {
			$file_path = $path . 'config/' . $file . '.php';
			if (in_array($file_path, $this->is_loaded, TRUE)) {
				return TRUE;
			}

			if (!file_exists($file_path)) {
				continue;
			}

			include $file_path;

			if (!isset($config) OR !is_array($config)) {
				if ($fail_gracefully === TRUE) {
					return FALSE;
				}

				show_error('Your ' . $file_path . ' file does not appear to contain a valid configuration array.');
			}

			return $this->config = $config;

			$this->is_loaded[] = $file_path;
			$config = NULL;
			$loaded = TRUE;
		}
		if ($loaded === TRUE) {
			return TRUE;
		} elseif ($fail_gracefully === TRUE) {
			return FALSE;
		}
		show_error('The configuration file ' . $file . '.php does not exist.');
	}

	/**
	 * Fetch a config file item
	 *
	 * @param	string	$item	Config item name
	 * @param	string	$index	Index name
	 * @return	string|null	The configuration item or NULL if the item doesn't exist
	 */
	public function item($item, $index = '') {
		if ($index == '') {
			return isset($this->config[$item]) ? $this->config[$item] : NULL;
		}
		return isset($this->config[$index], $this->config[$index][$item]) ? $this->config[$index][$item] : NULL;
	}

	/**
	 * Save all the settings
	 * @param array $data Array of values to be saved ($key,$value)
	 * @return bool
	 */
	public function save($data) {
		$this->load->helper('file');
		echo json_encode($data);
		$configFile = APPPATH . 'config/custom.php';

		write_file($configFile, "<?php \n defined('BASEPATH') OR exit('No direct script access allowed');\n\n", 'w');

		foreach ($data as $key => $value) {

			if ($key == 'site_logo') {
				$this->modifyImage($value);
			}

			$path = '';
			if ($key == 'pdf_binary' OR $key == 'image_binary') {
				$path = "APPPATH .";
			}

			if ($value === 1 OR $value === '1') {
				$value == (bool) TRUE;
			}

			if ($value === 0 OR $value === '0') {
				$value == (bool) FALSE;
			} else {
				$value = "'" . $value . "'";
			}
			write_file($configFile, '$config[' . "'" . $key . "'" . '] =  ' . $path . $value . ';' . PHP_EOL . PHP_EOL, 'a');
		}
		return true;
	}

	/**
	 * Make sure the specified image has multiple sizes
	 * @param image location
	 */
	public function modifyImage($image) {
		$pathParts = pathinfo($image);
		$config['source_image'] = $image;
		$config['maintain_ratio'] = TRUE;
		$config['width'] = 32;
		$config['new_image'] = $pathParts['dirname'] . '/' . $pathParts['filename'] . '-' . $config['width'] . '.' . $pathParts['extension'];
		$this->load->library('image_lib', $config);
		echo '<br>' . $config['new_image'];
		if (!$this->image_lib->resize()) {
			echo $this->image_lib->display_errors();
		}
	}

	/**
	 * Load settings to an array
	 * return array
	 */
	public function load() {
		$this->db->select('name,value');
		$query = $this->db->get('settings');
		foreach ($query->result() as $row) {

			$GLOBALS['CONFIG'][$row->name] = $row->value;
		}
	}

	/**
	 * Show the settings edit form
	 */
	public function edit() {
		$this->db->select();
		$query = $this->db->get('settings');

		foreach ($query->result() as $row) {
			$settings[] = array(
				'name' => $row->name,
				'value' => $row->value,
				'description' => $row->description,
				'validation' => $row->validation,
			);
		}
		$data = array(
			'languages' => $this->getLanguages(),
			'userIdNums' => $this->getUserIdNums(),
			'settingsArray' => $settings,
		);
		return json_encode($data, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
	}

	/**
	 * Validate a specific setting based on its validation type
	 * @param string $key The name of the setting to be tested
	 * @param string $value The value of the setting to be tested
	 */
	public function validate($key, $value) {
		// NOT IMPLEMENTED
	}

	/**
	 * This function will return an array of the possible theme names found in the /templates folder
	 * for use in the settings form
	 */
	public function getThemes() {
		$themes = $this->getFolders(APPPATH . 'templates');
		return $themes;
	}

	/**
	 * @return mixed
	 */
	public function getLanguages() {
		$languages = $this->getFolders(APPPATH . 'language');
		return str_replace('.php', '', $languages);
	}

	/**
	 * @param string $path
	 * @return array
	 */
	public function getFolders($path = '.') {
		$file_list = array();
		if ($handle = opendir($path)) {
			while (false !== ($file = readdir($handle))) {
				// Filter out any other types of folders that might be in here
				if ($file != "." && $file != ".." && $file != ".svn" && $file != 'README' && $file != 'sync.sh' && $file != 'common' && $file != 'DataTables') {
					array_push($file_list, $file);
				}
			}
			closedir($handle);
		}
		return $file_list;
	}

	/**
	 * Return an array of user names
	 * @return array
	 */
	public function getUserIdNums() {
		$this->db->select('id,username');
		$query = $this->db->get('user');

		foreach ($query->result() as $row) {
			$data[] = array(
				'id' => $row->id,
				'username' => $row->username,
			);
		}

		return $data;
	}

}
