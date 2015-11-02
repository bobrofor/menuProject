<?php


/**
 * @namespace
 */
namespace Application;


use Application\Menu;
use Bluz\Controller;


return
    /**
     * @privilege Upload
     * @return array
     */
    function () {

        $this->useJson();
        $crudController = new Controller\Crud();
        $crudController->setCrud(Menu\FileCrud::getInstance());
        $fileObjects = $crudController();

        return $fileObjects;
    };
