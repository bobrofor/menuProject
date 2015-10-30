<?php
/**
 * Created by PhpStorm.
 * User: bobrov
 * Date: 28.10.15
 * Time: 13:19
 */

/**
 * @namespace
 */
namespace Application;
use Bluz\Controller;
use Application\Menu;
use Bluz\Proxy\Request;
use Bluz\Proxy\Config;
use Bluz\Proxy\Session;
/**
 *@SWG\Resource(resourcePath="/upload")
 * @SWG\API(
 *  path = "/api/upload/",
 *  @SWG\Operation(
 *      method = "POST",
 *      nickname = "Upload image",
 *      summary = "Upload images",
 *      @SWG\Parameter(
 *          name = "files",
 *          paramType = "form",
 *          consumes = "multipart/form-data",
 *          description = "Upload images",
 *          required = true,
 *          type="File"
 *      ),
 *      @SWG\ResponseMessage(code=400, message="Invalid file type"),
 *      @SWG\ResponseMessage(code=200, message="File was uploaded")
 *  )
 * )
 */
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
        $fileName = strtolower( $newFileData->getName());
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
        while (file_exists($path  . $fileName . '.' . $newFileData->getExtension())) {
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
