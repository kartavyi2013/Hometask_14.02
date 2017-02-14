<?php

namespace includes\controllers\admin\menu;


class HomeTaskMyMediaMenuController extends HomeTaskBaseAdminMenuController
{
    public function action()
    {
        // TODO: Implement action() method.

        $pluginPage = add_media_page(
            __('HomeTask', HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN),
            __('HomeTask', HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN),
            'read',
            'step_by_step_control_sub_media_menu',
            array(&$this, 'render')
        );
    }

    public function render()
    {
        // TODO: Implement render() method.
        _e("Hello this page media", HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN);
    }

    public static function newInstance()
    {
        // TODO: Implement newInstance() method.
        $instance = new self;
        return $instance;
    }
}
