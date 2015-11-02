<?php
/**
 * Created by PhpStorm.
 * User: bobrov
 * Date: 28.10.15
 * Time: 13:19
 */

/**
 * @namespace
 */
namespace Application;
use Bluz\Controller;
use Application\Menu;
use Bluz\Proxy\Request;
use Bluz\Proxy\Config;
use Bluz\Proxy\Session;
/**
 *@SWG\Resource(resourcePath="/upload")
 * @SWG\API(
 *  path = "/api/upload/",
 *  @SWG\Operation(
 *      method = "POST",
 *      nickname = "Upload image",
 *      summary = "Upload images",
 *      @SWG\Parameter(
 *          name = "files",
 *          paramType = "form",
 *          consumes = "multipart/form-data",
 *          description = "Upload images",
 *          required = true,
 *          type="File"
 *      ),
 *      @SWG\ResponseMessage(code=400, message="Invalid file type"),
 *      @SWG\ResponseMessage(code=200, message="File was uploaded")
 *  )
 * )
 */
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
