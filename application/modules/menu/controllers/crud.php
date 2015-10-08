<?php
/**
 * CRUD for menu
 *
 */
namespace Application;

use Application\Menu;
use Bluz\Controller;

return
    /**
     * @accept HTML
     * @accept JSON
     * @privilege Management
     * @return mixed
     */
    function () use ($view) {
        /**
         * @var Bootstrap $this
         */
        $categoriesTable = Categories\Table::getInstance();
        $foodTree = $categoriesTable->buildTreeByAlias('food');
        $foodCategories = reset($foodTree);
        $crudController = new Controller\Crud();
        $crudController->setCrud(Menu\Crud::getInstance());
        $output = $crudController();

        $output['row']->getRelations('Media');

var_dump($output['row']->row);

        //var_dump($qwerty);
        //$view->media =$qwerty;
        $view->foodCategories = $foodCategories['children'];

        //$output['foodCategories'] = $foodCategories['children'];


        return $output;
    };
