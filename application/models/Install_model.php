<?php
class Install_Model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

    }
/**
 * Create the default user when installing the
 * application.
 * @param  array $data
 * @return json encoded array response
 */
    public function createNewUser($data)
    {
        if (!$this->session->admin) {
            $msg = array(
                'status' => 'error',
                'msg' => 'You do not have permission to add a new user.',
            );
            echo json_encode($msg);
            exit;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('adminUsername', 'Username', 'trim|required');
        $this->form_validation->set_rules('adminEmail', 'Email', 'trim|required');
        $this->form_validation->set_rules('adminPhone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('firstName', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'trim|required');

        if ($this->form_validation->run() == false) {
            $msg = array(
                'status' => 'error',
                'msg' => validation_errors('', ''),
            );
            echo json_encode($msg);
            exit;
        }

        $data = array(
            'username' => $this->input->post('adminUsername'),
            'email' => $this->input->post('adminEmail'),
            'phone' => $this->input->post('adminPhone'),
            'department' => $this->input->post('department') ? $this->input->post('department') : 1,
            'first_name' => $this->input->post('firstName'),
            'last_name' => $this->input->post('lastName'),
            'password' => password_hash($this->input->post('adminPassword'), PASSWORD_DEFAULT),
            'last_pw_reset' => date('Y-m-d H:i:s'),
        );

        // Query to insert data in database
        //
        $this->db->insert('user', $data);

        if ($this->db->affected_rows() === 1) {
//$this->emailNewUser($data, $this->db->insert_id());

            $msg = array(
                'status' => 'success',
                'msg' => 'Successfully created the new user.',
            );
            echo json_encode($msg);
            exit;
        }

        // end insert new user
    }

    public function setupDatabase($data)
    {

    }

    public function databaseVariables()
    {

        $db['default'] = array(
            'dsn' => '',
            'hostname' => 'localhost',
            'username' => 'root',
            'password' => '',
            'database' => 'database_name',
            'dbdriver' => 'mysqli',
            'dbprefix' => '',
            'pconnect' => true,
            'db_debug' => true,
            'cache_on' => false,
            'cachedir' => '',
            'char_set' => 'utf8',
            'dbcollat' => 'utf8_general_ci',
            'swap_pre' => '',
            'encrypt' => false,
            'compress' => false,
            'stricton' => false,
            'failover' => array(),
        );
    }

    public function getPhpOptions()
    {

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

    public function getPhpSettings()
    {
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
