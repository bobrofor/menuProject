<?php


/**
 * @namespace
 */
namespace Application;

use Bluz\Proxy\Request;
use Bluz\Proxy\Session;
use Bluz\Proxy\Config;
use Bluz\Request\RequestException;


return
    /**
     * @privilege Upload
     * @return array
     */
    function () {

        $this->useJson();

        //get saved data
        $existFilesData = Session::get('files');
        $files = unserialize($existFilesData);
        //get paths to upload directory
        $path = Config::getModuleData('menu', 'full_path');
        $relativePath = Config::getModuleData('menu', 'relative_path');
        //get new file,that saved in /tmp directory
        $newFileData = Request::getFileUpload()->getFile('files');
        //validate file name
        $newFileData->createValidName($path);
        $newFileData->moveTo($path);
        //merge new and exist files data
        if ($existFilesData) {
            $fileObjects = $files;
            array_push($fileObjects, $newFileData);

        } else {
            $fileObjects = array($newFileData);
        }
        Session::set('files', serialize($fileObjects));

        $result = array();
        foreach ($fileObjects as $file) {
            $result[] = [
                'title' => $file->getName(),
                'type' => $file->getMimeType(),
                'path' => $relativePath . $file->getFullName()

            ];

        }

        return $result;
    };
