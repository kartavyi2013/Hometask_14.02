<?php

namespace includes\common;

use includes\controllers\admin\menu\HomeTaskMainAdminMenuController;
use includes\controllers\admin\menu\HomeTaskMainAdminSubMenuController;
use includes\controllers\admin\menu\HomeTaskMyCommentsMenuController;
use includes\controllers\admin\menu\HomeTaskMyDashboardMenuController;
use includes\controllers\admin\menu\HomeTaskMyMediaMenuController;
use includes\controllers\admin\menu\HomeTaskMyOptionsMenuController;
use includes\controllers\admin\menu\HomeTaskMyPagesMenuController;
use includes\controllers\admin\menu\HomeTaskMyPluginsMenuController;
use includes\controllers\admin\menu\HomeTaskMyPostsMenuController;
use includes\controllers\admin\menu\HomeTaskMyThemeMenuController;
use includes\controllers\admin\menu\HomeTaskMyToolsMenuController;
use includes\controllers\admin\menu\HomeTaskMyUsersMenuController;


class HometaskLoader
{
    private static $instance = null;

    private function __construct(){
        // is_admin() Условный тег. Срабатывает когда показывается админ панель сайта (консоль или любая
        // другая страница админки).
        // Проверяем в админке мы или нет
        if ( is_admin() ) {
            // Когда в админке вызываем метод admin()
            $this->admin();
        } else {
            // Когда на сайте вызываем метод site()
            $this->site();
        }
        $this->all();


    }

    public static function getInstance(){
        if ( null == self::$instance ) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Метод будет срабатывать когда вы находитесь в Админ панеле. Загрузка классов для Админ панели
     */
    public function admin(){
        HomeTaskMainAdminMenuController::newInstance();
        HomeTaskMainAdminSubMenuController::newInstance();
        HomeTaskMyDashboardMenuController::newInstance();
        HomeTaskMyPostsMenuController::newInstance();
        HomeTaskMyMediaMenuController::newInstance();
        HomeTaskMyPagesMenuController::newInstance();
        HomeTaskMyCommentsMenuController::newInstance();
        HomeTaskMyThemeMenuController::newInstance();
        HomeTaskMyPluginsMenuController::newInstance();
        HomeTaskMyUsersMenuController::newInstance();
        HomeTaskMyToolsMenuController::newInstance();
        HomeTaskMyOptionsMenuController::newInstance();

    }

    /**
     * Метод будет срабатывать когда вы находитесь Сайте. Загрузка классов для Сайта
     */
    public function site(){

    }

    /**
     * Метод будет срабатывать везде. Загрузка классов для Админ панеле и Сайта
     */
    public function all(){
        HomeTaskLocalization::getInstance();
        HomeTaskLoaderScript::getInstance();

    }
}
