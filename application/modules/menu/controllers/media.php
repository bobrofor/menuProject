<?php


namespace Application;

use Bluz\Proxy\Messages;
use Bluz\Proxy\Request;
use Application\Menu;
use Bluz\Db\Exception\RelationNotFoundException;
use Bluz\Proxy\Layout;
use Bluz\Proxy\Session;


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

    };
