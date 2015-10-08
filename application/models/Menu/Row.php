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

/**
 * Pages Row
 *
 * @package  Application\Pages
 *
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property string $content
 * @property string $keywords
 * @property string $description
 * @property string $created
 * @property string $updated
 * @property integer $userId
 *
 * @SWG\Model(id="Pages")
 * @SWG\Property(name="id", type="integer")
 * @SWG\Property(name="title", type="string", required=true)
 * @SWG\Property(name="alias", type="string", required=true)
 * @SWG\Property(name="content", type="string", required=true)
 * @SWG\Property(name="keywords", type="string", description="Meta keywords")
 * @SWG\Property(name="description", type="string", description="Meta description")
 * @SWG\Property(name="created", type="string", format="date-time")
 * @SWG\Property(name="updated", type="string", format="date-time")
 * @SWG\Property(name="userId", type="integer")
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
}
