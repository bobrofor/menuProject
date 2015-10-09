<?php


namespace Application;

use Bluz\Proxy\Messages;


return
    /**
     * @accept HTML
     * @accept JSON
     * @privilege Management
     * @return \closure
     */
    function ($dishId, $mediaId) use ($view) {
        $this->useJson();

        $dishId = Menu\Table::findRow($dishId);
        $mediaId = Media\Table::findRow($mediaId);

        if (!$dishId || $mediaId) {
            Messages::addError('Invalid dishId or mediaId');
            $this->redirectTo('menu', 'grid');
            return false;
        }

        $dishesMediaRow = new DishesMedia\Row();
        $dishesMediaRow->dishId = $dishId;
        $dishesMediaRow->userId = $mediaId;
        $dishesMediaRow->save();
        Messages::addSuccess(
            'Media file has been successfully added'

        );
        $this->redirectTo('menu', 'grid');
    };