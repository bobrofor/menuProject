<?php

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

        try {

            Db::handler()->beginTransaction();
            $this->saveAdditionData($data);
            $response = parent::updateOne($primary, $data);
            //Db::delete('wertwert')->where(['ee' => 3333])->execute();

            Db::handler()->commit();
            return $response;

        } catch (\PDOException $e) {

            Db::handler()->rollBack();
            throw $e;
        }
    }


    /**
     * @param array $data
     * @throws Exception
     */
    public function createOne($data)
    {
        try {

            Db::handler()->beginTransaction();
            $data['id'] = reset(parent::createOne($data));

            $this->saveAdditionData($data);


            Db::handler()->commit();

            return $data['id'];

        } catch (\PDOException $e) {

            Db::handler()->rollBack();
            throw $e;
        }

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
     * @param int   $offset
     * @param int   $limit
     * @param array $params
     * @return array|int|mixed
     */
    public function readSet($offset = 0, $limit = 10, $params = array())
    {

        $select = $this->getTable()->select();


        if ($limit) {
            $selectPart = $select->getQueryPart('select');
            $selectPart = 'SQL_CALC_FOUND_ROWS ' . current($selectPart);
            $select->select($selectPart)
                ->setLimit($limit)
                ->setOffset($offset);
        }

        $result = $select->execute();

        if ($limit) {
            $total = Db::fetchOne('SELECT FOUND_ROWS()');
        } else {
            $total = sizeof($result);
        }

        if (sizeof($result) < $total && Request::METHOD_GET == Request::getMethod()) {
            Response::setStatusCode(206);
            Response::setHeader(
                'Content-Range',
                'items ' . $offset . '-' . ($offset + sizeof($result)) . '/' . $total
            );
        }

        return $result;
    }


    /***
     * @param mixed $primary
     * @return \Bluz\Db\Row
     * @throws \Bluz\Application\Exception\NotFoundException
     */
    public function readOne($primary)
    {
        $filesArray = unserialize(Session::get('files'));
        $path = Config::getModuleData('menu', 'full_path');

        if ($filesArray) {
            foreach ($filesArray as $file) {
                $filename = $path . $file->getFullName();

                if (is_file($filename)) {
                    unlink($filename);
                }
            }
        }
        Session::delete('files');

        return parent::readOne($primary);

    }

}
