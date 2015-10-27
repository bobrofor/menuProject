<?php


/**
 * @namespace
 */
namespace Application;

use Bluz\Proxy\Request;
use Bluz\Proxy\Session;
use Bluz\Proxy\Config;


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
        $fileName = strtolower(isset($data['title']) ? $data['title'] : $newFileData->getName());

        // Prepare filename
        $fileName = preg_replace('/[ _;:]+/i', '-', $fileName);
        $fileName = preg_replace('/[-]+/i', '-', $fileName);
        $fileName = preg_replace('/[^a-z0-9.-]+/i', '', $fileName);

        // If name is wrong
        if (empty($fileName)) {
            $fileName = date('Y-m-d-His');
        }

        // If file already exists, increment name
        $originFileName = $fileName;
        $counter = 0;

        while (file_exists($this->uploadDir . '/' . $fileName . '.' . $newFileData->getExtension())) {
            $counter++;
            $fileName = $originFileName . '-' . $counter;
        }

        // Setup new name and move to user directory
        $newFileData->setName($fileName);
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
