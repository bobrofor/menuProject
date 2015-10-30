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

        $editor=new Manager($newFileData,$path);
        //validate file name
        $editor->renameFileName();
        //merge new and exist files data
        if ($existFilesData) {
            $fileObjects = $files;
            array_push($fileObjects,$editor->getFile());

        } else {
            $fileObjects = array($editor->getFile());
        }
        Session::set('files', serialize($fileObjects));

        return array('id'=> array_search($editor->getFile(),$fileObjects),
            'path'=>$relativePath . $editor->getFile()->getName());

    }


    /**
     * @param mixed $primary
     */

    public function updateOne()
    {

    }



    public function deleteOne($primary)
    {
        //get saved data
        $existFilesData = Session::get('files');
        $files = unserialize($existFilesData);

        $file=$files[reset($primary)];
        if (is_file(PATH_PUBLIC .'/uploads/menu/'.$file->getName().'.'.$file->getExtension() )) {
            @unlink(PATH_PUBLIC .'/uploads/menu/'.$file->getName().'.'.$file->getExtension());
        }
        if (is_file(PATH_PUBLIC .'/uploads/menu/'.$file->getName().'.'.$file->getExtension())) {
            @unlink(PATH_PUBLIC .'/uploads/menu/'.$file->getName().'.'.$file->getExtension() );
        }


        $result=array();

        foreach($files as $key=>$file)
        {
            if($key!=reset($primary))
            {
                $result[$key]=$file;
            }

        }
        Session::set('files', serialize($result));

    }


}