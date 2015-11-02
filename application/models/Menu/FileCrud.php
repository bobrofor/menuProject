<?php
/**
 * Created by PhpStorm.
 * User: bobrov
 * Date: 28.10.15
 * Time: 16:56
 */

/**
 * @namespace
 */
namespace Application\Menu;

use Bluz\Proxy\Request;
use Bluz\Proxy\Session;
use Bluz\Proxy\Config;
use Application\DishesMedia;
use Application\Media;
use Files\Manager;


class FileCrud extends \Bluz\Crud\Table
{


    /**
     * @param array $data
     * @return array|mixed
     * @throws \Bluz\Request\RequestException
     */

    protected $primary = 'title';


    /***
     * @return array
     */

    public function createOne()
    {

        //get saved data
        $existFilesData = Session::get('files');
        $files = unserialize($existFilesData);
        //get paths to upload directory
        $path = Config::getModuleData('menu', 'full_path');
        $relativePath = Config::getModuleData('menu', 'relative_path');


        //get new file,that saved in /tmp directory
        $newFileData = Request::getFileUpload()->getFile('files');

        $editor = new Manager($newFileData, $path);
        //validate file name
        $editor->renameFileName();
        //merge new and exist files data
        if ($existFilesData) {
            $fileObjects = $files;

            $fileObjects[uniqid()] = $editor->getFile();

        } else {
            $fileObjects = [uniqid() => $editor->getFile()];
        }
        Session::set('files', serialize($fileObjects));

        $file = $editor->getFile();
        return array(
            'id' => array_search($editor->getFile(), $fileObjects),
            'path' => $relativePath . $file->getName() . '.' . $file->getExtension()
        );

    }


    /***
     * @param mixed $primary
     */

    public function deleteOne($primary)
    {

        //get saved data
        $existFilesData = Session::get('files');
        $files = unserialize($existFilesData);
        $fileId = reset($primary);
        $file = $files[$fileId];
        if (is_file(PATH_PUBLIC . '/uploads/menu/' . $file->getName() . '.' . $file->getExtension())) {
            @unlink(PATH_PUBLIC . '/uploads/menu/' . $file->getName() . '.' . $file->getExtension());
        }
        unset($files[$fileId]);
        Session::set('files', serialize($files));

    }


}