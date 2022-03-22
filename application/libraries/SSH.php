<?php
require_once(APPPATH . 'third_party' . DIRECTORY_SEPARATOR . 'phpseclib3' . DIRECTORY_SEPARATOR . 'vendor'  . DIRECTORY_SEPARATOR . 'autoload.php');

use phpseclib3\Net\SSH2;
class SSH
{

    private $sshConnection = NULL;

    public function __destruct()
    {
        
    }

    public function __construct()
    {
        
    }

    public function new($address, $port, $username, $password, $timeout = 3)
    {
        $this->timeout = $timeout;
        $this->sshConnection = new SSH2($address, $port, $timeout);
        $this->sshConnection->login($username, $password);
    }

    
    public function disconnect()
    {
        $this->sshConnection->disconnect();
    }

    public function write($command)
    {
        $res = FALSE;
        if ($command == ' ') {
            $res = FALSE;
        } else {
            $command = trim($command);
            if (substr($command, 0, 1) == "*") return TRUE;
        }
        try {
            if (substr($command, -1) != "\r\n" && substr($command, -1) != "\n") $command .= "\n";
            $res = $this->sshConnection->write($command);
        } catch (\Throwable $th) {
            $res = FALSE;
        }
        return $res;
    }

    public function read($var = NULL)
    {
        return $this->sshConnection->read($var);
    }
}
?>