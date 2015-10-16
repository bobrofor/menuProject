<?php
/**
 * CRUD for menu
 *
 */
namespace Application;

use Application\Menu;
use Bluz\Controller;
use Bluz\Db\Exception\RelationNotFoundException;
use Bluz\Proxy\Request;


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

        $view->foodCategories = $foodCategories['children'];

        if (Request::isGet()) {
            try {
                $view->unusedMedia = DishesMedia\Table::getUnusedMedia();
                $view->media = $output['row']->getRelations('Media');
            } catch (RelationNotFoundException $e) {
                $view->media = array();
            }
        }


        return $output;
    };
