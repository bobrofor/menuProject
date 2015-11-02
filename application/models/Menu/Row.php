<?php
/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/skeleton
 */

/**
 * @namespace
 */
namespace Application\Menu;

use Application\Users;
use Bluz\Validator\Traits\Validator;
use Bluz\Validator\Validator as v;
use Application\DishesMedia;

/**
 * Class Row
 * @package Application\Menu
 */
class Row extends \Bluz\Db\Row
{
    use Validator;

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function beforeSave()
    {
        // title validator
        $this->addValidator(
            'title',
            v::required(),
            v::length(2, 128)
        );

        //description validator
        $this->addValidator(
            'description',
            v::required(),
            v::length(2, 250),
            v::string());

        //category validator
        $this->addValidator(
            'categoryId',
            v::required(),
            v::integer()
        );


        //cost validator
        $this->addValidator(
            'cost',
            v::required(),
            v::float(),
            v::min(0.01, true)
        );

    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function beforeInsert()
    {
        $this->created = gmdate('Y-m-d H:i:s');
    }

    /**
     * {@inheritdoc}
     *
     * @return void
     */
    public function beforeUpdate()
    {
        $this->updated = gmdate('Y-m-d H:i:s');
    }

    protected function afterDelete()
    {
        DishesMedia\Table::delete(['mediaId' => $this->id]);
    }

}
