<?php

namespace includes\controllers\admin\menu;


abstract class HomeTaskBaseAdminMenuController
{
    public function __construct(){
        /*
         * Регистрирует хук-событие. При регистрации указывается PHP функция,
         * которая сработает в момент события, которое вызывается с помощью do_action().
         */
        add_action('admin_menu', array( &$this, 'action'));
    }

    abstract public function action();
    abstract public function render();
    abstract public static function newInstance();
}
