<?php
/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/skeleton
 */

/**
 * @namespace
 */
namespace Application\Menu;

use Bluz\Db\Query;
use \Bluz\Db\Relations;

/**
 * Pages Table
 *
 * @package  Application\Pages
 *
 * @method   static Row findRow($primaryKey)
 * @method   static Row findRowWhere($whereList)
 */
class Table extends \Bluz\Db\Table
{
    /**
     * Table
     * @var string
     */
    protected $table = 'dishes';

    /**
     * Primary key(s)
     * @var array
     */
    protected $primary = array('id');


    public function init()
    {

        $this->linkTo('id', 'DishesMedia', 'dishId');
        $this->linkToMany('Media', 'DishesMedia');
    }


    public function advancedSelect()
    {

        $self = static::getInstance();

        $select = new Query\Select();
        $select->select('d.id , d.title, d.description, d.cost, c.name AS category')
            ->from('dishes', 'd')
            ->join('d', 'categories', 'c', 'd.categoryId = c.id')
            ->setFetchType($self->rowClass);

        return $select;

    }
}
