<?php

// PHP VERSION CHECK
if (!preg_match('/^(\d+\.\d+)/', PHP_VERSION, $ver) || ($ver[1] < 5.3))
    die("You are using PHP " . PHP_VERSION . " when Finder require at least version 5.3.0! Some systems has an option to change the active PHP version. Please refer to your hosting provider or upgrade your PHP distribution.");


// SAFE MODE CHECK
if (ini_get("safe_mode"))
    die("The \"safe_mode\" PHP ini setting is turned on! You cannot run Finder in safe mode.");


// CMS INTEGRATION
if (isset($_GET['cms']) &&
    (basename($_GET['cms']) == $_GET['cms']) &&
    is_file("integration/{$_GET['cms']}.php")
)
    require "integration/{$_GET['cms']}.php";


// REGISTER AUTOLOAD FUNCTION
require "core/autoload.php";


// json_encode() IMPLEMENTATION IF JSON EXTENSION IS MISSING
if (!function_exists("json_encode")) {

    function json_encode($data) {

        if (is_array($data)) {
            $ret = array();

            // OBJECT
            if (array_keys($data) !== range(0, count($data) - 1)) {
                foreach ($data as $key => $val)
                    $ret[] = json_encode((string) $key) . ':' . json_encode($val);
                return "{" . implode(",", $ret) . "}";

            // ARRAY
            } else {
                foreach ($data as $val)
                    $ret[] = json_encode($val);
                return "[" . implode(",", $ret) . "]";
            }

        // BOOLEAN OR NULL
        } elseif (is_bool($data) || ($data === null))
            return ($data === null)
                ? "null"
                : ($data ? "true" : "false");

        // FLOAT
        elseif (is_float($data))
            return rtrim(rtrim(number_format($data, 14, ".", ""), "0"), ".");

        // INTEGER
        elseif (is_int($data))
            return $data;

        // STRING
        return '"' .
            str_replace('/', "\\/",
            str_replace("\t", "\\t",
            str_replace("\r", "\\r",
            str_replace("\n", "\\n",
            str_replace('"', "\\\"",
            str_replace("\\", "\\\\",
        $data)))))) . '"';
    }
}

