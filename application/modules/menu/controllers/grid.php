<?php
/**
 * Grid of pages
 *
 * @author   Anton Shevchuk
 * @created  27.08.12 10:08
 */
namespace Application;

use Bluz\Proxy\Layout;

return
    /**
     * @privilege Management
     * @return void
     */
    function ($categoryID = null) use ($view, $module, $controller) {
        /**
         * @var Bootstrap $this
         * @var \Bluz\View\View $view
         */
        Layout::setTemplate('dashboard.phtml');
        Layout::breadCrumbs(
            [
                $view->ahref('Dashboard', ['dashboard', 'index']),
                __('Menu')
            ]
        );

        $grid = new Menu\Grid();
        $grid->setModule($module);
        $grid->setController($controller);
        $view->grid = $grid;
        $categoriesTable = Categories\Table::getInstance();
        $foodTree = $categoriesTable->buildTreeByAlias('food');
        $view->categories = reset($foodTree);

    };
