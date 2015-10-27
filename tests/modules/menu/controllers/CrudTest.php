<?php
/**
 * @namespace
 */
namespace Application\Tests\Menu;

use Application\Tests\ControllerTestCase;
use Bluz\Request\AbstractRequest;
use Bluz\Http;
use Bluz\Proxy\Db;
use Bluz\Proxy\Response;


/***
 * Class CrudTest
 * @package Application\Tests\Menu
 */

class CrudTest extends ControllerTestCase
{

    protected $uri = '/menu/crud';


    protected $validData = array(
        'title'       => 'tenderloins',
        'description' => 'meet',
        'categoryId'  => 17,
        'cost'     => 34.2
    );


    protected $invalidFields = array(
        'title' => '',
        'description' => '',
        'categoryId' => 'text',
        'cost' => 'text'
    );


    /**
     * setUp
     *
     * @return void
     */

    public function setUp()
    {
        parent::setUp();
        $this->getApp()->useLayout(false);
        $this->setupSuperUserIdentity();
    }


    /**
     * GET request should return FORM for create record
     */

    public function testCreateForm()
    {
        $this->dispatchRouter($this->uri, null);
        $this->assertOk();
        $this->assertQueryCount('form[method="POST"]', 1);
    }


    /**
     *  GET request with ID record should return FORM for edit
     */

    public function testEditForm()
    {
        $this->dispatchRouter($this->uri, ['id' => 5]);
        $this->assertOk();

        $this->assertQueryCount('form[method="PUT"]', 1);
        $this->assertQueryCount('input[name="id"][value="5"]', 1);
    }


    /**
     * GET request with wrong ID record should return ERROR 404
     */

    public function testEditFormError()
    {
        $this->dispatchRouter($this->uri, ['id' => 100042]);
        $this->assertResponseCode(404);
    }


    /**
     * POST request should create a dish
     */

    public function testCreateDish()
    {
        //delete dish with valid data

        if ($this->getTestDish()) {
            $this->deleteTestDish();
        }

        $this->dispatchUri($this->uri, $this->validData,
            Http\Request::METHOD_POST);
        $this->assertOk();
        //if dish exist return true
        $this->assertTrue((bool)$this->getTestDish());
        $this->deleteTestDish();
    }


    /**
     *POST request with wrong params
     * */

    public function testCreateWrongDish()
    {
        foreach ($this->invalidFields as $key => $param) {

            //create params with one invalid field
            $params = array_replace($this->validData, [$key => $param]);
            $this->dispatchUri($this->uri, $params, Http\Request::METHOD_POST);
            $this->assertOk();
            $this->assertNotNull(Response::getBody()->errors);

        }
    }


    /**
     * POST request should create a dish
     */

    public function testEditDish()
    {

        $dishID = $this->createTestDish();
        $params = array_replace($this->validData, ['id' => $dishID]);

        $this->dispatchUri($this->uri, $params, Http\Request::METHOD_PUT);
        $this->assertOk();
    }


    /**
     * wrong PUT request
     */

    public function testWrongCrudPut()
    {
        $this->dispatchRouter('/menu/crud/', null, AbstractRequest::METHOD_PUT);
        $this->assertResponseCode(404);
    }


    /**
     * wrong DELETE request
     */
    public function testWrongCrudDelete()
    {
        $this->dispatchRouter('/menu/crud/', null,
            AbstractRequest::METHOD_DELETE);
        $this->assertResponseCode(404);
    }


    /**
     *  DELETE request
     */

    public function testCrudDelete()
    {
        //create dish (if not exist)
        if (!$dishId = $this->getTestDish()) {
            $dishId = $this->createTestDish();
        }

        $this->dispatchRouter('/menu/crud/', ['id' => $dishId],
            AbstractRequest::METHOD_DELETE);
        $this->assertOk();
    }


    /**
     * get exist dish from table
     */

    private function getTestDish()
    {
        return Db::fetchOne(
            'SELECT * FROM `dishes` WHERE `title` = ?',
            [$this->validData['title']]
        );
    }


    /**
     * delete dish
     */

    private function deleteTestDish()
    {
        Db::delete('dishes')->where('title=?',
            $this->validData['title'])->execute();
    }


    /**
     * create dish
     */
    private function createTestDish()
    {
        return Db::insert('dishes')->setArray($this->validData)->execute();
    }


}
