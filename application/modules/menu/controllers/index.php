<?php



namespace Application;
/**
 * @privilege Management
 * @return void
 */
use Bluz\Proxy\Layout;

return
    /**
     * @return \closure
     */
    function () use ($view, $module, $controller){

        Layout::title('Menu Module');
        Layout::title('Append', Layout::POS_APPEND);
        Layout::title('Prepend', Layout::POS_PREPEND);
        Layout::headStyle($view->baseUrl('css/categories.css'));

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

    };
