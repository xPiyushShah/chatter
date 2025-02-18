<?php
namespace Config;
use App\Libraries;

use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function webSocketServer($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('WebSocketServer');
        }
        return new \App\Libraries\WebSocketServer();
    }
}
