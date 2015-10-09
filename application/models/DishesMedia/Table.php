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

use Bluz\Db\Query;
use Bluz\Proxy\Db;


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

    public function getMediaByDishId($dishId)
    {

        $select = "select m.* from media m join dishes_media dm on m.id=dm.mediaId where dm.dishId= $dishId";

        return Db::fetchAll($select);

    }

    public function getUnusedMedia()
    {
        $select = "select m.* from media m where id NOT IN (SELECT mediaId FROM dishes_media)";

        return Db::fetchAll($select);
    }
}
