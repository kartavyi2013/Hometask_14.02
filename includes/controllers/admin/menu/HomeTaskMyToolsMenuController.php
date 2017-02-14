<?php


namespace includes\controllers\admin\menu;


class HomeTaskMyToolsMenuController extends HomeTaskBaseAdminMenuController
{
    public function action()
    {
        // TODO: Implement action() method.

        $pluginPage = add_management_page(
            __('Sub tools HomeTask', HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN),
            __('Sub tools HomeTask', HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN),
            'read',
            'step_by_step_control_sub_tools_menu',
            array(&$this, 'render')
        );
    }

    public function render()
    {
        // TODO: Implement render() method.
        _e("Hello this page Tools", HOMETASKSHORTCODE_PlUGIN_TEXTDOMAIN);
    }

    public static function newInstance()
    {
        // TODO: Implement newInstance() method.
        $instance = new self;
        return $instance;
    }
}
