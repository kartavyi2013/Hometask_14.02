<?php

namespace includes\controllers\admin\menu;


class HomeTaskMainAdminSubMenuController extends HomeTaskBaseAdminMenuController
{

    public function action()
    {
        // TODO: Implement action() method.
        $pluginPage = add_submenu_page(
            HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN,
            _x(
                'HomeTask',
                'admin menu page' ,
                HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN
            ),
            _x(
                'HomeTask',
                'admin menu page' ,
                HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN
            ),
            'manage_options',
            'step_by_step_control_sub_menu',
            array(&$this, 'render'));
    }

    public function render()
    {
        // TODO: Implement render() method.
        _e("Hello world sub menu", HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN);
    }

    public static function newInstance()
    {
        // TODO: Implement newInstance() method.
        $instance = new self;
        return $instance;
    }
}
