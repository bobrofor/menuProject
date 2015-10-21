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


}
