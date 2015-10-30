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
        'id' => '',
        'title' => 'tenderloins',
        'description' => 'meet',
        'categoryId' => 17,
        'cost' => 34.2
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
     * tearDown
     *
     */

    public function tearDown()
    {
        parent::tearDown();
        $this->deleteTestDish();

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
        $this->createTestDish();
        $id=$this->getTestDish();
        $this->dispatchRouter($this->uri, ['id' => $id]);
        $this->assertOk();
        $this->assertQueryCount('form[method="PUT"]', 1);
    }


    /**
     * POST request should create a dish
     */

    public function testCreateDish()
    {

        //delete dish with valid data
        $this->dispatchUri($this->uri, $this->validData,
            Http\Request::METHOD_POST);
        $this->assertOk();

        //if dish exist return true
        $this->assertTrue((bool)$this->getTestDish());
    }


    /**
     * POST request should create a dish
     */

    public function testCreateDishWithoutPrivileges()
    {
        $this->setupGuestIdentity();
        //delete dish with valid data
        $this->dispatchUri($this->uri, $this->validData,
            Http\Request::METHOD_POST);
        $this->assertResponseCode(403);

    }



    /**
     * POST request should create a dish
     */

    public function testEditDishWithoutPrivileges()
    {
        $this->setupGuestIdentity();
        $dishID = $this->createTestDish();
        $params = array_replace($this->validData, ['id' => $dishID]);
        $this->dispatchUri($this->uri, $params, Http\Request::METHOD_PUT);
        $this->assertResponseCode(403);

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
     *  DELETE request
     */

    public function testCrudDelete()
    {
        $dishId = $this->createTestDish();

        $this->dispatchRouter('/menu/crud/', ['id' => $dishId],
            AbstractRequest::METHOD_DELETE);
        $this->assertOk();
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
