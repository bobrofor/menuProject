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
    function ($mediaId) {
        $this->useJson();

        /**
         * @var Users\Row $user
         */
        $dishesMediaRow=DishesMedia\Table::findRowWhere(['mediaId' => $mediaId]);

        if (!$dishesMediaRow) {
            Messages::addError('Invalid mediaID in dishes_media table');
            $this->redirectTo('menu', 'grid');
            return false;
        }


        $dishesMediaRow->delete();
        Messages::addSuccess(
            'Media has been successfully unactivated'
        );
        $this->redirectTo('menu', 'grid');// remove old code


    };