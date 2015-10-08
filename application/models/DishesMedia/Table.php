<?php
/**
 * Created by PhpStorm.
 * User: bobrov
 * Date: 08.10.15
 * Time: 15:32
 */

/**
* @namespace
*/
namespace Application\DishesMedia;



class Table extends \Bluz\Db\Table
{
    /**
     * Table
     *
     * @var string
     */
    protected $table = 'dishes_media';

    /**
     * Primary key(s)
     * @var array
     */
    protected $primary = array('dishId', 'mediaId');

    /**
     * init
     *
     * @return void
     */
    public function init()
    {
        $this->linkTo('dishId', 'Dishes', 'id');
        $this->linkTo('mediaId', 'Media', 'id');
    }
}
