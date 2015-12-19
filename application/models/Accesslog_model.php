<?php
/**
 * Description of AccessLog_class.php
 *
 * This class provides the ability to track various changes to a file by
 * utilizing an access log
 *
 */
class AccessLog_Model extends CI_Model
{

    public $accessLog;
    private static $db;
    private static $session;

    public function __construct()
    {
        parent::__construct();
        self::$db = &get_instance()->db;
        self::$session = &get_instance()->session;
        $this->name = 'AccessLog';
        $this->author = '';
        $this->version = '1.0';
        $this->homepage = base_url();
        $this->description = 'AccessLog Plugin';
        $this->accessLog = '';
    }

    /**
     * @param string $_var The string to display
     */
    public function setAccessLog($_var)
    {
        $this->accessLog = $_var;
    }

    /**
     * @returns string $var Get the value of accesslog var
     */
    public function getAccessLog()
    {
        $var = $this->accessLog;
        return $var;
    }

    /**
     * Draw the admin menu
     * Required if you want an admin menu to show for your plugin
     */
    public function onAdminMenu()
    {
        $curdir = dirname(__FILE__);
    }

    /**
     * Create the entry into the access_log database
     * @param int $fileId
     * @param string $type The type of entry to describe what happened
     * @param PDO $pdo
     */
    public static function addLogEntry($fileId, $type)
    {
        if ($fileId == 0) {
            global $id;
            $fileId = $id;
        }
        $data = array(
            'file_id' => $fileId,
            'user_id' => self::$session->id,
            'timestamp' => date('Y-m-d H:i:s'),
            'action' => $type,
        );
        self::$db->insert('access_log', $data);
    }
}
