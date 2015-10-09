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
//        $output = $crudController();

        $view->foodCategories = $foodCategories['children'];

//        $updateMode = !is_array($output);
//        $createMode = empty($output['row']->id);

       // if (!$updateMode && !$createMode) {

//        $view->media = $output['row']->getRelations('Media');
//        die();

       // }

        /*$dishtable = DishesMedia\Table::getInstance();

        $condition = is_array($output) && !empty($output['row']->id);


        if ($condition) {
            $media = $dishtable->getMediaByDishId($output['row']->id);
            $view->media = $media;
        }


        $unusedMedia = $dishtable->getUnusedMedia();
        $view->unusedMedia = $unusedMedia;
*/
        return $crudController();
    };
