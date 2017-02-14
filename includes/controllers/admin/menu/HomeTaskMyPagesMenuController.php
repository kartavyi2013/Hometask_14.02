<?php

namespace includes\controllers\admin\menu;


class HomeTaskMyPagesMenuController extends HomeTaskBaseAdminMenuController
{
    public function action()
    {
        // TODO: Implement action() method.

        $pluginPage = add_pages_page(
            __('Sub pages HomeTask', HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN),
            __('Sub pages HomeTask', HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN),
            'read',
            'step_by_step_control_sub_pages_menu',
            array(&$this, 'render')
        );
    }

    public function render()
    {
        // TODO: Implement render() method.
        _e("Hello this page Pages", HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN);
    }

    public static function newInstance()
    {
        // TODO: Implement newInstance() method.
        $instance = new self;
        return $instance;
    }
}
