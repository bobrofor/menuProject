<?php
/**
 * Upload media content to server
 *
 * @author   Anton Shevchuk
 * @created  06.02.13 18:16
 */

/**
 * @namespace
 */
namespace Application;

use Application\Menu\UploadHandler;
use Bluz\Proxy\Config;
use Bluz\Proxy\Request;


return
    /**
     * @privilege Upload
     * @return array
     */
    function () {
        $uploadDir = Config::getModuleData('media', 'upload_path');

        $options = array(
            'upload_dir' => $uploadDir . '/' . $this->user()->id . '/media/',
            'upload_url' => 'http://menu.prj/uploads/'. $this->user()->id . '/media/');

        $uphandler = new UploadHandler($options);
        $files=$uphandler->get_response();
        if(!empty($files) && is_array($files))
        {

            foreach($files as $file)
            {

            }

        }
    };
