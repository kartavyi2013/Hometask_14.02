<?php


namespace includes;

use includes\common\HomeTaskLoader;


class HomeTaskPlugin
{
    private static $instance = null;
    private function __construct() {




        HomeTaskLoader::getInstance();
    }
    public static function getInstance() {

        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;

    }
   
    static public function activation()
    {
        // debug.log
        error_log('plugin '.HOMETASKSHORTCODE_PlUGIN_NAME.' activation');
    }

    static public function deactivation()
    {
        // debug.log
        error_log('plugin '.HOMETASKSHORTCODE_PlUGIN_NAME.' deactivation');
    }


}

 
HomeTaskPlugin::getInstance();

