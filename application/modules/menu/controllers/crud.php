<?php
/**
 * CRUD for menu
 *
 */
namespace Application;

use Application\Menu;
use Bluz\Controller;
use Bluz\Db\Exception\RelationNotFoundException;
use Bluz\Proxy\Config;
use Bluz\Proxy\Layout;
use Bluz\Proxy\Request;
use Bluz\Proxy\Session;


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

                $filesArray = unserialize(Session::get('files'));
                $path = Config::getModuleData('menu', 'full_path');

                if ($filesArray) {
                    foreach ($filesArray as $file) {
                        $filename = $path . $file->getFullName();

                        if (is_file($filename)) {
                            unlink($filename);
                        }
                    }
                }
                Session::delete('files');
                $view->unusedMedia = DishesMedia\Table::getUnusedMedia();
                $view->media = $output['row']->getRelations('Media');
            } catch (RelationNotFoundException $e) {
                $view->media = array();
            }
        }


        return $output;
    };
