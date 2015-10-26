<?php
/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/skeleton
 */

/**
 * @namespace
 */
namespace Application\Menu;

use Bluz\Proxy\Session;
use Application\Media;
use Application\DishesMedia;
use Application\Exception;
use Bluz\Proxy\Config;
use Bluz\Proxy\Db;
use Bluz\Proxy\Request;
use Bluz\Proxy\Response;

class Crud extends \Bluz\Crud\Table
{
    /**
     * @param mixed $primary
     * @param array $data
     * @return int
     * @throws Exception
     * @throws \Bluz\Application\Exception\NotFoundException
     */
    public function updateOne($primary, $data)
    {

        $this->saveAdditionData($data);
        return parent::updateOne($primary, $data);
    }


    /**
     * @param array $data
     * @throws Exception
     */
    public function createOne($data)
    {
        $id = parent::createOne($data);
        $this->saveAdditionData($data);
        return $id;
    }

    /**
     * @throws Exception
     */
    private function saveAdditionData($data)
    {
        $files = Session::get('files');
        if ($files) {

            $filesArray = unserialize($files);
            $media = Media\Crud::getInstance();

            $media->setUploadDir(Config::getModuleData('menu', 'full_path'));
            $dishesMedia = DishesMedia\Table::getInstance();

            foreach ($filesArray as $file) {

                $mediaId = $media->createExistOne($file);

                $dishesMediaArray = array(
                    'dishId' => $data['id'],
                    'mediaId' => reset($mediaId)
                );

                $row = $dishesMedia::create($dishesMediaArray);
                $row->setFromArray($dishesMediaArray);
                $row->save();

            }
        }
        Session::delete('files');
    }


    /**
     * {@inheritdoc}
     *
     * @param int $offset
     * @param int $limit
     * @param array $params
     * @return array|int|mixed
     */
    public function readSet($offset = 0, $limit = 10, $params = array())
    {
        $select = Db::select('*')
            ->from('dishes', 'd');

        if ($limit) {
            $selectPart = $select->getQueryPart('select');
            $selectPart = 'SQL_CALC_FOUND_ROWS ' . current($selectPart);
            $select->select($selectPart);

            $select->setLimit($limit);
            $select->setOffset($offset);
        }

        $result = $select->execute('\\Application\\Menu\\Row');

        if ($limit) {
            $total = Db::fetchOne('SELECT FOUND_ROWS()');
        } else {
            $total = sizeof($result);
        }

        if (sizeof($result) < $total && Request::METHOD_GET == Request::getMethod()) {
            Response::setStatusCode(206);
            Response::setHeader(
                'Content-Range',
                'items '.$offset.'-'.($offset+sizeof($result)).'/'. $total
            );
        }

        return $result;
    }

}
