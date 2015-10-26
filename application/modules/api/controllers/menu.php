<?php
/**
 * Example of REST controller
 *
 * @category Application
 *
 */
namespace Application;

use Bluz\Controller;
use Application\Menu;

/**
 * @SWG\Resource(resourcePath="/menu")
 * @SWG\Api(
 *   path="/api/menu/{id}",
 *   @SWG\Operation(
 *      method="GET", nickname="getDishById",  type="array", items="$ref:Menu",
 *      summary="Find dish by ID",
 *      notes="Returns a dish model",
 *      @SWG\Parameter(
 *          name="id",
 *          description="ID of dish that needs to be fetched",
 *          paramType="path",
 *          required=true,
 *          allowMultiple=false,
 *          type="integer"
 *      ),
 *      @SWG\ResponseMessage(code=200, message="Given dish found", responseModel="$ref:Menu"),
 *      @SWG\ResponseMessage(code=404, message="Dish not found", responseModel="ErrorModel")
 *   )
 * )
 *
 *
 * @SWG\Api(
 *   path="/api/menu",
 *   @SWG\Operation(
 *      method="GET", nickname="getDishes", type="array", items="$ref:Menu",
 *      summary="Collection of items",
 *      notes="Returns a collection, partial",
 *      @SWG\Parameter(
 *          name="offset",
 *          description="Query offset",
 *          paramType="query",
 *          required=false,
 *          allowMultiple=false,
 *          type="integer"
 *      ),
 *      @SWG\Parameter(
 *          name="limit",
 *          description="Query limit",
 *          paramType="query",
 *          required=false,
 *          allowMultiple=false,
 *          type="integer"
 *      ),
 *      @SWG\ResponseMessage(code=206, message="Collection of dishes present")
 *   )
 * )
 *
 * @SWG\Api(
 *   path="/api/menu",
 *   @SWG\Operation(
 *      method="POST", nickname="create",
 *      summary="Create Dish",
 *      @SWG\Parameter(
 *          name="categoryId",
 *          description="categoryId",
 *          paramType="form",
 *          required=true,
 *          allowMultiple=false,
 *          type="integer"
 *      ),
 *      @SWG\Parameter(
 *          name="cost",
 *          description="cost",
 *          paramType="form",
 *          required=true,
 *          allowMultiple=false,
 *          type="integer"
 *      ),
 *       @SWG\Parameter(
 *          name="description",
 *          description="description",
 *          paramType="form",
 *          required=true,
 *          allowMultiple=false,
 *          type="string"
 *      ),
 *      @SWG\Parameter(
 *          name="title",
 *          description="title",
 *          paramType="form",
 *          required=true,
 *          allowMultiple=false,
 *          type="string"
 *      ),
 *      @SWG\ResponseMessage(code=201, message="Item created, will return Location of created item"),
 *      @SWG\ResponseMessage(code=400, message="Validation errors")
 *   )
 * )
 **
 * @SWG\Api(
 *   path="/api/menu/{id}",
 *   @SWG\Operation(
 *      method="PUT", nickname="create",
 *      summary="Create Dish",
 *  @SWG\Parameter(
 *          name="id",
 *          description="ID of dish that needs to be updated",
 *          paramType="path",
 *          required=true,
 *          allowMultiple=false,
 *          type="integer"
 *      ),
 *      @SWG\Parameter(
 *          name="categoryId",
 *          description="categoryId",
 *          paramType="form",
 *          required=true,
 *          allowMultiple=false,
 *          type="integer"
 *      ),
 *      @SWG\Parameter(
 *          name="cost",
 *          description="cost",
 *          paramType="form",
 *          required=true,
 *          allowMultiple=false,
 *          type="integer"
 *      ),
 *       @SWG\Parameter(
 *          name="description",
 *          description="description",
 *          paramType="form",
 *          required=true,
 *          allowMultiple=false,
 *          type="string"
 *      ),
 *      @SWG\Parameter(
 *          name="title",
 *          description="title",
 *          paramType="form",
 *          required=true,
 *          allowMultiple=false,
 *          type="string"
 *      ),
 *     @SWG\ResponseMessage(code=200, message="Dish updated"),
 *      @SWG\ResponseMessage(code=304, message="Not modified"),
 *      @SWG\ResponseMessage(code=400, message="Validation errors"),
 *      @SWG\ResponseMessage(code=404, message="Item not found")
 *   )
 * )
 *
 *
 * @SWG\Api(
 *   path="/api/menu/{id}",
 *   @SWG\Operation(
 *      method="DELETE", nickname="deleteItem",
 *      summary="Delete Item",
 *      @SWG\Parameter(
 *          name="id",
 *          description="ID of item dish needs to be removed",
 *          paramType="path",
 *          required=true,
 *          allowMultiple=false,
 *          type="integer"
 *      ),
 *      @SWG\ResponseMessage(code=204, message="Dish removed"),
 *      @SWG\ResponseMessage(code=404, message="Dish not found")
 *   )
 * )
 *
 *
 *
 *
 */
/**
 * @accept HTML
 * @accept JSON
 * @accept XML
 * @privilege Management
 * @return mixed
 */
return

    function () {

        $restController = new Controller\Rest();
        $restController->setCrud(Menu\Crud::getInstance());

        return $restController();

    };
