<?php
/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/skeleton
 */

/**
 * @namespace
 */
namespace Application\Menu;

use Bluz\Db\Query\Select;
use Bluz\Grid\Source\SelectSource;

/**
 * Grid of Pages
 *
 * @package  Application\Pages
 */
class Grid extends \Bluz\Grid\Grid
{
    /**
     * @var string
     */
    protected $uid = 'dishes';

    /**
     * init
     *
     * @return self
     */
    public function init()
    {


        $table = Table::getInstance();
        $adapter = new SelectSource();
        $adapter->setSource($table->advancedSelect());
        $this->setAdapter($adapter);
        $this->setDefaultLimit(25);
        $this->setAllowOrders(['title', 'id', 'cost', 'categoryId']);
        $this->setAllowFilters(['title', 'description', 'categoryId', 'id']);
        return $this;
    }


}
