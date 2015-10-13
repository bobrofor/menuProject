<?php


namespace Application;

use Bluz\Proxy\Messages;
use Bluz\Proxy\Request;
use Application\Menu;
use Bluz\Db\Exception\RelationNotFoundException;


return
    /**
     * @privilege Management
     *
     * @accept HTML
     * @accept JSON
     * @param int $id
     * @return void
     */
    function ($dishId) use ($view) {


        $dish = Menu\Table::findRow($dishId);

        if (Request::isGet()) {
            try {
                $view->unusedMedia = DishesMedia\Table::getUnusedMedia();
                //media for current dish
                $view->dishMedia = $dish->getRelations('Media');
            } catch (RelationNotFoundException $e) {
                $view->dishMedia = array();
            }
        }


        if (Request::isPost()) {

            $media = Request::getParam('media');
            $dishId = Request::getParam('dishId');

            $dmTable = DishesMedia\Table::getInstance();
            $dmTable::delete(['dishId' => $dishId]);

            foreach ($media as $image) {

                $dmTable::insert(array(
                    'dishId' => $dishId,
                    'mediaId' => $image
                ));

            }
            $view->dish = $dish;

            Messages::addSuccess('Dishes media was updated');
            return false;

        }

        $view->dish = $dish;
    };
