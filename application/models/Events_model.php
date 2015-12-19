<?php
class Events_Model extends CI_Model
{
    
    public function sendData($msg)
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        echo 'data: ' . $msg. PHP_EOL;
        echo PHP_EOL;
        ob_flush();
    }
}
