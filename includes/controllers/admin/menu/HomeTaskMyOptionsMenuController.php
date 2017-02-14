<?php

namespace includes\controllers\admin\menu;


class HomeTaskMyOptionsMenuController extends HomeTaskBaseAdminMenuController
{
    public function action()
    {
        // TODO: Implement action() method.

        $pluginPage = add_options_page(
            __('Sub options HomeTask', HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN),
            __('Sub options HomeTask', HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN),
            'read',
            'step_by_step_control_sub_options_menu',
            array(&$this, 'render')
        );
    }

    public function render()
    {
        // TODO: Implement render() method.
        _e("Hello this page Settings", HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN);
    }

    public static function newInstance()
    {
        // TODO: Implement newInstance() method.
        $instance = new self;
        return $instance;
    }
}
